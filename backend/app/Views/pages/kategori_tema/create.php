<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>


<style>
    /* * NOTE: Ini adalah semua CSS dari file-file sebelumnya.
     * Idealnya, semua CSS ini dipindahkan ke file CSS utama Anda 
     * (yang dimuat di 'layouts/main') agar tidak duplikat.
    */
    :root {
        --primary-gov: #1e40af;
        --secondary-gov: #0c4a6e;
        --success-gov: #047857;
        --warning-gov: #b45309;
        --danger-gov: #be123c;
        --info-gov: #0369a1;
        --accent-gov: #fbbf24;
    }

    /* Page Header */
    .page-header-gov {
        background: linear-gradient(135deg, var(--primary-gov) 0%, var(--secondary-gov) 100%);
        color: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(30, 64, 175, 0.15);
        margin-bottom: 30px;
        border-left: 6px solid var(--accent-gov);
    }

    .page-header-gov h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .page-header-gov h3 i {
        color: var(--accent-gov);
        margin-right: 12px;
    }
    
    /* Alerts (untuk error/sukses) */
    .alert-success-gov {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: none;
        border-left: 5px solid var(--success-gov);
        border-radius: 12px;
        padding: 18px 24px;
        box-shadow: 0 2px 12px rgba(4, 120, 87, 0.15);
        margin-bottom: 24px;
        color: #065f46;
        font-weight: 500;
    }

    .alert-success-gov::before {
        content: '\F26B';
        font-family: 'bootstrap-icons';
        font-size: 1.3rem;
        color: var(--success-gov);
        margin-right: 10px;
    }

    /* === CSS UNTUK FORM === */

    /* Form Card */
    .form-card-gov {
        background: white;
        border-radius: 16px;
        padding: 35px 40px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.5s ease-out;
    }

    /* Form Label */
    .form-label-gov {
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    /* Form Input */
    .form-control-gov {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 12px 16px;
        font-size: 0.95rem;
        color: #1e293b;
        transition: all 0.3s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .form-control-gov:focus {
        border-color: var(--primary-gov);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.2);
        outline: none;
    }

    /* Form Actions (Tombol) */
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #f1f5f9; /* Garis pemisah */
    }

    /* Tombol Submit (Success) */
    .btn-gov-submit {
        background: linear-gradient(135deg, var(--success-gov) 0%, #059669 100%);
        color: white;
        border: none;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(4, 120, 87, 0.2);
    }

    .btn-gov-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(4, 120, 87, 0.3);
        color: white;
    }

    /* Tombol Kembali (Secondary) */
    .btn-gov-secondary {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        border: 1px solid #cbd5e1;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-gov-secondary:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #334155;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    /* === AKHIR CSS FORM === */

    /* Animasi */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid py-4">
    <div class="page-header-gov">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="bi bi-plus-circle"></i>
                    Tambah Tema Baru
                </h3>
            </div>
        </div>
    </div>

    <div class="card form-card-gov">
        <form action="<?= site_url('tema') ?>" method="post">
            
            <div class="mb-3">
                <label for="nama_tema" class="form-label form-label-gov">Nama Tema</label>
                <input type="text" 
                       class="form-control form-control-gov" 
                       name="nama_tema" 
                       id="nama_tema" 
                       placeholder="Masukkan nama tema..."
                       required>
            </div>

            <div class="form-actions">
                <a href="<?= site_url('tema') ?>" class="btn btn-gov-secondary">Kembali</a>
                <button type="submit" class="btn btn-gov-submit">
                    <i class="bi bi-save me-2"></i>Simpan
                </button>
            </div>
            
        </form>
    </div>
</div>
<?= $this->endSection() ?>