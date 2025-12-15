<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_shift'  => 'Shift Pagi',
                'jam_mulai'   => '08:00:00',
                'jam_selesai' => '16:00:00',
            ],
            [
                'nama_shift'  => 'Shift Siang',
                'jam_mulai'   => '16:00:00',
                'jam_selesai' => '00:00:00',
            ],
        ];

        foreach ($data as $item) {
            Shift::updateOrCreate(
                ['nama_shift' => $item['nama_shift']],
                $item
            );
        }
    }
}
