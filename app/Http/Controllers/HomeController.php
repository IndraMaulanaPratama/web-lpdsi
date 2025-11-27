<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use App\Models\Agenda;
use App\Models\Sambutan; 
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil satu data konten beranda
        // $home = HomeContent::first();

        // Ambil satu data visi & misi
        $visiMisi = VisiMisi::latest()->first();

        // Ambil data sambutan (kalau cuma 1, ambil yang terbaru)
        $sambutan = Sambutan::latest()->first();

        // Ambil beberapa data agenda terbaru (misal 5)
        $agendas = Agenda::latest('tanggal')->take(5)->get();
        $berita = Post::latest()->take(3)->get();

        // Kirim semua data ke view
        return view('welcome', compact('visiMisi', 'sambutan', 'agendas', 'berita'));
    }
}
