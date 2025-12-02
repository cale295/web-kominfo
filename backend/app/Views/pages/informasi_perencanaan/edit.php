<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Dokumen</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('informasi_perencanaan') ?>">Informasi Perencanaan</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Form Edit Dokumen
        </div>
        <div class="card-body">
            
            <?= $this->include('layouts/alerts') ?>

            <form action="<?= base_url('informasi_perencanaan/' . $doc['id_perencanaan']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="kategori" class="form-control" value="<?= old('kategori', $doc['kategori']) ?>" required>                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" class="form-control" value="<?= old('tahun', $doc['tahun']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="judul_dokumen" class="form-control" value="<?= old('judul_dokumen', $doc['judul_dokumen']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ganti File (Opsional)</label>
                    <input type="file" name="document_file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah file.</div>
                    
                    <div class="mt-2 p-2 bg-light border rounded">
                        <small class="fw-bold">File saat ini:</small> 
                        <a href="<?= base_url($doc['file_path']) ?>" target="_blank" class="text-decoration-none">
                            <i class="fas fa-file"></i> <?= $doc['file_name'] ?>
                        </a>
                    </div>
                </div>

                <div class="mt-4 border-top pt-3 d-flex justify-content-end gap-2">
                    <a href="<?= base_url('informasi_perencanaan') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>