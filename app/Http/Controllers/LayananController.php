<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Labkomputer;
use App\Models\LabBahasa;
use App\Models\LabPemerintahan;
use App\Models\Pddikti;

class LayananController extends Controller
{
    public function komputer()
    {
         // Kalau hanya 1 data yang aktif ditampilkan:
        $lab = LabKomputer::latest()->first();

        return view('Layanan.komputer', compact('lab'));
    }

    public function bahasa()
    {
        $lab = LabBahasa::latest()->first();
        return view('Layanan.bahasa', compact('lab'));
    }

    public function pemerintahan()
    {
        $lab = LabPemerintahan::latest()->first();
        return view('Layanan.pemerintahan', compact('lab'));
    }

    public function pddikti()
    {
        $lab = Pddikti::latest()->first();
        return view('Layanan.pddikti', compact('lab'));
    }
}
