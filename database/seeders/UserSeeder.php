<?php

namespace Database\Seeders;

use App\Models\divisi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Maca data Difisi/Kapus
        $lksi = divisi::where('name', 'LKSI')->first();
        $lp = Divisi::where('name', 'LP')->first();
        $lb = Divisi::where('name', 'LB')->first();
        $pddikti = Divisi::where('name', 'PDDIKTI')->first();
        $tu = Divisi::where('name', 'TU')->first();
        $kl = Divisi::where('name', 'KL')->first();

        // Maca Data Role
        $sa = Role::where('name', 'SA')->first();
        $admin = Role::where('name', 'Admin')->first();
        $KL = Role::where('name', 'KL')->first();
        $ktu = Role::where('name', 'TU')->first();
        $kp = Role::where('name', 'KP')->first();
        $staff = Role::where('name', 'Staff')->first();


        // Inisiasi data user
        $users = [
            [
                'divisi_id' => $lksi->id,
                'name' => 'Rama Wirahma',
                'email' => 'rama-wirahma@ipdn.ac.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            [
                'divisi_id' => $lksi->id,
                'name' => 'Viona',
                'email' => 'helpdesk.lpdsi@ipdn.ac.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],

            [
                'divisi_id' => $lksi->id,
                'name' => 'Administrator',
                'email' => 'lksi@ipdn.ac.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],

        ];

        /**
         * Proses input database
         * 1. ngalebetkeun data user
         * 2. nangtoskeun role dumasar kana user
         */
        foreach ($users as $data) {
            # code...

            // Ngadaftarkeun data user
            $user = User::create($data);


            // Nangtoskeun Role kanggo user nu tos didaftarkeun
            if ($user->email === 'rama-wirahma@ipdn.ac.id' || $user->email === 'helpdesk.lpdsi@ipdn.ac.id') {
                $user->roles()->attach($sa->id);
            } elseif ($user->email === 'lksi@ipdn.ac.id') {
                $user->roles()->attach($admin->id);
            }
        }

        $this->command->info('Mangga akang/teteh, data user parantos lebet 🙏');
    }
}
