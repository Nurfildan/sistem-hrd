<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('shift', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('shift');
    }
};
