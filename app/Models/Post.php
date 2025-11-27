<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'isi',
        'gambar',
        'penulis',
        'tanggal',
    ];

    protected $with = ['user'];

    // Relasi kana table user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
