<?php

namespace App\Livewire\Admin\Page;

use App\Models\Pddikti;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class PddiktiCrud extends Component
{
    use WithPagination;

    public $labId;
    public $judul;
    public $deskripsi;
    public $tugas;
    public $search = '';
    public $sort = 'latest';
    public $showForm = false;

    protected $rules = [
        'judul' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'tugas' => 'nullable|string',
    ];

    public function render()
    {
        $query = Pddikti::query();

        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        $query->when($this->sort === 'asc', fn($q) => $q->orderBy('judul', 'asc'))
              ->when($this->sort === 'desc', fn($q) => $q->orderBy('judul', 'desc'))
              ->when($this->sort === 'latest', fn($q) => $q->latest());

        return view('livewire.admin.page.pddikti-crud', [
            'labs' => $query->paginate(5)
        ]);
    }

    public function store()
    {
        $this->validate();

        Pddikti::updateOrCreate(
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
            'message' => 'Data PDDIKTI berhasil disimpan.'
        ]);

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $lab = Pddikti::findOrFail($id);

        $this->labId = $lab->id;
        $this->judul = $lab->judul;
        $this->deskripsi = $lab->deskripsi;
        $this->tugas = $lab->tugas;
        $this->showForm = true;
    }

    public function delete($id)
    {
        Pddikti::findOrFail($id)->delete();

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
