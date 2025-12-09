<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    :root {
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
    }

    /* Gradient Title */
    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Modern Card */
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    /* Soft Badges & Buttons */
    .btn-soft-primary { background-color: var(--primary-soft); color: var(--primary-text); border: none; }
    .btn-soft-primary:hover { background-color: #4f46e5; color: white; }
    
    .btn-soft-danger { background-color: var(--danger-soft); color: var(--danger-text); border: none; }
    .btn-soft-danger:hover { background-color: #dc2626; color: white; }

    /* Image Hover Effect */
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .img-hover-zoom:hover {
        transform: scale(1.5);
        z-index: 10;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        cursor: zoom-in;
    }

    /* Table Styling */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 2px solid #f3f4f6;
    }
    .table tbody tr td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .icon-wrapper {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 5px;
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Layanan Utama</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-th-large me-1 text-primary"></i> 
                Kelola daftar layanan/shortcut yang tampil di halaman utama website.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Home Service</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-danger me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Terjadi Kesalahan!</h6>
                    <small><?= session()->getFlashdata('error') ?></small>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Layanan</h5>
                <span class="text-muted small">Kelola shortcut aplikasi atau layanan publik</span>
            </div>
            
            <?php if ($can_create): ?>
                <a href="/home_service/new" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Layanan
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">No</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Icon</th>
                            <th class="py-3 text-uppercase" width="25%">Nama Layanan</th>
                            <th class="py-3 text-uppercase" width="25%">URL Tujuan</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Urutan</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($services)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="fas fa-concierge-bell fa-4x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada layanan</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan layanan baru untuk ditampilkan di beranda.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($services as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?php if (!empty($item['icon_image']) && file_exists($item['icon_image'])): ?>
                                                <div class="icon-wrapper shadow-sm img-hover-zoom">
                                                    <img src="<?= base_url($item['icon_image']) ?>" alt="Icon" style="width: 100%; height: 100%; object-fit: contain;">
                                                </div>
                                            <?php else: ?>
                                                <span class="badge bg-light text-secondary border rounded-pill px-3 py-2">No Icon</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['title']) ?></div>
                                        <div class="d-flex align-items-center text-muted small mt-1">
                                            <i class="far fa-clock me-1 text-secondary" style="font-size: 0.7rem;"></i>
                                            <span>Update: <?= date('d M Y', strtotime($item['updated_at'])) ?></span>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <?php if ($item['link']): ?>
                                            <a href="<?= esc($item['link']) ?>" target="_blank" 
                                               class="btn btn-light btn-sm text-primary text-decoration-none border shadow-sm px-3 rounded-pill" 
                                               style="font-size: 0.8rem; max-width: 250px;" 
                                               data-bs-toggle="tooltip" title="Kunjungi URL">
                                                <i class="fas fa-external-link-alt me-2"></i>
                                                <span class="d-inline-block text-truncate align-middle" style="max-width: 150px;">
                                                    <?= esc($item['link']) ?>
                                                </span>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">- Tidak ada link -</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill font-monospace" style="font-size: 0.85rem;">
                                            <?= esc($item['sorting']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_service'], $item['is_active'], 'home_service/toggle-status') ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/home_service/<?= $item['id_service'] ?>/edit" 
                                                   class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                   style="width: 32px; height: 32px;"
                                                   data-bs-toggle="tooltip" title="Edit Layanan">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/home_service/<?= $item['id_service'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" 
                                                            class="btn btn-soft-danger btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                            style="width: 32px; height: 32px;"
                                                            data-bs-toggle="tooltip" title="Hapus Permanen">
                                                        <i class="fas fa-trash-alt fa-xs"></i>
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
            <div class="d-flex align-items-center text-muted small">
                <i class="fas fa-sort-numeric-down me-2 text-primary"></i>
                <span>Gunakan kolom <strong>Urutan</strong> untuk mengatur posisi tampilan layanan di halaman utama.</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<?= $this->endSection() ?>