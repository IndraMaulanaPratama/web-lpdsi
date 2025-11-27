<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Akses kanggo CRUD tea gening ieu mah
            ['name' => 'view', 'description' => 'Melihat data'],
            ['name' => 'create', 'description' => 'Membuat data baru'],
            ['name' => 'edit', 'description' => 'Mengedit data'],
            ['name' => 'delete', 'description' => 'Menghapus data'],
            ['name' => 'restore', 'description' => 'Mengembalikan data yang dihapus'],
            ['name' => 'force_delete', 'description' => 'Menghapus data permanen'],

            // Akses jugawn manawi kaanggo setujuan data 👀
            ['name' => 'approve', 'description' => 'Menyetujui data'],
            ['name' => 'reject', 'description' => 'Menolak data'],
            ['name' => 'publish', 'description' => 'Mempublish data'],
            ['name' => 'unpublish', 'description' => 'Unpublish data'],
            ['name' => 'export', 'description' => 'Export data'],
            ['name' => 'import', 'description' => 'Import data'],
            ['name' => 'print', 'description' => 'Print data'],
            ['name' => 'download', 'description' => 'Download file'],
            ['name' => 'upload', 'description' => 'Upload file'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $this->command->info('Seeder Permission parantos dipidamel aden ginupatohan 😍');
    }
}
