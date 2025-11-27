<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Panduan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'divisi_id',
        'judul',
        'slug',
        'penulis',
        'isi',
        'category_panduan_id',
        'likes_count',
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    // Biar otomatis bikin slug dari judul
    protected static function booted()
    {
        static::creating(function ($panduan) {
            $panduan->slug = Str::slug($panduan->judul);
        });
    }

    public function category()
    {
        return $this->belongsTo(CategoryPanduan::class, 'category_panduan_id');
    }
    public function categoryPanduan()
    {
        return $this->belongsTo(CategoryPanduan::class, 'category_panduan_id');
    }
    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function likes()
    {
        return $this->hasMany(Komentar::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->attributes['likes_count'] ?? 0;
    }

}
