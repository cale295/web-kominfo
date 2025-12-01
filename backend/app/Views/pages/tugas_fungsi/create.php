<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Tugas/Fungsi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/tugas_fungsi">Tugas Fungsi</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <!-- Alert Messages -->
    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Input</h6>
        </div>
        <div class="card-body">
            <form action="/tugas_fungsi" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipe Konten <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeTugas" value="tugas" <?= old('type') == 'tugas' ? 'checked' : 'checked' ?>>
                                    <label class="form-check-label" for="typeTugas">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-2">TUGAS</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeFungsi" value="fungsi" <?= old('type') == 'fungsi' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="typeFungsi">
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info px-2">FUNGSI</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                            <!-- Class 'editor' disiapkan untuk integrasi Summernote/CKEditor -->
                            <textarea class="form-control editor" name="description" rows="6" placeholder="Masukkan deskripsi tugas atau fungsi..." required><?= old('description') ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Urutan Tampilan</label>
                                    <input type="number" class="form-control" name="order_number" value="<?= old('order_number', 0) ?>">
                                    <div class="form-text">Semakin kecil angkanya, semakin di atas posisinya.</div>
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
                    <a href="/tugas_fungsi" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>