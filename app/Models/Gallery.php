<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    // izinkan mass assignment untuk kolom ini
    protected $fillable = ['title', 'image'];
}
