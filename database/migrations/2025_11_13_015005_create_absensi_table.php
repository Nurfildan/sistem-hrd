<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->unsignedBigInteger('shift_id');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa', 'Cuti'])->default('Hadir');
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shift')->onDelete('cascade');
            $table->unique(['karyawan_id', 'tanggal']); // satu record per karyawan per hari

        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
};
