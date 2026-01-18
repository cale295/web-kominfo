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
   IMAGE HOVER EFFECTS
================================ */

    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        display: block;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 2px solid var(--gray-200);
    }

    .img-hover-zoom:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
        border-color: var(--primary);
    }

    /* Image preview boxes */
    .img-preview-box {
        width: 120px;
        height: 120px;
        background-color: var(--gray-100);
        border: 2px solid var(--gray-200);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-top: 10px;
        box-shadow: var(--shadow-sm);
    }

    .img-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .current-image-preview-box {
        width: 120px;
        height: 120px;
        border: 2px solid var(--primary);
        border-radius: 0.75rem;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-sm);
    }

    .current-image-preview-box img {
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
        padding: 0.75rem 1.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Soft button styles */
    .btn-soft-primary { 
        background-color: var(--primary-soft); 
        color: var(--primary-text); 
        border: none; 
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-soft-primary:hover { 
        background-color: var(--primary); 
        color: white; 
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }
    
    .btn-soft-danger { 
        background-color: var(--danger-soft); 
        color: var(--danger-text); 
        border: none; 
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-soft-danger:hover { 
        background-color: var(--danger); 
        color: white; 
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .rounded-circle {
        border-radius: 50% !important;
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
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
        background-color: #fff;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
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
        gap: 10px;
        border-radius: 0 0 1.5rem 1.5rem;
    }

    /* ===============================
   FORM STYLES - Updated
================================ */

    .form-group-row {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .form-group-row.align-items-start {
        align-items: flex-start;
    }

    .form-label-custom {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--gray-800);
        margin-bottom: 0;
        width: 30%;
        padding-right: 15px;
    }

    .form-input-container {
        width: 70%;
        position: relative;
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

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .required-star {
        color: var(--danger);
        margin-left: 2px;
        font-weight: bold;
    }

    /* ===============================
   MODAL BUTTONS - Updated
================================ */

    .btn-custom-cancel {
        background-color: var(--gray-300);
        color: var(--gray-700);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-custom-cancel:hover {
        background-color: var(--gray-400);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-custom-save {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .btn-custom-save:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    }

    /* ===============================
   TEXT HELPERS
================================ */

    .text-helper {
        font-size: 0.8rem;
        color: var(--gray-500);
        font-style: italic;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .text-helper i {
        color: var(--info-text);
    }

    /* ===============================
   MODAL IMAGE VIEWER - Updated
================================ */

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
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .image-modal.show {
        display: flex;
    }

    .image-modal-content {
        max-width: 90%;
        max-height: 85%;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .image-modal-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 2.5rem;
        cursor: pointer;
        background: var(--danger);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        border: 2px solid white;
        box-shadow: var(--shadow-md);
    }

    .image-modal-close:hover {
        background: #b91c1c;
        transform: rotate(90deg) scale(1.1);
        box-shadow: var(--shadow-lg);
    }

    /* ===============================
   BADGES & STATUS
================================ */

    .badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 50px;
        font-size: 0.75rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid;
    }

    .badge-primary {
        background-color: var(--primary-soft);
        color: var(--primary-text);
        border-color: var(--primary-light);
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
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
        background: var(--gray-100);
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-sm);
    }

    .empty-state h5 {
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
   STATUS TOGGLE - Updated
================================ */

    .status-btn {
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 0.375rem;
    }

    .status-btn:hover {
        background: var(--gray-100);
        transform: translateY(-1px);
    }

    .status-btn .switch {
        position: relative;
        width: 48px;
        height: 24px;
        background-color: var(--gray-300);
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    .status-btn .switch::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .status-btn .switch.active {
        background-color: var(--success);
    }

    .status-btn .switch.active::after {
        left: 26px;
    }

    .status-btn .switch-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--gray-700);
        min-width: 65px;
        text-align: left;
        transition: color 0.3s;
    }

    .status-btn .switch.active + .switch-label {
        color: var(--success-text);
    }

    /* ===============================
   ANIMATIONS
================================ */

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ===============================
   RESPONSIVE
================================ */

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 1rem;
        }

        .form-group-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-label-custom {
            width: 100%;
            margin-bottom: 0.5rem;
            padding-right: 0;
        }

        .form-input-container {
            width: 100%;
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

        .btn-primary {
            padding: 0.625rem 1.25rem;
            font-size: 0.8125rem;
        }
    }

    /* ===============================
   UTILITY CLASSES
================================ */

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .font-monospace {
        font-family: 'Courier New', monospace;
    }

    .rounded-pill {
        border-radius: 50px !important;
    }

    .object-fit-cover {
        object-fit: cover;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">
                <i class="bi bi-calendar-event me-2"></i>
                Agenda Kegiatan
            </h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-calendar-alt me-1 text-primary"></i> 
                Kelola jadwal kegiatan, lokasi, dan dokumentasi.
            </p>
        </div>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Agenda Management</li>
            </ol>
        </nav>
    </div>

    <!-- Alerts -->
    <?= $this->include('layouts/alerts') ?>

    <!-- Main Card -->
    <div class="card card-modern mt-4">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Daftar Agenda</h5>
                    <span class="text-muted small">Kelola jadwal kegiatan, lokasi, dan dokumentasi</span>
                </div>
                
                <?php if ($can_create): ?>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAgenda">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Agenda
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">No</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Foto</th>
                            <th class="py-3 text-uppercase" width="25%">Nama Kegiatan</th>
                            <th class="py-3 text-uppercase" width="25%">Lokasi & Deskripsi</th>
                            <th class="py-3 text-uppercase" width="20%">Waktu</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($agendas)): ?>
                            <?php foreach ($agendas as $i => $agenda): ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge-number" style="background: var(--primary-soft); color: var(--primary-text); padding: 0.5rem 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.875rem;">
                                            <?= $i + 1 ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($agenda['image'])): ?>
                                            <div class="img-hover-zoom shadow-sm mx-auto" style="width: 60px; height: 60px;">
                                                <img src="<?= base_url('uploads/agenda/' . $agenda['image']) ?>" 
                                                     class="w-100 h-100 object-fit-cover" 
                                                     onclick="openImageModal(this.src)"
                                                     title="Klik untuk memperbesar">
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold text-dark"><?= esc($agenda['activity_name']) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bi bi-geo-alt-fill me-2 text-danger fs-6"></i>
                                            <span class="fw-semibold text-dark"><?= esc($agenda['location']) ?></span>
                                        </div>
                                        <div class="text-muted small text-truncate" style="max-width: 250px;">
                                            <?= esc($agenda['description']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="bi bi-calendar-event me-2 text-primary fs-6"></i>
                                                <span class="text-dark fw-bold"><?= date('d M Y', strtotime($agenda['start_date'])) ?></span>
                                            </div>
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="bi bi-clock me-2"></i>
                                                <span><?= date('H:i', strtotime($agenda['start_date'])) ?> - <?= date('H:i', strtotime($agenda['end_date'])) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?= btn_toggle($agenda['id_agenda'], $agenda['status'], 'agenda/toggle-status') ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                    class="btn btn-soft-primary btn-sm rounded-circle shadow-sm" 
                                                    style="width: 32px; height: 32px;"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditAgenda"
                                                    data-id="<?= $agenda['id_agenda'] ?>"
                                                    data-name="<?= esc($agenda['activity_name']) ?>"
                                                    data-location="<?= esc($agenda['location']) ?>"
                                                    data-description="<?= esc($agenda['description']) ?>"
                                                    data-start="<?= date('Y-m-d\TH:i', strtotime($agenda['start_date'])) ?>" 
                                                    data-end="<?= date('Y-m-d\TH:i', strtotime($agenda['end_date'])) ?>"
                                                    data-status="<?= $agenda['status'] ?>"
                                                    data-image="<?= $agenda['image'] ?>"
                                                    title="Edit Agenda">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="<?= base_url('agenda/delete/'.$agenda['id_agenda']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" 
                                                            class="btn btn-soft-danger btn-sm rounded-circle shadow-sm" 
                                                            style="width: 32px; height: 32px;"
                                                            title="Hapus Agenda">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="bi bi-calendar-event"></i>
                                        </div>
                                        <h5>Belum Ada Agenda</h5>
                                        <p>Mulai dengan menambahkan agenda pertama</p>
                                        <?php if ($can_create): ?>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAgenda">
                                                <i class="bi bi-plus-circle me-2"></i>Tambah Agenda
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
                    <i class="bi bi-info-circle me-2 text-primary"></i>
                    <span>Total: <strong><?= count($agendas) ?></strong> agenda</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-calendar-check me-1"></i>
                        <?= date('d M Y') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Agenda Modal -->
<div class="modal fade" id="modalTambahAgenda" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Form Tambah Data Agenda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('agenda') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group-row">
                        <label class="form-label-custom">Nama Kegiatan <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" name="activity_name" required 
                                   placeholder="Contoh: Rapat Koordinasi">
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Lokasi <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" name="location" required 
                                   placeholder="Contoh: Ruang Rapat Utama">
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Mulai <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" name="start_date" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Selesai <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" name="end_date" required>
                        </div>
                    </div>
                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom">Deskripsi</label>
                        <div class="form-input-container">
                            <textarea class="form-control" name="description" rows="4" 
                                      placeholder="Deskripsi kegiatan..."></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="active">
                    
                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom">Foto</label>
                        <div class="form-input-container">
                            <input type="file" class="form-control" name="image" id="add_image" 
                                   accept="image/*" onchange="previewAddImage()">
                            <div class="text-helper">
                                <i class="bi bi-info-circle"></i>
                                Format: JPG, PNG (Max 2MB)
                            </div>
                            <div class="img-preview-box" id="add-preview-box" style="display:none;">
                                <img id="add-img-preview" src="#">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-custom-save">
                        <i class="bi bi-check-circle me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Agenda Modal -->
<div class="modal fade" id="modalEditAgenda" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Form Edit Data Agenda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="" method="post" enctype="multipart/form-data" id="formEditAgenda">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body">
                    <div class="form-group-row">
                        <label class="form-label-custom">Nama Kegiatan <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" id="edit_activity_name" name="activity_name" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Lokasi <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" id="edit_location" name="location" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Mulai <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Selesai <span class="required-star">*</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom">Deskripsi</label>
                        <div class="form-input-container">
                            <textarea class="form-control" id="edit_description" name="description" rows="4"></textarea>
                        </div>
                    </div>  

                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom">Foto</label>
                        <div class="form-input-container">
                            <div id="current-image-container" style="display: none;">
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-image me-1"></i>Foto Saat Ini:
                                </div>
                                <div class="current-image-preview-box">
                                    <img id="current-image-preview" src="#" alt="Current">
                                </div>
                            </div>
                            <input type="file" class="form-control" id="edit_image" name="image" 
                                   accept="image/*" onchange="previewEditImage()">
                            <div class="text-helper">
                                <i class="bi bi-info-circle"></i>
                                Kosongkan jika tidak ingin mengubah foto
                            </div>
                            <div class="img-preview-box" id="edit-preview-container" style="display: none;">
                                <img id="edit-img-preview" src="#" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom-cancel" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-custom-save">
                        <i class="bi bi-check-circle me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Viewer Modal -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
    <img class="image-modal-content" id="modalImage">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Modal Logic
    var modalEditAgenda = document.getElementById('modalEditAgenda');
    modalEditAgenda.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        
        // Populate URL
        var id = button.getAttribute('data-id');
        document.getElementById('formEditAgenda').action = '<?= base_url('agenda') ?>/' + id;
        
        // Populate Inputs
        document.getElementById('edit_activity_name').value = button.getAttribute('data-name');
        document.getElementById('edit_location').value = button.getAttribute('data-location');
        document.getElementById('edit_description').value = button.getAttribute('data-description');
        document.getElementById('edit_start_date').value = button.getAttribute('data-start');
        document.getElementById('edit_end_date').value = button.getAttribute('data-end');

        // Image Preview Logic
        var image = button.getAttribute('data-image');
        var imgContainer = document.getElementById('current-image-container');
        var imgPreview = document.getElementById('current-image-preview');

        if (image && image !== "") {
            imgContainer.style.display = 'block';
            imgPreview.src = '<?= base_url('uploads/agenda') ?>/' + image; 
        } else {
            imgContainer.style.display = 'none';
        }

        // Reset Upload Input
        document.getElementById('edit_image').value = '';
        document.getElementById('edit-preview-container').style.display = 'none';
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

// Preview Image Functions
function previewAddImage() {
    const image = document.querySelector('#add_image');
    const imgPreview = document.querySelector('#add-img-preview');
    const box = document.querySelector('#add-preview-box');
    if(image.files && image.files[0]){
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
            box.style.display = 'flex';
        }
    } else {
        box.style.display = 'none';
    }
}

function previewEditImage() {
    const image = document.querySelector('#edit_image');
    const imgPreview = document.querySelector('#edit-img-preview');
    const previewContainer = document.querySelector('#edit-preview-container');
    if(image.files && image.files[0]){
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
            previewContainer.style.display = 'flex';
        }
    } else {
        previewContainer.style.display = 'none';
    }
}

// Image Viewer Functions
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Keyboard support for image modal
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// AJAX Toggle Status (if using custom toggle)
function toggleStatus(id) {
    fetch('<?= base_url('agenda/toggle-status') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Status berhasil diubah',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: 'var(--success-soft)',
                color: 'var(--success-text)'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal mengubah status: ' + data.message,
                confirmButtonColor: 'var(--primary)',
                background: 'var(--danger-soft)',
                color: 'var(--danger-text)'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan saat mengubah status',
            confirmButtonColor: 'var(--primary)',
            background: 'var(--danger-soft)',
            color: 'var(--danger-text)'
        });
    });
}

// Date Validation Functions
function setupDateValidation(startInput, endInput) {
    if (!startInput || !endInput) return;

    // Set min saat awal
    if (startInput.value) {
        endInput.min = startInput.value;
    }

    startInput.addEventListener('change', function () {
        endInput.min = startInput.value;

        if (endInput.value && endInput.value < startInput.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai!',
                confirmButtonColor: 'var(--primary)',
                background: 'var(--warning-soft)',
                color: 'var(--warning-text)'
            });
            endInput.value = startInput.value;
        }
    });

    endInput.addEventListener('change', function () {
        if (startInput.value && endInput.value < startInput.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai!',
                confirmButtonColor: 'var(--primary)',
                background: 'var(--warning-soft)',
                color: 'var(--warning-text)'
            });
            endInput.value = startInput.value;
        }
    });

    // Validasi submit
    const form = startInput.closest('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            if (startInput.value && endInput.value && endInput.value < startInput.value) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai!',
                    confirmButtonColor: 'var(--primary)',
                    background: 'var(--danger-soft)',
                    color: 'var(--danger-text)'
                });
                endInput.value = startInput.value;
            }
        });
    }
}

// Initialize date validation for add modal
document.addEventListener('DOMContentLoaded', function () {
    setupDateValidation(
        document.querySelector('input[name="start_date"]'),
        document.querySelector('input[name="end_date"]')
    );
});

// Initialize date validation for edit modal
document.getElementById('modalEditAgenda').addEventListener('shown.bs.modal', function () {
    setupDateValidation(
        document.getElementById('edit_start_date'),
        document.getElementById('edit_end_date')
    );
});
</script>

<?= $this->endSection() ?>