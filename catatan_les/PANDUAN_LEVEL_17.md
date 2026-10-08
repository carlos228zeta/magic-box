# Panduan Belajar Magic Box: Level 17 (Upload Gambar, Filter Kategori, dan Sortir Data)

Pada materi Level 17 ini, kita menambahkan beberapa fitur penting untuk membuat aplikasi CRUD Magic Box menjadi lebih lengkap, yaitu fitur upload berkas gambar, penyaringan kategori secara cepat, pengurutan data otomatis, dan modal dialog konfirmasi hapus.

---

## 1. Fitur Utama yang Dikerjakan

1. **Upload Berkas Gambar (File Upload & Storage)**
   - Menambahkan kemampuan melampirkan foto untuk setiap data favorit.
   - Menggunakan konfigurasi storage bawaan Laravel agar berkas tersimpan aman di direktori publik.
   - Menyediakan fitur pratinjau gambar secara langsung sebelum disimpan, serta opsi untuk mengganti atau menghapus gambar lama saat proses edit.

2. **Kategori Berwarna dan Ikon Otomatis**
   - Menampilkan ikon dan warna label yang menyesuaikan secara otomatis berdasarkan kategori yang dipilih (seperti Hobi, Makanan, Minuman, Film, Game, Musik, Buku, dan lainnya).

3. **Penyaringan Cepat (Quick Filter Badges)**
   - Menyediakan tombol-tombol kategori di atas daftar data agar pengguna bisa menyaring data hanya dengan satu kali klik tanpa perlu mengetik di kotak pencarian.

4. **Pengurutan Data (Sorting)**
   - Menambahkan menu pilihan untuk mengurutkan data berdasarkan:
     - Terbaru (bawaan)
     - Terlama
     - Nama A sampai Z
     - Nama Z sampai A
     - Khusus data yang disematkan sebagai Favorit Utama (Pin)

5. **Konfirmasi Hapus dengan SweetAlert2**
   - Mengganti dialog konfirmasi bawaan peramban web dengan tampilan modal yang lebih rapi dan jelas saat pengguna ingin menghapus data.

---

## 2. Alur Teknis Upload Berkas di Laravel

1. **Formulir View**
   Pada tag formulir HTML, wajib ditambahkan atribut `enctype="multipart/form-data"` agar peramban dapat mengirimkan data berkas ke server:
   ```blade
   <form action="{{ route('favorite.store') }}" method="POST" enctype="multipart/form-data">
       @csrf
       <input type="file" name="gambar" accept="image/*">
   ```

2. **Penyimpanan di Controller**
   Controller memeriksa keberadaan berkas dan menyimpannya ke dalam direktori storage publik:
   ```php
   if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
       $path = $request->file('gambar')->store('favorites', 'public');
       $dataToSave['gambar'] = $path;
   }
   ```

3. **Tautan Simbolik (Symbolic Link)**
   Laravel memisahkan folder penyimpanan internal dengan folder aset publik. Agar berkas gambar dapat diakses oleh browser, kita membuat tautan simbolik menggunakan perintah:
   ```bash
   php artisan storage:link
   ```

---

## 3. Langkah Pengujian Mandiri

1. Jalankan server lokal dengan perintah `php artisan serve`.
2. Buka alamat `http://127.0.0.1:8000` di peramban web.
3. Coba tambahkan data favorit baru dengan melampirkan foto.
4. Klik pada gambar kecil di daftar utama untuk melihat tampilan gambar dalam ukuran penuh.
5. Uji coba tombol filter kategori dan menu pengurutan data.
6. Coba lakukan penghapusan data untuk memastikan pesan konfirmasi muncul dengan benar.
