<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labpemerintahan extends Model
{
    protected $table = 'lab_pemerintahan';
    protected $fillable = ['judul', 'deskripsi', 'tugas'];

    protected $casts = [
        'tugas' => 'array', // jika tugas disimpan dalam JSON
    ];
}
