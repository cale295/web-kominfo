<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📜 Daftar Berita</h3>
        <div>
            <a href="<?= site_url('berita/new') ?>" class="btn btn-primary">+ Tambah Berita</a>
            <a href="<?= site_url('berita/trash') ?>" class="btn btn-secondary">🗑️ Sampah</a>
        </div>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th width="5%">#</th>
                <th width="10%">Gambar</th>
                <th>Judul</th>
                <th>Topik</th>
                <th>Kategori</th>
                <th>Status Tayang</th>
                <th>Status Berita</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Dibuat</th>
                <th width="12%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($berita)): ?>
                <?php foreach ($berita as $i => $row): ?>
                    <tr>
                        <td class="text-center"><?= $i + 1 ?></td>

                        <!-- Thumbnail -->
                        <td class="text-center">
                            <?php if (!empty($row['feat_image'])): ?>
                                <img src="<?= base_url('uploads/berita/' . $row['feat_image']) ?>" 
                                     alt="Gambar Berita" 
                                     class="img-thumbnail" 
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                        </td>

                        <!-- Judul -->
                        <td><?= esc($row['judul']) ?></td>

                        <!-- Topik -->
                        <td><?= esc($row['topik'] ?? '-') ?></td>

                        <!-- Kategori -->
                        <td><?= esc($row['nama_kategori'] ?? '-') ?></td>

                        <!-- Status Tayang -->
                        <td class="text-center">
                            <?php if ($row['status'] == '1'): ?>
                                <span class="badge bg-success">Tayang</span>
                            <?php elseif ($row['status'] == '0'): ?>
                                <span class="badge bg-secondary">Tidak Tayang</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Draft</span>
                            <?php endif; ?>
                        </td>

                        <!-- Status Berita -->
                        <td class="text-center">
                            <?php
                                $statusBerita = [
                                    '0' => ['bg-secondary', 'Draft'],
                                    '2' => ['bg-info text-dark', 'Menunggu Verifikasi'],
                                    '3' => ['bg-warning text-dark', 'Perbaikan'],
                                    '4' => ['bg-success', 'Layak Tayang'],
                                    '6' => ['bg-danger', 'Revisi']
                                ];
                                [$class, $text] = $statusBerita[$row['status_berita']] ?? ['bg-light text-dark', '-'];
                            ?>
                            <span class="badge <?= $class ?>"><?= $text ?></span>
                        </td>

                        <!-- Pembuat -->
                        <td class="text-center"><?= esc($row['created_by_name'] ?? '-') ?></td>

                        <!-- Tanggal -->
                        <td class="text-center"><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>

                        <!-- Aksi -->
                        <td class="text-center">
                            <a href="<?= site_url('berita/'.$row['id_berita'].'/edit') ?>" class="btn btn-sm btn-warning">✏️</a>
                            <a href="<?= site_url('berita/delete/'.$row['id_berita']) ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Yakin ingin hapus berita ini?')">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="10" class="text-center text-muted">Belum ada berita</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
