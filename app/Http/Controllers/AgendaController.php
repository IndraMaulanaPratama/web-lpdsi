<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('pages.agenda-detail', compact('agenda'));
    }
}
