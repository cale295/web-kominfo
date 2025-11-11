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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
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

        .gov-header .welcome-text {
            font-size: 0.9375rem;
            color: var(--gray-600);
            margin-top: 6px;
        }

        .gov-badge {
            background: var(--gray-100);
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            border: 1px solid var(--gray-200);
            color: var(--primary);
        }

        .gov-badge i {
            color: var(--primary);
            margin-right: 4px;
        }

        /* Statistics Cards */
        .stats-card {
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            background: white;
            overflow: hidden;
            position: relative;
            height: 100%;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: currentColor;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-card .card-body {
            padding: 20px;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 12px;
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 8px 0;
            color: var(--gray-900);
        }

        .stats-card .card-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0;
        }

        .stats-card .stats-subtitle {
            font-size: 0.8125rem;
            color: var(--gray-500);
            margin-top: 4px;
        }

        /* Card Color Variants */
        .card-primary .stats-icon { background: #eff6ff; color: var(--primary); }
        .card-success .stats-icon { background: #f0fdf4; color: var(--success); }
        .card-warning .stats-icon { background: #fef3c7; color: var(--warning); }
        .card-info .stats-icon { background: #f0f9ff; color: var(--info); }

        .card-primary::before { color: var(--primary); }
        .card-success::before { color: var(--success); }
        .card-warning::before { color: var(--warning); }
        .card-info::before { color: var(--info); }

        /* Alert Info */
        .gov-alert {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-left: 4px solid var(--primary);
            border-radius: 8px;
            padding: 16px 20px;
        }

        .gov-alert i {
            font-size: 1.125rem;
            color: var(--primary);
            margin-right: 8px;
        }

        .gov-alert strong {
            color: var(--gray-900);
        }

        /* Table Card */
        .table-card {
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
        }

        .table-card .card-header {
            background: var(--gray-50);
            border-bottom: 1px solid var(--gray-200);
            padding: 16px 20px;
        }

        .table-card .card-header h5 {
            font-weight: 600;
            color: var(--gray-900);
            margin: 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .table-card .card-header i {
            color: var(--primary);
            margin-right: 10px;
            font-size: 1.125rem;
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
            padding: 12px 16px;
            border: none;
            border-bottom: 2px solid var(--gray-200);
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

        .gov-table .menu-item {
            font-weight: 500;
            color: var(--gray-900);
        }

        .gov-table .menu-item i {
            color: var(--primary);
            margin-right: 8px;
        }

        .gov-table .submenu-item {
            padding-left: 40px;
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .check-icon {
            color: var(--success);
            font-size: 1.25rem;
        }

        .cross-icon {
            color: var(--gray-300);
            font-size: 1.25rem;
        }

        /* Activity Card */
        .activity-item {
            padding: 16px 20px;
            border: none;
            border-bottom: 1px solid var(--gray-100);
            transition: background-color 0.2s ease;
        }

        .activity-item:hover {
            background-color: var(--gray-50);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .activity-icon.success { background: #f0fdf4; color: var(--success); }
        .activity-icon.primary { background: #eff6ff; color: var(--primary); }
        .activity-icon.info { background: #f0f9ff; color: var(--info); }

        .activity-title {
            font-weight: 500;
            color: var(--gray-900);
            margin-bottom: 4px;
            font-size: 0.875rem;
        }

        .activity-time {
            color: var(--gray-500);
            font-size: 0.8125rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .gov-header h1 {
                font-size: 1.375rem;
            }
            
            .stats-card h3 {
                font-size: 1.75rem;
            }

            .gov-table thead th,
            .gov-table tbody td {
                padding: 10px 12px;
                font-size: 0.8125rem;
            }

            .gov-header {
                padding: 20px;
            }

            .table-card .card-header {
                padding: 14px 16px;
            }
        }

        /* Remove excessive animations */
        .stats-card {
            animation: none;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-speedometer2"></i>
                Dashboard Administrasi
            </h1>
            <p class="welcome-text mb-0">
                Selamat datang, <strong><?= esc(session()->get('full_name')) ?></strong>
            </p>
        </div>
        <div>
            <span class="gov-badge">
                <i class="bi bi-shield-lock"></i>
                <?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?>
            </span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card card-primary">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="bi bi-newspaper"></i>
                </div>
                <h6 class="card-title">Total Berita</h6>
                <h3>245</h3>
                <p class="stats-subtitle mb-0">Berita dipublikasikan</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card card-success">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <h6 class="card-title">Agenda Kegiatan</h6>
                <h3>18</h3>
                <p class="stats-subtitle mb-0">Kegiatan mendatang</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card card-warning">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="bi bi-images"></i>
                </div>
                <h6 class="card-title">Galeri Foto</h6>
                <h3>532</h3>
                <p class="stats-subtitle mb-0">Total foto tersimpan</p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card stats-card card-info">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h6 class="card-title">Dokumen</h6>
                <h3>89</h3>
                <p class="stats-subtitle mb-0">Dokumen tersedia</p>
            </div>
        </div>
    </div>
</div>

<!-- Info Alert -->
<div class="gov-alert mb-4">
    <div class="d-flex align-items-start">
        <i class="bi bi-info-circle-fill flex-shrink-0"></i>
        <div>
            <strong>Informasi Penting:</strong> 
            Menu yang ditampilkan disesuaikan dengan hak akses role Anda. 
            Role aktif saat ini: <strong><?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?></strong>
        </div>
    </div>
</div>

<!-- Role-based Menu Structure Table -->
<div class="card table-card mb-4">
    <div class="card-header">
        <h5>
            <i class="bi bi-diagram-3"></i>
            Struktur Hak Akses Berdasarkan Role
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table gov-table mb-0">
                <thead>
                    <tr>
                        <th width="40%">Modul & Menu</th>
                        <th class="text-center">Super Admin</th>
                        <th class="text-center">Admin</th>
                        <th class="text-center">Editor</th>
                        <th class="text-center">User</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-newspaper"></i> Manajemen Berita
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="submenu-item">
                            <i class="bi bi-arrow-return-right"></i> Kategori/Tema/Tag Berita
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-calendar-event"></i> Agenda & Galeri
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-file-earmark-text"></i> Manajemen Dokumen
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-gear-fill"></i> Layanan & Menu
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-people-fill"></i> Pengguna & Akses
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-file-earmark-person"></i> Artikel Saya
                        </td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="menu-item">
                            <i class="bi bi-sliders"></i> Pengaturan Sistem
                        </td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-check-circle-fill check-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                        <td class="text-center"><i class="bi bi-x-circle-fill cross-icon"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card table-card">
    <div class="card-header">
        <h5>
            <i class="bi bi-clock-history"></i>
            Aktivitas Terakhir
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <div class="list-group-item activity-item d-flex align-items-center">
                <div class="activity-icon success me-3">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="activity-title">Berita baru berhasil dipublikasikan</div>
                    <div class="activity-time">5 menit yang lalu</div>
                </div>
            </div>
            <div class="list-group-item activity-item d-flex align-items-center">
                <div class="activity-icon primary me-3">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="activity-title">Agenda kegiatan diperbarui</div>
                    <div class="activity-time">1 jam yang lalu</div>
                </div>
            </div>
            <div class="list-group-item activity-item d-flex align-items-center">
                <div class="activity-icon info me-3">
                    <i class="bi bi-cloud-upload"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="activity-title">Dokumen resmi berhasil diunggah</div>
                    <div class="activity-time">3 jam yang lalu</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>