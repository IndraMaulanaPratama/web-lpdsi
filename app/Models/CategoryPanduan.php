<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryPanduan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_name',
        'category_description',
    ];

    /**
     * Relasi ke tabel panduans
     * Satu kategori bisa punya banyak panduan
     */
    public function panduans()
    {
        return $this->hasMany(Panduan::class, 'category_panduan_id');
    }
}
