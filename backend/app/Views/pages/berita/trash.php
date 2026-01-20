<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --primary: #6366f1;
        --primary-light: #eef2ff;
        --primary-dark: #4f46e5;
        --success: #10b981;
        --success-soft: #ecfdf5;
        --success-text: #059669;
        --danger: #ef4444;
        --danger-soft: #fef2f2;
        --danger-text: #dc2626;
        --info: #3b82f6;
        --info-soft: #eff6ff;
        --info-text: #2563eb;
        --warning: #f59e0b;
        --warning-soft: #fffbeb;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-500: #6b7280;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--gray-50);
        color: var(--gray-900);
        font-size: 14px;
    }

    .text-gradient {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .breadcrumb {
        background-color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .breadcrumb-item a {
        text-decoration: none;
        font-weight: 600;
        color: var(--primary);
        font-size: 0.875rem;
    }

    .breadcrumb-item.active {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        background: white;
    }

    .card-header-modern {
        background: linear-gradient(135deg, var(--danger-soft) 0%, var(--warning-soft) 100%);
        border-bottom: 2px solid var(--gray-200);
        padding: 1.5rem;
    }

    .btn {
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary {
        background: var(--gray-300);
        color: var(--gray-700);
    }

    .btn-secondary:hover {
        background: var(--gray-400);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-success {
        background: var(--success);
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-info {
        background: var(--info);
        color: white;
    }

    .btn-info:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-danger {
        background: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead {
        background: linear-gradient(135deg, var(--gray-800) 0%, var(--gray-700) 100%);
    }

    .table thead th {
        color: black;
        background-color: var(--gray-200);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
    }

    .table-hover tbody tr {
        transition: all 0.2s ease;
    }

    .table-hover tbody tr:hover {
        background-color: var(--gray-50);
        transform: translateX(3px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state h6 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .badge-category {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 50px;
        font-size: 0.75rem;
        background: var(--primary-light);
        color: var(--primary);
        border: 1px solid var(--primary);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stats-card {
        background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 1.5rem;
    }

    .stats-card h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stats-card p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .card-header-modern {
            padding: 1rem;
        }

        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8125rem;
        }

        .stats-card h2 {
            font-size: 2rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">
                <i class="bi bi-trash3 me-2"></i>
                Sampah Berita
            </h1>
            <p class="text-muted small mb-0">
                <i class="bi bi-info-circle me-1"></i> 
                Kelola berita yang telah dihapus
            </p>
        </div>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= site_url('berita') ?>">Berita</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sampah</li>
            </ol>
        </nav>
    </div>

    <!-- Main Card -->
    <div class="card card-modern">
        <div class="card-header-modern">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-list-ul me-2 text-danger"></i>
                        Daftar Berita Terhapus
                    </h5>
                    <span class="text-muted small">Berita dapat dipulihkan atau dihapus permanen</span>
                </div>
                <a href="<?= site_url('berita') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">Judul Berita</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Diperbarui Oleh</th>
                            <th class="text-center">Tanggal Update</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($berita)): ?>
                            <?php foreach ($berita as $row): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-newspaper me-2 text-danger fs-5"></i>
                                            <span class="fw-semibold text-dark"><?= esc($row['judul']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-category">
                                            <i class="bi bi-tag"></i>
                                            <?= esc($row['kategori']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-2 text-primary"></i>
                                            <span class="text-dark"><?= esc($row['updated_by_name']) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column small">
                                            <span class="text-dark fw-semibold">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <?= date('d M Y', strtotime($row['updated_at'])) ?>
                                            </span>
                                            <span class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                <?= date('H:i', strtotime($row['updated_at'])) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <!-- Restore Button -->
                                            <form action="<?= site_url('berita/' . $row['id_berita'] . '/restore') ?>" method="post" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-success btn-sm rounded-circle" 
                                                    data-bs-toggle="tooltip"
                                                    title="Pulihkan Berita"
                                                    style="width: 36px; height: 36px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>

                                            <!-- Log Button -->
                                            <a href="<?= site_url('berita/' . $row['id_berita'] . '/log') ?>" 
                                               class="btn btn-info btn-sm rounded-circle"
                                               data-bs-toggle="tooltip"
                                               title="Lihat Log"
                                               style="width: 36px; height: 36px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-journal-text"></i>
                                            </a>

                                            <!-- Permanent Delete Button -->
                                            <form action="<?= site_url('berita/' . $row['id_berita'] . '/destroyPermanent') ?>" method="post" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm rounded-circle"
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus Permanen"
                                                    style="width: 36px; height: 36px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <h6>Sampah Kosong</h6>
                                        <p>Tidak ada berita yang dihapus</p>
                                        <a href="<?= site_url('berita') ?>" class="btn btn-primary mt-3">
                                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Berita
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($berita)): ?>
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center text-muted small">
                    <i class="bi bi-info-circle me-2 text-danger"></i>
                    <span>Total: <strong><?= count($berita) ?></strong> berita di sampah</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <!-- Pagination -->
                    <?php if (isset($pager)): ?>
                        <?= $pager->links('default', 'bootstrap_pagination') ?>
                    <?php endif; ?>
                    
                    <span class="badge" style="background: var(--danger-soft); color: var(--danger-text); padding: 0.5rem 1rem; border-radius: 50px; border: 1px solid var(--danger);">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Data Terhapus
                    </span>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});

// Enhanced confirm for restore
document.querySelectorAll('form[action*="/restore"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Pulihkan Berita?',
            html: 'Berita akan dikembalikan ke daftar berita aktif.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: 'var(--success)',
            cancelButtonColor: 'var(--gray-500)',
            confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Ya, Pulihkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});

// Enhanced confirm for permanent delete
document.querySelectorAll('form[action*="/destroyPermanent"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '⚠️ Peringatan!',
            html: '<p class="mb-2">Anda akan <strong>menghapus permanen</strong> berita ini.</p><p class="text-danger mb-0"><i class="bi bi-exclamation-triangle me-1"></i>Tindakan ini <strong>tidak dapat dibatalkan!</strong></p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--danger)',
            cancelButtonColor: 'var(--gray-500)',
            confirmButtonText: '<i class="bi bi-trash3 me-2"></i>Ya, Hapus Permanen!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>

<?= $this->endSection() ?>