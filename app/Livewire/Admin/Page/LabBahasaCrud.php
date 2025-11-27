<?php

namespace App\Livewire\Admin\Page;

use App\Models\LabBahasa;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class LabBahasaCrud extends Component
{
    use WithPagination;

    public $labId;
    public $judul;
    public $deskripsi;
    public $tugas;
    public $search = '';
    public $sort = 'latest';

    public $showForm = false; // Sudah benar
    protected $rules = [
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tugas' => 'nullable|string',
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }

    public function render()
    {
        $query = LabBahasa::query()
            ->when($this->search, fn($q) =>
                $q->where('judul', 'like', '%' . $this->search . '%')
            )
            ->when($this->sort === 'asc', fn($q) => $q->orderBy('judul', 'asc'))
            ->when($this->sort === 'desc', fn($q) => $q->orderBy('judul', 'desc'))
            ->when($this->sort === 'latest', fn($q) => $q->latest());

        return view('livewire.admin.page.lab-bahasa-crud', [
            'labs' => $query->paginate(5)
        ]);
    }

    // Menghapus openForm() dan mengandalkan tombol @click="openModal = true" di Blade
    // public function openForm()
    // {
    //     $this->resetForm();
    //     $this->dispatch('open-modal');
    // }

    public function store()
    {
        $this->validate();

        LabBahasa::updateOrCreate(
            ['id' => $this->labId],
            [
                'judul' => $this->judul,
                'deskripsi' => $this->deskripsi,
                'tugas' => $this->tugas,
            ]
        );

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Data laboratorium berhasil disimpan.'
        ]);

        $this->resetForm();
        
        // Menggunakan mekanisme dispatch (seperti Lab Komputer)
        $this->showForm = false; 
        $this->dispatch('closeModal'); 
        $this->dispatch('refreshTable');
    }

    public function edit($id)
    {
        $lab = LabBahasa::findOrFail($id);

        $this->labId = $lab->id;
        $this->judul = $lab->judul;
        $this->deskripsi = $lab->deskripsi;
        $this->tugas = $lab->tugas;
        
        // Mengubah dispatch('open-modal') menjadi set properti showForm
        $this->showForm = true; 
    }

    public function delete($id)
    {
        LabBahasa::findOrFail($id)->delete();

        // Memastikan refreshTable dipanggil setelah delete
        $this->dispatch('refreshTable');

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['labId', 'judul', 'deskripsi', 'tugas']);
        $this->resetValidation();
    }
}