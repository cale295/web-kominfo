<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?><div class="container-fluid px-4">
    <h1 class="mt-4">Program & Anggaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Program</li>
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
            <div><i class="fas fa-table me-1"></i> Data Program</div>
            <?php if (isset($can_create) && $can_create) : ?>
                <a href="<?= base_url('program/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Program
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center align-middle">
                        <tr>
                            <th>No</th>
                            <th>Nama Program & Kegiatan</th>
                            <th>Tahun</th>
                            <th>Nilai Anggaran</th>
                            <th>Lampiran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Menggunakan variable menu_profiles sesuai controller -->
                        <?php if (empty($menu_profiles)) : ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data program.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($menu_profiles as $index => $item) : ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($item['nama_program']) ?></strong><br>
                                        <small class="text-muted"><?= esc($item['nama_kegiatan']) ?></small>
                                    </td>
                                    <td class="text-center"><?= esc($item['tahun']) ?></td>
                                    <td>Rp <?= number_format($item['nilai_anggaran'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($item['file_lampiran'])) : ?>
                                            <a href="<?= base_url($item['file_lampiran']) ?>" target="_blank" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['is_active']) : ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <!-- Tambahkan style width minimal agar tombol tidak turun baris -->
                                    <td class="text-center text-nowrap" style="width: 15%;">
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php if (isset($can_update) && $can_update) : ?>
                                                <!-- Pastikan menggunakan id_program jika itu nama kolom primary key di database -->
                                                <a href="<?= base_url('program/' . $item['id_program'] . '/edit') ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            <?php endif; ?>

                                            <?php if (isset($can_delete) && $can_delete) : ?>
                                                <form action="<?= base_url('program/' . $item['id_program']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? File lampiran juga akan dihapus.');">
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