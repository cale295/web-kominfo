<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Agenda</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/agenda_pelatihan">Agenda</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Input</h6>
        </div>
        <div class="card-body">
            <form action="/agenda_pelatihan" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Agenda <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" placeholder="Contoh: Pelatihan Digital Marketing" value="<?= old('judul') ?>" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_agenda" value="<?= old('tanggal_agenda') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Waktu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="waktu" placeholder="09:00 - 12:00 WIB" value="<?= old('waktu') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tempat / Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tempat" placeholder="Nama Gedung / Ruangan / Link Zoom" value="<?= old('tempat') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                            <!-- Class editor untuk WYSIWYG -->
                            <textarea class="form-control editor" name="deskripsi" rows="6" required><?= old('deskripsi') ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <label class="form-label fw-bold">Thumbnail / Poster <span class="text-danger">*</span></label>
                                
                                <!-- Preview Container -->
                                <div class="mb-3 position-relative bg-white rounded border d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                                    <img id="thumb-preview" src="#" alt="Preview" class="d-none w-100 h-100 object-fit-contain">
                                    <div id="thumb-placeholder" class="text-center text-muted">
                                        <i class="fas fa-image fa-2x mb-2"></i><br>
                                        <small>Upload Gambar</small>
                                    </div>
                                </div>

                                <input class="form-control" type="file" id="thumbnail" name="thumbnail" accept="image/*" onchange="previewImage(this)" required>
                                <div class="form-text mt-2">Format: JPG, PNG. Maks 2MB.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Publikasi</label>
                            <select class="form-select" name="status">
                                <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Draft (Konsep)</option>
                                <option value="published" <?= old('status') == 'published' ? 'selected' : '' ?>>Published (Tayang)</option>
                                <option value="archived" <?= old('status') == 'archived' ? 'selected' : '' ?>>Archived (Arsip)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/agenda_pelatihan" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Agenda</button>
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
</script>
<?= $this->endSection() ?>