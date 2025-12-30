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
    
    .icon-wrapper {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 5px;
    }

    /* Modal Styling */
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 1rem 1rem 0 0;
    }
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Layanan Utama</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-th-large me-1 text-primary"></i> 
                Kelola daftar layanan/shortcut yang tampil di halaman utama website.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Home Service</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm border-start border-4 border-success rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-success me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Berhasil!</h6>
                    <small><?= session()->getFlashdata('success') ?></small>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-danger me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
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

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Layanan</h5>
                <span class="text-muted small">Kelola shortcut aplikasi atau layanan publik</span>
            </div>
            
            <?php if ($can_create): ?>
                <?php if (count($services) >= 10): ?>
                    <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0" disabled data-bs-toggle="tooltip" title="Maksimal 10 layanan sudah tercapai">
                        <i class="fas fa-lock me-2"></i>Batas Layanan Tercapai
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Layanan (<?= count($services) ?>/10)
                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">No</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Icon</th>
                            <th class="py-3 text-uppercase" width="25%">Nama Layanan</th>
                            <th class="py-3 text-uppercase" width="25%">URL Tujuan</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Urutan</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($services)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="fas fa-concierge-bell fa-4x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada layanan</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan layanan baru untuk ditampilkan di beranda.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($services as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?php if (!empty($item['icon_image']) && file_exists($item['icon_image'])): ?>
                                                <div class="icon-wrapper shadow-sm img-hover-zoom">
                                                    <img src="<?= base_url($item['icon_image']) ?>" alt="Icon" style="width: 100%; height: 100%; object-fit: contain;">
                                                </div>
                                            <?php else: ?>
                                                <span class="badge bg-light text-secondary border rounded-pill px-3 py-2">No Icon</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['title']) ?></div>
                                        <div class="d-flex align-items-center text-muted small mt-1">
                                            <i class="far fa-clock me-1 text-secondary" style="font-size: 0.7rem;"></i>
                                            <span>Update: <?= date('d M Y', strtotime($item['updated_at'])) ?></span>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <?php if ($item['link']): ?>
                                            <a href="<?= esc($item['link']) ?>" target="_blank" 
                                               class="btn btn-light btn-sm text-primary text-decoration-none border shadow-sm px-3 rounded-pill" 
                                               style="font-size: 0.8rem; max-width: 250px;" 
                                               data-bs-toggle="tooltip" title="Kunjungi URL">
                                                <i class="fas fa-external-link-alt me-2"></i>
                                                <span class="d-inline-block text-truncate align-middle" style="max-width: 150px;">
                                                    <?= esc($item['link']) ?>
                                                </span>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">- Tidak ada link -</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill font-monospace" style="font-size: 0.85rem;">
                                            <?= esc($item['sorting']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_service'], $item['is_active'], 'home_service/toggle-status') ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button"
                                                   class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                                   style="width: 32px; height: 32px;"
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#editServiceModal"
                                                   data-id="<?= $item['id_service'] ?>"
                                                   data-title="<?= esc($item['title']) ?>"
                                                   data-link="<?= esc($item['link']) ?>"
                                                   data-sorting="<?= $item['sorting'] ?>"
                                                   data-active="<?= $item['is_active'] ?>"
                                                   data-icon="<?= !empty($item['icon_image']) ? base_url($item['icon_image']) : '' ?>"
                                                   title="Edit Layanan">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/home_service/<?= $item['id_service'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
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
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center text-muted small">
                    <i class="fas fa-sort-numeric-down me-2 text-primary"></i>
                    <span>Gunakan kolom <strong>Urutan</strong> untuk mengatur posisi tampilan layanan di halaman utama.</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge <?= count($services) >= 10 ? 'bg-danger' : 'bg-info' ?> px-3 py-2">
                        <i class="fas fa-th-large me-1"></i>
                        Total Layanan: <?= count($services) ?>/10
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Layanan -->
<div class="modal fade" id="createServiceModal" tabindex="-1" aria-labelledby="createServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="createServiceModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Layanan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/home_service" method="post" enctype="multipart/form-data" id="createServiceForm">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-4">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" placeholder="Contoh: Layanan Pengaduan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">URL Tujuan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    <input type="url" class="form-control" name="link" placeholder="https://...">
                                </div>
                                <div class="form-text">Masukkan link lengkap diawali http:// atau https://</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Urutan (Sorting)</label>
                                        <input type="number" class="form-control" name="sorting" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 pt-4">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                            <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan (Upload Icon) -->
                        <div class="col-md-5">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <label class="form-label fw-bold mb-3">Icon Layanan</label>
                                    
                                    <!-- Preview Container -->
                                    <div class="mb-3 position-relative" style="width: 150px; height: 150px; border: 2px dashed #ccc; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: #fff; overflow: hidden;">
                                        <img id="icon-preview" src="#" alt="Preview" class="d-none" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        <span id="icon-placeholder" class="text-muted small">Preview Icon</span>
                                    </div>

                                    <input class="form-control" type="file" id="icon_image" name="icon_image" accept="image/*">
                                    <div class="form-text mt-2">Format: PNG, JPG, SVG. Maks 2MB.<br>Disarankan rasio 1:1 (Persegi).</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Layanan -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editServiceModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Layanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data" id="editServiceForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="id_service" id="edit_id_service">
                
                <div class="modal-body px-4 py-4">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Layanan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="edit_title" placeholder="Contoh: Layanan Pengaduan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">URL Tujuan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    <input type="url" class="form-control" name="link" id="edit_link" placeholder="https://...">
                                </div>
                                <div class="form-text">Masukkan link lengkap diawali http:// atau https://</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Urutan (Sorting)</label>
                                        <input type="number" class="form-control" name="sorting" id="edit_sorting">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 pt-4">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                                            <label class="form-check-label fw-bold" for="edit_is_active">Status Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan (Upload Icon) -->
                        <div class="col-md-5">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                    <label class="form-label fw-bold mb-3">Icon Layanan</label>
                                    
                                    <!-- Preview Container -->
                                    <div class="mb-3 position-relative" style="width: 150px; height: 150px; border: 2px dashed #ccc; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: #fff; overflow: hidden;">
                                        <img id="edit-icon-preview" src="#" alt="Preview" class="d-none" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        <span id="edit-icon-placeholder" class="text-muted small">Preview Icon</span>
                                    </div>

                                    <input class="form-control" type="file" id="edit_icon_image" name="icon_image" accept="image/*">
                                    <div class="form-text mt-2">Format: PNG, JPG, SVG. Maks 2MB.<br>Kosongkan jika tidak ingin mengubah icon.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update Layanan
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

        // Preview Icon for Create Modal
        const iconInput = document.getElementById('icon_image');
        if (iconInput) {
            iconInput.addEventListener('change', function(e) {
                const preview = document.getElementById('icon-preview');
                const placeholder = document.getElementById('icon-placeholder');
                
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                        placeholder.classList.add('d-none');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Preview Icon for Edit Modal
        const editIconInput = document.getElementById('edit_icon_image');
        if (editIconInput) {
            editIconInput.addEventListener('change', function(e) {
                const preview = document.getElementById('edit-icon-preview');
                const placeholder = document.getElementById('edit-icon-placeholder');
                
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                        placeholder.classList.add('d-none');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Handle Edit Modal
        const editModal = document.getElementById('editServiceModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                
                // Get data from button attributes
                const id = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');
                const link = button.getAttribute('data-link');
                const sorting = button.getAttribute('data-sorting');
                const active = button.getAttribute('data-active');
                const icon = button.getAttribute('data-icon');
                
                // Fill form fields
                document.getElementById('edit_id_service').value = id;
                document.getElementById('edit_title').value = title;
                document.getElementById('edit_link').value = link || '';
                document.getElementById('edit_sorting').value = sorting;
                document.getElementById('edit_is_active').checked = active == '1';
                
                // Set existing icon preview
                const preview = document.getElementById('edit-icon-preview');
                const placeholder = document.getElementById('edit-icon-placeholder');
                if (icon) {
                    preview.src = icon;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                } else {
                    preview.src = '#';
                    preview.classList.add('d-none');
                    placeholder.classList.remove('d-none');
                }
                
                // Set form action
                document.getElementById('editServiceForm').action = '/home_service/' + id;
            });
        }

        // Reset forms when modals are closed
        const createModal = document.getElementById('createServiceModal');
        if (createModal) {
            createModal.addEventListener('hidden.bs.modal', function () {
                document.getElementById('createServiceForm').reset();
                document.getElementById('icon-preview').classList.add('d-none');
                document.getElementById('icon-placeholder').classList.remove('d-none');
            });
        }

        if (editModal) {
            editModal.addEventListener('hidden.bs.modal', function () {
                document.getElementById('editServiceForm').reset();
                document.getElementById('edit-icon-preview').classList.add('d-none');
                document.getElementById('edit-icon-placeholder').classList.remove('d-none');
            });
        }

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>

<?= $this->endSection() ?>