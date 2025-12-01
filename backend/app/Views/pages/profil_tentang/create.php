<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Konten Profil</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/profil_tentang">Profil Tentang</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <?php if (session()->has('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Tambah</h6>
        </div>
        <div class="card-body">
            <form action="/profil_tentang" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" placeholder="Contoh: Visi & Misi Kota" value="<?= old('title') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Konten</label>
                            <!-- Tambahkan class 'editor' jika ingin integrasi CKEditor/Summernote -->
                            <textarea class="form-control editor" name="content" rows="10" placeholder="Tulis konten lengkap disini..."><?= old('content') ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kategori / Section <span class="text-danger">*</span></label>
                                    <input class="form-control" list="sectionOptions" name="section" id="section" placeholder="Pilih atau ketik..." value="<?= old('section') ?>" required>
                                    <datalist id="sectionOptions">
                                        <option value="profil">Profil</option>
                                        <option value="visi_misi">Visi Misi</option>
                                        <option value="ruang_lingkup">Ruang Lingkup</option>
                                        <option value="susunan_organisasi">Susunan Organisasi</option>
                                    </datalist>
                                    <div class="form-text">Pilih dari list atau ketik baru.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar Pendukung</label>
                                    <!-- Preview -->
                                    <div class="mb-2 position-relative bg-white rounded border d-flex align-items-center justify-content-center overflow-hidden" style="height: 150px;">
                                        <img id="img-preview" src="#" alt="Preview" class="d-none w-100 h-100 object-fit-cover">
                                        <div id="img-placeholder" class="text-center text-muted">
                                            <i class="fas fa-image fa-2x mb-2"></i><br>
                                            <small>Preview Gambar</small>
                                        </div>
                                    </div>
                                    <input class="form-control" type="file" id="image_url" name="image_url" accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text mt-1">Format: JPG, PNG. Maks 2MB.</div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-bold small">Urutan</label>
                                        <input type="number" class="form-control" name="sorting" value="<?= old('sorting', 0) ?>">
                                    </div>
                                    <div class="col-6 pt-4">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                                            <label class="form-check-label fw-bold small" for="is_active">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/profil_tentang" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('img-preview');
        const placeholder = document.getElementById('img-placeholder');
        
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