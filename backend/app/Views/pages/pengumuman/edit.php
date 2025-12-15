<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Pengumuman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/pengumuman">Pengumuman</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit</h6>
        </div>
        <div class="card-body">
            <form action="/pengumuman/<?= $item['id_pengumuman'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Pengumuman <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" value="<?= old('judul', $item['judul']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Pengumuman <span class="text-danger">*</span></label>
                            <textarea class="form-control editor" name="content" rows="8"><?= old('content', $item['content']) ?></textarea>
                        </div>

                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <label class="form-label fw-bold">Pengaturan Media</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipe_media" id="tipeLink" value="link" onchange="toggleMedia('link')" <?= old('tipe_media', $item['tipe_media']) == 'link' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tipeLink"><i class="fas fa-link me-1"></i> Link URL</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tipe_media" id="tipeFile" value="file" onchange="toggleMedia('file')" <?= old('tipe_media', $item['tipe_media']) == 'file' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="tipeFile"><i class="fas fa-file-pdf me-1"></i> Upload File</label>
                                    </div>
                                </div>

                                <div id="inputLink" class="mb-2">
                                    <label class="form-label small">URL Tujuan</label>
                                    <input type="url" class="form-control" name="link_url" placeholder="https://..." value="<?= old('link_url', $item['link_url']) ?>">
                                </div>

                                <div id="inputFile" class="mb-2 d-none">
                                    <label class="form-label small">Upload Dokumen (PDF/DOC)</label>
                                    
                                    <?php if (!empty($item['file_media'])): ?>
                                        <div class="alert alert-info py-2 px-3 mb-2 small">
                                            <i class="fas fa-file-alt me-1"></i> File saat ini: 
                                            <a href="<?= base_url($item['file_media']) ?>" target="_blank" class="alert-link">Lihat File</a>
                                        </div>
                                    <?php endif; ?>

                                    <input type="file" class="form-control" name="file_media">
                                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah file.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <label class="form-label fw-bold">Gambar Utama (Cover)</label>
                                <div class="mb-3 position-relative bg-white rounded border d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px;">
                                    <?php 
                                        $hasThumb = !empty($item['featured_image']) && file_exists($item['featured_image']);
                                        $thumbSrc = $hasThumb ? base_url($item['featured_image']) : '#';
                                        $thumbClass = $hasThumb ? 'w-100 h-100 object-fit-contain' : 'd-none';
                                        $phClass = $hasThumb ? 'd-none' : '';
                                    ?>
                                    <img id="thumb-preview" src="<?= $thumbSrc ?>" alt="Preview" class="<?= $thumbClass ?>">
                                    <div id="thumb-placeholder" class="text-center text-muted <?= $phClass ?>">
                                        <i class="fas fa-image fa-2x mb-2"></i><br>
                                        <small><?= $hasThumb ? 'Ganti Gambar' : 'Belum ada Gambar' ?></small>
                                    </div>
                                </div>
                                <input class="form-control" type="file" name="featured_image" accept="image/*" onchange="previewImage(this)">
                                <div class="form-text mt-2">Biarkan kosong jika tidak diganti.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="0">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?= old('status', $item['status']) == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold" for="status">Status Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/pengumuman" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
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
                preview.classList.add('w-100', 'h-100', 'object-fit-contain');
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

    document.addEventListener("DOMContentLoaded", function() {
        const isFile = document.getElementById('tipeFile').checked;
        toggleMedia(isFile ? 'file' : 'link');
    });
</script>
<?= $this->endSection() ?>