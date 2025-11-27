<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labkomputer extends Model
{
    protected $table = 'lab_komputer';
    protected $fillable = ['judul', 'deskripsi', 'tugas'];

    protected $casts = [
        'tugas' => 'array', // jika tugas disimpan dalam JSON
    ];
}
