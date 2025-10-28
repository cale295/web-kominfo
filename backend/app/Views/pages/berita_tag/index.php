<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📌 Daftar Tag Berita</h3>
        <div>
            <a href="<?= site_url('berita_tag/new') ?>" class="btn btn-primary">+ Tambah Tag</a>
            <a href="<?= site_url('berita_tag/trash') ?>" class="btn btn-secondary">🗑️ Tong Sampah</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Tag</th>
                <th>Slug</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tags) && is_array($tags)): ?>
                <?php $i = 1; ?>
                <?php foreach ($tags as $tag): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($tag['name']) ?></td>
                        <td><?= esc($tag['slug']) ?></td>
                        <td><?= esc($tag['created_by_name'] ?? '-') ?></td>
                        <td><?= esc($tag['created_at'] ?? '-') ?></td>
                        <td>
                            <a href="<?= site_url('berita_tag/'.$tag['id_tags'].'/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="<?= site_url('berita_tag/' . $tag['id_tags']) ?>" 
                                              method="post" 
                                              style="display:inline;">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin Membuang Tag ini?')"
                                                    title="Hapus">
                                                Trash
                                            </button>
                                        </form>                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada tag.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
