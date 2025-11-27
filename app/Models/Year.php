<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Year extends Model
{
    protected $fillable = ['year'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($year) {
            if (empty($year->slug)) {
                $year->slug = Str::slug($year->year);
            }
        });
    }

}

