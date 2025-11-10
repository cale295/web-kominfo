<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">🗑️ Sampah Berita</h3>
        <a href="<?= site_url('berita') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Diperbarui Oleh</th>
                        <th>Tanggal Update</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($berita)): ?>
                        <?php foreach ($berita as $row): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($row['judul']) ?></td>
                                <td><?= esc($row['kategori']) ?></td>
                                <td><?= esc($row['updated_by_name']) ?></td>
                                <td><?= date('d M Y H:i', strtotime($row['updated_at'])) ?></td>
                                <td class="text-center">
                                    <a href="<?= site_url('berita/' . $row['id_berita'] . '/restore') ?>" 
                                       class="btn btn-success btn-sm px-3 me-1">
                                        <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                                    </a>
                                   <form action="<?= site_url('berita/' . $row['id_berita'] . '/destroyPermanent') ?>" method="post" style="display:inline;">
    <?= csrf_field() ?>
    <button class="btn btn-sm btn-danger"
        onclick="return confirm('Yakin hapus permanen? Semua berita terkait akan tetap ada, tapi kategori akan hilang.')">
        Hapus Permanen
    </button>
</form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Tidak ada berita di sampah.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
