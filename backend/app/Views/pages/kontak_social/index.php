<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Kontak Social Media</h1>
            <p class="text-muted small mb-0">Kelola tautan media sosial dan platform komunikasi lainnya.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kontak Social</li>
        </ol>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-share-alt me-2"></i>Daftar Social Media
            </h6>
            <?php if ($can_create): ?>
                <a href="<?= base_url('kontak_social/new') ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="15%">Platform</th>
                            <th class="py-3" width="15%">Icon Class</th>
                            <th class="py-3" width="25%">Link URL</th>
                            <th class="text-center py-3" width="10%">Urutan</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="10%">Toggle</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th class="text-center py-3" width="10%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kontak_social)): ?>
                            <tr>
                                <td colspan="<?= ($can_update || $can_delete) ? 8 : 7 ?>" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-hashtag fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan akun media sosial baru.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kontak_social as $index => $item): ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark"><?= esc($item['platform']) ?></span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light text-primary border rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 32px; height: 32px;">
                                                <i class="<?= esc($item['icon_class']) ?>"></i>
                                            </div>
                                            <code class="small text-muted"><?= esc($item['icon_class']) ?></code>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="<?= esc($item['link_url']) ?>" target="_blank" class="text-decoration-none d-block text-truncate" style="max-width: 200px;" title="<?= esc($item['link_url']) ?>">
                                            <i class="fas fa-external-link-alt small me-1"></i>
                                            <?= esc($item['link_url']) ?>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border"><?= esc($item['urutan']) ?></span>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($item['status'] == '1'): ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success px-2">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary px-2">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <?= btn_toggle($item['id_kontak_social'], $item['status'], 'kontak_social/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center align-items-center h-100">
                                                <?php if ($can_update): ?>
                                                    <a href="<?= base_url('kontak_social/' . $item['id_kontak_social'] . '/edit') ?>" 
                                                       class="btn btn-outline-warning btn-sm rounded-circle shadow-sm" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="<?= base_url('kontak_social/' . $item['id_kontak_social']) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                                data-bs-toggle="tooltip" 
                                                                title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
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