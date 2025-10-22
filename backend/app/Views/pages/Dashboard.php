<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
    <style>
        .stats-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .stats-card .card-body {
            padding: 20px;
        }
        .stats-card h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-top: 10px;
        }
        .stats-card .card-title {
            font-size: 0.95rem;
            font-weight: 600;
        }
        .page-header {
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .info-alert {
            border-left: 4px solid #0dcaf0;
            background-color: #cff4fc;
            border-radius: 8px;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="page-header">
    <h2 class="mb-2">Dashboard</h2>
    <p class="text-muted mb-0">
        Selamat datang, <strong><?= esc(session()->get('full_name')) ?></strong>! 
        <span class="badge bg-primary ms-2"><?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?></span>
    </p>
</div>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-newspaper"></i> Total Berita
                        </h5>
                        <h2>245</h2>
                        <small>Berita dipublikasikan</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-calendar-event"></i> Agenda
                        </h5>
                        <h2>18</h2>
                        <small>Kegiatan mendatang</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-white bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-images"></i> Foto
                        </h5>
                        <h2>532</h2>
                        <small>Total foto galeri</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-file-earmark"></i> Dokumen
                        </h5>
                        <h2>89</h2>
                        <small>Dokumen tersedia</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Info Alert -->
        <div class="alert info-alert">
            <i class="bi bi-info-circle"></i> <strong>Informasi:</strong> 
            Menu yang ditampilkan disesuaikan dengan hak akses role Anda. 
            Role saat ini: <strong><?= ucfirst(str_replace('_', ' ', session()->get('role'))) ?></strong>
        </div>

        <!-- Role-based Menu Structure Table -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-table"></i> Struktur Menu Berdasarkan Role
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="40%">Menu</th>
                                <th class="text-center">Super Admin</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Editor</th>
                                <th class="text-center">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-speedometer2"></i> Dashboard</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-newspaper"></i> Manajemen Berita</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                            </tr>
                            <tr>
                                <td class="ps-4">└ Kategori/Tema/Tag Berita</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar-event"></i> Agenda & Galeri</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-file-earmark-text"></i> Dokumen</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-gear"></i> Layanan & Menu</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-people"></i> Pengguna & Akses</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-file-earmark-text"></i> Artikel Saya</td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-sliders"></i> Pengaturan</td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                                <td class="text-center"><i class="bi bi-x-circle-fill text-danger fs-5"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history"></i> Aktivitas Terakhir
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-plus-circle text-success fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">Berita baru ditambahkan</div>
                            <small class="text-muted">5 menit yang lalu</small>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-pencil-square text-primary fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">Agenda diperbarui</div>
                            <small class="text-muted">1 jam yang lalu</small>
                        </div>
                    </div>
                    <div class="list-group-item d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-upload text-info fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">Dokumen baru diunggah</div>
                            <small class="text-muted">3 jam yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>