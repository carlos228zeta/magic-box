@extends('layouts.app')

@section('title', 'Magic Box - Dashboard Kotak Ajaib')

@push('styles')
<style>
    /* Hero Banner Dashboard */
    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
        border-radius: var(--radius-md);
        padding: 30px 36px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.2);
        gap: 20px;
        flex-wrap: wrap;
    }

    .hero-text h1 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .hero-text p {
        font-size: 14px;
        opacity: 0.92;
        line-height: 1.5;
        max-width: 580px;
    }

    .hero-buttons {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-hero-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: var(--primary);
        padding: 11px 20px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.15s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .btn-hero-primary:hover {
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .btn-hero-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.15);
        color: white;
        padding: 11px 18px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.15s ease;
        backdrop-filter: blur(4px);
    }

    .btn-hero-secondary:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 18px;
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        padding: 22px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        gap: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-card.stat-pinned {
        background: #fffdf5;
        border-color: #fde68a;
    }

    .stat-badge {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 3px 10px;
        border-radius: 4px;
        background: var(--primary-light);
        color: var(--primary);
        width: fit-content;
        letter-spacing: 0.5px;
    }

    .stat-pinned .stat-badge {
        background: var(--gold-light);
        color: #b45309;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1;
        margin: 4px 0;
    }

    .stat-footer-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .stat-pinned .stat-footer-link {
        color: #b45309;
    }

    .stat-footer-link:hover { text-decoration: underline; }

    /* Recent Items Card */
    .recent-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .recent-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-color);
    }

    .recent-title {
        font-size: 16px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .recent-all-link {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--primary);
        text-decoration: none;
    }

    .recent-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .recent-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: #f8fafc;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-color);
        gap: 14px;
        transition: background-color 0.15s ease;
    }

    .recent-item:hover { background: #f1f5f9; }

    .recent-item.is-pinned {
        background: #fffdf5;
        border-color: #fde68a;
    }

    .recent-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }

    .recent-text {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        word-break: break-word;
    }

    .cat-tag {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        background: #e2e8f0;
        color: #334155;
        text-transform: uppercase;
        flex-shrink: 0;
    }

    .recent-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-edit-sm {
        background: var(--warning-light);
        color: var(--warning);
        border: 1px solid #fde68a;
        padding: 5px 12px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-edit-sm:hover { background: var(--warning); color: white; }

    @media (max-width: 768px) {
        .hero-banner { flex-direction: column; align-items: flex-start; }
        .hero-buttons { width: 100%; flex-direction: column; }
        .btn-hero-primary, .btn-hero-secondary { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')

    <!-- Banner Dashboard -->
    <div class="hero-banner">
        <div class="hero-text">
            <h1>
                <span>Dashboard Magic Box</span>
                <span class="level-badge" style="background: rgba(255,255,255,0.2); color: white; border: none;">Level 16</span>
            </h1>
            <p>Selamat datang di pusat kendali aplikasi CRUD Magic Box. Pantau ringkasan harta, temukan hal yang disukai, dan kelola data database <code>magicbox</code>.</p>
        </div>
        <div class="hero-buttons">
            <a href="{{ route('favorites.index') }}" class="btn-hero-primary">
                <i class="bi bi-box-seam-fill"></i>
                <span>Buka Magic Box</span>
            </a>
            <a href="{{ route('favorite.create') }}" class="btn-hero-secondary">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Favorit</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div>
        <h2 style="font-size: 13.5px; font-weight: 700; margin-bottom: 14px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Ringkasan Harta Favorit</h2>
        <div class="stats-grid">
            <!-- Total Semua Harta -->
            <div class="stat-card">
                <span class="stat-badge">Total Semua</span>
                <div class="stat-number">{{ $totalAll ?? 0 }}</div>
                <a href="{{ route('favorites.index') }}" class="stat-footer-link">
                    <span>Lihat Semua Data</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Total Favorit Utama (Bintang ⭐) -->
            <div class="stat-card stat-pinned">
                <span class="stat-badge">⭐ Favorit Utama</span>
                <div class="stat-number" style="color: #b45309;">{{ $totalPinned ?? 0 }}</div>
                <a href="{{ route('favorites.index') }}" class="stat-footer-link">
                    <span>Lihat yang Disematkan</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Per Kategori -->
            @foreach($categories as $cat)
                <div class="stat-card">
                    <span class="stat-badge">{{ ucfirst($cat) }}</span>
                    <div class="stat-number">{{ $stats[$cat] ?? 0 }}</div>
                    <a href="{{ route('favorite.category', $cat) }}" class="stat-footer-link">
                        <span>Buka Kategori {{ ucfirst($cat) }}</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Riwayat Terbaru -->
    <div class="recent-card">
        <div class="recent-header">
            <div class="recent-title">
                <i class="bi bi-clock-history" style="color: var(--primary);"></i>
                <span>Harta Favorit Terbaru & Disematkan</span>
            </div>
            <a href="{{ route('favorites.index') }}" class="recent-all-link">
                <span>Lihat Semua Data</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if($latestFavorites->isEmpty())
            <p style="text-align: center; color: var(--text-muted); padding: 24px;">Belum ada data favorit tersimpan di database.</p>
        @else
            <div class="recent-list">
                @foreach($latestFavorites as $fav)
                    <div class="recent-item {{ $fav->is_pinned ? 'is-pinned' : '' }}">
                        <div class="recent-left">
                            @if($fav->is_pinned)
                                <i class="bi bi-star-fill" style="color: var(--gold); font-size: 16px;" title="Favorit Utama"></i>
                            @else
                                <i class="bi bi-dot" style="color: var(--text-muted); font-size: 20px;"></i>
                            @endif
                            <span class="recent-text">{{ $fav->isi }}</span>
                        </div>
                        <div class="recent-actions">
                            <span class="cat-tag">{{ ucfirst($fav->kategori) }}</span>
                            <span style="font-size: 12px; color: var(--text-muted);">{{ $fav->created_at->diffForHumans() }}</span>
                            <a href="{{ route('favorites.edit', $fav->id) }}" class="btn-edit-sm">
                                <i class="bi bi-pencil-square"></i>
                                <span>Edit</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
