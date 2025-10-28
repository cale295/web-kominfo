<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Kategori</h3>
        <div class="d-flex gap-2">
            <a href="<?= site_url('kategori/trash') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-trash-alt me-1"></i> Trash
            </a>
            <a href="<?= site_url('kategori/new') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="12%" class="text-center">Tampil Nav</th>
                            <th width="10%" class="text-center">Urutan</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kategori)): ?>
                            <?php foreach ($kategori as $i => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td class="fw-semibold"><?= esc($row['kategori']) ?></td>
                                    <td class="text-muted"><?= esc($row['keterangan']) ?></td>
                                    <td class="text-center">
                                        <?php if ($row['status']): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row['is_show_nav'] == '1'): ?>
                                            <span class="badge bg-info">Ya</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">Tidak</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-dark"><?= $row['sorting_nav'] ?? '-' ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= site_url('kategori/' . $row['id_kategori'] . '/edit') ?>" 
                                           class="btn btn-sm btn-warning me-1" 
                                           title="Edit">
                                            Edit
                                        </a>
                                        <form action="<?= site_url('kategori/' . $row['id_kategori']) ?>" 
                                              method="post" 
                                              style="display:inline;">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin hapus kategori ini?')"
                                                    title="Hapus">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                    Belum ada data kategori
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .card {
        border-radius: 10px;
    }
    
    thead th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<?= $this->endSection() ?>