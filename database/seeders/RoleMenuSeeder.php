<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisiasi role
        $superAdminRole = Role::where('name', 'SA')->first();
        $adminRole = Role::where('name', 'Admin')->first();

        // Nyandak sadaya menu nu tos aya di database
        $allMenus = Menu::all();

        // Super Admin - Pasihan sadaya menu tur sadaya akses/permission
        foreach ($allMenus as $menu) {
            RoleMenu::create([
                'role_id' => $superAdminRole->id,
                'menu_id' => $menu->id,
                'permissions' => json_encode([
                    'view',
                    'create',
                    'edit',
                    'delete',
                    'restore',
                    'force_delete',
                    'approve',
                    'reject',
                    'publish',
                    'unpublish',
                    'export',
                    'import',
                    'print',
                    'download',
                    'upload'
                ]),
            ]);
        }


        // Admin - Pasihan hampir sadaya menu iwal ti menu pengaturan sareng pengguna
        $adminMenus = $allMenus->filter(function ($menu) {
            return !in_array($menu->name, ['Pengaturan Aplikasi', 'Kelola Pengguna']);
        });


        // Proses input data role menu kanggo admin
        foreach ($adminMenus as $menu) {
            RoleMenu::create([
                'role_id' => $adminRole->id,
                'menu_id' => $menu->id,
                'permissions' => json_encode(['view', 'create', 'edit', 'delete']),
            ]);
        }

        $this->command->info('Role menus tos rengse dilebetkeun juragan 👌🏻');
    }
}
