<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    #[Layout('layouts.login')]

    public function login()
    {
        $credentials = $this->validate();

        if (Auth::attempt($credentials, $this->remember)) {
            $user = User::where('email', $this->email)->first();
            $role = $user->roles->first();
            $menus = $role->menus;

            session()->put('menus', $menus);
            session()->put('role', $role);
            session()->put('divisi', $user->divisi->description);
            session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        } else {
            $this->password = null;
            session()->flash('warning', 'Data pengguna tidak ditemukan');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
