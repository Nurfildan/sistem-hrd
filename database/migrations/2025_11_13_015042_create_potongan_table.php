<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('potongan', function (Blueprint $table) {
            $table->id();

            // Relasi ke penggajian
            $table->unsignedBigInteger('penggajian_id');
            $table->string('nama_potongan');
            $table->decimal('jumlah', 15, 2);

            // keterangan tambahan
            $table->text('keterangan')->nullable();

            $table->timestamps();
            
            $table->foreign('penggajian_id')
                ->references('id')
                ->on('penggajian')
                ->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('potongan');
    }
};