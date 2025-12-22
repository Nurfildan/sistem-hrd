<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('aturan_potongan_jabatan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('jabatan_id');

            // Potongan berdasarkan status kehadiran
            $table->decimal('potongan_hadir', 15, 2)->default(0);
            $table->decimal('potongan_terlambat', 15, 2)->default(0);
            $table->decimal('potongan_izin', 15, 2)->default(0);
            $table->decimal('potongan_sakit', 15, 2)->default(0);
            $table->decimal('potongan_alpa', 15, 2)->default(0);
            $table->decimal('potongan_cuti', 15, 2)->default(0);

            $table->timestamps();

            $table->foreign('jabatan_id')
                ->references('id')
                ->on('jabatan')
                ->cascadeOnDelete();

            // 1 jabatan = 1 aturan
            $table->unique('jabatan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan_potongan_jabatan');
    }
};
