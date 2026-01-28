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
    .badge-nav {
        background-color: var(--info-soft);
        color: var(--info-text);
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    .badge-nav.no {
        background-color: #f3f4f6;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    .badge-sorting {
        background-color: #f3f4f6;
        color: #374151;
        font-weight: 600;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
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

    /* Text Truncate */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.875rem;
    }

    /* Time Info */
    .time-info {
        font-size: 0.75rem;
        color: #6b7280;
    }
    .time-info i {
        font-size: 0.7rem;
    }
    
    /* Style untuk toggle yang terkunci */
    .form-check-input:disabled {
        cursor: not-allowed;
        opacity: 0.5;
        background-color: #e5e7eb;
        border-color: #d1d5db;
    }
    
    .form-check-input:disabled:checked {
        background-color: #9ca3af;
        border-color: #9ca3af;
    }
    
    /* Select disabled */
    select:disabled {
        background-color: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
    }
    
    /* Loading overlay */
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
    }
    
    .spinner-border {
        width: 3rem;
        height: 3rem;
    }
    
    /* Status badge */
    .status-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
    }
</style>

<!-- Loading Overlay -->
<div id="loadingOverlay">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Kategori Berita</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-list-alt me-1 text-primary"></i> 
                Kelola pengelompokan konten berita dan artikel.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Kategori</li>
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

    <?php
    // Hitung jumlah kategori aktif
    $activeCount = 0;
    if (!empty($kategori)) {
        foreach ($kategori as $row) {
            if ($row['is_show_nav'] == '1') {
                $activeCount++;
            }
        }
    }
    $remainingSlots = max(0, 10 - $activeCount);
    ?>

    <?php if ($activeCount >= 10): ?>
        <div class="alert alert-warning border-0 shadow-sm border-start border-4 border-warning rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-warning me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="fw-medium">
                    <strong>Perhatian:</strong> Batas maksimal 10 kategori aktif telah tercapai (<span class="fw-bold"><?= $activeCount ?>/10</span>). 
                    <span class="d-block mt-1 small">
                        <i class="fas fa-info-circle me-1"></i>
                        Anda masih dapat <strong>menonaktifkan</strong> kategori yang aktif, 
                        tetapi <strong>tidak dapat mengaktifkan</strong> kategori baru/nonaktif hingga ada slot yang tersedia.
                    </span>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Kategori</h5>
                <span class="text-muted small">Pengelompokan konten berita dan artikel</span>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex flex-column align-items-end">
                    <span class="badge bg-<?= $remainingSlots > 0 ? 'primary' : 'danger' ?> rounded-pill px-3 py-2 mb-1">
                        <i class="fas fa-layer-group me-1"></i> 
                        Aktif: <?= $activeCount ?>/10 
                        <?php if($remainingSlots > 0): ?>
                            <span class="ms-1">(Tersisa: <?= $remainingSlots ?>)</span>
                        <?php endif; ?>
                    </span>
                    <?php if($activeCount >= 10): ?>
                        <span class="text-danger small fw-bold">
                            <i class="fas fa-lock me-1"></i>Limit tercapai
                        </span>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Kategori
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <?php if (empty($kategori)): ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-list-alt fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada kategori</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan data baru.</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3" width="20%">Nama Kategori</th>
                                <th class="text-center py-3" width="10%">Urutan</th>
                                <th class="py-3" width="15%">Info Waktu</th>
                                <th class="text-center py-3" width="10%">Status</th>
                                <th class="text-center py-3" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategori as $i => $row): ?>
                                <?php 
                                $isCurrentlyActive = ($row['is_show_nav'] == '1');
                                $canDeactivate = $isCurrentlyActive; // Selalu bisa menonaktifkan
                                $canActivate = (!$isCurrentlyActive && $activeCount < 10); // Hanya bisa mengaktifkan jika kurang dari 10
                                $isLocked = (!$isCurrentlyActive && $activeCount >= 10); // Terkunci jika tidak aktif dan sudah 10 aktif
                                ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $i + 1 ?></td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($row['kategori']) ?></div>
                                        <?php if (!empty($row['keterangan'])): ?>
                                            <div class="text-truncate-2 text-muted">
                                                <?= esc($row['keterangan']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge-sorting"><?= $row['sorting_nav'] ?? '-' ?></span>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column time-info">
                                            <span>
                                                <i class="far fa-clock me-1"></i> 
                                                Cre: <?= date('d/m/y', strtotime($row['created_on'])) ?>
                                            </span>
                                            <?php if($row['modified_on']): ?>
                                            <span class="mt-1">
                                                <i class="fas fa-pencil-alt me-1"></i> 
                                                Upd: <?= date('d/m/y', strtotime($row['modified_on'])) ?>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <?php if ($isLocked): ?>
                                                <!-- Toggle terkunci untuk kategori nonaktif -->
                                                <div class="position-relative" data-bs-toggle="tooltip" 
                                                     title="Tidak dapat diaktifkan. Batas 10 kategori aktif tercapai. Nonaktifkan kategori lain terlebih dahulu.">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" 
                                                               type="checkbox" 
                                                               disabled
                                                               id="toggle-locked-<?= $row['id_kategori'] ?>">
                                                        <label class="form-check-label small text-muted ms-2" 
                                                               for="toggle-locked-<?= $row['id_kategori'] ?>">
                                                            <i class="fas fa-lock fa-xs"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <span class="badge bg-secondary status-badge ms-2">Terkunci</span>
                                            <?php else: ?>
                                                <!-- Toggle normal -->
                                                <div data-bs-toggle="tooltip" 
                                                     title="<?= $isCurrentlyActive ? 'Klik untuk menonaktifkan' : 'Klik untuk mengaktifkan' ?>">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input toggle-status" 
                                                               type="checkbox" 
                                                               data-id="<?= $row['id_kategori'] ?>"
                                                               data-current="<?= $isCurrentlyActive ? '1' : '0' ?>"
                                                               data-url="kategori/toggle-status"
                                                               id="toggle-<?= $row['id_kategori'] ?>"
                                                               <?= $isCurrentlyActive ? 'checked' : '' ?>>
                                                    </div>
                                                </div>
                                                <span class="badge bg-<?= $isCurrentlyActive ? 'success' : 'secondary' ?> status-badge ms-2">
                                                    <?= $isCurrentlyActive ? 'Aktif' : 'Nonaktif' ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button"
                                               class="btn-action btn-soft-warning hover-scale" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Kategori"
                                               onclick='openEditModal(<?= json_encode($row) ?>)'>
                                                <i class="fas fa-pencil-alt fa-xs"></i>
                                            </button>

                                            <button type="button" 
                                                    class="btn-action btn-soft-danger hover-scale" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus Permanen"
                                                    onclick="confirmDelete('<?= site_url('kategori/'.$row['id_kategori']) ?>')">
                                                <i class="fas fa-trash-alt fa-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endif ?>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <span>Maksimal <strong>10 kategori aktif</strong> yang dapat ditampilkan. 
                <?php if($activeCount >= 10): ?>
                    <strong class="text-danger">Limit tercapai!</strong> Nonaktifkan kategori aktif untuk mengaktifkan yang lain.
                <?php else: ?>
                    Tersisa <strong><?= $remainingSlots ?> slot</strong> aktif.
                <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('kategori') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Politik, Ekonomi, Olahraga" required autofocus>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tampilkan di Navigasi?</label>
                            <select name="is_show_nav" class="form-select" id="createIsShowNav" <?= $activeCount >= 10 ? 'disabled' : '' ?>>
                                <?php if($activeCount >= 10): ?>
                                    <option value="0" selected>Nonaktif (wajib)</option>
                                    <option value="1" disabled>Aktif (limit tercapai)</option>
                                <?php else: ?>
                                    <option value="1" selected>Ya (Aktif)</option>
                                    <option value="0">Tidak (Nonaktif)</option>
                                <?php endif; ?>
                            </select>
                            <?php if ($activeCount >= 10): ?>
                                <input type="hidden" name="is_show_nav" value="0">
                                <div class="form-text text-danger small">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Batas 10 kategori aktif telah tercapai. Kategori baru harus dibuat sebagai nonaktif.
                                </div>
                            <?php else: ?>
                                <div class="form-text text-muted small">
                                    Kategori aktif akan tampil di frontend. Tersisa <?= 10 - $activeCount ?> slot aktif.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Deskripsi singkat kategori (opsional)"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Urutan Navigasi</label>
                            <input type="number" name="sorting_nav" class="form-control" placeholder="Contoh: 1, 2, 3" min="0" value="0">
                            <div class="form-text small">Urutan tampilan di menu (angka kecil = lebih dulu)</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_id_kategori" name="id_kategori">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kategori" id="edit_kategori" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tampilkan di Navigasi?</label>
                            <div id="editIsShowNavContainer">
                                <!-- Akan diisi oleh JavaScript -->
                            </div>
                            <div class="form-text text-muted small mt-1">
                                <?php if($activeCount >= 10): ?>
                                    <i class="fas fa-info-circle me-1 text-danger"></i>
                                    Limit 10 kategori aktif tercapai. Hanya bisa mengubah dari aktif ke nonaktif.
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Urutan Navigasi</label>
                            <input type="number" name="sorting_nav" id="edit_sorting_nav" class="form-control" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form untuk delete -->
<form id="deleteSingleForm" action="" method="post" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hitung kategori aktif dari PHP
        const activeCount = <?= $activeCount ?>;
        const maxActive = 10;
        
        // --- 1. TOOLTIP INIT ---
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // --- 2. TOGGLE STATUS AJAX LOGIC dengan validasi batas ---
        const toggles = document.querySelectorAll('.toggle-status');
        const base_url = "<?= base_url() ?>";

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const url = this.dataset.url;
                const isChecked = this.checked ? 1 : 0;
                const currentStatus = parseInt(this.dataset.current);
                
                // Validasi: jika mencoba mengaktifkan (dari 0 ke 1) dan sudah mencapai batas
                if (currentStatus === 0 && isChecked === 1 && activeCount >= maxActive) {
                    // Tampilkan SweetAlert
                    Swal.fire({
                        icon: 'warning',
                        title: 'Batas Maksimal',
                        html: `<div class="text-start">
                            <p>Tidak dapat mengaktifkan kategori.</p>
                            <p class="mb-0">Batas maksimal <strong>10 kategori aktif</strong> telah tercapai (${activeCount}/10).</p>
                            <p class="mt-2">Silakan nonaktifkan kategori lain terlebih dahulu.</p>
                        </div>`,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33',
                    });
                    this.checked = false;
                    return;
                }

                // Validasi: jika mencoba menonaktifkan (dari 1 ke 0), selalu boleh
                if (currentStatus === 1 && isChecked === 0) {
                    // Lanjutkan proses
                }

                // Tampilkan konfirmasi
                Swal.fire({
                    title: 'Konfirmasi',
                    text: isChecked === 1 ? 'Aktifkan kategori ini?' : 'Nonaktifkan kategori ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading overlay
                        const loadingOverlay = document.getElementById('loadingOverlay');
                        loadingOverlay.style.display = 'flex';
                        
                        // Kunci toggle sementara
                        this.disabled = true;

                        const csrfName = '<?= csrf_token() ?>';
                        const csrfHash = '<?= csrf_hash() ?>';

                        let formData = new FormData();
                        formData.append('id', id);
                        formData.append('status', isChecked);
                        formData.append(csrfName, csrfHash);

                        fetch(base_url + '/' + url, {
                            method: 'POST',
                            headers: { 
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfHash
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Auto-refresh halaman setelah 500ms
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Status kategori berhasil diubah',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            } else {
                                // Sembunyikan loading
                                loadingOverlay.style.display = 'none';
                                this.disabled = false;
                                this.checked = !isChecked; // Kembalikan ke state sebelumnya
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message || 'Terjadi kesalahan saat mengubah status.',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#d33',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Sembunyikan loading
                            loadingOverlay.style.display = 'none';
                            this.disabled = false;
                            this.checked = !isChecked; // Kembalikan ke state sebelumnya
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33',
                            });
                        });
                    } else {
                        // Jika dibatalkan, kembalikan ke state sebelumnya
                        this.checked = !isChecked;
                    }
                });
            });
        });

        // --- 3. VALIDASI REAL-TIME UNTUK TOGGLE ---
        document.querySelectorAll('.toggle-status').forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                const currentStatus = parseInt(this.dataset.current);
                const newStatus = this.checked ? 1 : 0;
                
                // Jika mencoba mengaktifkan (dari 0 ke 1) dan sudah ada 10 aktif
                if (currentStatus === 0 && newStatus === 1 && activeCount >= maxActive) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Tampilkan alert
                    Swal.fire({
                        icon: 'warning',
                        title: 'Batas Maksimal',
                        html: `<div class="text-start">
                            <p>Tidak dapat mengaktifkan kategori.</p>
                            <p class="mb-0">Batas maksimal <strong>10 kategori aktif</strong> telah tercapai (${activeCount}/10).</p>
                            <p class="mt-2">Silakan nonaktifkan kategori lain terlebih dahulu.</p>
                        </div>`,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33',
                    });
                    
                    return false;
                }
            });
        });

        // --- 4. AUTO-SHOW MODAL JIKA ADA ERROR ---
        <?php if (session()->get('errors') || session()->getFlashdata('error')): ?>
            <?php if (isset($kategori) && isset($kategori['id_kategori'])): ?>
                // Jika ada data kategori, berarti dari edit
                openEditModal(<?= json_encode($kategori) ?>);
            <?php else: ?>
                // Jika tidak ada data kategori, berarti dari create
                var modalCreate = new bootstrap.Modal(document.getElementById('modalCreate'));
                modalCreate.show();
            <?php endif; ?>
        <?php endif; ?>
    });

    // --- 5. FUNCTION OPEN EDIT MODAL ---
    function openEditModal(data) {
        const activeCount = <?= $activeCount ?>;
        const maxActive = 10;
        const isCurrentlyActive = data.is_show_nav == '1';
        
        // Isi form dengan data
        document.getElementById('edit_id_kategori').value = data.id_kategori;
        document.getElementById('edit_kategori').value = data.kategori || '';
        document.getElementById('edit_keterangan').value = data.keterangan || '';
        document.getElementById('edit_sorting_nav').value = data.sorting_nav || '';
        
        // Handle is_show_nav dengan logika limit
        const container = document.getElementById('editIsShowNavContainer');
        
        if (activeCount >= maxActive && !isCurrentlyActive) {
            // Jika sudah 10 aktif dan kategori ini nonaktif, lock ke nonaktif
            container.innerHTML = `
                <select name="is_show_nav" class="form-select" disabled>
                    <option value="0" selected>Nonaktif</option>
                    <option value="1" disabled>Aktif (limit tercapai)</option>
                </select>
                <input type="hidden" name="is_show_nav" value="0">
            `;
        } else if (activeCount >= maxActive && isCurrentlyActive) {
            // Jika sudah 10 aktif dan kategori ini aktif, bisa nonaktifkan tapi tidak bisa mengaktifkan yang lain
            container.innerHTML = `
                <select name="is_show_nav" class="form-select">
                    <option value="1" selected>Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            `;
        } else {
            // Bebas mengubah
            container.innerHTML = `
                <select name="is_show_nav" class="form-select">
                    <option value="1" ${isCurrentlyActive ? 'selected' : ''}>Aktif</option>
                    <option value="0" ${!isCurrentlyActive ? 'selected' : ''}>Nonaktif</option>
                </select>
            `;
        }
        
        document.getElementById('formEdit').action = '<?= site_url('kategori/') ?>' + data.id_kategori;
        
        var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        modalEdit.show();
    }

    // --- 6. HELPER DELETE ---
    function confirmDelete(url) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data kategori dan semua berita didalamnya akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteSingleForm');
                form.action = url;
                
                // Tampilkan loading
                const loadingOverlay = document.getElementById('loadingOverlay');
                loadingOverlay.style.display = 'flex';
                
                // Submit form
                form.submit();
            }
        });
    }

    // --- 7. RESET FORM KETIKA MODAL DITUTUP ---
    document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
    });

    document.getElementById('modalEdit').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
    });

    // --- 8. VALIDASI FORM EDIT SAAT SUBMIT ---
    document.getElementById('formEdit').addEventListener('submit', function(e) {
        const activeCount = <?= $activeCount ?>;
        const maxActive = 10;
        const formData = new FormData(this);
        const isShowNav = formData.get('is_show_nav');
        const currentIsActive = document.querySelector('input[name="is_show_nav"]:checked')?.value || 
                               document.querySelector('select[name="is_show_nav"]')?.value;
        
        // Jika mencoba mengubah dari nonaktif ke aktif dan sudah mencapai limit
        if (isShowNav == '1' && currentIsActive == '0' && activeCount >= maxActive) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Batas Maksimal',
                html: `<div class="text-start">
                    <p>Tidak dapat mengaktifkan kategori.</p>
                    <p class="mb-0">Batas maksimal <strong>10 kategori aktif</strong> telah tercapai (${activeCount}/10).</p>
                    <p class="mt-2">Silakan nonaktifkan kategori lain terlebih dahulu.</p>
                </div>`,
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33',
            });
        }
    });

</script>

<?= $this->endSection() ?>