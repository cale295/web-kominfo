<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Struktur Organisasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/struktur_organisasi">Struktur</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Input</h6>
        </div>
        <div class="card-body">
            <form action="/struktur_organisasi" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Unit/Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" placeholder="Contoh: Bidang Informasi dan Komunikasi Publik" value="<?= old('nama') ?>" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <input class="form-control" list="kategoriList" name="kategori" placeholder="Pilih atau ketik..." value="<?= old('kategori') ?>" required>
                                <datalist id="kategoriList">
                                    <option value="sekretariat">Sekretariat</option>
                                    <option value="bidang">Bidang</option>
                                    <option value="seksi">Seksi</option>
                                    <option value="upt">UPT</option>
                                    <option value="kelompok_jabatan">Kelompok Jabatan</option>
                                </datalist>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Induk (Parent)</label>
                                <select class="form-select" name="parent_id">
                                    <option value="">- Tidak Ada (Root) -</option>
                                    <?php foreach ($parents as $p): ?>
                                        <option value="<?= $p['id_struktur'] ?>" <?= old('parent_id') == $p['id_struktur'] ? 'selected' : '' ?>>
                                            <?= $p['nama'] ?> (<?= ucfirst($p['kategori']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">Pilih jika unit ini berada di bawah unit lain.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea class="form-control" name="deskripsi" rows="3"><?= old('deskripsi') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Konten HTML (Opsional)</label>
                            <!-- Class editor untuk Summernote/CKEditor -->
                            <textarea class="form-control editor" name="konten_html" rows="5"><?= old('konten_html') ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Urutan Tampilan</label>
                                    <input type="number" class="form-control" name="sorting" value="<?= old('sorting', 0) ?>">
                                    <div class="form-text">Semakin kecil angkanya, semakin di atas.</div>
                                </div>

                                <div class="mb-3 pt-2">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/struktur_organisasi" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>