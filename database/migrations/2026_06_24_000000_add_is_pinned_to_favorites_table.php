<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: Tambahkan kolom is_pinned untuk fitur Bintang / Pin Favorit Level 16.
     */
    public function up(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false)->after('isi');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropColumn('is_pinned');
        });
    }
};
