<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use App\Models\Event;
use App\Models\Photo;

class GaleriController extends Controller
{
    public function index()
    {
        $years = Year::withCount('events')
                 ->orderBy('year', 'desc') // urut dari besar ke kecil
                 ->get();

        return view('pages.galeri', [
            'level' => 'year',
            'years' => $years,
        ]);
    }

    public function showYear($year)
    {
        $year = Year::where('slug', $year)->firstOrFail();
        $events = $year->events;

        return view('pages.galeri', [
            'level'  => 'event',
            'year'   => $year,
            'events' => $events,
        ]);
    }

    public function showEvent($year, $event)
    {
        $year = Year::where('slug', $year)->firstOrFail();
        $event = Event::where('slug', $event)
                      ->where('year_id', $year->id)
                      ->firstOrFail();

        return view('pages.galeri', [
            'level'  => 'photo',
            'year'   => $year,
            'event'  => $event,
            'photos' => $event->photos,
        ]);
    }
}
