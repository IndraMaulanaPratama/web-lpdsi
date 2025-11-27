<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class divisi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "description"
    ];


    // Relasi ke tabel user
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
