<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Layanan Utama</h1>
            <p class="text-muted small mb-0">Kelola daftar layanan/shortcut yang tampil di halaman utama.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Home Service</li>
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
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list-ul me-2"></i>Daftar Layanan</h6>
            <?php if ($can_create): ?>
                <a href="/home_service/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Layanan
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="text-center py-3" width="10%">Icon</th>
                            <th class="py-3" width="30%">Nama Layanan</th>
                            <th class="py-3" width="25%">URL Tujuan</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="10%">Urutan</th>
                            <th class="text-center py-3" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($services)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-concierge-bell fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data layanan</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan data baru untuk memulai.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($services as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($item['icon_image']) && file_exists($item['icon_image'])): ?>
                                            <div class="p-1 border rounded bg-light d-inline-block">
                                                <img src="<?= base_url($item['icon_image']) ?>" alt="Icon" style="height: 40px; width: 40px; object-fit: contain;">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">No Icon</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['title']) ?></div>
                                        <div class="small text-muted">Diupdate: <?= date('d M Y', strtotime($item['updated_at'])) ?></div>
                                    </td>
                                    <td>
                                        <?php if ($item['link']): ?>
                                            <a href="<?= esc($item['link']) ?>" target="_blank" class="text-decoration-none small text-truncate d-inline-block" style="max-width: 250px;">
                                                <i class="fas fa-external-link-alt me-1 text-primary"></i> <?= esc($item['link']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
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
                                                <a href="/home_service/<?= $item['id_service'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/home_service/<?= $item['id_service'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
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
    // Initialize Tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?= $this->endSection() ?>