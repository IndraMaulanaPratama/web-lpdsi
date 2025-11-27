<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Sambutan;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin')]
class SambutanCrud extends Component
{
    use WithFileUploads;

    public $sambutans, $judul, $sambutan, $foto, $sambutanId;
    public $isModalOpen = false;
    public $sambutanModel;

    protected $listeners = ['refreshTable' => '$refresh'];

    protected function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'sambutan' => 'required',
            'foto' => $this->sambutanId
                ? 'required|image|mimes:jpg,jpeg,png|max:2048'
                : 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    protected $validationAttributes = [
        'judul' => 'Judul Sambutan',
        'sambutan' => 'Konten Sambutan',
        'foto' => 'Foto Sambutan'
    ];

    protected $messages = [
        'judul.required' => 'Judul wajib diisi',
        'foto.required' => 'Foto wajib diisi',
        'judul.max' => 'Judul maksimal 255 karakter.',
        'sambutan.required' => 'Konten sambutan wajib diisi',
        'foto.image' => 'File harus berupa gambar',
        'foto.mimes' => 'Format foto harus JPG/JPEG/PNG',
        'foto.max' => 'Ukuran foto maksimal 2MB',
    ];

    public function mount()
    {
        $this->resetInput();
    }

    public function render()
    {
        $this->sambutans = Sambutan::latest()->get();
        return view('livewire.admin.page.sambutan-crud');
    }

    public function openModal()
    {
        $this->resetInput();
        $this->dispatch('resetEditor');
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInput();
        $this->dispatch('resetEditor');
    }

    public function resetInput()
    {
        $this->judul = '';
        $this->sambutan = '';
        $this->foto = '';
        $this->sambutanId = null;
        $this->sambutanModel = null;
    }

    public function store()
    {
        $this->validate();

        $path = $this->foto
            ? $this->foto->store('sambutan', 'public')
            : ($this->sambutanModel->foto ?? null);

        Sambutan::updateOrCreate(
            ['id' => $this->sambutanId],
            [
                'judul' => $this->judul,
                'konten' => $this->sambutan,
                'foto' => $path,
            ]
        );

        $this->dispatch('notify', type: 'success', message: $this->sambutanId ? 'Data diperbarui!' : 'Data ditambahkan!');

        $this->closeModal();
        $this->dispatch('$refresh');
    }

    public function delete($id)
    {
        Sambutan::find($id)?->delete();

        $this->dispatch('notify', type: 'success', message: 'Data berhasil dihapus!');
        $this->dispatch('$refresh');
    }



    public function edit($id)
    {
        $sambutan = Sambutan::findOrFail($id);

        $this->sambutanId = $id;
        $this->judul = $sambutan->judul;
        $this->sambutan = $sambutan->konten;
        $this->sambutanModel = $sambutan;

        $this->isModalOpen = true;
        $this->dispatch('setEditorContent', $this->sambutan);
    }

}
