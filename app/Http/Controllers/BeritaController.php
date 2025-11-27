<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class BeritaController extends Controller
{
    public function welcome()
    {
        $berita = Post::latest()->take(3)->get(); // ambil 3 berita terbaru
        return view('welcome', compact('berita'));
    }
    public function index()
    {
        $berita = Post::latest()->paginate(9);
        return view('pages.news.berita', compact('berita'));
    }

    public function show($slug)
    {
        $detail = Post::where('slug', $slug)->firstOrFail();
        return view('pages.news.berita-detail', compact('detail'));
    }
}
