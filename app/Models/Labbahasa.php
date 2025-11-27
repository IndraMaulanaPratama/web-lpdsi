<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labbahasa extends Model
{
    use HasFactory;

    protected $table = 'lab_bahasa';
    protected $fillable = [
        'judul',
        'deskripsi',
        'tugas',
    ];
}
