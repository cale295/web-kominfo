<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Berita Utama</h1>
            <p class="text-muted small mb-0">Kelola berita yang ditampilkan di halaman utama.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Berita Utama</li>
        </ol>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-newspaper me-2"></i>Daftar Berita Utama
                </h6>
            </div>
                
                <?php if (!empty($can_create) && $can_create): ?>
                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                        <i class="fas fa-plus me-1"></i> Tambah Berita Utama
                    </button>
                <?php endif; ?>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable">
                        <thead class="bg-light text-secondary text-uppercase small fw-bold">
                            <tr>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="text-center py-3" width="10%">Gambar</th>
                                <th class="py-3" width="25%">Judul Berita</th>
                                <th class="py-3" width="15%">Dibuat Oleh</th>
                                <th class="text-center py-3" width="10%">Urutan</th>
                                <th class="text-center py-3" width="10%">Status</th>
                                <th class="text-center py-3" width="10%">Tanggal</th>
                                <th class="text-center py-3" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($beritaUtama)): ?>
                                <?php foreach ($beritaUtama as $i => $b): ?>
                                    <tr>
                                        <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                                        
                                        <td class="text-center">
                                            <?php if (!empty($b['feat_image'])): ?>
                                                <img src="<?= base_url($b['feat_image']) ?>" 
                                                     alt="Gambar Berita" 
                                                     class="img-thumbnail rounded"
                                                     style="width: 60px; height: 45px; object-fit: cover; cursor: pointer;"
                                                     onclick="showImagePreview('<?= base_url($b['feat_image']) ?>')">
                                            <?php else: ?>
                                                <span class="text-muted small">
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td>
                                            <span class="fw-bold text-dark"><?= esc($b['judul']) ?></span>
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex flex-column small">
                                                <span class="fw-bold text-dark">
                                                    <i class="fas fa-user-circle me-1 text-secondary"></i> 
                                                    <?= esc($b['created_by_name'] ?? 'System') ?>
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            <span class="badge bg-info text-white rounded-pill">
                                                <i class="fas fa-sort-numeric-down"></i> <?= $b['jenis'] ?? '-' ?>
                                            </span>
                                        </td>
                                        
                                        <td class="text-center">
                                            <?php if ($b['status']): ?>
                                                <span class="badge bg-success rounded-pill">
                                                    <i class="fas fa-check-circle"></i> Aktif
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary rounded-pill">
                                                    <i class="fas fa-times-circle"></i> Nonaktif
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="text-center small text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?= date('d M Y', strtotime($b['created_date'])) ?>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <?php if (!empty($can_update) && $can_update): ?>
                                                    <button type="button"
                                                            class="btn btn-outline-warning btn-sm rounded-circle shadow-sm"
                                                            data-bs-toggle="tooltip" 
                                                            title="Edit"
                                                            onclick="openEditModal(<?= $b['id_berita_utama'] ?>, <?= $b['id_berita'] ?>, '<?= esc($b['judul']) ?>', '<?= base_url($b['feat_image']) ?>', <?= $b['jenis'] ?? 0 ?>, <?= $b['status'] ?>)">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if (!empty($can_delete) && $can_delete): ?>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Hapus"
                                                            onclick="confirmDelete('<?= site_url('berita-utama/'.$b['id_berita_utama']) ?>')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted opacity-50 mb-2">
                                            <i class="fas fa-newspaper fa-3x"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada berita utama</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan berita utama baru.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Berita Utama
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('berita-utama') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <!-- Info Box -->
                    <div class="alert alert-info d-flex align-items-start mb-4">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>Petunjuk Pengisian</strong><br>
                            <small>Pilih berita yang akan dijadikan berita utama. Atur urutan dan status sesuai kebutuhan.</small>
                        </div>
                    </div>

                    <!-- Pilih Berita -->
                    <div class="mb-4">
                        <label for="create_id_berita" class="form-label fw-bold">
                            <i class="fas fa-newspaper me-1"></i>
                            Pilih Berita <span class="text-danger">*</span>
                        </label>
                        <select name="id_berita" id="create_id_berita" class="form-select" required>
                            <option value="">-- Pilih Berita --</option>
                            <?php if (isset($beritas) && !empty($beritas)): ?>
                                <?php foreach ($beritas as $b): ?>
                                    <option value="<?= $b['id_berita'] ?>" data-image="<?= base_url($b['feat_image']) ?>">
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">
                            <i class="fas fa-lightbulb me-1"></i>
                            Pilih berita yang akan ditampilkan sebagai berita utama
                        </small>
                    </div>

                    <!-- Preview Gambar -->
                    <div id="create_preview_wrapper" class="text-center mb-4 p-3 bg-light rounded border" style="display:none;">
                        <span class="d-block fw-bold text-secondary mb-2">
                            <i class="fas fa-eye me-1"></i> Preview Gambar Berita
                        </span>
                        <img id="create_preview_image" src="" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                    </div>

                    <!-- Pengaturan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_jenis" class="form-label fw-bold">
                                    <i class="fas fa-sort-numeric-down me-1"></i>
                                    Urutan Tampilan
                                </label>
                                <input type="number" name="jenis" id="create_jenis" class="form-control" placeholder="Contoh: 1" min="1">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Angka kecil tampil lebih dahulu (1 = headline utama)
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_status" class="form-label fw-bold">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Status Publikasi <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="create_status" class="form-select" required>
                                    <option value="1">✓ Aktif - Ditampilkan</option>
                                    <option value="0">✗ Nonaktif - Tidak Ditampilkan</option>
                                </select>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Status publikasi berita utama
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Berita Utama
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <!-- Pilih Berita -->
                    <div class="mb-4">
                        <label for="edit_id_berita" class="form-label fw-bold">
                            <i class="fas fa-newspaper me-1"></i>
                            Pilih Berita <span class="text-danger">*</span>
                        </label>
                        <select name="id_berita" id="edit_id_berita" class="form-select" required>
                            <?php if (isset($beritaList) && !empty($beritaList)): ?>
                                <?php foreach ($beritaList as $b): ?>
                                    <option value="<?= $b['id_berita'] ?>" data-image="<?= base_url($b['feat_image']) ?>">
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">
                            <i class="fas fa-lightbulb me-1"></i>
                            Pilih berita yang akan ditampilkan sebagai berita utama
                        </small>
                    </div>

                    <!-- Preview Gambar -->
                    <div id="edit_preview_wrapper" class="text-center mb-4 p-3 bg-light rounded border">
                        <span class="d-block fw-bold text-secondary mb-2">
                            <i class="fas fa-eye me-1"></i> Preview Gambar Berita
                        </span>
                        <img id="edit_preview_image" src="" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                    </div>

                    <!-- Pengaturan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_jenis" class="form-label fw-bold">
                                    <i class="fas fa-sort-numeric-down me-1"></i>
                                    Urutan Tampilan
                                </label>
                                <input type="number" name="jenis" id="edit_jenis" class="form-control" placeholder="Contoh: 1" min="1">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Angka kecil tampil lebih dahulu (1 = headline utama)
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label fw-bold">
                                    <i class="fas fa-toggle-on me-1"></i>
                                    Status Publikasi <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="edit_status" class="form-select" required>
                                    <option value="1">✓ Aktif - Ditampilkan</option>
                                    <option value="0">✗ Nonaktif - Tidak Ditampilkan</option>
                                </select>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Status publikasi berita utama
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview Image -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="imagePreviewModalLabel">
                    <i class="fas fa-image me-2"></i>Preview Gambar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="preview_full_image" src="" alt="Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Form untuk delete satuan -->
<form id="deleteForm" action="" method="post" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    .form-check-input { cursor: pointer; }
    
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }
    
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
    }
    
    .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
    }
    
    .img-thumbnail {
        transition: all 0.2s;
    }
    
    .img-thumbnail:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
</style>

<script>
    // Tooltip
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // Create Modal Preview
    document.getElementById('create_id_berita').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const imageSrc = selectedOption.getAttribute('data-image');
        const previewWrapper = document.getElementById('create_preview_wrapper');
        const previewImage = document.getElementById('create_preview_image');
        
        if (imageSrc && selectedOption.value) {
            previewImage.src = imageSrc;
            previewWrapper.style.display = 'block';
        } else {
            previewWrapper.style.display = 'none';
        }
    });

    // Edit Modal Function
    function openEditModal(id, idBerita, judul, image, jenis, status) {
        document.getElementById('formEdit').action = '<?= site_url('berita-utama/') ?>' + id;
        document.getElementById('edit_id_berita').value = idBerita;
        document.getElementById('edit_jenis').value = jenis || '';
        document.getElementById('edit_status').value = status || '1';
        document.getElementById('edit_preview_image').src = image;
        
        var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        modalEdit.show();
    }

    // Edit Modal Preview
    document.getElementById('edit_id_berita').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const imageSrc = selectedOption.getAttribute('data-image');
        const previewImage = document.getElementById('edit_preview_image');
        
        if (imageSrc) {
            previewImage.src = imageSrc;
        }
    });

    // Show Full Image Preview
    function showImagePreview(imageSrc) {
        document.getElementById('preview_full_image').src = imageSrc;
        var imageModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        imageModal.show();
    }

    // Delete Function
    function confirmDelete(url) {
        if(confirm('Apakah Anda yakin ingin menghapus berita utama ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            form.submit();
        }
    }

    // Reset forms on modal close
    document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
        document.getElementById('create_id_berita').selectedIndex = 0;
        document.getElementById('create_jenis').value = '';
        document.getElementById('create_status').value = '1';
        document.getElementById('create_preview_wrapper').style.display = 'none';
    });

    document.getElementById('modalEdit').addEventListener('hidden.bs.modal', function () {
        document.getElementById('edit_id_berita').selectedIndex = 0;
        document.getElementById('edit_jenis').value = '';
        document.getElementById('edit_status').value = '1';
    });
</script>

<?= $this->endSection() ?>