<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Web Routes - Magic Box (Belajar Laravel CRUD Lengkap Level 16)
|--------------------------------------------------------------------------
|
| Di sini tempat pendaftaran semua alamat URL (Route) aplikasi kita.
| Di Level 16, kita menambahkan fitur:
| 1. Pencarian (Search Bar) & Paginasi (Pagination)
| 2. Toggle Status Pin / Favorit Utama (is_pinned)
| 3. Master Layout Blade terpusat
|
*/

// =========================================================================
// 1. HALAMAN UTAMA CRUD MAGIC BOX (READ + SEARCH + PAGINATE)
// =========================================================================
Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.list');

// =========================================================================
// 2. CREATE: FORM & PROSES SIMPAN DATA BARU
// =========================================================================
// GET: Menampilkan form tambah favorit
Route::get('/favorite/create', [FavoriteController::class, 'create'])->name('favorite.create');
Route::get('/favorites/create', [FavoriteController::class, 'create'])->name('favorites.create');

// POST: Menerima dan menyimpan data baru dari form ke database
Route::post('/favorite/store', [FavoriteController::class, 'store'])->name('favorite.store');
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');

// =========================================================================
// 3. UPDATE: FORM & PROSES UBAH DATA LAMA
// =========================================================================
// GET: Menampilkan form edit berisi data lama berdasarkan ID
Route::get('/favorites/{id}/edit', [FavoriteController::class, 'edit'])->name('favorites.edit');

// PUT: Menerima dan menyimpan perubahan data ke database
Route::put('/favorites/{id}', [FavoriteController::class, 'update'])->name('favorites.update');

// =========================================================================
// 4. DELETE: PROSES HAPUS DATA DARI DATABASE
// =========================================================================
// DELETE: Menghapus data dari database berdasarkan ID
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// =========================================================================
// 5. FITUR LEVEL 16: TOGGLE BINTANG / PIN FAVORIT UTAMA (PATCH)
// =========================================================================
Route::patch('/favorites/{id}/toggle-pin', [FavoriteController::class, 'togglePin'])->name('favorites.togglePin');

// =========================================================================
// 6. FITUR TAMBAHAN (DASHBOARD & FILTER KATEGORI)
// =========================================================================
Route::get('/dashboard', [FavoriteController::class, 'dashboard'])->name('dashboard');
Route::get('/hobi', [FavoriteController::class, 'hobi'])->name('favorite.hobi');
Route::get('/makanan', [FavoriteController::class, 'makanan'])->name('favorite.makanan');
Route::get('/minuman', [FavoriteController::class, 'minuman'])->name('favorite.minuman');
Route::get('/kategori/{kategori}', [FavoriteController::class, 'category'])->name('favorite.category');
