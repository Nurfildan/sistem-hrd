<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AturanPotonganJabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('aturan_potongan_jabatan')->insert([
            [
                'jabatan_id' => 1,
                'potongan_hadir'      => 0,
                'potongan_terlambat'  => 25000,
                'potongan_izin'       => 30000,
                'potongan_sakit'      => 0,
                'potongan_alpa'       => 100000,
                'potongan_cuti'       => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
