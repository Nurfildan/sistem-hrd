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
            $table->decimal('potongan_per_absen', 15, 2);

            $table->timestamps();

            $table->foreign('jabatan_id')
                ->references('id')
                ->on('jabatan')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan_potongan_jabatan');
    }
};
