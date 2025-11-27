<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'SA',
                'description' => 'Super Administrator',
            ],
            [
                'name' => 'Admin',
                'description' => 'Administrator sistem dengan akses terbatas',
            ],
            [
                'name' => 'KL',
                'description' => 'Kepala Lembaga',
            ],
            [
                'name' => 'TU',
                'description' => 'Kepala Sub Bagian Tata Usaha',
            ],
            [
                'name' => 'KP',
                'description' => 'Kepala Pusat',
            ],

            [
                'name' => 'Staff',
                'description' => 'Staff',
            ],

        ];

        foreach ($roles as $role) {
            # code...
            Role::create($role);
        }

        $this->command->info('Seeder kanggo tabel Role parantos dipidamel dunungan 😎');
    }
}
