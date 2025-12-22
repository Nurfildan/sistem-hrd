<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departemen;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        $data = ['IT', 'HRD'];

        foreach ($data as $nama) {
            Departemen::updateOrCreate(
                ['nama_departemen' => $nama],
                []
            );
        }
    }
}
