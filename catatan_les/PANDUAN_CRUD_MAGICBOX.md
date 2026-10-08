# Catatan Les: Belajar CRUD Laravel (Magic Box)

Halo! Ini catatan pegangan kamu buat belajar dan latihan mandiri di rumah. Di materi kali ini, project Magic Box kita sudah berhasil jadi aplikasi CRUD yang utuh.

Biar kamu makin paham apa yang baru saja kita ketik bareng-bareng di kelas, baca rangkuman ini pelan-pelan ya.

---

## 1. Apa Itu CRUD?

CRUD itu singkatan dari 4 hal yang selalu ada di semua website dan aplikasi di dunia:

1. C = Create (Artinya membuat atau menambah data baru).
   Contoh di project kita: Kamu ngetik nama hobi baru, terus klik tombol Simpan.

2. R = Read (Artinya membaca atau menampilkan data yang sudah ada).
   Contoh di project kita: Halaman utama yang menampilkan daftar semua favorit dari database.

3. U = Update (Artinya mengedit atau mengubah data yang sudah tersimpan).
   Contoh di project kita: Kamu klik tombol Edit, ganti kata yang typo, lalu simpan perubahannya.

4. D = Delete (Artinya menghapus data).
   Contoh di project kita: Kamu klik tombol Hapus untuk membuang data yang tidak kamu mau.

---

## 2. Bagaimana Alur Datanya di Laravel?

Waktu kamu klik tombol di browser, urutan jalannya seperti ini:

1. Browser kamu membuka alamat web.
2. File routes/web.php membaca alamat itu dan memanggil Controller yang cocok.
3. FavoriteController menerima tugas, lalu memanggil Model Favorite.
4. Model Favorite bertugas ngobrol langsung dengan database MySQL (database magicbox, tabel favorites).
5. Database mengirim balik datanya ke Controller.
6. Controller mengirim data tersebut ke file View (Blade).
7. View Blade mengubah data jadi tampilan HTML yang rapi di layar browser kamu.

---

## 3. Penjelasan Model (app/Models/Favorite.php)

File Model ini adalah jembatan penghubung antara kode PHP kita dengan tabel favorites di MySQL.

Isi kodenya:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database MySQL kita
    protected $table = 'favorites';

    // Kolom apa saja yang boleh diisi lewat form
    protected $fillable = [
        'kategori',
        'isi'
    ];
}
```

Kenapa ada fillable?
Laravel punya pengaman bawaan. Kalau kita mau memasukkan data dari form ke database, kita harus mendaftarkan dulu nama kolomnya di dalam array fillable. Di tabel kita kolomnya adalah kategori dan isi.

---

## 4. Penjelasan Controller (app/Http/Controllers/FavoriteController.php)

Controller itu seperti mandor atau pengatur lalu lintas. Semua proses logika dan perintah CRUD ditulis di sini.

Ada 6 fungsi utama di dalam controller kita:

### Fungsi 1: index() -> Untuk Fitur Read (Tampilkan Semua Data)

```php
public function index()
{
    // Mengambil semua data dari tabel favorites, diurutkan dari yang paling baru
    $favorites = Favorite::latest()->get();
    $categories = $this->getCategories();

    // Kirim datanya ke tampilan index.blade.php
    return view('index', [
        'favorites' => $favorites,
        'categories' => $categories
    ]);
}
```

Penjelasan:
Favorite::latest()->get() artinya tolong ambilkan semua data dari tabel favorites, urutkan dari tanggal terbaru. Lalu data itu dikirim ke file index.blade.php supaya bisa dilihat pengguna.

---

### Fungsi 2: create() -> Untuk Membuka Form Tambah

```php
public function create()
{
    $categories = $this->getCategories();

    // Buka tampilan form kosong di create.blade.php
    return view('create', [
        'categories' => $categories
    ]);
}
```

Penjelasan:
Fungsi ini tugasnya sederhana, cuma membuka halaman create.blade.php yang berisi form kosong agar siswa bisa mengetik data baru.

---

### Fungsi 3: store() -> Untuk Menyimpan Data Baru ke Database

```php
public function store(Request $request)
{
    // Cek jika siswa memilih bikin kategori baru
    if ($request->input('kategori') === 'baru' && $request->filled('kategori_baru')) {
        $request->merge(['kategori' => strtolower(trim($request->input('kategori_baru')))]);
    }

    // Validasi agar form tidak boleh dikosongkan
    $validated = $request->validate([
        'kategori' => 'required|string|max:50',
        'isi'      => 'required|string|max:500',
    ], [
        'kategori.required' => 'Kategori wajib diisi atau dipilih!',
        'isi.required'      => 'Isi favorit tidak boleh kosong!',
    ]);

    // Simpan ke database MySQL lewat Model
    Favorite::create([
        'kategori' => strtolower(trim($validated['kategori'])),
        'isi'      => trim($validated['isi'])
    ]);

    // Kembali ke halaman utama dengan pesan sukses
    return redirect()->route('favorites.index')
        ->with('success', 'Data baru berhasil disimpan ke Magic Box.');
}
```

Penjelasan:
1. $request->validate bertugas memeriksa. Kalau kolomnya kosong, proses berhenti dan muncul peringatan error.
2. Favorite::create bertugas memasukkan baris baru ke tabel MySQL.
3. redirect()->route mengembalikan siswa ke halaman utama sambil membawa pesan sukses.

---

### Fungsi 4: edit($id) -> Untuk Membuka Form Edit

```php
public function edit($id)
{
    // Cari data di database yang nomor ID-nya cocok
    $favorite = Favorite::findOrFail($id);
    $categories = $this->getCategories();

    // Buka form edit dan bawa data lama yang mau diedit
    return view('edit', [
        'favorite'   => $favorite,
        'categories' => $categories
    ]);
}
```

Penjelasan:
findOrFail($id) artinya cari data favorit yang punya ID tersebut. Kalau ketemu, datanya dikirim ke file edit.blade.php supaya form otomatis terisi data lama.

---

### Fungsi 5: update($id) -> Untuk Menyimpan Perubahan Data

```php
public function update(Request $request, $id)
{
    // Cari data yang mau diubah
    $favorite = Favorite::findOrFail($id);

    if ($request->input('kategori') === 'baru' && $request->filled('kategori_baru')) {
        $request->merge(['kategori' => strtolower(trim($request->input('kategori_baru')))]);
    }

    // Validasi data
    $validated = $request->validate([
        'kategori' => 'required|string|max:50',
        'isi'      => 'required|string|max:500',
    ], [
        'kategori.required' => 'Kategori wajib diisi atau dipilih!',
        'isi.required'      => 'Isi favorit tidak boleh kosong!',
    ]);

    // Update isinya di database
    $favorite->update([
        'kategori' => strtolower(trim($validated['kategori'])),
        'isi'      => trim($validated['isi'])
    ]);

    // Kembali ke halaman utama dengan pesan sukses
    return redirect()->route('favorites.index')
        ->with('success', 'Data favorit berhasil diperbarui.');
}
```

Penjelasan:
Setelah siswa mengubah teks di form edit lalu klik Simpan Perubahan, fungsi update() ini yang mengubah data lama di MySQL menjadi data baru.

---

### Fungsi 6: destroy($id) -> Untuk Menghapus Data

```php
public function destroy($id)
{
    // Cari data yang mau dihapus berdasarkan ID
    $favorite = Favorite::findOrFail($id);

    // Hapus data dari tabel
    $favorite->delete();

    // Kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()
        ->with('success', 'Data berhasil dihapus dari Magic Box.');
}
```

Penjelasan:
$favorite->delete() akan menghapus baris data tersebut selamanya dari MySQL.

---

## 5. Penjelasan Rute (routes/web.php)

Rute adalah buku daftar alamat di website kita. Setiap ada yang akses URL tertentu, rute yang menentukan controller mana yang harus jalan.

```php
// Menampilkan halaman utama
Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');

// Membuka form tambah
Route::get('/favorite/create', [FavoriteController::class, 'create'])->name('favorite.create');

// Memproses simpan data baru (menggunakan POST)
Route::post('/favorite/store', [FavoriteController::class, 'store'])->name('favorite.store');

// Membuka form edit data berdasarkan ID
Route::get('/favorites/{id}/edit', [FavoriteController::class, 'edit'])->name('favorites.edit');

// Memproses update data berdasarkan ID (menggunakan PUT)
Route::put('/favorites/{id}', [FavoriteController::class, 'update'])->name('favorites.update');

// Memproses hapus data berdasarkan ID (menggunakan DELETE)
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
```

Catatan metode pengiriman data:
- GET: dipakai saat cuma mau membuka atau melihat halaman.
- POST: dipakai saat mau mengirim data baru dari form.
- PUT: dipakai saat mau menimpa atau memperbarui data lama.
- DELETE: dipakai saat mau menghapus data.

---

## 6. Penjelasan Tampilan Blade (Views)

Blade adalah file HTML buatan Laravel dengan ekstensi .blade.php.

Ada 3 hal penting yang sering kita tulis di form Blade:

1. @csrf
   Ini adalah stempel keamanan wajib dari Laravel. Setiap kali membuat tag form, selalu letakkan @csrf di bawahnya supaya form kita aman dari hacker.

2. @method('PUT') dan @method('DELETE')
   Form di HTML biasa cuma kenal GET dan POST. Agar Laravel tahu form edit kita itu proses update, kita tulis @method('PUT'). Dan untuk form hapus, kita tulis @method('DELETE').

3. old('nama_input')
   Kalau pengguna lupa mengisi salah satu kolom form dan muncul error, isian form yang lain tidak akan hilang berkat fungsi old().

---

## 7. Cara Latihan Mandiri di Rumah

1. Buka XAMPP Control Panel, pastikan Apache dan MySQL sudah Start (berwarna hijau).
2. Buka aplikasi Terminal atau Command Prompt di folder project magicbox.
3. Ketik perintah:
   php artisan serve
4. Buka browser dan ketik alamat:
   http://127.0.0.1:8000
5. Coba 4 aksi ini:
   - Coba lihat apakah data lama muncul (Read).
   - Coba klik tombol Tambah Favorit, isi hobi atau makanan kesukaanmu, lalu klik Simpan (Create).
   - Coba klik tombol Edit di samping data yang kamu buat tadi, ubah teksnya, lalu klik Simpan Perubahan (Update).
   - Coba klik tombol Hapus, pilih OK saat muncul pertanyaan konfirmasi, dan lihat apakah datanya hilang (Delete).

Kalau 4 hal di atas sudah berhasil berjalan di browsermu, berarti kamu sudah resmi menguasai materi CRUD Laravel level dasar. Keren banget!
