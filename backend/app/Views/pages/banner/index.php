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

    /* Filter Navigation */
    .filter-nav {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-100);
        flex-wrap: wrap;
    }

    .filter-btn {
        background: var(--gray-100);
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-btn:hover {
        background: var(--gray-200);
        color: var(--gray-900);
    }

    .filter-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 2px 4px rgba(30, 64, 175, 0.2);
    }
    
    .filter-count {
        background: rgba(255,255,255,0.2);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
    }
    .filter-btn:not(.active) .filter-count {
        background: var(--gray-300);
        color: white;
    }

    /* Action Buttons */
    .action-buttons .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .action-buttons .btn-primary {
        background: var(--primary);
        border: none;
        color: white;
    }

    .action-buttons .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .action-buttons .btn-primary:disabled {
        background: var(--gray-400);
        cursor: not-allowed;
        transform: none;
    }

    /* Table Card */
    .table-card {
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
    }

    /* Custom Table */
    .gov-table {
        margin: 0;
    }

    .gov-table thead {
        background: var(--gray-100);
    }

    .gov-table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .gov-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
    }

    .gov-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .gov-table tbody tr:hover {
        background-color: var(--gray-50);
    }

    /* Banner Image */
    .banner-image {
        width: 100px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .banner-image:hover {
        border-color: var(--primary);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
    }

    /* Badges */
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
    }

    .bg-success { background-color: var(--success) !important; }
    .bg-secondary { background-color: var(--gray-500) !important; }
    .bg-warning { background-color: var(--warning) !important; color: white !important; }
    .bg-info { background-color: var(--info) !important; color: white !important; }
    .bg-danger { background-color: var(--danger) !important; }

    /* Banner Title */
    .banner-title {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.9375rem;
    }

    /* URL Link */
    .url-link {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }

    .url-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .url-link i {
        font-size: 1rem;
    }

    /* User Info */
    .user-info {
        font-size: 0.875rem;
    }

    .user-name {
        font-weight: 500;
        color: var(--gray-900);
    }

    .user-date {
        color: var(--gray-500);
        font-size: 0.75rem;
        margin-top: 2px;
    }

    /* Action Buttons in Table */
    .gov-table .btn {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
    }

    .gov-table .btn-warning {
        background: var(--warning);
        color: white;
    }

    .gov-table .btn-warning:hover {
        background: #b45309;
        transform: translateY(-1px);
    }

    .gov-table .btn-danger {
        background: var(--danger);
        color: white;
    }

    .gov-table .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }

    /* Image Modal */
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
    }

    .image-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .image-modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        animation: zoomIn 0.3s ease;
    }

    .image-modal-content img {
        width: 100%;
        height: auto;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .modal-close {
        position: absolute;
        top: -50px;
        right: 0;
        color: white;
        font-size: 2rem;
        font-weight: bold;
        cursor: pointer;
        background: var(--danger);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
        border: 2px solid white;
    }

    .modal-close:hover {
        background: #b91c1c;
        transform: rotate(90deg) scale(1.1);
    }

    /* Empty State */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-500);
    }

    .no-data i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 16px;
    }

    /* Switch Toggle Status */
    .status-btn {
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .status-btn:hover {
        opacity: 0.8;
    }

    .status-btn .switch {
        position: relative;
        width: 42px;
        height: 22px;
        background-color: var(--gray-300);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .status-btn .switch::after {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        background-color: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    .status-btn .switch.active {
        background-color: var(--success);
    }

    .status-btn .switch.active::after {
        left: 22px;
    }

    .status-btn .switch-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--gray-700);
        min-width: 65px;
        text-align: left;
    }

    /* MODAL CREATE/EDIT BANNER STYLES */
    .create-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        overflow-y: auto;
        animation: fadeIn 0.3s ease;
    }

    .create-modal.show {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 20px;
    }

    .modal-content-form {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 800px;
        width: 100%;
        position: relative;
        animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        margin: auto;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header-custom {
        padding: 24px 30px;
        border-bottom: 2px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, var(--primary), #4338ca);
        border-radius: 16px 16px 0 0;
    }

    .modal-header-custom h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
    }

    .modal-close-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1.5rem;
        line-height: 1;
    }

    .modal-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .modal-body-custom {
        padding: 30px;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    /* Form Styles in Modal */
    .form-group-modal {
        margin-bottom: 20px;
    }

    .form-label-modal {
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label-modal i {
        color: var(--primary);
        opacity: 0.8;
    }

    .form-control-modal, .form-select-modal {
        background-color: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 0.95rem;
        transition: all 0.25s ease;
        color: var(--text-dark);
        width: 100%;
    }

    .form-control-modal:focus, .form-select-modal:focus {
        background-color: #fff;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .upload-area-modal {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-area-modal:hover {
        border-color: var(--primary);
        background: #eef2ff;
    }

    .upload-icon-circle {
        width: 50px;
        height: 50px;
        background: #e0e7ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: var(--primary);
        transition: 0.3s;
    }

    .upload-area-modal:hover .upload-icon-circle {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
    }

    .current-img-preview {
        max-height: 100px;
        max-width: 200px;
        object-fit: contain;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        padding: 5px;
        background: white;
    }

    .media-input-group {
        display: none;
        animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-submit-modal {
        background: linear-gradient(135deg, var(--primary), #4338ca);
        color: white;
        padding: 12px 32px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-submit-modal:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
    }

    .text-required {
        color: #ef4444;
        margin-left: 3px;
        font-weight: bold;
    }

    .form-text-modal {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-top: 4px;
    }

    /* Limit Info Badge */
    .limit-info {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: #fef3c7;
        border: 1px solid #fbbf24;
        border-radius: 6px;
        font-size: 0.8rem;
        color: #92400e;
        font-weight: 500;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gov-header { padding: 20px; }
        .gov-header h1 { font-size: 1.375rem; }
        .filter-nav { gap: 8px; overflow-x: auto; padding-bottom: 5px; flex-wrap: nowrap; }
        .filter-btn { white-space: nowrap; }
        .gov-table thead th, .gov-table tbody td { padding: 10px 12px; font-size: 0.8125rem; }
        .action-buttons { flex-direction: column; gap: 8px; }
        .action-buttons .btn { width: 100%; }
        .banner-image { width: 80px; height: 50px; }
        .modal-content-form { margin: 20px; }
        .modal-body-custom { padding: 20px; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-card-image"></i>
                Daftar Banner
            </h1>
            <div class="mt-2">
                <span class="limit-info">
                    <i class="bi bi-info-circle"></i>
                    Maksimal 1 banner per kategori
                </span>
            </div>
        </div>
        <div class="action-buttons d-flex gap-2">
            <button onclick="openCreateModal()" class="btn btn-primary" id="btnTambahBanner">
                <i class="bi bi-plus-circle"></i> Tambah Banner
            </button>
        </div>
    </div>

    <div class="filter-nav">
        <button class="filter-btn active" onclick="filterTable('all', this)">
            <i class="bi bi-grid"></i> Semua
            <span class="filter-count" id="count-all">0</span>
        </button>
        <button class="filter-btn" onclick="filterTable('1', this)">
            <i class="bi bi-house"></i> Banner Utama
            <span class="filter-count" id="count-1">0</span>
        </button>
        <button class="filter-btn" onclick="filterTable('2', this)">
            <i class="bi bi-window"></i> Banner Popup
            <span class="filter-count" id="count-2">0</span>
        </button>
        <button class="filter-btn" onclick="filterTable('3', this)">
            <i class="bi bi-newspaper"></i> Banner Berita
            <span class="filter-count" id="count-3">0</span>
        </button>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<?php if (!empty($banners) && is_array($banners)): ?>
    <div class="card table-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table gov-table mb-0" id="bannerTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th style="min-width: 180px;">Judul</th>
                            <th class="text-center" style="width: 130px;">Kategori</th>
                            <th class="text-center" style="width: 100px;">Media</th>
                            <th class="text-center" style="width: 130px;">Gambar</th>
                            <th style="min-width: 150px;">URL</th>
                            <th class="text-center" style="width: 80px;">Sorting</th>
                            <th style="min-width: 140px;">Dibuat Oleh</th>
                            <th style="min-width: 140px;">Diperbarui</th>
                            <th class="text-center" style="min-width: 140px;">Toggle Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($banners as $b): ?>
                            <tr class="banner-row" data-category="<?= $b['category_banner'] ?>">
                                <td class="text-center">
                                    <strong><?= $no++ ?></strong>
                                </td>
                                <td>
                                    <div class="banner-title"><?= esc($b['title']) ?></div>
                                </td>
                                <td class="text-center">
                                    <?php
                                        $kategori = [
                                            1 => ['nama' => 'Banner Utama', 'class' => 'bg-info'],
                                            2 => ['nama' => 'Banner Popup', 'class' => 'bg-warning'],
                                            3 => ['nama' => 'Banner Berita', 'class' => 'bg-success']
                                        ];
                                        $kat = $kategori[$b['category_banner']] ?? ['nama' => '-', 'class' => 'bg-secondary'];
                                    ?>
                                    <span class="badge <?= $kat['class'] ?>"><?= $kat['nama'] ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($b['media_type'])): ?>
                                        <span class="badge bg-info">
                                            <i class="bi bi-film"></i> <?= esc($b['media_type']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($b['image'])): ?>
                                        <img 
                                            src="<?= base_url('uploads/banner/' . $b['image']) ?>" 
                                            alt="Banner" 
                                            class="banner-image"
                                            onclick="openImageModal(this.src, '<?= esc(addslashes($b['title'])) ?>')"
                                            title="Klik untuk memperbesar">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($b['url'])): ?>
                                        <a href="<?= esc($b['url']) ?>" target="_blank" class="url-link" title="<?= esc($b['url']) ?>">
                                            <i class="bi bi-link-45deg"></i>
                                            <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block;">
                                                <?= esc($b['url']) ?>
                                            </span>
                                        </a>
                                    <?php elseif (!empty($b['url_yt'])): ?>
                                        <a href="<?= esc($b['url_yt']) ?>" target="_blank" class="url-link">
                                            <i class="bi bi-youtube"></i> YouTube
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?= esc($b['sorting'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name"><?= esc($b['created_by_name'] ?? '-') ?></div>
                                        <div class="user-date">
                                            <?= esc($b['created_at'] ? date('d/m/Y H:i', strtotime($b['created_at'])) : '-') ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name"><?= esc($b['updated_by_name'] ?? '-') ?></div>
                                        <div class="user-date">
                                            <?= esc($b['updated_at'] ? date('d/m/Y H:i', strtotime($b['updated_at'])) : '-') ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="status-btn" 
                                            data-id="<?= $b['id_banner'] ?>">
                                        <div class="switch <?= ($b['status'] == '1' ? 'active' : '') ?>"></div>
                                        <span class="switch-label">
                                            <?= ($b['status'] == '1' ? 'Aktif' : 'Non-Aktif') ?>
                                        </span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-1">
                                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8') ?>)" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit Banner">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <form action="<?= site_url('banner/'.$b['id_banner']) ?>" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm w-100" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus banner ini?')"
                                                    title="Hapus Banner">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr id="noRowsMessage" style="display: none;">
                            <td colspan="12" class="text-center py-5 text-muted">
                                <i class="bi bi-filter-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2">Tidak ada banner di kategori ini.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="card table-card">
        <div class="card-body">
            <div class="no-data">
                <i class="bi bi-inbox"></i>
                <p class="mb-0">Belum ada data banner</p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Image Preview Modal -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <div class="image-modal-content" onclick="event.stopPropagation()">
        <span class="modal-close" onclick="closeImageModal()" title="Tutup">&times;</span>
        <img id="modalImage" src="" alt="Preview">
    </div>
</div>

<!-- Create Banner Modal -->
<div id="createBannerModal" class="create-modal">
    <div class="modal-content-form">
        <div class="modal-header-custom">
            <h2><i class="bi bi-plus-circle me-2"></i>Tambah Banner Baru</h2>
            <button type="button" class="modal-close-btn" onclick="closeCreateModal()">×</button>
        </div>
        <div class="modal-body-custom">
            <form action="<?= site_url('banner') ?>" method="post" enctype="multipart/form-data" id="createBannerForm">
                <?= csrf_field() ?>

                <div class="form-group-modal">
                    <label for="title" class="form-label-modal">
                        <i class="bi bi-type-h1"></i> Judul Banner <span class="text-required">*</span>
                    </label>
                    <input type="text" name="title" id="title" class="form-control-modal" 
                           placeholder="Contoh: Promo Diskon Akhir Tahun" required>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group-modal">
                            <label for="category_banner" class="form-label-modal">
                                <i class="bi bi-layers"></i> Posisi Penempatan <span class="text-required">*</span>
                            </label>
                            <select name="category_banner" id="category_banner" class="form-select-modal" required>
                                <option value="">-- Pilih Posisi --</option>
                                <option value="1">Banner Utama (Header)</option>
                                <option value="2">Banner Popup</option>
                                <option value="3">Banner Berita</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group-modal">
                            <label for="sorting" class="form-label-modal">
                                <i class="bi bi-sort-numeric-down"></i> Urutan
                            </label>
                            <input type="number" name="sorting" id="sorting" class="form-control-modal" 
                                   min="1" placeholder="1">
                            <div class="form-text-modal">Urutan prioritas (1 = Pertama)</div>
                        </div>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label for="media_type" class="form-label-modal">
                        <i class="bi bi-collection-play"></i> Tipe Konten <span class="text-required">*</span>
                    </label>
                    <select name="media_type" id="media_type" class="form-select-modal" required onchange="handleMediaTypeModal('create')">
                        <option value="">-- Pilih Jenis Media --</option>
                        <option value="image">Gambar / Foto</option>
                        <option value="video">Video Youtube</option>
                    </select>
                </div>

                <div id="group_image_modal" class="form-group-modal media-input-group">
                    <label class="form-label-modal mb-2">Upload File Gambar <span class="text-required">*</span></label>
                    <div class="upload-area-modal" onclick="document.getElementById('image_modal').click()">
                        <input type="file" name="image" id="image_modal" accept="image/*" style="display:none" onchange="previewFileNameModal('create')">
                        
                        <div class="upload-icon-circle">
                            <i class="bi bi-cloud-arrow-up fs-4"></i>
                        </div>
                        
                        <span id="file-label-modal" class="fw-bold" style="color: var(--primary);">Klik area ini untuk memilih gambar</span>
                        <div class="text-muted small mt-2">Format: JPG, PNG (Max 2MB)</div>
                    </div>
                </div>

                <div id="group_video_modal" class="form-group-modal media-input-group">
                    <div class="p-3 bg-white border border-danger border-opacity-25 rounded-3" style="background: #fef2f2 !important;">
                        <label for="url_yt" class="form-label-modal text-danger mb-2">
                            <i class="bi bi-youtube"></i> Link Video Youtube <span class="text-required">*</span>
                        </label>
                        <input type="url" name="url_yt" id="url_yt" class="form-control-modal border-danger border-opacity-25" 
                               placeholder="https://youtube.com/watch?v=..." style="background: white;">
                        <div class="form-text-modal text-danger opacity-75">
                            <i class="bi bi-info-circle me-1"></i> Pastikan video berstatus Publik atau Tidak Terdaftar (Unlisted).
                        </div>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label for="url" class="form-label-modal">
                        <i class="bi bi-link-45deg"></i> Link Redirect (Opsional)
                    </label>
                    <input type="url" name="url" id="url" class="form-control-modal" 
                           placeholder="https://tujuannya.com">
                    <div class="form-text-modal">Pengunjung akan diarahkan ke link ini jika mengklik banner.</div>
                </div>

                <div class="form-group-modal">
                    <label for="keterangan" class="form-label-modal">
                        <i class="bi bi-text-paragraph"></i> Keterangan (Opsional)
                    </label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control-modal" 
                              placeholder="Catatan tambahan..."></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn-submit-modal">
                        <i class="bi bi-check-circle me-2"></i>Simpan Banner
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Edit Banner Modal -->
<div id="editBannerModal" class="create-modal">
    <div class="modal-content-form">
        <div class="modal-header-custom">
            <h2><i class="bi bi-pencil me-2"></i>Edit Banner</h2>
            <button type="button" class="modal-close-btn" onclick="closeEditModal()">×</button>
        </div>
        <div class="modal-body-custom">
            <form action="" method="post" enctype="multipart/form-data" id="editBannerForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id_banner" id="edit_id_banner">

                <div class="form-group-modal">
                    <label for="edit_title" class="form-label-modal">
                        <i class="bi bi-type-h1"></i> Judul Banner <span class="text-required">*</span>
                    </label>
                    <input type="text" name="title" id="edit_title" class="form-control-modal" 
                           placeholder="Contoh: Promo Diskon Akhir Tahun" required>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group-modal">
                            <label for="edit_category_banner" class="form-label-modal">
                                <i class="bi bi-layers"></i> Posisi Penempatan <span class="text-required">*</span>
                            </label>
                            <select name="category_banner" id="edit_category_banner" class="form-select-modal" required>
                                <option value="">-- Pilih Posisi --</option>
                                <option value="1">Banner Utama (Header)</option>
                                <option value="2">Banner Popup</option>
                                <option value="3">Banner Berita</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group-modal">
                            <label for="edit_sorting" class="form-label-modal">
                                <i class="bi bi-sort-numeric-down"></i> Urutan
                            </label>
                            <input type="number" name="sorting" id="edit_sorting" class="form-control-modal" 
                                   min="1" placeholder="1">
                            <div class="form-text-modal">Urutan prioritas (1 = Pertama)</div>
                        </div>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label for="edit_media_type" class="form-label-modal">
                        <i class="bi bi-collection-play"></i> Tipe Konten <span class="text-required">*</span>
                    </label>
                    <select name="media_type" id="edit_media_type" class="form-select-modal" required onchange="handleMediaTypeModal('edit')">
                        <option value="">-- Pilih Jenis Media --</option>
                        <option value="image">Gambar / Foto</option>
                        <option value="video">Video Youtube</option>
                    </select>
                </div>

                <div id="edit_group_image_modal" class="form-group-modal media-input-group">
                    <label class="form-label-modal mb-2">Upload File Gambar Baru</label>
                    
                    <!-- Current Image Preview -->
                    <div id="current_image_container" class="mb-3" style="display:none;">
                        <p class="text-muted small mb-2">Gambar Saat Ini:</p>
                        <img id="current_image_preview" src="" alt="Current" class="current-img-preview">
                    </div>

                    <div class="upload-area-modal" onclick="document.getElementById('edit_image_modal').click()">
                        <input type="file" name="image" id="edit_image_modal" accept="image/*" style="display:none" onchange="previewFileNameModal('edit')">
                        
                        <div class="upload-icon-circle">
                            <i class="bi bi-cloud-arrow-up fs-4"></i>
                        </div>
                        
                        <span id="edit_file-label-modal" class="fw-bold" style="color: var(--primary);">Klik area ini untuk memilih gambar baru</span>
                        <div class="text-muted small mt-2">Format: JPG, PNG (Max 2MB) • Kosongkan jika tidak ingin mengubah</div>
                    </div>
                </div>

                <div id="edit_group_video_modal" class="form-group-modal media-input-group">
                    <div class="p-3 bg-white border border-danger border-opacity-25 rounded-3" style="background: #fef2f2 !important;">
                        <label for="edit_url_yt" class="form-label-modal text-danger mb-2">
                            <i class="bi bi-youtube"></i> Link Video Youtube <span class="text-required">*</span>
                        </label>
                        <input type="url" name="url_yt" id="edit_url_yt" class="form-control-modal border-danger border-opacity-25" 
                               placeholder="https://youtube.com/watch?v=..." style="background: white;">
                        <div class="form-text-modal text-danger opacity-75">
                            <i class="bi bi-info-circle me-1"></i> Pastikan video berstatus Publik atau Tidak Terdaftar (Unlisted).
                        </div>
                    </div>
                </div>

                <div class="form-group-modal">
                    <label for="edit_url" class="form-label-modal">
                        <i class="bi bi-link-45deg"></i> Link Redirect (Opsional)
                    </label>
                    <input type="url" name="url" id="edit_url" class="form-control-modal" 
                           placeholder="https://tujuannya.com">
                    <div class="form-text-modal">Pengunjung akan diarahkan ke link ini jika mengklik banner.</div>
                </div>

                <div class="form-group-modal">
                    <label for="edit_keterangan" class="form-label-modal">
                        <i class="bi bi-text-paragraph"></i> Keterangan (Opsional)
                    </label>
                    <textarea name="keterangan" id="edit_keterangan" rows="3" class="form-control-modal" 
                              placeholder="Catatan tambahan..."></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn-submit-modal">
                        <i class="bi bi-check-circle me-2"></i>Update Banner
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Category Count Data (passed from PHP)
const categoryCount = {
    '1': <?= count(array_filter($banners ?? [], fn($b) => $b['category_banner'] == 1)) ?>,
    '2': <?= count(array_filter($banners ?? [], fn($b) => $b['category_banner'] == 2)) ?>,
    '3': <?= count(array_filter($banners ?? [], fn($b) => $b['category_banner'] == 3)) ?>
};

// Update button counts and disable logic
function updateButtonStates() {
    document.getElementById('count-all').textContent = Object.values(categoryCount).reduce((a,b) => a+b, 0);
    document.getElementById('count-1').textContent = categoryCount['1'];
    document.getElementById('count-2').textContent = categoryCount['2'];
    document.getElementById('count-3').textContent = categoryCount['3'];

    // Disable tambah button if all categories are full
    const allFull = categoryCount['1'] >= 1 && categoryCount['2'] >= 1 && categoryCount['3'] >= 1;
    const btnTambah = document.getElementById('btnTambahBanner');
    
    if (allFull) {
        btnTambah.disabled = true;
        btnTambah.title = 'Semua kategori sudah terisi (maksimal 1 banner per kategori)';
    } else {
        btnTambah.disabled = false;
        btnTambah.title = 'Tambah Banner Baru';
    }
}

// Filter Table
function filterTable(category, btnElement) {
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    btnElement.classList.add('active');

    const rows = document.querySelectorAll('.banner-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const rowCat = row.getAttribute('data-category');
        if (category === 'all' || rowCat === category) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const noMsg = document.getElementById('noRowsMessage');
    if (visibleCount === 0) {
        noMsg.style.display = '';
    } else {
        noMsg.style.display = 'none';
    }
}

// Image Modal Functions
function openImageModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    
    modal.classList.add('show');
    modalImg.src = imageSrc;
    modalImg.alt = imageName;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Create Banner Modal Functions
function openCreateModal() {
    const modal = document.getElementById('createBannerModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    // Reset form
    document.getElementById('createBannerForm').reset();
    handleMediaTypeModal('create');
    
    // Disable kategori yang sudah penuh
    const selectKategori = document.getElementById('category_banner');
    Array.from(selectKategori.options).forEach(option => {
        if (option.value && categoryCount[option.value] >= 1) {
            option.disabled = true;
            option.text = option.text + ' (Penuh)';
        } else {
            option.disabled = false;
            option.text = option.text.replace(' (Penuh)', '');
        }
    });
}

function closeCreateModal() {
    const modal = document.getElementById('createBannerModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Edit Banner Modal Functions
function openEditModal(banner) {
    const modal = document.getElementById('editBannerModal');
    const form = document.getElementById('editBannerForm');
    
    // Set form action
    form.action = '<?= site_url('banner/') ?>' + banner.id_banner;
    
    // Fill form fields
    document.getElementById('edit_id_banner').value = banner.id_banner;
    document.getElementById('edit_title').value = banner.title;
    document.getElementById('edit_category_banner').value = banner.category_banner;
    document.getElementById('edit_sorting').value = banner.sorting || '';
    document.getElementById('edit_media_type').value = banner.media_type;
    document.getElementById('edit_url').value = banner.url || '';
    document.getElementById('edit_url_yt').value = banner.url_yt || '';
    document.getElementById('edit_keterangan').value = banner.keterangan || '';
    
    // Show current image if exists
    if (banner.media_type === 'image' && banner.image) {
        const imgContainer = document.getElementById('current_image_container');
        const imgPreview = document.getElementById('current_image_preview');
        imgContainer.style.display = 'block';
        imgPreview.src = '<?= base_url('uploads/banner/') ?>' + banner.image;
    } else {
        document.getElementById('current_image_container').style.display = 'none';
    }
    
    // Handle media type display
    handleMediaTypeModal('edit');
    
    // Disable other categories (user can't change to full category)
    const selectKategori = document.getElementById('edit_category_banner');
    Array.from(selectKategori.options).forEach(option => {
        if (option.value && option.value != banner.category_banner && categoryCount[option.value] >= 1) {
            option.disabled = true;
            option.text = option.text.replace(' (Penuh)', '') + ' (Penuh)';
        } else {
            option.disabled = false;
            option.text = option.text.replace(' (Penuh)', '');
        }
    });
    
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    const modal = document.getElementById('editBannerModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Handle Media Type in Modal
function handleMediaTypeModal(mode) {
    const prefix = mode === 'edit' ? 'edit_' : '';
    const type = document.getElementById(prefix + 'media_type').value;
    const groupImage = document.getElementById(prefix + 'group_image_modal');
    const inputImage = document.getElementById(prefix + 'image_modal');
    const groupVideo = document.getElementById(prefix + 'group_video_modal');
    const inputVideo = document.getElementById(prefix + 'url_yt');

    groupImage.style.display = 'none';
    groupVideo.style.display = 'none';
    inputImage.required = false;
    inputVideo.required = false;

    if (type === 'image') {
        groupImage.style.display = 'block';
        if (mode === 'create') {
            inputImage.required = true;
        }
        inputVideo.value = '';
    } else if (type === 'video') {
        groupVideo.style.display = 'block';
        inputVideo.required = true;
        inputImage.value = '';
    }
}

// Preview Filename in Modal
function previewFileNameModal(mode) {
    const prefix = mode === 'edit' ? 'edit_' : '';
    const input = document.getElementById(prefix + 'image_modal');
    const label = document.getElementById(prefix + 'file-label-modal');
    
    if(input.files && input.files[0]) {
        label.innerText = "File Terpilih: " + input.files[0].name;
        label.style.color = "#059669";
    }
}

// Close modals on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
        closeCreateModal();
        closeEditModal();
    }
});

// Close create modal when clicking outside
document.getElementById('createBannerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateModal();
    }
});

// Close edit modal when clicking outside
document.getElementById('editBannerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Toggle Status
$(document).on('click', '.status-btn', function () {
    let btn = $(this);
    let id = btn.data('id');
    let switchEl = btn.find('.switch');
    let labelEl = btn.find('.switch-label');
    
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    btn.css('opacity', '0.6').prop('disabled', true);

    $.ajax({
        url: "<?= site_url('banner/toggle-status') ?>",
        type: "POST",
        data: { 
            id: id,
            [csrfName]: csrfHash 
        },
        dataType: "json",
        success: function(res) {
            btn.css('opacity', '1').prop('disabled', false);

            if (res.status === 'success') {
                if (res.token) {
                    csrfHash = res.token;
                    $('input[name="' + csrfName + '"]').val(csrfHash);
                }

                if (res.newStatus == 1) {
                    switchEl.addClass('active');
                    labelEl.text('Aktif');
                } else {
                    switchEl.removeClass('active');
                    labelEl.text('Non-Aktif');
                }
            } else {
                alert('Gagal: ' + (res.message || 'Terjadi kesalahan'));
            }
        },
        error: function(xhr, status, error) {
            btn.css('opacity', '1').prop('disabled', false);
            console.error(error);
            alert('Gagal menghubungi server.');
        }
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateButtonStates();
});
</script>

<?= $this->endSection() ?>