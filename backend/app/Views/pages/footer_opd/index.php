<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Footer OPD</h1>
            <p class="text-muted small mb-0">Kelola informasi identitas, kontak, dan aset visual footer website.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Footer OPD</li>
        </ol>
    </div>

    <!-- Alert Messages -->
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
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table me-2"></i>Daftar Data</h6>
            <?php if ($can_create): ?>
                <a href="/footer_opd/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="30%">Identitas Website</th>
                            <th class="py-3" width="20%">Kontak & Alamat</th>
                            <th class="text-center py-3" width="15%">Aset Visual</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($footer_opd)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-folder-open fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data tersedia</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan data baru untuk memulai.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($footer_opd as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1 fs-6"><?= esc($item['website_name']) ?></div>
                                        <div class="small text-muted fst-italic border-start border-3 border-primary ps-2">
                                            <?= esc($item['official_title']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1 small">
                                            <span class="text-truncate" title="<?= esc($item['address']) ?>">
                                                <i class="fas fa-map-marker-alt me-2 text-danger w-15px text-center"></i>
                                                <?= strlen($item['address']) > 40 ? substr($item['address'], 0, 40) . '...' : esc($item['address']) ?>
                                            </span>
                                            <?php if($item['email']): ?>
                                                <span><i class="fas fa-envelope me-2 text-warning w-15px text-center"></i> <?= esc($item['email']) ?></span>
                                            <?php endif; ?>
                                            <?php if($item['phone']): ?>
                                                <span><i class="fas fa-phone me-2 text-success w-15px text-center"></i> <?= esc($item['phone']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <?php if (!empty($item['logo_cominfo']) && file_exists($item['logo_cominfo'])): ?>
                                                <div class="p-1 border rounded bg-light" data-bs-toggle="tooltip" title="Logo Kominfo">
                                                    <img src="<?= base_url($item['logo_cominfo']) ?>" alt="Logo" style="height: 35px; width: auto; object-fit: contain;">
                                                </div>
                                            <?php endif; ?>

                                            <?php if (!empty($item['election_badge']) && file_exists($item['election_badge'])): ?>
                                                <div class="p-1 border rounded bg-light" data-bs-toggle="tooltip" title="Badge Pemilu">
                                                    <img src="<?= base_url($item['election_badge']) ?>" alt="Badge" style="height: 35px; width: auto; object-fit: contain;">
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (empty($item['logo_cominfo']) && empty($item['election_badge'])): ?>
                                                <span class="badge bg-light text-muted border">No Image</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['is_active'] == 1) : ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success px-3">
                                                <i class="fas fa-check-circle me-1"></i> Aktif
                                            </span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary px-3">
                                                <i class="fas fa-ban me-1"></i> Non-Aktif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                    <?= btn_toggle($item['id_opd_info'], $item['is_active'], 'footer_opd/toggle-status') ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/footer_opd/<?= $item['id_opd_info'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/footer_opd/<?= $item['id_opd_info'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Hapus Permanen">
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
        <div class="card-footer bg-white py-3 border-top-0">
            <div class="small text-muted d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                <span>Menampilkan seluruh data informasi footer yang terdaftar di sistem.</span>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    .w-15px { width: 15px; display: inline-block; }
</style>

<script>
    // Initialize Bootstrap Tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?= $this->endSection() ?>