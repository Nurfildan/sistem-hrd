<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('jabatan')->insert([
            ['nama_jabatan'=>'Staff','gaji_pokok'=>3000000,'tunjangan'=>500000,'created_at'=>now(),'updated_at'=>now()],
            ['nama_jabatan'=>'Manager','gaji_pokok'=>7000000,'tunjangan'=>1500000,'created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('departemen')->insert([
            ['nama_departemen'=>'IT','created_at'=>now(),'updated_at'=>now()],
            ['nama_departemen'=>'HRD','created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('karyawan')->insert([
            ['nip'=>'K001','nama'=>'Budi Santoso','jabatan_id'=>1,'departemen_id'=>1,'tgl_masuk'=>'2025-01-01','status'=>'Tetap','no_hp'=>'08123456789','email'=>'budi@mail.com','alamat'=>'Jl. Contoh No.1','created_at'=>now(),'updated_at'=>now()],
            ['nip'=>'K002','nama'=>'Siti Aminah','jabatan_id'=>2,'departemen_id'=>2,'tgl_masuk'=>'2025-02-01','status'=>'Tetap','no_hp'=>'08198765432','email'=>'siti@mail.com','alamat'=>'Jl. Contoh No.2','created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('users')->insert([
            ['name'=>'Admin','email'=>'admin@mail.com','password'=>Hash::make('password'),'role'=>'Admin','karyawan_id'=>null,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Budi Santoso','email'=>'budi@mail.com','password'=>Hash::make('password'),'role'=>'Karyawan','karyawan_id'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Siti Aminah','email'=>'siti@mail.com','password'=>Hash::make('password'),'role'=>'HRD','karyawan_id'=>2,'created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('shift')->insert([
            ['nama_shift'=>'Shift Pagi','jam_mulai'=>'08:00:00','jam_selesai'=>'16:00:00','created_at'=>now(),'updated_at'=>now()],
            ['nama_shift'=>'Shift Siang','jam_mulai'=>'16:00:00','jam_selesai'=>'00:00:00','created_at'=>now(),'updated_at'=>now()],
        ]);

        DB::table('karyawan_shift')->insert([
            ['karyawan_id'=>1,'shift_id'=>1,'tanggal'=>now()->toDateString(),'created_at'=>now(),'updated_at'=>now()],
            ['karyawan_id'=>2,'shift_id'=>2,'tanggal'=>now()->toDateString(),'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
