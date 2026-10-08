# Catatan Les: Magic Box Level 16 (Smart CRUD & Clean Layout)

Halo! Selamat datang di **Level 16** dari proyek Magic Box kita! 🚀

Setelah di Level 14 kita berhasil membuat sistem CRUD lengkap, di Level 16 ini aplikasi kita naik kelas menjadi **aplikasi web profesional yang rapi, cerdas, dan interaktif**.

Baca panduan ini pelan-pelan ya untuk bahan latihan mandiri di rumah.

---

## 1. Apa Saja yang Baru di Level 16?

Ada 4 peningkatan besar yang kita tambahkan di Level 16:

1. **Master Layout Blade (`layouts/app.blade.php`)**
   - Sebelumnya, kita mengulang tag HTML, Sidebar, dan CSS ratusan baris di 5 file blade berbeda.
   - Sekarang, semua kerangka induk dipusatkan di satu file layout menggunakan `@extends` dan `@yield`. Kode jadi super bersih (*Clean Code / DRY*)!

2. **Kotak Pencarian Pintar (Search Bar)**
   - Sekarang kita bisa mencari kata kunci hobi, film, atau makanan langsung dari search bar atas tanpa harus scroll data satu per satu.

3. **Paginasi Rapi (Pagination)**
   - Jika data sudah banyak, website tidak akan melar ke bawah. Laravel membaginya rapi per 6 data per halaman lengkap dengan tombol halaman modern (1, 2, 3, Selanjutnya).

4. **Fitur Bintang / Favorit Utama (⭐ Pin to Top)**
   - Ada tombol bintang di samping setiap harta. Jika diklik, data tersebut akan ditandai sebagai **Favorit Utama** dan otomatis selalu muncul di urutan paling atas!

---

## 2. Mengenal Konsep Master Layout (`layouts/app.blade.php`)

### Apa itu `@extends` dan `@yield`?
Bayangkan Master Layout seperti **kertas sertifikat kosong** yang sudah ada bingkai dan kop suratnya. Sedangkan halaman `index`, `create`, atau `edit` adalah **isi tulisan di tengahnya**.

- File Induk: `resources/views/layouts/app.blade.php`
  Di bagian tengah yang ingin diisi konten dinamis, kita pasang stempel:
  ```blade
  @yield('content')
  ```

- File Anak: `resources/views/index.blade.php`
  File anak cukup memanggil induknya dengan:
  ```blade
  @extends('layouts.app')

  @section('content')
      <!-- Hanya tulis konten utamanya di sini -->
  @endsection
  ```

**Keuntungan:** Kalau kamu mau ganti nama aplikasi di sidebar atau ganti warna tema, cukup ubah di `app.blade.php` saja, semua halaman otomatis ikut berubah!

---

## 3. Bagaimana Cara Kerja Fitur Pencarian (Search)?

Alur kerjanya:
1. Pengguna mengetik kata kunci di input form (misal: `"Spider-Man"`).
2. Form mengirim nilai tersebut lewat URL: `http://127.0.0.1:8000/?search=Spider-Man`
3. `FavoriteController` membaca nilai itu dengan `$request->input('search')`.
4. Laravel menjalankan query SQL cerdas dengan klausa `LIKE`:
   ```php
   if ($search !== '') {
       $query->where(function ($q) use ($search) {
           $q->where('isi', 'LIKE', "%{$search}%")
             ->orWhere('kategori', 'LIKE', "%{$search}%");
       });
   }
   ```
5. Hasil yang cocok langsung ditampilkan ke layar.

---

## 4. Bagaimana Cara Kerja Paginasi (Pagination)?

Di Level 14 kita memakai `Favorite::latest()->get()`, yang artinya "ambil SEMUA data sekaligus".

Di Level 16 kita ganti menjadi:
```php
$favorites = $query->orderBy('is_pinned', 'desc')
                   ->latest()
                   ->paginate(6)
                   ->withQueryString();
```

- `paginate(6)`: Batasi hanya 6 baris data per halaman.
- `withQueryString()`: Menjaga agar kata kunci pencarian tidak hilang saat kita klik halaman ke-2 atau ke-3.
- Di file Blade, kita tinggal menulis tombol navigasinya atau memanfaatkan `$favorites->hasPages()`.

---

## 5. Bagaimana Cara Kerja Fitur Bintang (Toggle Pin ⭐)?

1. Kita menambahkan kolom baru bernama `is_pinned` (bertipe boolean: `true` atau `false`) di tabel `favorites` lewat migration.
2. Ketika ikon bintang diklik, form mengirim request dengan metode `PATCH` ke URL `/favorites/{id}/toggle-pin`.
3. Di Controller, kita membalik status nilainya:
   ```php
   public function togglePin($id)
   {
       $favorite = Favorite::findOrFail($id);
       $favorite->is_pinned = !$favorite->is_pinned; // Jika tadinya false jadi true, jika true jadi false
       $favorite->save();

       return redirect()->back()->with('success', 'Status bintang berhasil diubah!');
   }
   ```
4. Saat query dipanggil, kita pasang perintah `orderBy('is_pinned', 'desc')` agar baris yang bernilai `true` (1) selalu ditaruh di urutan paling pertama.

---

## 6. Uji Coba & Latihan Mandiri di Rumah

Coba lakukan 5 misi ini di komputermu:

1. **Jalankan Aplikasi:**
   - Buka terminal di folder project, ketik:
     ```bash
     php artisan serve
     ```
   - Buka browser di `http://127.0.0.1:8000`.

2. **Misi 1 - Tambah Data:**
   - Klik tombol **Tambah Favorit**. Masukkan beberapa hobi atau makanan kesukaanmu. Jangan lupa centang *"Sematkan sebagai Favorit Utama"* pada salah satu data.

3. **Misi 2 - Tes Bintang Favorit (Pin):**
   - Di halaman utama, klik ikon bintang (⭐) pada salah satu data biasa. Lihat apakah data tersebut langsung berpindah ke urutan paling atas dengan badge emas *"Favorit Utama"*.

4. **Misi 3 - Tes Pencarian (Search):**
   - Ketik salah satu kata di kotak pencarian atas lalu tekan Enter. Pastikan data yang muncul hanya yang mengandung kata tersebut. Klik tombol tanda silang merah (X) untuk mereset pencarian.

5. **Misi 4 - Ganti Warna Tema:**
   - Di menu sidebar bawah, coba klik warna Hijau, Ungu, Jingga, atau Merah Muda. Perhatikan bagaimana semua tombol dan badge otomatis berganti warna serasi!

---

**Selamat! Kamu sudah resmi menyelesaikan materi Level 16 Laravel Magic Box! Keren banget! 🎉**
