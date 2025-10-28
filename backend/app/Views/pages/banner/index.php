<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>\


<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Daftar Banner</h3>
        <div class="d-flex gap-2">
            <a href="<?= site_url('banner/trash') ?>" class="btn btn-secondary">
                <i class="bi bi-trash3"></i> Lihat Sampah
            </a>
            <a href="<?= site_url('banner/new') ?>" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Banner
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

        <?= $this->include('layouts/alerts') ?>

    <?php if (!empty($banners) && is_array($banners)): ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th width="5%">#</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Kategori</th>
                        <th>Media</th>
                        <th>Gambar</th>
                        <th>URL</th>
                        <th>Sorting</th>
                        <th>Dibuat Oleh</th>
                        <th>Diperbarui Oleh</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($banners as $b): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= esc($b['title']) ?></td>

                            <td class="text-center">
                                <?php if ($b['status'] === '1'): ?>
                                    <span class="badge bg-success">Publish</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Unpublish</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php
                                    $kategori = [
                                        1 => 'Banner Utama',
                                        2 => 'Banner Popup',
                                        3 => 'Banner Berita'
                                    ];
                                    echo $kategori[$b['category_banner']] ?? '-';
                                ?>
                            </td>

                            <td class="text-center"><?= esc($b['media_type'] ?? '-') ?></td>

                            <td class="text-center">
                                <?php if (!empty($b['image'])): ?>
                                    <img src="<?= base_url('uploads/banner/' . $b['image']) ?>" 
                                         alt="Banner" width="100" class="rounded shadow-sm border">
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($b['url'])): ?>
                                    <a href="<?= esc($b['url']) ?>" target="_blank"><?= esc($b['url']) ?></a>
                                <?php elseif (!empty($b['url_yt'])): ?>
                                    <a href="<?= esc($b['url_yt']) ?>" target="_blank">Lihat YouTube</a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center"><?= esc($b['sorting'] ?? '-') ?></td>

                            <td>
                                <small>
                                    <?= esc($b['created_by_name'] ?? '-') ?><br>
                                    <span class="text-muted">
                                        <?= esc($b['created_at'] ? date('d/m/Y H:i', strtotime($b['created_at'])) : '-') ?>
                                    </span>
                                </small>
                            </td>

                            <td>
                                <small>
                                    <?= esc($b['updated_by_name'] ?? '-') ?><br>
                                    <span class="text-muted">
                                        <?= esc($b['updated_at'] ? date('d/m/Y H:i', strtotime($b['updated_at'])) : '-') ?>
                                    </span>
                                </small>
                            </td>

                            <td class="text-center">
                                <a href="<?= site_url('banner/' . $b['id_banner'] . '/edit') ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="<?= site_url('banner/' . $b['id_banner']) ?>" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus banner ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center shadow-sm">
            Belum ada data banner.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
