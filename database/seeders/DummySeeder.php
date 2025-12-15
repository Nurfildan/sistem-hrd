<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // KARYAWAN
        DB::table('karyawan')->insert([
            [
                'nip'            => 'KRY001',
                'nama'           => 'HRD Default',
                'jabatan_id'     => 2,
                'departemen_id'  => 2,
                'tgl_masuk'      => now()->toDateString(),
                'status'         => 'Tetap',
                'no_hp'          => '08111111111',
                'email'          => 'hrd@gmail.com',
                'alamat'         => 'Kantor HRD',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'nip'            => 'KRY002',
                'nama'           => 'Karyawan Default',
                'jabatan_id'     => 1,
                'departemen_id'  => 1,
                'tgl_masuk'      => now()->toDateString(),
                'status'         => 'Tetap',
                'no_hp'          => '08222222222',
                'email'          => 'karyawan@gmail.com',
                'alamat'         => 'Kantor IT',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        // KARYAWAN SHIFT
        DB::table('karyawan_shift')->insert([
            [
                'karyawan_id' => 1,
                'shift_id'    => 1,
                'tanggal'     => now()->toDateString(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'karyawan_id' => 2,
                'shift_id'    => 2,
                'tanggal'     => now()->toDateString(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
