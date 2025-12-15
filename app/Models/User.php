<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'divisi_id',

        // Tambihan kanggo google auth
        'google_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected $with = ['roles', 'divisi'];



    // Relasi kana table role
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }


    // Relasi kana table custom_user_menu
    public function customMenus()
    {
        return $this->belongsToMany(Menu::class, 'custom_user_menu')
            ->withPivot('permissions')
            ->withTimestamps();
    }


    // Relasi ke tabel divisi (kepala pusat)
    public function divisi()
    {
        return $this->belongsTo(divisi::class);
    }


    // Relasi kana table log
    public function logs()
    {
        return $this->hasMany(Log::class);
    }


    // Method untuk mendapatkan semua permissions user
    public function getAllPermissions()
    {
        $permissions = [];

        // Permissions dari role
        foreach ($this->roles as $role) {
            foreach ($role->menus as $menu) {
                if (!empty($menu->pivot->permissions)) {
                    $permissions[$menu->id] = array_merge(
                        $permissions[$menu->id] ?? [],
                        $menu->pivot->permissions
                    );
                }
            }
        }

        // Custom permissions
        foreach ($this->customMenus as $menu) {
            if (!empty($menu->pivot->permissions)) {
                $permissions[$menu->id] = array_merge(
                    $permissions[$menu->id] ?? [],
                    $menu->pivot->permissions
                );
            }
        }

        return $permissions;
    }



    /*** ------------------- Ranah na accessor ------------------- ***/

    /** Accessor ieu dianggo upami tos aya kondisi 1 user kagungan langkung ti 1 role */
    // public function getListRoleAttribute()
    // {
    //     return $this->roles->pluck('name')->toArray();
    // }

    // nyandak namu role anu nuju dianggo
    public function getNamaRoleAttribute()
    {
        return $this->roles->first()->description ?? null;
    }

    // nyandak nami divisi
    public function getNamaDivisiAttribute()
    {
        return $this->divisi->description ?? null;
    }
    /*** ------------------- Tungtung tina Ranah na accessor ------------------- ***/
}
