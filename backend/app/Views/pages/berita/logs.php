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
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .page-header h4 {
        font-size: 1.5rem;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .page-header p {
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .timeline-wrapper {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
        padding-left: 60px;
        padding-bottom: 35px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item:last-child .timeline-line {
        display: none;
    }

    /* Timeline Dot */
    .timeline-dot {
        position: absolute;
        left: 0;
        top: 5px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        box-shadow: 0 3px 10px rgba(0,0,0, 0.2);
        z-index: 2;
    }

    .dot-draft { 
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    }
    
    .dot-layak { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* TAMBAHAN CSS UNTUK MENUNGGU VERIFIKASI (WARNING/ORANGE) */
    .dot-verif {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .timeline-line {
        position: absolute;
        left: 19px;
        top: 45px;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, var(--gray-300), var(--gray-200));
    }

    /* Log Card */
    .log-card {
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        padding: 0;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .log-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        border-color: var(--primary);
        transform: translateY(-2px);
    }

    .log-card-header {
        padding: 20px;
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
        gap: 12px;
        margin-bottom: 12px;
    }

    .status-badge-large {
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-draft {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #334155;
    }

    .status-layak {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    /* TAMBAHAN CSS UNTUK MENUNGGU VERIFIKASI (WARNING/ORANGE) */
    .status-verif {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
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
        gap: 20px;
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
        margin-top: 15px;
    }

    .info-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .badge-change {
        background: #fef3c7;
        color: #92400e;
        border: 2px solid #fbbf24;
    }

    .badge-content-edit {
        background: #e0e7ff;
        color: #3730a3;
        border: 2px solid #818cf8;
    }

    /* Detail Section */
    .log-detail {
        padding: 25px;
        background: white;
    }

    .detail-section {
        margin-bottom: 25px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--gray-200);
    }

    .section-title i {
        color: var(--primary);
        font-size: 1.3rem;
    }

    /* Change Items */
    .change-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .change-item {
        background: #fffbeb;
        border: 2px solid #fbbf24;
        border-radius: 10px;
        padding: 15px;
    }

    .change-field {
        font-weight: 700;
        color: #92400e;
        font-size: 0.9rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .change-comparison {
        display: grid;
        gap: 12px;
    }

    .value-box {
        padding: 12px;
        border-radius: 8px;
        font-size: 0.9rem;
        position: relative;
        padding-left: 45px;
    }

    .value-box::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .value-old {
        background: #fee2e2;
        border-left: 4px solid #dc2626;
    }

    .value-old::before {
        content: '✕';
        background: #dc2626;
        color: white;
        font-size: 0.7rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .value-new {
        background: #dcfce7;
        border-left: 4px solid #16a34a;
    }

    .value-new::before {
        content: '✓';
        background: #16a34a;
        color: white;
        font-size: 0.7rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .value-label {
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 5px;
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
        border-radius: 10px;
        padding: 15px;
    }

    .snapshot-label {
        font-weight: 700;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 8px;
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
        min-height: 40px;
    }

    .snapshot-value.large {
        max-height: 250px;
        overflow-y: auto;
    }

    .snapshot-image {
        max-width: 100%;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 5rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-state h5 {
        font-weight: 700;
        color: #64748b;
        margin-bottom: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .timeline-item {
            padding-left: 50px;
        }

        .timeline-dot {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .timeline-line {
            left: 17px;
        }

        .log-meta {
            flex-direction: column;
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
            <p class="mb-0">Lihat semua perubahan yang terjadi pada berita ini dari waktu ke waktu</p>
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
            <small class="text-muted">Klik pada setiap kartu untuk melihat detail perubahan</small>
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
                    
                    // Tentukan label & class (DEFAULT = DRAFT)
                    $statusText = 'Draft';
                    $statusClass = 'status-draft';
                    $dotClass = 'dot-draft';
                    $iconStatus = 'bi-file-earmark-text';
                    
                    // LOGIKA UNTUK MENENTUKAN TAMPILAN BERDASARKAN STATUS
                    if ($currentStatusBerita == '4') {
                        // Jika Status 4 = Layak Tayang
                        $statusText = 'Layak Tayang';
                        $statusClass = 'status-layak';
                        $dotClass = 'dot-layak';
                        $iconStatus = 'bi-check-circle-fill';
                    } elseif ($currentStatusBerita == '2') {
                        // Jika Status 2 = Menunggu Verifikasi
                        $statusText = 'Menunggu Verifikasi';
                        $statusClass = 'status-verif';
                        $dotClass = 'dot-verif';
                        $iconStatus = 'bi-hourglass-split'; // Icon Jam Pasir
                    }
                ?>
                <div class="timeline-item">
                    <div class="timeline-dot <?= $dotClass ?>">
                        <i class="<?= $iconStatus ?>"></i>
                    </div>
                    <div class="timeline-line"></div>

                    <div class="log-card" 
                         data-bs-toggle="collapse" 
                         data-bs-target="#detail<?= $index ?>"
                         aria-expanded="false">
                        
                        <div class="log-card-header">
                            <div class="status-main">
                                <span class="status-badge-large <?= $statusClass ?>">
                                    <i class="<?= $iconStatus ?>"></i>
                                    <?= $statusText ?>
                                </span>
                                <span class="collapse-hint">
                                    Lihat Detail
                                    <i class="bi bi-chevron-down collapse-icon"></i>
                                </span>
                            </div>

                            <div class="log-meta">
                                <div class="meta-item">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Diubah oleh: <strong><?= esc($log['full_name']) ?></strong></span>
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
                                            // Helper function/logic untuk label perubahan status
                                            $getLabel = function($code) {
                                                if ($code == '4') return 'Layak Tayang';
                                                if ($code == '2') return 'Menunggu Verifikasi';
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
                                            Ada <?= count($changes) ?> bagian yang diubah
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
                                                            <span class="value-label label-old">Sebelum Diubah:</span>
                                                            <div><?= nl2br(esc(substr($change['old'], 0, 200))) ?><?= strlen($change['old']) > 200 ? '...' : '' ?></div>
                                                        </div>
                                                        <div class="value-box value-new">
                                                            <span class="value-label label-new">Setelah Diubah:</span>
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
                                        <span>Isi Lengkap Berita Saat Ini</span>
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
                                                <i class="bi bi-tags"></i>
                                                Topik
                                            </div>
                                            <div class="snapshot-value">
                                                <?= esc($data['topik'] ?? '-') ?>
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

                                        <div class="snapshot-item">
                                            <div class="snapshot-label">
                                                <i class="bi bi-file-earmark-text"></i>
                                                Isi Berita Lengkap
                                            </div>
                                            <div class="snapshot-value large">
                                                <?= $data['content'] ?? '-' ?>
                                            </div>
                                        </div>

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

                                        <?php if (!empty($log['note_perbaikan']) || !empty($log['note_revisi'])): ?>
                                            <div class="row">
                                                <?php if (!empty($log['note_perbaikan'])): ?>
                                                    <div class="col-md-6">
                                                        <div class="snapshot-item">
                                                            <div class="snapshot-label">
                                                                <i class="bi bi-chat-left-text"></i>
                                                                Catatan dari Admin
                                                            </div>
                                                            <div class="snapshot-value">
                                                                <?= nl2br(esc($log['note_perbaikan'])) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($log['note_revisi'])): ?>
                                                    <div class="col-md-6">
                                                        <div class="snapshot-item" style="border-color: var(--primary);">
                                                            <div class="snapshot-label text-primary">
                                                                <i class="bi bi-exclamation-circle"></i>
                                                                Catatan Revisi
                                                            </div>
                                                            <div class="snapshot-value" style="background: #eff6ff;">
                                                                <?= nl2br(esc($log['note_revisi'])) ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

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
        const logCards = document.querySelectorAll('.log-card');
        
        logCards.forEach(card => {
            card.addEventListener('click', function(e) {
                // Jangan toggle jika klik di dalam detail
                if (e.target.closest('.log-detail')) return;
                
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
            });
        });
    });
</script>
<?= $this->endSection() ?>