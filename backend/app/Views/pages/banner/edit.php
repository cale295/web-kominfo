<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --success: #059669;
        --warning: #d97706;
        --info: #0284c7;
        --danger: #dc2626;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    body {
        background-color: var(--gray-50);
    }

    /* Header Styles */
    .gov-header {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        border: 1px solid var(--gray-200);
        border-left: 4px solid var(--primary);
    }

    .gov-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .gov-header h1 i {
        color: var(--primary);
        margin-right: 10px;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 32px;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
    }

    .section-title i {
        color: var(--primary);
        margin-right: 10px;
        font-size: 1.25rem;
    }

    /* Form Controls */
    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 8px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label i {
        color: var(--primary);
        font-size: 1rem;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .form-text {
        color: var(--gray-500);
        font-size: 0.8125rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-text i {
        font-size: 0.875rem;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Image Preview */
    .image-preview-container {
        margin-bottom: 20px;
        padding: 20px;
        background: var(--gray-50);
        border-radius: 12px;
        border: 2px dashed var(--gray-300);
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
        border: 2px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.2s;
    }

    .current-image img:hover {
        border-color: var(--primary);
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
    }

    .image-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--success);
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
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
        background: var(--gray-100);
        border-radius: 12px;
        border: 2px dashed var(--gray-300);
        color: var(--gray-400);
    }

    .no-image-placeholder i {
        font-size: 3rem;
        margin-bottom: 8px;
    }

    .no-image-placeholder span {
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* File Input */
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
        justify-content: center;
        gap: 10px;
        padding: 12px 20px;
        background: var(--primary);
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
        font-size: 0.9375rem;
    }

    .file-input-label:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .file-input-label i {
        font-size: 1.125rem;
    }

    .file-name-display {
        margin-top: 12px;
        padding: 10px 14px;
        background: var(--gray-100);
        border-radius: 8px;
        color: var(--gray-700);
        font-size: 0.875rem;
        display: none;
        align-items: center;
        gap: 8px;
    }

    .file-name-display.show {
        display: flex;
    }

    .file-name-display i {
        color: var(--primary);
        font-size: 1rem;
    }

    /* Action Buttons */
    .action-buttons {
        padding-top: 24px;
        border-top: 2px solid var(--gray-200);
        margin-top: 32px;
    }

    .btn {
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9375rem;
        transition: all 0.2s;
        border: none;
    }

    .btn-primary {
        background: var(--primary);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-secondary {
        background: var(--gray-600);
    }

    .btn-secondary:hover {
        background: var(--gray-700);
        transform: translateY(-2px);
    }

    .btn i {
        margin-right: 6px;
    }

    /* Section Spacing */
    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid var(--gray-100);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
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
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .modal-close {
        position: absolute;
        top: -50px;
        right: 0;
        color: white;
        font-size: 2rem;
        font-weight: bold;
        cursor: pointer;
        background: var(--danger);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
        border: 2px solid white;
    }

    .modal-close:hover {
        background: #b91c1c;
        transform: rotate(90deg) scale(1.1);
    }

    /* Animations */
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

    /* Responsive */
    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .gov-header {
            padding: 20px;
        }

        .gov-header h1 {
            font-size: 1.375rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .current-image img,
        .no-image-placeholder {
            width: 100%;
            max-width: 250px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            margin: 4px 0 !important;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-pencil-square"></i>
                Edit Banner
            </h1>
        </div>
        <div>
            <a href="<?= site_url('banner') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Form Card -->
<div class="form-card">
    <form action="<?= site_url('banner/' . $banner['id_banner']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- SECTION: Informasi Dasar -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-info-circle"></i>
                Informasi Dasar
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">
                    <i class="bi bi-text-left"></i>
                    Judul Banner
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title"
                    class="form-control"
                    value="<?= esc($banner['title']) ?>"
                    placeholder="Contoh: Banner Promo Akhir Tahun"
                    required>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Masukkan judul yang menarik dan deskriptif
                </small>
            </div>

            <div class="mb-3">
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
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Opsional - Tambahkan deskripsi untuk informasi lebih lengkap
                </small>
            </div>
        </div>

        <!-- SECTION: Media & Gambar -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-images"></i>
                Media & Gambar
            </div>

            <!-- Gambar Saat Ini -->
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
                                Aktif
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
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Format: JPG, PNG, GIF | Maksimal: 5MB | Kosongkan jika tidak ingin mengubah
                </small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
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
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Pilih jenis konten banner
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category_banner" class="form-label">
                            <i class="bi bi-grid-3x3"></i>
                            Kategori Banner
                            <span class="text-danger">*</span>
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
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Tentukan posisi penempatan banner
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION: URL & Link -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-link-45deg"></i>
                URL & Link
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">
                    <i class="bi bi-link"></i>
                    URL Banner (Link Tujuan)
                </label>
                <input 
                    type="url" 
                    name="url" 
                    id="url"
                    class="form-control"
                    value="<?= esc($banner['url']) ?>"
                    placeholder="https://contoh.com">
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Opsional - Link yang akan dibuka saat banner diklik
                </small>
            </div>

            <div class="mb-3">
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
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Opsional - Khusus untuk banner video dari YouTube
                </small>
            </div>
        </div>

        <!-- SECTION: Pengaturan Publikasi -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-sliders"></i>
                Pengaturan Publikasi
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            <i class="bi bi-toggle-on"></i>
                            Status Publikasi
                            <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="0" <?= $banner['status'] == '0' ? 'selected' : '' ?>>
                                ✗ Unpublish - Tidak Ditampilkan
                            </option>
                            <option value="1" <?= $banner['status'] == '1' ? 'selected' : '' ?>>
                                ✓ Publish - Ditampilkan
                            </option>
                        </select>
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Status publikasi banner di halaman depan
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
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
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Angka kecil akan tampil lebih dahulu
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= site_url('banner') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
        </div>
    </form>
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
    modalImg.alt = imageName;
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