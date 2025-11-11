<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="<?= site_url('berita') ?>" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h2 class="mb-1 fw-bold">Edit Berita</h2>
                    <p class="text-muted mb-0">Perbarui informasi berita</p>
                </div>
            </div>

            <form action="<?= site_url('berita/'.$berita['id_berita'].'/update') ?>" method="post" enctype="multipart/form-data" id="form-berita">
                <?= csrf_field() ?>

                <!-- Informasi Utama -->
                <div class="mb-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">
                        <i class="bi bi-newspaper text-primary me-2"></i>Informasi Utama
                    </h5>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">
                                Judul <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="judul" class="form-control form-control-lg" 
                                value="<?= esc(old('judul', $berita['judul'])) ?>" 
                                placeholder="Masukkan judul berita yang menarik" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Topik</label>
                            <input type="text" name="topik" class="form-control" 
                                value="<?= esc(old('topik', $berita['topik'])) ?>"
                                placeholder="Topik utama berita">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <?php
                            $oldKategori = old('id_kategori');
                            if (!empty($oldKategori) && !is_array($oldKategori)) {
                                $oldKategori = explode(',', $oldKategori);
                            }
                            // $selected dikirim dari controller (array id_kategori)
                            $selected = !empty($oldKategori) ? $oldKategori : ($selected ?? []);
                            ?>
                            <div class="kategori-checkbox-group p-3 border rounded bg-light">
                                <?php foreach ($kategori as $kat): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" 
                                            name="id_kategori[]" 
                                            value="<?= $kat['id_kategori'] ?>" 
                                            id="kat_<?= $kat['id_kategori'] ?>"
                                            <?= in_array($kat['id_kategori'], $selected) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kat_<?= $kat['id_kategori'] ?>">
                                            <?= esc($kat['kategori']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih satu atau lebih kategori
                            </small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Sub Kategori</label>
                            <input type="text" name="id_sub_kategori" class="form-control" 
                                value="<?= esc(old('id_sub_kategori', $berita['id_sub_kategori'])) ?>"
                                placeholder="Sub kategori (opsional)">
                        </div>
                    </div>
                </div>

                <!-- Konten Berita -->
                <div class="mb-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">
                        <i class="bi bi-file-text text-primary me-2"></i>Konten Berita
                    </h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Intro Singkat</label>
                        <textarea name="intro" class="form-control" rows="3"
                                  placeholder="Ringkasan singkat berita (lead paragraph)"><?= esc(old('intro', $berita['intro'])) ?></textarea>
                        <small class="text-muted">Paragraf pembuka yang menarik perhatian pembaca</small>
                    </div>

                    <!-- Quill editor content -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Berita (Editor)</label>

                        <!-- toolbar -->
                        <div id="toolbar-main" class="ql-toolbar-custom mb-2">
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-align" value=""></button>
                                <button class="ql-align" value="center"></button>
                                <button class="ql-align" value="right"></button>
                                <button class="ql-align" value="justify"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-clean"></button>
                            </span>
                        </div>

                        <!-- editor container -->
                        <div id="editor-main" style="min-height: 300px; background: #fff; border: 1px solid #ced4da; border-radius: .375rem; overflow:auto;">
                            <?= $berita['content'] ?>  <!-- server-side render existing HTML -->
                        </div>
                        <!-- hidden textarea to submit -->
                        <textarea name="content" id="content-hidden" style="display:none;"><?= old('content', $berita['content']) ?></textarea>
                    </div>

                    <!-- Quill editor content2 -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Berita 2 (Editor)</label>

                        <div id="toolbar-2" class="ql-toolbar-custom mb-2">
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-clean"></button>
                            </span>
                        </div>

                        <div id="editor-2" style="min-height: 220px; background: #fff; border: 1px solid #ced4da; border-radius: .375rem;">
                            <?= $berita['content2'] ?>
                        </div>
                        <textarea name="content2" id="content2-hidden" style="display:none;"><?= old('content2', $berita['content2']) ?></textarea>
                    </div>
                </div>

                <!-- Berita Terkait -->
                <div class="mb-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">
                        <i class="bi bi-link-45deg text-primary me-2"></i>Berita Terkait
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Berita Terkait 1</label>
                            <select name="id_berita_terkait" class="form-select">
                                <option value="">-- Pilih Berita --</option>
                                <?php foreach ($beritaAll as $b): ?>
                                    <option value="<?= $b['id_berita'] ?>" 
                                        <?= $b['id_berita'] == old('id_berita_terkait', $berita['id_berita_terkait']) ? 'selected' : '' ?>>
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Berita Terkait 2</label>
                            <select name="id_berita_terkait2" class="form-select">
                                <option value="">-- Pilih Berita --</option>
                                <?php foreach ($beritaAll as $b): ?>
                                    <option value="<?= $b['id_berita'] ?>" 
                                        <?= $b['id_berita'] == old('id_berita_terkait2', $berita['id_berita_terkait2']) ? 'selected' : '' ?>>
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Media & Sumber -->
                <div class="mb-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">
                        <i class="bi bi-camera-video text-primary me-2"></i>Media & Sumber
                    </h5>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Gambar Utama (Featured Image)</label>
                            <?php if(!empty($berita['feat_image'])): ?>
                                <div class="mb-2">
                                    <img src="<?= base_url($berita['feat_image']) ?>" 
                                        class="img-thumbnail" 
                                        style="max-height: 200px; object-fit: cover;">
                                    <div class="form-text">Gambar saat ini</div>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="feat_image" class="form-control" accept="image/*">
                            <small class="text-muted">Upload gambar baru untuk mengganti (JPG, PNG, max 2MB)</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Video</label>
                            <input type="url" name="link_video" class="form-control" 
                                value="<?= esc(old('link_video', $berita['link_video'])) ?>"
                                placeholder="https://youtube.com/...">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Sumber Berita</label>
                            <input type="text" name="sumber" class="form-control" 
                                value="<?= esc(old('sumber', $berita['sumber'])) ?>"
                                placeholder="Nama sumber atau media">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Caption Gambar</label>
                            <textarea name="caption" class="form-control" rows="2"><?= esc(old('caption', $berita['caption'])) ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Catatan, Status, Action -->
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Catatan Admin</label>
                            <textarea name="note" class="form-control" rows="3"><?= esc(old('note', $berita['note'])) ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Note Revisi</label>
                            <textarea name="note_revisi" class="form-control" rows="3"><?= esc(old('note_revisi', $berita['note_revisi'])) ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status Tayang</label>
                            <select name="status" class="form-select">
                                <option value="1" <?= old('status', $berita['status']) == '1' ? 'selected' : '' ?>>🟢Tayang</option>
                                <option value="5" <?= old('status', $berita['status']) == '5' ? 'selected' : '' ?>>🔴Tidak Tayang</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status Berita</label>
                            <select name="status_berita" class="form-select">
                                <option value="0" <?= old('status_berita', $berita['status_berita']) == '0' ? 'selected' : '' ?>>📝 Draft</option>
                                <option value="2" <?= old('status_berita', $berita['status_berita']) == '2' ? 'selected' : '' ?>>⏳ Menunggu Verifikasi</option>
                                <option value="3" <?= old('status_berita', $berita['status_berita']) == '3' ? 'selected' : '' ?>>❌ Ditolak</option>
                                <option value="4" <?= old('status_berita', $berita['status_berita']) == '4' ? 'selected' : '' ?>>✅ Layak Tayang</option>
                                <option value="6" <?= old('status_berita', $berita['status_berita']) == '6' ? 'selected' : '' ?>>✅ Revisi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="<?= site_url('berita') ?>" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-2"></i>Update Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quill CSS & JS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
.ql-toolbar-custom { background:#f8f9fa; border:1px solid #ced4da; border-radius:.375rem; padding:6px; }
.ql-editor { min-height:220px; }
.kategori-checkbox-group { max-height:250px; overflow-y:auto; }
.form-check:hover { background: rgba(13,110,253,0.03); border-radius:4px; padding:4px 8px; margin:0 -8px 8px -8px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Quill editors
    const quillMain = new Quill('#editor-main', {
        modules: { toolbar: '#toolbar-main' },
        theme: 'snow'
    });
    const quill2 = new Quill('#editor-2', {
        modules: { toolbar: '#toolbar-2' },
        theme: 'snow'
    });

    // If server-rendered HTML exists in the divs (we put it server-side),
    // Quill already got it because we placed HTML inside containers.
    // But to be safe if you want to force-set from PHP variable:
    // (use JSON-encoded strings to avoid breaking)
    // quillMain.root.innerHTML = <?= json_encode($berita['content']) ?>;
    // quill2.root.innerHTML = <?= json_encode($berita['content2']) ?>;

    // On submit, copy Quill contents to hidden textareas
    const form = document.getElementById('form-berita');
    form.addEventListener('submit', function(e) {
        // copy html
        document.getElementById('content-hidden').value = quillMain.root.innerHTML.trim();
        document.getElementById('content2-hidden').value = quill2.root.innerHTML.trim();

        // Optional simple validation: require non-empty text
        if (quillMain.getText().trim().length === 0) {
            e.preventDefault();
            alert('Isi Berita tidak boleh kosong.');
            quillMain.focus();
            return false;
        }
    });
});
</script>

<?= $this->endSection() ?>
