<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<style>
    :root {
        --primary-blue: #1e40af;
        --secondary-blue: #1e3a8a;
        --accent-gold: #fbbf24;
        --light-gold: #fcd34d;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 8px 24px rgba(30, 64, 175, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header h3 {
        color: white;
        font-weight: 700;
        font-size: 1.8rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .page-header h3 i {
        color: var(--accent-gold);
        font-size: 2rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%);
        border: none;
        color: var(--primary-blue);
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(251, 191, 36, 0.3);
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
        color: var(--secondary-blue);
    }

    .btn-trash {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(100, 116, 139, 0.3);
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .btn-trash:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        color: white;
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    }

    .alert-success {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: none;
        border-left: 4px solid #16a34a;
        border-radius: 12px;
        padding: 16px 20px;
        color: #166534;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);
        animation: slideInDown 0.4s ease-out;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: none;
        border-left: 4px solid #dc2626;
        border-radius: 12px;
        padding: 16px 20px;
        color: #991b1b;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.1);
        animation: slideInDown 0.4s ease-out;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: none;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 16px 20px;
        color: #92400e;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.1);
    }

    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-body {
        padding: 0;
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        margin: 0;
    }

    .table thead {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
    }

    .table thead th {
        color: black;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 16px 14px;
        border: none;
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.9rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.03) 0%, rgba(251, 191, 36, 0.03) 100%);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-number {
        font-weight: 600;
        color: var(--accent-gold);
        background: rgba(251, 191, 36, 0.1);
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .banner-title {
        font-weight: 600;
        color: var(--primary-blue);
        font-size: 0.95rem;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .badge.bg-secondary {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%) !important;
        box-shadow: 0 2px 8px rgba(100, 116, 139, 0.3);
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%) !important;
        color: var(--primary-blue) !important;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }

    .banner-image {
        width: 100px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid var(--accent-gold);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .banner-image:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 16px rgba(251, 191, 36, 0.4);
        border-color: var(--light-gold);
    }

    .no-image {
        font-size: 0.85rem;
        color: #94a3b8;
        font-style: italic;
    }

    .url-link {
        color: var(--primary-blue);
        text-decoration: none;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
    }

    .url-link:hover {
        color: var(--accent-gold);
        text-decoration: underline;
    }

    .url-link i {
        font-size: 0.8rem;
    }

    .user-info {
        font-size: 0.85rem;
    }

    .user-name {
        font-weight: 600;
        color: var(--primary-blue);
    }

    .user-date {
        color: #64748b;
        font-size: 0.75rem;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%);
        color: var(--primary-blue);
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
        color: var(--secondary-blue);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 1.1rem;
        margin: 0;
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
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .modal-close {
        position: absolute;
        top: -45px;
        right: 0;
        color: white;
        font-size: 2rem;
        font-weight: bold;
        cursor: pointer;
        background: rgba(239, 68, 68, 0.9);
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        border: 3px solid white;
    }

    .modal-close:hover {
        background: #dc2626;
        transform: rotate(90deg) scale(1.1);
    }

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

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 992px) {
        .banner-image {
            width: 80px;
            height: 50px;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 24px;
        }

        .page-header h3 {
            font-size: 1.4rem;
        }

        .btn-primary-custom,
        .btn-trash {
            padding: 10px 18px;
            font-size: 0.9rem;
        }

        .table thead th {
            font-size: 0.7rem;
            padding: 12px 8px;
        }

        .table tbody td {
            padding: 10px 8px;
            font-size: 0.8rem;
        }

        .banner-image {
            width: 60px;
            height: 40px;
        }

        .btn-action {
            padding: 5px 10px;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h3>
                <i class="bi bi-card-image"></i>
                Daftar Banner
            </h3>
            <div class="d-flex gap-2 flex-wrap">
                <a href="<?= site_url('banner/trash') ?>" class="btn btn-trash">
                    <i class="bi bi-trash3 me-2"></i>Lihat Sampah
                </a>
                <a href="<?= site_url('banner/new') ?>" class="btn btn-primary-custom">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Banner
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger d-flex align-items-center mb-4">
            <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;"></i>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
    <?php endif; ?>

    <!-- Table Card -->
    <?php if (!empty($banners) && is_array($banners)): ?>
        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="min-width: 180px;">Judul</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 130px;">Kategori</th>
                                <th style="width: 100px;">Media</th>
                                <th style="width: 130px;">Gambar</th>
                                <th style="min-width: 150px;">URL</th>
                                <th style="width: 80px;">Sorting</th>
                                <th style="min-width: 140px;">Dibuat Oleh</th>
                                <th style="min-width: 140px;">Diperbarui</th>
                                <th style="width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($banners as $b): ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="table-number"><?= $no++ ?></div>
                                    </td>
                                    <td>
                                        <div class="banner-title"><?= esc($b['title']) ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($b['status'] === '1'): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Publish
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle me-1"></i>Unpublish
                                            </span>
                                        <?php endif; ?>
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
                                                <i class="bi bi-film me-1"></i><?= esc($b['media_type']) ?>
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
                                            <span class="no-image">Tidak ada gambar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($b['url'])): ?>
                                            <a href="<?= esc($b['url']) ?>" target="_blank" class="url-link">
                                                <i class="bi bi-link-45deg"></i>
                                                <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block;">
                                                    <?= esc($b['url']) ?>
                                                </span>
                                            </a>
                                        <?php elseif (!empty($b['url_yt'])): ?>
                                            <a href="<?= esc($b['url_yt']) ?>" target="_blank" class="url-link">
                                                <i class="bi bi-youtube"></i>YouTube
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
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="<?= site_url('banner/' . $b['id_banner'] . '/edit') ?>" 
                                               class="btn btn-sm btn-warning btn-action" 
                                               title="Edit Banner">
                                                <i class="bi bi-pencil-square"></i>Edit
                                            </a>
                                            <form action="<?= site_url('banner/' . $b['id_banner']) ?>" method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger btn-action"
                                                        onclick="return confirm('Yakin ingin Membuang banner ini?')"
                                                        title="Hapus Banner">
                                                    <i class="bi bi-trash3"></i>Trash
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <i class="bi bi-info-circle me-2" style="font-size: 1.5rem;"></i>
            Belum ada data banner.
        </div>
    <?php endif; ?>
</div>

<!-- Image Modal -->
<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <div class="image-modal-content" onclick="event.stopPropagation()">
        <span class="modal-close" onclick="closeImageModal()" title="Tutup">&times;</span>
        <img id="modalImage" src="" alt="Preview">
    </div>
</div>

<script>
function openImageModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    
    modal.classList.add('show');
    modalImg.src = imageSrc;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// Prevent right click on images
document.addEventListener('contextmenu', function(e) {
    if (e.target.classList.contains('banner-image') || e.target.id === 'modalImage') {
        e.preventDefault();
    }
});
</script>

<?= $this->endSection() ?>