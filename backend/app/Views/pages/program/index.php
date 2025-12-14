<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #2c3e50;
        --accent-color: #f6c23e; /* Warna Kuning/Emas sesuai menu Program */
        --accent-text: #856404;
        --success-color: #27ae60;
    }

    /* Header Styling */
    .page-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border-left: 5px solid var(--accent-color);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Card Styling */
    .card-table {
        background: white;
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* Table Styling */
    .table thead th {
        background-color: #fffcf0; /* Background agak kekuningan tipis */
        color: var(--primary-color);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        border-bottom: 2px solid #eec14b;
        padding: 1rem;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }

    /* Program & Kegiatan Styling */
    .program-title {
        font-weight: 700;
        color: var(--primary-color);
        display: block;
        margin-bottom: 4px;
    }
    .kegiatan-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
    }
    .kegiatan-subtitle i {
        font-size: 0.8rem;
        margin-right: 5px;
    }

    /* Badge Tahun */
    .badge-year {
        background-color: #e9ecef;
        color: var(--primary-color);
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 6px;
    }

    /* Tombol Aksi */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        margin: 0 2px;
    }
    .btn-edit-custom { background-color: #fff3cd; color: #856404; }
    .btn-edit-custom:hover { background-color: #ffeeba; }
    
    .btn-delete-custom { background-color: #f8d7da; color: #721c24; }
    .btn-delete-custom:hover { background-color: #f5c6cb; }

    .btn-download-custom { background-color: #e3f2fd; color: #0d47a1; }
    .btn-download-custom:hover { background-color: #bbdefb; }

    /* Empty State */
    .empty-state {
        padding: 4rem;
        text-align: center;
        color: #95a5a6;
    }
</style>

<?= $this->include('layouts/alerts') ?>

<div style="display:none;">
    <?= csrf_field() ?>
</div>

<div class="container-fluid px-4 py-4">
    
    <div class="page-header">
        <div>
            <h3 class="m-0 fw-bold" style="color: var(--primary-color);">
                <i class="bi bi-journal-bookmark-fill me-2" style="color: var(--accent-color);"></i>Program & Anggaran
            </h3>
            <p class="text-muted m-0 mt-1">Kelola data perencanaan program, kegiatan, dan anggaran dinas.</p>
        </div>
        
        <?php if (isset($can_create) && $can_create) : ?>
            <a href="<?= base_url('program/new') ?>" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Program
            </a>
        <?php endif; ?>
    </div>

    <div class="card card-table">
        <div class="card-body p-0">
            
            <?php if (empty($menu_profiles)) : ?>
                <div class="empty-state">
                    <i class="bi bi-journal-x display-4 mb-3 d-block text-secondary"></i>
                    <h5>Belum ada data program</h5>
                    <p class="text-muted">Silakan tambahkan data program kerja dan anggaran baru.</p>
                    <?php if (isset($can_create) && $can_create) : ?>
                        <a href="<?= base_url('program/new') ?>" class="btn btn-outline-primary mt-2">Tambah Data</a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="35%">Program & Kegiatan</th>
                                <th width="10%" class="text-center">Tahun</th>
                                <th width="15%" class="text-end">Anggaran (Rp)</th>
                                <th width="10%" class="text-center">Lampiran</th>
                                <th width="10%" class="text-center">Status</th> <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menu_profiles as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <span class="program-title"><?= esc($item['nama_program']) ?></span>
                                        <div class="kegiatan-subtitle">
                                            <i class="bi bi-arrow-return-right"></i>
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
                                               class="btn-action btn-download-custom" 
                                               data-bs-toggle="tooltip" 
                                               title="Unduh Lampiran">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($item['id_program'], $item['is_active'], 'program/toggle-status') ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <?php if (isset($can_update) && $can_update) : ?>
                                            <a href="<?= base_url('program/' . $item['id_program'] . '/edit') ?>" 
                                               class="btn-action btn-edit-custom"
                                               data-bs-toggle="tooltip" 
                                               title="Edit Data">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (isset($can_delete) && $can_delete) : ?>
                                            <form action="<?= base_url('program/' . $item['id_program']) ?>" method="post" class="d-inline delete-form">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="btn-action btn-delete-custom btn-delete" 
                                                        title="Hapus Data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Inisialisasi Tooltip Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // SweetAlert untuk Hapus
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Hapus Program?',
                text: "Data program, kegiatan, dan lampiran akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>