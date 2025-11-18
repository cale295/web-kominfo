<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --success: #059669;
        --warning: #d97706;
        --info: #0284c7;
        --danger: #dc2626;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    body {
        background-color: var(--gray-50);
    }

    /* Header Styles */
    .gov-header {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        border: 1px solid var(--gray-200);
        border-left: 4px solid var(--primary);
    }

    .gov-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .gov-header h1 i {
        color: var(--primary);
        margin-right: 10px;
    }

    .berita-title {
        font-size: 0.9375rem;
        color: var(--gray-600);
        margin-top: 8px;
        font-weight: 400;
    }

    .berita-title strong {
        color: var(--gray-900);
    }

    .action-buttons .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .action-buttons .btn-secondary {
        background: var(--gray-600);
        border: none;
    }

    .action-buttons .btn-secondary:hover {
        background: var(--gray-700);
        transform: translateY(-2px);
    }

    /* Table Card */
    .table-card {
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
    }

    /* Custom Table */
    .gov-table {
        margin: 0;
    }

    .gov-table thead {
        background: var(--gray-100);
    }

    .gov-table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .gov-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
    }

    .gov-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .gov-table tbody tr:hover {
        background-color: var(--gray-50);
    }

    /* Log Elements */
    .log-user {
        font-weight: 500;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .log-user i {
        color: var(--primary);
    }

    .log-keterangan {
        color: var(--gray-700);
        line-height: 1.5;
    }

    .log-status {
        padding: 4px 10px;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.75rem;
        display: inline-block;
        background-color: var(--info);
        color: white;
    }

    .log-note {
        color: var(--gray-600);
        font-size: 0.875rem;
        line-height: 1.4;
        max-width: 250px;
    }

    .log-note.empty {
        color: var(--gray-400);
        font-style: italic;
    }

    .log-time {
        color: var(--gray-600);
        font-size: 0.875rem;
        white-space: nowrap;
    }

    /* Empty State */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-500);
    }

    .no-data i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 16px;
    }

    /* Timeline Indicator */
    .timeline-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gov-header {
            padding: 20px;
        }
        
        .gov-header h1 {
            font-size: 1.375rem;
        }

        .gov-table thead th,
        .gov-table tbody td {
            padding: 10px 12px;
            font-size: 0.8125rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 8px;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-clock-history"></i>
                Riwayat Log Berita
            </h1>
            <div class="berita-title">
                <strong>Berita:</strong> <?= esc($berita['judul']) ?>
            </div>
        </div>
        <div class="action-buttons d-flex gap-2">
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Table Card -->
<div class="card table-card">
    <div class="card-body p-0">
        <?php if (!empty($logs)): ?>
            <div class="table-responsive">
                <table class="table gov-table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">#</th>
                            <th style="min-width: 150px;">User</th>
                            <th style="min-width: 200px;">Keterangan</th>
                            <th class="text-center" style="width: 120px;">Status</th>
                            <th style="min-width: 200px;">Note Perbaikan</th>
                            <th style="min-width: 200px;">Note Revisi</th>
                            <th class="text-center" style="width: 140px;">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $index => $log): ?>
                            <tr>
                                <td class="text-center">
                                    <div class="timeline-number"><?= $index + 1 ?></div>
                                </td>
                                <td>
                                    <div class="log-user">
                                        <i class="bi bi-person-circle"></i>
                                        <?= esc($log['user_name']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="log-keterangan">
                                        <?= esc($log['keterangan']) ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="log-status">
                                        <?= esc($log['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="log-note <?= empty($log['note_perbaikan']) ? 'empty' : '' ?>">
                                        <?= !empty($log['note_perbaikan']) ? esc($log['note_perbaikan']) : '-' ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="log-note <?= empty($log['note_revisi']) ? 'empty' : '' ?>">
                                        <?= !empty($log['note_revisi']) ? esc($log['note_revisi']) : '-' ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="log-time">
                                        <i class="bi bi-calendar3"></i>
                                        <?= date('d M Y', strtotime($log['created_date'])) ?>
                                        <br>
                                        <i class="bi bi-clock"></i>
                                        <?= date('H:i', strtotime($log['created_date'])) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-data">
                <i class="bi bi-clock-history"></i>
                <p class="mb-0">Belum ada log untuk berita ini</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>