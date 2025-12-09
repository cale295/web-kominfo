<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    /* KONFIGURASI WARNA & VARIABEL */
    :root {
        --primary: #4f46e5;       /* Indigo Modern */
        --primary-hover: #4338ca;
        --bg-body: #f1f5f9;
        --card-bg: #ffffff;
        --input-bg: #f8fafc;      /* Background input default */
        --border-color: #e2e8f0;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --radius: 12px;           /* Sudut membulat */
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-dark);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* KARTU FORM (MODERN CARD) */
    .form-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        padding: 40px;
        max-width: 850px;
        margin: 40px auto;
        position: relative;
        overflow: hidden;
        border: 1px solid white;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--primary), #818cf8);
    }

    /* HEADER HALAMAN */
    .page-header {
        margin-bottom: 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
        letter-spacing: -0.5px;
    }

    /* STYLING INPUT & LABEL */
    .form-group { margin-bottom: 24px; }

    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 10px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-label i { color: var(--primary); opacity: 0.8; }

    .form-control, .form-select {
        background-color: var(--input-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 1rem;
        transition: all 0.25s ease;
        color: var(--text-dark);
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); 
        outline: none;
    }

    .form-text {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 6px;
        margin-left: 2px;
    }

    /* AREA UPLOAD GAMBAR */
    .upload-area {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        border-color: var(--primary);
        background: #eef2ff;
        transform: translateY(-2px);
    }

    .upload-icon-circle {
        width: 60px;
        height: 60px;
        background: #e0e7ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: var(--primary);
        transition: 0.3s;
    }
    
    .upload-area:hover .upload-icon-circle {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    /* ANIMASI */
    .media-input-group {
        display: none;
        animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* TOMBOL */
    .btn-submit {
        background: linear-gradient(135deg, var(--primary), #4338ca);
        color: white;
        padding: 14px 40px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
    }

    .btn-cancel {
        padding: 12px 24px;
        color: var(--text-muted);
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
        border-radius: 8px;
    }
    .btn-cancel:hover {
        background: #f1f5f9;
        color: var(--text-dark);
    }
    
    .text-required { color: #ef4444; margin-left: 3px; font-weight: bold; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="form-card">
        
        <div class="page-header">
            <div>
                <h1 class="page-title">Tambah Banner Baru</h1>
                <p class="text-muted m-0 mt-1">Lengkapi informasi di bawah untuk membuat banner.</p>
            </div>
            <a href="<?= site_url('banner') ?>" class="btn-cancel">
                <i class="bi bi-arrow-left me-1"></i> Batal
            </a>
        </div>

        <?= $this->include('layouts/alerts') ?>

        <form action="<?= site_url('banner') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="title" class="form-label">
                    <i class="bi bi-type-h1"></i> Judul Banner <span class="text-required">*</span>
                </label>
                <input type="text" name="title" id="title" class="form-control" 
                       placeholder="Contoh: Promo Diskon Akhir Tahun" value="<?= old('title') ?>" required>
            </div>

            <?php 
                // Cek apakah ada parameter dari Controller ($selected_kategori)
                // Atau cek old input jika terjadi error validasi
                $currentKat = $selected_kategori ?? old('category_banner');
                
                $namaKategori = [
                    1 => 'Banner Utama (Header)',
                    2 => 'Banner Popup',
                    3 => 'Banner Berita'
                ];
            ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="category_banner" class="form-label">
                            <i class="bi bi-layers"></i> Posisi Penempatan <span class="text-required">*</span>
                        </label>
                        
                        <?php if (!empty($currentKat) && isset($namaKategori[$currentKat])): ?>
                            <div class="p-3 bg-white border rounded d-flex align-items-center gap-3 shadow-sm" style="background-color: #f8fafc !important;">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                     <i class="bi bi-check-lg fw-bold" style="font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Posisi Terpilih Otomatis</small>
                                    <span class="fw-bold text-dark" style="font-size: 1rem;"><?= $namaKategori[$currentKat] ?></span>
                                </div>
                            </div>
                            <input type="hidden" name="category_banner" value="<?= $currentKat ?>">

                        <?php else: ?>
                            <select name="category_banner" id="category_banner" class="form-select" required>
                                <option value="">-- Pilih Posisi --</option>
                                <option value="1" <?= old('category_banner') == '1' ? 'selected' : '' ?>>Banner Utama (Header)</option>
                                <option value="2" <?= old('category_banner') == '2' ? 'selected' : '' ?>>Banner Popup</option>
                                <option value="3" <?= old('category_banner') == '3' ? 'selected' : '' ?>>Banner Berita</option>
                            </select>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sorting" class="form-label">
                            <i class="bi bi-sort-numeric-down"></i> Urutan
                        </label>
                        <input type="number" name="sorting" id="sorting" class="form-control" 
                               value="<?= old('sorting') ?>" min="1" placeholder="1">
                        <div class="form-text">Urutan prioritas (1 = Pertama).</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="media_type" class="form-label">
                    <i class="bi bi-collection-play"></i> Tipe Konten <span class="text-required">*</span>
                </label>
                <select name="media_type" id="media_type" class="form-select" required onchange="handleMediaType()">
                    <option value="">-- Pilih Jenis Media --</option>
                    <option value="image" <?= old('media_type') == 'image' ? 'selected' : '' ?>>Gambar / Foto</option>
                    <option value="video" <?= old('media_type') == 'video' ? 'selected' : '' ?>>Video Youtube</option>
                </select>
            </div>

            <div id="group_image" class="form-group media-input-group">
                <label class="form-label mb-2">Upload File Gambar <span class="text-required">*</span></label>
                <div class="upload-area" onclick="document.getElementById('image').click()">
                    <input type="file" name="image" id="image" accept="image/*" style="display:none" onchange="previewFileName()">
                    
                    <div class="upload-icon-circle">
                        <i class="bi bi-cloud-arrow-up fs-4"></i>
                    </div>
                    
                    <span id="file-label" class="fw-bold" style="color: var(--primary);">Klik area ini untuk memilih gambar</span>
                    <div class="text-muted small mt-2">Format: JPG, PNG (Max 2MB)</div>
                </div>
            </div>

            <div id="group_video" class="form-group media-input-group">
                <div class="p-4 bg-white border border-danger border-opacity-25 rounded-3 shadow-sm" style="background: #fef2f2;">
                    <label for="url_yt" class="form-label text-danger mb-2">
                        <i class="bi bi-youtube"></i> Link Video Youtube <span class="text-required">*</span>
                    </label>
                    <input type="url" name="url_yt" id="url_yt" class="form-control border-danger border-opacity-25" 
                           placeholder="https://youtube.com/watch?v=..." value="<?= old('url_yt') ?>"
                           style="background: white;">
                    <div class="form-text text-danger opacity-75">
                        <i class="bi bi-info-circle me-1"></i> Pastikan video berstatus Publik atau Tidak Terdaftar (Unlisted).
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <label for="url" class="form-label">
                    <i class="bi bi-link-45deg"></i> Link Redirect (Opsional)
                </label>
                <input type="url" name="url" id="url" class="form-control" 
                       placeholder="https://tujuannya.com" value="<?= old('url') ?>">
                <div class="form-text">Pengunjung akan diarahkan ke link ini jika mengklik banner.</div>
            </div>

            <div class="form-group">
                <label for="keterangan" class="form-label">
                    <i class="bi bi-text-paragraph"></i> Keterangan (Opsional)
                </label>
                <textarea name="keterangan" id="keterangan" rows="3" class="form-control" 
                          placeholder="Catatan tambahan..."><?= old('keterangan') ?></textarea>
            </div>

            <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top gap-3">
                <button type="submit" class="btn-submit">
                    Simpan Banner <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // Logic Show/Hide
    function handleMediaType() {
        const type = document.getElementById('media_type').value;
        const groupImage = document.getElementById('group_image');
        const inputImage = document.getElementById('image');
        const groupVideo = document.getElementById('group_video');
        const inputVideo = document.getElementById('url_yt');

        groupImage.style.display = 'none';
        groupVideo.style.display = 'none';
        inputImage.required = false;
        inputVideo.required = false;

        if (type === 'image') {
            groupImage.style.display = 'block';
            inputImage.required = true;
        } else if (type === 'video') {
            groupVideo.style.display = 'block';
            inputVideo.required = true;
        }
    }

    // Preview Filename
    function previewFileName() {
        const input = document.getElementById('image');
        const label = document.getElementById('file-label');
        if(input.files && input.files[0]) {
            label.innerText = "File Terpilih: " + input.files[0].name;
            label.style.color = "#059669"; 
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        handleMediaType();
    });
</script>

<?= $this->endSection() ?>