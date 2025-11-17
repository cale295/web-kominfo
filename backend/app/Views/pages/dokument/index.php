<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Manajemen Dokumen</h5>

        <?php if ($can_create): ?>
        <a href="<?= base_url('dokument/new') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus"></i> Tambah Dokumen
        </a>
        <?php endif; ?>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-center">
                        <th width="50">#</th>
                        <th>Nama Dokumen</th>
                        <th>Kategori</th>
                        <th>File</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dokument)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox"></i> Belum ada data dokumen
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php $no = 1; foreach ($dokument as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($row['document_name']) ?></td>
                        <td><?= esc($row['category_name']) ?></td>
                        <td>
                            <?php if (!empty($row['file_path'])): ?>
                                <a href="<?= base_url($row['file_path']) ?>" target="_blank">Lihat File</a>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if ($can_update): ?>
                                <a href="<?= base_url('dokument/' . $row['id_document']) ?>/edit" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ($can_delete): ?>
                                <form action="<?= base_url('dokument/' . $row['id_document']) ?>" 
                                      method="post" 
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus dokumen ini?')">

                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">

                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
