<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Dokumen</h5>
    </div>

    <div class="card-body">
        <form action="<?= base_url('dokument') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                <input type="text" 
                       name="document_name" 
                       class="form-control <?= isset($errors['document_name']) ? 'is-invalid' : '' ?>"
                       value="<?= old('document_name') ?>">

                <?php if (isset($errors['document_name'])): ?>
                    <div class="invalid-feedback"><?= $errors['document_name'] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori Dokumen <span class="text-danger">*</span></label>
                <select name="id_document_category" class="form-control">
                    <option value="">-- Pilih Kategori --</option>

                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_document_category'] ?>">
                            <?= esc($k['category_name']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload File</label>
                <input type="file" name="file_path" class="form-control">
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('dokument') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
