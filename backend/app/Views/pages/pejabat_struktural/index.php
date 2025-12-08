<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Pejabat Struktural</h1>
            <p class="text-muted small mb-0">Kelola daftar struktur organisasi dan pejabat terkait.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Pejabat Struktural</li>
        </ol>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-sitemap me-2"></i>Daftar Struktur Organisasi
            </h6>
            <?php if ($can_create): ?>
                <a href="<?= base_url('pejabat_struktural/new') ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </a>
            <?php endif; ?>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="text-center py-3" width="15%">Gambar</th>
                            <th class="py-3">Info Struktur</th>
                            <th class="text-center py-3">Status</th>
                            <th class="text-center py-3">Toggle</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th class="text-center py-3" width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pejabat_struktural)): ?>
                            <tr>
                                <td colspan="<?= ($can_update || $can_delete) ? 6 : 5 ?>" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-sitemap fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan pejabat struktural baru.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pejabat_struktural as $index => $item): ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <?php if (!empty($item['image_url'])): ?>
                                            <div class="position-relative d-inline-block rounded overflow-hidden shadow-sm border bg-light">
                                                <img src="<?= base_url('uploads/pejabat_struktural/' . $item['image_url']) ?>" 
                                                     alt="Preview" 
                                                     style="height: 60px; width: auto; object-fit: cover;">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">No Image</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['title']) ?></div>
                                        <div class="small text-muted"><?= esc($item['subtitle']) ?></div>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($item['is_active'] == 1): ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success px-2">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary px-2">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <?= btn_toggle($item['id_pejabat_s'], $item['is_active'], 'pejabat_struktural/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center align-items-center h-100">
                                                <?php if ($can_update): ?>
                                                    <a href="<?= base_url('pejabat_struktural/' . $item['id_pejabat_s'] . '/edit') ?>" 
                                                       class="btn btn-outline-warning btn-sm rounded-circle shadow-sm" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="<?= base_url('pejabat_struktural/' . $item['id_pejabat_s']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                                data-bs-toggle="tooltip" 
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
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
    .img-thumbnail { border-radius: 8px; }
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