<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    protected $with = ['user', 'role'];

    // Relasi kana table user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi kana table role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
