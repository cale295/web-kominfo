<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 gap-3">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Profil & Tentang</h1>
            <p class="text-muted small mb-0">Kelola konten statis seperti Visi Misi, Sejarah, dan Profil Organisasi.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Profil Tentang</li>
        </ol>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2 fs-5"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-book-open me-2"></i>Daftar Konten</h6>
            <?php if ($can_create): ?>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="fas fa-plus me-1"></i> Tambah Konten
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
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
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-file-alt fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada konten</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan data baru.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($profils as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['title']) ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 350px;">
                                            <?= strip_tags($item['content']) ?>
                                        </div>
                                        <div class="d-lg-none mt-2">
                                            <span class="badge bg-secondary me-1">Urutan: <?= esc($item['sorting']) ?></span>
                                            <?php if ($item['is_active']): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Nonaktif</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center d-none d-lg-table-cell">
                                        <?= btn_toggle($item['id_tentang'], $item['is_active'], 'profil_tentang/toggle-status') ?>
                                    </td>
                                    <td class="text-center d-none d-lg-table-cell">
                                        <span class="badge bg-light text-dark border"><?= esc($item['sorting']) ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 gap-sm-2 justify-content-center flex-wrap">
                                            <?php if ($can_update): ?>
                                                <button type="button" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" 
                                                        data-bs-toggle="tooltip" title="Edit"
                                                        onclick='openEditModal(<?= json_encode($item, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/profil_tentang/<?= $item['id_tentang'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
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
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg">
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
                                                <span class="badge bg-success">Aktif</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
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
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Konten Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                <span class="badge bg-success" id="edit_status_badge">Aktif</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save me-1"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-scale { 
        transition: all 0.3s ease; 
    }
    .hover-scale:hover { 
        transform: scale(1.05); 
    }
    
    .modal-content {
        border-radius: 15px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    /* Scrollbar Styling */
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }
    
    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    
    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    @media (max-width: 991px) {
        .modal-xl {
            max-width: 95%;
        }
        
        .modal-body {
            max-height: 60vh !important;
        }
    }
    
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-body {
            padding: 1rem !important;
            max-height: 65vh !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Update status badge when switch changes (create)
        document.getElementById('is_active_create').addEventListener('change', function() {
            const badge = this.nextElementSibling.querySelector('.badge');
            if (this.checked) {
                badge.className = 'badge bg-success';
                badge.textContent = 'Aktif';
            } else {
                badge.className = 'badge bg-danger';
                badge.textContent = 'Nonaktif';
            }
        });

        // Update status badge when switch changes (edit)
        document.getElementById('edit_is_active').addEventListener('change', function() {
            const badge = document.getElementById('edit_status_badge');
            if (this.checked) {
                badge.className = 'badge bg-success';
                badge.textContent = 'Aktif';
            } else {
                badge.className = 'badge bg-danger';
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
            badge.className = 'badge bg-success';
            badge.textContent = 'Aktif';
        } else {
            badge.className = 'badge bg-danger';
            badge.textContent = 'Nonaktif';
        }
        
    
        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('modalEdit'));
        modal.show();
    }
</script>
<?= $this->endSection() ?>