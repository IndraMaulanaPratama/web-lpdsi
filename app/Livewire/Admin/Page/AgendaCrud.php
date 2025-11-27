<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Agenda;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin')]
class AgendaCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $judul, $tanggal, $lokasi, $deskripsi, $gambar;
    public $isEdit = false;
    public $showForm = false;
    public $agenda_id;

    // 🔹 Pesan error lebih rapih & Bahasa Indonesia
    protected $validationAttributes = [
        'judul' => 'Judul',
        'tanggal' => 'Tanggal',
        'lokasi' => 'Lokasi',
        'gambar' => 'Foto',
        'deskripsi' => 'Deskripsi',
    ];

    protected $messages = [
        'judul.required' => ' Judul wajib diisi',
        'judul.max' => ':attribute maksimal 255 karakter.',
        'tanggal.required' => 'Tanggal wajib diisi',
        'tanggal.date' => ':attribute harus berupa tanggal yang valid.',
        'lokasi.required' => 'Lokasi wajib diisi',
        'deskripsi.required' => 'Deskripsi wajib diisi',
        'lokasi.max' => ':attribute maksimal 255 karakter.',
        'gambar.required' => 'Gambar wajib diunggah.',
        'gambar.image' => ':attribute harus berupa gambar.',
        'gambar.mimes' => 'Format :attribute harus JPG/JPEG/PNG.',
        'gambar.max' => 'Ukuran :attribute maksimal 2MB.',
    ];

    // 🔹 Rules dibuat dinamis
    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            // kalau EDIT foto tidak wajib
            'gambar' => $this->isEdit
                ? 'nullable|image|max:2048|mimes:jpg,jpeg,png'
                : 'required|image|max:2048|mimes:jpg,jpeg,png',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function render()
    {
        return view('livewire.admin.page.agenda-crud', [
            'agendas' => Agenda::latest()->paginate(10),
        ]);
    }

    public function resetForm()
    {
        $this->reset(['judul', 'tanggal', 'lokasi', 'deskripsi', 'gambar', 'isEdit', 'agenda_id']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        $path = $this->gambar->store('agenda', 'public');

        Agenda::create([
            'judul' => $this->judul,
            'tanggal' => $this->tanggal,
            'lokasi' => $this->lokasi,
            'deskripsi' => $this->deskripsi,
            'gambar' => $path,
        ]);

        session()->flash('success', 'Agenda berhasil ditambahkan.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $this->agenda_id = $id;
        $this->judul = $agenda->judul;
        $this->tanggal = $agenda->tanggal;
        $this->lokasi = $agenda->lokasi;
        $this->deskripsi = $agenda->deskripsi;
        $this->gambar = null;
        $this->isEdit = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate();

        $agenda = Agenda::findOrFail($this->agenda_id);

        if ($this->gambar) {
            if ($agenda->gambar && Storage::disk('public')->exists($agenda->gambar)) {
                Storage::disk('public')->delete($agenda->gambar);
            }
            $path = $this->gambar->store('agenda', 'public');
        } else {
            $path = $agenda->gambar;
        }

        $agenda->update([
            'judul' => $this->judul,
            'tanggal' => $this->tanggal,
            'lokasi' => $this->lokasi,
            'deskripsi' => $this->deskripsi,
            'gambar' => $path,
        ]);

        session()->flash('success', 'Agenda berhasil diperbarui.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function delete($id)
    {
        $agenda = Agenda::findOrFail($id);

        if ($agenda->gambar && Storage::disk('public')->exists($agenda->gambar)) {
            Storage::disk('public')->delete($agenda->gambar);
        }

        $agenda->delete();
        session()->flash('success', 'Agenda berhasil dihapus.');
    }
}
