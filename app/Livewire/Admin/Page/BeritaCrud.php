<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Import Storage

#[Layout('layouts.admin')]
class BeritaCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $judul, $isiKonten, $gambar, $post_id, $penulis, $tanggal;
    public $isEdit = false;
    public $showForm = false;

    // Aturan validasi
    protected $rules = [
        'judul' => 'required|string|max:255',
        'isiKonten' => 'required|string',
        // Gambar tetap nullable di sini, nanti divalidasi wajib di store
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
        'penulis' => 'required|string|max:100', // Diubah menjadi 'required'
        'tanggal' => 'required|date', // Diubah menjadi 'required'
    ];
    
    
    // Pesan Error yang rapi (Custom Validation Messages)
    protected $messages = [
        'judul.required' => 'Judul wajib diisi.',
        'judul.max' => 'Judul maksimal :max karakter.',
        'isiKonten.required' => 'Konten wajib diisi.',
        'penulis.required' => 'Penulis wajib diisi.',
        'penulis.max' => 'Penulis maksimal :max karakter.',
        'tanggal.required' => 'Tanggal wajib diisi.',
        'tanggal.date' => 'Tanggal harus berupa tanggal yang valid.',
        'gambar.required' => 'Gambar wajib diunggah.', // Digunakan saat store
        'gambar.image' => 'File harus berupa gambar yang valid.',
        'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
        'gambar.max' => 'Ukuran gambar maksimal 2MB.',
    ];
    
    // Atribut Validasi yang mudah dibaca (Custom Validation Attributes)
    protected $validationAttributes = [
        'judul' => 'Judul Berita',
        'isiKonten' => 'Isi Konten',
        'gambar' => 'Gambar Berita',
        'penulis' => 'Nama Penulis',
        'tanggal' => 'Tanggal Berita',
    ];


    // Validasi gambar saat properti gambar diubah (hanya validasi gambar)
    public function updatedGambar()
    {
        $this->validateOnly('gambar');
    }

    /** ---------------------------
     * Render
     * --------------------------*/
    public function render()
    {
        // Ambil data berita terbaru dengan pagination
        $berita = Post::latest()->paginate(10);
        return view('livewire.admin.page.berita-crud', compact('berita'));
    }

    /** ---------------------------
     * Store Berita Baru
     * --------------------------*/
    public function store()
    {
        // Gabungkan aturan validasi dengan membuat gambar wajib ada saat membuat baru
        // Gambar wajib ada saat membuat baru
        $this->validate(array_merge($this->rules, [
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]));

        try {
            // Upload gambar dan simpan path
            $path = $this->gambar ? $this->gambar->store('berita', 'public') : null;

            Post::create([
                'user_id' => auth()->user()->id,
                'judul' => $this->judul,
                'isi' => $this->isiKonten,
                'gambar' => $path,
                // Menggunakan nilai dari input, karena sudah wajib
                'penulis' => $this->penulis, 
                'tanggal' => $this->tanggal,
                'slug' => Str::slug($this->judul),
            ]);

            session()->flash('success', 'Berita berhasil ditambahkan.');
            
            $this->resetForm();
            // Dispatcth event untuk refresh Livewire dan notifikasi sukses
            $this->dispatch('$refresh');
            $this->dispatch('notify', type: 'success', message: $message);

        } catch (\Throwable $th) {
            $this->dispatch('notify', type: 'error', message: 'Gagal menambah berita: ' . $th->getMessage());
        }
    }

    /** ---------------------------
     * Edit Berita
     * --------------------------*/
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $this->post_id = $post->id;
        $this->judul = $post->judul;
        $this->isiKonten = $post->isi;
        $this->penulis = $post->penulis;
        $this->tanggal = $post->tanggal ? date('Y-m-d', strtotime($post->tanggal)) : null;

        $this->gambar = null; // Reset properti gambar agar tidak divalidasi saat update
        $this->isEdit = true;
        $this->showForm = true;

        // Kirim event ke JS agar TinyMCE di-reinit
        $this->dispatch('edit-mode');
    }

    /** ---------------------------
     * Update Berita
     * --------------------------*/
    public function update()
    {
        // Saat update, gambar tetap 'nullable' dari properti $rules di atas
        $this->validate(); 

        $post = Post::findOrFail($this->post_id);

        try {
            $path = $post->gambar;
            if ($this->gambar) {
                // Hapus gambar lama jika ada gambar baru diunggah
                if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
                    Storage::disk('public')->delete($post->gambar);
                }
                $path = $this->gambar->store('berita', 'public');
            }

            $post->update([
                'judul' => $this->judul,
                'isi' => $this->isiKonten,
                'gambar' => $path,
                'penulis' => $this->penulis, // Menggunakan nilai dari input karena sudah wajib
                'tanggal' => $this->tanggal, // Menggunakan nilai dari input karena sudah wajib
                'slug' => Str::slug($this->judul),
            ]);

            $message = 'Berita berhasil diperbarui.';

            $this->resetForm();
            // Dispatcth event untuk refresh Livewire dan notifikasi sukses
            $this->dispatch('$refresh');
            $this->dispatch('notify', type: 'success', message: $message);
        } catch (\Throwable $th) {
            $this->dispatch('notify', type: 'error', message: 'Gagal memperbarui berita: ' . $th->getMessage());
        }
    }

    /** ---------------------------
     * Delete Berita
     * --------------------------*/
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        
        try {
            // Hapus file gambar dari storage
            if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
                Storage::disk('public')->delete($post->gambar);
            }
            
            $post->delete();
            
            $message = 'Berita berhasil dihapus.';

            // Dispatcth event untuk refresh Livewire dan notifikasi sukses
            $this->dispatch('$refresh');
            $this->dispatch('notify', type: 'success', message: $message);
        } catch (\Throwable $th) {
            $this->dispatch('notify', type: 'error', message: 'Gagal menghapus berita: ' . $th->getMessage());
        }
    }

    /** ---------------------------
     * Reset Form
     * --------------------------*/
    public function resetForm()
    {
        $this->reset(['judul', 'isiKonten', 'gambar', 'penulis', 'tanggal', 'post_id', 'isEdit']);
        $this->showForm = false;
        $this->dispatch('close-modal'); // Tutup modal
        $this->resetValidation(); // Hapus pesan validasi
    }

    /** ---------------------------
     * Toggle Form (Tambah)
     * --------------------------*/
    public function toggleForm()
    {
        $this->resetValidation();
        $this->resetForm(); 
        $this->isEdit = false;
        $this->showForm = true; 

        if ($this->showForm) {
            $this->dispatch('initEditor'); // Re-init TinyMCE untuk mode tambah
        }
    }
}