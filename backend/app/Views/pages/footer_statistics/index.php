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
    .btn-soft-warning { background-color: var(--warning-soft); color: var(--warning-text); border: none; }
    .btn-soft-warning:hover { background-color: #d97706; color: white; }
    
    .btn-soft-danger { background-color: var(--danger-soft); color: var(--danger-text); border: none; }
    .btn-soft-danger:hover { background-color: #dc2626; color: white; }

    .badge-soft-info { background-color: var(--info-soft); color: var(--info-text); }
    .badge-soft-success { background-color: var(--success-soft); color: var(--success-text); }
    
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

    /* Styling Tabs */
    .nav-pills .nav-link {
        border-radius: 0.75rem;
        transition: all 0.2s;
        font-weight: 500;
    }
    .nav-pills .nav-link.active {
        background-color: #4f46e5;
        color: white;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    .nav-pills .nav-link:hover:not(.active) {
        background-color: var(--primary-soft);
        color: var(--primary-text);
    }

    /* Modal Styling Fix */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .modal-header {
        border-bottom: 1px solid #f3f4f6;
        background-color: #fff;
        border-radius: 1rem 1rem 0 0;
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Footer Statistics</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-chart-pie me-1 text-primary"></i> 
                Kelola data statistik (pengunjung, data desa, dll) di footer.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Statistics</li>
            </ol>
        </nav>
    </div>

    <?= $this->include('components/footer_tabs') ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Statistik</h5>
                <span class="text-muted small">Angka statistik yang ditampilkan di halaman depan</span>
            </div>
            
            <?php if ($can_create): ?>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" data-bs-toggle="modal" data-bs-target="#modalTambahStatistik">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Data
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">No</th>
                            <th class="py-3 text-uppercase">Label Statistik</th>
                            <th class="py-3 text-uppercase">Nilai (Value)</th>
                            <th class="text-center py-3 text-uppercase">Tipe</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Urutan</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($statistics)): ?>
                            <?php foreach ($statistics as $key => $row): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $key + 1 ?></td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($row['stat_label']) ?></div>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-primary fs-6"><?= esc($row['stat_value']) ?></div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge badge-soft-info border shadow-sm px-3 py-2 rounded-pill text-uppercase" style="font-size: 0.75rem;">
                                            <?= esc($row['stat_type']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-1 rounded-pill font-monospace">
                                            <?= esc($row['sorting']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($row['id_footer_statis'], $row['is_active'], 'footer_statistics/toggle-status') ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                   class="btn btn-soft-warning btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center btn-edit" 
                                                   style="width: 32px; height: 32px;"
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#modalEditStatistik"
                                                   data-id="<?= $row['id_footer_statis'] ?>"
                                                   data-label="<?= esc($row['stat_label']) ?>"
                                                   data-value="<?= esc($row['stat_value']) ?>"
                                                   data-type="<?= esc($row['stat_type']) ?>"
                                                   data-sorting="<?= esc($row['sorting']) ?>"
                                                   data-autoupdate="<?= $row['auto_update'] ?>"
                                                   data-active="<?= $row['is_active'] ?>"
                                                   title="Edit Data">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if ($can_delete): ?>
                                                <form action="<?= base_url('footer_statistics/' . $row['id_footer_statis']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="fas fa-chart-bar fa-4x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada data statistik</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan data statistik baru.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <span>Gunakan tipe <strong>Dynamic</strong> jika data diambil otomatis, atau <strong>Static/Manual</strong> untuk input manual.</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahStatistik" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-gray-800" id="modalTambahLabel">
                    <i class="fas fa-plus-circle text-primary me-2"></i>Tambah Statistik Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?= base_url('footer_statistics') ?>" method="post">
                <div class="modal-body p-4">
                    <?= csrf_field() ?>

                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stat_label" class="form-label fw-bold small text-uppercase text-muted">Label Statistik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="stat_label" name="stat_label" value="<?= old('stat_label') ?>" placeholder="Contoh: Klien Puas" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stat_value" class="form-label fw-bold small text-uppercase text-muted">Nilai (Value) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="stat_value" name="stat_value" value="<?= old('stat_value') ?>" placeholder="Contoh: 150+" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stat_type" class="form-label fw-bold small text-uppercase text-muted">Tipe Statistik</label>
                            <select class="form-select form-control" id="stat_type" name="stat_type">
                                <option value="today_visitors" <?= old('stat_type') == 'today_visitors' ? 'selected' : '' ?>>Visitor (Hari Ini)</option>
                                <option value="online_visitors" <?= old('stat_type') == 'online_visitors' ? 'selected' : '' ?>>Online Visitor</option>
                                <option value="total_visitors" <?= old('stat_type') == 'total_visitors' ? 'selected' : '' ?>>Total Visitor</option>
                                <option value="manual" <?= old('stat_type') == 'manual' ? 'selected' : '' ?>>Manual Input</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="sorting" class="form-label fw-bold small text-uppercase text-muted">Urutan (Sorting)</label>
                            <input type="number" class="form-control" id="sorting" name="sorting" value="<?= old('sorting', 0) ?>">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 d-flex align-items-center bg-light p-3 rounded">
                            <div class="form-check me-4">
                                <input class="form-check-input" type="checkbox" id="auto_update" name="auto_update" value="1" <?= old('auto_update') ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold text-dark" for="auto_update">
                                    Auto Update Count
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold text-dark" for="is_active">
                                    Aktifkan Data
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0 rounded-bottom">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditStatistik" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-gray-800" id="modalEditLabel">
                    <i class="fas fa-edit text-warning me-2"></i>Edit Statistik
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formEditStatistik" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_stat_label" class="form-label fw-bold small text-uppercase text-muted">Label Statistik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_stat_label" name="stat_label" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_stat_value" class="form-label fw-bold small text-uppercase text-muted">Nilai (Value) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_stat_value" name="stat_value" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_stat_type" class="form-label fw-bold small text-uppercase text-muted">Tipe Statistik</label>
                            <select class="form-select form-control" id="edit_stat_type" name="stat_type">
                                <option value="today_visitors">Visitor (Hari Ini)</option>
                                <option value="online_visitors">Online Visitor</option>
                                <option value="total_visitors">Total Visitor</option>
                                <option value="manual">Manual Input</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_sorting" class="form-label fw-bold small text-uppercase text-muted">Urutan (Sorting)</label>
                            <input type="number" class="form-control" id="edit_sorting" name="sorting">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12 d-flex align-items-center bg-light p-3 rounded">
                            <div class="form-check me-4">
                                <input class="form-check-input" type="checkbox" id="edit_auto_update" name="auto_update" value="1">
                                <label class="form-check-label fw-bold text-dark" for="edit_auto_update">
                                    Auto Update Count
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                                <label class="form-check-label fw-bold text-dark" for="edit_is_active">
                                    Aktifkan Data
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0 rounded-bottom">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Script untuk Re-open Modal Tambah jika ada error validasi
        <?php if (session()->has('errors')) : ?>
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahStatistik'));
            myModal.show();
        <?php endif; ?>

        // Script untuk Menghandle Modal Edit (Populating Data)
        var modalEdit = document.getElementById('modalEditStatistik');
        modalEdit.addEventListener('show.bs.modal', function (event) {
            // Button yang men-trigger modal
            var button = event.relatedTarget;
            
            // Ambil data dari atribut data-*
            var id = button.getAttribute('data-id');
            var label = button.getAttribute('data-label');
            var value = button.getAttribute('data-value');
            var type = button.getAttribute('data-type');
            var sorting = button.getAttribute('data-sorting');
            var autoUpdate = button.getAttribute('data-autoupdate');
            var isActive = button.getAttribute('data-active');

            // Update Action URL pada Form Edit
            var form = document.getElementById('formEditStatistik');
            form.action = '<?= base_url('footer_statistics') ?>/' + id;

            // Isi input value di dalam modal
            document.getElementById('edit_stat_label').value = label;
            document.getElementById('edit_stat_value').value = value;
            document.getElementById('edit_stat_type').value = type;
            document.getElementById('edit_sorting').value = sorting;

            // Handle Checkbox
            document.getElementById('edit_auto_update').checked = (autoUpdate == 1);
            document.getElementById('edit_is_active').checked = (isActive == 1);
        });
    });
</script>

<?= $this->endSection() ?>