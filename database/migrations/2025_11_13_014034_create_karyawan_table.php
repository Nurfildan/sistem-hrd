<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->unsignedBigInteger('jabatan_id');
            $table->unsignedBigInteger('departemen_id');
            $table->date('tgl_masuk');
            $table->enum('status', ['Tetap','Kontrak','Magang'])->default('Kontrak');
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('cascade');
            $table->foreign('departemen_id')->references('id')->on('departemen')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('karyawan');
    }
};
