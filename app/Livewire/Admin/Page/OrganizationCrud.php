<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Organization; 
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On; 

#[Layout('layouts.admin')]
class OrganizationCrud extends Component
{
    use WithFileUploads;

    public $structures;
    public $title;
    public $image;
    public $imagePreview;
    public $showForm = false;
    public $isEdit = false;
    public $editingId = null;

    // 1. Tambahkan Pesan Error dan Atribut Validasi yang Jelas (Mengadopsi gaya AgendaCrud)
    protected $validationAttributes = [
        'title' => 'Judul',
        'image' => 'Gambar',
    ];

    protected $messages = [
        'title.required' => ':attribute wajib diisi.',
        'title.max' => ':attribute maksimal 255 karakter.',
        'image.required' => ':attribute wajib diunggah.',
        'image.image' => ':attribute harus berupa file gambar yang valid.', // Pesan tambahan untuk aturan 'image'
        'image.mimes' => 'Format :attribute harus JPG, JPEG, atau PNG.',
        'image.max' => 'Ukuran :attribute maksimal 2MB.',
    ];
    
    // 2. Ganti static $rules menjadi dynamic rules()
    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            // Aturan dinamis: nullable saat edit, required saat create.
            // Menggunakan 'image' dan 'mimes' sesuai contoh AgendaCrud
            'image' => $this->isEdit
                ? 'nullable|image|max:2048|mimes:jpg,jpeg,png' 
                : 'required|image|max:2048|mimes:jpg,jpeg,png',
        ];
    }

    public function mount()
    {
        $this->loadStructures();
    }
    
    public function updatedImage()
    {
        // Panggil validasi gambar real-time menggunakan rules() yang dinamis
        $this->validateOnly('image'); 
    }

    #[On('refreshTable')] 
    public function loadStructures()
    {
        $this->structures = Organization::latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.page.organization-crud');
    }
    
    // ----------------------------------------------------
    // Fungsi Manajemen Form
    // ----------------------------------------------------
    
    public function closeForm()
    {
        $this->reset(['title', 'image', 'imagePreview', 'editingId', 'isEdit']);
        $this->resetValidation();
        $this->showForm = false; 
    }

    public function openCreateForm()
    {
        $this->closeForm(); 
        $this->showForm = true; 
        $this->isEdit = false; 
    }

    // ----------------------------------------------------
    // CRUD Logic
    // ----------------------------------------------------

    public function store()
    {
        // Panggil validate() tanpa argumen, Livewire akan menggunakan rules() yang dinamis
        $this->validate(); 

        $path = $this->image->storeAs(
            'organization_structures', 
            uniqid() . '.' . $this->image->getClientOriginalExtension(), 
            'public'
        );

        Organization::create([
            'title' => $this->title,
            'image' => $path,
        ]);

        $this->dispatch('alert', type: 'success', message: 'Struktur organisasi berhasil ditambahkan.');
        
        $this->closeForm();
        $this->dispatch('refreshTable'); 
    }

    public function edit($id)
    {
        $org = Organization::findOrFail($id);
        $this->editingId = $id;
        $this->title = $org->title;
        $this->image = null; 
        $this->imagePreview = $org->image ? asset('storage/'.$org->image) : null;
        $this->isEdit = true;
        $this->showForm = true;
        $this->resetValidation();
    }

    public function update()
    {
        // Panggil validate() tanpa argumen, Livewire akan menggunakan rules() yang dinamis
        $this->validate(); 

        $org = Organization::findOrFail($this->editingId);

        if ($this->image) {
            // Hapus gambar lama
            if ($org->image && Storage::disk('public')->exists($org->image)) {
                Storage::disk('public')->delete($org->image);
            }
            // Simpan gambar baru
            $path = $this->image->storeAs(
                'organization_structures', 
                uniqid() . '.' . $this->image->getClientOriginalExtension(), 
                'public'
            );
            $org->image = $path;
        }

        $org->title = $this->title;
        $org->save();

        $this->dispatch('alert', type: 'success', message: 'Struktur organisasi berhasil diupdate.');
        
        $this->closeForm();
        $this->dispatch('refreshTable'); 
    }

    public function delete($id)
    {
        $structure = Organization::findOrFail($id);
        
        if ($structure->image && Storage::disk('public')->exists($structure->image)) {
            Storage::disk('public')->delete($structure->image);
        }

        $structure->delete();

        $this->dispatch('alert', type: 'success', message: 'Struktur organisasi berhasil dihapus.');
        $this->dispatch('refreshTable');
    }
}