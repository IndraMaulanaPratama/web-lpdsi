<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class StrukturController extends Controller
{
    public function index()
    {
        $structure = Organization::latest()->first();
        return view('pages.struktur', compact('structure'));
    }
}
