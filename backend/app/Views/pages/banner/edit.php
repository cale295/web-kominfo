<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary-blue: #1e40af;
        --secondary-blue: #1e3a8a;
        --accent-gold: #fbbf24;
        --light-gold: #fcd34d;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 8px 24px rgba(30, 64, 175, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
    }

    .page-header h3 {
        color: white;
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h3 i {
        color: var(--accent-gold);
        font-size: 2rem;
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
        font-size: 0.95rem;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 12px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateX(-4px);
    }

    .btn-back i {
        font-size: 1.1rem;
    }

    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-body {
        padding: 40px;
    }

    .form-label {
        color: var(--primary-blue);
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label i {
        color: var(--accent-gold);
        font-size: 1.1rem;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 4px;
    }

    .form-control,
    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.1);
        background: white;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-text-helper {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-text-helper i {
        color: var(--accent-gold);
        font-size: 0.9rem;
    }

    /* Image Preview */
    .image-preview-container {
        margin-bottom: 16px;
        padding: 16px;
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(251, 191, 36, 0.05) 100%);
        border-radius: 12px;
        border: 2px dashed rgba(251, 191, 36, 0.3);
    }

    .current-image {
        position: relative;
        display: inline-block;
    }

    .current-image img {
        width: 300px;
        height: auto;
        max-height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid var(--accent-gold);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .current-image img:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
    }

    .image-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%);
        color: var(--primary-blue);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.4);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .no-image-placeholder {
        width: 300px;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
        color: #94a3b8;
    }

    .no-image-placeholder i {
        font-size: 3rem;
        margin-bottom: 8px;
    }

    .no-image-placeholder span {
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* File Input Custom */
    .file-input-wrapper {
        position: relative;
    }

    .file-input-custom {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-custom input[type="file"] {
        position: absolute;
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(30, 64, 175, 0.3);
    }

    .file-input-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
    }

    .file-input-label i {
        font-size: 1.2rem;
    }

    .file-name-display {
        margin-top: 10px;
        padding: 10px 14px;
        background: rgba(30, 64, 175, 0.08);
        border-radius: 8px;
        color: var(--primary-blue);
        font-size: 0.9rem;
        display: none;
    }

    .file-name-display.show {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .file-name-display i {
        color: var(--accent-gold);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 14px 32px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(30, 64, 175, 0.3);
        transition: all 0.3s ease;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(251, 191, 36, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        color: white;
    }

    .btn-primary-custom:hover::before {
        left: 100%;
    }

    .btn-secondary-custom {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 14px 32px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(100, 116, 139, 0.3);
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-secondary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        color: white;
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid #f1f5f9;
    }

    /* Image Modal */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
    }

    .image-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .image-modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        animation: zoomIn 0.3s ease;
    }

    .image-modal-content img {
        width: 100%;
        height: auto;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .modal-close {
        position: absolute;
        top: -45px;
        right: 0;
        color: white;
        font-size: 2rem;
        font-weight: bold;
        cursor: pointer;
        background: rgba(239, 68, 68, 0.9);
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        border: 3px solid white;
    }

    .modal-close:hover {
        background: #dc2626;
        transform: rotate(90deg) scale(1.1);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 24px;
        }

        .page-header h3 {
            font-size: 1.4rem;
        }

        .card-body {
            padding: 24px;
        }

        .current-image img,
        .no-image-placeholder {
            width: 100%;
            max-width: 250px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary-custom,
        .btn-secondary-custom {
            width: 100%;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="page-header-content">
                <h3>
                    <i class="bi bi-pencil-square"></i>
                    Edit Banner
                </h3>
                <p>Perbarui informasi banner yang sudah ada</p>
            </div>
            <a href="<?= site_url('banner') ?>" class="btn btn-back">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alerts -->
    <?= $this->include('layouts/alerts') ?>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('banner/' . $banner['id_banner']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <!-- Judul -->
                <div class="mb-4">
                    <label for="title" class="form-label">
                        <i class="bi bi-text-left"></i>
                        Judul Banner
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title"
                        class="form-control"
                        value="<?= esc($banner['title']) ?>"
                        placeholder="Contoh: Banner Promo Akhir Tahun"
                        required>
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Masukkan judul yang menarik dan deskriptif
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="form-label">
                        <i class="bi bi-text-paragraph"></i>
                        Keterangan Banner
                    </label>
                    <textarea 
                        name="keterangan" 
                        id="keterangan" 
                        rows="4"
                        class="form-control"
                        placeholder="Jelaskan detail tentang banner ini..."><?= esc($banner['keterangan']) ?></textarea>
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Opsional - Tambahkan deskripsi untuk informasi lebih lengkap
                    </div>
                </div>

                <!-- Gambar Sekarang -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-image"></i>
                        Gambar Banner Saat Ini
                    </label>
                    
                    <div class="image-preview-container">
                        <?php if (!empty($banner['image'])): ?>
                            <div class="current-image">
                                <img 
                                    src="<?= base_url('uploads/banner/' . $banner['image']) ?>" 
                                    alt="Banner"
                                    onclick="openImageModal(this.src, '<?= esc(addslashes($banner['title'])) ?>')"
                                    title="Klik untuk memperbesar">
                                <div class="image-badge">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Gambar Aktif
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                <i class="bi bi-image"></i>
                                <span>Belum ada gambar</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Ganti Gambar -->
                <div class="mb-4">
                    <label for="image" class="form-label">
                        <i class="bi bi-arrow-repeat"></i>
                        Ganti Gambar Banner
                    </label>
                    <div class="file-input-wrapper">
                        <div class="file-input-custom">
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*"
                                onchange="displayFileName(this)">
                            <label for="image" class="file-input-label">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Pilih Gambar Baru (Opsional)</span>
                            </label>
                        </div>
                        <div class="file-name-display" id="fileNameDisplay">
                            <i class="bi bi-file-earmark-image"></i>
                            <span id="fileName"></span>
                        </div>
                    </div>
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Format: JPG, PNG, GIF | Max: 5MB | Kosongkan jika tidak ingin mengubah
                    </div>
                </div>

                <!-- Row untuk Tipe Media & Kategori -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="media_type" class="form-label">
                                <i class="bi bi-film"></i>
                                Tipe Media
                            </label>
                            <select name="media_type" id="media_type" class="form-select">
                                <option value="">-- Pilih Tipe Media --</option>
                                <option value="image" <?= $banner['media_type'] == 'image' ? 'selected' : '' ?>>
                                    📷 Gambar
                                </option>
                                <option value="video" <?= $banner['media_type'] == 'video' ? 'selected' : '' ?>>
                                    🎥 Video
                                </option>
                            </select>
                            <div class="form-text-helper">
                                <i class="bi bi-info-circle"></i>
                                Pilih jenis konten banner
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="category_banner" class="form-label">
                                <i class="bi bi-grid-3x3"></i>
                                Kategori Banner
                                <span class="required">*</span>
                            </label>
                            <select name="category_banner" id="category_banner" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="1" <?= $banner['category_banner'] == '1' ? 'selected' : '' ?>>
                                    🏠 Banner Utama
                                </option>
                                <option value="2" <?= $banner['category_banner'] == '2' ? 'selected' : '' ?>>
                                    🪟 Banner Popup
                                </option>
                                <option value="3" <?= $banner['category_banner'] == '3' ? 'selected' : '' ?>>
                                    📰 Banner Berita
                                </option>
                            </select>
                            <div class="form-text-helper">
                                <i class="bi bi-info-circle"></i>
                                Tentukan posisi penempatan banner
                            </div>
                        </div>
                    </div>
                </div>

                <!-- URL Banner -->
                <div class="mb-4">
                    <label for="url" class="form-label">
                        <i class="bi bi-link-45deg"></i>
                        URL Banner (Link Tujuan)
                    </label>
                    <input 
                        type="url" 
                        name="url" 
                        id="url"
                        class="form-control"
                        value="<?= esc($banner['url']) ?>"
                        placeholder="https://contoh.com">
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Opsional - Link yang akan dibuka saat banner diklik
                    </div>
                </div>

                <!-- URL YouTube -->
                <div class="mb-4">
                    <label for="url_yt" class="form-label">
                        <i class="bi bi-youtube"></i>
                        URL YouTube (Jika Video)
                    </label>
                    <input 
                        type="url" 
                        name="url_yt" 
                        id="url_yt"
                        class="form-control"
                        value="<?= esc($banner['url_yt']) ?>"
                        placeholder="https://youtube.com/watch?v=...">
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Opsional - Khusus untuk banner video dari YouTube
                    </div>
                </div>

                <!-- Row untuk Status & Sorting -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="status" class="form-label">
                                <i class="bi bi-toggle-on"></i>
                                Status Publikasi
                                <span class="required">*</span>
                            </label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="0" <?= $banner['status'] == '0' ? 'selected' : '' ?>>
                                    ✗ Unpublish - Tidak Ditampilkan
                                </option>
                                <option value="1" <?= $banner['status'] == '1' ? 'selected' : '' ?>>
                                    ✓ Publish - Ditampilkan
                                </option>
                            </select>
                            <div class="form-text-helper">
                                <i class="bi bi-info-circle"></i>
                                Status publikasi banner di halaman depan
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="sorting" class="form-label">
                                <i class="bi bi-sort-numeric-down"></i>
                                Urutan Tampilan (Sorting)
                            </label>
                            <input 
                                type="number" 
                                name="sorting" 
                                id="sorting"
                                class="form-control"
                                value="<?= esc($banner['sorting']) ?>"
                                placeholder="1, 2, 3, ..."
                                min="1">
                            <div class="form-text-helper">
                                <i class="bi bi-info-circle"></i>
                                Angka kecil akan tampil lebih dahulu
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= site_url('banner') ?>" class="btn btn-secondary-custom">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <div class="image-modal-content" onclick="event.stopPropagation()">
        <span class="modal-close" onclick="closeImageModal()" title="Tutup">&times;</span>
        <img id="modalImage" src="" alt="Preview">
    </div>
</div>

<script>
function displayFileName(input) {
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileName = document.getElementById('fileName');
    
    if (input.files && input.files[0]) {
        fileName.textContent = input.files[0].name;
        fileNameDisplay.classList.add('show');
    } else {
        fileNameDisplay.classList.remove('show');
    }
}

function openImageModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    
    modal.classList.add('show');
    modalImg.src = imageSrc;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>

<?= $this->endSection() ?>