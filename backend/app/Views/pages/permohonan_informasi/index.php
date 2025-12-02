<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Permohonan Informasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Dokumen</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-file-invoice me-1"></i>
                File Permohonan Informasi
            </div>
            <?php if ($can_create): ?>
                <a href="<?= base_url('permohonan_informasi/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Dokumen
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul Dokumen</th>
                            <th>Tahun</th>
                            <th>File</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($documents)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3">Belum ada data dokumen.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($documents as $index => $item): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= esc($item['judul_dokumen']) ?></td>
                                    <td><?= esc($item['tahun']) ?></td>
                                    <td>
                                        <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Unduh
                                        </a>
                                    </td>
                                    
                                    <?php if ($can_update || $can_delete): ?>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if ($can_update): ?>
                                                <a href="<?= base_url('permohonan_informasi/' . $item['id_permohonan'] . '/edit') ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="<?= base_url('permohonan_informasi/' . $item['id_permohonan']) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?');">
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