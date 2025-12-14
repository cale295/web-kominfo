<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Style Konsisten dengan Halaman Edit & Index */
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #95a5a6;
        --accent-color: #3498db;
        --success-color: #27ae60;
    }

    /* Header Styling */
    .page-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border-left: 5px solid var(--success-color); /* Hijau untuk Create */
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Card Styling */
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
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--success-color);
        box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.1);
    }

    /* Upload & Preview Area */
    .upload-area {
        background-color: #f8f9fa;
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s;
        height: 280px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .upload-area:hover {
        background-color: #f1f8e9;
        border-color: var(--success-color);
    }

    .upload-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
        transition: color 0.3s;
    }

    .upload-area:hover .upload-icon {
        color: var(--success-color);
    }

    /* Image Preview saat file dipilih */
    .img-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 10px;
        z-index: 10;
        display: none; /* Hidden by default */
    }

    /* Tombol */
    .btn-submit {
        background-color: var(--success-color);
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        background-color: #219150;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3);
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
                <i class="bi bi-folder-plus me-2"></i>Tambah Album
            </h3>
            <p class="text-muted m-0 mt-1">Buat album foto baru untuk galeri Anda</p>
        </div>
        <a href="<?= site_url('album') ?>" class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4">
            
            <form action="<?= site_url('album') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <h5 class="mb-4 text-muted border-bottom pb-2">Detail Informasi</h5>
                        
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-tag me-2"></i>Nama Album <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="album_name" 
                                   class="form-control" 
                                   placeholder="Contoh: Festival Kota Tangerang 2024" 
                                   required 
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-card-text me-2"></i>Deskripsi
                            </label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="6" 
                                      placeholder="Ceritakan sedikit tentang isi album ini..."></textarea>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <h5 class="mb-4 text-muted border-bottom pb-2">Cover Album</h5>
                        
                        <div class="mb-3">
                            <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                                <img id="imgPreview" class="img-preview" alt="Preview Cover">
                                
                                <div id="uploadPlaceholder">
                                    <i class="bi bi-cloud-arrow-up upload-icon"></i>
                                    <h6 class="fw-bold text-secondary">Upload Cover</h6>
                                    <p class="small text-muted mb-0">Klik disini untuk memilih gambar</p>
                                    <p class="small text-muted mt-1" style="font-size: 0.75rem;">(JPG, PNG, Max 2MB)</p>
                                </div>
                            </div>

                            <input type="file" 
                                   name="cover_image" 
                                   id="fileInput" 
                                   class="d-none" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            
                            <div class="text-center mt-2">
                                <small class="text-muted">Gambar cover bersifat opsional</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-4 pt-3 border-top gap-2">
                    <a href="<?= site_url('album') ?>" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-lg me-2"></i>Simpan Album
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
        const placeholder = document.getElementById('uploadPlaceholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; 
                placeholder.style.opacity = '0'; 
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "";
            preview.style.display = 'none';
            placeholder.style.opacity = '1';
        }
    }
</script>
<?= $this->endSection() ?>