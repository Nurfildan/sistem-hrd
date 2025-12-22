<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        Karyawan::create([
            'nip'           => 'KRY-001',
            'nama'          => 'Karla',
            'jabatan_id'    => 1, // pastikan ada di JabatanSeeder
            'departemen_id' => 1, // pastikan ada di DepartemenSeeder
            'tgl_masuk'     => Carbon::now(),
            'status'        => 'Tetap',
            'no_hp'         => '08123456789',
            'email'         => 'Karla@company.com',
            'alamat'        => 'Kantor Pusat',
            'foto'          => null,
        ]);
    }
}
