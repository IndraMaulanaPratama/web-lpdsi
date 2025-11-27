<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use App\Models\divisi;
use App\Models\CategorySop;
use Illuminate\Http\Request;

class SOPController extends Controller
{
    public function show($type)
    {
        $divisi = Divisi::whereRaw('LOWER(name) = ?', [strtolower($type)])->firstOrFail();

        // Ambil semua SOP aktif di divisi itu
        $data = Sop::with('categorySop')
            ->where('divisi_id', $divisi->id)
            ->where('sop_status', 1)
            ->get();

        // Ambil kategori terkait
        $categories = CategorySop::whereIn('id', $data->pluck('category_sop_id')->unique())
            ->get();

        $judul = 'SOP ' . strtoupper($divisi->name);

        return view('pages.sop', compact('judul', 'data', 'categories'));
    }

}
