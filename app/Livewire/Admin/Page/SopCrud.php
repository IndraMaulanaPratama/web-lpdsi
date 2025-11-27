<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Sop;
use App\Models\Divisi;
use App\Models\CategorySop;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.admin')]
class SopCrud extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'tailwind';

    // Form Properties
    public $sop_name;
    public $sop_description;
    public $sop_status = true;
    public $sop_file;
    public $divisi_id = '';
    public $category_sop_id = '';
    
    // UI Control Properties
    public $editId;
    public $isEdit = false;
    public $showForm = false;
    public $search = '';

    // Validation Rules
    protected $rules = [
        'sop_name' => 'required|string|max:255',
        'sop_description' => 'nullable|string',
        'divisi_id' => 'required|exists:divisis,id',
        'category_sop_id' => 'required|exists:category_sops,id',
        'sop_file' => 'required|mimes:pdf|max:5120',
        'sop_status' => 'boolean',
    ];

    // Validation Messages
    protected $messages = [
        'sop_name.required' => 'Nama SOP wajib diisi.',
        'sop_name.max' => 'Nama SOP maksimal 255 karakter.',
        'divisi_id.required' => 'Divisi harus dipilih.',
        'category_sop_id.required' => 'Kategori SOP harus dipilih.',
        'sop_file.mimes' => 'File harus berformat PDF, DOC, atau DOCX.',
        'sop_file.max' => 'Ukuran file maksimal 5MB.',
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function render()
    {
        try {
            $data = Sop::with(['divisi', 'categorySop'])
                ->where('sop_name', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(10);

            return view('livewire.admin.page.sop-crud', [
                'data' => $data,
                'divisis' => Divisi::orderBy('name')->get(),
                'categories' => CategorySop::orderBy('category_name')->get(),
            ]);
        } catch (\Exception $e) {
            logger()->error('Error in SopCrud render: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return view('livewire.admin.page.sop-crud', [
                'data' => collect(),
                'divisis' => collect(),
                'categories' => collect(),
            ]);
        }
    }

    public function toggleForm()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->showForm = !$this->showForm;
    }

    public function store()
    {
        // Gunakan validasi eksplisit supaya kelihatan error-nya
        $validated = $this->validate([
            'sop_name' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisis,id',
            'category_sop_id' => 'required|exists:category_sops,id',
            'sop_status' => 'required|boolean',
            'sop_description' => 'nullable|string',
            'sop_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Coba deteksi tipe file sebelum simpan
        if ($this->sop_file) {
            \Log::debug('📄 File info:', [
                'name' => $this->sop_file->getClientOriginalName(),
                'mime' => $this->sop_file->getMimeType(),
                'ext'  => $this->sop_file->getClientOriginalExtension(),
            ]);

            try {
                $path = $this->sop_file->store('sop_files', 'public');
            } catch (\Exception $e) {
                \Log::error('❌ Gagal upload file SOP: ' . $e->getMessage());
                session()->flash('error', 'Gagal upload file: ' . $e->getMessage());
                return;
            }
        } else {
            $path = null;
        }

        $sop = Sop::create([
            'sop_name' => trim($this->sop_name),
            'sop_description' => trim($this->sop_description ?? ''),
            'sop_status' => (bool)$this->sop_status,
            'divisi_id' => $this->divisi_id,
            'category_sop_id' => $this->category_sop_id,
            'sop_file' => $path,
        ]);

        \Log::debug('✅ SOP berhasil dibuat:', ['id' => $sop->id, 'file' => $path]);

        session()->flash('success', 'SOP berhasil ditambahkan!');
        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $data = Sop::findOrFail($id);
        $this->fill([
            'sop_name' => $data->sop_name,
            'sop_description' => $data->sop_description,
            'sop_status' => $data->sop_status,
            'divisi_id' => $data->divisi_id,
            'category_sop_id' => $data->category_sop_id,
        ]);
        $this->editId = $id;
        $this->isEdit = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            
            $sop = Sop::findOrFail($this->editId);
            $path = $sop->sop_file;

            if ($this->sop_file) {
                // Delete old file if exists
                if ($sop->sop_file && Storage::disk('public')->exists($sop->sop_file)) {
                    Storage::disk('public')->delete($sop->sop_file);
                }
                // Store new file
                $path = $this->sop_file->store('sop_files', 'public');
            }

            $sop->update([
                'sop_name' => trim($this->sop_name),
                'sop_description' => trim($this->sop_description ?? ''),
                'sop_status' => (bool) $this->sop_status,
                'divisi_id' => $this->divisi_id,
                'category_sop_id' => $this->category_sop_id,
                'sop_file' => $path,
            ]);

            DB::commit();
            session()->flash('success', 'SOP berhasil diperbarui!');
            
            $this->resetForm();
            $this->showForm = false;
            $this->dispatch('close-modal');
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $sop = Sop::find($id);

        if ($sop) {
            // Hapus file-nya juga biar gak nyangkut di storage
            if ($sop->sop_file && Storage::disk('public')->exists($sop->sop_file)) {
                Storage::disk('public')->delete($sop->sop_file);
            }

            $sop->delete(); // Ini penting!
            session()->flash('success', 'SOP berhasil dihapus.');
            $this->resetPage();
        } else {
            session()->flash('error', 'Data tidak ditemukan.');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'sop_name', 'sop_description', 'sop_status',
            'divisi_id', 'category_sop_id', 'sop_file',
            'editId', 'isEdit'
        ]);
    }
    public function loadData()
    {
        // sementara kosong dulu
    }

}
