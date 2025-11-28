<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Video Layanan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/home_video_layanan">Video Layanan</a></li>
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
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit Video</h6>
        </div>
        <div class="card-body">
            <form action="/home_video_layanan/<?= $video['id_video_layanan'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Video <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="<?= old('title', $video['title']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link YouTube <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                                <input type="url" class="form-control" name="youtube_url" value="<?= old('youtube_url', $video['youtube_url']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Embed Code</label>
                            <textarea class="form-control" name="embed_code" rows="3"><?= old('embed_code', $video['embed_code']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea class="form-control" name="description" rows="2"><?= old('description', $video['description']) ?></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan (Thumbnail & Opsi) -->
                    <div class="col-md-5">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <label class="form-label fw-bold">Thumbnail Video</label>
                                
                                <!-- Preview Container -->
                                <div class="mb-3 position-relative bg-white rounded border d-flex align-items-center justify-content-center overflow-hidden" style="height: 180px;">
                                    <?php 
                                        $hasThumb = !empty($video['thumb_image']) && file_exists($video['thumb_image']);
                                        $thumbSrc = $hasThumb ? base_url($video['thumb_image']) : '#';
                                        $thumbClass = $hasThumb ? 'w-100 h-100 object-fit-cover' : 'd-none';
                                        $phClass = $hasThumb ? 'd-none' : '';
                                    ?>
                                    <img id="thumb-preview" src="<?= $thumbSrc ?>" alt="Preview" class="<?= $thumbClass ?>">
                                    <div id="thumb-placeholder" class="text-center text-muted <?= $phClass ?>">
                                        <i class="fas fa-image fa-2x mb-2"></i><br>
                                        <small><?= $hasThumb ? 'Ganti Thumbnail' : 'Belum ada Thumbnail' ?></small>
                                    </div>
                                </div>

                                <input class="form-control" type="file" id="thumb_image" name="thumb_image" accept="image/*" onchange="previewImage(this)">
                                <div class="form-text mt-2">Biarkan kosong jika tidak ingin mengubah thumbnail.</div>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="sorting" value="<?= old('sorting', $video['sorting']) ?>">
                                    <label>Urutan</label>
                                </div>
                            </div>
                            <div class="col-md-6 pt-2">
                                <div class="form-check form-switch mb-2">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= old('is_featured', $video['is_featured']) == 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="is_featured">Video Utama?</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', $video['is_active']) == 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/home_video_layanan" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Video</button>
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
                preview.className = 'w-100 h-100 object-fit-cover';
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>