<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'menu_id',
        'permissions'
    ];

    protected $with = ['role', 'menu'];

    // Relasi kana table role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi kana table menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
