<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary-blue: #1e40af;
        --secondary-blue: #1e3a8a;
        --accent-gold: #fbbf24;
        --light-gold: #fcd34d;
    }

    .page-header {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 8px 24px rgba(100, 116, 139, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header h3 {
        color: white;
        font-weight: 700;
        font-size: 1.8rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .page-header h3 i {
        color: #fca5a5;
        font-size: 2rem;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 12px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 1;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateX(-4px);
    }

    .btn-back i {
        font-size: 1.1rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: none;
        border-left: 4px solid #16a34a;
        border-radius: 12px;
        padding: 16px 20px;
        color: #166534;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);
        animation: slideInDown 0.4s ease-out;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: none;
        border-left: 4px solid #f59e0b;
        border-radius: 12px;
        padding: 20px;
        color: #92400e;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.1);
        text-align: center;
    }

    .alert-warning i {
        font-size: 3rem;
        color: #f59e0b;
        display: block;
        margin-bottom: 12px;
    }

    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-body {
        padding: 0;
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        margin: 0;
    }

    .table thead {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    }

    .table thead th {
        color: black;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 18px 16px;
        border: none;
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, rgba(100, 116, 139, 0.03) 0%, rgba(239, 68, 68, 0.03) 100%);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table-number {
        font-weight: 600;
        color: #94a3b8;
        background: rgba(148, 163, 184, 0.1);
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .banner-title {
        font-weight: 600;
        color: #64748b;
        font-size: 0.95rem;
        text-decoration: line-through;
        opacity: 0.8;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%) !important;
        color: var(--primary-blue) !important;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .user-info {
        font-size: 0.85rem;
    }

    .user-name {
        font-weight: 600;
        color: #64748b;
    }

    .user-date {
        color: #94a3b8;
        font-size: 0.75rem;
    }

    .btn-action {
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-restore {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-restore:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: white;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .btn-permanent-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-permanent-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
    }

    .empty-state {
        padding: 80px 20px;
        text-align: center;
    }

    .empty-state i {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h5 {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 0.95rem;
        margin: 0;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 24px;
        }

        .page-header h3 {
            font-size: 1.4rem;
        }

        .btn-back {
            padding: 10px 18px;
            font-size: 0.9rem;
        }

        .table thead th {
            font-size: 0.75rem;
            padding: 14px 12px;
        }

        .table tbody td {
            padding: 12px;
            font-size: 0.85rem;
        }

        .btn-action {
            padding: 6px 10px;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h3>
                <i class="bi bi-trash3"></i>
                Sampah Banner
            </h3>
            <a href="<?= site_url('banner') ?>" class="btn btn-back">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success d-flex align-items-center mb-4">
            <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php endif; ?>

    <?= $this->include('layouts/alerts') ?>

    <!-- Table Card -->
    <?php if (!empty($banners)): ?>
        <div class="card">
            <div class="card-body">
                <div class="table-container">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="min-width: 200px;">Judul Banner</th>
                                <th style="width: 150px;">Kategori</th>
                                <th style="min-width: 150px;">Dihapus Oleh</th>
                                <th style="min-width: 150px;">Tanggal Hapus</th>
                                <th style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1; 
                            $kategori = [
                                1 => ['nama' => 'Banner Utama', 'class' => 'bg-info'],
                                2 => ['nama' => 'Banner Popup', 'class' => 'bg-warning'],
                                3 => ['nama' => 'Banner Berita', 'class' => 'bg-success']
                            ];
                            foreach ($banners as $b): 
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="table-number"><?= $no++ ?></div>
                                    </td>
                                    <td>
                                        <div class="banner-title"><?= esc($b['title']) ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        $kat = $kategori[$b['category_banner']] ?? ['nama' => '-', 'class' => 'bg-secondary'];
                                        ?>
                                        <span class="badge <?= $kat['class'] ?>"><?= $kat['nama'] ?></span>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-name">
                                                <i class="bi bi-person-fill me-1" style="color: #94a3b8;"></i>
                                                <?= esc($b['is_delete_by_name'] ?? '-') ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-date">
                                                <i class="bi bi-clock me-1"></i>
                                                <?php if (!empty($b['is_delete_at'])): ?>
                                                    <?= date('d/m/Y H:i', strtotime($b['is_delete_at'])) ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center flex-wrap">
                                            <a href="<?= site_url('banner/restore/' . $b['id_banner']) ?>" 
                                               class="btn btn-sm btn-restore btn-action" 
                                               title="Pulihkan Banner">
                                                <i class="bi bi-arrow-counterclockwise"></i>Pulihkan
                                            </a>
                                            <a href="<?= site_url('banner/destroyPermanent/' . $b['id_banner']) ?>"
                                               class="btn btn-sm btn-permanent-delete btn-action"
                                               onclick="return confirm('⚠️ PERHATIAN!\n\nBanner akan dihapus PERMANEN dan tidak dapat dipulihkan kembali.\n\nYakin ingin melanjutkan?')"
                                               title="Hapus Permanen">
                                                <i class="bi bi-trash3-fill"></i>Hapus Permanen
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <div class="empty-state">
                    <i class="bi bi-trash3"></i>
                    <h5>Sampah Kosong</h5>
                    <p>Tidak ada banner yang dihapus saat ini</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>