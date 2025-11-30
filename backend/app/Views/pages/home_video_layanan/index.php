<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Video Layanan</h1>
            <p class="text-muted small mb-0">Kelola galeri video dan video unggulan di halaman utama.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Video Layanan</li>
        </ol>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-5"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-video me-2"></i>Daftar Video</h6>
            <?php if ($can_create): ?>
                <a href="/home_video_layanan/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Video
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="text-center py-3" width="15%">Thumbnail</th>
                            <th class="py-3" width="30%">Informasi Video</th>
                            <th class="py-3" width="20%">Link Youtube</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="10%">Urutan</th>
                            <th class="text-center py-3" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($videos)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-film fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada video</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan video baru.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($videos as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($item['thumb_image']) && file_exists($item['thumb_image'])): ?>
                                            <div class="position-relative d-inline-block rounded overflow-hidden shadow-sm border">
                                                <img src="<?= base_url($item['thumb_image']) ?>" alt="Thumbnail" style="height: 60px; width: 100px; object-fit: cover;">
                                                <div class="position-absolute top-50 start-50 translate-middle text-white">
                                                    <i class="fas fa-play-circle fa-lg opacity-75"></i>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center text-muted small" style="height: 60px; width: 100px;">
                                                No Thumb
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['title']) ?></div>
                                        <?php if ($item['is_featured'] == 1): ?>
                                            <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i> Utama</span>
                                        <?php endif; ?>
                                        <div class="small text-muted mt-1 text-truncate" style="max-width: 250px;">
                                            <?= esc($item['description']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?= esc($item['youtube_url']) ?>" target="_blank" class="text-decoration-none small text-truncate d-inline-block" style="max-width: 200px;">
                                            <i class="fab fa-youtube text-danger me-1"></i> <?= esc($item['youtube_url']) ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['is_active'] == 1) : ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success px-2">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary px-2">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border"><?= esc($item['sorting']) ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/home_video_layanan/<?= $item['id_video_layanan'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/home_video_layanan/<?= $item['id_video_layanan'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Hapus">
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
    </div>
</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?= $this->endSection() ?>