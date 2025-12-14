<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #2c3e50;
        --accent-color: #f39c12; /* Warna Oranye untuk Edit/Warning tone */
        --text-muted: #6c757d;
    }

    /* Header Styling */
    .page-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border-left: 5px solid var(--accent-color);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Form Card */
    .form-card {
        background: white;
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 4px rgba(243, 156, 18, 0.1);
    }

    /* Image Preview Area */
    .img-preview-container {
        width: 100%;
        height: 300px;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        background-color: #f8f9fa;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-preview {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Agar gambar utuh terlihat */
        background-color: #000; /* Background hitam agar kontras */
    }

    /* Buttons */
    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        background-color: #1a252f;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background-color: transparent;
        color: #7f8c8d;
        padding: 0.8rem 1.5rem;
        border: 1px solid transparent;
        font-weight: 500;
    }
    .btn-cancel:hover {
        color: var(--primary-color);
        background-color: #ecf0f1;
        border-radius: 8px;
    }
</style>

<div class="container py-4">

    <div class="page-header">
        <div>
            <h3 class="m-0 fw-bold" style="color: var(--primary-color);">
                <i class="bi bi-pencil-square me-2"></i>Edit Foto
            </h3>
            <p class="text-muted m-0 mt-1">Perbarui informasi atau ganti file foto</p>
        </div>
        <a href="<?= site_url('gallery') ?>" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4">
            
            <form action="<?= site_url('gallery/' . $photo['id_photo']) ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <h5 class="mb-4 text-muted border-bottom pb-2">Detail Foto</h5>

                        <div class="mb-3">
                            <label for="photo_title" class="form-label">
                                <i class="bi bi-card-heading me-2"></i>Judul Foto <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="photo_title" 
                                   id="photo_title" 
                                   value="<?= esc($photo['photo_title']) ?>" 
                                   class="form-control" 
                                   placeholder="Masukkan judul foto..." 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="id_album" class="form-label">
                                <i class="bi bi-folder2-open me-2"></i>Album <span class="text-danger">*</span>
                            </label>
                            <select name="id_album" id="id_album" class="form-select" required>
                                <option value="" disabled>-- Pilih Album --</option>
                                <?php foreach ($albums as $album): ?>
                                    <option value="<?= $album['id_album'] ?>" <?= $album['id_album'] == $photo['id_album'] ? 'selected' : '' ?>>
                                        <?= esc($album['album_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">
                                <i class="bi bi-text-paragraph me-2"></i>Deskripsi
                            </label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      class="form-control" 
                                      rows="5" 
                                      placeholder="Tuliskan cerita dibalik foto ini..."
                                      required><?= esc($photo['deskripsi']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <h5 class="mb-4 text-muted border-bottom pb-2">File Foto</h5>
                        
                        <div class="mb-3">
                            <div class="img-preview-container mb-3 shadow-sm">
                                <?php if (!empty($photo['file_path'])): ?>
                                    <img src="<?= base_url('uploads/gallery/' . $photo['file_path']) ?>" 
                                         class="img-preview" 
                                         id="imgPreview" 
                                         alt="Preview Foto">
                                <?php else: ?>
                                    <div class="text-muted text-center">
                                        <i class="bi bi-image-alt fs-1"></i><br>Tidak ada foto
                                    </div>
                                <?php endif; ?>
                            </div>

                            <label for="file_path" class="form-label small text-muted">Ganti Foto (Opsional)</label>
                            <input type="file" 
                                   name="file_path" 
                                   id="file_path" 
                                   class="form-control" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto.</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-4 pt-3 border-top gap-2">
                    <a href="<?= site_url('gallery') ?>" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-circle me-2"></i>Perbarui Foto
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewImage(input) {
        const preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>