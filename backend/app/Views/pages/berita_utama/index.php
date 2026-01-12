<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --success: #059669;
        --warning: #d97706;
        --info: #0284c7;
        --danger: #dc2626;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    body {
        background-color: var(--gray-50);
    }

    /* Header Styles */
    .gov-header {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        border: 1px solid var(--gray-200);
        border-left: 4px solid var(--primary);
    }

    .gov-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .gov-header h1 i {
        color: var(--primary);
        margin-right: 10px;
    }

    .action-buttons .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .action-buttons .btn-primary {
        background: var(--primary);
        border: none;
    }

    .action-buttons .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    /* Table Card */
    .table-card {
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
    }

    /* Custom Table */
    .gov-table {
        margin: 0;
    }

    .gov-table thead {
        background: var(--gray-100);
    }

    .gov-table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .gov-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
    }

    .gov-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .gov-table tbody tr:hover {
        background-color: var(--gray-50);
    }

    /* Image Thumbnails */
    .img-thumbnail {
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        padding: 4px;
        background: white;
        transition: all 0.2s;
    }

    .img-thumbnail:hover {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    /* Badges */
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
    }

    .bg-success { background-color: var(--success) !important; }
    .bg-secondary { background-color: var(--gray-500) !important; }

    /* Action Buttons in Table */
    .gov-table .btn {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
    }

    .gov-table .btn-warning {
        background: var(--warning);
        color: white;
    }

    .gov-table .btn-warning:hover {
        background: #b45309;
        transform: translateY(-1px);
    }

    .gov-table .btn-danger {
        background: var(--danger);
        color: white;
    }

    .gov-table .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }

    /* Empty State */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-500);
    }

    .no-data i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 16px;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modal-header {
        border-bottom: 1px solid var(--gray-200);
        padding: 24px 32px;
        background: var(--gray-50);
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .modal-header h5 {
        color: var(--gray-900);
        font-weight: 600;
        font-size: 1.375rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header h5 i {
        color: var(--primary);
    }

    .modal-body {
        padding: 32px;
    }

    .modal-footer {
        border-top: 1px solid var(--gray-200);
        padding: 24px 32px;
        gap: 12px;
    }

    .btn-close:focus {
        box-shadow: none;
    }

    /* Form Styles in Modal */
    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 8px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label i {
        color: var(--primary);
        font-size: 1rem;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .form-text {
        color: var(--gray-500);
        font-size: 0.8125rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-text i {
        font-size: 0.875rem;
    }

    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-left: 4px solid var(--primary);
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: start;
        gap: 12px;
    }

    .info-box i {
        color: var(--primary);
        font-size: 1.25rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .info-box-text {
        color: var(--gray-700);
        font-size: 0.875rem;
        line-height: 1.5;
    }

    .info-box-text strong {
        color: var(--gray-900);
        display: block;
        margin-bottom: 4px;
    }

    /* Preview Image */
    .preview-container {
        margin-top: 20px;
        padding: 20px;
        background: var(--gray-50);
        border-radius: 12px;
        border: 2px dashed var(--gray-300);
        text-align: center;
    }

    .preview-container img {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        border-radius: 12px;
        border: 2px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .preview-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-600);
        margin-bottom: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gov-header {
            padding: 20px;
        }
        
        .gov-header h1 {
            font-size: 1.375rem;
        }

        .gov-table thead th,
        .gov-table tbody td {
            padding: 10px 12px;
            font-size: 0.8125rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 8px;
        }

        .action-buttons .btn {
            width: 100%;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 20px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-pin-angle"></i>
                Daftar Berita Utama
            </h1>
        </div>
        <div class="action-buttons d-flex gap-2">
            <?php if (!empty($can_create) && $can_create): ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle"></i> Tambah Berita Utama
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Table Card -->
<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table gov-table mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th class="text-center" style="width: 120px;">Gambar</th>
                        <th style="min-width: 250px;">Judul Berita</th>
                        <th style="min-width: 140px;">Dibuat Oleh</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                        <th class="text-center" style="width: 140px;">Tanggal</th>
                        <th class="text-center" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($beritaUtama)): ?>
                        <?php foreach ($beritaUtama as $i => $b): ?>
                            <tr>
                                <td class="text-center">
                                    <strong><?= $i + 1 ?></strong>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($b['feat_image'])): ?>
                                        <img 
                                            src="<?= base_url($b['feat_image']) ?>" 
                                            alt="Gambar Berita" 
                                            class="img-thumbnail"
                                            style="width: 80px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= esc($b['judul']) ?></strong>
                                </td>
                                <td>
                                    <?= esc($b['created_by_name'] ?? '-') ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($b['status']): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-x-circle"></i> Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <?= date('d M Y H:i', strtotime($b['created_date'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($can_update) && $can_update): ?>
                                        <button type="button" 
                                                class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal"
                                                data-id="<?= $b['id_berita_utama'] ?>"
                                                data-id-berita="<?= $b['id_berita'] ?>"
                                                data-judul="<?= esc($b['judul']) ?>"
                                                data-image="<?= base_url($b['feat_image']) ?>"
                                                data-jenis="<?= $b['jenis'] ?>"
                                                data-status="<?= $b['status'] ?>">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($can_delete) && $can_delete): ?>
                                        <form action="<?= site_url('berita-utama/'.$b['id_berita_utama']) ?>" 
                                              method="post"
                                              class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus berita utama ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="no-data">
                                    <i class="bi bi-inbox"></i>
                                    <p class="mb-0">Belum ada berita utama</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= site_url('berita-utama') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 id="createModalLabel">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Berita Utama
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Info Box -->
                    <div class="info-box">
                        <i class="bi bi-lightbulb"></i>
                        <div class="info-box-text">
                            <strong>Petunjuk Pengisian</strong>
                            Pilih berita yang akan dijadikan berita utama. Atur jenis dan status sesuai kebutuhan.
                        </div>
                    </div>

                    <!-- SECTION: Pilih Berita -->
                    <div class="mb-4">
                        <label for="create_id_berita" class="form-label">
                            <i class="bi bi-file-text"></i>
                            Berita
                            <span class="text-danger">*</span>
                        </label>
                        <select name="id_berita" id="create_id_berita" class="form-select" required>
                            <option value="">-- Pilih Berita --</option>
                            <?php if (isset($beritas) && !empty($beritas)): ?>
                                <?php foreach ($beritas as $b): ?>
                                    <option 
                                        value="<?= $b['id_berita'] ?>" 
                                        data-image="<?= base_url($b['feat_image']) ?>">
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Pilih berita yang akan ditampilkan sebagai berita utama
                        </small>
                    </div>

                    <!-- Preview Gambar -->
                    <div id="create_preview_wrapper" class="preview-container" style="display:none;">
                        <span class="preview-label">
                            <i class="bi bi-eye"></i> Preview Gambar Berita
                        </span>
                        <img id="create_preview_image" src="" alt="Preview Gambar">
                    </div>

                    <!-- SECTION: Pengaturan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_jenis" class="form-label">
                                    <i class="bi bi-sort-numeric-down"></i>
                                    Jenis / Urutan
                                </label>
                                <input 
                                    type="number" 
                                    name="jenis" 
                                    id="create_jenis"
                                    class="form-control" 
                                    placeholder="Contoh: 1"
                                    min="1">
                                <small class="form-text">
                                    <i class="bi bi-info-circle"></i>
                                    Angka kecil akan tampil lebih dahulu (1 = headline utama)
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_status" class="form-label">
                                    <i class="bi bi-toggle-on"></i>
                                    Status Publikasi
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="create_status" class="form-select" required>
                                    <option value="1">
                                        ✓ Aktif - Ditampilkan
                                    </option>
                                    <option value="0">
                                        ✗ Nonaktif - Tidak Ditampilkan
                                    </option>
                                </select>
                                <small class="form-text">
                                    <i class="bi bi-info-circle"></i>
                                    Status publikasi berita utama
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Berita Utama
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h5 id="editModalLabel">
                        <i class="bi bi-pencil-square"></i>
                        Edit Berita Utama
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- SECTION: Pilih Berita -->
                    <div class="mb-4">
                        <label for="edit_id_berita" class="form-label">
                            <i class="bi bi-file-text"></i>
                            Berita
                            <span class="text-danger">*</span>
                        </label>
                        <select name="id_berita" id="edit_id_berita" class="form-select" required>
                            <?php if (isset($beritaList) && !empty($beritaList)): ?>
                                <?php foreach ($beritaList as $b): ?>
                                    <option 
                                        value="<?= $b['id_berita'] ?>" 
                                        data-image="<?= base_url($b['feat_image']) ?>">
                                        <?= esc($b['judul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="form-text">
                            <i class="bi bi-info-circle"></i>
                            Pilih berita yang akan ditampilkan sebagai berita utama
                        </small>
                    </div>

                    <!-- Preview Gambar -->
                    <div id="edit_preview_wrapper" class="preview-container">
                        <span class="preview-label">
                            <i class="bi bi-eye"></i> Preview Gambar Berita
                        </span>
                        <img id="edit_preview_image" src="" alt="Preview Gambar">
                    </div>

                    <!-- SECTION: Pengaturan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_jenis" class="form-label">
                                    <i class="bi bi-sort-numeric-down"></i>
                                    Jenis / Urutan
                                </label>
                                <input 
                                    type="number" 
                                    name="jenis" 
                                    id="edit_jenis"
                                    class="form-control" 
                                    placeholder="Contoh: 1"
                                    min="1">
                                <small class="form-text">
                                    <i class="bi bi-info-circle"></i>
                                    Angka kecil akan tampil lebih dahulu (1 = headline utama)
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">
                                    <i class="bi bi-toggle-on"></i>
                                    Status Publikasi
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="edit_status" class="form-select" required>
                                    <option value="1">✓ Aktif - Ditampilkan</option>
                                    <option value="0">✗ Nonaktif - Tidak Ditampilkan</option>
                                </select>
                                <small class="form-text">
                                    <i class="bi bi-info-circle"></i>
                                    Status publikasi berita utama
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Berita Utama
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Create modal image preview
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

    // Edit modal functionality
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        
        // Get data attributes
        const id = button.getAttribute('data-id');
        const idBerita = button.getAttribute('data-id-berita');
        const judul = button.getAttribute('data-judul');
        const image = button.getAttribute('data-image');
        const jenis = button.getAttribute('data-jenis');
        const status = button.getAttribute('data-status');
        
        // Update form action
        document.getElementById('editForm').action = '<?= site_url('berita-utama/') ?>' + id;
        
        // Set form values
        document.getElementById('edit_id_berita').value = idBerita;
        document.getElementById('edit_jenis').value = jenis || '';
        document.getElementById('edit_status').value = status || '1';
        
        // Set preview image
        const previewImage = document.getElementById('edit_preview_image');
        previewImage.src = image;
        
        // Find and select the correct berita option
        const selectElement = document.getElementById('edit_id_berita');
        for (let i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].value === idBerita) {
                selectElement.selectedIndex = i;
                break;
            }
        }
    });

    // Edit modal image preview
    document.getElementById('edit_id_berita').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const imageSrc = selectedOption.getAttribute('data-image');
        const previewImage = document.getElementById('edit_preview_image');
        
        if (imageSrc) {
            previewImage.src = imageSrc;
        }
    });

    // Reset create modal when closed
    document.getElementById('createModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('create_id_berita').selectedIndex = 0;
        document.getElementById('create_jenis').value = '';
        document.getElementById('create_status').value = '1';
        document.getElementById('create_preview_wrapper').style.display = 'none';
    });
</script>
<?= $this->endSection() ?>