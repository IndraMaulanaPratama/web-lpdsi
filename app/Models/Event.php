<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['year_id', 'name', 'slug'];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

}

