<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_jabatan' => 'Staff',
                'gaji_pokok'   => 3000000,
                'tunjangan'    => 500000,
            ],
            [
                'nama_jabatan' => 'Manager',
                'gaji_pokok'   => 7000000,
                'tunjangan'    => 1500000,
            ],
        ];

        foreach ($data as $item) {
            Jabatan::updateOrCreate(
                ['nama_jabatan' => $item['nama_jabatan']],
                $item
            );
        }
    }
}
