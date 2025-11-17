<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Manajemen Kategori Dokumen</h5>
            <a href="<?= base_url('dokument_kategori/new') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah
            </a>
    </div>

    <div class="card-body">

        <?php if (empty($dokumentKategori)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mb-0">Belum ada data kategori dokumen</p>
            </div>
        <?php else: ?>
        
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($dokumentKategori as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['category_name']) ?></td>
                                <td><?= esc($row['category_description']) ?></td>

                                <td>
                                    <?php if ($can_update): ?>
                                        <a href="<?= base_url('dokument_kategori/' . $row['id_document_category'].'/edit') ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>

<?php if ($can_delete): ?>
    <form action="<?= base_url('dokument_kategori/' . $row['id_document_category']) ?>" 
          method="post" 
          style="display:inline-block;"
          onsubmit="return confirm('Hapus kategori ini?')">
        
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

        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
