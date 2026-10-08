# Rincian Perubahan Kode: Level 17

Dokumen ini mencatat rincian baris kode yang ditambahkan atau dimodifikasi pada setiap file selama proses pengembangan materi Level 17. Dokumen ini dapat digunakan sebagai referensi perbandingan kode saat latihan mandiri.

---

## Daftar File yang Diubah

1. `database/migrations/2026_06_25_000000_add_gambar_to_favorites_table.php` (File Migrasi Baru)
2. `app/Models/Favorite.php` (Model)
3. `app/Http/Controllers/FavoriteController.php` (Controller)
4. `resources/views/layouts/app.blade.php` (Master Layout)
5. `resources/views/index.blade.php` (Halaman Daftar Utama)
6. `resources/views/create.blade.php` (Halaman Form Tambah Data)
7. `resources/views/edit.blade.php` (Halaman Form Ubah Data)

---

## 1. File Migrasi Database
Lokasi file: `database/migrations/2026_06_25_000000_add_gambar_to_favorites_table.php`

Tujuan: Menambahkan kolom `gambar` bertipe string yang bersifat opsional (nullable) pada tabel `favorites`.

```php
public function up(): void
{
    Schema::table('favorites', function (Blueprint $table) {
        $table->string('gambar')->nullable()->after('is_pinned');
    });
}

public function down(): void
{
    Schema::table('favorites', function (Blueprint $table) {
        $table->dropColumn('gambar');
    });
}
```

---

## 2. Model Favorite
Lokasi file: `app/Models/Favorite.php`

Perubahan yang dilakukan:
- Baris 35: Menambahkan kolom `'gambar'` ke dalam properti `$fillable` agar diizinkan untuk proses pengisian massal (mass assignment).
- Baris 44 sampai 93: Menambahkan method helper (accessor) untuk:
  - `getCategoryIconAttribute`: Menentukan ikon penanda kategori.
  - `getCategoryColorAttribute`: Menentukan kombinasi warna label kategori.
  - `getGambarUrlAttribute`: Memeriksa keberadaan berkas fisik gambar di folder storage dan mengembalikan tautan URL lengkapnya.

Contoh potongan kode:
```php
protected $fillable = [
    'kategori',
    'isi',
    'is_pinned',
    'gambar'
];

public function getGambarUrlAttribute(): ?string
{
    if ($this->gambar && file_exists(public_path('storage/' . $this->gambar))) {
        return asset('storage/' . $this->gambar);
    }
    return null;
}
```

---

## 3. Controller
Lokasi file: `app/Http/Controllers/FavoriteController.php`

Perubahan yang dilakukan:
- Baris 7: Menambahkan import facade storage `use Illuminate\Support\Facades\Storage;`.
- Method `index` (Baris 42 sampai 76):
  - Menangkap parameter pencarian, filter kategori (`filter_kategori`), dan opsi pengurutan (`sort`).
  - Menambahkan percabangan query pengurutan data berdasarkan pilihan pengguna (`latest`, `oldest`, `az`, `za`, atau `pinned`).
- Method `store` (Baris 102 sampai 128):
  - Menambahkan aturan validasi berkas gambar: `'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048'`.
  - Menjalankan proses penyimpanan berkas fisik gambar ke folder `public/favorites`.
- Method `update` (Baris 148 sampai 186):
  - Menambahkan pengecekan opsi hapus gambar lama menggunakan perintah `Storage::disk('public')->delete(...)`.
  - Menghapus gambar lama secara otomatis jika pengguna mengunggah gambar baru sebagai pengganti.
- Method `destroy` (Baris 194 sampai 206):
  - Menghapus berkas fisik gambar dari penyimpanan lokal saat data favorit dihapus dari database.

---

## 4. Master Layout
Lokasi file: `resources/views/layouts/app.blade.php`

Perubahan yang dilakukan:
- Baris 439: Menyematkan pustaka SweetAlert2 melalui CDN script tag.
- Baris 458 sampai 478: Membuat fungsi JavaScript `confirmDelete` untuk menangani pop-up konfirmasi hapus data secara elegan sebelum formulir dikirimkan ke server.

---

## 5. Halaman Daftar Utama (Index)
Lokasi file: `resources/views/index.blade.php`

Perubahan yang dilakukan:
- Baris 368 sampai 418:
  - Menyisipkan komponen tombol saring kategori cepat (Quick Filter).
  - Menyisipkan menu dropdown untuk memilih urutan data.
- Baris 433 sampai 437: Menampilkan kotak gambar kecil (thumbnail) di samping teks favorit yang bisa diklik.
- Baris 466 sampai 475: Mengubah tombol hapus agar memanggil fungsi JavaScript `confirmDelete(this)`.
- Baris 517 sampai 531: Menambahkan fungsi JavaScript `previewImage` untuk menampilkan gambar dalam ukuran lebih besar melalui dialog modal.

---

## 6. Halaman Form Tambah Data (Create)
Lokasi file: `resources/views/create.blade.php`

Perubahan yang dilakukan:
- Baris 243: Menambahkan atribut `enctype="multipart/form-data"` pada elemen `<form>`.
- Baris 270 sampai 286: Menambahkan area input file gambar berserta wadah pratinjau (preview).
- Baris 340 sampai 357: Menambahkan skrip JavaScript `FileReader` agar gambar yang baru dipilih pengguna langsung tampil di layar sebelum formulir dikirim.

---

## 7. Halaman Form Ubah Data (Edit)
Lokasi file: `resources/views/edit.blade.php`

Perubahan yang dilakukan:
- Baris 241: Menambahkan atribut `enctype="multipart/form-data"` pada formulir pembaruan data.
- Baris 268 sampai 299:
  - Menampilkan pratinjau gambar yang saat ini tersimpan di server.
  - Menyediakan kotak centang untuk menghapus gambar yang ada tanpa menghapus data teks.
  - Menyediakan area untuk mengunggah gambar pengganti baru.
