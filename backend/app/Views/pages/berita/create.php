<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>📝 Tambah Berita</h3>
    <form action="<?= site_url('berita') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Judul -->
        <div class="mb-3">
            <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul berita" value="<?= old('judul') ?>">
        </div>

        <!-- Topik -->
        <div class="mb-3">
            <label class="form-label">Topik</label>
            <input type="text" name="topik" class="form-control" placeholder="Masukkan topik berita" value="<?= old('topik') ?>">
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat['id_kategori'] ?>" <?= old('id_kategori') == $kat['id_kategori'] ? 'selected' : '' ?>>
                        <?= esc($kat['kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Intro -->
        <div class="mb-3">
            <label class="form-label">Intro Singkat</label>
            <textarea name="intro" class="form-control" rows="3" placeholder="Deskripsi singkat sebelum isi utama"><?= old('intro') ?></textarea>
        </div>

        <!-- Isi Berita -->
        <div class="mb-3">
            <label class="form-label">Isi Berita</label>
            <textarea name="content" class="form-control" rows="8" placeholder="Tulis isi berita di sini..."><?= old('content') ?></textarea>
        </div>

        <!-- Berita Terkait 1 -->
        <div class="mb-3">
            <label class="form-label">Berita Terkait 1</label>
            <select name="id_berita_terkait" class="form-select">
                <option value="">-- Pilih Berita Terkait --</option>
                <?php foreach ($beritaAll as $b): ?>
                    <option value="<?= $b['id_berita'] ?>" <?= old('id_berita_terkait') == $b['id_berita'] ? 'selected' : '' ?>>
                        <?= esc($b['judul']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Berita Terkait 2 -->
        <div class="mb-3">
            <label class="form-label">Berita Terkait 2</label>
            <select name="id_berita_terkait2" class="form-select">
                <option value="">-- Pilih Berita Terkait --</option>
                <?php foreach ($beritaAll as $b): ?>
                    <option value="<?= $b['id_berita'] ?>" <?= old('id_berita_terkait2') == $b['id_berita'] ? 'selected' : '' ?>>
                        <?= esc($b['judul']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Gambar Utama -->
        <div class="mb-3">
            <label class="form-label">Gambar Utama (feat_image)</label>
            <input type="file" name="feat_image" class="form-control">
        </div>

        <!-- Link Video -->
        <div class="mb-3">
            <label class="form-label">Link Video (YouTube / lainnya)</label>
            <input type="text" name="link_video" class="form-control" placeholder="https://youtube.com/..." value="<?= old('link_video') ?>">
        </div>

        <!-- Keyword -->
        <div class="mb-3">
            <label class="form-label">Kata Kunci (SEO Keyword)</label>
            <textarea name="keyword" class="form-control" rows="2" placeholder="Pisahkan dengan koma"><?= old('keyword') ?></textarea>
        </div>

        <!-- Sumber -->
        <div class="mb-3">
            <label class="form-label">Sumber Berita</label>
            <input type="text" name="sumber" class="form-control" placeholder="Contoh: Detik.com, Kompas, dll" value="<?= old('sumber') ?>">
        </div>

        <!-- Caption Gambar -->
        <div class="mb-3">
            <label class="form-label">Caption Gambar</label>
            <textarea name="caption" class="form-control" rows="2" placeholder="Tuliskan keterangan gambar"><?= old('caption') ?></textarea>
        </div>

        <!-- Status otomatis -->
        <input type="hidden" name="status" value="0"> <!-- Tidak tayang dulu -->
        <input type="hidden" name="status_berita" value="2"> <!-- Menunggu Verifikasi -->

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary ms-2">Kembali</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
