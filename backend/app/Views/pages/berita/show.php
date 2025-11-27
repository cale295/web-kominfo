<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-5">
    <a href="<?= site_url('berita') ?>" class="btn btn-outline-secondary mb-4 rounded-pill">
        <i class="bi bi-arrow-left me-2"></i> Kembali ke Berita
    </a>

    <article class="mb-5">
        <header class="mb-4">
            <?php if(!empty($tags)): ?>
                <div class="mb-3">
                    <?php foreach($tags as $t): ?>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-2 me-2">
                            #<?= esc($t) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($kategori)): ?>
                <div class="mb-3">
                    <?php foreach($kategori as $k): ?>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-2 me-2">
                            <?= esc($k) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            
            <h1 class="display-5 fw-bold mb-3 lh-sm"><?= esc($berita['judul']) ?></h1>
            
            <div class="d-flex flex-wrap align-items-center text-muted mb-3 border-bottom pb-3">
                <div class="me-4 mb-2">
                    <i class="bi bi-person-circle me-2 text-secondary"></i>
                    <span class="fw-medium text-dark"><?= esc($berita['created_by_name']) ?></span>
                </div>
                <div class="me-4 mb-2">
                    <i class="bi bi-calendar3 me-2 text-secondary"></i>
                    <small><?= date('d M Y', strtotime($berita['created_at'])) ?></small>
                </div>
                <div class="me-4 mb-2">
                    <i class="bi bi-eye me-2 text-secondary"></i>
                    <small><?= esc($berita['hit'] ?? 0) ?>x Dilihat</small>
                </div>
            </div>
        </header>

        <?php if(!empty($berita['feat_image'])): ?>
            <figure class="figure w-100 mb-5">
                <img src="<?= base_url($berita['feat_image']) ?>" 
                     class="figure-img img-fluid rounded shadow-sm w-100" 
                     alt="<?= esc($berita['judul']) ?>"
                     style="max-height: 550px; object-fit: cover;">
                
                <?php if(!empty($berita['caption'])): ?>
                    <figcaption class="figure-caption text-center fst-italic mt-2">
                        <i class="bi bi-camera me-1"></i> <?= esc($berita['caption']) ?>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <div class="article-content mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php if(!empty($berita['intro'])): ?>
                        <p class="lead fw-normal mb-4 text-dark">
                            <?= nl2br(esc($berita['intro'])) ?>
                        </p>
                    <?php endif; ?>

                    <div class="fs-5 lh-lg mb-4 text-break">
                        <?= $berita['content'] ?> </div>

                    <?php if(!empty($berita['content2'])): ?>
                        <div class="fs-5 lh-lg mb-4 text-break">
                            <?= $berita['content2'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if(!empty($additionalImages)): ?>
            <div class="my-5 pt-4 border-top">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-images me-2 text-primary"></i>Galeri Foto
                </h4>
                <div class="row g-4">
                    <?php foreach($additionalImages as $imgData): ?>
                        <?php
                            // Normalisasi Data (String vs Array)
                            $path = '';
                            $caption = '';

                            if (is_array($imgData)) {
                                $path = $imgData['path'] ?? '';
                                $caption = $imgData['caption'] ?? '';
                            } else {
                                $path = $imgData; // Format lama (string only)
                            }

                            if (empty($path)) continue;
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
                                <div class="position-relative">
                                    <img src="<?= base_url($path) ?>" 
                                         class="card-img-top" 
                                         alt="Galeri"
                                         style="height: 250px; object-fit: cover;">
                                    
                                    <div class="image-overlay d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrows-fullscreen text-white fs-4"></i>
                                    </div>
                                </div>
                                
                                <?php if(!empty($caption)): ?>
                                    <div class="card-body bg-light border-top">
                                        <p class="card-text small text-muted mb-0">
                                            <?= esc($caption) ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(!empty($berita['link_video'])): ?>
            <div class="alert alert-light border border-primary border-opacity-25 shadow-sm my-4 d-flex align-items-center" role="alert">
                <div class="display-6 text-danger me-3">
                    <i class="bi bi-youtube"></i>
                </div>
                <div>
                    <h5 class="alert-heading fw-bold mb-1">Video Terkait</h5>
                    <a href="<?= esc($berita['link_video']) ?>" target="_blank" class="alert-link text-decoration-none">
                        Tonton video selengkapnya di sini <i class="bi bi-box-arrow-up-right ms-1"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-wrap justify-content-between align-items-center border-top pt-4 mt-5">
            <?php if(!empty($berita['sumber'])): ?>
                <div class="mb-3">
                    <span class="text-muted me-2">Sumber:</span>
                    <span class="fw-bold text-dark"><?= esc($berita['sumber']) ?></span>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($berita['keyword'])): ?>
                <div class="mb-3 text-end">
                    <i class="bi bi-tags text-secondary me-2"></i>
                    <?php 
                        $tags = explode(',', $berita['keyword']);
                        foreach($tags as $tag): 
                    ?>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary fw-normal me-1">
                            #<?= esc(trim($tag)) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </article>

    <?php if(!empty($beritaTerkait)): ?>
        <section class="mt-5 pt-5 border-top bg-light p-4 rounded-4">
            <h4 class="fw-bold mb-4">
                <i class="bi bi-newspaper me-2 text-primary"></i>Baca Juga
            </h4>
            <div class="row g-4">
                <?php foreach($beritaTerkait as $bt): ?>
                    <?php if($bt): ?>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100 hover-lift">
                                <div class="row g-0 h-100">
                                    <div class="col-4">
                                        <img src="<?= base_url($bt['feat_image']) ?>" 
                                             class="img-fluid rounded-start h-100 w-100" 
                                             style="object-fit: cover;"
                                             alt="Thumbnail">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body py-2 pe-3">
                                            <small class="text-muted d-block mb-1">
                                                <?= date('d M Y', strtotime($bt['created_at'])) ?>
                                            </small>
                                            <h6 class="card-title mb-0 fw-bold">
                                                <a href="<?= site_url('berita/show/'.$bt['slug']) ?>" 
                                                   class="text-decoration-none text-dark stretched-link three-line-clamp">
                                                    <?= esc($bt['judul']) ?>
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
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
/* Custom Font & Styling */
.article-content {
    font-family: 'Georgia', 'Times New Roman', serif; /* Font serif enak dibaca untuk artikel panjang */
    color: #2d3748;
    line-height: 1.8;
}

/* Hover Animation for Cards */
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
}

/* Image Overlay Effect */
.image-overlay {
    position: absolute; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.3); opacity: 0; transition: 0.3s;
}
.card:hover .image-overlay { opacity: 1; }

/* Utilities */
.three-line-clamp {
    display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
}
.badge-soft-primary {
    background-color: rgba(13, 110, 253, 0.1); color: #0d6efd;
}
figure img {
    transition: opacity 0.3s;
}
figure img:hover {
    opacity: 0.95;
}
</style>

<?= $this->endSection() ?>