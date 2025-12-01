<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Konten Profil</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/profil_tentang">Profil Tentang</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>


    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit</h6>
        </div>
        <div class="card-body">
            <form action="/profil_tentang/<?= $profil['id_tentang'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="<?= old('title', $profil['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Konten</label>
                            <textarea class="form-control editor" name="content" rows="10"><?= old('content', $profil['content']) ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kategori / Section <span class="text-danger">*</span></label>
                                    <input class="form-control" list="sectionOptions" name="section" id="section" value="<?= old('section', $profil['section']) ?>" required>
                                    <datalist id="sectionOptions">
                                        <option value="profil">Profil</option>
                                        <option value="visi_misi">Visi Misi</option>
                                        <option value="ruang_lingkup">Ruang Lingkup</option>
                                        <option value="susunan_organisasi">Susunan Organisasi</option>
                                    </datalist>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar Pendukung</label>
                                    
                                    <!-- Preview Container -->
                                    <div class="mb-2 position-relative bg-white rounded border d-flex align-items-center justify-content-center overflow-hidden" style="height: 150px;">
                                        <?php 
                                            $hasImage = !empty($profil['image_url']) && file_exists($profil['image_url']);
                                            $imgSrc = $hasImage ? base_url($profil['image_url']) : '#';
                                            $imgClass = $hasImage ? 'w-100 h-100 object-fit-cover' : 'd-none';
                                            $phClass = $hasImage ? 'd-none' : '';
                                        ?>
                                        <img id="img-preview" src="<?= $imgSrc ?>" alt="Preview" class="<?= $imgClass ?>">
                                        <div id="img-placeholder" class="text-center text-muted <?= $phClass ?>">
                                            <i class="fas fa-image fa-2x mb-2"></i><br>
                                            <small><?= $hasImage ? 'Ganti Gambar' : 'Belum ada Gambar' ?></small>
                                        </div>
                                    </div>

                                    <input class="form-control" type="file" id="image_url" name="image_url" accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-bold small">Urutan</label>
                                        <input type="number" class="form-control" name="sorting" value="<?= old('sorting', $profil['sorting']) ?>">
                                    </div>
                                    <div class="col-6 pt-4">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', $profil['is_active']) == 1 ? 'checked' : '' ?>>
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
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
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
                preview.className = 'w-100 h-100 object-fit-cover';
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>