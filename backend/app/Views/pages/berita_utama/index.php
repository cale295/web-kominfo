<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    /* ===============================
   DESIGN SYSTEM (Selaras dengan Sidebar & Dashboard)
================================ */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        /* Primary Colors */
        --primary: #6366f1;
        --primary-light: #eef2ff;
        --primary-dark: #4f46e5;

        /* Soft Colors */
        --primary-soft: #eef2ff;
        --primary-text: #4f46e5;
        --success-soft: #ecfdf5;
        --success-text: #059669;
        --danger-soft: #fef2f2;
        --danger-text: #dc2626;
        --warning-soft: #fffbeb;
        --warning-text: #d97706;
        --info-soft: #eff6ff;
        --info-text: #3b82f6;

        /* Neutral Colors */
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;

        /* Semantic Colors */
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;

        /* Surface */
        --bg-body: #f9fafb;
        --card-bg: #ffffff;
        --border: #e5e7eb;

        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--bg-body);
        color: var(--gray-900);
        font-size: 14px;
        line-height: 1.5;
    }

    .container-fluid {
        max-width: 100%;
        padding: 0 2rem;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 1rem;
        }
    }

    /* ===============================
   PAGE HEADER - Updated Style
================================ */

    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Breadcrumb from system */
    .breadcrumb {
        background-color: var(--card-bg);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        margin-top: 1rem;
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

    /* ===============================
   CARD - Updated Style
================================ */

    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
        overflow: hidden;
        background: var(--card-bg);
    }

    .card-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        background: white;
        border-bottom: 2px solid var(--gray-200);
        padding: 1.5rem 1.5rem;
    }

    /* ===============================
   TABLE - Updated Style
================================ */

    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead {
        background: linear-gradient(135deg, var(--primary-soft) 0%, var(--info-soft) 100%);
        border-bottom: 2px solid var(--gray-200);
    }

    .table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
        padding: 1rem;
        border-bottom: 2px solid var(--gray-200);
        border: none;
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
        background: var(--card-bg);
    }

    .table-hover tbody tr:hover {
        background-color: var(--gray-50);
        transform: translateX(5px);
        transition: transform 0.2s ease;
    }

    /* ===============================
   IMAGE STYLES
================================ */

    .img-preview-box {
        width: 60px;
        height: 45px;
        border: 2px solid var(--gray-200);
        border-radius: 0.75rem;
        overflow: hidden;
        background: var(--gray-100);
        display: inline-block;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .img-preview-box:hover {
        border-color: var(--primary);
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .img-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Image preview in modal */
    .image-preview-container {
        height: 200px;
        width: 100%;
        border: 2px dashed var(--gray-300);
        border-radius: 1rem;
        background: var(--gray-50);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .image-preview-container:hover {
        border-color: var(--primary);
        background: var(--primary-soft);
    }

    .image-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ===============================
   BUTTONS - Updated Style
================================ */

    .btn {
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
        box-shadow: var(--shadow-sm);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 0.5rem 1.5rem;
        font-size: 0.875rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-primary:disabled:hover {
        transform: none;
        box-shadow: var(--shadow-sm);
    }

    .btn-secondary {
        background: var(--gray-300);
        color: var(--gray-700);
        padding: 0.5rem 1.5rem;
        font-size: 0.875rem;
    }

    .btn-secondary:hover {
        background: var(--gray-400);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-warning {
        background: var(--warning);
        color: white;
        padding: 0.5rem 1.5rem;
        font-size: 0.875rem;
    }

    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* Outline buttons */
    .btn-outline-warning {
        background: transparent;
        border: 1px solid var(--warning);
        color: var(--warning);
    }

    .btn-outline-warning:hover {
        background: var(--warning);
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-danger {
        background: transparent;
        border: 1px solid var(--danger);
        color: var(--danger);
    }

    .btn-outline-danger:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-1px);
    }

    .rounded-circle {
        border-radius: 50% !important;
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    /* ===============================
   MODAL STYLES - Updated Style
================================ */

    .modal-content {
        border-radius: 1.5rem;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .modal-header {
        border-bottom: 2px solid var(--gray-200);
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
    }

    .modal-header.bg-warning {
        background: linear-gradient(135deg, var(--warning), #d97706);
        color: white;
    }

    .modal-header.bg-dark {
        background: var(--gray-900);
        color: white;
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 2rem;
        background-color: var(--gray-50);
    }

    .modal-footer {
        background-color: var(--gray-100);
        border-top: 2px solid var(--gray-200);
        padding: 1.5rem 2rem;
        justify-content: flex-end;
        gap: 0.75rem;
        border-radius: 0 0 1.5rem 1.5rem;
    }

    /* ===============================
   FORM STYLES - Updated
================================ */

    .form-label {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 0.75rem;
        border: 2px solid var(--gray-300);
        padding: 0.875rem 1rem;
        font-size: 0.9rem;
        background: white;
        transition: all 0.25s ease;
        color: var(--gray-900);
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        outline: none;
        transform: translateY(-1px);
    }

    /* ===============================
   ALERT STYLES
================================ */

    .alert {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        border-left: 4px solid;
    }

    .alert-warning {
        background: var(--warning-soft);
        border-left-color: var(--warning);
        color: var(--warning-text);
    }

    .alert-warning {
        background: var(--warning-soft);
        border-left-color: var(--warning);
        color: var(--warning-text);
    }

    /* ===============================
   BADGES - Updated Style
================================ */

    .badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 50px;
        font-size: 0.75rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .bg-success {
        background-color: var(--success-soft) !important;
        color: var(--success-text) !important;
        border-color: var(--success) !important;
    }

    .bg-secondary {
        background-color: var(--gray-200) !important;
        color: var(--gray-700) !important;
        border-color: var(--gray-300) !important;
    }

    .bg-info {
        background-color: var(--info-soft) !important;
        color: var(--info-text) !important;
        border-color: var(--info) !important;
    }

    /* ===============================
   EMPTY STATE
================================ */

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
        background: var(--gray-100);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-sm);
    }

    .empty-state h6 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray-500);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    /* ===============================
   TEXT UTILITIES
================================ */

    .text-muted {
        color: var(--gray-500) !important;
    }

    .text-secondary {
        color: var(--gray-600) !important;
    }

    .text-dark {
        color: var(--gray-900) !important;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .small {
        font-size: 0.875rem;
    }

    .fw-bold {
        font-weight: 600;
    }

    /* ===============================
   FORM TEXT
================================ */

    .form-text {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-text i {
        color: var(--info-text);
    }

    /* ===============================
   HOVER EFFECTS
================================ */

    .hover-scale {
        transition: transform 0.2s ease;
    }

    .hover-scale:hover {
        transform: translateY(-1px) scale(1.02);
    }

    /* ===============================
   RESPONSIVE
================================ */

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 1rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-header {
            padding: 1.25rem;
        }

        .modal-footer {
            padding: 1.25rem;
        }

        .table thead th,
        .table tbody td {
            padding: 0.875rem 0.75rem;
            font-size: 0.8125rem;
        }

        .card-header {
            padding: 1rem;
        }

        .btn-primary,
        .btn-secondary,
        .btn-warning {
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
        }
    }

    /* ===============================
   UTILITY CLASSES
================================ */

    .font-monospace {
        font-family: 'Courier New', monospace;
    }

    .rounded-pill {
        border-radius: 50px !important;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .rounded {
        border-radius: 0.75rem !important;
    }

    .shadow-sm {
        box-shadow: var(--shadow-sm) !important;
    }

    .shadow-lg {
        box-shadow: var(--shadow-lg) !important;
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
                <i class="fas fa-newspaper me-2"></i>
                Berita Utama
            </h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-star me-1 text-primary"></i> 
                Kelola berita yang ditampilkan di halaman utama (Maksimal 6 berita).
            </p>
        </div>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Berita Utama</li>
            </ol>
        </nav>
    </div>

    <!-- Limit Warning Alert -->
    <?php 
    $totalBerita = count($beritaUtama ?? []);
    $isLimitReached = $totalBerita >= 6;
    ?>
    
    <?php if ($isLimitReached): ?>
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-3 fs-5"></i>
        <div>
            <strong>Limit Tercapai!</strong> Anda sudah mencapai batas maksimal 6 berita utama. 
            Hapus berita yang ada untuk menambahkan berita baru.
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="card card-modern mt-4">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fas fa-newspaper me-2 text-primary"></i>
                        Daftar Berita Utama
                    </h5>
                    <span class="text-muted small">
                        Kelola berita yang ditampilkan di halaman utama 
                        <span class="badge bg-info ms-2"><?= $totalBerita ?> / 6</span>
                    </span>
                </div>
                
                <?php if (!empty($can_create) && $can_create): ?>
                    <button type="button" 
                            class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalCreate"
                            <?= $isLimitReached ? 'disabled' : '' ?>>
                        <i class="fas fa-plus me-1"></i> 
                        <?= $isLimitReached ? 'Limit Tercapai' : 'Tambah Berita Utama' ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">No</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Gambar</th>
                            <th class="py-3 text-uppercase" width="35%">Judul Berita</th>
                            <th class="py-3 text-uppercase" width="15%">Dibuat Oleh</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Tanggal</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($beritaUtama)): ?>
                            <?php foreach ($beritaUtama as $i => $b): ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge-number" style="background: var(--primary-soft); color: var(--primary-text); padding: 0.5rem 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.875rem;">
                                            <?= $i + 1 ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if (!empty($b['feat_image'])): ?>
                                            <div class="img-preview-box hover-scale" onclick="showImagePreview('<?= base_url($b['feat_image']) ?>')" title="Klik untuk memperbesar">
                                                <img src="<?= base_url($b['feat_image']) ?>" 
                                                     alt="Gambar Berita">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark d-block mb-1"><?= esc($b['judul']) ?></span>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle me-2 text-primary fs-5"></i>
                                            <span class="text-dark fw-semibold"><?= esc($b['created_by_name'] ?? 'System') ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex flex-column small">
                                            <span class="text-dark fw-semibold"><?= date('d M Y', strtotime($b['created_date'])) ?></span>
                                            <span class="text-muted"><?= date('H:i', strtotime($b['created_date'])) ?></span>
                                        </div>
                                    </td>

                                     <td class="text-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-1">
                                                <?= btn_toggle($b['id_berita_utama'], $b['status'], 'berita-utama/toggle-status') ?>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if (!empty($can_update) && $can_update): ?>
                                                <button type="button"
                                                        class="btn btn-outline-warning btn-sm rounded-circle shadow-sm hover-scale"
                                                        data-bs-toggle="tooltip" 
                                                        title="Edit"
                                                        onclick="openEditModal(<?= $b['id_berita_utama'] ?>, <?= $b['id_berita'] ?>, '<?= esc($b['judul']) ?>', '<?= base_url($b['feat_image']) ?>', <?= $b['jenis'] ?? 0 ?>, <?= $b['status'] ?>)">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if (!empty($can_delete) && $can_delete): ?>
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm rounded-circle shadow-sm hover-scale" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Hapus"
                                                        onclick="confirmDelete('<?= site_url('berita-utama/'.$b['id_berita_utama']) ?>')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada berita utama</h6>
                                        <p class="text-muted">Silakan tambahkan berita utama baru (Maksimal 6 berita)</p>
                                        <?php if (!empty($can_create) && $can_create): ?>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                                <i class="fas fa-plus me-2"></i> Tambah Berita Utama
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center text-muted small">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    <span>Total: <strong><?= $totalBerita ?> / 6</strong> berita utama</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <?php if ($isLimitReached): ?>
                        <span class="badge bg-warning px-3 py-2 rounded-pill">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Limit Tercapai
                        </span>
                    <?php else: ?>
                        <span class="badge bg-success px-3 py-2 rounded-pill">
                            <i class="fas fa-check me-1"></i>
                            <?= 6 - $totalBerita ?> Slot Tersisa
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Berita Utama
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('berita-utama') ?>" method="post" id="formCreate">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <!-- Pilih Berita -->
                    <div class="mb-4">
                        <label for="create_id_berita" class="form-label">
                            <i class="fas fa-newspaper me-1"></i>
                            Pilih Berita <span class="text-danger">*</span>
                        </label>
                        <select name="id_berita" id="create_id_berita" class="form-select" required>
                            <option value="">-- Pilih Berita --</option>
                            <?php if (isset($beritas) && !empty($beritas)): ?>
                                <?php foreach ($beritas as $b): ?>
                                    <option value="<?= $b['id_berita'] ?>" data-image="<?= base_url($b['feat_image']) ?>">
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="form-text">
                            <i class="fas fa-lightbulb"></i>
                            Pilih berita yang akan ditampilkan sebagai berita utama
                        </div>
                    </div>

                    <!-- Preview Gambar -->
                    <div id="create_preview_wrapper" class="text-center mb-4" style="display:none;">
                        <div class="image-preview-container">
                            <img id="create_preview_image" src="" alt="Preview" class="img-fluid rounded">
                        </div>
                        <div class="form-text mt-2">
                            <i class="fas fa-eye"></i>
                            Preview gambar berita yang dipilih
                        </div>
                    </div>

                    <!-- Pengaturan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_status" class="form-label">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Status Publikasi <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="create_status" class="form-select" required>
                                    <option value="1">✓ Aktif - Ditampilkan</option>
                                    <option value="0">✗ Nonaktif - Tidak Ditampilkan</option>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i>
                                    Status publikasi berita utama
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Berita Utama
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <!-- Pilih Berita -->
                    <div class="mb-4">
                        <label for="edit_id_berita" class="form-label">
                            <i class="fas fa-newspaper me-1"></i>
                            Pilih Berita <span class="text-danger">*</span>
                        </label>
                        <select name="id_berita" id="edit_id_berita" class="form-select" required>
                            <?php if (isset($beritaList) && !empty($beritaList)): ?>
                                <?php foreach ($beritaList as $b): ?>
                                    <option value="<?= $b['id_berita'] ?>" data-image="<?= base_url($b['feat_image']) ?>">
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="form-text">
                            <i class="fas fa-lightbulb"></i>
                            Pilih berita yang akan ditampilkan sebagai berita utama
                        </div>
                    </div>

                    <!-- Preview Gambar -->
                    <div id="edit_preview_wrapper" class="text-center mb-4">
                        <div class="image-preview-container">
                            <img id="edit_preview_image" src="" alt="Preview" class="img-fluid rounded">
                        </div>
                        <div class="form-text mt-2">
                            <i class="fas fa-eye"></i>
                            Preview gambar berita yang dipilih
                        </div>
                    </div>

                    <!-- Pengaturan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Status Publikasi <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="edit_status" class="form-select" required>
                                    <option value="1">✓ Aktif - Ditampilkan</option>
                                    <option value="0">✗ Nonaktif - Tidak Ditampilkan</option>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i>
                                    Status publikasi berita utama
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview Image -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewModalLabel">
                    <i class="fas fa-image me-2"></i>Preview Gambar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="preview_full_image" src="" alt="Preview" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Form untuk delete -->
<form id="deleteForm" action="" method="post" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Tooltip initialization
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Auto-dismiss alerts after 5 seconds
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

// Validasi Limit 6 Data pada Form Create
document.getElementById('formCreate').addEventListener('submit', function(e) {
    const totalBerita = <?= $totalBerita ?>;
    if (totalBerita >= 6) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Limit Tercapai!',
            html: 'Anda sudah mencapai batas maksimal <strong>6 berita utama</strong>.<br>Silakan hapus berita yang ada untuk menambahkan berita baru.',
            confirmButtonColor: 'var(--warning)',
            background: 'var(--warning-soft)',
            color: 'var(--warning-text)'
        });
        return false;
    }
});

// Create Modal Preview
document.getElementById('create_id_berita').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const imageSrc = selectedOption.getAttribute('data-image');
    const previewWrapper = document.getElementById('create_preview_wrapper');
    const previewImage = document.getElementById('create_preview_image');
    
    if (imageSrc && selectedOption.value) {
        previewImage.src = imageSrc;
        previewWrapper.style.display = 'block';
    } else {
        previewWrapper.style.display = 'none';
    }
});

// Edit Modal Function
function openEditModal(id, idBerita, judul, image, jenis, status) {
    document.getElementById('formEdit').action = '<?= site_url('berita-utama/') ?>' + id;
    document.getElementById('edit_id_berita').value = idBerita;
    document.getElementById('edit_status').value = status || '1';
    document.getElementById('edit_preview_image').src = image;
    
    var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
    modalEdit.show();
}

// Edit Modal Preview
document.getElementById('edit_id_berita').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const imageSrc = selectedOption.getAttribute('data-image');
    const previewImage = document.getElementById('edit_preview_image');
    
    if (imageSrc) {
        previewImage.src = imageSrc;
    }
});

// Show Full Image Preview
function showImagePreview(imageSrc) {
    document.getElementById('preview_full_image').src = imageSrc;
    var imageModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    imageModal.show();
}

// Delete Function with SweetAlert2
function confirmDelete(url) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        html: 'Anda akan menghapus berita utama ini.<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--danger)',
        cancelButtonColor: 'var(--gray-500)',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            form.submit();
        }
    });
}

// Reset forms on modal close
document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
    document.getElementById('create_id_berita').selectedIndex = 0;
    document.getElementById('create_status').value = '1';
    document.getElementById('create_preview_wrapper').style.display = 'none';
});

document.getElementById('modalEdit').addEventListener('hidden.bs.modal', function () {
    document.getElementById('edit_id_berita').selectedIndex = 0;
    document.getElementById('edit_status').value = '1';
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const idBerita = form.querySelector('select[name="id_berita"]');
            
            if (idBerita && !idBerita.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Silakan pilih berita terlebih dahulu!',
                    confirmButtonColor: 'var(--primary)',
                    background: 'var(--danger-soft)',
                    color: 'var(--danger-text)'
                });
                idBerita.focus();
                return;
            }
        });
    });
});
</script>

<?= $this->endSection() ?>