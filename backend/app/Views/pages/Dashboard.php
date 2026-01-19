<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* ===============================
   DESIGN SYSTEM (Selaras dengan Sidebar)
================================ */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    /* Primary Colors - Sama dengan sidebar */
    --primary: #6366f1;      /* Indigo */
    --primary-light: #eef2ff;
    --primary-dark: #4f46e5;
    
    /* Neutral Colors */
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    
    /* Semantic Colors */
    --success: #10b981;
    --success-light: #d1fae5;
    --warning: #f59e0b;
    --warning-light: #fef3c7;
    --danger: #ef4444;
    --danger-light: #fee2e2;
    --info: #06b6d4;
    --info-light: #cffafe;
    
    /* Surface */
    --bg-body: #f9fafb;
    --card-bg: #ffffff;
    --border: #e5e7eb;
    
    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-body);
    color: var(--gray-900);
    font-size: 14px;
    line-height: 1.5;
}

/* ===============================
   LAYOUT
================================ */

.dashboard-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

/* ===============================
   STAT CARDS (Modern Grid)
================================ */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 0.75rem;
    padding: 1.5rem;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
    border-color: var(--primary);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark));
}

.card-header-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.card-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    background: var(--primary-light);
    color: var(--primary);
    transition: transform 0.2s;
}

.stat-card:hover .card-icon-wrapper {
    transform: scale(1.1);
}

.card-trend {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.card-trend.up {
    background: var(--success-light);
    color: var(--success);
}

.card-trend.down {
    background: var(--danger-light);
    color: var(--danger);
}

.card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-value {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1;
    margin-bottom: 1rem;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
    font-size: 0.8rem;
    color: var(--gray-500);
}

.card-footer strong {
    color: var(--gray-900);
    font-weight: 600;
}

/* Variasi warna untuk card icons */
.stat-card:nth-child(1) .card-icon-wrapper {
    background: #eef2ff;
    color: #6366f1;
}

.stat-card:nth-child(2) .card-icon-wrapper {
    background: #fef3c7;
    color: #f59e0b;
}

.stat-card:nth-child(3) .card-icon-wrapper {
    background: #d1fae5;
    color: #10b981;
}

.stat-card:nth-child(4) .card-icon-wrapper {
    background: #cffafe;
    color: #06b6d4;
}

/* ===============================
   ACTIVITY TABLE CARD
================================ */

.table-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.table-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    background: var(--gray-50);
}

.table-card-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-900);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table-card-header h3 i {
    color: var(--primary);
}

.activity-list {
    list-style: none;
}

.activity-item {
    display: flex;
    gap: 1rem;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    transition: background 0.2s;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item:hover {
    background: var(--gray-50);
}

.activity-icon-box {
    width: 44px;
    height: 44px;
    min-width: 44px;
    background: var(--primary-light);
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    color: var(--primary);
}

.activity-details {
    flex: 1;
}

.activity-details h5 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
}

.activity-meta {
    font-size: 0.8125rem;
    color: var(--gray-500);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.activity-meta i {
    font-size: 0.75rem;
}

.activity-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.125rem 0.5rem;
    background: var(--gray-100);
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--gray-600);
}

/* ===============================
   EMPTY STATE
================================ */

.empty-state {
    text-align: center;
    padding: 3rem 1.5rem;
}

.empty-state i {
    font-size: 3rem;
    color: var(--gray-300);
    margin-bottom: 1rem;
}

.empty-state h5 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--gray-500);
    font-size: 0.875rem;
}

/* ===============================
   RESPONSIVE
================================ */

@media (max-width: 768px) {
    .dashboard-wrapper {
        padding: 1.5rem 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .card-value {
        font-size: 1.875rem;
    }

    .header-title h1 {
        font-size: 1.5rem;
    }

    .activity-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1" style="background: linear-gradient(45deg, #4e73df, #224abe); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Dashboard Administrator
            </h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-tachometer-alt me-1 text-primary"></i> 
                Ringkasan statistik dan aktivitas sistem.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm border-start border-4 border-success rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-success me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-check"></i>
                </div>
                <div class="fw-medium">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="dashboard-wrapper">
        <!-- STATISTICS GRID -->
        <div class="stats-grid">

            <div class="stat-card">
                <div class="card-header-section">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
                <div class="card-title">Total Berita</div>
                <div class="card-value"><?= $total_berita ?? 0 ?></div>
                <div class="card-footer">
                    <span><strong><?= $publish_berita ?? 0 ?></strong> Terbit</span>
                    <span><strong><?= $draft_berita ?? 0 ?></strong> Draft</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="card-header-section">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="card-title">Agenda</div>
                <div class="card-value"><?= $agenda_total ?? 0 ?></div>
                <div class="card-footer">
                    <span><strong><?= $agenda_upcoming ?? 0 ?></strong> Akan Datang</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="card-header-section">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
                <div class="card-title">Galeri Foto</div>
                <div class="card-value"><?= $gallery_total ?? 0 ?></div>
                <div class="card-footer">
                    <span>Album Tersimpan</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="card-header-section">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
                <div class="card-title">Dokumen</div>
                <div class="card-value"><?= $document_total ?? 0 ?></div>
                <div class="card-footer">
                    <span><strong><?= $document_new ?? 0 ?></strong> Bulan Ini</span>
                </div>
            </div>

        </div>

        <!-- RECENT ACTIVITY -->
        <div class="table-card">
            <div class="table-card-header">
                <h3>
                    <i class="fas fa-history"></i>
                    Aktivitas Terakhir
                </h3>
            </div>

            <ul class="activity-list">
                <?php if (!empty($last_logs)): ?>
                    <?php foreach ($last_logs as $log): ?>
                        <li class="activity-item">
                            <div class="activity-icon-box">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="activity-details">
                                <h5><?= esc($log['keterangan']) ?></h5>
                                <div class="activity-meta">
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        <?= date('d M Y, H:i', strtotime($log['created_date'])) ?>
                                    </span>
                                    <span class="activity-badge">
                                        <i class="fas fa-user"></i>
                                        <?= esc($log['username'] ?? 'System') ?>
                                    </span>
                                </div>
                            </div>
                        </li>
                    <?php endforeach ?>
                <?php else: ?>
                    <li class="activity-item">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h5>Belum Ada Aktivitas</h5>
                            <p>Aktivitas sistem akan muncul di sini</p>
                        </div>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>