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

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Kontak Social Media</h1>
            <p class="text-muted small mb-0">Kelola tautan media sosial dan platform komunikasi lainnya. (Maksimal <?= $maxLimit ?> data)</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kontak Social</li>
        </ol>
    </div>
    
    <?= $this->include('components/kontak_tabs') ?>

    <?php if (!$canAddMore): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Batas Maksimal Tercapai!</strong> Anda sudah mencapai batas maksimal <?= $maxLimit ?> data social media. Hapus data yang ada jika ingin menambah yang baru.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-share-alt me-2"></i>Daftar Social Media
                </h6>
                <span class="badge bg-info rounded-pill">
                    <?= $currentCount ?> / <?= $maxLimit ?> data
                </span>
            </div>
            <?php if ($can_create && $canAddMore): ?>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </button>
            <?php elseif ($can_create && !$canAddMore): ?>
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" disabled>
                    <i class="fas fa-ban me-1"></i> Batas Maksimal
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
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
                        <?php if (empty($kontak_social)): ?>
                            <tr>
                                <td colspan="<?= ($can_update || $can_delete) ? 7 : 6 ?>" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-hashtag fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan akun media sosial baru (maksimal <?= $maxLimit ?> data).</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kontak_social as $index => $item): ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark"><?= esc($item['platform']) ?></span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-light text-primary border rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 32px; height: 32px;">
                                                <i class="<?= esc($item['icon_class']) ?>"></i>
                                            </div>
                                            <code class="small text-muted"><?= esc($item['icon_class']) ?></code>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="<?= esc($item['link_url']) ?>" target="_blank" class="text-decoration-none d-block text-truncate" style="max-width: 200px;" title="<?= esc($item['link_url']) ?>">
                                            <i class="fas fa-external-link-alt small me-1"></i>
                                            <?= esc($item['link_url']) ?>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border"><?= esc($item['urutan']) ?></span>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <?= btn_toggle($item['id_kontak_social'], $item['status'], 'kontak_social/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center align-items-center h-100">
                                                <?php if ($can_update): ?>
                                                    <button type="button" 
                                                            class="btn btn-outline-warning btn-sm rounded-circle shadow-sm btn-edit" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalEdit"
                                                            data-id="<?= $item['id_kontak_social'] ?>"
                                                            data-platform="<?= esc($item['platform']) ?>"
                                                            data-icon="<?= esc($item['icon_class']) ?>"
                                                            data-link="<?= esc($item['link_url']) ?>"
                                                            data-urutan="<?= esc($item['urutan']) ?>"
                                                            title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="<?= base_url('kontak_social/' . $item['id_kontak_social']) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                                data-bs-toggle="tooltip" 
                                                                title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kontak Social
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('kontak_social') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <!-- Info Box -->
                    <div class="alert alert-info d-flex align-items-start mb-4">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>Catatan:</strong><br>
                            <small>Anda dapat menambahkan maksimal <?= $maxLimit ?> akun social media. Saat ini sudah ada <?= $currentCount ?> data.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="platform" class="form-label fw-bold">
                            Nama Platform <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="platform" name="platform" value="<?= old('platform') ?>" placeholder="Contoh: Instagram Official" required>
                    </div>

                    <div class="mb-3">
                        <label for="icon_class" class="form-label fw-bold">
                            Pilih Icon <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
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
                        <label for="link_url" class="form-label fw-bold">
                            Link URL <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url" class="form-control" id="link_url" name="link_url" value="<?= old('link_url') ?>" placeholder="https://instagram.com/username" required>
                        </div>
                        <small class="text-muted">URL lengkap dengan https://</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="urutan" class="form-label fw-bold">Urutan</label>
                            <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', 0) ?>" min="0">
                            <small class="text-muted">Angka kecil tampil lebih dulu</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
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

<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kontak Social
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" action="" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_platform" class="form-label fw-bold">
                                Nama Platform <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_platform" name="platform" placeholder="Contoh: Instagram Official" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_icon_class" class="form-label fw-bold">
                                Pilih Icon <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text bg-light">
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
                        <label for="edit_link_url" class="form-label fw-bold">
                            Link URL <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url" class="form-control" id="edit_link_url" name="link_url" placeholder="https://..." required>
                        </div>
                        <small class="text-muted">Pastikan link diawali dengan http:// atau https://</small>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="edit_urutan" class="form-label fw-bold">Urutan</label>
                            <input type="number" class="form-control" id="edit_urutan" name="urutan" min="0">
                            <small class="text-muted">Angka kecil tampil lebih dulu</small>
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

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    
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
</style>

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
        // 1. Tooltip Init
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // 2. Logic Populate Modal Edit
        const editButtons = document.querySelectorAll('.btn-edit');
        const formEdit = document.getElementById('formEdit');
        const baseUrl = "<?= base_url('kontak_social') ?>"; // Base URL untuk update

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

        // 3. Logic Toggle Switch AJAX
        const toggles = document.querySelectorAll('.form-check-input[type="checkbox"]');
        const toggleBaseUrl = "<?= base_url() ?>"; 

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const url = this.dataset.url;
                
                // Tentukan nilai yang dikirim (1/0)
                const isChecked = this.checked ? 1 : 0; 
                
                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = '<?= csrf_hash() ?>';

                let formData = new FormData();
                formData.append('id', id);
                formData.append('status', isChecked);
                formData.append(csrfName, csrfHash);

                fetch(toggleBaseUrl + '/' + url, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Update Berhasil');
                    } else {
                        alert('Gagal: ' + (data.message || 'Error'));
                        this.checked = !this.checked; // Kembalikan posisi jika error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal koneksi server');
                    this.checked = !this.checked;
                });
            });
        });

        // 4. Reset form when modal closed
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