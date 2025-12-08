<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Sop extends Model
{
    use HasFactory;

    protected $table = 'sops';
    protected $fillable = [
        'category_sop_id',
        'divisi_id',
        'sop_name',
        'sop_description',
        'sop_status',
        'sop_file'
    ];

    // sementara
    protected $with = [];

    // Relasi ke tabel CategorySop
    public function categorySop()
    {
        return $this->belongsTo(CategorySop::class, 'category_sop_id');
    }

    public function category()
    {
        return $this->belongsTo(CategorySop::class, 'category_sop_id');
    }

    // Relasi ke tabel Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }
}
