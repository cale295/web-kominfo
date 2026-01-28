<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border: #e2e8f0;
        --radius: 8px;
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --bg-input: #fff;
    }

    .form-page {
        max-width: 600px;
        margin: 3rem auto;
        padding: 0 1rem;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .header-section {
        text-align: center;
        margin-bottom: 2rem;
    }

    .header-section h3 {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .folder-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #eff6ff;
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        border: 1px solid #dbeafe;
    }

    .card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-body {
        padding: 2rem;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    .alert-danger ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.9rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        font-size: 0.95rem;
        color: var(--text-main);
        background: var(--bg-input);
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* File Upload Styling */
    .file-upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        background: #f8fafc;
        transition: all 0.2s;
        position: relative;
    }

    .file-upload-box:hover {
        border-color: var(--primary);
        background: #eff6ff;
    }

    .file-upload-box.has-file {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .file-upload-box input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon-wrapper {
        margin-bottom: 0.5rem;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-icon {
        color: var(--primary);
        transition: all 0.3s ease;
    }

    .upload-icon.has-file {
        color: #10b981;
    }

    .upload-text {
        font-weight: 500;
        color: var(--text-main);
        margin-bottom: 0.25rem;
        transition: all 0.3s ease;
    }

    .upload-text.has-file {
        color: #10b981;
        font-weight: 600;
    }

    .upload-hint {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 2rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        flex: 1;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: white;
        color: var(--text-muted);
        border: 1px solid var(--border);
    }
    .btn-secondary:hover {
        background: #f8fafc;
        color: var(--text-main);
        border-color: #cbd5e1;
    }

    /* Success color for uploaded state */
    .success-color {
        color: #10b981;
    }
</style>

<div class="form-page">

    <div class="header-section">
        <h3><?= esc($title) ?></h3>
        <div class="folder-badge">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            <?= esc($nama_folder) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <?php if ($validation->getErrors()) : ?>
                <div class="alert alert-danger">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; font-weight: 600;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Terjadi Kesalahan
                    </div>
                    <ul>
                        <?php foreach ($validation->getErrors() as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form
                action="<?= site_url("informasi-publik/$slug/dokumen/store/" . urlencode($nama_folder)) ?>"
                method="post"
                enctype="multipart/form-data"
            >
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </span>
                        <input
                            type="text"
                            name="nama_dokumen"
                            id="nama_dokumen"
                            class="form-control"
                            value="<?= old('nama_dokumen') ?>"
                            placeholder="Contoh: Laporan Keuangan Semester 1"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="tahun" class="form-label">Tahun</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </span>
                        <input
                            type="number"
                            name="tahun"
                            id="tahun"
                            class="form-control"
                            value="<?= old('tahun') ?>"
                            placeholder="YYYY (Misal: 2024)"
                            min="2000"
                            max="2099"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="file_upload" class="form-label">File Dokumen</label>
                    <div class="file-upload-box" id="file-upload-container">
                        <input
                            type="file"
                            name="file_upload"
                            id="file_upload"
                            accept=".pdf,.doc,.docx,.xls,.xlsx"
                            onchange="updateFileName(this)"
                            required
                        >
                        <div class="upload-icon-wrapper">
                            <!-- Default upload icon -->
                            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="upload-default-icon" class="upload-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <!-- Success/check icon (hidden by default) -->
                            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="upload-success-icon" class="upload-icon" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="upload-text" id="file-label">Klik atau Tarik File ke Sini</div>
                        <div class="upload-hint">Format: PDF, Word, Excel (Maks. 5MB)</div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url("informasi-publik/$slug") ?>" class="btn btn-secondary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload Dokumen
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        const uploadDefaultIcon = document.getElementById('upload-default-icon');
        const uploadSuccessIcon = document.getElementById('upload-success-icon');
        const container = document.getElementById('file-upload-container');
        const uploadIconWrapper = container.querySelector('.upload-icon-wrapper');
        
        if (input.files && input.files.length > 0) {
            const fileName = input.files[0].name;
            label.textContent = fileName;
            label.classList.add('has-file');
            uploadDefaultIcon.classList.add('has-file');
            uploadSuccessIcon.classList.add('has-file');
            container.classList.add('has-file');
            
            // Switch icons
            uploadDefaultIcon.style.display = 'none';
            uploadSuccessIcon.style.display = 'block';
            
            // Pastikan icon wrapper tetap terpusat
            uploadIconWrapper.style.display = 'flex';
            uploadIconWrapper.style.alignItems = 'center';
            uploadIconWrapper.style.justifyContent = 'center';
            
            // Tambahkan info ukuran file jika tersedia
            const fileSize = input.files[0].size;
            const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);
            
            // Update hint dengan info file
            const hintElement = container.querySelector('.upload-hint');
            hintElement.innerHTML = `Format: PDF, Word, Excel (Maks. 5MB)<br><span style="font-size: 0.7rem; color: #10b981;">Ukuran: ${fileSizeMB} MB</span>`;
            
        } else {
            label.textContent = 'Klik atau Tarik File ke Sini';
            label.classList.remove('has-file');
            uploadDefaultIcon.classList.remove('has-file');
            uploadSuccessIcon.classList.remove('has-file');
            container.classList.remove('has-file');
            
            // Switch icons kembali
            uploadDefaultIcon.style.display = 'block';
            uploadSuccessIcon.style.display = 'none';
            
            // Reset hint
            const hintElement = container.querySelector('.upload-hint');
            hintElement.textContent = 'Format: PDF, Word, Excel (Maks. 5MB)';
        }
    }
    
    // Optional: Drag and drop functionality
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file_upload');
        const container = document.getElementById('file-upload-container');
        
        // Highlight when dragging over
        container.addEventListener('dragover', function(e) {
            e.preventDefault();
            container.style.borderColor = 'var(--primary)';
            container.style.background = '#eff6ff';
        });
        
        // Remove highlight when not dragging
        container.addEventListener('dragleave', function(e) {
            e.preventDefault();
            if (!container.classList.contains('has-file')) {
                container.style.borderColor = '#cbd5e1';
                container.style.background = '#f8fafc';
            }
        });
        
        // Handle drop
        container.addEventListener('drop', function(e) {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                updateFileName(fileInput);
            }
        });
    });
</script>

<?= $this->endSection() ?>