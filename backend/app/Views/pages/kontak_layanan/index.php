<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Kontak Layanan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kontak Layanan</li>
                </ol>
            </nav>
        </div>
        <?php if ($can_create): ?>
            <a href="/kontak_layanan/new" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Tambah Baru
            </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table me-1"></i> Daftar Data Layanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="25%">Judul Info</th>
                            <th width="10%" class="text-center">Icon</th>
                            <th width="15%">Kontak</th>
                            <th width="10%" class="text-center">Urutan</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kontaklayanan)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-folder-open fa-2x mb-2"></i><br>Belum ada data tersedia.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($kontaklayanan as $i => $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($row['judul']) ?></div>
                                        <small class="text-muted"><?= esc($row['subjudul']) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center mx-auto text-white shadow-sm" 
                                             style="width: 40px; height: 40px; border-radius: 50%; background-color: <?= esc($row['icon_bg_color']) ?>;">
                                            <i class="<?= esc($row['icon_class']) ?>"></i>
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size: 0.7rem;"><?= esc($row['icon_class']) ?></small>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <?php if ($row['link_url']) : ?>
                                                <a href="<?= esc($row['link_url']) ?>" target="_blank" class="text-decoration-none text-truncate d-block" style="max-width: 150px;">
                                                    <i class="fas fa-link text-muted me-1"></i> Link
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= esc($row['urutan']) ?></td>
                                    <td class="text-center">
                                        <?php if ($row['status'] == 'aktif') : ?>
                                            <span class="badge rounded-pill bg-success">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?php if ($can_update) : ?>
                                                <a href="/kontak_layanan/<?= $row['id_kontak_layanan'] ?>/edit" class="btn btn-warning btn-sm text-white" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if ($can_delete) : ?>
                                                <form action="/kontak_layanan/<?= $row['id_kontak_layanan'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="fas fa-trash"></i>
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