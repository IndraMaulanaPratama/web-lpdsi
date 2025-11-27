<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategorySop extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_name',
        'category_description'
    ];

    protected $with = ['sops'];

    // Relasi ke tabel SOP
    public function sops()
    {
        return $this->hasMany(Sop::class, 'category_sop_id');
    }
}
