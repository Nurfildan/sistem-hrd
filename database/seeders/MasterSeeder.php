<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    public function run(): void
    {
        // DEPARTEMEN
        DB::table('departemen')->updateOrInsert(
            ['nama_departemen' => 'IT'],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('departemen')->updateOrInsert(
            ['nama_departemen' => 'HRD'],
            [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // JABATAN
        DB::table('jabatan')->updateOrInsert(
            ['nama_jabatan' => 'Staff'],
            [
                'gaji_pokok' => 3000000,
                'tunjangan'  => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('jabatan')->updateOrInsert(
            ['nama_jabatan' => 'Manager'],
            [
                'gaji_pokok' => 7000000,
                'tunjangan'  => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // SHIFT
        DB::table('shift')->updateOrInsert(
            ['nama_shift' => 'Shift Pagi'],
            [
                'jam_mulai'  => '08:00:00',
                'jam_selesai'=> '16:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('shift')->updateOrInsert(
            ['nama_shift' => 'Shift Siang'],
            [
                'jam_mulai'  => '16:00:00',
                'jam_selesai'=> '00:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
