<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['event_id', 'image', 'video_url', 'slug'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

