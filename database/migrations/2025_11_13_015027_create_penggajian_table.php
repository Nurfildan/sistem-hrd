<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('karyawan_id');

            // Periode gaji (contoh: 2025-09)
            $table->string('periode');

            $table->date('tanggal_penggajian');

            // Komponen gaji
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('tunjangan', 15, 2)->default(0);

            // Potongan
            $table->decimal('potongan_otomatis', 15, 2)->default(0);
            $table->decimal('potongan_tambahan', 15, 2)->default(0);

            // Total gaji bersih
            $table->decimal('total_gaji', 15, 2)->default(0);

            $table->enum('status_pembayaran', [
                'Belum Dibayar',
                'Sudah Dibayar'
            ])->default('Belum Dibayar');

            $table->timestamps();

            $table->foreign('karyawan_id')
                  ->references('id')
                  ->on('karyawan')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};
