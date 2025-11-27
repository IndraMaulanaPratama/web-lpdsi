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
        return $this->belongsToMany(User::class, 'USER_ROLES');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'ROLE_MENUS')
            ->withPivot('permissions')
            ->withTimestamps();
    }

}

