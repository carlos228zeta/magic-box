@extends('layouts.app')

@section('title', 'Magic Box - Edit Data Favorit')

@push('styles')
<style>
    .content-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
        align-items: start;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        padding: 28px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .form-header {
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .form-header h2 {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-dark);
    }

    .form-header p {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-select, .form-input, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-color);
        background: #f8fafc;
        color: var(--text-dark);
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: all 0.15s ease;
    }

    .form-select:focus, .form-input:focus, .form-textarea:focus {
        background: #ffffff;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Upload & Existing Image Styling */
    .current-image-box {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        margin-bottom: 12px;
    }

    .current-image-thumb {
        width: 64px;
        height: 64px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }

    .file-upload-box {
        border: 2px dashed var(--border-color);
        border-radius: var(--radius-sm);
        padding: 18px;
        text-align: center;
        background: #fbfcfe;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .file-upload-box:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .file-upload-icon {
        font-size: 28px;
        color: var(--primary);
        margin-bottom: 4px;
    }

    .image-preview-container {
        margin-top: 12px;
        display: none;
        position: relative;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid var(--border-color);
        max-height: 200px;
    }

    .image-preview-container img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        background: var(--gold-light);
        border: 1px solid #fde68a;
        border-radius: var(--radius-sm);
        cursor: pointer;
    }

    .checkbox-group input {
        width: 18px;
        height: 18px;
        accent-color: var(--gold);
        cursor: pointer;
    }

    .checkbox-group label {
        font-size: 13.5px;
        font-weight: 700;
        color: #92400e;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 26px;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--warning);
        color: white;
        padding: 11px 22px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-submit:hover {
        background: #b45309;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        background: #ffffff;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        padding: 11px 20px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-cancel:hover { background: #f1f5f9; }

    .alert-error {
        background: var(--danger-light);
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 14px 18px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        margin-bottom: 20px;
    }

    .alert-error ul { margin-left: 20px; margin-top: 6px; }

    .info-card {
        background: #ffffff;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        padding: 24px;
    }

    .info-title {
        font-size: 14.5px;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-item {
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-color);
    }

    .info-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }

    .info-item h4 {
        font-size: 13px;
        font-weight: 700;
        color: var(--warning);
        margin-bottom: 3px;
    }

    .info-item p {
        font-size: 12.5px;
        color: var(--text-muted);
        line-height: 1.45;
    }

    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

    <!-- Header Bar -->
    <div class="header-bar">
        <div class="header-title">
            <div>
                <h1>
                    <span>Edit Data Favorit</span>
                    <span class="level-badge">ID: #{{ $favorite->id }}</span>
                </h1>
                <p>Ubah teks, kategori, ganti foto atau kelola pin bintang untuk harta kesukaan ini.</p>
            </div>
        </div>

        <div class="header-actions">
            <a href="{{ route('favorites.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">

        <!-- Form Edit Data (Dengan enctype multipart/form-data) -->
        <div class="form-card">
            <div class="form-header">
                <h2>Formulir Ubah Harta</h2>
                <p>Pastikan data yang diperbarui sudah benar sebelum menekan tombol simpan.</p>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    <strong>Ada kesalahan pengisian data:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('favorites.update', $favorite->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Field Kategori -->
                <div class="form-group">
                    <label for="kategori" class="form-label">Kategori Harta</label>
                    <select name="kategori" id="kategori" class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('kategori', $favorite->kategori) == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                        <option value="baru">+ Kategori Baru...</option>
                    </select>
                </div>

                <!-- Field Kategori Baru -->
                <div class="form-group" id="kategori-baru-box" style="display: none;">
                    <label for="kategori_baru" class="form-label">Nama Kategori Baru</label>
                    <input type="text" name="kategori_baru" id="kategori_baru" class="form-input" placeholder="Contoh: game, anime, pelajaran, musik" value="{{ old('kategori_baru') }}">
                </div>

                <!-- Field Isi Favorit -->
                <div class="form-group">
                    <label for="isi" class="form-label">Isi Harta Favorit</label>
                    <textarea name="isi" id="isi" class="form-textarea" required>{{ old('isi', $favorite->isi) }}</textarea>
                </div>

                <!-- Field Upload / Ganti Gambar -->
                <div class="form-group">
                    <label class="form-label">Foto / Gambar Favorit</label>

                    @if($favorite->gambar_url)
                        <div class="current-image-box">
                            <img src="{{ $favorite->gambar_url }}" alt="Foto Saat Ini" class="current-image-thumb">
                            <div style="flex: 1;">
                                <div style="font-size: 13px; font-weight: 700; color: var(--text-dark);">Foto Saat Ini</div>
                                <label style="font-size: 12px; color: #dc2626; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; margin-top: 4px;">
                                    <input type="checkbox" name="hapus_gambar" value="1">
                                    <span>Hapus foto saat ini</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="gambar" id="gambar" accept="image/*" style="display: none;" onchange="handleImagePreview(this)">
                    
                    <div class="file-upload-box" onclick="document.getElementById('gambar').click()">
                        <div class="file-upload-icon"><i class="bi bi-image"></i></div>
                        <div style="font-size: 13px; font-weight: 600; color: var(--text-dark);">
                            {{ $favorite->gambar ? 'Klik untuk mengganti foto...' : 'Klik untuk mengunggah foto...' }}
                        </div>
                        <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 2px;">Format: JPG, PNG, WEBP (Maks 2 MB)</div>
                    </div>

                    <div class="image-preview-container" id="preview-box">
                        <img id="image-preview" src="#" alt="Preview Foto Baru">
                    </div>
                </div>

                <!-- Field Bintang / Pin Favorit -->
                <div class="form-group">
                    <div class="checkbox-group" onclick="document.getElementById('is_pinned').click()">
                        <input type="checkbox" name="is_pinned" id="is_pinned" value="1" {{ old('is_pinned', $favorite->is_pinned) ? 'checked' : '' }} onclick="event.stopPropagation()">
                        <label for="is_pinned">
                            <i class="bi bi-star-fill" style="color: var(--gold);"></i>
                            <span>Sematkan sebagai Favorit Utama (Tampil Paling Atas ⭐)</span>
                        </label>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="btn-group">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check2-circle"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                    <a href="{{ route('favorites.index') }}" class="btn-cancel">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Alur Belajar -->
        <div class="info-card">
            <div class="info-title">
                <i class="bi bi-question-circle-fill" style="color: var(--warning);"></i>
                <span>Catatan Belajar Update File</span>
            </div>
            <div class="info-item">
                <h4>1. Penanganan File Lama</h4>
                <p>Saat foto baru diunggah, controller menggunakan <code>Storage::disk('public')->delete(...)</code> untuk menghapus foto lama agar penyimpanan server tetap hemat.</p>
            </div>
            <div class="info-item">
                <h4>2. Method Spoofing @method('PUT')</h4>
                <p>Laravel menerima request bertipe <code>PUT</code> melalui bantuan input hidden yang disisipkan oleh Blade.</p>
            </div>
            <div class="info-item">
                <h4>3. Toggle Hapus Foto</h4>
                <p>Pengguna dapat memilih menghapus foto tanpa harus menghapus teks harta favoritnya.</p>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var selectKategori = document.getElementById('kategori');
        var boxKategoriBaru = document.getElementById('kategori-baru-box');
        var inputKategoriBaru = document.getElementById('kategori_baru');

        function cekKategori() {
            if (selectKategori.value === 'baru') {
                boxKategoriBaru.style.display = 'block';
                inputKategoriBaru.setAttribute('required', 'required');
            } else {
                boxKategoriBaru.style.display = 'none';
                inputKategoriBaru.removeAttribute('required');
            }
        }

        cekKategori();
        selectKategori.addEventListener('change', cekKategori);
    });

    function handleImagePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('preview-box').style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
