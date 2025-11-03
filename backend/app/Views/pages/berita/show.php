<h1><?= esc($berita['judul']) ?></h1>
<p><?= esc($berita['intro']) ?></p>
<div><?= $berita['content'] ?></div>

<h4>Berita Terkait</h4>
<ul>
    <?php foreach ($related as $r): ?>
        <li>
            <a href="<?= site_url('berita/' . $r['slug']) ?>">
                <?= esc($r['judul']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h2><?= esc($berita['judul']) ?></h2>
    <p><em>Topik: <?= esc($berita['topik']) ?></em></p>
    <p><?= esc($berita['content']) ?></p>

    <?php if (!empty($related)): ?>
        <h5>Berita Terkait:</h5>
        <ul>
            <?php foreach ($related as $r): ?>
                <li>
                    <a href="<?= site_url('berita/' . $r['slug']) ?>">
                        <?= esc($r['judul']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
