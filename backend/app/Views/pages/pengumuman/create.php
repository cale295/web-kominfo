<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Pengumuman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/pengumuman">Pengumuman</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Input</h6>
        </div>
        <div class="card-body">
            <form action="/pengumuman" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Pengumuman <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" value="<?= old('judul') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Pengumuman <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" name="content" rows="8"><?= old('content') ?></textarea>
                        </div>

                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <label class="form-label fw-bold">Pengaturan Media</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipe_media" id="tipeLink" value="link" onchange="toggleMedia('link')" <?= old('tipe_media') == 'link' ? 'checked' : 'checked' ?>>
                                        <label class="form-check-label" for="tipeLink"><i class="fas fa-link me-1"></i> Link URL</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipe_media" id="tipeFile" value="file" onchange="toggleMedia('file')" <?= old('tipe_media') == 'file' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tipeFile"><i class="fas fa-file-pdf me-1"></i> Upload File</label>
                                    </div>
                                </div>

                                <div id="inputLink" class="mb-2">
                                    <label class="form-label small">URL Tujuan</label>
                                    <input type="url" class="form-control" name="link_url" placeholder="https://..." value="<?= old('link_url') ?>">
                                </div>

                                <div id="inputFile" class="mb-2 d-none">
                                    <label class="form-label small">Upload Dokumen (PDF/DOC)</label>
                                    <input type="file" class="form-control" name="file_media">
                                    <div class="form-text">Maksimal 5MB.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <label class="form-label fw-bold">Gambar Utama (Cover) <span class="text-danger">*</span></label>
                                <div class="mb-3 position-relative bg-white rounded border d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                                    <img id="thumb-preview" src="#" alt="Preview" class="d-none w-100 h-100 object-fit-contain">
                                    <div id="thumb-placeholder" class="text-center text-muted">
                                        <i class="fas fa-image fa-2x mb-2"></i><br>
                                        <small>Upload Gambar</small>
                                    </div>
                                </div>
                                <input class="form-control" type="file" name="featured_image" accept="image/*" onchange="previewImage(this)" required>
                                <div class="form-text mt-2">Wajib diisi. Format JPG/PNG.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?= old('status', 1) == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold" for="status">Status Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/pengumuman" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('thumb-preview');
        const placeholder = document.getElementById('thumb-placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleMedia(type) {
        const inputLink = document.getElementById('inputLink');
        const inputFile = document.getElementById('inputFile');
        
        if (type === 'link') {
            inputLink.classList.remove('d-none');
            inputFile.classList.add('d-none');
        } else {
            inputLink.classList.add('d-none');
            inputFile.classList.remove('d-none');
        }
    }

    // Run on load to set initial state based on old input
    document.addEventListener("DOMContentLoaded", function() {
        const isFile = document.getElementById('tipeFile').checked;
        toggleMedia(isFile ? 'file' : 'link');
    });
</script>
<?= $this->endSection() ?>