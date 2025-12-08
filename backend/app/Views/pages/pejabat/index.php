<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Pejabat</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Pejabat</li>
    </ol>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><i class="fas fa-table me-1"></i> Data Pejabat</div>
            <?php if (isset($can_create) && $can_create) : ?>
                <a href="<?= base_url('pejabat/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Pejabat
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama & NIP</th>
                            <th>Jabatan</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pejabat)) : ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data pejabat.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($pejabat as $index => $item) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <?php if ($item['foto']) : ?>
                                            <img src="<?= base_url('uploads/pejabat/' . $item['foto']) ?>" 
                                                 alt="Foto <?= esc($item['nama']) ?>" 
                                                 class="img-thumbnail" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        <?php else : ?>
                                            <span class="badge bg-secondary">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= esc($item['nama']) ?></strong><br>
                                        <small class="text-muted">NIP: <?= esc($item['nip']) ?></small>
                                    </td>
                                    <td><?= esc($item['jabatan']) ?></td>
                                    <td><?= esc($item['urutan']) ?></td>
                                    <td>
                                        <?php if ($item['is_active']) : ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                    <?= btn_toggle($item['id_pejabat'], $item['is_active'], 'pejabat/toggle-status') ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (isset($can_update) && $can_update) : ?>
                                                <a href="<?= base_url('pejabat/' . $item['id_pejabat'] . '/edit') ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            <?php endif; ?>

                                            <?php if (isset($can_delete) && $can_delete) : ?>
                                                <form action="<?= base_url('pejabat/' . $item['id_pejabat']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
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
<?= $this->endSection() ?>