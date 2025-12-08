<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Pejabat Struktural</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Pejabat Struktural</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-sitemap me-1"></i>
                Daftar Struktur Organisasi
            </div>
            <?php if ($can_create): ?>
                <a href="<?= base_url('pejabat_struktural/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Gambar</th>
                            <th>Info Struktur</th>
                            <th>Status</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pejabat_struktural)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">Belum ada data.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pejabat_struktural as $index => $item): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($item['image_url'])): ?>
                                            <img src="<?= base_url('uploads/pejabat_struktural/' . $item['image_url']) ?>" 
                                                 alt="Preview" 
                                                 class="img-thumbnail" 
                                                 style="height: 80px; width: auto;">
                                        <?php else: ?>
                                            <span class="text-muted small">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <h6 class="fw-bold mb-0"><?= esc($item['title']) ?></h6>
                                        <small class="text-muted"><?= esc($item['subtitle']) ?></small>
                                    </td>
                                    <td>
                                        <?php if ($item['is_active'] == 1): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                    <?= btn_toggle($item['id_pejabat_s'], $item['is_active'], 'pejabat_struktural/toggle-status') ?>
                                    </td>
                                    <?php if ($can_update || $can_delete): ?>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if ($can_update): ?>
                                                <a href="<?= base_url('pejabat_struktural/' . $item['id_pejabat_s'] . '/edit') ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="<?= base_url('pejabat_struktural/' . $item['id_pejabat_s']) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm">
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
<?= $this->endSection() ?>