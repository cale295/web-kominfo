<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Styling Header */
    .header-detail {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .header-detail::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 5px; height: 100%;
        background: #4361ee;
    }

    /* Styling Card Foto */
    .photo-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .photo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .photo-img-wrapper {
        position: relative;
        height: 200px; /* Tinggi tetap agar layout rapi */
        width: 100%;
        background-color: #f0f0f0; /* Placeholder warna abu saat loading */
        overflow: hidden;
    }
    .photo-img {
        height: 100%;
        width: 100%;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .photo-img:hover {
        transform: scale(1.05);
    }
    .photo-body {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .photo-title {
        font-weight: 600;
        margin-bottom: 0.2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .status-badge {
        position: absolute;
        top: 10px; right: 10px;
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 20px;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    /* Lightbox */
    .modal-fullscreen .modal-body { padding: 0; background: black; display: flex; align-items: center; justify-content: center; }
    .modal-fullscreen img { max-height: 100vh; max-width: 100vw; }
</style>

<div class="container-fluid py-4">

    <a href="<?= site_url('album') ?>" class="btn btn-outline-secondary mb-3 rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Album
    </a>

    <div class="header-detail d-md-flex justify-content-between align-items-start">
        <div>
            <h2 class="fw-bold mb-1"><?= esc($album['album_name']) ?></h2>
            <p class="text-muted mb-2"><?= esc($album['description']) ?: 'Tidak ada deskripsi.' ?></p>
            <span class="badge bg-light text-primary border">
                <i class="bi bi-images me-1"></i> <?= count($photos) ?> Foto
            </span>
            <span class="badge bg-light text-secondary border ms-1">
                Dibuat: <?= date('d M Y', strtotime($album['created_at'] ?? 'now')) ?>
            </span>
        </div>
    </div>

    <?php if (empty($photos)): ?>
        <div class="text-center py-5 bg-white rounded-3 shadow-sm">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="100" class="mb-3 opacity-50">
            <h5 class="text-muted">Album ini masih kosong</h5>
            <p class="text-muted small">Kembali ke halaman utama untuk mengupload foto.</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($photos as $photo): ?>
            
            <?php 
                $is_active = ($photo['status'] == 0); 
                $status_label = $is_active ? 'Aktif' : 'Tidak Aktif';
                $status_class = $is_active ? 'bg-success text-white' : 'bg-secondary text-white';
                $btn_toggle_class = $is_active ? 'btn-outline-success' : 'btn-outline-secondary';
                $new_status_value = $is_active ? 1 : 0;
            ?>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="photo-card">
                    <div class="photo-img-wrapper">
                        <span class="status-badge <?= $status_class ?>">
                            <?= $status_label ?>
                        </span>

                        <img src="<?= base_url('uploads/gallery/' . $photo['file_path']) ?>" 
                             class="photo-img" 
                             alt="<?= esc($photo['photo_title'] ?? 'Foto') ?>"
                             loading="lazy" 
                             decoding="async"
                             data-bs-toggle="modal" data-bs-target="#lightboxModal"
                             onclick="showLightbox(this.src, '<?= esc($photo['photo_title'] ?? '') ?>')">
                    </div>
                    
                    <div class="photo-body">
                        <div class="photo-title text-dark"><?= esc($photo['photo_title']) ?: 'Tanpa Judul' ?></div>
                        <small class="text-muted d-block text-truncate mb-3"><?= esc($photo['deskripsi']) ?: '-' ?></small>
                        
                        <div class="mt-auto">
                            <form action="<?= site_url('photo/toggle/'.$photo['id_photo']) ?>" method="post" class="mb-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="status" value="<?= $new_status_value ?>">
                                <button type="submit" class="btn btn-sm <?= $btn_toggle_class ?> w-100 d-flex justify-content-between align-items-center">
                                    <span>Status: <strong><?= $status_label ?></strong></span>
                                    <i class="bi bi-toggle-<?= $is_active ? 'on' : 'off' ?> fs-6"></i>
                                </button>
                            </form>

                            <div class="d-flex gap-2">
                                <a href="<?= base_url('uploads/gallery/' . $photo['file_path']) ?>" 
                                   download="<?= $photo['photo_title'] ?: 'download-image' ?>" 
                                   class="btn btn-sm btn-primary flex-grow-1" 
                                   title="Download">
                                    <i class="bi bi-download"></i>
                                </a>

                                <form action="<?= site_url('photo/delete/'.$photo['id_photo']) ?>" method="post" class="flex-grow-1" onsubmit="return confirm('Hapus foto ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-sm btn-danger w-100" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0 bg-transparent position-absolute w-100" style="z-index: 1055;">
                <h5 class="modal-title text-white text-shadow" id="lightboxTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img id="lightboxImage" src="" alt="Full View">
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    
    <?php if (session()->getFlashdata('success')) : ?>
    <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
    <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-exclamation-triangle me-2"></i> <?= session()->getFlashdata('error') ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
    <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <ul class="mb-0 ps-3">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    // Script Lightbox
    function showLightbox(src, title) {
        document.getElementById('lightboxImage').src = src;
        document.getElementById('lightboxTitle').innerText = title;
    }

    // Auto Close Toast setelah 4 detik (Optional)
    document.addEventListener("DOMContentLoaded", function(){
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            // Inisialisasi toast bootstrap
            return new bootstrap.Toast(toastEl, { delay: 4000 });
        });
        // Tampilkan toast yang sudah ada class 'show' secara manual jika perlu
        // (Bootstrap 5 biasanya otomatis menampilkan jika ada class .show, 
        // tapi script ini memastikan behavior close button berfungsi)
    });
</script>

<?= $this->endSection() ?>