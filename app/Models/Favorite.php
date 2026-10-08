<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Model Favorite - Jembatan Antara Laravel & Tabel 'favorites'
|--------------------------------------------------------------------------
|
| Model ini mewakili tabel 'favorites' di database MySQL 'magicbox'.
| Melalui Model ini, kita bisa melakukan operasi CRUD:
| - Create  : Favorite::create([...])
| - Read    : Favorite::all(), Favorite::find($id)
| - Update  : $favorite->update([...])
| - Delete  : $favorite->delete()
|
*/

class Favorite extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database (opsional jika nama tabel jamak dalam bahasa Inggris)
    protected $table = 'favorites';

    // $fillable: Kolom yang diizinkan diisi data secara massal (mass assignment)
    // Demi keamanan, Laravel mewajibkan kita mendaftarkan kolom apa saja yang boleh diisi pengguna.
    protected $fillable = [
        'kategori',
        'isi',
        'is_pinned',
        'gambar'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    /**
     * Helper Level 17: Mengambil Ikon Dinamis berdasarkan Kategori
     */
    public function getCategoryIconAttribute(): string
    {
        $map = [
            'hobi'     => '🎮',
            'makanan'  => '🍕',
            'minuman'  => '🧋',
            'film'     => '🎬',
            'musik'    => '🎵',
            'buku'     => '📚',
            'game'     => '👾',
            'olahraga' => '⚽',
            'teknologi'=> '💻',
            'hewan'    => '🐱',
            'wisata'   => '✈️',
        ];

        return $map[strtolower($this->kategori)] ?? '✨';
    }

    /**
     * Helper Level 17: Mengambil Warna Badge berdasarkan Kategori
     */
    public function getCategoryColorAttribute(): string
    {
        $map = [
            'hobi'     => 'bg-purple-100 text-purple-700 border-purple-200 dark:bg-purple-950/50 dark:text-purple-300 dark:border-purple-800/40',
            'makanan'  => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800/40',
            'minuman'  => 'bg-cyan-100 text-cyan-700 border-cyan-200 dark:bg-cyan-950/50 dark:text-cyan-300 dark:border-cyan-800/40',
            'film'     => 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800/40',
            'musik'    => 'bg-pink-100 text-pink-700 border-pink-200 dark:bg-pink-950/50 dark:text-pink-300 dark:border-pink-800/40',
            'buku'     => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800/40',
            'game'     => 'bg-indigo-100 text-indigo-700 border-indigo-200 dark:bg-indigo-950/50 dark:text-indigo-300 dark:border-indigo-800/40',
            'olahraga' => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-950/50 dark:text-green-300 dark:border-green-800/40',
            'teknologi'=> 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-950/50 dark:text-blue-300 dark:border-blue-800/40',
            'hewan'    => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-950/50 dark:text-orange-300 dark:border-orange-800/40',
        ];

        return $map[strtolower($this->kategori)] ?? 'bg-indigo-100 text-indigo-700 border-indigo-200 dark:bg-indigo-950/50 dark:text-indigo-300 dark:border-indigo-800/40';
    }

    /**
     * Helper URL Gambar
     */
    public function getGambarUrlAttribute(): ?string
    {
        if ($this->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->gambar)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($this->gambar);
        }
        return null;
    }
}
