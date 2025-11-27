<?php

namespace App\Livewire\Admin\Page;

use App\Models\Labkomputer;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class LabKomputerCrud extends Component
{
    use WithPagination;

    public $labId;
    public $judul;
    public $deskripsi;
    public $tugas;
    public $search = '';
    public $sort = 'latest';
    public $showForm = false;

    protected $validationAttributes = [
        'judul' => 'Judul',
        'deskripsi' => 'Deskripsi',
        'tugas' => 'Tugas',
    ];

    protected $messages = [
        'judul.required' => 'Judul wajib diisi.',
        'judul.min' => 'Judul minimal :min karakter.',
        'judul.max' => 'Judul maksimal :max karakter.',

        'deskripsi.required' => 'Deskripsi wajib diisi.',
        'deskripsi.min' => 'Deskripsi minimal :min karakter.',

        'tugas.min' => 'Tugas minimal :min karakter.',
    ];

    protected function rules()
    {
        return [
            'judul' => 'required|string|min:3|max:255',
            'deskripsi' => 'required|string|min:10',
            'tugas' => 'nullable|string|min:5',
        ];
    }

    public function render()
    {
        $query = LabKomputer::query();

        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        $query->when($this->sort === 'asc', fn($q) => $q->orderBy('judul', 'asc'))
              ->when($this->sort === 'desc', fn($q) => $q->orderBy('judul', 'desc'))
              ->when($this->sort === 'latest', fn($q) => $q->latest());

        return view('livewire.admin.page.lab-komputer-crud', [
            'labs' => $query->paginate(5)
        ]);
    }

    public function store()
    {
        $this->validate();

        LabKomputer::updateOrCreate(
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
        $this->showForm = false;
    }

    public function edit($id)
    {
        $lab = LabKomputer::findOrFail($id);

        $this->labId = $lab->id;
        $this->judul = $lab->judul;
        $this->deskripsi = $lab->deskripsi;
        $this->tugas = $lab->tugas;

        $this->resetErrorBag();
        $this->showForm = true;
    }

    public function delete($id)
    {
        LabKomputer::findOrFail($id)->delete();

        session()->flash('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Data berhasil dihapus.'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['labId', 'judul', 'deskripsi', 'tugas']);
        $this->resetErrorBag();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;

        if (!$this->showForm) {
            $this->resetForm();
        }
    }
}
