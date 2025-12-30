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
    }

    .form-page {
        max-width: 550px; /* Membatasi lebar agar form fokus di tengah */
        margin: 3rem auto;
        padding: 0 1rem;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .header-section {
        text-align: center;
        margin-bottom: 2rem;
    }

    .header-section h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .header-section p {
        color: var(--text-muted);
        font-size: 0.9rem;
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

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-main);
        font-size: 0.95rem;
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
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem; /* Padding kiri lebih besar untuk ikon */
        font-size: 0.95rem;
        color: var(--text-main);
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        transition: all 0.2s;
        box-sizing: border-box; /* Penting agar padding tidak merusak width */
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

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
</style>

<div class="form-page">

    <div class="header-section">
        <h3><?= esc($title) ?></h3>
        <p>Buat folder baru untuk mengelompokkan dokumen.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?= site_url("informasi-publik/$slug/folder/store") ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nama_folder" class="form-label">
                        Nama Folder
                    </label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        </span>
                        <input
                            type="text"
                            name="nama_folder"
                            id="nama_folder"
                            class="form-control"
                            placeholder="Contoh: Laporan Keuangan 2024"
                            required
                            autofocus
                            autocomplete="off"
                        >
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url("informasi-publik/$slug") ?>" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Folder
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>