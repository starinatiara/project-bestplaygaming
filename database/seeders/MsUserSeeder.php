<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MsUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['nama' => 'Super Admin', 'username' => 'superadmin', 'password' => 'admin123', 'role' => 'superadmin'],
            ['nama' => 'Kasir 1', 'username' => 'kasir1', 'password' => 'kasir123', 'role' => 'kasir'],
        ];

        foreach ($users as $u) {
            DB::table('ms_user')->updateOrInsert(
                ['username' => $u['username']],
                [
                    'nama' => $u['nama'],
                    'password' => Hash::make($u['password']),
                    'role' => $u['role'],
                ]
            );
        }
    }
}