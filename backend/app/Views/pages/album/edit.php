<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Menggunakan variabel warna yang sama dengan Index agar konsisten */
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #95a5a6;
        --accent-color: #3498db;
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

    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
    }

    /* Styling Preview Image */
    .img-preview-container {
        width: 100%;
        height: 250px;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        overflow: hidden;
        position: relative;
    }

    .img-preview {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    .img-placeholder {
        text-align: center;
        color: #adb5bd;
    }

    /* Tombol */
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
                <i class="bi bi-pencil-square me-2"></i>Edit Album
            </h3>
            <p class="text-muted m-0 mt-1">Perbarui informasi detail album</p>
        </div>
        <a href="<?= site_url('album') ?>" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4">
            
            <form action="<?= site_url('album/'.$album['id_album']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <h5 class="mb-4 text-muted border-bottom pb-2">Informasi Album</h5>
                        
                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-tag me-2"></i>Nama Album <span class="text-danger">*</span></label>
                            <input type="text" name="album_name" 
                                   value="<?= esc($album['album_name']) ?>" 
                                   class="form-control" 
                                   placeholder="Masukkan judul album..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="bi bi-card-text me-2"></i>Deskripsi</label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="5" 
                                      placeholder="Tuliskan deskripsi singkat tentang album ini..."><?= esc($album['description']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <h5 class="mb-4 text-muted border-bottom pb-2">Cover Album</h5>
                        
                        <div class="mb-3">
                            <div class="img-preview-container mb-3">
                                <?php if ($album['cover_image']): ?>
                                    <img src="<?= base_url('uploads/album_covers/'.$album['cover_image']) ?>" 
                                         class="img-preview" 
                                         id="imgPreview">
                                <?php else: ?>
                                    <img src="" class="img-preview d-none" id="imgPreview">
                                    <div class="img-placeholder" id="placeholder">
                                        <i class="bi bi-image fs-1"></i>
                                        <p class="mb-0 mt-2">Tidak ada cover</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <label class="form-label small text-muted">Ganti Cover (Opsional)</label>
                            <input type="file" 
                                   name="cover_image" 
                                   class="form-control" 
                                   id="fileInput" 
                                   accept="image/*"
                                   onchange="previewImage()">
                            <div class="form-text">Format: JPG, PNG, JPEG. Maks 2MB.</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-4 pt-3 border-top gap-2">
                    <a href="<?= site_url('album') ?>" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewImage() {
        const fileInput = document.getElementById('fileInput');
        const imgPreview = document.getElementById('imgPreview');
        const placeholder = document.getElementById('placeholder');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove('d-none');
                if(placeholder) placeholder.classList.add('d-none');
            }
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>