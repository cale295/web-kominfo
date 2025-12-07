<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Kerjasama</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/ip_kerjasama_daerah">Kerjasama</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Input</h6>
        </div>
        <div class="card-body">
            <form action="/ip_kerjasama_daerah" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nomor" placeholder="Contoh: 123/PKS/2023" value="<?= old('nomor') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tentang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tentang" placeholder="Judul singkat kerjasama" value="<?= old('tentang') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Perihal / Detail <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="perihal" rows="4" placeholder="Jelaskan isi kerjasama..." required><?= old('perihal') ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/ip_kerjasama_daerah" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>