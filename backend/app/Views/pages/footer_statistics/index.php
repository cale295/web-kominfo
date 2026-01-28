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

    .card-modern:hover {
        transform: translateY(-2px);
    }

    /* Soft Badges & Buttons */
    .btn-soft-primary {
        background-color: var(--primary-soft);
        color: var(--primary-text);
        border: none;
    }
    .btn-soft-primary:hover {
        background-color: #4f46e5;
        color: white;
    }
    
    .btn-soft-warning { 
        background-color: var(--warning-soft); 
        color: var(--warning-text); 
        border: none; 
    }
    .btn-soft-warning:hover { 
        background-color: #d97706; 
        color: white; 
    }
    
    .btn-soft-danger { 
        background-color: var(--danger-soft); 
        color: var(--danger-text); 
        border: none; 
    }
    .btn-soft-danger:hover { 
        background-color: #dc2626; 
        color: white; 
    }

    .badge-soft-info { 
        background-color: var(--info-soft); 
        color: var(--info-text); 
        padding: 0.5rem 1rem;
        border-radius: 50rem;
    }
    .badge-soft-success { 
        background-color: var(--success-soft); 
        color: var(--success-text); 
        padding: 0.5rem 1rem;
        border-radius: 50rem;
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

    /* Badge for Auto Update */
    .badge-auto {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
    
    .badge-auto-on {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    
    .badge-auto-off {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
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
                            <th class="text-center py-3 text-uppercase">Auto Update</th>
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
                                        <div class="fw-bold text-dark mb-1"><?= esc($row['stat_label']) ?></div>
                                        <small class="text-muted d-block">ID: <?= $row['id_footer_statis'] ?></small>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-primary fs-6 mb-1"><?= number_format($row['stat_value']) ?></div>
                                        <?php if ($row['auto_update'] == 1): ?>
                                            <small class="text-success">
                                                <i class="fas fa-sync-alt fa-xs me-1"></i>Auto Update
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php
                                            $typeBadgeClass = '';
                                            $typeText = '';
                                            switch($row['stat_type']) {
                                                case 'today_visitors':
                                                    $typeBadgeClass = 'bg-primary';
                                                    $typeText = 'Today';
                                                    break;
                                                case 'online_visitors':
                                                    $typeBadgeClass = 'bg-success';
                                                    $typeText = 'Online';
                                                    break;
                                                case 'total_visitors':
                                                    $typeBadgeClass = 'bg-info';
                                                    $typeText = 'Total';
                                                    break;
                                                case 'manual':
                                                    $typeBadgeClass = 'bg-secondary';
                                                    $typeText = 'Manual';
                                                    break;
                                                default:
                                                    $typeBadgeClass = 'bg-light text-dark';
                                                    $typeText = $row['stat_type'];
                                            }
                                        ?>
                                        <span class="badge <?= $typeBadgeClass ?> px-3 py-2 rounded-pill text-uppercase" style="font-size: 0.75rem;">
                                            <?= esc($typeText) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if ($row['auto_update'] == 1): ?>
                                            <span class="badge-auto badge-auto-on">
                                                <i class="fas fa-check-circle me-1"></i>ON
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-auto badge-auto-off">
                                                <i class="fas fa-times-circle me-1"></i>OFF
                                            </span>
                                        <?php endif; ?>
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
                                <td colspan="8" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="fas fa-chart-bar fa-4x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada data statistik</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan data statistik baru.</p>
                                        <?php if ($can_create): ?>
                                            <button type="button" class="btn btn-primary btn-sm mt-3 rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambahStatistik">
                                                <i class="fas fa-plus me-2"></i>Tambah Data Pertama
                                            </button>
                                        <?php endif; ?>
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

<!-- Modal Tambah Statistik -->
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
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading fw-bold mb-2">Terdapat kesalahan:</h6>
                            <ul class="mb-0 ps-3">
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stat_label" class="form-label fw-bold small text-uppercase text-muted">
                                Label Statistik <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="stat_label" 
                                   name="stat_label" 
                                   value="<?= old('stat_label') ?>" 
                                   placeholder="Contoh: Pengunjung Hari Ini" 
                                   required>
                            <small class="form-text text-muted">Nama yang akan ditampilkan di footer</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stat_type" class="form-label fw-bold small text-uppercase text-muted">
                                Tipe Statistik <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-control" id="stat_type" name="stat_type" required>
                                <option value="" disabled selected>-- Pilih Tipe --</option>
                                <option value="today_visitors" <?= old('stat_type') == 'today_visitors' ? 'selected' : '' ?>>Pengunjung Hari Ini</option>
                                <option value="online_visitors" <?= old('stat_type') == 'online_visitors' ? 'selected' : '' ?>>Pengunjung Online</option>
                                <option value="total_visitors" <?= old('stat_type') == 'total_visitors' ? 'selected' : '' ?>>Total Pengunjung</option>
                                <option value="manual" <?= old('stat_type') == 'manual' ? 'selected' : '' ?>>Input Manual</option>
                            </select>
                            <small class="form-text text-muted">Pilih "Input Manual" jika ingin isi sendiri</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sorting" class="form-label fw-bold small text-uppercase text-muted">
                                Urutan (Sorting)
                            </label>
                            <input type="number" 
                                   class="form-control" 
                                   id="sorting" 
                                   name="sorting" 
                                   value="<?= old('sorting', 0) ?>"
                                   min="0"
                                   max="999">
                            <small class="form-text text-muted">Angka kecil muncul pertama (0, 1, 2, ...)</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="bg-light p-3 rounded">
                                <!-- Hanya Info tentang Auto Update, TANPA Checkbox Aktifkan Data -->
                                <div class="alert alert-info alert-sm mt-2 mb-0 py-2">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Auto Update:</strong> 
                                    <span id="autoUpdateInfo">Akan aktif otomatis berdasarkan tipe statistik yang dipilih.</span>
                                </div>
                                
                                <!-- Info Status -->
                                <div class="alert alert-success alert-sm mt-2 mb-0 py-2">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    <strong>Status:</strong> 
                                    <span>Data akan otomatis aktif setelah disimpan.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="alert alert-light border mt-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-lightbulb text-warning fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="alert-heading mb-1">Informasi Penting:</h6>
                                <p class="mb-0 small">
                                    • Nilai statistik akan diisi otomatis oleh sistem untuk tipe <strong>Pengunjung</strong><br>
                                    • Untuk tipe <strong>Input Manual</strong>, Anda perlu mengisi nilai secara manual di halaman edit<br>
                                    • Auto update akan aktif untuk tipe non-manual<br>
                                    • Data akan otomatis aktif setelah disimpan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0 rounded-bottom">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Statistik -->
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
                            <label for="edit_stat_label" class="form-label fw-bold small text-uppercase text-muted">
                                Label Statistik <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_stat_label" 
                                   name="stat_label" 
                                   required>
                            <small class="form-text text-muted">Nama yang akan ditampilkan di footer</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_stat_type" class="form-label fw-bold small text-uppercase text-muted">
                                Tipe Statistik <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-control" id="edit_stat_type" name="stat_type" required>
                                <option value="" disabled>-- Pilih Tipe --</option>
                                <option value="today_visitors">Pengunjung Hari Ini</option>
                                <option value="online_visitors">Pengunjung Online</option>
                                <option value="total_visitors">Total Pengunjung</option>
                                <option value="manual">Input Manual</option>
                            </select>
                            <small class="form-text text-muted">Pilih "Input Manual" jika ingin isi sendiri</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_sorting" class="form-label fw-bold small text-uppercase text-muted">
                                Urutan (Sorting)
                            </label>
                            <input type="number" 
                                   class="form-control" 
                                   id="edit_sorting" 
                                   name="sorting" 
                                   min="0"
                                   max="999">
                            <small class="form-text text-muted">Angka kecil muncul pertama (0, 1, 2, ...)</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="bg-light p-3 rounded">
                                <!-- Info tentang Auto Update di Edit -->
                                <div class="alert alert-info alert-sm mt-2 mb-0 py-2" id="editAutoUpdateInfo">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Auto Update:</strong> 
                                    <span id="autoUpdateStatus">Status akan tampil di sini...</span>
                                </div>
                                
                                <!-- Info Status Aktif -->
                                <div class="alert alert-success alert-sm mt-2 mb-0 py-2">
                                    <i class="fas fa-toggle-on me-2"></i>
                                    <strong>Status Aktif:</strong> 
                                    <span id="activeStatusInfo">Gunakan tombol toggle di tabel untuk mengubah status</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info untuk Input Manual -->
                    <div class="alert alert-warning border" id="manualInputAlert" style="display: none;">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-warning fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="alert-heading mb-1">Input Manual Dipilih:</h6>
                                <p class="mb-0 small">
                                    Untuk tipe ini, Anda perlu mengisi nilai statistik secara manual.<br>
                                    Silakan gunakan tombol "Edit Nilai" di halaman utama untuk mengubah nilai.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0 rounded-bottom">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Perbarui Data
                    </button>
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

        // Update Auto Update Info di Modal Tambah
        const statTypeSelect = document.getElementById('stat_type');
        const autoUpdateInfo = document.getElementById('autoUpdateInfo');
        
        if (statTypeSelect) {
            statTypeSelect.addEventListener('change', function() {
                if (this.value === 'manual') {
                    autoUpdateInfo.textContent = 'TIDAK AKTIF - Anda perlu mengisi nilai manual';
                    autoUpdateInfo.parentElement.classList.remove('alert-info');
                    autoUpdateInfo.parentElement.classList.add('alert-warning');
                } else {
                    autoUpdateInfo.textContent = 'AKTIF - Nilai akan diupdate otomatis oleh sistem';
                    autoUpdateInfo.parentElement.classList.remove('alert-warning');
                    autoUpdateInfo.parentElement.classList.add('alert-info');
                }
            });
            
            // Trigger change event on page load
            statTypeSelect.dispatchEvent(new Event('change'));
        }

        // Script untuk Menghandle Modal Edit (Populating Data)
        var modalEdit = document.getElementById('modalEditStatistik');
        modalEdit.addEventListener('show.bs.modal', function (event) {
            // Button yang men-trigger modal
            var button = event.relatedTarget;
            
            // Ambil data dari atribut data-*
            var id = button.getAttribute('data-id');
            var label = button.getAttribute('data-label');
            var type = button.getAttribute('data-type');
            var sorting = button.getAttribute('data-sorting');
            var autoUpdate = button.getAttribute('data-autoupdate');
            var isActive = button.getAttribute('data-active');

            // Update Action URL pada Form Edit
            var form = document.getElementById('formEditStatistik');
            form.action = '<?= base_url('footer_statistics') ?>/' + id;

            // Isi input value di dalam modal
            document.getElementById('edit_stat_label').value = label;
            document.getElementById('edit_stat_type').value = type;
            document.getElementById('edit_sorting').value = sorting;

            // Handle Auto Update Info
            const editAutoUpdateInfo = document.getElementById('editAutoUpdateInfo');
            const autoUpdateStatus = document.getElementById('autoUpdateStatus');
            const manualInputAlert = document.getElementById('manualInputAlert');
            
            if (type === 'manual') {
                autoUpdateStatus.textContent = 'TIDAK AKTIF - Anda perlu mengisi nilai manual';
                editAutoUpdateInfo.classList.remove('alert-info');
                editAutoUpdateInfo.classList.add('alert-warning');
                manualInputAlert.style.display = 'block';
            } else {
                autoUpdateStatus.textContent = 'AKTIF - Nilai akan diupdate otomatis oleh sistem';
                editAutoUpdateInfo.classList.remove('alert-warning');
                editAutoUpdateInfo.classList.add('alert-info');
                manualInputAlert.style.display = 'none';
            }
            
            // Update active status info
            const activeStatusInfo = document.getElementById('activeStatusInfo');
            if (isActive == 1) {
                activeStatusInfo.textContent = 'Data saat ini AKTIF. Gunakan tombol toggle di tabel untuk menonaktifkan.';
                activeStatusInfo.parentElement.classList.remove('alert-danger');
                activeStatusInfo.parentElement.classList.add('alert-success');
            } else {
                activeStatusInfo.textContent = 'Data saat ini NON-AKTIF. Gunakan tombol toggle di tabel untuk mengaktifkan.';
                activeStatusInfo.parentElement.classList.remove('alert-success');
                activeStatusInfo.parentElement.classList.add('alert-danger');
            }

            // Listen for type change in edit modal
            const editStatType = document.getElementById('edit_stat_type');
            editStatType.addEventListener('change', function() {
                if (this.value === 'manual') {
                    autoUpdateStatus.textContent = 'TIDAK AKTIF - Anda perlu mengisi nilai manual';
                    editAutoUpdateInfo.classList.remove('alert-info');
                    editAutoUpdateInfo.classList.add('alert-warning');
                    manualInputAlert.style.display = 'block';
                } else {
                    autoUpdateStatus.textContent = 'AKTIF - Nilai akan diupdate otomatis oleh sistem';
                    editAutoUpdateInfo.classList.remove('alert-warning');
                    editAutoUpdateInfo.classList.add('alert-info');
                    manualInputAlert.style.display = 'none';
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>