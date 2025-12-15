<?php

namespace Database\Seeders;

use App\Models\divisi;  // Fixed case sensitivity
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisis = [
            [
                'name' => 'LKSI',
                'description' => 'Lab Komputer dan Sistem Informasi',
            ],
            [
                'name' => 'PDDIKTI',
                'description' => 'Pengelolaan Data Pendidikan Tinggi',
            ],
            [
                'name' => 'LB',
                'description' => 'Laboratorium Bahasa',
            ],
            [
                'name' => 'LP',
                'description' => 'Laboratorium Pemerintahan',
            ],
            [
                'name' => 'TU',
                'description' => ' Tata Usaha dan Sistem Informasi'
            ],
            [
                'name' => 'KL',
                'description' => 'Kepala Lembaga',
            ],

        ];

        foreach ($divisis as $divisi) {
            divisi::create($divisi);
        }

        $this->command->info('Data seeder Kepala Pusat parantos rengse dipidamel juragan 🙏!');
    }
}
