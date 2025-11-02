<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    /* * NOTE: Ini adalah semua CSS dari file agenda Anda.
     * Idealnya, semua CSS ini dipindahkan ke file CSS utama Anda 
     * (yang dimuat di 'layouts/main') agar tidak duplikat.
     * Tapi untuk sekarang, ini akan berfungsi.
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

    .btn-add-agenda {
        background: white;
        color: var(--primary-gov);
        border: none;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-add-agenda:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: var(--primary-gov);
    }

    /* Alert Success */
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

    /* Table Card */
    .table-card-gov {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: white;
    }

    /* Table Styles */
    .table-gov {
        margin: 0;
        width: 100%;
    }

    .table-gov thead {
        background: linear-gradient(135deg, var(--primary-gov) 0%, var(--secondary-gov) 100%);
    }

    .table-gov thead th {
        color: black;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 18px 16px;
        border: none;
        white-space: nowrap;
    }

    .table-gov tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    .table-gov tbody tr {
        transition: all 0.2s ease;
    }

    .table-gov tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Activity Name Cell (Bisa dipakai ulang) */
    .activity-name {
        font-weight: 600;
        color: #1e293b;
    }
    
    /* Action Buttons */
    .btn-action-group {
        display: flex;
        gap: 6px;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 2px solid;
        background: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        padding: 0;
    }

    .btn-edit {
        border-color: var(--warning-gov);
        color: var(--warning-gov);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        border-color: var(--warning-gov);
        color: var(--warning-gov);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(180, 83, 9, 0.25);
    }

    .btn-delete {
        border-color: var(--danger-gov);
        color: var(--danger-gov);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-color: var(--danger-gov);
        color: var(--danger-gov);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(190, 18, 60, 0.25);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #94a3b8;
    }

    /* Animation */
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

    .table-card-gov {
        animation: fadeInUp 0.5s ease-out;
    }

    .alert-success-gov {
        animation: fadeInUp 0.4s ease-out;
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
                    <i class="bi bi-tags"></i>
                    Daftar Tema
                </h3>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= site_url('tema/new') ?>" class="btn btn-add-agenda">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Tema Baru
                </a>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success-gov alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>


    <div class="card table-card-gov">
        <div class="table-responsive">
            <table class="table table-gov table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Tema</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($temas)): ?>
                        <?php foreach($temas as $i => $tema): ?>
                        <tr>
                            <td><strong><?= $i + 1 ?></strong></td>
                            <td>
                                <div class="activity-name">
                                    <?= esc($tema['nama_tema']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="btn-action-group">
                                    <a href="<?= site_url('tema/'.$tema['id_tema'].'/edit') ?>" 
                                       class="btn-action btn-edit"
                                       title="Edit Tema">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form action="<?= site_url('tema/'.$tema['id_tema']) ?>" method="post" class="d-inline">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" 
                                                class="btn-action btn-delete" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus tema ini?')"
                                                title="Hapus Tema">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="bi bi-tag-x"></i>
                                    <h5>Belum Ada Tema</h5>
                                    <p>Silakan tambahkan tema baru untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Inisialisasi Tooltip (untuk tombol edit/hapus)
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        // Pastikan Bootstrap's Tooltip sudah dimuat di layout/main.php
        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        }
    });
});
</script>
<?= $this->endSection() ?>