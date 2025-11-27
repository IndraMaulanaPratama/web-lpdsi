<?php

namespace App\Livewire\Admin\Page;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.admin')]
class Profile extends Component
{
    use WithFileUploads;

    public $name, $email, $avatar, $password, $password_confirmation;
    public $avatarPreview;

    public function mount()
    {
        $user = auth()->user();
        $this->name  = $user->name;
        $this->email = $user->email;
        $this->avatarPreview = $user->avatar ? asset('storage/' . $user->avatar) : null;
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:2048',
        ]);

        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function save()
    {
        $user = auth()->user();

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$user->id}",
            'password' => 'nullable|confirmed|min:8',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Upload avatar
        if ($this->avatar) {
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                \Storage::disk('public')->delete($user->avatar);
            }

            $path = $this->avatar->store('avatars', 'public');
            $validated['avatar'] = $path;
        } else {
            unset($validated['avatar']);
        }

        // Hash password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        session()->flash('message', 'Profil berhasil diperbarui.');

        $this->reset('password', 'password_confirmation');
    }

    public function render()
    {
        return view('livewire.admin.page.profile')->layout('layouts.admin');
    }
}