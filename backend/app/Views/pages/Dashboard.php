<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>

    <style>
        :root {
            --primary-gov: #1e40af;
            --secondary-gov: #0c4a6e;
            --success-gov: #047857;
            --warning-gov: #b45309;
            --info-gov: #0369a1;
            --danger-gov: #be123c;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header Styles */
        .gov-header {
            background: linear-gradient(135deg, var(--primary-gov) 0%, var(--secondary-gov) 100%);
            color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(30, 64, 175, 0.15);
            margin-bottom: 30px;
            border-left: 6px solid #fbbf24;
        }

        .gov-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .gov-header .welcome-text {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-top: 8px;
        }

        .gov-badge {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Statistics Cards */
        .stats-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            height: 4px;
            background: linear-gradient(90deg, currentColor, transparent);
            opacity: 0.8;
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .stats-card .card-body {
            padding: 24px;
        }

        .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 16px;
        }

        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 12px 0 8px 0;
            background: linear-gradient(135deg, #1e293b 0%, #475569 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-card .card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0;
        }

        .stats-card .stats-subtitle {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 4px;
        }

        /* Card Color Variants */
        .card-primary .stats-icon { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: var(--primary-gov); }
        .card-success .stats-icon { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: var(--success-gov); }
        .card-warning .stats-icon { background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%); color: var(--warning-gov); }
        .card-info .stats-icon { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: var(--info-gov); }

        .card-primary::before { color: var(--primary-gov); }
        .card-success::before { color: var(--success-gov); }
        .card-warning::before { color: var(--warning-gov); }
        .card-info::before { color: var(--info-gov); }

        /* Alert Info */
        .gov-alert {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: none;
            border-left: 5px solid var(--primary-gov);
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 2px 8px rgba(30, 64, 175, 0.08);
        }

        .gov-alert i {
            font-size: 1.3rem;
            color: var(--primary-gov);
            margin-right: 8px;
        }

        /* Table Card */
        .table-card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: white;
        }

        .table-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 2px solid #e2e8f0;
            padding: 20px 24px;
        }

        .table-card .card-header h5 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            font-size: 1.15rem;
        }

        .table-card .card-header i {
            color: var(--primary-gov);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Custom Table */
        .gov-table {
            margin: 0;
        }

        .gov-table thead {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }

        .gov-table thead th {
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding: 16px 20px;
            border: none;
        }

        .gov-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .gov-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .gov-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .gov-table .menu-item {
            font-weight: 500;
            color: #1e293b;
        }

        .gov-table .menu-item i {
            color: var(--primary-gov);
            margin-right: 8px;
        }

        .gov-table .submenu-item {
            padding-left: 40px;
            font-size: 0.9rem;
            color: #64748b;
        }

        .check-icon {
            color: #059669;
            font-size: 1.4rem;
            filter: drop-shadow(0 2px 4px rgba(5, 150, 105, 0.2));
        }

        .cross-icon {
            color: #dc2626;
            font-size: 1.4rem;
            filter: drop-shadow(0 2px 4px rgba(220, 38, 38, 0.2));
        }

        /* Activity Card */
        .activity-item {
            padding: 18px 20px;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .activity-item:hover {
            background-color: #f8fafc;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .activity-icon.success { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #059669; }
        .activity-icon.primary { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #2563eb; }
        .activity-icon.info { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0284c7; }

        .activity-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }

        .activity-time {
            color: #94a3b8;
            font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .gov-header h1 {
                font-size: 1.5rem;
            }
            
            .stats-card h3 {
                font-size: 2rem;
            }

            .gov-table thead th,
            .gov-table tbody td {
                padding: 12px;
                font-size: 0.85rem;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-card {
            animation: fadeInUp 0.5s ease-out backwards;
        }

        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1>
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard Administrasi
            </h1>
            <p class="welcome-text mb-0">
                Selamat datang, <strong><?= esc(session()->get('full_name')) ?></strong>
            </p>
        </div>
        <div class="mt-3 mt-md-0">
            <span class="gov-badge">
                <i class="bi bi-shield-check me-1"></i>
                <?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?>
            </span>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
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