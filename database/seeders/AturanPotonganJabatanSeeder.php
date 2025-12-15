<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AturanPotonganJabatan;
use App\Models\Jabatan;

class AturanPotonganJabatanSeeder extends Seeder
{
    public function run(): void
    {
        $aturan = [
            'Staff'   => 100000,
            'Manager' => 300000,
        ];

        foreach ($aturan as $jabatanNama => $potongan) {
            $jabatan = Jabatan::where('nama_jabatan', $jabatanNama)->first();

            if ($jabatan) {
                AturanPotonganJabatan::updateOrCreate(
                    ['jabatan_id' => $jabatan->id],
                    ['potongan_per_absen' => $potongan]
                );
            }
        }
    }
}
