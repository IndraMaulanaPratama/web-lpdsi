<?php

namespace Database\Seeders;

use App\Models\CategoryPanduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryPanduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Manajemen Akun',
                'category_description' => 'Petunjuk umum bagi pengguna untuk memahami fitur sistem.',
            ],
            [
                'category_name' => 'Beban Kerja Dosen',
                'category_description' => 'Petunjuk untuk para dosen.',
            ],
            [
                'category_name' => 'Manajemen PTK',
                'category_description' => 'Prosedur untuk menjaga keamanan dan privasi data pengguna.',
            ],
        ];

        foreach ($categories as $category) {
            CategoryPanduan::create($category);
        }

        $this->command->info('✅ Data seeder kategori Panduan berhasil dieksekusi!');
    }
}
