<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin123'),
                'role'     => 'Admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'HRD@gmail.com'],
            [
                'name'         => 'HRD',
                'password'     => Hash::make('HRD12345'),
                'role'         => 'HRD',
                'karyawan_id'  => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'karyawan@gmail.com'],
            [
                'name'         => 'Karyawan',
                'password'     => Hash::make('karyawan'),
                'role'         => 'Karyawan',
                'karyawan_id'  => 2,
            ]
        );
    }
}
