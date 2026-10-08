<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Magic Box - CRUD Laravel')</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            /* Tema Warna Dinamis */
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --bg-main: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --radius-md: 12px;
            --radius-sm: 8px;
            --danger: #dc2626;
            --danger-light: #fef2f2;
            --warning: #d97706;
            --warning-light: #fffbeb;
            --success: #16a34a;
            --success-light: #f0fdf4;
            --gold: #f59e0b;
            --gold-light: #fef3c7;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            font-size: 14.5px;
            line-height: 1.5;
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* 1. SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            padding: 24px 18px;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 22px;
            text-decoration: none;
        }

        .brand-logo-sq {
            width: 42px;
            height: 42px;
            background: var(--primary);
            color: #ffffff;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
            transition: transform 0.2s ease;
        }

        .brand-box:hover .brand-logo-sq {
            transform: rotate(-5deg) scale(1.05);
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .menu-group { margin-bottom: 22px; }
        
        .menu-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-muted);
            margin-bottom: 8px;
            padding-left: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.15s ease;
            margin-bottom: 4px;
        }

        .menu-item i {
            font-size: 16px;
            color: var(--text-muted);
            transition: color 0.15s ease;
        }

        .menu-item:hover {
            background-color: var(--primary-light);
            color: var(--primary-hover);
        }

        .menu-item:hover i {
            color: var(--primary-hover);
        }

        .menu-item.active {
            background-color: var(--primary);
            color: #ffffff;
        }

        .menu-item.active i {
            color: #ffffff;
        }

        /* Box Pemilih Warna Tema */
        .color-picker-card {
            margin-top: auto;
            padding: 14px 16px;
            background: var(--primary-light);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
        }

        .color-picker-card h4 {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .color-picker-options {
            display: flex;
            gap: 8px;
        }

        .color-btn {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 2px solid white;
            cursor: pointer;
            box-shadow: 0 0 0 1px #cbd5e1;
            transition: transform 0.15s ease;
        }

        .color-btn:hover { transform: scale(1.18); }

        /* 2. MAIN WRAPPER */
        .main-wrapper {
            margin-left: 260px;
            flex: 1;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            gap: 22px;
            min-width: 0;
        }

        /* Header Bar */
        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 22px 26px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            gap: 16px;
            flex-wrap: wrap;
        }

        .header-title h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-title p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 13.5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
        }

        .btn-add:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: var(--text-dark);
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 13.5px;
            text-decoration: none;
            border: 1px solid var(--border-color);
            transition: all 0.15s ease;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
        }

        /* Banner Success */
        .alert-success {
            background: var(--success-light);
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Search Bar Komponen */
        .search-form {
            display: flex;
            align-items: center;
            position: relative;
            flex: 1;
            max-width: 420px;
        }

        .search-input {
            width: 100%;
            padding: 10px 16px 10px 38px;
            font-size: 13.5px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            background: #f8fafc;
            color: var(--text-dark);
            outline: none;
            transition: all 0.15s ease;
        }

        .search-input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            color: var(--text-muted);
            pointer-events: none;
            font-size: 14px;
        }

        .search-reset {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            padding: 4px;
            border-radius: 50%;
        }

        .search-reset:hover {
            color: var(--danger);
        }

        /* Level Badge */
        .level-badge {
            background: #f1f5f9;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .sidebar { width: 70px; padding: 16px 8px; }
            .brand-title, .brand-subtitle, .menu-title, .menu-item span, .color-picker-card, .brand-box div { display: none; }
            .brand-logo-sq { width: 36px; height: 36px; font-size: 16px; margin: 0 auto; }
            .main-wrapper { margin-left: 70px; padding: 16px; }
            .header-bar { flex-direction: column; align-items: flex-start; }
            .search-form { max-width: 100%; width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- 1. SIDEBAR NAVIGATION -->
    <aside class="sidebar">
        <a href="{{ route('favorites.index') }}" class="brand-box">
            <div class="brand-logo-sq">M</div>
            <div>
                <div class="brand-title">Magic Box</div>
                <div class="brand-subtitle">Belajar CRUD SMP <span class="level-badge">Lv 16</span></div>
            </div>
        </a>

        <div class="menu-group">
            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('favorites.index') }}" class="menu-item {{ request()->routeIs('favorites.index') || request()->routeIs('favorites.list') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Semua Favorit</span>
            </a>
            <a href="{{ route('favorite.create') }}" class="menu-item {{ request()->routeIs('favorite.create') || request()->routeIs('favorites.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Tambah Favorit</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-title">Kategori Harta</div>
            @php
                $sharedCategories = $categories ?? ['hobi', 'makanan', 'minuman'];
            @endphp
            @foreach($sharedCategories as $cat)
                <a href="{{ route('favorite.category', $cat) }}" class="menu-item {{ request()->is('kategori/'.$cat) ? 'active' : '' }}">
                    <i class="bi bi-tag-fill"></i>
                    <span>{{ ucfirst($cat) }}</span>
                </a>
            @endforeach
        </div>

        <!-- FITUR PILIH WARNA TEMA KUSTOM -->
        <div class="color-picker-card">
            <h4>Warna Tema</h4>
            <div class="color-picker-options">
                <button class="color-btn" style="background:#2563eb" onclick="setTheme('#2563eb', '#eff6ff')" title="Biru"></button>
                <button class="color-btn" style="background:#059669" onclick="setTheme('#059669', '#ecfdf5')" title="Hijau"></button>
                <button class="color-btn" style="background:#7c3aed" onclick="setTheme('#7c3aed', '#f5f3ff')" title="Ungu"></button>
                <button class="color-btn" style="background:#d97706" onclick="setTheme('#d97706', '#fffbeb')" title="Jingga"></button>
                <button class="color-btn" style="background:#db2777" onclick="setTheme('#db2777', '#fdf2f8')" title="Merah Muda"></button>
            </div>
        </div>
    </aside>

    <!-- 2. MAIN WRAPPER -->
    <main class="main-wrapper">

        <!-- Flash Message Success -->
        @if(session('success'))
            <div class="alert-success">
                <i class="bi bi-check-circle-fill" style="font-size: 18px;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- SweetAlert2 Modern Alert Dialog -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script Pengubah Warna Tema Kustom & Konfirmasi Hapus SweetAlert2 -->
    <script>
        function setTheme(primaryColor, lightColor) {
            document.documentElement.style.setProperty('--primary', primaryColor);
            document.documentElement.style.setProperty('--primary-hover', primaryColor);
            document.documentElement.style.setProperty('--primary-light', lightColor);
            localStorage.setItem('magicbox_theme_primary', primaryColor);
            localStorage.setItem('magicbox_theme_light', lightColor);
        }

        (function() {
            var p = localStorage.getItem('magicbox_theme_primary');
            var l = localStorage.getItem('magicbox_theme_light');
            if (p && l) {
                document.documentElement.style.setProperty('--primary', p);
                document.documentElement.style.setProperty('--primary-hover', p);
                document.documentElement.style.setProperty('--primary-light', l);
            }
        })();

        // Konfirmasi Hapus Interaktif SweetAlert2
        function confirmDelete(button) {
            const form = button.closest('form');
            Swal.fire({
                title: 'Hapus Harta Favorit?',
                text: "Harta ini akan dihapus permanen dari Magic Box!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="bi bi-trash-fill"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                borderRadius: '16px',
                customClass: {
                    popup: 'swal2-magic-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
