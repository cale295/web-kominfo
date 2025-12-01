<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Kontak Social Media</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Kontak Social</li>
    </ol>

    <!-- Alert Success/Error -->
    <?= $this->include('layouts/alerts') ?>
    

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Daftar Social Media
            </div>
            <?php if ($can_create): ?>
                <a href="<?= base_url('kontak_social/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Baru
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Platform</th>
                            <th>Icon</th>
                            <th>Link URL</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kontak_social)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kontak_social as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($item['platform']) ?></td>
                                    <td>
                                        <i class="<?= esc($item['icon_class']) ?>"></i> 
                                        <small class="text-muted ms-2">(<?= esc($item['icon_class']) ?>)</small>
                                    </td>
                                    <td>
                                        <a href="<?= esc($item['link_url']) ?>" target="_blank" class="text-decoration-none">
                                            <?= substr(esc($item['link_url']), 0, 30) ?>...
                                        </a>
                                    </td>
                                    <td><?= esc($item['urutan']) ?></td>
                                    <td>
                                        <?php if ($item['status'] == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <?php if ($can_update || $can_delete): ?>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if ($can_update): ?>
                                                <a href="<?= base_url('kontak_social/' . $item['id_kontak_social'] . '/edit') ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="<?= base_url('kontak_social/' . $item['id_kontak_social']) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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