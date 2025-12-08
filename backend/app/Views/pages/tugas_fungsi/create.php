<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Styling Custom untuk Editor */
    .ql-toolbar-custom {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .ql-container {
        border-radius: 0 0 0.5rem 0.5rem;
        font-family: inherit;
        font-size: 1rem;
        background: white;
    }
    .ql-editor {
        min-height: 250px;
    }

    /* Styling Pilihan Tipe (Radio Button) */
    .btn-check:checked + .btn-outline-custom {
        background-color: #e8f0fe;
        border-color: #0d6efd;
        color: #0d6efd;
    }
    .hover-card:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 py-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Tambah Tugas/Fungsi</h1>
            <p class="text-muted small mb-0 mt-1">Formulir penambahan data tugas pokok atau fungsi baru.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-white shadow-sm px-3 py-2 rounded-pill small">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/tugas_fungsi" class="text-decoration-none">Tugas Fungsi</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <form action="/tugas_fungsi" method="post" id="formTugas">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-2"></i>Konten Deskripsi</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-gray-700">Deskripsi Tugas/Fungsi <span class="text-danger">*</span></label>
                            
                            <div id="toolbar-content" class="ql-toolbar-custom">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                                <select class="ql-header">
                                    <option value="1"></option>
                                    <option value="2"></option>
                                    <option value="3"></option>
                                    <option selected></option>
                                </select>
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-clean"></button>
                            </div>
                            
                            <div id="editor-content" class="ql-container ql-snow">
                                <div class="ql-editor">
                                    <?= old('description') ?>
                                </div>
                            </div>
                            
                            <textarea name="description" id="description-hidden" style="display:none;"></textarea>
                        </div>
                        </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-cog me-2"></i>Pengaturan</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-gray-700">Tipe Kategori <span class="text-danger">*</span></label>
                            <div class="d-flex flex-column gap-2">
                                <input type="radio" class="btn-check" name="type" id="typeTugas" value="tugas" <?= old('type') == 'tugas' ? 'checked' : 'checked' ?>>
                                <label class="btn btn-outline-custom border text-start p-3 rounded-3 hover-card d-flex align-items-center" for="typeTugas">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">TUGAS POKOK</div>
                                        <div class="small text-muted">Kegiatan utama organisasi</div>
                                    </div>
                                </label>

                                <input type="radio" class="btn-check" name="type" id="typeFungsi" value="fungsi" <?= old('type') == 'fungsi' ? 'checked' : '' ?>>
                                <label class="btn btn-outline-custom border text-start p-3 rounded-3 hover-card d-flex align-items-center" for="typeFungsi">
                                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">FUNGSI</div>
                                        <div class="small text-muted">Peran penunjang organisasi</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25">

                        <div class="mb-2">
                            <div class="form-check form-switch p-0 m-0 d-flex justify-content-between align-items-center bg-light p-3 rounded-3 border">
                                <label class="form-check-label fw-bold text-gray-700" for="is_active">Status Aktif</label>
                                <div>
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input ms-0" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?> style="float: none; margin-left: 0;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i>Simpan Data
                    </button>
                    <a href="/tugas_fungsi" class="btn btn-light btn-lg rounded-pill border text-muted">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Inisialisasi Quill pada div #editor-content
        var quill = new Quill('#editor-content', {
            modules: {
                toolbar: '#toolbar-content' // Menggunakan toolbar custom di atas
            },
            theme: 'snow',
            placeholder: 'Tulis deskripsi tugas atau fungsi di sini...'
        });

        // 2. Logic saat tombol Submit ditekan
        var form = document.querySelector('#formTugas');
        form.onsubmit = function() {
            // Ambil isi HTML dari editor Quill
            var editorHTML = quill.root.innerHTML;
            
            // Masukkan ke dalam textarea hidden bernama 'description'
            // Agar bisa dibaca oleh Controller ($this->request->getPost('description'))
            var hiddenInput = document.querySelector('#description-hidden');
            
            // Cek jika kosong
            if (editorHTML === '<p><br></p>') {
                hiddenInput.value = '';
            } else {
                hiddenInput.value = editorHTML;
            }
        };
    });
</script>
<?= $this->endSection() ?>