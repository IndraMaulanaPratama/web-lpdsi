<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pddikti extends Model
{
    protected $table = 'lab_pddikti';
    protected $fillable = ['judul', 'deskripsi', 'tugas'];

    protected $casts = [
        'tugas' => 'array', // jika tugas disimpan dalam JSON
    ];
}
