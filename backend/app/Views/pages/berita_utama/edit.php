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

    /* Image Preview */
    .preview-container {
        margin-top: 20px;
        padding: 20px;
        background: var(--gray-50);
        border-radius: 12px;
        border: 2px dashed var(--gray-300);
        text-align: center;
    }

    .preview-container img {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
        border-radius: 12px;
        border: 2px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .preview-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-600);
        margin-bottom: 12px;
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

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            margin: 4px 0 !important;
        }

        .preview-container img {
            max-height: 200px;
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
                Edit Berita Utama
            </h1>
        </div>
        <div>
            <a href="<?= site_url('berita-utama') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Form Card -->
<div class="form-card">
    <form action="<?= site_url('berita-utama/' . $utama['id_berita_utama']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- SECTION: Pilih Berita -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-newspaper"></i>
                Pilih Berita
            </div>

            <div class="mb-3">
                <label for="id_berita" class="form-label">
                    <i class="bi bi-file-text"></i>
                    Berita
                    <span class="text-danger">*</span>
                </label>
                <select name="id_berita" id="id_berita" class="form-select" required>
                    <?php foreach ($beritaList as $b): ?>
                        <option 
                            value="<?= $b['id_berita'] ?>" 
                            data-image="<?= base_url($b['feat_image']) ?>"
                            <?= $b['id_berita'] == $utama['id_berita'] ? 'selected' : '' ?>>
                            <?= esc($b['judul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Pilih berita yang akan ditampilkan sebagai berita utama
                </small>
            </div>

            <!-- Preview Gambar -->
            <div id="preview-wrapper" class="preview-container">
                <span class="preview-label">
                    <i class="bi bi-eye"></i> Preview Gambar Berita
                </span>
                <img 
                    id="preview-image" 
                    src="<?= base_url($utama['feat_image']) ?>" 
                    alt="Preview Gambar">
            </div>
        </div>

        <!-- SECTION: Pengaturan -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-sliders"></i>
                Pengaturan
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis" class="form-label">
                            <i class="bi bi-sort-numeric-down"></i>
                            Jenis / Urutan
                        </label>
                        <input 
                            type="number" 
                            name="jenis" 
                            id="jenis"
                            class="form-control" 
                            value="<?= esc($utama['jenis']) ?>"
                            placeholder="Contoh: 1"
                            min="1">
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Angka kecil akan tampil lebih dahulu (1 = headline utama)
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            <i class="bi bi-toggle-on"></i>
                            Status Publikasi
                            <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="1" <?= $utama['status'] == 1 ? 'selected' : '' ?>>
                                ✓ Aktif - Ditampilkan
                            </option>
                            <option value="0" <?= $utama['status'] == 0 ? 'selected' : '' ?>>
                                ✗ Nonaktif - Tidak Ditampilkan
                            </option>
                        </select>
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Status publikasi berita utama
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= site_url('berita-utama') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Update Berita Utama
            </button>
        </div>
    </form>
</div>

<script>
// Preview gambar saat dropdown berubah
const idBerita = document.getElementById('id_berita');
const previewImage = document.getElementById('preview-image');

idBerita.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const imageSrc = selectedOption.getAttribute('data-image');
    
    if (imageSrc) {
        previewImage.src = imageSrc;
    } else {
        previewImage.src = '';
    }
});
</script>

<?= $this->endSection() ?>