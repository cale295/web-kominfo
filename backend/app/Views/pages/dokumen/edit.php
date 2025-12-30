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

    /* Alert Styling */
    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    .alert-danger ul { margin: 0; padding-left: 1.25rem; }

    /* Form Elements */
    .form-group { margin-bottom: 1.5rem; }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.9rem;
    }

    .input-wrapper { position: relative; }

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

    /* Current File Display */
    .current-file-box {
        background: #f8fafc;
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-main);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .btn-view {
        font-size: 0.8rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        background: #eff6ff;
        border-radius: 4px;
        transition: background 0.2s;
    }
    .btn-view:hover { background: #dbeafe; }

    /* File Upload Box */
    .file-upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 1.25rem;
        text-align: center;
        background: #fff;
        transition: all 0.2s;
        position: relative;
    }

    .file-upload-box:hover {
        border-color: var(--primary);
        background: #f8fafc;
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

    .upload-label {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .upload-icon { color: var(--text-muted); margin-bottom: 0.25rem; }

    /* Actions */
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

    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }

    .btn-secondary { background: white; color: var(--text-muted); border: 1px solid var(--border); }
    .btn-secondary:hover { background: #f8fafc; color: var(--text-main); border-color: #cbd5e1; }
</style>

<div class="form-page">

    <div class="header-section">
        <h3><?= esc($title) ?></h3>
        <div class="folder-badge">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            <?= esc($dokumen['nama_folder']) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <?php if ($validation->getErrors()) : ?>
                <div class="alert alert-danger">
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">Gagal menyimpan data</div>
                    <ul>
                        <?php foreach ($validation->getErrors() as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form
                action="<?= site_url("informasi-publik/$slug/update/" . $dokumen['id_document']) ?>"
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
                            value="<?= old('nama_dokumen', $dokumen['nama_dokumen']) ?>"
                            required
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
                            value="<?= old('tahun', $dokumen['tahun']) ?>"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">File Saat Ini</label>
                    <div class="current-file-box">
                        <div class="file-info">
                            <svg width="24" height="24" style="color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <?php if ($dokumen['file_path']) : ?>
                                <span>File Tersimpan</span>
                            <?php else : ?>
                                <span class="text-muted">Tidak ada file</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($dokumen['file_path']) : ?>
                            <a href="<?= base_url('uploads/dokumen/' . $dokumen['file_path']) ?>" target="_blank" class="btn-view">
                                Lihat / Download
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="file_upload" class="form-label">Ganti File (Opsional)</label>
                    <div class="file-upload-box">
                        <input
                            type="file"
                            name="file_upload"
                            id="file_upload"
                            accept=".pdf,.doc,.docx,.xls,.xlsx"
                            onchange="updateFileName(this)"
                        >
                        <div class="upload-icon">
                            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div class="upload-label" id="file-label">
                            Klik untuk mengganti file
                        </div>
                    </div>
                    <small style="display:block; margin-top:0.5rem; color:#94a3b8; font-size: 0.8rem;">
                        Biarkan kosong jika tidak ingin mengubah file saat ini.
                    </small>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url("informasi-publik/$slug") ?>" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files && input.files.length > 0) {
            label.textContent = input.files[0].name;
            label.style.color = '#2563eb';
            label.style.fontWeight = '600';
        } else {
            label.textContent = 'Klik untuk mengganti file';
            label.style.color = '#64748b';
            label.style.fontWeight = 'normal';
        }
    }
</script>

<?= $this->endSection() ?>