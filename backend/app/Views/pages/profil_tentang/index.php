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

    /* Modal Styling */
    .modal-content {
        border-radius: 15px;
        border: none;
    }
    .modal-header.bg-primary {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .modal-header.bg-warning {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    
    .hover-scale { 
        transition: transform 0.2s; 
    }
    .hover-scale:hover { 
        transform: scale(1.05); 
    }

    /* Form Control Focus */
    .form-control:focus, .form-select:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    /* Custom Badge */
    .badge-custom {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 10px;
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Profil & Tentang</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-book-open me-1 text-primary"></i> 
                Kelola konten statis seperti Visi Misi, Sejarah, dan Profil Organisasi.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Profil Tentang</li>
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

    <!-- Alert jika sudah mencapai batas maksimal -->
    <?php if (count($profils) >= 4): ?>
        <div class="alert alert-warning border-0 shadow-sm border-start border-4 border-warning rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-warning me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="fw-medium">
                    <strong>Perhatian:</strong> Batas maksimal 4 konten telah tercapai. Hapus konten yang ada untuk menambahkan yang baru.
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Konten</h5>
                <span class="text-muted small">Personil yang menjabat saat ini</span>
            </div>
            
            <?php if ($can_create && count($profils) < 4): ?>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Konten
                </button>
            <?php elseif ($can_create): ?>
                <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0" disabled>
                    <i class="fas fa-ban me-2"></i>Batas Tercapai (4/4)
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="45%">Judul & Konten</th>
                            <th class="text-center py-3 d-none d-lg-table-cell" width="10%">Status</th>
                            <th class="text-center py-3 d-none d-lg-table-cell" width="10%">Urutan</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($profils)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="fas fa-file-alt fa-4x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada konten</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan data baru (maksimal 4 konten).</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php 
                            // Limit to 4 items
                            $limitedProfils = array_slice($profils, 0, 4);
                            foreach ($limitedProfils as $index => $item) : 
                            ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['title']) ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 350px;">
                                            <?= strip_tags($item['content']) ?>
                                        </div>
                                        <div class="d-lg-none mt-2">
                                            <span class="badge bg-light text-dark border shadow-sm px-2 py-1 rounded-pill font-monospace me-2">
                                                <?= esc($item['sorting']) ?>
                                            </span>
                                            <?php if ($item['is_active']): ?>
                                                <span class="badge bg-success-soft text-success px-2 py-1 rounded-pill">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-soft text-danger px-2 py-1 rounded-pill">Nonaktif</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center d-none d-lg-table-cell">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_tentang'], $item['is_active'], 'profil_tentang/toggle-status') ?>
                                        </div>
                                    </td>
                                    <td class="text-center d-none d-lg-table-cell">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill font-monospace">
                                            <?= esc($item['sorting']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                   class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                   style="width: 32px; height: 32px;"
                                                   data-bs-toggle="tooltip" title="Edit Data"
                                                   onclick='openEditModal(<?= json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/profil_tentang/<?= $item['id_tentang'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
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
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <span>Maksimal <strong>4 konten</strong> yang dapat ditampilkan. Urutkan dengan kolom <strong>Urutan</strong>.</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Konten Profil Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/profil_tentang" method="post" id="formCreate">
                <?= csrf_field() ?>
                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <div class="border rounded p-3 bg-white h-100">
                                <h6 class="text-dark fw-bold mb-3 pb-2 border-bottom">
                                    <i class="fas fa-file-alt me-2"></i>Informasi Konten
                                </h6>
                                    
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Judul <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="title" 
                                           placeholder="Contoh: Visi & Misi Organisasi" required>
                                    <div class="form-text">Masukkan judul yang jelas dan deskriptif</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Konten Lengkap</label>
                                    <textarea class="form-control" name="content" rows="8" 
                                              placeholder="Tulis konten lengkap di sini..."></textarea>
                                    <div class="form-text">Tuliskan konten secara detail dan terstruktur</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <div class="border rounded p-3 bg-white h-100">
                                <h6 class="text-dark fw-bold mb-3 pb-2 border-bottom">
                                    <i class="fas fa-cog me-2"></i>Pengaturan
                                </h6>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Urutan</label>
                                        <input type="number" class="form-control" name="sorting" value="0" min="0">
                                        <div class="form-text small">Urutan tampil</div>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                   id="is_active_create" name="is_active" value="1" checked>
                                            <label class="form-check-label" for="is_active_create">
                                                <span class="badge bg-success badge-custom">Aktif</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-warning text-white border-0">
                <h5 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Konten Profil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data" id="formEdit">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row g-4">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <div class="border rounded p-3 bg-white h-100">
                                <h6 class="text-dark fw-bold mb-3 pb-2 border-bottom">
                                    <i class="fas fa-file-alt me-2"></i>Informasi Konten
                                </h6>
                                    
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Judul <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="title" 
                                           id="edit_title" required>
                                    <div class="form-text">Masukkan judul yang jelas dan deskriptif</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Konten Lengkap</label>
                                    <textarea class="form-control" name="content" rows="8" id="edit_content"></textarea>
                                    <div class="form-text">Tuliskan konten secara detail dan terstruktur</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <div class="border rounded p-3 bg-white h-100">
                                <h6 class="text-dark fw-bold mb-3 pb-2 border-bottom">
                                    <i class="fas fa-cog me-2"></i>Pengaturan
                                </h6>

                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold">Urutan</label>
                                        <input type="number" class="form-control" name="sorting" id="edit_sorting" min="0">
                                        <div class="form-text small">Urutan tampil</div>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label fw-semibold d-block">Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                   id="edit_is_active" name="is_active" value="1">
                                            <label class="form-check-label" for="edit_is_active">
                                                <span class="badge bg-success badge-custom" id="edit_status_badge">Aktif</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i>Update Data
                    </button>
                </div>
            </form>
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

        // Update status badge when switch changes (create)
        document.getElementById('is_active_create').addEventListener('change', function() {
            const badge = this.nextElementSibling.querySelector('.badge');
            if (this.checked) {
                badge.className = 'badge bg-success badge-custom';
                badge.textContent = 'Aktif';
            } else {
                badge.className = 'badge bg-danger badge-custom';
                badge.textContent = 'Nonaktif';
            }
        });

        // Update status badge when switch changes (edit)
        document.getElementById('edit_is_active').addEventListener('change', function() {
            const badge = document.getElementById('edit_status_badge');
            if (this.checked) {
                badge.className = 'badge bg-success badge-custom';
                badge.textContent = 'Aktif';
            } else {
                badge.className = 'badge bg-danger badge-custom';
                badge.textContent = 'Nonaktif';
            }
        });

        // Reset create form when modal is closed
        document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
            document.getElementById('formCreate').reset();
        });
    });

   
    // Open edit modal and populate data
    function openEditModal(item) {
        // Set form action
        document.getElementById('formEdit').action = '/profil_tentang/' + item.id_tentang;
        
        // Populate form fields
        document.getElementById('edit_title').value = item.title || '';
        document.getElementById('edit_sorting').value = item.sorting || 0;
        document.getElementById('edit_content').value = item.content || '';
        
        // Handle checkbox
        const checkbox = document.getElementById('edit_is_active');
        const badge = document.getElementById('edit_status_badge');
        checkbox.checked = item.is_active == 1;
        if (item.is_active == 1) {
            badge.className = 'badge bg-success badge-custom';
            badge.textContent = 'Aktif';
        } else {
            badge.className = 'badge bg-danger badge-custom';
            badge.textContent = 'Nonaktif';
        }
        
        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    }
</script>
<?= $this->endSection() ?>