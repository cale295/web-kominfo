<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Layanan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/home_service">Home Service</a></li>
        <li class="breadcrumb-item active">Edit</li>
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
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit Layanan</h6>
        </div>
        <div class="card-body">
            <form action="/home_service/<?= $service['id_service'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="<?= old('title', $service['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">URL Tujuan</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                <input type="url" class="form-control" name="link" value="<?= old('link', $service['link']) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Urutan (Sorting)</label>
                                    <input type="number" class="form-control" name="sorting" value="<?= old('sorting', $service['sorting']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 pt-4">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', $service['is_active']) == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Upload Icon) -->
                    <div class="col-md-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                <label class="form-label fw-bold mb-3">Icon Layanan</label>
                                
                                <!-- Preview Container -->
                                <div class="mb-3 position-relative" style="width: 150px; height: 150px; border: 2px dashed #ccc; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: #fff; overflow: hidden;">
                                    <?php 
                                        $hasImage = !empty($service['icon_image']) && file_exists($service['icon_image']);
                                        $imgSrc = $hasImage ? base_url($service['icon_image']) : '#';
                                        $imgClass = $hasImage ? '' : 'd-none';
                                        $phClass = $hasImage ? 'd-none' : '';
                                    ?>
                                    <img id="icon-preview" src="<?= $imgSrc ?>" alt="Preview" class="<?= $imgClass ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    <span id="icon-placeholder" class="text-muted small <?= $phClass ?>">
                                        <?= $hasImage ? '' : 'Belum ada icon' ?>
                                    </span>
                                </div>

                                <input class="form-control" type="file" id="icon_image" name="icon_image" accept="image/*" onchange="previewImage(this)">
                                <div class="form-text mt-2">Biarkan kosong jika tidak ingin mengganti icon.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/home_service" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('icon-preview');
        const placeholder = document.getElementById('icon-placeholder');
        
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