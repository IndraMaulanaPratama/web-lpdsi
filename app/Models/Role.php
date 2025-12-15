<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "description"
    ];

    protected $with = ['menus'];

    // Relasi kana table user
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_menus')
            ->withPivot('permissions')
            ->withTimestamps();
    }

}

