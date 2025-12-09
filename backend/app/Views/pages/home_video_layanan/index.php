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
    
    .badge-soft-warning { background-color: var(--warning-soft); color: var(--warning-text); }

    /* Image Hover Effect */
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: block;
        overflow: hidden;
        border-radius: 0.5rem;
    }
    .img-hover-zoom img {
        transition: transform 0.3s ease;
    }
    .img-hover-zoom:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .img-hover-zoom:hover img {
        transform: scale(1.1);
    }
    
    /* Play Icon Overlay */
    .play-overlay {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 30px; height: 30px;
        background: rgba(0,0,0,0.6);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white;
        backdrop-filter: blur(2px);
        transition: all 0.2s;
    }
    .img-hover-zoom:hover .play-overlay {
        background: #dc2626; /* YouTube Red */
        transform: translate(-50%, -50%) scale(1.2);
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
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Video Layanan</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-video me-1 text-primary"></i> 
                Kelola galeri video dan video unggulan (featured) di halaman utama.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Video Layanan</li>
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
                <h5 class="fw-bold text-dark mb-0">Daftar Video</h5>
                <span class="text-muted small">Kelola konten multimedia</span>
            </div>
            
            <?php if ($can_create): ?>
                <a href="/home_video_layanan/new" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Video
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">No</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Thumbnail</th>
                            <th class="py-3 text-uppercase" width="30%">Informasi Video</th>
                            <th class="py-3 text-uppercase" width="20%">Link Youtube</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Urutan</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($videos)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="fas fa-film fa-4x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada video</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan video baru untuk ditampilkan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($videos as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <?php if (!empty($item['thumb_image']) && file_exists($item['thumb_image'])): ?>
                                            <div class="position-relative d-inline-block img-hover-zoom shadow-sm border" style="width: 120px; height: 70px;">
                                                <img src="<?= base_url($item['thumb_image']) ?>" alt="Thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                                                <div class="play-overlay">
                                                    <i class="fas fa-play fa-xs"></i>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light border rounded d-flex flex-column align-items-center justify-content-center text-muted small mx-auto" style="width: 120px; height: 70px;">
                                                <i class="fas fa-image mb-1 opacity-50"></i>
                                                <span style="font-size: 0.7rem">No Thumb</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['title']) ?></div>
                                        
                                        <?php if ($item['is_featured'] == 1): ?>
                                            <span class="badge badge-soft-warning border border-warning rounded-pill px-2 mb-1">
                                                <i class="fas fa-star me-1" style="font-size: 0.6rem;"></i> Utama
                                            </span>
                                        <?php endif; ?>
                                        
                                        <div class="small text-muted text-truncate" style="max-width: 250px;">
                                            <?= esc($item['description']) ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <a href="<?= esc($item['youtube_url']) ?>" target="_blank" 
                                           class="btn btn-light btn-sm text-danger text-decoration-none border shadow-sm px-3 rounded-pill" 
                                           style="font-size: 0.8rem; max-width: 200px;" 
                                           data-bs-toggle="tooltip" title="Tonton di Youtube">
                                            <i class="fab fa-youtube me-2"></i>
                                            <span class="d-inline-block text-truncate align-middle" style="max-width: 120px; color: #333;">
                                                <?= esc($item['youtube_url']) ?>
                                            </span>
                                        </a>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill font-monospace" style="font-size: 0.85rem;">
                                            <?= esc($item['sorting']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_video_layanan'], $item['is_active'], 'home_video_layanan/toggle-status') ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/home_video_layanan/<?= $item['id_video_layanan'] ?>/edit" 
                                                   class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                   style="width: 32px; height: 32px;"
                                                   data-bs-toggle="tooltip" title="Edit Video">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/home_video_layanan/<?= $item['id_video_layanan'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');">
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
                <span>Video dengan status <strong>"Utama"</strong> akan muncul di posisi utama</span>
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