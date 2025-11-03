<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>✏️ Edit Berita</h3>

    <form action="<?= site_url('berita/'.$berita['id_berita']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- Judul -->
        <div class="mb-3">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" value="<?= esc(old('judul', $berita['judul'])) ?>" required>
        </div>

        <!-- Topik -->
        <div class="mb-3">
            <label class="form-label">Topik</label>
            <input type="text" name="topik" class="form-control" value="<?= esc(old('topik', $berita['topik'])) ?>">
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <select name="id_kategori" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat['id_kategori'] ?>" <?= $kat['id_kategori'] == $berita['id_kategori'] ? 'selected' : '' ?>>
                        <?= esc($kat['kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Sub Kategori -->
        <div class="mb-3">
            <label class="form-label">Sub Kategori</label>
            <input type="text" name="id_sub_kategori" class="form-control" value="<?= esc(old('id_sub_kategori', $berita['id_sub_kategori'])) ?>">
        </div>

        <!-- Intro -->
        <div class="mb-3">
            <label class="form-label">Intro Singkat</label>
            <textarea name="intro" class="form-control" rows="3"><?= esc(old('intro', $berita['intro'])) ?></textarea>
        </div>

        <!-- Isi Berita -->
        <div class="mb-3">
            <label class="form-label">Isi Berita</label>
            <textarea name="content" class="form-control" rows="6"><?= esc(old('content', $berita['content'])) ?></textarea>
        </div>

        <!-- Berita Terkait 1 -->
        <div class="mb-3">
            <label class="form-label">Berita Terkait 1</label>
            <select name="id_berita_terkait" class="form-select">
                <option value="">-- Pilih Berita Terkait --</option>
                <?php foreach ($beritaAll as $b): ?>
                    <option value="<?= $b['id_berita'] ?>" <?= $b['id_berita'] == $berita['id_berita_terkait'] ? 'selected' : '' ?>>
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
                    <option value="<?= $b['id_berita'] ?>" <?= $b['id_berita'] == $berita['id_berita_terkait2'] ? 'selected' : '' ?>>
                        <?= esc($b['judul']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Link Video -->
        <div class="mb-3">
            <label class="form-label">Link Video (YouTube / lainnya)</label>
            <input type="text" name="link_video" class="form-control" value="<?= esc(old('link_video', $berita['link_video'])) ?>">
        </div>

        <!-- Keyword -->
        <div class="mb-3">
            <label class="form-label">Kata Kunci (SEO Keyword)</label>
            <textarea name="keyword" class="form-control" rows="2"><?= esc(old('keyword', $berita['keyword'])) ?></textarea>
        </div>

        <!-- Sumber -->
        <div class="mb-3">
            <label class="form-label">Sumber Berita</label>
            <input type="text" name="sumber" class="form-control" value="<?= esc(old('sumber', $berita['sumber'])) ?>">
        </div>

        <!-- Caption Gambar -->
        <div class="mb-3">
            <label class="form-label">Caption Gambar</label>
            <textarea name="caption" class="form-control" rows="2"><?= esc(old('caption', $berita['caption'])) ?></textarea>
        </div>

        <!-- Catatan / note admin -->
        <div class="mb-3">
            <label class="form-label">Catatan / Note Admin</label>
            <textarea name="note" class="form-control" rows="2"><?= esc(old('note', $berita['note'])) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Note Revisi</label>
            <textarea name="note_revisi" class="form-control" rows="2"><?= esc(old('note_revisi', $berita['note_revisi'])) ?></textarea>
        </div>

        <!-- Dokumen -->
        <?php for($i=1;$i<=4;$i++): ?>
        <div class="mb-3">
            <label class="form-label">Dokumen <?= $i ?></label>
            <input type="text" name="dokumen<?= $i == 1 ? '' : ($i == 2 ? '_duo' : ($i == 3 ? '_tigo' : '_quatro')) ?>" class="form-control mb-1" placeholder="Link / path dokumen" value="<?= esc(old('dokumen'.($i == 1 ? '' : ($i == 2 ? '_duo' : ($i == 3 ? '_tigo' : '_quatro'))), $berita['dokumen'.($i == 1 ? '' : ($i == 2 ? '_duo' : ($i == 3 ? '_tigo' : '_quatro')))])) ?>">
            <input type="text" name="dokumen_<?php echo ['title','duo_title','tigo_title','quatro_title'][$i-1]; ?>" class="form-control" placeholder="Judul dokumen" value="<?= esc(old('dokumen_'.['title','duo_title','tigo_title','quatro_title'][$i-1], $berita['dokumen_'.['title','duo_title','tigo_title','quatro_title'][$i-1]])) ?>">
        </div>
        <?php endfor; ?>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">Status Tayang</label>
            <select name="status" class="form-select">
                <option value="0" <?= $berita['status'] == '0' ? 'selected' : '' ?>>Tidak Tayang</option>
                <option value="1" <?= $berita['status'] == '1' ? 'selected' : '' ?>>Tayang</option>
            </select>
        </div>

        <!-- Status Berita -->
        <div class="mb-3">
            <label class="form-label">Status Berita</label>
            <select name="status_berita" class="form-select">
                <option value="0" <?= $berita['status_berita'] == '0' ? 'selected' : '' ?>>Draft</option>
                <option value="2" <?= $berita['status_berita'] == '2' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                <option value="1" <?= $berita['status_berita'] == '1' ? 'selected' : '' ?>>Tayang</option>
                <option value="3" <?= $berita['status_berita'] == '3' ? 'selected' : '' ?>>Ditolak</option>
            </select>
        </div>

        <!-- Tombol aksi -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success">💾 Update</button>
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary ms-2">Kembali</a>
        </div>

    </form>
</div>

<?= $this->endSection() ?>
