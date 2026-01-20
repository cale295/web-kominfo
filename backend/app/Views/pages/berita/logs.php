<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --success: #059669;
        --warning: #d97706;
        --danger: #dc2626;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .page-header h4 {
        font-size: 1.4rem;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .page-header p {
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .timeline-wrapper {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .timeline-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--gray-200);
    }

    .timeline-header i {
        font-size: 1.5rem;
        color: var(--primary);
    }

    .timeline-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1e293b;
    }

    .timeline-container {
        position: relative;
        padding: 10px 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 50px;
        padding-bottom: 30px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    /* Timeline Dot */
    .timeline-dot {
        position: absolute;
        left: 0;
        top: 5px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        z-index: 2;
    }

    .dot-draft { 
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    }
    
    .dot-layak { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .dot-verif {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .dot-revisi {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    }

    .timeline-line {
        position: absolute;
        left: 19px;
        top: 43px;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #cbd5e1, #e2e8f0);
    }

    .timeline-item:last-child .timeline-line {
        display: none;
    }

    /* Log Card */
    .log-card {
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        padding: 0;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }

    .log-card:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .log-card-header {
        padding: 18px;
        cursor: pointer;
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
    }

    .log-card-header:hover {
        background: #f0f4ff;
    }

    .status-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .status-badge {
        padding: 10px 18px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .news-content-wrapper {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #374151;
}

.content-section {
    margin-bottom: 0;
}

.content-section p {
    margin-bottom: 1.2em;
    text-align: justify;
}

.content-divider {
    text-align: center;
    margin: 30px 0;
    position: relative;
}

.content-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(to right, transparent, #cbd5e1, transparent);
}

.divider-text {
    background: white;
    padding: 0 20px;
    color: #64748b;
    font-size: 0.9rem;
    font-style: italic;
    position: relative;
    z-index: 1;
}

/* Styling untuk konten berita */
.snapshot-value.large {
    font-size: 1rem;
    line-height: 1.7;
}

.snapshot-value.large img {
    max-width: 100%;
    height: auto;
    margin: 15px 0;
    border-radius: 8px;
}

.snapshot-value.large h1,
.snapshot-value.large h2,
.snapshot-value.large h3,
.snapshot-value.large h4 {
    margin-top: 1.5em;
    margin-bottom: 0.8em;
    color: #1e293b;
}

.snapshot-value.large blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1.5em;
    margin: 1.5em 0;
    color: #475569;
    font-style: italic;
}
    .status-draft {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #334155;
    }

    .status-layak {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-verif {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .status-revisi {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #7c2d12;
    }

    .collapse-hint {
        color: var(--primary);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 600;
    }

    .collapse-icon {
        transition: transform 0.3s;
        font-size: 1.1rem;
    }

    .log-card[aria-expanded="true"] .collapse-icon {
        transform: rotate(180deg);
    }

    .log-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--gray-300);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #64748b;
    }

    .meta-item i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .meta-item strong {
        color: #1e293b;
        font-weight: 600;
    }

    /* Info Badges */
    .info-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 12px;
    }

    .info-badge {
        padding: 7px 14px;
        border-radius: 18px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .badge-change {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fbbf24;
    }

    .badge-content-edit {
        background: #e0e7ff;
        color: #3730a3;
        border: 1px solid #818cf8;
    }

    /* Detail Section */
    .log-detail {
        padding: 22px;
        background: white;
    }

    .detail-section {
        margin-bottom: 22px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--gray-200);
    }

    .section-title i {
        color: var(--primary);
        font-size: 1.2rem;
    }

    /* Change Items */
    .change-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .change-item {
        background: #fffbeb;
        border: 2px solid #fbbf24;
        border-radius: 8px;
        padding: 14px;
    }

    .change-field {
        font-weight: 700;
        color: #92400e;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .change-field i {
        font-size: 1rem;
    }

    .change-comparison {
        display: grid;
        gap: 10px;
    }

    .value-box {
        padding: 12px;
        border-radius: 6px;
        font-size: 0.9rem;
        position: relative;
        padding-left: 40px;
    }

    .value-box::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
    }

    .value-old {
        background: #fee2e2;
        border-left: 4px solid #dc2626;
    }

    .value-old::before {
        content: '✕';
        background: #dc2626;
        color: white;
    }

    .value-new {
        background: #dcfce7;
        border-left: 4px solid #16a34a;
    }

    .value-new::before {
        content: '✓';
        background: #16a34a;
        color: white;
    }

    .value-label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 4px;
        display: block;
        letter-spacing: 0.5px;
    }

    .label-old { color: #dc2626; }
    .label-new { color: #16a34a; }

    /* Snapshot Section */
    .snapshot-grid {
        display: grid;
        gap: 15px;
    }

    .snapshot-item {
        background: var(--gray-50);
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        padding: 14px;
    }

    .snapshot-label {
        font-weight: 700;
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.5px;
    }

    .snapshot-label i {
        font-size: 1rem;
    }

    .snapshot-value {
        background: white;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid var(--gray-300);
        min-height: 38px;
        font-size: 0.95rem;
    }

    .snapshot-value.large {
        max-height: 250px;
        overflow-y: auto;
        padding: 15px;
    }

    .snapshot-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* Notes Section */
    .notes-section {
        background: #f8fafc;
        border-radius: 8px;
        padding: 15px;
        border-left: 4px solid var(--primary);
    }

    .notes-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 15px;
        opacity: 0.3;
    }

    .empty-state h5 {
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .timeline-item {
            padding-left: 45px;
        }

        .timeline-dot {
            width: 36px;
            height: 36px;
        }

        .timeline-line {
            left: 18px;
        }

        .log-meta {
            flex-direction: column;
            gap: 10px;
        }
        
        .status-main {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="bi bi-clock-history me-2"></i>Riwayat Perubahan Berita</h4>
            <p class="mb-0">Lihat semua perubahan yang terjadi pada berita ini</p>
        </div>
        <a href="<?= site_url('berita') ?>" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="timeline-wrapper">
    <div class="timeline-header">
        <i class="bi bi-newspaper"></i>
        <div>
            <h5><?= esc($berita['judul']) ?></h5>
            <small class="text-muted">Klik pada setiap kartu untuk melihat detail</small>
        </div>
    </div>

    <?php if (!empty($logs)): ?>
        <div class="timeline-container">
            <?php foreach ($logs as $index => $item): ?>
                <?php 
                    $log = $item['log'];
                    $data = $item['data'];
                    $changes = $item['changes'] ?? [];
                    $hasChanges = $item['hasChanges'] ?? false;
                    $statusBeritaChanged = $item['statusBeritaChanged'] ?? false;
                    $statusBeritaChangeInfo = $item['statusBeritaChangeInfo'] ?? null;
                    $currentStatusBerita = $item['currentStatusBerita'] ?? 0;
                    
                    // Tentukan label & class
                    $statusText = 'Draft';
                    $statusClass = 'status-draft';
                    $dotClass = 'dot-draft';
                    $iconStatus = 'bi-file-earmark-text';
                    
                    if ($currentStatusBerita == '4') {
                        $statusText = 'Layak Tayang';
                        $statusClass = 'status-layak';
                        $dotClass = 'dot-layak';
                        $iconStatus = 'bi-check-circle';
                    } elseif ($currentStatusBerita == '2') {
                        $statusText = 'Menunggu Verifikasi';
                        $statusClass = 'status-verif';
                        $dotClass = 'dot-verif';
                        $iconStatus = 'bi-hourglass-split';
                    } elseif ($currentStatusBerita == '6') {
                        $statusText = 'Revisi';
                        $statusClass = 'status-revisi';
                        $dotClass = 'dot-revisi';
                        $iconStatus = 'bi-arrow-clockwise';
                    }
                ?>
                <div class="timeline-item">
                    <div class="timeline-dot <?= $dotClass ?>">
                        <i class="bi <?= $iconStatus ?>"></i>
                    </div>
                    <div class="timeline-line"></div>

                    <div class="log-card" 
                         data-bs-toggle="collapse" 
                         data-bs-target="#detail<?= $index ?>"
                         aria-expanded="false">
                        
                        <div class="log-card-header">
                            <div class="status-main">
                                <span class="status-badge <?= $statusClass ?>">
                                    <i class="bi <?= $iconStatus ?>"></i>
                                    <?= $statusText ?>
                                </span>
                                <span class="collapse-hint">
                                    Klik untuk detail
                                    <i class="bi bi-chevron-down collapse-icon"></i>
                                </span>
                            </div>

                            <div class="log-meta">
                                <div class="meta-item">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Oleh: <strong><?= esc($log['full_name']) ?></strong></span>
                                </div>
                                <div class="meta-item">
                                    <i class="bi bi-calendar-check"></i>
                                    <span><strong><?= date('d M Y', strtotime($log['created_date'])) ?></strong></span>
                                </div>
                                <div class="meta-item">
                                    <i class="bi bi-clock"></i>
                                    <span><strong><?= date('H:i', strtotime($log['created_date'])) ?> WIB</strong></span>
                                </div>
                            </div>

                            <?php if ($statusBeritaChanged || $hasChanges): ?>
                                <div class="info-badges">
                                    <?php if ($statusBeritaChanged): ?>
                                        <?php 
                                            $getLabel = function($code) {
                                                if ($code == '4') return 'Layak Tayang';
                                                elseif ($code == '2') return 'Menunggu Verifikasi';
                                                elseif ($code == '6') return 'Revisi';
                                                return 'Draft';
                                            };

                                            $fromText = $getLabel($statusBeritaChangeInfo['from']);
                                            $toText = $getLabel($statusBeritaChangeInfo['to']);
                                        ?>
                                        <span class="info-badge badge-change">
                                            <i class="bi bi-arrow-left-right"></i>
                                            Status: <?= $fromText ?> → <?= $toText ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($hasChanges): ?>
                                        <span class="info-badge badge-content-edit">
                                            <i class="bi bi-pencil-square"></i>
                                            <?= count($changes) ?> bagian diubah
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="collapse" id="detail<?= $index ?>">
                            <div class="log-detail">
                                
                                <?php if ($hasChanges): ?>
                                    <div class="detail-section">
                                        <div class="section-title">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Bagian yang Diubah</span>
                                        </div>
                                        <div class="change-list">
                                            <?php foreach ($changes as $change): ?>
                                                <div class="change-item">
                                                    <div class="change-field">
                                                        <i class="bi bi-arrow-right-short"></i>
                                                        <?= esc($change['field']) ?>
                                                    </div>
                                                    <div class="change-comparison">
                                                        <div class="value-box value-old">
                                                            <span class="value-label label-old">Sebelum:</span>
                                                            <div><?= nl2br(esc(substr($change['old'], 0, 200))) ?><?= strlen($change['old']) > 200 ? '...' : '' ?></div>
                                                        </div>
                                                        <div class="value-box value-new">
                                                            <span class="value-label label-new">Sesudah:</span>
                                                            <div><?= nl2br(esc(substr($change['new'], 0, 200))) ?><?= strlen($change['new']) > 200 ? '...' : '' ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="detail-section">
                                    <div class="section-title">
                                        <i class="bi bi-file-text"></i>
                                        <span>Isi Berita Saat Ini</span>
                                    </div>
                                    <div class="snapshot-grid">
                                        <div class="snapshot-item">
                                            <div class="snapshot-label">
                                                <i class="bi bi-card-heading"></i>
                                                Judul Berita
                                            </div>
                                            <div class="snapshot-value fw-bold">
                                                <?= esc($data['judul'] ?? '-') ?>
                                            </div>
                                        </div>

                                        <div class="snapshot-item">
                                            <div class="snapshot-label">
                                                <i class="bi bi-text-paragraph"></i>
                                                Ringkasan (Intro)
                                            </div>
                                            <div class="snapshot-value">
                                                <?= nl2br(esc($data['intro'] ?? '-')) ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="snapshot-item">
                                                    <div class="snapshot-label">
                                                        <i class="bi bi-link-45deg"></i>
                                                        Sumber Berita
                                                    </div>
                                                    <div class="snapshot-value">
                                                        <?= esc($data['sumber'] ?? '-') ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="snapshot-item">
                                                    <div class="snapshot-label">
                                                        <i class="bi bi-folder"></i>
                                                        Kategori
                                                    </div>
                                                    <div class="snapshot-value">
                                                        <?php 
                                                            $kategori = $data['kategori_berita'] ?? [];
                                                            echo !empty($kategori) 
                                                                ? implode(', ', array_column($kategori, 'kategori'))
                                                                : '-';
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

<?php 
    // Gabungkan dengan logika yang lebih cerdas
    $hasContent1 = !empty($data['content']);
    $hasContent2 = !empty($data['content2']);
?>

<?php if ($hasContent1 || $hasContent2): ?>
    <div class="snapshot-item">
        <div class="snapshot-label">
            <i class="bi bi-file-earmark-text"></i>
            Isi Berita Lengkap
        </div>
        <div class="snapshot-value large">
            <div class="news-content-wrapper">
                <?php if ($hasContent1): ?>
                    <div class="content-section">
                        <?= $data['content'] ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($hasContent1 && $hasContent2): ?>
                    <div class="content-divider">
                        <span class="divider-text">Lanjutan Berita</span>
                    </div>
                <?php endif; ?>
                
                <?php if ($hasContent2): ?>
                    <div class="content-section">
                        <?= $data['content2'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
                                        <?php if (!empty($data['feat_image'])): ?>
                                            <div class="snapshot-item">
                                                <div class="snapshot-label">
                                                    <i class="bi bi-image"></i>
                                                    Foto Utama
                                                </div>
                                                <div class="snapshot-value">
                                                    <img src="<?= base_url($data['feat_image']) ?>" 
                                                         alt="Foto Utama" 
                                                         class="snapshot-image">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (!empty($log['note_perbaikan']) || !empty($log['note_revisi'])): ?>
                                    <div class="detail-section">
                                        <div class="section-title">
                                            <i class="bi bi-chat-left-text"></i>
                                            <span>Catatan</span>
                                        </div>
                                        <div class="row">
                                            <?php if (!empty($log['note_perbaikan'])): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="notes-section">
                                                        <div class="notes-title text-primary">
                                                            <i class="bi bi-info-circle"></i>
                                                            Catatan dari Admin
                                                        </div>
                                                        <div class="text-muted">
                                                            <?= nl2br(esc($log['note_perbaikan'])) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($log['note_revisi'])): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="notes-section" style="border-left-color: var(--warning);">
                                                        <div class="notes-title text-warning">
                                                            <i class="bi bi-exclamation-circle"></i>
                                                            Catatan Revisi
                                                        </div>
                                                        <div class="text-muted">
                                                            <?= nl2br(esc($log['note_revisi'])) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h5>Belum Ada Riwayat Perubahan</h5>
            <p>Berita ini belum pernah diubah sejak dibuat</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-close other cards when opening one (optional)
        const logCards = document.querySelectorAll('.log-card');
        
        // Optional: Auto-close other open cards when one is opened
        logCards.forEach(card => {
            card.addEventListener('show.bs.collapse', function() {
                logCards.forEach(otherCard => {
                    if (otherCard !== this.closest('.log-card')) {
                        const collapse = otherCard.querySelector('.collapse.show');
                        if (collapse) {
                            new bootstrap.Collapse(collapse).hide();
                        }
                    }
                });
            });
        });
    });
</script>
<?= $this->endSection() ?>