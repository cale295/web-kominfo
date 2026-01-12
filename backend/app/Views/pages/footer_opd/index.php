<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    :root {
        --primary-soft: #eef2ff;
        --primary-text: #4f46e5;
        --success-soft: #ecfdf5;
        --success-text: #059669;
        --danger-soft: #fef2f2;
        --danger-text: #dc2626;
        --warning-soft: #fffbeb;
        --warning-text: #d97706;
    }

    /* Gradient Title */
    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Modern Card */
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    /* Action Buttons Soft */
    .btn-soft-primary { background-color: var(--primary-soft); color: var(--primary-text); border: none; }
    .btn-soft-primary:hover { background-color: #4f46e5; color: white; }
    
    .btn-soft-danger { background-color: var(--danger-soft); color: var(--danger-text); border: none; }
    .btn-soft-danger:hover { background-color: #dc2626; color: white; }

    /* Image Hover Effect */
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .img-hover-zoom:hover {
        transform: scale(1.5);
        z-index: 10;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        cursor: zoom-in;
    }

    /* Table Styling */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 2px solid #f3f4f6;
    }
    .table tbody tr td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f9fafb;
    }
    
    .icon-box {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 8px;
    }

    /* Styling Tambahan untuk Tabs */
    .nav-pills .nav-link {
        border-radius: 0.75rem;
        transition: all 0.2s;
        font-weight: 500;
    }
    .nav-pills .nav-link.active {
        background-color: #4f46e5; /* Sesuaikan dengan tema primary */
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: var(--primary-soft);
        color: var(--primary-text);
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Manajemen Footer</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-info-circle me-1 text-primary"></i> 
                Pusat kendali informasi identitas, sosial media, dan statistik footer.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Footer OPD</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-white text-danger me-3 shadow-sm" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Terjadi Kesalahan!</h6>
                    <small><?= session()->getFlashdata('error') ?></small>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?= $this->include('components/footer_tabs') ?>
    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Informasi OPD</h5>
                <span class="text-muted small">Kelola data identitas dinas/instansi</span>
            </div>
            
            <?php if ($can_create): ?>
                <a href="/footer_opd/new" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Data Baru
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">#</th>
                            <th class="py-3 text-uppercase" width="25%">Identitas Website</th>
                            <th class="py-3 text-uppercase" width="25%">Kontak & Alamat</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aset Visual</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($footer_opd)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486777.png" alt="Empty" width="80" class="opacity-25 mb-3">
                                        <h6 class="fw-bold text-secondary">Belum ada data tersedia</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan data baru untuk memulai pengaturan footer.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($footer_opd as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 45px; height: 45px; min-width: 45px;">
                                                <i class="fas fa-globe text-primary fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= esc($item['website_name']) ?></div>
                                                <div class="small text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                                    <?= esc($item['official_title']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column gap-2 small">
                                            <div class="d-flex align-items-start text-muted">
                                                <span class="icon-box bg-light text-danger shadow-sm me-2 flex-shrink-0" style="width:24px; height:24px; font-size:10px;">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                                <span class="lh-sm"><?= esc($item['address']) ?></span>
                                            </div>
                                            <?php if($item['email']): ?>
                                                <div class="d-flex align-items-center text-muted">
                                                    <span class="icon-box bg-light text-warning shadow-sm me-2 flex-shrink-0" style="width:24px; height:24px; font-size:10px;">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <span><?= esc($item['email']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <?php 
                                            $hasImage = false;
                                            $renderImg = function($path, $title) {
                                                if (!empty($path) && file_exists($path)) {
                                                    return '<div class="position-relative" data-bs-toggle="tooltip" title="'.$title.'">
                                                                <img src="'.base_url($path).'" 
                                                                     class="img-thumbnail rounded-3 shadow-sm img-hover-zoom bg-white" 
                                                                     style="height: 40px; width: 40px; object-fit: contain; padding: 2px;">
                                                            </div>';
                                                }
                                                return '';
                                            };
                                            
                                            echo $renderImg($item['logo_cominfo'], 'Logo Kominfo');
                                            if (!empty($item['logo_cominfo']) && file_exists($item['logo_cominfo'])) $hasImage = true;
                                            ?>
                                            <?php if (!$hasImage): ?>
                                                <span class="badge bg-light text-secondary border rounded-pill px-3">Kosong</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-1">
                                                <?= btn_toggle($item['id_opd_info'], $item['is_active'], 'footer_opd/toggle-status') ?>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/footer_opd/<?= $item['id_opd_info'] ?>/edit" 
                                                   class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                   style="width: 32px; height: 32px;"
                                                   data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/footer_opd/<?= $item['id_opd_info'] ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" 
                                                            class="btn btn-soft-danger btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                            style="width: 32px; height: 32px;"
                                                            data-bs-toggle="tooltip" title="Hapus Permanen">
                                                        <i class="fas fa-trash-alt fa-xs"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="fas fa-shield-alt me-2 text-primary"></i>
                <span>Pastikan data berstatus <strong>"AKTIF"</strong> agar muncul di halaman depan website.</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<?= $this->endSection() ?>