<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?= $this->include('layouts/alerts') ?>

<div class="container mt-5">
    <h3 class="mb-4">Tambah Banner</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('banner') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Tipe Media</label>
            <select name="media_type" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="image">Gambar</option>
                <option value="video">Video</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">URL Banner</label>
            <input type="text" name="url" class="form-control" placeholder="https://contoh.com">
        </div>

        <div class="mb-3">
            <label class="form-label">URL YouTube (jika ada)</label>
            <input type="text" name="url_yt" class="form-control" placeholder="https://youtube.com/....">
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori Banner</label>
            <select name="category_banner" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="1">Banner Utama</option>
                <option value="2">Banner Popup</option>
                <option value="3">Banner Berita</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="0">Unpublish</option>
                <option value="1">Publish</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Urutan (Sorting)</label>
            <input type="number" name="sorting" class="form-control" placeholder="1, 2, 3, dst">
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= site_url('banner') ?>" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
