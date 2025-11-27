<?php

namespace App\Livewire\Admin\Page;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\VisiMisi;

#[Layout('layouts.admin')]
class VisimisiCrud extends Component
{
    public $showForm = true; // langsung tampil form
    public $isEdit = false;
    public $editId;
    public $visi;
    public $misi;

    protected $rules = [
        'visi' => 'required|string',
        'misi' => 'required|string',
    ];

    // 🔹 Otomatis jalan saat komponen pertama kali dimuat
    public function mount()
    {
        $data = VisiMisi::first();

        if ($data) {
            // kalau sudah ada data → langsung tampil di form mode edit
            $this->editId = $data->id;
            $this->visi = $data->visi;
            $this->misi = $data->misi;
            $this->isEdit = true;
        } else {
            // kalau belum ada data → tampil form kosong untuk tambah
            $this->isEdit = false;
            $this->visi = '';
            $this->misi = '';
        }

        $this->showForm = true; // form selalu tampil
        $this->dispatch('initEditor'); // aktifkan CKEditor
    }

    public function render()
    {
        return view('livewire.admin.page.visimisi-crud');
    }

    // 🔹 Simpan data baru
    public function store()
    {
        $this->validate();

        $data = VisiMisi::create([
            'visi' => $this->visi,
            'misi' => $this->misi,
        ]);

        session()->flash('success', 'Data berhasil ditambahkan');

        // langsung ubah ke mode edit
        $this->editId = $data->id;
        $this->isEdit = true;
        $this->visi = $data->visi;
        $this->misi = $data->misi;

        $this->dispatch('initEditor');
    }

    // 🔹 Simpan perubahan
    public function update()
    {
        $this->validate();

        $data = VisiMisi::findOrFail($this->editId);
        $data->update([
            'visi' => $this->visi,
            'misi' => $this->misi,
        ]);

        session()->flash('success', 'Data berhasil diperbarui');

        // tetap di mode edit
        $this->isEdit = true;
        $this->dispatch('initEditor');
    }

    // 🔹 Hapus data
    public function delete()
    {
        if ($this->editId) {
            VisiMisi::findOrFail($this->editId)->delete();
        }

        session()->flash('success', 'Data berhasil dihapus');

        // reset form jadi kosong (mode create lagi)
        $this->reset(['visi', 'misi', 'editId', 'isEdit']);
        $this->isEdit = false;
        $this->dispatch('initEditor');
    }
}
