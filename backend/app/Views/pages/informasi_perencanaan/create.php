<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Dokumen</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('informasi_perencanaan') ?>">Informasi Perencanaan</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i> Form Upload Dokumen
        </div>
        <div class="card-body">
            
            <?= $this->include('layouts/alerts') ?>

            <form action="<?= base_url('informasi_perencanaan') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori" class="form-control" value="<?= old('kategori') ?>" placeholder="Contoh: Rencana Strategis" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" class="form-control" value="<?= old('tahun', date('Y')) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="judul_dokumen" class="form-control" value="<?= old('judul_dokumen') ?>" placeholder="Contoh: Rencana Strategis 2024-2029" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Upload File (PDF/Doc/Xls) <span class="text-danger">*</span></label>
                    <input type="file" name="document_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                    <div class="form-text">Maksimal ukuran file: 10MB.</div>
                </div>

                <div class="mt-4 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= base_url('informasi_perencanaan') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>