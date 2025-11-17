<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Kategori Dokumen</h5>
    </div>

    <div class="card-body">
        <form action="<?= base_url('dokument_kategori/' .$dokumentKategori['id_document_category']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-3">
                <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" 
                       name="category_name" 
                       class="form-control <?= isset($errors['category_name']) ? 'is-invalid' : '' ?>"
                       value="<?= old('category_name', $dokumentKategori['category_name']) ?>">

                <?php if (isset($errors['category_name'])): ?>
                    <div class="invalid-feedback"><?= $errors['category_name'] ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="category_description" 
                          class="form-control" 
                          rows="3"><?= old('category_description', $dokumentKategori['category_description']) ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('dokument_kategori') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
