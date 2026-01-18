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
    
    .btn-soft-info { background-color: var(--info-soft); color: var(--info-text); border: none; }
    .btn-soft-info:hover { background-color: #3b82f6; color: white; }

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
    .badge-year {
        background-color: #f3f4f6;
        color: #374151;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    /* Program & Kegiatan Styling */
    .program-title {
        font-weight: 700;
        color: #1f2937;
        display: block;
        margin-bottom: 4px;
        font-size: 1rem;
    }
    .kegiatan-subtitle {
        color: #6b7280;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        margin-top: 2px;
    }
    .kegiatan-subtitle i {
        font-size: 0.75rem;
        margin-right: 6px;
        color: #9ca3af;
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
        margin: 0 2px;
    }
    
    /* Hover Scale */
    .hover-scale { 
        transition: transform 0.2s; 
    }
    .hover-scale:hover { 
        transform: scale(1.05); 
    }
</style>

<div style="display:none;">
    <?= csrf_field() ?>
</div>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Program & Anggaran</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-chart-pie me-1 text-primary"></i> 
                Kelola data perencanaan program, kegiatan, dan anggaran dinas.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Program</li>
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
                <h5 class="fw-bold text-dark mb-0">Daftar Program</h5>
                <span class="text-muted small">Perencanaan program dan anggaran dinas</span>
            </div>
            
            <?php if (isset($can_create) && $can_create) : ?>
                <a href="<?= base_url('program/new') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Program
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php if (empty($menu_profiles)) : ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-chart-line fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada data program</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan data program kerja dan anggaran baru.</p>
                        <?php if (isset($can_create) && $can_create) : ?>
                            <a href="<?= base_url('program/new') ?>" class="btn btn-primary rounded-pill px-4 mt-3 shadow-sm hover-scale">
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
                                <th class="py-3" width="35%">Program & Kegiatan</th>
                                <th class="text-center py-3" width="10%">Tahun</th>
                                <th class="text-end py-3" width="15%">Anggaran (Rp)</th>
                                <th class="text-center py-3" width="10%">Lampiran</th>
                                <th class="text-center py-3" width="10%">Status</th>
                                <th class="text-center py-3" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menu_profiles as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <span class="program-title"><?= esc($item['nama_program']) ?></span>
                                        <div class="kegiatan-subtitle">
                                            <i class="fas fa-arrow-right"></i>
                                            <?= esc($item['nama_kegiatan']) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge-year"><?= esc($item['tahun']) ?></span>
                                    </td>

                                    <td class="text-end fw-bold text-dark">
                                        <?= number_format($item['nilai_anggaran'], 0, ',', '.') ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if (!empty($item['file_lampiran'])) : ?>
                                            <a href="<?= base_url($item['file_lampiran']) ?>" 
                                               target="_blank" 
                                               class="btn-action btn-soft-info hover-scale" 
                                               data-bs-toggle="tooltip" 
                                               title="Unduh Lampiran">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_program'], $item['is_active'], 'program/toggle-status') ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if (isset($can_update) && $can_update) : ?>
                                                <a href="<?= base_url('program/' . $item['id_program'] . '/edit') ?>" 
                                                   class="btn-action btn-soft-primary hover-scale"
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit Data">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (isset($can_delete) && $can_delete) : ?>
                                                <form action="<?= base_url('program/' . $item['id_program']) ?>" method="post" class="d-inline delete-form">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" 
                                                            class="btn-action btn-soft-danger hover-scale btn-delete" 
                                                            title="Hapus Data">
                                                        <i class="fas fa-trash-alt"></i>
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
                <span>Format angka anggaran menggunakan pemisah ribuan. Klik tombol PDF untuk melihat lampiran.</span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // SweetAlert untuk Hapus
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                Swal.fire({
                    title: 'Hapus Program?',
                    text: "Data program, kegiatan, dan lampiran akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3',
                        confirmButton: 'rounded-pill px-4',
                        cancelButton: 'rounded-pill px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<?= $this->endSection() ?>