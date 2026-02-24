<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->integer('terlambat_menit')->default(0)->after('status');
            $table->enum('sumber', ['Auto', 'Manual'])->default('Auto')->after('terlambat_menit');
            $table->foreignId('updated_by')
                ->nullable()
                ->after('sumber')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['terlambat_menit', 'sumber', 'updated_by']);
        });
    }
};
