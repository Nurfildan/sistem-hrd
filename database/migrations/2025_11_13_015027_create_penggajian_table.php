<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->string('bulan');
            $table->date('tanggal_penggajian');
            $table->decimal('gaji_pokok',15,2)->default(0);
            $table->decimal('tunjangan',15,2)->default(0);
            $table->decimal('potongan',15,2)->default(0);
            $table->decimal('total_gaji',15,2)->default(0);
            $table->enum('status_pembayaran',['Belum Dibayar','Sudah Dibayar'])->default('Belum Dibayar');
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('penggajian');
    }
};
