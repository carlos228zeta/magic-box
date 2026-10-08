<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration – membuat tabel favorites di database.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();               // Kolom id (nomor urut otomatis)
            $table->string('kategori'); // Kolom kategori (Hobi / Makanan / Minuman)
            $table->text('isi');        // Kolom isi (isi favorit)
            $table->timestamps();       // Kolom created_at dan updated_at (waktu otomatis)
        });
    }

    /**
     * Batalkan migration – hapus tabel favorites dari database.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
