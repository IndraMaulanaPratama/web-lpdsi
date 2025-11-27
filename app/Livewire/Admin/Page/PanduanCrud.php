<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use App\Models\Panduan;
use App\Models\Divisi;
use App\Models\CategoryPanduan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class PanduanCrud extends Component
{
    use WithPagination;

    // 🧩 Properti untuk form
    public $judul;
    public $penulis = 'Admin';
    public $isiArtikel;
    public $divisi_id;
    public $category_panduan_id;
    public $panduan_id;

    // 🧩 Properti kontrol UI
    public $isEdit = false;
    public $showForm = false;
    public $search = '';

    // 🧩 Aturan validasi
    protected $rules = [
        'judul' => 'required|string|max:255',
        'penulis' => 'required|string|max:100',
        'isiArtikel' => 'required|string',
        'divisi_id' => 'required|exists:divisis,id',
        'category_panduan_id' => 'required|exists:category_panduans,id',
    ];

    protected $messages = [
        'judul.required' => 'Judul panduan wajib diisi.',
        'penulis.required' => 'Penulis wajib diisi.',
        'isiArtikel.required' => 'Isi artikel tidak boleh kosong.',
        'divisi_id.required' => 'Divisi harus dipilih.',
        'category_panduan_id.required' => 'Kategori panduan harus dipilih.',
    ];

    // 🧩 Render tampilan utama
    public function render()
    {
        $panduans = Panduan::with(['divisi', 'category'])
            ->where('judul', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.page.panduan-crud', [
            'panduans' => $panduans,
            'divisis' => Divisi::all(),
            'categories' => CategoryPanduan::all(),
        ]);
    }

    // 🧩 Reset semua field form
    public function resetForm()
    {
        $this->reset([
            'judul',
            'penulis',
            'isiArtikel',
            'divisi_id',
            'category_panduan_id',
            'panduan_id',
            'isEdit',
        ]);

        $this->penulis = 'Admin'; // biar balik default
    }

    // 🧩 Simpan data baru
    public function store()
    {
        $this->validate();
        
        Panduan::create([
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul),
            'penulis' => $this->penulis,
            'isi' => $this->isiArtikel,
            'divisi_id' => $this->divisi_id,
            'category_panduan_id' => $this->category_panduan_id,
        ]);

        session()->flash('success', 'Panduan berhasil ditambahkan.');

        $this->resetForm();
        $this->showForm = false;

        // 🔥 Tambahkan ini:
        $this->dispatch('close-modal');
        $this->resetPage();
    }

    // 🧩 Ambil data untuk edit
    public function edit($id)
    {
        $panduan = Panduan::findOrFail($id);

        $this->panduan_id = $panduan->id;
        $this->judul = $panduan->judul;
        $this->penulis = $panduan->penulis;
        $this->isiArtikel = $panduan->isi;
        $this->divisi_id = $panduan->divisi_id;
        $this->category_panduan_id = $panduan->category_panduan_id;

        $this->isEdit = true;
        $this->showForm = true;

        // 🔥 Tambah ini supaya TinyMCE isi ulang konten
        $this->dispatch('edit-mode');
    }

    // 🧩 Update data
    public function update()
    {
        $this->validate();

        $panduan = Panduan::findOrFail($this->panduan_id);

        $panduan->update([
            'judul' => $this->judul,
            'slug' => Str::slug($this->judul),
            'penulis' => $this->penulis,
            'isi' => $this->isiArtikel,
            'divisi_id' => $this->divisi_id,
            'category_panduan_id' => $this->category_panduan_id,
        ]);

        session()->flash('success', 'Panduan berhasil diperbarui.');

        $this->resetForm();
        $this->showForm = false;

        // 🔥 Tambahkan ini juga:
        $this->dispatch('close-modal');
        $this->resetPage();
    }
    // 🧩 Hapus data
    public function delete($id)
    {
        $panduan = Panduan::findOrFail($id);
        $panduan->delete();

        session()->flash('success', 'Panduan berhasil dihapus.');
        $this->resetPage();
    }
}
