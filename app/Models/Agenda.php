<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas'; // nama tabel

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'lokasi',
        'gambar',
    ];
}
