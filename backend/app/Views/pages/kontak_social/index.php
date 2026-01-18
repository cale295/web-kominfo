<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<?php
// DEFINISI ARRAY ICON (Dipakai di Create & Edit Modal)
$socialIcons = [
    'fab fa-facebook'       => 'Facebook',
    'fab fa-facebook-f'     => 'Facebook (F)',
    'fab fa-twitter'        => 'Twitter',
    'fab fa-instagram'      => 'Instagram',
    'fab fa-linkedin'       => 'LinkedIn',
    'fab fa-linkedin-in'    => 'LinkedIn (In)',
    'fab fa-youtube'        => 'YouTube',
    'fab fa-tiktok'         => 'TikTok',
    'fab fa-whatsapp'       => 'WhatsApp',
    'fab fa-telegram'       => 'Telegram',
    'fab fa-pinterest'      => 'Pinterest',
    'fab fa-github'         => 'Github',
    'fas fa-globe'          => 'Website (Globe)',
    'fas fa-envelope'       => 'Email',
    'fas fa-phone'          => 'Telepon',
    'fas fa-map-marker-alt' => 'Lokasi/Map',
];

// Hitung jumlah data yang sudah ada
$currentCount = count($kontak_social ?? []);
$maxLimit = 4;
$canAddMore = $currentCount < $maxLimit;
?>

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

    /* Badge Styling */
    .badge-count {
        background-color: var(--info-soft);
        color: var(--info-text);
        font-weight: 600;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
    }
    .badge-urutan {
        background-color: #f3f4f6;
        color: #374151;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        border: 1px solid #e5e7eb;
    }

    /* Icon Display */
    .icon-display {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-soft);
        color: var(--primary-text);
        font-size: 1rem;
    }
    .icon-code {
        font-size: 0.75rem;
        color: #6b7280;
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

    /* Link Styling */
    .link-truncate {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Kontak Social Media</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-share-alt me-1 text-primary"></i> 
                Kelola tautan media sosial dan platform komunikasi (maksimal <?= $maxLimit ?> data).
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Kontak Social</li>
            </ol>
        </nav>
    </div>

    <?php if (!$canAddMore): ?>
        <div class="alert alert-warning border-0 shadow-sm border-start border-4 border-warning rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-warning me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="fw-medium">
                    <strong>Batas Maksimal Tercapai!</strong> Anda sudah mencapai batas maksimal <?= $maxLimit ?> data social media. Hapus data yang ada jika ingin menambah yang baru.
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?= $this->include('components/kontak_tabs') ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Daftar Social Media</h5>
                    <span class="text-muted small">Akun media sosial dan platform komunikasi</span>
                </div>
                <span class="badge-count">
                    <?= $currentCount ?> / <?= $maxLimit ?> data
                </span>
            </div>
            
            <?php if ($can_create && $canAddMore): ?>
                <button type="button" 
                        class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalCreate">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Baru
                </button>
            <?php elseif ($can_create && !$canAddMore): ?>
                <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                    <i class="fas fa-ban me-1 text-secondary"></i> Batas Maksimal
                </span>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php if (empty($kontak_social)): ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-hashtag fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada data</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan akun media sosial baru (maksimal <?= $maxLimit ?> data).</p>
                        <?php if ($can_create && $canAddMore): ?>
                            <button type="button" 
                                    class="btn btn-primary rounded-pill px-4 mt-3 shadow-sm hover-scale" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalCreate">
                                <i class="fas fa-plus me-1"></i>Tambah Data
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3" width="15%">Platform</th>
                                <th class="py-3" width="15%">Icon Class</th>
                                <th class="py-3" width="25%">Link URL</th>
                                <th class="text-center py-3" width="10%">Urutan</th>
                                <th class="text-center py-3" width="10%">Status</th>
                                <?php if ($can_update || $can_delete): ?>
                                    <th class="text-center py-3" width="10%">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kontak_social as $index => $item): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark"><?= esc($item['platform']) ?></span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="icon-display">
                                                <i class="<?= esc($item['icon_class']) ?>"></i>
                                            </div>
                                            <span class="icon-code"><?= esc($item['icon_class']) ?></span>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="<?= esc($item['link_url']) ?>" 
                                           target="_blank" 
                                           class="text-decoration-none link-truncate"
                                           data-bs-toggle="tooltip" 
                                           title="<?= esc($item['link_url']) ?>">
                                            <i class="fas fa-external-link-alt small me-1"></i>
                                            <?= esc($item['link_url']) ?>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge-urutan"><?= esc($item['urutan']) ?></span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_kontak_social'], $item['status'], 'kontak_social/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <?php if ($can_update): ?>
                                                    <button type="button" 
                                                            class="btn-action btn-soft-warning hover-scale btn-edit" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEdit"
                                                            data-id="<?= $item['id_kontak_social'] ?>"
                                                            data-platform="<?= esc($item['platform']) ?>"
                                                            data-icon="<?= esc($item['icon_class']) ?>"
                                                            data-link="<?= esc($item['link_url']) ?>"
                                                            data-urutan="<?= esc($item['urutan']) ?>"
                                                            data-bs-toggle="tooltip"
                                                            title="Edit Data">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="<?= base_url('kontak_social/' . $item['id_kontak_social']) ?>" 
                                                          method="POST" 
                                                          class="d-inline delete-form"
                                                          onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" 
                                                                class="btn-action btn-soft-danger hover-scale"
                                                                data-bs-toggle="tooltip" 
                                                                title="Hapus Permanen">
                                                            <i class="fas fa-trash-alt fa-xs"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
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
                <span>Maksimal <?= $maxLimit ?> data social media. Urutan menentukan tampilan di halaman publik.</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kontak Social
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('kontak_social') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <!-- Info Box -->
                    <div class="alert alert-info border-0 border-start border-4 border-info rounded-3 mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <strong>Catatan:</strong>
                                <div class="small">Anda dapat menambahkan maksimal <?= $maxLimit ?> akun social media. Saat ini sudah ada <?= $currentCount ?> data.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="platform" class="form-label fw-semibold">
                            Nama Platform <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="platform" name="platform" 
                               value="<?= old('platform') ?>" 
                               placeholder="Contoh: Instagram Official" required>
                    </div>

                    <div class="mb-3">
                        <label for="icon_class" class="form-label fw-semibold">
                            Pilih Icon <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border">
                                <i id="create-icon-preview" class="<?= old('icon_class', 'fas fa-icons') ?>"></i>
                            </span>
                            
                            <select class="form-select" id="create_icon_class" name="icon_class" required onchange="updateIconPreview(this, 'create-icon-preview')">
                                <option value="">-- Pilih Icon --</option>
                                <?php foreach ($socialIcons as $class => $label): ?>
                                    <option value="<?= $class ?>" <?= old('icon_class') == $class ? 'selected' : '' ?>>
                                        <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <small class="text-muted">Pilih icon yang sesuai dengan platform.</small>
                    </div>

                    <div class="mb-3">
                        <label for="link_url" class="form-label fw-semibold">
                            Link URL <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url" class="form-control" id="link_url" name="link_url" 
                                   value="<?= old('link_url') ?>" 
                                   placeholder="https://instagram.com/username" required>
                        </div>
                        <small class="text-muted">URL lengkap dengan https://</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="urutan" class="form-label fw-semibold">Urutan</label>
                            <input type="number" class="form-control" id="urutan" name="urutan" 
                                   value="<?= old('urutan', 0) ?>" min="0">
                            <small class="text-muted">Angka kecil tampil lebih dulu</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-warning text-white border-0">
                <h5 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kontak Social
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_platform" class="form-label fw-semibold">
                                Nama Platform <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_platform" name="platform" 
                                   placeholder="Contoh: Instagram Official" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_icon_class" class="form-label fw-semibold">
                                Pilih Icon <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text bg-light border">
                                    <i id="edit-icon-preview" class="fas fa-icons"></i>
                                </div>
                                <select class="form-select" id="edit_icon_class" name="icon_class" required onchange="updateIconPreview(this, 'edit-icon-preview')">
                                    <option value="">-- Pilih Icon --</option>
                                    <?php foreach ($socialIcons as $class => $label): ?>
                                        <option value="<?= $class ?>">
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_link_url" class="form-label fw-semibold">
                            Link URL <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url" class="form-control" id="edit_link_url" name="link_url" 
                                   placeholder="https://..." required>
                        </div>
                        <small class="text-muted">Pastikan link diawali dengan http:// atau https://</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_urutan" class="form-label fw-semibold">Urutan</label>
                            <input type="number" class="form-control" id="edit_urutan" name="urutan" min="0">
                            <small class="text-muted">Angka kecil tampil lebih dulu</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
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

<script>
    // Fungsi Global untuk Preview Icon
    function updateIconPreview(selectElement, previewId) {
        var iconClass = selectElement.value;
        // Jika belum pilih, set icon default
        if(iconClass === "") iconClass = "fas fa-icons";
        
        var previewIcon = document.getElementById(previewId);
        if(previewIcon) {
            previewIcon.className = iconClass;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Logic Populate Modal Edit
        const editButtons = document.querySelectorAll('.btn-edit');
        const formEdit = document.getElementById('formEdit');
        const baseUrl = "<?= base_url('kontak_social') ?>";

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Ambil data dari atribut tombol
                const id = this.dataset.id;
                const platform = this.dataset.platform;
                const icon = this.dataset.icon;
                const link = this.dataset.link;
                const urutan = this.dataset.urutan;

                // Update URL Action Form
                formEdit.action = baseUrl + '/' + id;

                // Isi Field Input Modal Edit
                document.getElementById('edit_platform').value = platform;
                document.getElementById('edit_link_url').value = link;
                document.getElementById('edit_urutan').value = urutan;
                
                // Handle Select Icon
                const iconSelect = document.getElementById('edit_icon_class');
                iconSelect.value = icon;
                
                // Jika icon custom (tidak ada di list), tambahkan opsi sementara dan pilih
                if(icon && !iconSelect.value) {
                    let option = new Option("Custom (" + icon + ")", icon, true, true);
                    iconSelect.add(option);
                }

                // Trigger update preview icon di modal edit
                updateIconPreview(iconSelect, 'edit-icon-preview');
            });
        });

        // Reset form when modal closed
        document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
            this.querySelector('form').reset();
            document.getElementById('create-icon-preview').className = 'fas fa-icons';
        });

        document.getElementById('modalEdit').addEventListener('hidden.bs.modal', function () {
            this.querySelector('form').reset();
            document.getElementById('edit-icon-preview').className = 'fas fa-icons';
        });
    });
</script>

<?= $this->endSection() ?>