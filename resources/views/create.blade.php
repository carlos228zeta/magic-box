@extends('layouts.app')

@section('title', 'Magic Box - Tambah Favorit Baru')

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

    /* Upload Gambar Box Level 17 */
    .file-upload-box {
        border: 2px dashed var(--border-color);
        border-radius: var(--radius-sm);
        padding: 20px;
        text-align: center;
        background: #fbfcfe;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .file-upload-box:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .file-upload-icon {
        font-size: 32px;
        color: var(--primary);
        margin-bottom: 6px;
    }

    .file-upload-text {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .file-upload-subtext {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .image-preview-container {
        margin-top: 14px;
        display: none;
        position: relative;
        border-radius: var(--radius-sm);
        overflow: hidden;
        border: 1px solid var(--border-color);
        max-height: 220px;
    }

    .image-preview-container img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .btn-remove-preview {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(220, 38, 38, 0.85);
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
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
        background: var(--primary);
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
        background: var(--primary-hover);
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

    /* Alert Error */
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

    /* Info Card */
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
        color: var(--primary);
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
                    <span>Tambah Favorit Baru</span>
                    <span class="level-badge">Level 17</span>
                </h1>
                <p>Isi formulir dan lampirkan foto kesukaanmu ke dalam database <code>magicbox</code>.</p>
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

        <!-- Form Tambah Data (Dengan enctype multipart/form-data) -->
        <div class="form-card">
            <div class="form-header">
                <h2>Formulir Harta Favorit</h2>
                <p>Data beserta file foto akan disimpan otomatis ke Storage Laravel.</p>
            </div>

            @if($errors->any())
                <div class="alert-error">
                    <strong>Ada kolom yang belum terisi dengan benar:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('favorite.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Field Kategori -->
                <div class="form-group">
                    <label for="kategori" class="form-label">Kategori Harta</label>
                    <select name="kategori" id="kategori" class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('kategori') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                        <option value="baru" {{ old('kategori') == 'baru' ? 'selected' : '' }}>+ Kategori Baru...</option>
                    </select>
                </div>

                <!-- Field Kategori Baru -->
                <div class="form-group" id="kategori-baru-box" style="display: none;">
                    <label for="kategori_baru" class="form-label">Nama Kategori Baru</label>
                    <input type="text" name="kategori_baru" id="kategori_baru" class="form-input" placeholder="Contoh: game, film, anime, pelajaran, musik" value="{{ old('kategori_baru') }}">
                </div>

                <!-- Field Isi Favorit -->
                <div class="form-group">
                    <label for="isi" class="form-label">Isi Harta Favorit</label>
                    <textarea name="isi" id="isi" class="form-textarea" placeholder="Contoh: Bermain game Minecraft bersama teman-teman setiap sore" required>{{ old('isi') }}</textarea>
                </div>

                <!-- Field Upload Gambar Level 17 -->
                <div class="form-group">
                    <label class="form-label">Foto / Gambar (Opsional)</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*" style="display: none;" onchange="handleImagePreview(this)">
                    
                    <div class="file-upload-box" onclick="document.getElementById('gambar').click()">
                        <div class="file-upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                        <div class="file-upload-text">Klik untuk memilih foto dari komputer</div>
                        <div class="file-upload-subtext">Format: JPG, PNG, WEBP, GIF (Maksimal 2 MB)</div>
                    </div>

                    <div class="image-preview-container" id="preview-box">
                        <img id="image-preview" src="#" alt="Preview Foto">
                        <button type="button" class="btn-remove-preview" onclick="removeImagePreview()" title="Hapus Foto">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>

                <!-- Field Bintang / Pin Favorit -->
                <div class="form-group">
                    <div class="checkbox-group" onclick="document.getElementById('is_pinned').click()">
                        <input type="checkbox" name="is_pinned" id="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} onclick="event.stopPropagation()">
                        <label for="is_pinned">
                            <i class="bi bi-star-fill" style="color: var(--gold);"></i>
                            <span>Sematkan sebagai Favorit Utama (Tampil Paling Atas ⭐)</span>
                        </label>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="btn-group">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        <span>Simpan Harta</span>
                    </button>
                    <a href="{{ route('favorites.index') }}" class="btn-cancel">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Alur Belajar Level 17 -->
        <div class="info-card">
            <div class="info-title">
                <i class="bi bi-lightbulb-fill" style="color: var(--warning);"></i>
                <span>Catatan Belajar Level 17</span>
            </div>
            <div class="info-item">
                <h4>1. enctype="multipart/form-data"</h4>
                <p>Wajib dipasang pada tag <code>&lt;form&gt;</code> agar browser bisa mengirim berkas biner gambar ke server.</p>
            </div>
            <div class="info-item">
                <h4>2. Storage Disk Laravel</h4>
                <p>Gambar disimpan di <code>storage/app/public/favorites</code> dan dihubungkan ke folder <code>public/storage</code> lewat <code>php artisan storage:link</code>.</p>
            </div>
            <div class="info-item">
                <h4>3. Validasi File</h4>
                <p>Controller memastikan file benar-benar gambar dengan rule <code>image|mimes:jpeg,png,webp|max:2048</code>.</p>
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

    function removeImagePreview() {
        var input = document.getElementById('gambar');
        input.value = '';
        document.getElementById('preview-box').style.display = 'none';
        document.getElementById('image-preview').src = '#';
    }
</script>
@endpush
