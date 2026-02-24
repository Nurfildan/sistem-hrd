<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->string('nama_karyawan')->nullable()->after('karyawan_id');
            $table->string('nama_jabatan')->nullable()->after('nama_karyawan');
        });
    }

    public function down(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->dropColumn(['nama_karyawan', 'nama_jabatan']);
        });
    }
};
