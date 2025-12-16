<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    /* Styling khusus halaman Detail */
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
        background: #4361ee; /* Warna Primary */
    }
    .photo-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        height: 100%;
    }
    .photo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .photo-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
        cursor: pointer;
    }
    .photo-body {
        padding: 1rem;
    }
    .photo-title {
        font-weight: 600;
        margin-bottom: 0.2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Lightbox sederhana (opsional, biar foto bisa di-zoom) */
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
        
        <div class="mt-3 mt-md-0">
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
            <div class="col-6 col-md-4 col-lg-3">
                <div class="photo-card">
                    <img src="<?= base_url('uploads/gallery/' . $photo['file_path']) ?>" 
                         class="photo-img" 
                         alt="<?= esc($photo['photo_title'] ?? 'Foto') ?>"
                         data-bs-toggle="modal" data-bs-target="#lightboxModal"
                         onclick="showLightbox(this.src, '<?= esc($photo['photo_title'] ?? '') ?>')">
                    
                    <div class="photo-body">
                        <div class="photo-title text-dark"><?= esc($photo['photo_title']) ?: 'Tanpa Judul' ?></div>
                        <small class="text-muted d-block text-truncate"><?= esc($photo['deskripsi']) ?: '-' ?></small>
                        
                        <form action="<?= site_url('photo/delete/'.$photo['id_photo']) ?>" method="post" class="mt-2" onsubmit="return confirm('Hapus foto ini?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-sm btn-light text-danger w-100 border hover-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
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

<script>
    function showLightbox(src, title) {
        document.getElementById('lightboxImage').src = src;
        document.getElementById('lightboxTitle').innerText = title;
    }
</script>

<?= $this->endSection() ?>