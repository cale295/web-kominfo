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
        height: 40px;
        border: 2px solid var(--gray-200);
        border-radius: 0.5rem;
        overflow: hidden;
        background: var(--gray-100);
        display: inline-block;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .img-preview-box:hover {
        border-color: var(--primary);
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .img-preview-box img {
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

    .btn-light {
        background: var(--gray-100);
        color: var(--gray-700);
        border: 1px solid var(--gray-300);
        padding: 0.5rem 1.5rem;
        font-size: 0.875rem;
    }

    .btn-light:hover {
        background: var(--gray-200);
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
        transition: all 0.2s;
    }

    .btn-outline-primary {
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline-primary:hover {
        background: var(--primary);
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
        max-height: 70vh;
        overflow-y: auto;
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

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* Form switch styles */
    .form-switch .form-check-input {
        width: 2.75em;
        height: 1.5em;
        cursor: pointer;
        border: 2px solid var(--gray-300);
        background-color: white;
        transition: all 0.2s;
    }

    .form-switch .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .form-switch .form-check-input:focus {
        box-shadow: 0 0 0 3px var(--primary-light);
        border-color: var(--primary);
    }

    /* ===============================
   CARD INSIDE MODAL
================================ */

    .card {
        border: none;
        border-radius: 1rem;
        background: white;
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
    }

    .card:hover {
        box-shadow: var(--shadow-md);
    }

    .card-header {
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-200);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray-700);
        padding: 1rem 1.25rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* ===============================
   IMAGE PREVIEW IN MODAL
================================ */

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

    .image-preview-placeholder {
        text-align: center;
        color: var(--gray-500);
    }

    .image-preview-placeholder i {
        font-size: 3rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
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

    .bg-info {
        background-color: var(--info-soft) !important;
        color: var(--info-text) !important;
        border-color: var(--info) !important;
    }

    .bg-warning {
        background-color: var(--warning-soft) !important;
        color: var(--warning-text) !important;
        border-color: var(--warning) !important;
    }

    .bg-light {
        background-color: var(--gray-100) !important;
        color: var(--gray-600) !important;
        border-color: var(--gray-300) !important;
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

    .text-uppercase {
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.75rem;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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
   RESPONSIVE
================================ */

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 1rem;
        }

        .modal-body {
            padding: 1.5rem;
            max-height: 60vh;
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

        .card-body {
            padding: 1.25rem;
        }

        .btn-primary,
        .btn-light,
        .btn-warning {
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
        }
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

    .small {
        font-size: 0.875rem;
    }

    .fw-bold {
        font-weight: 600;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">
                <i class="fas fa-bullhorn me-2"></i>
                Pengumuman
            </h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-newspaper me-1 text-primary"></i> 
                Kelola pengumuman untuk website dan aplikasi.
            </p>
        </div>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Pengumuman Management</li>
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
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fas fa-bullhorn me-2 text-primary"></i>
                        Daftar Pengumuman
                    </h5>
                    <span class="text-muted small">Kelola pengumuman untuk website dan aplikasi</span>
                </div>
                
                <?php if ($can_create): ?>
                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" 
                            data-bs-toggle="modal" data-bs-target="#addPengumumanModal">
                        <i class="fas fa-plus me-1"></i> Tambah Pengumuman
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
                            <th class="text-center py-3 text-uppercase" width="10%">Gambar</th>
                            <th class="py-3 text-uppercase" width="30%">Judul & Konten</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Media</th>
                            <th class="py-3 text-uppercase" width="15%">Tanggal</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengumuman)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-newspaper"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada pengumuman</h6>
                                        <p class="text-muted">Mulai dengan menambahkan pengumuman pertama</p>
                                        <?php if ($can_create): ?>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPengumumanModal">
                                                <i class="fas fa-plus me-2"></i> Tambah Pengumuman
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($pengumuman as $index => $item) : ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge-number" style="background: var(--primary-soft); color: var(--primary-text); padding: 0.5rem 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.875rem;">
                                            <?= $index + 1 ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($item['featured_image']) && file_exists($item['featured_image'])): ?>
                                            <div class="img-preview-box hover-scale" onclick="openImageModal('<?= base_url($item['featured_image']) ?>')" style="cursor: pointer;" title="Klik untuk memperbesar">
                                                <img src="<?= base_url($item['featured_image']) ?>" alt="Img">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['judul']) ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 250px;">
                                            <?= strip_tags($item['content']) ?>
                                        </div>
                                        <div class="text-muted small mt-1">
                                            <i class="far fa-clock me-1"></i>
                                            <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($item['tipe_media'] == 'link'): ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-link me-1"></i> Link
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">
                                                <i class="fas fa-file-alt me-1"></i> File
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-muted">
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-semibold"><?= date('d M Y', strtotime($item['created_at'])) ?></span>
                                            <span><?= date('H:i', strtotime($item['created_at'])) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <?= btn_toggle($item['id_pengumuman'], $item['status'], 'pengumuman/toggle-status') ?>
                                            
                                            <?php if ($can_update): ?>
                                                <button type="button" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm hover-scale" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editPengumumanModal<?= $item['id_pengumuman'] ?>"
                                                        title="Edit Pengumuman">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/pengumuman/<?= $item['id_pengumuman'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm hover-scale" title="Hapus Pengumuman">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center text-muted small">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    <span>Total: <strong><?= count($pengumuman) ?></strong> pengumuman</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                        <i class="fas fa-bullhorn me-1"></i>
                        Sistem Pengumuman
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengumuman -->
<div class="modal fade" id="addPengumumanModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addPengumumanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="addPengumumanLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Pengumuman
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="/pengumuman" method="post" enctype="multipart/form-data" id="formPengumuman">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header">Informasi Dasar</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="judul" value="<?= old('judul') ?>" placeholder="Masukkan judul pengumuman..." required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                                        <textarea class="form-control editor" name="content" rows="6" placeholder="Tulis isi pengumuman..."><?= old('content') ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">Pengaturan Media</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label mb-2">Tipe Media</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipe_media" id="tipeLink" value="link" onchange="toggleMedia('link')" <?= old('tipe_media') == 'link' ? 'checked' : 'checked' ?>>
                                            <label class="form-check-label" for="tipeLink">
                                                <i class="fas fa-link me-1"></i> Link URL
                                            </label>
                                        </div>
                                    </div>

                                    <div id="inputLink" class="mb-2">
                                        <label class="form-label">URL Tujuan</label>
                                        <input type="url" class="form-control" name="link_url" placeholder="https://contoh.com" value="<?= old('link_url') ?>">
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>
                                            Masukkan link lengkap diawali https://
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header">Gambar Cover <span class="text-danger">*</span></div>
                                <div class="card-body text-center">
                                    <div class="image-preview-container mb-3" onclick="document.querySelector('input[name=\'featured_image\']').click()">
                                        <img id="thumb-preview" src="#" alt="Preview" class="d-none">
                                        <div id="thumb-placeholder" class="image-preview-placeholder">
                                            <i class="fas fa-image"></i><br>
                                            <small>Klik untuk memilih gambar</small>
                                        </div>
                                    </div>
                                    <input class="form-control d-none" type="file" name="featured_image" accept="image/*" onchange="previewImage(this)" required>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i>
                                        Format JPG/PNG. Wajib diisi. Maks 2MB.
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">Pengaturan Status</div>
                                <div class="card-body">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" value="1" <?= old('status', 1) == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-bold" for="statusSwitch">Status Aktif</label>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>
                                            Jika tidak aktif, pengumuman tidak akan tampil di frontend.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Batal
                </button>
                <button type="button" onclick="document.getElementById('formPengumuman').submit()" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-save me-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pengumuman -->
<?php if (!empty($pengumuman)): ?>
    <?php foreach ($pengumuman as $item): ?>
        <div class="modal fade" id="editPengumumanModal<?= $item['id_pengumuman'] ?>" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editPengumumanLabel<?= $item['id_pengumuman'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPengumumanLabel<?= $item['id_pengumuman'] ?>">
                            <i class="fas fa-edit me-2"></i>Edit Pengumuman
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="/pengumuman/<?= $item['id_pengumuman'] ?>" method="post" enctype="multipart/form-data" id="formEditPengumuman<?= $item['id_pengumuman'] ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-header">Informasi Dasar</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="judul" value="<?= esc($item['judul']) ?>" placeholder="Masukkan judul pengumuman..." required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                                                <textarea class="form-control editor-edit" name="content" rows="6" placeholder="Tulis isi pengumuman..."><?= esc($item['content']) ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3">
                                        <div class="card-header">Pengaturan Media</div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label mb-2">Tipe Media</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tipe_media" id="tipeLink<?= $item['id_pengumuman'] ?>" value="link" 
                                                           onchange="toggleMediaEdit('link', <?= $item['id_pengumuman'] ?>)" 
                                                           <?= $item['tipe_media'] == 'link' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="tipeLink<?= $item['id_pengumuman'] ?>">
                                                        <i class="fas fa-link me-1"></i> Link URL
                                                    </label>
                                                </div>
                                            </div>

                                            <div id="inputLinkEdit<?= $item['id_pengumuman'] ?>" class="mb-2 <?= $item['tipe_media'] != 'link' ? 'd-none' : '' ?>">
                                                <label class="form-label">URL Tujuan</label>
                                                <input type="url" class="form-control" name="link_url" placeholder="https://contoh.com" value="<?= esc($item['link_url']) ?>">
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle"></i>
                                                    Masukkan link lengkap diawali https://
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-header">Gambar Cover</div>
                                        <div class="card-body text-center">
                                            <div class="image-preview-container mb-3" onclick="document.getElementById('editImageInput<?= $item['id_pengumuman'] ?>').click()">
                                                <?php if (!empty($item['featured_image']) && file_exists($item['featured_image'])): ?>
                                                    <img id="thumb-preview-edit<?= $item['id_pengumuman'] ?>" 
                                                         src="<?= base_url($item['featured_image']) ?>" 
                                                         alt="Preview" 
                                                         class="w-100 h-100 object-fit-cover">
                                                <?php else: ?>
                                                    <img id="thumb-preview-edit<?= $item['id_pengumuman'] ?>" src="#" alt="Preview" class="d-none w-100 h-100 object-fit-cover">
                                                    <div id="thumb-placeholder-edit<?= $item['id_pengumuman'] ?>" class="image-preview-placeholder">
                                                        <i class="fas fa-image"></i><br>
                                                        <small>Klik untuk memilih gambar</small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <input class="form-control d-none" type="file" name="featured_image" accept="image/*" 
                                                   id="editImageInput<?= $item['id_pengumuman'] ?>"
                                                   onchange="previewImageEdit(this, <?= $item['id_pengumuman'] ?>)">
                                            <div class="form-text">
                                                <i class="fas fa-info-circle"></i>
                                                Format JPG/PNG. Kosongkan jika tidak ingin mengubah gambar.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">Pengaturan Status</div>
                                        <div class="card-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" id="statusSwitchEdit<?= $item['id_pengumuman'] ?>" 
                                                       name="status" value="1" <?= $item['status'] == 1 ? 'checked' : '' ?>>
                                                <label class="form-check-label fw-bold" for="statusSwitchEdit<?= $item['id_pengumuman'] ?>">Status Aktif</label>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle"></i>
                                                    Jika tidak aktif, pengumuman tidak akan tampil di frontend.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Batal
                        </button>
                        <button type="button" onclick="document.getElementById('formEditPengumuman<?= $item['id_pengumuman'] ?>').submit()" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Image Modal Viewer -->
<div id="imageModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image me-2"></i>Preview Gambar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImageViewer" src="" alt="Preview" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Image Modal Viewer
function openImageModal(src) {
    document.getElementById('modalImageViewer').src = src;
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}

// Tooltips initialization
document.addEventListener('DOMContentLoaded', function () {
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

// Image Preview Functions
function previewImage(input) {
    const preview = document.getElementById('thumb-preview');
    const placeholder = document.getElementById('thumb-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
    }
}

function previewImageEdit(input, id) {
    const preview = document.getElementById('thumb-preview-edit' + id);
    const placeholder = document.getElementById('thumb-placeholder-edit' + id);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if(placeholder) placeholder.classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Media Toggle Functions
function toggleMedia(type) {
    const inputLink = document.getElementById('inputLink');
    const inputFile = document.getElementById('inputFile');
    
    if (type === 'link') {
        inputLink.classList.remove('d-none');
        if(inputFile) inputFile.classList.add('d-none');
    } else {
        inputLink.classList.add('d-none');
        if(inputFile) inputFile.classList.remove('d-none');
    }
}

function toggleMediaEdit(type, id) {
    const inputLink = document.getElementById('inputLinkEdit' + id);
    const inputFile = document.getElementById('inputFileEdit' + id);
    
    if (type === 'link') {
        inputLink.classList.remove('d-none');
        if(inputFile) inputFile.classList.add('d-none');
    } else {
        inputLink.classList.add('d-none');
        if(inputFile) inputFile.classList.remove('d-none');
    }
}

// Reset form when add modal is closed
const modalEl = document.getElementById('addPengumumanModal');
if(modalEl) {
    modalEl.addEventListener('hidden.bs.modal', function () {
        document.getElementById('formPengumuman').reset();
        document.getElementById('thumb-preview').classList.add('d-none');
        document.getElementById('thumb-preview').src = '#';
        document.getElementById('thumb-placeholder').classList.remove('d-none');
        document.getElementById('tipeLink').checked = true;
        toggleMedia('link');
    });
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[id^="formPengumuman"], form[id^="formEditPengumuman"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const title = form.querySelector('input[name="judul"]');
            const content = form.querySelector('textarea[name="content"]');
            const featuredImage = form.querySelector('input[name="featured_image"]');
            
            if (!title.value.trim()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Judul pengumuman harus diisi!',
                    confirmButtonColor: 'var(--primary)',
                    background: 'var(--danger-soft)',
                    color: 'var(--danger-text)'
                });
                title.focus();
                return;
            }
            
            if (!content.value.trim()) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Isi pengumuman harus diisi!',
                    confirmButtonColor: 'var(--primary)',
                    background: 'var(--danger-soft)',
                    color: 'var(--danger-text)'
                });
                content.focus();
                return;
            }
            
            // For add form, check featured image
            if (form.id === 'formPengumuman' && (!featuredImage || !featuredImage.value)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gambar cover harus diisi!',
                    confirmButtonColor: 'var(--primary)',
                    background: 'var(--danger-soft)',
                    color: 'var(--danger-text)'
                });
                return;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>