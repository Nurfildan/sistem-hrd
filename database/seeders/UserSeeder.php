<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'],
            [
                'name'        => 'Admin',
                'password'    => Hash::make('admin123'),
                'role'        => 'Admin',
                'karyawan_id' => null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );

        // HRD
        DB::table('users')->updateOrInsert(
            ['email' => 'HRD@gmail.com'],
            [
                'name'        => 'HRD',
                'password'    => Hash::make('HRD12345'),
                'role'        => 'HRD',
                'karyawan_id' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );

        // KARYAWAN
        DB::table('users')->updateOrInsert(
            ['email' => 'karyawan@gmail.com'],
            [
                'name'        => 'Karyawan',
                'password'    => Hash::make('karyawan'),
                'role'        => 'Karyawan',
                'karyawan_id' => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }
}
