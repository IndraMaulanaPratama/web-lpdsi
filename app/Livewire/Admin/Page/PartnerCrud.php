<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.admin')]
class PartnerCrud extends Component
{
    use WithFileUploads;

    public $logo;
    public $type = 'domestic'; // default
    public $showModal = false; // untuk kontrol popup modal

    // 🔹 Tambahkan pesan error yang rapi
    protected $validationAttributes = [
        'logo' => 'Logo Mitra',
        'type' => 'Jenis Mitra',
    ];

    protected $messages = [
        'logo.required' => ':attribute wajib diunggah.',
        'logo.image' => ':attribute harus berupa gambar yang valid.',
        'logo.mimes' => 'Format :attribute harus JPG, JPEG, atau PNG.',
        'logo.max' => 'Ukuran :attribute maksimal 2MB.',
        'type.required' => ':attribute wajib dipilih.',
        'type.in' => ':attribute tidak valid.',
    ];
    // ------------------------------------

    protected $rules = [
        'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'type' => 'required|in:domestic,foreign',
    ];
    
    // 🔹 updatedLogo untuk validasi real-time saat file dipilih
    public function updatedLogo()
    {
        $this->validateOnly('logo');
    }

    public function save()
    {
        $this->validate();

        $path = $this->logo->store('partners', 'public');

        Partner::create([
            'logo' => $path,
            'type' => $this->type,
        ]);

        $message = 'Logo berhasil ditambahkan!';
        
        // Reset form + tutup modal, seperti pola savePhoto
        $this->reset(['logo', 'type', 'showModal']);
        $this->type = 'domestic';

        // 💡 Menggunakan dispatch untuk refresh tampilan (agar real-time) dan notifikasi
        $this->dispatch('$refresh'); 
        $this->dispatch('notify', type: 'success', message: $message);
        
        // Opsional: session flash bisa dihapus jika Anda hanya mengandalkan notify
        session()->flash('success', $message);
    }

    public function delete($id)
    {
        $partner = Partner::findOrFail($id);

        if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        $message = 'Logo berhasil dihapus!';
        
        // 💡 Menggunakan dispatch untuk refresh tampilan (agar real-time) dan notifikasi, seperti pola deleteYear
        $this->dispatch('$refresh'); 
        $this->dispatch('notify', type: 'success', message: $message);

        // Opsional: session flash bisa dihapus jika Anda hanya mengandalkan notify
        session()->flash('success', $message);
    }

    public function render()
    {
        // 💡 Pastikan metode ini mengambil data terbaru dari database
        return view('livewire.admin.page.partner-crud', [
            'mitraDalam' => Partner::where('type', 'domestic')->get(),
            'mitraLuar'  => Partner::where('type', 'foreign')->get(),
        ]);
    }
}