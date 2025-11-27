<?php

namespace App\Livewire\Admin\Page;

use App\Models\Labpemerintahan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class LabPemerintahanCrud extends Component
{
    use WithPagination;

    public $labId;
    public $judul;
    public $deskripsi;
    public $tugas;
    public $search = '';
    public $sort = 'latest';
    public $showForm = false;
    public $isCollapseOpen = false;


    protected $rules = [
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tugas' => 'nullable|string',
    ];

    public function render()
    {
        $query = LabPemerintahan::query();

        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        $query->when($this->sort === 'asc', fn($q) => $q->orderBy('judul', 'asc'))
              ->when($this->sort === 'desc', fn($q) => $q->orderBy('judul', 'desc'))
              ->when($this->sort === 'latest', fn($q) => $q->latest());

        return view('livewire.admin.page.lab-pemerintahan-crud', [
            'labs' => $query->paginate(5)
        ]);
    }

    public function store()
    {
        $this->validate();

        LabPemerintahan::updateOrCreate(
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
            'message' => 'Data Lab Pemerintahan berhasil disimpan.'
        ]);

        $this->resetForm();
        $this->showForm = false;
        $this->isCollapseOpen = false;

    }

    public function edit($id)
    {
        $lab = LabPemerintahan::findOrFail($id);

        $this->labId = $lab->id;
        $this->judul = $lab->judul;
        $this->deskripsi = $lab->deskripsi;
        $this->tugas = $lab->tugas;
        $this->showForm = true;
        $this->isCollapseOpen = true;
    }

    public function delete($id)
    {
        LabPemerintahan::findOrFail($id)->delete();

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['labId', 'judul', 'deskripsi', 'tugas']);
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetForm();
        }
    }
}
