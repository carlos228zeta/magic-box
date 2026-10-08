<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| FavoriteController - Pusat Kendali CRUD Magic Box (Level 17)
|--------------------------------------------------------------------------
|
| Fitur Level 17 (Ultimate Upgrade):
| - Upload Gambar Harta Favorit + Image Preview
| - Kategori Ikon Dinamis & Warna Warni
| - Filter Cepat (Quick Filter Badges)
| - Fitur Sortir Dinamis (Terbaru, Terlama, A-Z, Z-A, Pinned)
| - Konfirmasi Hapus SweetAlert2
|
*/

class FavoriteController extends Controller
{
    // Helper function: Mengambil daftar kategori unik yang ada di Magic Box
    private function getCategories()
    {
        $dbCategories = Favorite::select('kategori')->distinct()->pluck('kategori')->toArray();
        $default = ['hobi', 'makanan', 'minuman', 'film', 'game', 'musik', 'buku'];
        
        // Gabungkan kategori bawaan dan dari database, lalu buat huruf kecil dan unik
        $merged = array_map('strtolower', array_merge($default, $dbCategories));
        return array_values(array_unique(array_filter($merged)));
    }

    // =========================================================================
    // 1. READ (Melihat Semua Data + Search + Filter + Sortir + Pagination + Pin)
    // =========================================================================
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $kategoriFilter = trim($request->input('filter_kategori', ''));
        $sort = $request->input('sort', 'latest');
        $categories = $this->getCategories();

        $query = Favorite::query();

        // 1. Filter Pencarian Kata Kunci
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('isi', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%");
            });
        }

        // 2. Filter Kategori Cepat (Quick Filter)
        if ($kategoriFilter !== '' && $kategoriFilter !== 'semua') {
            $query->where('kategori', strtolower($kategoriFilter));
        }

        // 3. Sortir Dinamis
        // Selalu prioritaskan Pin jika memilih 'latest' atau 'pinned'
        if ($sort === 'pinned') {
            $query->where('is_pinned', true)->latest();
        } elseif ($sort === 'oldest') {
            $query->orderBy('is_pinned', 'desc')->oldest();
        } elseif ($sort === 'az') {
            $query->orderBy('is_pinned', 'desc')->orderBy('isi', 'asc');
        } elseif ($sort === 'za') {
            $query->orderBy('is_pinned', 'desc')->orderBy('isi', 'desc');
        } else {
            // Default: 'latest'
            $query->orderBy('is_pinned', 'desc')->latest();
        }

        // Paginasi: 6 data per halaman
        $favorites = $query->paginate(6)->withQueryString();

        $totalCount = Favorite::count();
        $pinnedCount = Favorite::where('is_pinned', true)->count();

        return view('index', [
            'favorites'      => $favorites,
            'categories'     => $categories,
            'search'         => $search,
            'kategoriFilter' => $kategoriFilter,
            'sort'           => $sort,
            'totalCount'     => $totalCount,
            'pinnedCount'    => $pinnedCount,
        ]);
    }

    // =========================================================================
    // 2. CREATE (Menampilkan Form Tambah) -> create()
    // =========================================================================
    public function create()
    {
        $categories = $this->getCategories();

        return view('create', [
            'categories' => $categories
        ]);
    }

    // =========================================================================
    // 3. STORE (Menyimpan Data Baru + Upload Gambar) -> store()
    // =========================================================================
    public function store(Request $request)
    {
        if ($request->input('kategori') === 'baru' && $request->filled('kategori_baru')) {
            $request->merge(['kategori' => strtolower(trim($request->input('kategori_baru')))]);
        }

        // Validasi data & file upload gambar
        $validated = $request->validate([
            'kategori' => 'required|string|max:50',
            'isi'      => 'required|string|max:500',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048', // Max 2MB
        ], [
            'kategori.required' => 'Kategori wajib diisi atau dipilih!',
            'isi.required'      => 'Isi favorit tidak boleh kosong!',
            'gambar.image'      => 'File harus berupa gambar foto valid!',
            'gambar.max'        => 'Ukuran gambar maksimal 2MB!',
        ]);

        $dataToSave = [
            'kategori'  => strtolower(trim($validated['kategori'])),
            'isi'       => trim($validated['isi']),
            'is_pinned' => $request->boolean('is_pinned', false),
            'gambar'    => null,
        ];

        // Simpan file gambar jika di-upload
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $path = $request->file('gambar')->store('favorites', 'public');
            $dataToSave['gambar'] = $path;
        }

        Favorite::create($dataToSave);

        return redirect()->route('favorites.index')
            ->with('success', 'Harta baru beserta foto berhasil disimpan ke Magic Box! ✨');
    }

    // =========================================================================
    // 4. EDIT (Menampilkan Form Ubah Data) -> edit()
    // =========================================================================
    public function edit($id)
    {
        $favorite = Favorite::findOrFail($id);
        $categories = $this->getCategories();

        return view('edit', [
            'favorite'   => $favorite,
            'categories' => $categories
        ]);
    }

    // =========================================================================
    // 5. UPDATE (Menyimpan Perubahan + Ganti/Hapus Gambar) -> update()
    // =========================================================================
    public function update(Request $request, $id)
    {
        $favorite = Favorite::findOrFail($id);

        if ($request->input('kategori') === 'baru' && $request->filled('kategori_baru')) {
            $request->merge(['kategori' => strtolower(trim($request->input('kategori_baru')))]);
        }

        $validated = $request->validate([
            'kategori' => 'required|string|max:50',
            'isi'      => 'required|string|max:500',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        ], [
            'kategori.required' => 'Kategori wajib diisi atau dipilih!',
            'isi.required'      => 'Isi favorit tidak boleh kosong!',
            'gambar.image'      => 'File harus berupa gambar foto valid!',
            'gambar.max'        => 'Ukuran gambar maksimal 2MB!',
        ]);

        $updateData = [
            'kategori'  => strtolower(trim($validated['kategori'])),
            'isi'       => trim($validated['isi']),
            'is_pinned' => $request->has('is_pinned') ? $request->boolean('is_pinned') : $favorite->is_pinned,
        ];

        // Opsi: Hapus foto lama jika dicentang
        if ($request->boolean('hapus_gambar') && $favorite->gambar) {
            Storage::disk('public')->delete($favorite->gambar);
            $updateData['gambar'] = null;
        }

        // Jika upload foto baru
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            // Hapus file foto lama jika ada
            if ($favorite->gambar) {
                Storage::disk('public')->delete($favorite->gambar);
            }
            $path = $request->file('gambar')->store('favorites', 'public');
            $updateData['gambar'] = $path;
        }

        $favorite->update($updateData);

        return redirect()->route('favorites.index')
            ->with('success', 'Data favorit berhasil diperbarui!');
    }

    // =========================================================================
    // 6. DESTROY / DELETE (Menghapus Data & File Gambarnya) -> destroy()
    // =========================================================================
    public function destroy($id)
    {
        $favorite = Favorite::findOrFail($id);

        // Hapus file fisik gambar jika ada
        if ($favorite->gambar) {
            Storage::disk('public')->delete($favorite->gambar);
        }

        $favorite->delete();

        return redirect()->back()
            ->with('success', 'Harta favorit berhasil dihapus dari Magic Box.');
    }

    // =========================================================================
    // 7. TOGGLE PIN / BINTANG FAVORIT UTAMA -> togglePin()
    // =========================================================================
    public function togglePin($id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->is_pinned = !$favorite->is_pinned;
        $favorite->save();

        $pesan = $favorite->is_pinned
            ? '⭐ Berhasil disematkan sebagai Favorit Utama!'
            : 'Sematkan Favorit Utama dilepas.';

        return redirect()->back()->with('success', $pesan);
    }

    // =========================================================================
    // 8. DASHBOARD & FILTER KATEGORI
    // =========================================================================
    public function dashboard()
    {
        $categories = $this->getCategories();
        
        $stats = [];
        foreach ($categories as $cat) {
            $stats[$cat] = Favorite::where('kategori', $cat)->count();
        }
        
        $totalAll = Favorite::count();
        $totalPinned = Favorite::where('is_pinned', true)->count();
        $latestFavorites = Favorite::orderBy('is_pinned', 'desc')->latest()->take(6)->get();

        return view('dashboard', [
            'categories'      => $categories,
            'stats'           => $stats,
            'totalAll'        => $totalAll,
            'totalPinned'     => $totalPinned,
            'latestFavorites' => $latestFavorites
        ]);
    }

    public function category(Request $request, $kategori)
    {
        $search = trim($request->input('search', ''));
        $kategoriLower = strtolower($kategori);
        $categories = $this->getCategories();

        $query = Favorite::where('kategori', $kategoriLower);

        if ($search !== '') {
            $query->where('isi', 'LIKE', "%{$search}%");
        }

        $favorites = $query->orderBy('is_pinned', 'desc')
                           ->latest()
                           ->paginate(6)
                           ->withQueryString();

        $count = Favorite::where('kategori', $kategoriLower)->count();

        return view('favorite', [
            'kategori'   => ucfirst($kategoriLower),
            'favorites'  => $favorites,
            'categories' => $categories,
            'search'     => $search,
            'count'      => $count,
        ]);
    }

    public function hobi(Request $request) { return $this->category($request, 'hobi'); }
    public function makanan(Request $request) { return $this->category($request, 'makanan'); }
    public function minuman(Request $request) { return $this->category($request, 'minuman'); }
}

