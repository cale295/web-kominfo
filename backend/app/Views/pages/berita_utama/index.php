<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📌 Daftar Berita Utama</h4>
        <?php if (!empty($can_create) && $can_create): ?>
            <a href="<?= site_url('berita-utama/new') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Berita Utama
            </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Gambar</th> <!-- Kolom baru untuk gambar -->
                <th>Judul Berita</th>
                <th>Dibuat Oleh</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th width="130">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($beritaUtama)): ?>
                <?php foreach ($beritaUtama as $i => $b): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?php if(!empty($b['feat_image'])): ?>
                                <img src="<?= base_url('uploads/berita/' . $b['feat_image']) ?>" 
                                     alt="<?= esc($b['judul']) ?>" 
                                     class="img-thumbnail" 
                                     style="max-height:60px; object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada gambar</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($b['judul']) ?></td>
                        <td><?= esc($b['created_by_name'] ?? '-') ?></td>
                        <td>
                            <span class="badge bg-<?= $b['status'] ? 'success' : 'secondary' ?>">
                                <?= $b['status'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </td>
                        <td><?= date('d M Y H:i', strtotime($b['created_date'])) ?></td>
                        <td>
                            <?php if (!empty($can_update) && $can_update): ?>
                                <a href="<?= site_url('berita-utama/'.$b['id_berita_utama'].'/edit') ?>" 
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($can_delete) && $can_delete): ?>
                                <form action="<?= site_url('berita-utama/'.$b['id_berita_utama']) ?>" 
                                      method="post" style="display:inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus berita utama ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">Belum ada berita utama.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
