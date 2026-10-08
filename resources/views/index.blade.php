@extends('layouts.app')

@section('title', 'Magic Box - Semua Favorit')

@push('styles')
<style>
    /* Controls Bar: Filter & Sort */
    .controls-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .filter-pills-scroll {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        background: var(--card-bg);
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .filter-pill:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-1px);
    }

    .filter-pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    .sort-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--card-bg);
        padding: 4px 12px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .sort-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
    }

    .sort-select {
        border: none;
        background: transparent;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        outline: none;
        cursor: pointer;
    }

    /* Main Data Card */
    .data-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .data-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafafa;
        flex-wrap: wrap;
        gap: 12px;
    }

    .data-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .data-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: var(--text-dark);
    }

    .count-badge {
        background: var(--primary-light);
        color: var(--primary);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .pinned-badge {
        background: var(--gold-light);
        color: #b45309;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Item List */
    .item-list {
        display: flex;
        flex-direction: column;
    }

    .item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        gap: 20px;
        transition: all 0.2s ease;
        position: relative;
    }

    .item-row:last-child { border-bottom: none; }
    .item-row:hover {
        background: #fbfcfe;
    }

    .item-row.is-pinned {
        background: #fffdf5;
        border-left: 4px solid var(--gold);
    }

    .item-row.is-pinned:hover {
        background: #fefce8;
    }

    .item-main {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        flex: 1;
        min-width: 0;
    }

    /* Star Button */
    .btn-star {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 22px;
        color: #cbd5e1;
        padding: 4px;
        border-radius: 6px;
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.15s ease;
        line-height: 1;
    }

    .btn-star:hover {
        transform: scale(1.25);
        color: var(--gold);
    }

    .btn-star.active {
        color: var(--gold);
        filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.3));
    }

    /* Thumbnail Foto Item Level 17 */
    .item-thumb-wrapper {
        width: 76px;
        height: 76px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        background: #f1f5f9;
        flex-shrink: 0;
        border: 1px solid var(--border-color);
        position: relative;
        cursor: pointer;
    }

    .item-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .item-thumb-wrapper:hover .item-thumb {
        transform: scale(1.1);
    }

    .item-content-box {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
        min-width: 0;
    }

    .item-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .category-badge-dynamic {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid;
    }

    .badge-pinned-tag {
        background: var(--gold-light);
        color: #b45309;
        border: 1px solid #fde68a;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .time-badge {
        font-size: 12px;
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .item-text {
        font-size: 15.5px;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.5;
        word-break: break-word;
    }

    .item-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--warning-light);
        color: var(--warning);
        border: 1px solid #fde68a;
        padding: 8px 14px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 12.5px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-edit:hover {
        background: var(--warning);
        color: white;
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--danger-light);
        color: var(--danger);
        border: 1px solid #fecaca;
        padding: 8px 14px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-delete:hover {
        background: var(--danger);
        color: white;
    }

    /* Empty Box */
    .empty-box {
        text-align: center;
        padding: 60px 24px;
    }

    .empty-icon {
        font-size: 48px;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .empty-title { font-size: 18px; font-weight: 800; color: var(--text-dark); margin-bottom: 6px; }
    .empty-desc { font-size: 14px; color: var(--text-muted); margin-bottom: 22px; max-width: 480px; margin-left: auto; margin-right: auto; }

    /* Custom Pagination Bar */
    .pagination-wrapper {
        padding: 18px 24px;
        border-top: 1px solid var(--border-color);
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-info {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-color);
        background: white;
        color: var(--text-dark);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .page-btn:hover:not(.disabled) {
        background: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }

    .page-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .page-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f1f5f9;
    }

    @media (max-width: 768px) {
        .controls-bar { flex-direction: column; align-items: stretch; }
        .sort-box { justify-content: space-between; }
        .item-row { flex-direction: column; align-items: flex-start; }
        .item-actions { width: 100%; justify-content: flex-end; }
        .pagination-wrapper { flex-direction: column; align-items: stretch; text-align: center; }
        .pagination-nav { justify-content: center; }
    }
</style>
@endpush

@section('content')

    <!-- Top Header Bar -->
    <div class="header-bar">
        <div class="header-title">
            <div>
                <h1>
                    <span>Magic Box</span>
                    <span class="level-badge">Level 17</span>
                </h1>
                <p>Kelola harta favoritmu dengan Upload Foto 📷, Kategori Ikon Dinamis, Sortir, dan Pin ⭐</p>
            </div>
        </div>

        <div class="header-actions">
            <!-- Search Bar Form -->
            <form action="{{ route('favorites.index') }}" method="GET" class="search-form">
                <input type="hidden" name="filter_kategori" value="{{ $kategoriFilter ?? '' }}">
                <input type="hidden" name="sort" value="{{ $sort ?? 'latest' }}">
                <i class="bi bi-search search-icon"></i>
                <input 
                    type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="Cari favorit atau kategori..." 
                    value="{{ $search ?? '' }}"
                    autocomplete="off"
                >
                @if(!empty($search))
                    <a href="{{ route('favorites.index', ['filter_kategori' => $kategoriFilter ?? '', 'sort' => $sort ?? 'latest']) }}" class="search-reset" title="Hapus Pencarian">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                @endif
            </form>

            <a href="{{ route('favorite.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Favorit</span>
            </a>
        </div>
    </div>

    <!-- Filter Cepat & Sortir Bar (Fitur Level 17) -->
    <div class="controls-bar">
        <div class="filter-pills-scroll">
            <span style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Kategori:</span>
            
            <a href="{{ route('favorites.index', ['search' => $search ?? '', 'sort' => $sort ?? 'latest']) }}" 
               class="filter-pill {{ empty($kategoriFilter) || $kategoriFilter == 'semua' ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Semua ({{ $totalCount ?? $favorites->total() }})</span>
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('favorites.index', ['filter_kategori' => $cat, 'search' => $search ?? '', 'sort' => $sort ?? 'latest']) }}" 
                   class="filter-pill {{ ($kategoriFilter ?? '') === $cat ? 'active' : '' }}">
                    @php
                        $dummyFav = new \App\Models\Favorite(['kategori' => $cat]);
                    @endphp
                    <span>{{ $dummyFav->category_icon }}</span>
                    <span>{{ ucfirst($cat) }}</span>
                </a>
            @endforeach
        </div>

        <!-- Dropdown Sortir Dinamis -->
        <form action="{{ route('favorites.index') }}" method="GET" class="sort-box" id="sortForm">
            <input type="hidden" name="search" value="{{ $search ?? '' }}">
            <input type="hidden" name="filter_kategori" value="{{ $kategoriFilter ?? '' }}">
            <i class="bi bi-sort-down" style="color: var(--primary);"></i>
            <span class="sort-label">Urutkan:</span>
            <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                <option value="latest" {{ ($sort ?? 'latest') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                <option value="az" {{ ($sort ?? '') === 'az' ? 'selected' : '' }}>Nama (A - Z)</option>
                <option value="za" {{ ($sort ?? '') === 'za' ? 'selected' : '' }}>Nama (Z - A)</option>
                <option value="pinned" {{ ($sort ?? '') === 'pinned' ? 'selected' : '' }}>⭐ Hanya Favorit Utama</option>
            </select>
        </form>
    </div>

    <!-- Card List Data Favorit (READ) -->
    <div class="data-card">
        <div class="data-header">
            <div class="data-header-left">
                <h3>Daftar Favorit</h3>
                <span class="count-badge">{{ $favorites->total() }} Data Ditampilkan</span>
                @if(($pinnedCount ?? 0) > 0)
                    <span class="pinned-badge">
                        <i class="bi bi-star-fill"></i>
                        <span>{{ $pinnedCount }} Favorit Utama</span>
                    </span>
                @endif
            </div>

            @if(!empty($search) || !empty($kategoriFilter))
                <div style="font-size: 13px; color: var(--text-muted);">
                    Filter aktif: 
                    @if(!empty($search)) <strong>"{{ $search }}"</strong> @endif
                    @if(!empty($kategoriFilter)) <span class="category-badge-dynamic" style="font-size: 11px; padding: 2px 6px;">{{ ucfirst($kategoriFilter) }}</span> @endif
                    <a href="{{ route('favorites.index') }}" style="color: var(--primary); text-decoration: none; margin-left: 6px; font-weight: 700;">(Bersihkan)</a>
                </div>
            @endif
        </div>

        @if($favorites->isEmpty())
            <div class="empty-box">
                <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                @if(!empty($search) || !empty($kategoriFilter))
                    <div class="empty-title">Tidak Ada Harta yang Cocok</div>
                    <div class="empty-desc">Tidak ditemukan data favorit dengan filter yang dipilih. Coba ganti kata kunci atau pilih kategori lain.</div>
                    <a href="{{ route('favorites.index') }}" class="btn-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        <span>Tampilkan Semua Data</span>
                    </a>
                @else
                    <div class="empty-title">Magic Box Masih Kosong</div>
                    <div class="empty-desc">Belum ada data favorit di dalam kotak. Yuk abadikan hal kesukaanmu beserta fotonya sekarang!</div>
                    <a href="{{ route('favorite.create') }}" class="btn-add">
                        <i class="bi bi-plus-lg"></i>
                        <span>Tambah Favorit Pertama</span>
                    </a>
                @endif
            </div>
        @else
            <div class="item-list">
                @foreach($favorites as $favorite)
                    <div class="item-row {{ $favorite->is_pinned ? 'is-pinned' : '' }}">
                        <div class="item-main">
                            <!-- Tombol Toggle Bintang / Pin -->
                            <form action="{{ route('favorites.togglePin', $favorite->id) }}" method="POST" title="{{ $favorite->is_pinned ? 'Lepas Sematkan' : 'Sematkan sebagai Favorit Utama' }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-star {{ $favorite->is_pinned ? 'active' : '' }}">
                                    <i class="bi {{ $favorite->is_pinned ? 'bi-star-fill' : 'bi-star' }}"></i>
                                </button>
                            </form>

                            <!-- Thumbnail Foto Level 17 -->
                            @if($favorite->gambar_url)
                                <div class="item-thumb-wrapper" onclick="previewImage('{{ $favorite->gambar_url }}', '{{ addslashes($favorite->isi) }}')">
                                    <img src="{{ $favorite->gambar_url }}" alt="Foto Favorit" class="item-thumb">
                                </div>
                            @endif

                            <div class="item-content-box">
                                <div class="item-meta">
                                    <!-- Badge Kategori Ikon & Warna Dinamis -->
                                    <span class="category-badge-dynamic {{ $favorite->category_color }}">
                                        <span>{{ $favorite->category_icon }}</span>
                                        <span>{{ ucfirst($favorite->kategori) }}</span>
                                    </span>

                                    @if($favorite->is_pinned)
                                        <span class="badge-pinned-tag">
                                            <i class="bi bi-pin-angle-fill"></i> Favorit Utama
                                        </span>
                                    @endif

                                    <span class="time-badge" title="{{ $favorite->created_at->format('d M Y H:i') }}">
                                        <i class="bi bi-clock"></i> {{ $favorite->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="item-text">{{ $favorite->isi }}</div>
                            </div>
                        </div>
                        
                        <div class="item-actions">
                            <!-- Tombol EDIT (UPDATE) -->
                            <a href="{{ route('favorites.edit', $favorite->id) }}" class="btn-edit">
                                <i class="bi bi-pencil-square"></i>
                                <span>Edit</span>
                            </a>

                            <!-- Form & Tombol HAPUS dengan SweetAlert2 -->
                            <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete" onclick="confirmDelete(this)">
                                    <i class="bi bi-trash3-fill"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigasi Paginasi Cantik -->
            @if($favorites->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan data ke <strong>{{ $favorites->firstItem() }}</strong> sampai <strong>{{ $favorites->lastItem() }}</strong> dari total <strong>{{ $favorites->total() }}</strong> favorit
                    </div>
                    <div class="pagination-nav">
                        {{-- Tombol Previous --}}
                        @if ($favorites->onFirstPage())
                            <span class="page-btn disabled"><i class="bi bi-chevron-left"></i></span>
                        @else
                            <a href="{{ $favorites->previousPageUrl() }}" class="page-btn" rel="prev"><i class="bi bi-chevron-left"></i></a>
                        @endif

                        {{-- Angka Halaman --}}
                        @foreach ($favorites->getUrlRange(1, $favorites->lastPage()) as $page => $url)
                            @if ($page == $favorites->currentPage())
                                <span class="page-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Tombol Next --}}
                        @if ($favorites->hasMorePages())
                            <a href="{{ $favorites->nextPageUrl() }}" class="page-btn" rel="next"><i class="bi bi-chevron-right"></i></a>
                        @else
                            <span class="page-btn disabled"><i class="bi bi-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>

@endsection

@push('scripts')
<script>
    // Preview Gambar Besar dengan SweetAlert2
    function previewImage(url, title) {
        Swal.fire({
            title: title,
            imageUrl: url,
            imageAlt: 'Foto Favorit',
            showConfirmButton: false,
            showCloseButton: true,
            width: '600px',
            customClass: {
                popup: 'swal2-magic-popup'
            }
        });
    }
</script>
@endpush
