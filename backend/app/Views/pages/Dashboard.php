<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    /* Mengambil Font Inter agar sama dengan Sidebar */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    :root {
        /* Variabel diambil dari Sidebar.php untuk konsistensi */
        --primary: #3b82f6;
        --primary-soft: #eff6ff;
        --secondary: #64748b;
        --text-main: #1e293b;
        --text-muted: #94a3b8;
        --bg-body: #f8fafc; /* Warna background halaman */
        --card-bg: #ffffff;
        --border: #e2e8f0;
        --success: #10b981;
        --success-soft: #d1fae5;
        --warning: #f59e0b;
        --warning-soft: #fef3c7;
        --danger: #ef4444;
        --danger-soft: #fee2e2;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-body);
        color: var(--text-main);
        font-size: 0.925rem;
    }

    .dashboard-wrapper {
        padding: 2rem;
        max-width: 1600px;
        margin: 0 auto;
    }

    /* --- HEADER SECTION --- */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .header-title h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.5px;
    }

    .header-title p {
        color: var(--secondary);
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .user-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--card-bg);
        padding: 8px 16px;
        border-radius: 50px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }

    .role-tag {
        background: var(--primary-soft);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* --- CARDS & STATS --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Gaya Icon mirip Sidebar */
    .card-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .card-title {
        color: var(--secondary);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .card-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .card-footer {
        font-size: 0.8rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Warna Spesifik per Card */
    .card-blue .card-icon-wrapper { background: var(--primary-soft); color: var(--primary); }
    .card-green .card-icon-wrapper { background: var(--success-soft); color: var(--success); }
    .card-orange .card-icon-wrapper { background: var(--warning-soft); color: var(--warning); }
    .card-red .card-icon-wrapper { background: var(--danger-soft); color: var(--danger); }

    /* --- INFO PANEL --- */
    .system-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-item h4 { font-size: 0.8rem; color: var(--secondary); margin-bottom: 4px; font-weight: 500;}
    .info-item div { font-size: 0.95rem; font-weight: 600; color: var(--text-main); display: flex; align-items: center; gap: 8px;}

    /* --- TABLE STYLING --- */
    .table-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
    }

    .card-header h3 { font-size: 1rem; font-weight: 600; color: var(--text-main); }
    .card-header span { font-size: 0.8rem; color: var(--secondary); }

    .custom-table { width: 100%; border-collapse: collapse; }
    
    .custom-table th {
        background: var(--bg-body);
        color: var(--secondary);
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }

    .custom-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        color: var(--text-main);
        font-size: 0.9rem;
    }
    
    .custom-table tr:last-child td { border-bottom: none; }
    .custom-table tr:hover { background-color: #f8fafc; }

    /* Status Icons in Table */
    .status-check { color: var(--success); font-size: 1.1rem; }
    .status-x { color: var(--border); font-size: 1.1rem; }

    /* --- ACTIVITY LIST --- */
    .activity-list { list-style: none; }
    .activity-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }
    .activity-item:last-child { border-bottom: none; }

    .activity-icon-box {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--bg-body);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        color: var(--secondary);
        font-size: 0.9rem;
    }

    .activity-details h5 { font-size: 0.9rem; font-weight: 600; margin-bottom: 2px; color: var(--text-main); }
    .activity-meta { font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }

    /* --- BADGES --- */
    .badge { padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
    .badge-success { background: var(--success-soft); color: var(--success); }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-wrapper { padding: 1rem; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        .system-info-grid { grid-template-columns: 1fr; }
        .custom-table { display: block; overflow-x: auto; white-space: nowrap; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-wrapper">
    
    <div class="page-header">
        <div class="header-title">
            <h1>Dashboard Administrasi</h1>
            <p>Selamat datang kembali, pantau kinerja sistem hari ini.</p>
        </div>
        <div class="user-badge">
            <div style="display: flex; flex-direction: column; align-items: flex-end;">
                <span style="font-weight: 600; font-size: 0.9rem;"><?= esc(session()->get('full_name')) ?></span>
                <span class="role-tag"><?= strtoupper(str_replace('_', ' ', session()->get('role'))) ?></span>
            </div>
            <div style="width: 38px; height: 38px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                <i class="bi bi-person-fill"></i>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="card card-blue">
            <div class="card-icon-wrapper">
                <i class="bi bi-newspaper"></i>
            </div>
            <div class="card-title">Total Berita</div>
            <div class="card-value"><?= $total_berita ?></div>
            <div class="card-footer">
                <span class="badge badge-success"><i class="bi bi-arrow-up"></i> <?= $publish_berita ?> Terbit</span>
                <span style="margin-left: auto;">Draft: <?= $draft_berita ?></span>
            </div>
        </div>

        <div class="card card-green">
            <div class="card-icon-wrapper">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="card-title">Agenda Kegiatan</div>
            <div class="card-value"><?= $agenda_total ?></div>
            <div class="card-footer">
                <span><?= $agenda_upcoming ?> akan datang</span>
                <span style="margin-left: auto; color: var(--success); font-weight: 600;">Active</span>
            </div>
        </div>

        <div class="card card-orange">
            <div class="card-icon-wrapper">
                <i class="bi bi-images"></i>
            </div>
            <div class="card-title">Galeri Foto</div>
            <div class="card-value"><?= $gallery_total ?></div>
            <div class="card-footer">
                <span>Total album foto tersimpan</span>
            </div>
        </div>

        <div class="card card-red">
            <div class="card-icon-wrapper">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="card-title">Dokumen</div>
            <div class="card-value"><?= $document_total ?></div>
            <div class="card-footer">
                <span>+<?= $document_new ?> bulan ini</span>
            </div>
        </div>
    </div>

    <div class="system-info-grid">
        <div class="info-item">
            <h4>Status Server</h4>
            <div style="color: var(--success);">
                <i class="bi bi-hdd-network-fill"></i> Online / Stable
            </div>
        </div>
        <div class="info-item">
            <h4>Penyimpanan</h4>
            <div style="color: var(--primary);">
                <i class="bi bi-pie-chart-fill"></i> 2.4 GB / 10 GB
            </div>
        </div>
        <div class="info-item">
            <h4>Terakhir Backup</h4>
            <div style="color: var(--secondary);">
                <i class="bi bi-clock-history"></i> 2024-03-15 03:00
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        
        <div class="table-card">
            <div class="card-header">
                <h3>Hak Akses Role</h3>
                <span>Role: <strong style="color: var(--primary);"><?= ucfirst($user_role) ?></strong></span>
            </div>
            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th class="text-center">Create</th>
                            <th class="text-center">Read</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                            <th class="text-center">Publish</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($access_rights)): ?>
                            <tr><td colspan="6" class="text-center">Tidak ada data akses.</td></tr>
                        <?php else: ?>
                            <?php foreach ($access_rights as $access): ?>
                                <tr>
                                    <td><strong><?= esc($access['module_name']) ?></strong></td>
                                    <td style="text-align: center;">
                                        <i class="bi <?= $access['can_create'] ? 'bi-check-circle-fill status-check' : 'bi-dash-circle status-x' ?>"></i>
                                    </td>
                                    <td style="text-align: center;">
                                        <i class="bi <?= $access['can_read'] ? 'bi-check-circle-fill status-check' : 'bi-dash-circle status-x' ?>"></i>
                                    </td>
                                    <td style="text-align: center;">
                                        <i class="bi <?= $access['can_update'] ? 'bi-check-circle-fill status-check' : 'bi-dash-circle status-x' ?>"></i>
                                    </td>
                                    <td style="text-align: center;">
                                        <i class="bi <?= $access['can_delete'] ? 'bi-check-circle-fill status-check' : 'bi-dash-circle status-x' ?>"></i>
                                    </td>
                                    <td style="text-align: center;">
                                        <i class="bi <?= $access['can_publish'] ? 'bi-check-circle-fill status-check' : 'bi-dash-circle status-x' ?>"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-card" style="height: fit-content;">
            <div class="card-header">
                <h3>Aktivitas Terakhir</h3>
                <a href="#" style="font-size: 0.8rem; color: var(--primary); text-decoration: none;">Lihat Semua</a>
            </div>
            <div class="activity-list">
                <?php if (!empty($last_logs)): ?>
                    <?php foreach ($last_logs as $log): ?>
                        <div class="activity-item">
                            <div class="activity-icon-box">
                                <?php
                                $keterangan = strtolower($log['keterangan'] ?? '');
                                if (strpos($keterangan, 'tambah') !== false || strpos($keterangan, 'create') !== false) {
                                    echo '<i class="bi bi-plus-lg" style="color: var(--success);"></i>';
                                } elseif (strpos($keterangan, 'edit') !== false || strpos($keterangan, 'update') !== false) {
                                    echo '<i class="bi bi-pencil-fill" style="color: var(--warning);"></i>';
                                } elseif (strpos($keterangan, 'hapus') !== false || strpos($keterangan, 'delete') !== false) {
                                    echo '<i class="bi bi-trash-fill" style="color: var(--danger);"></i>';
                                } else {
                                    echo '<i class="bi bi-clock"></i>';
                                }
                                ?>
                            </div>
                            <div class="activity-details">
                                <h5><?= esc($log['keterangan']) ?></h5>
                                <div class="activity-meta">
                                    <span><?= date('d M H:i', strtotime($log['created_date'])) ?></span>
                                    <span>•</span>
                                    <span><?= esc($log['username'] ?? 'System') ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                        Belum ada aktivitas.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    
    <div style="text-align: center; margin-top: 2rem; color: var(--text-muted); font-size: 0.8rem;">
        &copy; <?= date('Y') ?> Government Administration System. All rights reserved.
    </div>

</div>
<?= $this->endSection() ?>