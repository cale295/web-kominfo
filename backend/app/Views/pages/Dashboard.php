<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
/* ===============================
   DASHBOARD BAPAK-BAPAK KOMINFO
   Simpel • Jelas • Resmi
================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary: #1d4ed8;      /* Biru pemerintah */
    --secondary: #374151;    /* Abu tua */
    --text-main: #111827;
    --text-muted: #6b7280;
    --bg-body: #f3f4f6;
    --card-bg: #ffffff;
    --border: #d1d5db;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: var(--bg-body);
    color: var(--text-main);
    font-size: 17px;
}

/* ===============================
   LAYOUT
================================ */

.dashboard-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
}

/* ===============================
   HEADER
================================ */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
}

.header-title h1 {
    font-size: 24px;
    font-weight: 700;
}

.header-title p {
    margin-top: 4px;
    color: var(--secondary);
}

.user-badge {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 2px solid var(--border);
    padding: 12px 16px;
    background: #fff;
}

.role-tag {
    margin-top: 4px;
    display: inline-block;
    background: var(--primary);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 8px;
}

/* ===============================
   STAT CARDS
================================ */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.card {
    background: var(--card-bg);
    border: 2px solid var(--border);
    padding: 20px;
}

.card-icon-wrapper {
    width: 60px;
    height: 60px;
    background: #e0e7ff;
    color: var(--primary);
    font-size: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}

.card-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--secondary);
    margin-bottom: 8px;
    text-transform: uppercase;
}

.card-value {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 12px;
}

.card-footer {
    font-size: 15px;
    color: var(--secondary);
    border-top: 2px solid var(--border);
    padding-top: 10px;
}

/* ===============================
   ACTIVITY
================================ */

.table-card {
    background: #fff;
    border: 2px solid var(--border);
}

.card-header {
    padding: 16px 20px;
    border-bottom: 2px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 700;
}

.activity-list {
    list-style: none;
}

.activity-item {
    display: flex;
    gap: 16px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon-box {
    width: 44px;
    height: 44px;
    background: #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.activity-details h5 {
    font-size: 16px;
    font-weight: 700;
}

.activity-meta {
    margin-top: 4px;
    font-size: 14px;
    color: var(--text-muted);
}

/* ===============================
   FOOTER
================================ */

.footer {
    margin-top: 40px;
    text-align: center;
    font-size: 14px;
    color: var(--text-muted);
}

/* ===============================
   RESPONSIVE
================================ */

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
}
</style>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="dashboard-wrapper">


    <!-- STAT -->
    <div class="stats-grid">

        <div class="card">
            <div class="card-icon-wrapper"><i class="bi bi-newspaper"></i></div>
            <div class="card-title">Total Berita</div>
            <div class="card-value"><?= $total_berita ?? 0 ?></div>
            <div class="card-footer">
                Terbit: <?= $publish_berita ?? 0 ?> | Draft: <?= $draft_berita ?? 0 ?>
            </div>
        </div>

        <div class="card">
            <div class="card-icon-wrapper"><i class="bi bi-calendar-check"></i></div>
            <div class="card-title">Agenda</div>
            <div class="card-value"><?= $agenda_total ?? 0 ?></div>
            <div class="card-footer">
                Akan datang: <?= $agenda_upcoming ?? 0 ?>
            </div>
        </div>

        <div class="card">
            <div class="card-icon-wrapper"><i class="bi bi-images"></i></div>
            <div class="card-title">Galeri Foto</div>
            <div class="card-value"><?= $gallery_total ?? 0 ?></div>
            <div class="card-footer">
                Total album tersimpan
            </div>
        </div>

        <div class="card">
            <div class="card-icon-wrapper"><i class="bi bi-file-earmark-text"></i></div>
            <div class="card-title">Dokumen</div>
            <div class="card-value"><?= $document_total ?? 0 ?></div>
            <div class="card-footer">
                Baru bulan ini: <?= $document_new ?? 0 ?>
            </div>
        </div>

    </div>

    <!-- ACTIVITY -->
    <div class="table-card">
        <div class="card-header">
            <h3>Aktivitas Terakhir</h3>
        </div>

        <ul class="activity-list">
            <?php if (!empty($last_logs)): ?>
                <?php foreach ($last_logs as $log): ?>
                    <li class="activity-item">
                        <div class="activity-icon-box">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="activity-details">
                            <h5><?= esc($log['keterangan']) ?></h5>
                            <div class="activity-meta">
                                <?= date('d M Y H:i', strtotime($log['created_date'])) ?> —
                                <?= esc($log['username'] ?? 'System') ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach ?>
            <?php else: ?>
                <li class="activity-item">
                    <div class="activity-details">
                        <h5>Belum ada aktivitas</h5>
                    </div>
                </li>
            <?php endif ?>
        </ul>
    </div>

    <div class="footer">
        &copy; <?= date('Y') ?> Sistem Administrasi Pemerintah
    </div>

</div>
<?= $this->endSection() ?>
