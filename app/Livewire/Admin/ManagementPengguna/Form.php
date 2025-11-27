<?php

namespace App\Livewire\Admin\ManagementPengguna;

use App\Models\divisi;
use App\Models\User;
use Livewire\Component;

class Form extends Component
{
    public $inputName, $inputEmail, $inputPassword, $inputDivisi;
    public $divisi;


    public function store()
    {

        try {

            $this->validate([
                'inputName' => ['required', 'string', 'max:255'],
                'inputEmail' => ['required', 'email', 'unique:users,email'],
                'inputPassword' => ['required', 'min:8'],
                'inputDivisi' => ['required', 'exists:divisis,id'],
            ]);

            $data = [
                'name' => $this->inputName,
                'email' => $this->inputEmail,
                'password' => bcrypt($this->inputPassword),
                'divisi_id' => $this->inputDivisi,
            ];

            User::create($data);

            // Show success alert
            session()->flash('alert', [
                'type' => 'success',
                'title' => 'Berhasil!',
                'message' => 'Data pengguna berhasil ditambahkan.',
                'dismissible' => true,
                'timeout' => 5000
            ]);

            $this->reset(['inputName', 'inputEmail', 'inputPassword', 'inputDivisi']);

        } catch (\Throwable $th) {

            // Show Error alert
            session()->flash('alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'message' => $th->getMessage(),
                'dismissible' => true,
                'timeout' => 5000
            ]);
        }
    }


    public function mount()
    {
        $divisi = divisi::get(['id', 'description']);
        $this->divisi = $divisi->pluck('description', 'id')->toArray();
    }


    public function render()
    {
        return view('livewire.admin.management-pengguna.form', [
            'divisi' => $this->divisi,
        ]);
    }
}
