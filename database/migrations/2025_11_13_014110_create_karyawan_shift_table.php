<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('karyawan_shift', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->unsignedBigInteger('shift_id');
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shift')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawan_shift');
    }
};
