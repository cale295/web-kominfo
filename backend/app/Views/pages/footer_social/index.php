<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Social Media Footer</h1>
            <p class="text-muted small mb-0">Kelola tautan sosial media yang tampil di footer website.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Social Media</li>
        </ol>
    </div>



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
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-share-alt me-2"></i>Daftar Akun</h6>
            <?php if ($can_create): ?>
                <a href="/footer_social/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Akun
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
                            <th class="py-3">Platform & Akun</th>
                            <th class="py-3">Link URL</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="10%">Urutan</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($social_media)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-globe-americas fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data</h6>
                                    <p class="small text-muted mb-0">Tambahkan akun sosial media resmi.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($social_media as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle shadow-sm" style="width: 40px; height: 40px;">
                                            <i class="fab fa-<?= esc($item['platform_icon']) ?> fs-5 text-primary"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['platform_name']) ?></div>
                                        <div class="small text-muted">@<?= esc($item['account_name']) ?></div>
                                    </td>
                                    <td>
                                        <a href="<?= esc($item['account_url']) ?>" target="_blank" class="text-decoration-none small text-truncate d-inline-block" style="max-width: 200px;">
                                            <i class="fas fa-external-link-alt me-1"></i> <?= esc($item['account_url']) ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['is_active'] == '1') : ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success px-2">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary px-2">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm"><?= esc($item['sorting']) ?></span>
                                    </td>
                                    <td class="text-center">
                                    <?= btn_toggle($item['id_footer_social'], $item['is_active'], 'footer_social/toggle-status') ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/footer_social/<?= $item['id_footer_social'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/footer_social/<?= $item['id_footer_social'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
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
<?= $this->endSection() ?>