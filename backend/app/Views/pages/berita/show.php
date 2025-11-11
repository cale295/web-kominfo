<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-5">
    <!-- Back Button -->
    <a href="<?= site_url('berita') ?>" class="btn btn-outline-secondary mb-4 rounded-pill">
        <i class="bi bi-arrow-left me-2"></i> Kembali ke Berita
    </a>

    <!-- Article Header -->
    <article class="mb-5">
        <header class="mb-4">
            <h1 class="display-5 fw-bold mb-3"><?= esc($berita['judul']) ?></h1>
            
            <!-- Meta Information -->
            <div class="d-flex flex-wrap align-items-center text-muted mb-3">
                <div class="me-4 mb-2">
                    <i class="bi bi-person-circle me-2"></i>
                    <small><?= esc($berita['created_by_name']) ?></small>
                </div>
                <div class="me-4 mb-2">
                    <i class="bi bi-calendar3 me-2"></i>
                    <small><?= date('d M Y', strtotime($berita['created_at'])) ?></small>
                </div>
                <?php if(!empty($berita['updated_at'])): ?>
                <div class="mb-2">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    <small>Diperbarui: <?= date('d M Y', strtotime($berita['updated_at'])) ?></small>
                </div>
                <?php endif; ?>
            </div>

            <!-- Kategori Badges -->
            <?php if(!empty($kategori)): ?>
                <div class="mb-4">
                    <?php foreach($kategori as $k): ?>
                        <span class="badge bg-primary rounded-pill px-3 py-2 me-2"><?= esc($k) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </header>

        <!-- Cover Image -->
        <?php if(!empty($berita['feat_image'])): ?>
            <div class="mb-5">
                <img src="<?= base_url($berita['feat_image']) ?>" 
                     class="img-fluid rounded shadow-sm w-100" 
                     alt="<?= esc($berita['judul']) ?>"
                     style="max-height: 500px; object-fit: cover;">
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="article-content mb-4">
            <div class="fs-5 lh-lg mb-4">
                <?= $berita['content'] ? nl2br(($berita['content'])) : '' ?>
            </div>

            <?php if(!empty($berita['content2'])): ?>
                <div class="fs-5 lh-lg mb-4">
                    <?= nl2br(($berita['content2'])) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Additional Images Gallery -->
        <?php if(!empty($additionalImages)): ?>
            <div class="my-5">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-images me-2"></i>Galeri Foto
                </h4>
                <div class="row g-3">
                    <?php foreach($additionalImages as $img): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <img src="<?= base_url($img) ?>" 
                                     class="card-img-top" 
                                     alt="Galeri"
                                     style="height: 250px; object-fit: cover;">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Video Link -->
        <?php if(!empty($berita['link_video'])): ?>
            <div class="alert alert-info border-0 shadow-sm my-4" role="alert">
                <h5 class="alert-heading">
                    <i class="bi bi-play-circle me-2"></i>Video Terkait
                </h5>
                <a href="<?= esc($berita['link_video']) ?>" 
                   target="_blank" 
                   class="alert-link">
                    Tonton Video <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
            </div>
        <?php endif; ?>

        <!-- Source -->
        <?php if(!empty($berita['sumber'])): ?>
            <div class="border-start border-primary border-4 ps-3 my-4">
                <small class="text-muted d-block mb-1">Sumber:</small>
                <p class="mb-0"><?= esc($berita['sumber']) ?></p>
            </div>
        <?php endif; ?>
    </article>

    <!-- Related News -->
    <?php if(!empty($beritaTerkait)): ?>
        <section class="mt-5 pt-5 border-top">
            <h4 class="fw-bold mb-4">
                <i class="bi bi-newspaper me-2"></i>Berita Terkait
            </h4>
            <div class="row g-4">
                <?php foreach($beritaTerkait as $bt): ?>
                    <?php if($bt): ?>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100 hover-lift">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="<?= site_url('berita/show/'.$bt['id_berita']) ?>" 
                                           class="text-decoration-none text-dark stretched-link">
                                            <?= esc($bt['judul']) ?>
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>

<style>
.article-content {
    font-family: 'Georgia', serif;
    color: #333;
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
</style>

<?= $this->endSection() ?>