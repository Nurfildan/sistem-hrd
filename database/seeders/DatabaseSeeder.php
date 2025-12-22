<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('local')) {
            $this->call([
                DepartemenSeeder::class,
                JabatanSeeder::class,
                KaryawanSeeder::class,
                UserSeeder::class,
                ShiftSeeder::class,
                AturanPotonganJabatanSeeder::class,
            ]);
        }
    }
}
