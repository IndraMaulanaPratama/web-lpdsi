<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DivisiSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            RoleMenuSeeder::class,
            PostSeeder::class,
            CategorySopSeeder::class,
            CategoryPanduanSeeder::class,
        ]);
    }
}
