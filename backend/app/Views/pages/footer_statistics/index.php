<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>


<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Footer Statistics</h1>
        <?php if ($can_create): ?>
            <a href="<?= base_url('footer_statistics/new') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        <?php endif; ?>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Statistik</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Icon</th>
                            <th>Label</th>
                            <th>Value</th>
                            <th>Type</th>
                            <th>Sorting</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($statistics)): ?>
                            <?php foreach ($statistics as $key => $row): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td class="text-center">
                                        <i class="<?= $row['stat_icon'] ?> fa-lg"></i>
                                        <br><small class="text-muted"><?= $row['stat_icon'] ?></small>
                                    </td>
                                    <td><?= esc($row['stat_label']) ?></td>
                                    <td><?= esc($row['stat_value']) ?></td>
                                    <td><span class="badge bg-info text-dark"><?= esc($row['stat_type']) ?></span></td>
                                    <td><?= esc($row['sorting']) ?></td>
                                    <td>
                                        <?php if ($row['is_active']): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($can_update): ?>
                                            <a href="<?= base_url('footer_statistics/' . $row['id_footer_statis'] . '/edit') ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($can_delete): ?>
                                            <form action="<?= base_url('footer_statistics/' . $row['id_footer_statis']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data statistik.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>