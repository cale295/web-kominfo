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

    /* Current File Display */
    .current-file {
        margin-top: 12px;
        padding: 12px 16px;
        background: var(--gray-100);
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .current-file i {
        color: var(--success);
        font-size: 1.25rem;
    }

    .current-file-text {
        flex: 1;
    }

    .current-file-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .current-file-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.875rem;
    }

    .current-file-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
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
                Edit Dokumen
            </h1>
        </div>
        <div>
            <a href="<?= base_url('dokument') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Form Card -->
<div class="form-card">
    <form action="<?= base_url('dokument/' . $dokument['id_document']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- SECTION: Informasi Dokumen -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-info-circle"></i>
                Informasi Dokumen
            </div>

            <div class="mb-3">
                <label for="document_name" class="form-label">
                    <i class="bi bi-file-text"></i>
                    Nama Dokumen
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    name="document_name" 
                    id="document_name"
                    class="form-control"
                    value="<?= old('document_name', $dokument['document_name']) ?>"
                    placeholder="Masukkan nama dokumen"
                    required>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Nama dokumen yang akan ditampilkan
                </small>
            </div>

            <div class="mb-3">
                <label for="id_document_category" class="form-label">
                    <i class="bi bi-folder"></i>
                    Kategori Dokumen
                    <span class="text-danger">*</span>
                </label>
                <select 
                    name="id_document_category" 
                    id="id_document_category"
                    class="form-select"
                    required>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_document_category'] ?>"
                            <?= $k['id_document_category'] == $dokument['id_document_category'] ? 'selected' : '' ?>>
                            <?= esc($k['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Pilih kategori yang sesuai dengan jenis dokumen
                </small>
            </div>
        </div>

        <!-- SECTION: File Dokumen -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-cloud-upload"></i>
                File Dokumen
            </div>

            <!-- Current File Display -->
            <?php if (!empty($dokument['file_path'])): ?>
                <div class="current-file">
                    <i class="bi bi-file-earmark-check-fill"></i>
                    <div class="current-file-text">
                        <div class="current-file-label">File Saat Ini</div>
                        <a href="<?= base_url($dokument['file_path']) ?>" 
                           target="_blank" 
                           class="current-file-link">
                            <i class="bi bi-download"></i>
                            Lihat File
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Upload New File -->
            <div class="mb-3 mt-3">
                <label for="file" class="form-label">
                    <i class="bi bi-arrow-repeat"></i>
                    Ganti File Dokumen
                </label>
                <div class="file-input-wrapper">
                    <div class="file-input-custom">
                        <input 
                            type="file" 
                            name="file" 
                            id="file"
                            accept=".pdf,.doc,.docx,.xls,.xlsx"
                            onchange="displayFileName(this)">
                        <label for="file" class="file-input-label">
                            <i class="bi bi-cloud-upload"></i>
                            <span>Pilih File Baru (Opsional)</span>
                        </label>
                    </div>
                    <div class="file-name-display" id="fileNameDisplay">
                        <i class="bi bi-file-earmark-check"></i>
                        <span id="fileName"></span>
                    </div>
                </div>
                <small class="form-text">
                    <i class="bi bi-info-circle"></i>
                    Format: PDF, DOC, DOCX, XLS, XLSX | Maksimal: 10MB | Kosongkan jika tidak ingin mengubah
                </small>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= base_url('dokument') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Update Dokumen
            </button>
        </div>
    </form>
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
</script>

<?= $this->endSection() ?>