@extends('layouts.app')

@section('title', 'Magic Box - Kategori ' . $kategori . ' Favorit')

@push('styles')
<style>
    /* Filter Bar */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        background: white;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        transition: all 0.15s ease;
    }

    .filter-pill:hover, .filter-pill.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    /* Main Data Card */
    .data-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
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

    /* Item List */
    .item-list {
        display: flex;
        flex-direction: column;
    }

    .item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid var(--border-color);
        gap: 16px;
        transition: background-color 0.15s ease;
    }

    .item-row:last-child { border-bottom: none; }
    .item-row:hover { background: #f8fafc; }

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
        gap: 14px;
        flex: 1;
        min-width: 0;
    }

    .btn-star {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 20px;
        color: #cbd5e1;
        padding: 4px;
        border-radius: 6px;
        transition: transform 0.15s ease, color 0.15s ease;
        line-height: 1;
    }

    .btn-star:hover {
        transform: scale(1.2);
        color: var(--gold);
    }

    .btn-star.active {
        color: var(--gold);
    }

    .item-content-box {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 0;
    }

    .item-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3px 10px;
        border-radius: 4px;
        width: fit-content;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .badge-hobi { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .badge-makanan { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .badge-minuman { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }

    .badge-pinned-tag {
        background: var(--gold-light);
        color: #b45309;
        border: 1px solid #fde68a;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
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
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.45;
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
        padding: 7px 14px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 12.5px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-edit:hover { background: var(--warning); color: white; }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--danger-light);
        color: var(--danger);
        border: 1px solid #fecaca;
        padding: 7px 14px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 12.5px;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-delete:hover { background: var(--danger); color: white; }

    .empty-box {
        text-align: center;
        padding: 56px 24px;
    }

    .empty-icon {
        font-size: 42px;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .empty-title { font-size: 17px; font-weight: 800; color: var(--text-dark); margin-bottom: 6px; }
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
        .item-row { flex-direction: column; align-items: flex-start; }
        .item-actions { width: 100%; justify-content: flex-end; }
        .pagination-wrapper { flex-direction: column; align-items: stretch; text-align: center; }
        .pagination-nav { justify-content: center; }
    }
</style>
@endpush

@section('content')

    <!-- Header Bar -->
    <div class="header-bar">
        <div class="header-title">
            <div>
                <h1>
                    <span>Kategori: {{ $kategori }}</span>
                    <span class="level-badge">Filter</span>
                </h1>
                <p>Menampilkan semua harta favorit yang terdaftar dalam kategori <strong>{{ $kategori }}</strong>.</p>
            </div>
        </div>

        <div class="header-actions">
            <!-- Search Bar Form -->
            <form action="{{ route('favorite.category', strtolower($kategori)) }}" method="GET" class="search-form">
                <i class="bi bi-search search-icon"></i>
                <input 
                    type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="Cari di kategori {{ $kategori }}..." 
                    value="{{ $search ?? '' }}"
                    autocomplete="off"
                >
                @if(!empty($search))
                    <a href="{{ route('favorite.category', strtolower($kategori)) }}" class="search-reset" title="Hapus Pencarian">
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

    <!-- Filter Bar -->
    <div class="filter-bar">
        <span class="filter-label">Kategori:</span>
        <a href="{{ route('favorites.index') }}" class="filter-pill">
            <i class="bi bi-collection"></i>
            <span>Semua</span>
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('favorite.category', $cat) }}" class="filter-pill {{ strtolower($cat) === strtolower($kategori) ? 'active' : '' }}">
                <i class="bi bi-tag-fill"></i>
                <span>{{ ucfirst($cat) }}</span>
            </a>
        @endforeach
    </div>

    <!-- Data Card -->
    <div class="data-card">
        <div class="data-header">
            <div class="data-header-left">
                <h3>Daftar Favorit {{ $kategori }}</h3>
                <span class="count-badge">{{ $favorites->total() }} Data</span>
            </div>

            @if(!empty($search))
                <div style="font-size: 13px; color: var(--text-muted);">
                    Hasil pencarian di kategori {{ $kategori }}: <strong>"{{ $search }}"</strong> 
                    <a href="{{ route('favorite.category', strtolower($kategori)) }}" style="color: var(--primary); text-decoration: none; margin-left: 6px; font-weight: 600;">(Reset)</a>
                </div>
            @endif
        </div>

        @if($favorites->isEmpty())
            <div class="empty-box">
                <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                @if(!empty($search))
                    <div class="empty-title">Tidak Ada Hasil Pencarian</div>
                    <div class="empty-desc">Tidak ditemukan data favorit kategori {{ $kategori }} dengan kata kunci <strong>"{{ $search }}"</strong>.</div>
                    <a href="{{ route('favorite.category', strtolower($kategori)) }}" class="btn-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        <span>Reset Pencarian</span>
                    </a>
                @else
                    <div class="empty-title">Belum Ada Favorit di Kategori Ini</div>
                    <div class="empty-desc">Belum ada harta favorit yang disimpan untuk kategori <strong>{{ $kategori }}</strong>.</div>
                    <a href="{{ route('favorite.create') }}" class="btn-add">
                        <i class="bi bi-plus-lg"></i>
                        <span>Tambah Favorit {{ $kategori }}</span>
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

                            <div class="item-content-box">
                                <div class="item-meta">
                                    <span class="category-badge">
                                        {{ ucfirst($favorite->kategori) }}
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
                            <a href="{{ route('favorites.edit', $favorite->id) }}" class="btn-edit">
                                <i class="bi bi-pencil-square"></i>
                                <span>Edit</span>
                            </a>

                            <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus favorit ini?\n\nData: {{ addslashes($favorite->isi) }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="bi bi-trash3-fill"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigasi Paginasi -->
            @if($favorites->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan data ke <strong>{{ $favorites->firstItem() }}</strong> sampai <strong>{{ $favorites->lastItem() }}</strong> dari total <strong>{{ $favorites->total() }}</strong> favorit
                    </div>
                    <div class="pagination-nav">
                        @if ($favorites->onFirstPage())
                            <span class="page-btn disabled"><i class="bi bi-chevron-left"></i></span>
                        @else
                            <a href="{{ $favorites->previousPageUrl() }}" class="page-btn" rel="prev"><i class="bi bi-chevron-left"></i></a>
                        @endif

                        @foreach ($favorites->getUrlRange(1, $favorites->lastPage()) as $page => $url)
                            @if ($page == $favorites->currentPage())
                                <span class="page-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

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
