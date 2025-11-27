<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Year;
use App\Models\Event;
use App\Models\Photo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin')]
class GalleryCrud extends Component
{
    use WithFileUploads;

    public $step = 0;

    // Tahun
    public $year;
    public $editYearId = null;

    // Event
    public $eventName;
    public $eventYearId;
    public $editEventId = null;

    // Foto / Video
    public $photoTitle;
    public $photoEventId;
    public $photoImage;
    public $mediaType = 'image';
    public $youtubeUrl;
    public $editPhotoId = null;

    public function render()
    {
        return view('livewire.admin.page.gallery-crud', [
            'years'  => Year::orderBy('year', 'desc')->get(),
            'events' => Event::with('year')->orderBy('name')->get(),
            'photos' => Photo::with('event')->latest()->get(),
        ]);
    }

    public function nextStep($step) { $this->step = $step; }
    public function backStep($step) { $this->step = $step; }

    // ---------------------------
    // YEAR CRUD
    // ---------------------------
    public function saveYear()
    {
        $this->validate(['year' => 'required|numeric|digits:4']);

        Year::updateOrCreate(
            ['id' => $this->editYearId],
            ['year' => $this->year]
        );

        $message = $this->editYearId ? 'Tahun diperbarui.' : 'Tahun ditambahkan.';
        session()->flash('success', $message);

        $this->reset(['year', 'editYearId']);
        $this->step = 0;

        $this->dispatch('notify', type: 'success', message: $message);
        $this->dispatch('close-modals');
    }

    public function editYear($id)
    {
        $year = Year::findOrFail($id);
        $this->editYearId = $year->id;
        $this->year = $year->year;
        $this->step = 1;
    }

    public function deleteYear($id)
    {
        Year::findOrFail($id)->delete();

        $message = 'Tahun dihapus.';
        session()->flash('success', $message);

        $this->dispatch('notify', type: 'success', message: $message);
    }

    // ---------------------------
    // EVENT CRUD
    // ---------------------------
    public function saveEvent()
    {
        $this->validate([
            'eventName'   => 'required|string',
            'eventYearId' => 'required|exists:years,id',
        ]);

        $slug = Str::slug($this->eventName);

        Event::updateOrCreate(
            ['id' => $this->editEventId],
            [
                'name'    => $this->eventName,
                'year_id' => $this->eventYearId,
                'slug'    => $slug,
            ]
        );

        $message = $this->editEventId ? 'Event diperbarui.' : 'Event ditambahkan.';
        session()->flash('success', $message);

        $this->reset(['eventName', 'eventYearId', 'editEventId']);
        $this->step = 0;

        $this->dispatch('notify', type: 'success', message: $message);
        $this->dispatch('close-modals');
    }

    public function editEvent($id)
    {
        $event = Event::findOrFail($id);
        $this->editEventId = $event->id;
        $this->eventName = $event->name;
        $this->eventYearId = $event->year_id;
        $this->step = 2;
    }

    public function deleteEvent($id)
    {
        Event::findOrFail($id)->delete();

        $message = 'Event dihapus.';
        session()->flash('success', $message);

        $this->dispatch('notify', type: 'success', message: $message);
    }



    // ---------------------------
    // PHOTO & VIDEO CRUD
    // ---------------------------
    public function savePhoto()
    {
        $this->validate([
            'photoEventId' => 'required|exists:events,id',
            'photoImage'   => 'nullable|image|max:4096',
            'youtubeUrl'   => 'nullable|url',
        ]);

        // Harus salah satu diisi
        if (!$this->photoImage && !$this->youtubeUrl) {
            $this->addError('media', 'Harap unggah foto atau masukkan link YouTube.');
            return;
        }

        $photo = $this->editPhotoId ? Photo::find($this->editPhotoId) : new Photo();

        if ($photo->image && $this->photoImage) {
            Storage::disk('public')->delete($photo->image);
        }

        // Simpan gambar jika ada
        $path = $this->photoImage
            ? $this->photoImage->storeAs('gallery', uniqid() . '.' . $this->photoImage->getClientOriginalExtension(), 'public')
            : $photo->image;

        // Convert link YouTube jika ada
        $youtube = $this->youtubeUrl ? $this->convertYoutubeToEmbed($this->youtubeUrl) : null;

        $slug = $this->editPhotoId
        ? ($photo->slug ?? Str::slug('media-' . $this->photoEventId)) // Kalau edit, pakai slug lama
        : Str::slug('media-' . $this->photoEventId . '-' . uniqid());  // Saat tambah baru, buat slug baru
        
        $photo->updateOrCreate(['id' => $this->editPhotoId], [
                'title'     => $this->photoTitle,
                'event_id'  => $this->photoEventId,
                'type'      => $this->mediaType,
                'image'     => $path,
                'video_url' => $youtube,
                'slug'      => $slug,
        ]);

        $this->resetPhotoForm();
        $this->dispatch('close-modals');
        $this->dispatch('notify', type: 'success', message: 'Media disimpan!');
    }

    public function editPhoto($id)
    {
        $photo = Photo::findOrFail($id);

        $this->editPhotoId = $photo->id;
        $this->photoTitle = $photo->title;
        $this->photoEventId = $photo->event_id;
        $this->mediaType = $photo->type;
        $this->youtubeUrl = $photo->video_url;

        $this->step = 3;
    }

   public function deletePhoto($id)
    {
        $photo = Photo::findOrFail($id);
        if ($photo->image) Storage::disk('public')->delete($photo->image);
        $photo->delete();

        $message = 'Media dihapus.';
        session()->flash('success', $message);

        $this->dispatch('notify', type: 'success', message: $message);
    }


    private function resetPhotoForm()
    {
        $this->reset(['photoTitle', 'photoImage', 'photoEventId', 'mediaType', 'youtubeUrl', 'editPhotoId']);
        $this->mediaType = 'image';
    }

    private function convertYoutubeToEmbed($url)
    {
        if (preg_match('/(youtu\.be\/|v=)([^&]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[2];
        }
        return $url;
    }
}
