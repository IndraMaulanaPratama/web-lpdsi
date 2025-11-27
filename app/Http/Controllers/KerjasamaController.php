<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class KerjasamaController extends Controller
{
    public function index()
    {
        $mitraDalam = Partner::where('type', 'domestic')->get();
        $mitraLuar  = Partner::where('type', 'foreign')->get();

        return view('pages.kerjasama', compact('mitraDalam', 'mitraLuar'));

    }
}
