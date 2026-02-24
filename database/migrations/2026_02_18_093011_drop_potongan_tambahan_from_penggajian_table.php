<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->dropColumn('potongan_tambahan');
        });
    }

    public function down(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->decimal('potongan_tambahan', 15, 2)->default(0);
        });
    }

};
