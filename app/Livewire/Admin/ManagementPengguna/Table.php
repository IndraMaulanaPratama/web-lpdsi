<?php

namespace App\Livewire\Admin\ManagementPengguna;

use App\Models\divisi;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $filterUrutan, $filterStatus = 'all', $filterDivisi, $inputSearch;
    public $divisi;


    public function mount()
    {
        $divisi = divisi::get(['id', 'description']);
        $this->divisi = $divisi->pluck('description', 'id')->toArray();
    }


    public function render()
    {

        $users = User::when(
            // Filter berdasarkan status
            $this->filterStatus,
            function ($query, $status) {

                if ($status == "aktif") {
                    return $query->withoutTrashed();
                } elseif ($status == "non-aktif") {
                    return $query->onlyTrashed();
                } elseif ($status == "all") {
                    return $query->withTrashed();
                } else {
                    return $query->withTrashed();
                }
            }
        )
            // Filter berdasarkan divisi
            ->when(
                $this->filterDivisi,
                function ($query, $divisi) {
                    return $query->where('divisi_id', $divisi);
                }
            )
            // Sorting Data
            ->when(
                $this->filterUrutan,
                function ($query, $urutan) {
                    switch ($urutan) {
                        case 'name_asc':
                            return $query->orderBy('name', 'asc');
                        case 'name_desc':
                            return $query->orderBy('name', 'desc');
                        case 'email_asc':
                            return $query->orderBy('email', 'asc');
                        case 'email_desc':
                            return $query->orderBy('email', 'desc');
                        case 'divisi_asc':
                            return $query->orderBy('divisi_id', 'asc');
                        case 'divisi_desc':
                            return $query->orderBy('divisi_id', 'desc');
                        default:
                            return $query->orderBy('created_at', 'desc');
                    }
                }
            )
            ->when(
                $this->inputSearch,
                function ($query, $search) {
                    return $query->where("name", "LIKE", $search . "%");
                }
            )
            ->paginate(5);

        return view('livewire.admin.management-pengguna.table', [
            'users' => $users,
            'divisi' => $this->divisi,
        ]);
    }
}
