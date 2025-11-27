<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // Menu Utama
            [
                'name' => 'Dashboard',
                'url' => '/admin/dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'order' => 1,
            ],
            [   'name' => 'Profil', 
                'url' => '#',
                'parent_id' => null, 
                'icon' => 'fas fa-building', 
                'order' => 2
            ],
            [
                'name' => 'Sambutan Kepala LPDSI',
                'url' => '/admin/sambutan',
                'parent_id' => 2,
                'icon' => 'fas fa-user-tie',
                'order' => 3,
            ],
            [
                'name' => 'Visi & Misi',
                'url' => '/admin/visi-misi',
                'parent_id' => 2,
                'icon' => 'fas fa-bullseye',
                'order' => 4,
            ],
            [
                'name' => 'Struktur Organisasi',
                'url' => '/admin/organisasi',
                'parent_id' => 2,
                'icon' => 'fas fa-sitemap',
                'order' => 5,
            ],
            [
                'name' => 'Kerjasama',
                'url' => '/admin/kerjasama',
                'icon' => 'fas fa-handshake',
                'order' => 6,
            ],
            [
                'name' => 'Berita',
                'url' => '/admin/berita',
                'icon' => 'fas fa-newspaper',
                'order' => 7,
            ],
            [
                'name' => 'Galeri',
                'url' => '/admin/galeri',
                'icon' => 'fas fa-images',
                'order' => 8,
            ],
            [
                'name' => 'SOP',
                'url' => '/admin/sop',
                'icon' => 'fas fa-file-alt',
                'order' => 9,
            ],
            [
                'name' => 'Layanan',
                'url' => '#',
                'parent_id' => null, 
                'icon' => 'fas fa-briefcase',
                'order' => 10,
            ],
            [
                'name' => 'Laboratorium Komputer&Sistem Informasi',
                'url' => '/admin/LabKomputer',
                'parent_id' => 10,
                'icon' => 'fas fa-desktop',
                'order' => 11,
            ],
            [
                'name' => 'Laboratorium Bahasa',
                'url' => '/admin/LabBahasa',
                'parent_id' => 10,
                'icon' => 'fas fa-language',
                'order' => 12,
            ],
            [
                'name' => 'PDDIKTI',
                'url' => '/admin/PDDIKTI',
                'parent_id' => 10,
                'icon' => 'fas fa-database',
                'order' => 13,
            ],
            [
                'name' => 'Laboratorium Pemerintahan',
                'url' => '/admin/LabPemerintahan',
                'parent_id' => 10,
                'icon' => 'fas fa-landmark',
                'order' => 14,
            ],
            [
                'name' => 'Panduan',
                'url' => '/admin/panduan',
                'icon' => 'fas fa-book-open',
                'order' => 15,
            ],
            [
                'name' => 'Agenda',
                'url' => '/admin/agenda',
                'icon' => 'fas fa-calendar-alt',
                'order' => 16,
            ],
            [
                'name' => 'Kelola Pengguna',
                'url' => '/admin/pengguna',
                'icon' => 'fas fa-users',
                'order' => 17,
            ],
            [
                'name' => 'Pengaturan Aplikasi',
                'url' => '/admin/dashboard',
                'icon' => 'fas fa-cog',
                'order' => 18,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        $this->command->info('Data menu tos kantun nanggo aa/teteh 🌹');

    }
}
