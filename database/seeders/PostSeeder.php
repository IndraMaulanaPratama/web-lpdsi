<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'user_id' => 1,
                'penulis' => 'penulis Berita 1',
                'judul' => 'Judul Berita 1',
                'slug' => Str::slug('Judul Berita 1'),
                'isi' => 'Ini adalah isi lengkap berita 1...',
                'gambar' => 'images/berita1.jpg',
                'tanggal' => date('Y-m-d'),
            ],

            [
                'user_id' => 2,
                'penulis' => 'penulis Berita 2',
                'judul' => 'Judul Berita 2',
                'slug' => Str::slug('Judul Berita 2'),
                'isi' => 'Ini adalah isi lengkap berita 2...',
                'gambar' => 'images/berita2.jpg',
                'tanggal' => date('Y-m-d'),
            ],

        ];

        foreach ($posts as $post) {
            # code...
            Post::create($post);
        }

        $this->command->info('Seeder Post berhasil dijalankan!');
    }
}
