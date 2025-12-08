<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    /* Base Styles - No Animation, Maximum Performance */
    :root {
        --primary: #0D47A1;
        --primary-light: #E3F2FD;
        --secondary: #1565C0;
        --success: #2E7D32;
        --warning: #F57C00;
        --danger: #C62828;
        --gray-50: #FAFAFA;
        --gray-100: #F5F5F5;
        --gray-200: #EEEEEE;
        --gray-300: #E0E0E0;
        --gray-700: #616161;
        --gray-900: #212121;
    }

    /* Reset untuk performance */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Base Layout - Simple and Fast */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        line-height: 1.4;
        background-color: var(--gray-100);
        color: var(--gray-900);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 16px;
    }

    /* Header - Simple and Clean */
    .simple-header {
        background: white;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
    }

    .simple-header h1 {
        font-size: 20px;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 4px;
    }

    .simple-header .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 8px;
    }

    .user-role {
        background: var(--primary-light);
        color: var(--primary);
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid #BBDEFB;
    }

    /* Stats Grid - Simple Boxes */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-box {
        background: white;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 20px;
        position: relative;
    }

    .stat-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--primary);
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: var(--gray-900);
        line-height: 1;
        margin: 8px 0;
    }

    .stat-label {
        font-size: 13px;
        color: var(--gray-700);
        font-weight: 500;
    }

    .stat-subtext {
        font-size: 12px;
        color: var(--gray-700);
        margin-top: 4px;
    }

    /* Simple Icon - No Animation */
    .stat-icon {
        width: 40px;
        height: 40px;
        background: var(--gray-100);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--primary);
        margin-bottom: 12px;
    }

    /* Quick Info Panel */
    .info-panel {
        background: white;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .info-panel h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--gray-200);
    }

    /* Simple Table - No Complex Styling */
    .simple-table-container {
        background: white;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .table-header {
        background: var(--gray-50);
        padding: 16px;
        border-bottom: 1px solid var(--gray-300);
    }

    .table-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--gray-900);
    }

    .simple-table {
        width: 100%;
        border-collapse: collapse;
    }

    .simple-table th {
        background: var(--gray-100);
        padding: 12px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-300);
    }

    .simple-table td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--gray-200);
        font-size: 14px;
        color: var(--gray-900);
    }

    .simple-table tr:last-child td {
        border-bottom: none;
    }

    /* Simple Check/X Icons */
    .check-icon {
        color: var(--success);
        font-weight: bold;
    }

    .x-icon {
        color: var(--gray-300);
        font-weight: bold;
    }

    /* Activity List - Simple */
    .activity-list {
        background: white;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
    }

    .activity-item {
        padding: 16px;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        background: var(--gray-100);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: var(--primary);
        flex-shrink: 0;
    }

    .activity-content {
        flex-grow: 1;
    }

    .activity-title {
        font-weight: 500;
        color: var(--gray-900);
        margin-bottom: 2px;
    }

    .activity-time {
        font-size: 12px;
        color: var(--gray-700);
    }

    /* Utility Classes */
    .text-primary {
        color: var(--primary);
    }

    .text-success {
        color: var(--success);
    }

    .text-warning {
        color: var(--warning);
    }

    .mb-16 {
        margin-bottom: 16px;
    }

    .mb-24 {
        margin-bottom: 24px;
    }

    /* Simple Status Badges */
    .status-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
    }

    .status-active {
        background: #E8F5E9;
        color: var(--success);
        border: 1px solid #C8E6C9;
    }

    .status-pending {
        background: #FFF3E0;
        color: var(--warning);
        border: 1px solid #FFE0B2;
    }

    /* No Hover Effects for Low-end Devices */
    @media (hover: hover) {
        /* Only apply hover effects on devices that support it */
        .stat-box:hover {
            border-color: var(--primary);
        }
        
        .activity-item:hover {
            background: var(--gray-50);
        }
        
        .simple-table tr:hover {
            background: var(--gray-50);
        }
    }

    /* Mobile Responsive - Simple */
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 12px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .simple-table {
            display: block;
            overflow-x: auto;
        }
        
        .stat-number {
            font-size: 28px;
        }
    }

    /* Very Low-end Device Optimization */
    @media (max-width: 480px) {
        body {
            font-size: 13px;
        }
        
        .dashboard-wrapper {
            padding: 8px;
        }
        
        .simple-header,
        .stat-box,
        .info-panel,
        .simple-table-container,
        .activity-list {
            padding: 12px;
        }
        
        .stat-number {
            font-size: 24px;
        }
    }

    /* Print Styles */
    @media print {
        body {
            background: white;
        }
        
        .dashboard-wrapper {
            max-width: 100%;
            padding: 0;
        }
        
        .simple-header,
        .stat-box,
        .info-panel,
        .simple-table-container,
        .activity-list {
            border: 1px solid #000;
            box-shadow: none;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-wrapper">
    <!-- Simple Header -->
    <div class="simple-header">
        <h1>Dashboard Administrasi</h1>
        <p style="color: var(--gray-700); margin-bottom: 8px;">
            Portal Manajemen Konten Pemerintahan
        </p>
        <div class="user-info">
            <span style="color: var(--gray-900); font-weight: 500;">
                <?= esc(session()->get('full_name')) ?>
            </span>
            <span class="user-role">
                <?= strtoupper(str_replace('_', ' ', session()->get('role'))) ?>
            </span>
        </div>
    </div>

    <!-- Simple Stats Grid -->
    <div class="stats-grid mb-24">
        <div class="stat-box">
            <div class="stat-icon">
                <i class="bi bi-newspaper"></i>
            </div>
            <div class="stat-number">245</div>
            <div class="stat-label">Total Berita</div>
            <div class="stat-subtext">Terbit: 215 | Draft: 30</div>
            <div class="status-badge status-active" style="margin-top: 8px;">
                <i class="bi bi-check-circle" style="margin-right: 4px;"></i>
                Sistem Aktif
            </div>
        </div>

        <div class="stat-box">
            <div class="stat-icon">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-number">18</div>
            <div class="stat-label">Agenda Kegiatan</div>
            <div class="stat-subtext">Mendatang: 8 | Selesai: 10</div>
        </div>

        <div class="stat-box">
            <div class="stat-icon">
                <i class="bi bi-folder"></i>
            </div>
            <div class="stat-number">532</div>
            <div class="stat-label">Galeri Foto</div>
            <div class="stat-subtext">Publik: 489 | Private: 43</div>
        </div>

        <div class="stat-box">
            <div class="stat-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="stat-number">89</div>
            <div class="stat-label">Dokumen</div>
            <div class="stat-subtext">Terbaru: 12 bulan ini</div>
        </div>
    </div>

    <!-- Simple Info Panel -->
    <div class="info-panel mb-24">
        <h3>Informasi Sistem</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
            <div>
                <div style="font-weight: 500; color: var(--gray-900); margin-bottom: 4px;">
                    Status Server
                </div>
                <div style="color: var(--success); font-weight: 500;">
                    <i class="bi bi-check-circle-fill" style="margin-right: 6px;"></i>
                    Online
                </div>
            </div>
            <div>
                <div style="font-weight: 500; color: var(--gray-900); margin-bottom: 4px;">
                    Last Backup
                </div>
                <div style="color: var(--gray-700);">
                    2024-03-15 03:00
                </div>
            </div>
            <div>
                <div style="font-weight: 500; color: var(--gray-900); margin-bottom: 4px;">
                    Storage Used
                </div>
                <div style="color: var(--gray-700);">
                    2.4 GB / 10 GB
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Access Table -->
    <div class="simple-table-container mb-24">
        <div class="table-header">
            <h3>Hak Akses Berdasarkan Role</h3>
            <p style="color: var(--gray-700); font-size: 13px; margin-top: 4px;">
                Role aktif: <strong class="text-primary"><?= ucfirst(session()->get('role')) ?></strong>
            </p>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="simple-table">
                <thead>
                    <tr>
                        <th>Modul & Menu</th>
                        <th style="text-align: center;">Super Admin</th>
                        <th style="text-align: center;">Admin</th>
                        <th style="text-align: center;">Editor</th>
                        <th style="text-align: center;">Viewer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Dashboard</strong></td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                    </tr>
                    <tr>
                        <td>Manajemen Berita</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 24px;">- Kategori Berita</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                    </tr>
                    <tr>
                        <td>Agenda & Galeri</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                    </tr>
                    <tr>
                        <td>Manajemen Dokumen</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                    </tr>
                    <tr>
                        <td>Pengaturan Sistem</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                    </tr>
                    <tr>
                        <td>Manajemen User</td>
                        <td style="text-align: center;" class="check-icon">✓</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                        <td style="text-align: center;" class="x-icon">✗</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Simple Activity List -->
    <div class="activity-list">
        <div class="table-header" style="border-bottom: 1px solid var(--gray-300);">
            <h3>Aktivitas Terakhir</h3>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">
                <i class="bi bi-plus-circle"></i>
            </div>
            <div class="activity-content">
                <div class="activity-title">Berita baru dipublikasikan</div>
                <div class="activity-time">5 menit yang lalu</div>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="activity-content">
                <div class="activity-title">Agenda kegiatan diperbarui</div>
                <div class="activity-time">1 jam yang lalu</div>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">
                <i class="bi bi-upload"></i>
            </div>
            <div class="activity-content">
                <div class="activity-title">Dokumen berhasil diunggah</div>
                <div class="activity-time">3 jam yang lalu</div>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="activity-content">
                <div class="activity-title">Backup sistem otomatis</div>
                <div class="activity-time">Kemarin, 03:00</div>
            </div>
        </div>
    </div>

    <!-- Simple Footer Info -->
    <div style="margin-top: 24px; padding: 16px; background: white; border: 1px solid var(--gray-300); border-radius: 8px; text-align: center;">
        <div style="color: var(--gray-700); font-size: 12px;">
            Sistem Dashboard v1.0 • Terakhir diperbarui: 15 Maret 2024
        </div>
        <div style="margin-top: 8px; color: var(--gray-700); font-size: 12px;">
            <span style="color: var(--success); font-weight: 500;">
                <i class="bi bi-check-circle-fill" style="margin-right: 4px;"></i>
                Semua sistem berjalan normal
            </span>
        </div>
    </div>
</div>

<!-- Zero JavaScript - Pure HTML/CSS Solution -->
<?= $this->endSection() ?>