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
        --info-soft: #eff6ff;
        --info-text: #3b82f6;
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

    /* Soft Badges & Buttons */
    .btn-soft-primary { background-color: var(--primary-soft); color: var(--primary-text); border: none; }
    .btn-soft-primary:hover { background-color: #4f46e5; color: white; }
    
    .btn-soft-danger { background-color: var(--danger-soft); color: var(--danger-text); border: none; }
    .btn-soft-danger:hover { background-color: #dc2626; color: white; }
    
    .btn-soft-warning { background-color: var(--warning-soft); color: var(--warning-text); border: none; }
    .btn-soft-warning:hover { background-color: #d97706; color: white; }

    /* Table Styling */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 2px solid #f3f4f6;
        text-transform: uppercase;
        background-color: #f9fafb;
    }
    .table tbody tr td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badge Styling */
    .badge-rup {
        background-color: var(--info-soft);
        color: var(--info-text);
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-family: 'Courier New', monospace;
    }

    /* Button Action */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
    }
    
    /* Hover Scale */
    .hover-scale { 
        transition: transform 0.2s; 
    }
    .hover-scale:hover { 
        transform: scale(1.05); 
    }

    /* Anggaran Styling */
    .anggaran-value {
        font-weight: 600;
        color: var(--success-text);
        font-size: 0.9rem;
    }
    .anggaran-label {
        font-size: 0.75rem;
        color: #6b7280;
    }

    /* Package Info */
    .package-name {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .package-desc {
        font-size: 0.8rem;
        color: #6b7280;
        line-height: 1.4;
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">IP Swakelola</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-user-cog me-1 text-primary"></i> 
                Informasi Pengadaan Swakelola yang dilaksanakan oleh unit kerja sendiri.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">IP Swakelola</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm border-start border-4 border-success rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-success me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-check"></i>
                </div>
                <div class="fw-medium">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-danger me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="fw-medium">
                    <?= session()->getFlashdata('error') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Paket Swakelola</h5>
                <span class="text-muted small">Pengadaan yang dilaksanakan secara mandiri oleh unit kerja</span>
            </div>
            
            <?php if ($can_create): ?>
                <a href="/ip_swakelola/new" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Data
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php if (empty($ip_swakelola)) : ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-user-cog fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada data</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan data pengadaan swakelola baru.</p>
                        <?php if ($can_create): ?>
                            <a href="/ip_swakelola/new" class="btn btn-primary rounded-pill px-4 mt-3 shadow-sm hover-scale">
                                <i class="fas fa-plus me-1"></i>Tambah Data
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3" width="15%">ID RUP</th>
                                <th class="py-3" width="45%">Nama Paket</th>
                                <th class="text-end py-3" width="20%">Pagu Anggaran</th>
                                <th class="text-center py-3" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ip_swakelola as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <span class="badge-rup"><?= esc($item['id_rup']) ?></span>
                                    </td>
                                    
                                    <td>
                                        <div class="package-name"><?= esc($item['nama_paket']) ?></div>
                                        <?php if (!empty($item['lokasi'])): ?>
                                            <div class="package-desc">
                                                <i class="fas fa-map-marker-alt me-1" style="font-size: 0.7rem; color: #9ca3af;"></i>
                                                <?= esc($item['lokasi']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-end">
                                        <div class="anggaran-value">
                                            Rp <?= number_format((float)esc($item['jumlah_pagu']), 0, ',', '.') ?>
                                        </div>
                                        <div class="anggaran-label">
                                            Pagu Swakelola
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/ip_swakelola/<?= $item['id'] ?>/edit" 
                                                   class="btn-action btn-soft-warning hover-scale"
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit Data">
                                                    <i class="fas fa-edit fa-xs"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/ip_swakelola/<?= $item['id'] ?>" 
                                                      method="post" 
                                                      class="d-inline delete-form"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" 
                                                            class="btn-action btn-soft-danger hover-scale"
                                                            data-bs-toggle="tooltip" 
                                                            title="Hapus Permanen">
                                                        <i class="fas fa-trash-alt fa-xs"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <span>Swakelola adalah pengadaan barang/jasa yang dilaksanakan sendiri oleh K/L/D/I sesuai Perpres No. 16 Tahun 2018.</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<?= $this->endSection() ?>