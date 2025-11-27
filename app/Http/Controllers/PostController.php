<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('uploads', 'public');
        }

        Post::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'excerpt' => Str::limit(strip_tags($request->isi), 150),
            'isi' => $request->isi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = $post->gambar;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('uploads', 'public');
        }

        $post->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'excerpt' => Str::limit(strip_tags($request->isi), 150),
            'isi' => $request->isi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diupdate');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus');
    }
}
