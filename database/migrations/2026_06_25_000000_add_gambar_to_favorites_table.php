<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: Tambahkan kolom gambar untuk upload foto harta favorit di Level 17.
     */
    public function up(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('is_pinned');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
    }
};
