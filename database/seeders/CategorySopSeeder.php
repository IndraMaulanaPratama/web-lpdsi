<?php

namespace Database\Seeders;

use App\Models\CategorySop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisis = [
            [
                'category_name' => 'Manajemen Akun',
                'category_description' => 'Data Dummy',
            ],


            [
                'category_name' => 'Manajemen PTK',
                'category_description' => 'Data Dummy',
            ],

            [
                'category_name' => 'Beban Kerja Dosen',
                'category_description' => 'Data Dummy',
            ],

        ];

        foreach ($divisis as $divisi) {
            CategorySop::create($divisi);
        }

        $this->command->info('Data seeder kategori SOP berhasil dieksekusi 🙏!');
    }
}
