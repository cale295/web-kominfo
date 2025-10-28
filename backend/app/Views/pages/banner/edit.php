<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?= $this->include('layouts/alerts') ?>

<div class="container mt-5">
    <h3 class="mb-4">Edit Banner</h3>

    <form action="<?= site_url('banner/' . $banner['id_banner']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="<?= esc($banner['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"><?= esc($banner['keterangan']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Sekarang</label><br>
            <?php if (!empty($banner['image'])): ?>
                <img src="<?= base_url('uploads/banner/' . $banner['image']) ?>" width="200" class="rounded border mb-2">
            <?php else: ?>
                <p class="text-muted">Belum ada gambar</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Ganti Gambar (Opsional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Tipe Media</label>
            <select name="media_type" class="form-select">
                <option value="">-- Pilih --</option>
                <option value="image" <?= $banner['media_type'] == 'image' ? 'selected' : '' ?>>Gambar</option>
                <option value="video" <?= $banner['media_type'] == 'video' ? 'selected' : '' ?>>Video</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">URL Banner</label>
            <input type="text" name="url" class="form-control" value="<?= esc($banner['url']) ?>" placeholder="https://contoh.com">
        </div>

        <div class="mb-3">
            <label class="form-label">URL YouTube (jika ada)</label>
            <input type="text" name="url_yt" class="form-control" value="<?= esc($banner['url_yt']) ?>" placeholder="https://youtube.com/...">
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori Banner</label>
            <select name="category_banner" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="1" <?= $banner['category_banner'] == '1' ? 'selected' : '' ?>>Banner Utama</option>
                <option value="2" <?= $banner['category_banner'] == '2' ? 'selected' : '' ?>>Banner Popup</option>
                <option value="3" <?= $banner['category_banner'] == '3' ? 'selected' : '' ?>>Banner Berita</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="0" <?= $banner['status'] == '0' ? 'selected' : '' ?>>Unpublish</option>
                <option value="1" <?= $banner['status'] == '1' ? 'selected' : '' ?>>Publish</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Urutan (Sorting)</label>
            <input type="number" name="sorting" class="form-control" value="<?= esc($banner['sorting']) ?>" placeholder="1, 2, 3, dst">
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= site_url('banner') ?>" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>

</body>
</html>
