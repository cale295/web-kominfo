<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

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

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="<?= site_url('berita/'.$berita['id_berita']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">

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
                                    $selected = !empty($oldKategori) ? $oldKategori : ($selectedKategoriIds ?? []);
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

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Isi Berita</label>
                                <textarea name="content" class="form-control" rows="8" 
                                          placeholder="Tulis konten berita secara lengkap..."><?= (old('content', $berita['content'])) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Isi Berita</label>
                                <textarea name="content2" class="form-control" rows="8" 
                                          placeholder="Tulis konten berita secara lengkap..."><?= (old('content', $berita['content2'])) ?></textarea>
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
                                <!-- Featured Image -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Gambar Utama (Featured Image)</label>
                                    <?php if(!empty($berita['feat_image'])): ?>
                                        <div class="mb-2">
                                            <img src="<?= base_url($berita['feat_image']) ?>" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 200px; object-fit: cover;" 
                                            <div class="form-text">Gambar saat ini</div>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="feat_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Upload gambar baru untuk mengganti (JPG, PNG, max 2MB)</small>
                                </div>

                                <!-- Additional Images -->
<!-- Additional Images -->
<div class="col-md-12 mb-3">
    <label class="form-label fw-semibold">Gambar Tambahan</label>
    <?php if(!empty($additionalImages)): ?>
        <div class="row mb-2 g-2">
            <?php foreach($additionalImages as $img): ?>
                <div class="col-md-3">
                    <img src="<?= base_url($img) ?>" 
                         class="img-thumbnail w-100" 
                         style="height: 150px; object-fit: cover;" 
                         alt="Additional Image">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="form-text mb-2">Gambar tambahan saat ini</div>
    <?php endif; ?>
    <input type="file" name="additional_images[]" class="form-control" 
           accept="image/*" multiple>
    <small class="text-muted">Upload beberapa gambar sekaligus (tekan Ctrl/Cmd untuk pilih banyak)</small>
</div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Link Video</label>
                                    <input type="url" name="link_video" class="form-control" 
                                           value="<?= esc(old('link_video', $berita['link_video'])) ?>"
                                           placeholder="https://youtube.com/...">
                                    <small class="text-muted">YouTube atau platform video lainnya</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Sumber Berita</label>
                                    <input type="text" name="sumber" class="form-control" 
                                           value="<?= esc(old('sumber', $berita['sumber'])) ?>"
                                           placeholder="Nama sumber atau media">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-semibold">Caption Gambar</label>
                                    <textarea name="caption" class="form-control" rows="2" 
                                              placeholder="Deskripsi atau keterangan gambar"><?= esc(old('caption', $berita['caption'])) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen Pendukung -->
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">
                                <i class="bi bi-file-earmark-pdf text-primary me-2"></i>Dokumen Pendukung
                            </h5>

                            <?php
                            $dokNames = [
                                ['field' => 'dokumen', 'title' => 'dokumen_title'],
                                ['field' => 'dokumen_duo', 'title' => 'dokumen_duo_title'],
                                ['field' => 'dokumen_tigo', 'title' => 'dokumen_tigo_title'],
                                ['field' => 'dokumen_quatro', 'title' => 'dokumen_quatro_title'],
                            ];
                            foreach ($dokNames as $idx => $dn): 
                                $field = $dn['field'];
                                $titleField = $dn['title'];
                            ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Dokumen <?= ($idx+1) ?></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="<?= $field ?>" class="form-control" 
                                           placeholder="Link atau path dokumen" 
                                           value="<?= esc(old($field, $berita[$field] ?? '')) ?>">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="<?= $titleField ?>" class="form-control" 
                                           placeholder="Judul dokumen" 
                                           value="<?= esc(old($titleField, $berita[$titleField] ?? '')) ?>">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- SEO & Metadata -->
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">
                                <i class="bi bi-search text-primary me-2"></i>SEO & Metadata
                            </h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kata Kunci (Keywords)</label>
                                <textarea name="keyword" class="form-control" rows="2" 
                                          placeholder="kata kunci, dipisah, dengan koma"><?= esc(old('keyword', $berita['keyword'])) ?></textarea>
                                <small class="text-muted">Pisahkan dengan koma untuk beberapa kata kunci</small>
                            </div>
                        </div>

                        <!-- Catatan Admin -->
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">
                                <i class="bi bi-clipboard-check text-primary me-2"></i>Catatan Internal
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Catatan Admin</label>
                                    <textarea name="note" class="form-control" rows="3" 
                                              placeholder="Catatan internal untuk admin"><?= esc(old('note', $berita['note'])) ?></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Note Revisi</label>
                                    <textarea name="note_revisi" class="form-control" rows="3" 
                                              placeholder="Catatan revisi atau perubahan"><?= esc(old('note_revisi', $berita['note_revisi'])) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2 mb-3">
                                <i class="bi bi-toggle-on text-primary me-2"></i>Status Publikasi
                            </h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status Tayang</label>
                                    <select name="status" class="form-select">
                                        <option value="1" <?= old('status', $berita['status']) == '1' ? 'selected' : '' ?>>
                                             🟢Tayang
                                        </option>
                                        <option value="5" <?= old('status', $berita['status']) == '5' ? 'selected' : '' ?>>
                                             🔴Tidak Tayang
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status Berita</label>
                                    <select name="status_berita" class="form-select">
                                        <option value="0" <?= old('status_berita', $berita['status_berita']) == '0' ? 'selected' : '' ?>>
                                            📝 Draft
                                        </option>
                                        <option value="2" <?= old('status_berita', $berita['status_berita']) == '2' ? 'selected' : '' ?>>
                                            ⏳ Menunggu Verifikasi
                                        </option>
                                        <option value="3" <?= old('status_berita', $berita['status_berita']) == '3' ? 'selected' : '' ?>>
                                            ❌ Ditolak
                                        </option>
                                        <option value="4" <?= old('status_berita', $berita['status_berita']) == '4' ? 'selected' : '' ?>>
                                            ✅ Layak Tayang
                                        </option>
                                        <option value="6" <?= old('status_berita', $berita['status_berita']) == '6' ? 'selected' : '' ?>>
                                            ✅ Revisi
                                        </option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
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
    </div>
</div>

<style>
.form-label {
    margin-bottom: 0.5rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.card {
    border-radius: 12px;
}

.border-bottom {
    border-color: #e9ecef !important;
}

h5 i {
    font-size: 1.1rem;
}

/* Checkbox Kategori Styling */
.kategori-checkbox-group {
    max-height: 250px;
    overflow-y: auto;
}

.kategori-checkbox-group::-webkit-scrollbar {
    width: 8px;
}

.kategori-checkbox-group::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.kategori-checkbox-group::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.kategori-checkbox-group::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-label {
    cursor: pointer;
    user-select: none;
}

.form-check:hover {
    background-color: rgba(13, 110, 253, 0.05);
    border-radius: 4px;
    padding: 4px 8px;
    margin: 0 -8px 8px -8px;
}

/* Image Preview Styling */
.img-thumbnail {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 4px;
    transition: all 0.3s ease;
}

.img-thumbnail:hover {
    border-color: #0d6efd;
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

input[type="file"].form-control {
    padding: 0.5rem;
    border: 2px dashed #dee2e6;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

input[type="file"].form-control:hover {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.05);
}

input[type="file"].form-control:focus {
    border-style: solid;
}

.btn {
    padding: 0.5rem 1.25rem;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>

<?= $this->endSection() ?>