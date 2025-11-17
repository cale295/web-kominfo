<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Dokumen</h5>
    </div>

    <div class="card-body">
        <form action="<?= base_url('dokument/' . $dokument['id_document']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-3">
                <label class="form-label">Nama Dokumen <span class="text-danger">*</span></label>
                <input type="text" 
                       name="document_name" 
                       class="form-control"
                       value="<?= old('document_name', $dokument['document_name']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori Dokumen</label>
                <select name="id_document_category" class="form-control">
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_document_category'] ?>"
                            <?= $k['id_document_category'] == $dokument['id_document_category'] ? 'selected' : '' ?>>
                            <?= esc($k['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">File Dokumen</label>
                <input type="file" name="file" class="form-control">

                <?php if (!empty($dokument['file_path'])): ?>
                    <p class="mt-2">
                        File saat ini: <a href="<?= base_url($dokument['file_path']) ?>" target="_blank">Lihat File</a>
                    </p>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('dokument') ?>" class="btn btn-secondary">
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
