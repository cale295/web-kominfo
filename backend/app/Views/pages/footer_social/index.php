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
    
    .icon-box {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: transform 0.2s;
    }
    .icon-box:hover { transform: scale(1.1); }

    /* Styling Tambahan untuk Tabs */
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
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Social Media Footer</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-share-alt me-1 text-primary"></i> 
                Kelola tautan sosial media resmi yang tampil di footer website.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Social Media</li>
            </ol>
        </nav>
    </div>

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

    <?= $this->include('components/footer_tabs') ?>
    
    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Akun</h5>
                <span class="text-muted small">Kelola platform sosial media instansi</span>
            </div>
            
            <?php if ($can_create): ?>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Akun
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">No</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Icon</th>
                            <th class="py-3 text-uppercase">Platform & Akun</th>
                            <th class="py-3 text-uppercase">Link URL</th>
                            <th class="text-center py-3 text-uppercase" width="10%">Urutan</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($social_media)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="fas fa-globe-americas fa-4x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada data tersedia</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan akun sosial media resmi instansi Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($social_media as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <div class="icon-box bg-light shadow-sm border">
                                            <i class="fab fa-<?= esc($item['platform_icon']) ?> fs-5 text-primary"></i>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['platform_name']) ?></div>
                                        <div class="small text-muted d-flex align-items-center">
                                            <i class="fas fa-at me-1 text-secondary" style="font-size: 0.7rem;"></i>
                                            <?= esc($item['account_name']) ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <a href="<?= esc($item['account_url']) ?>" target="_blank" 
                                           class="btn btn-light btn-sm text-primary text-decoration-none border shadow-sm px-3 rounded-pill" 
                                           style="font-size: 0.8rem; max-width: 250px;" 
                                           data-bs-toggle="tooltip" title="Kunjungi Link">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            <span class="d-inline-block text-truncate align-middle" style="max-width: 150px;">
                                                <?= esc($item['account_url']) ?>
                                            </span>
                                        </a>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill font-monospace" style="font-size: 0.85rem;">
                                            <?= esc($item['sorting']) ?>
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_footer_social'], $item['is_active'], 'footer_social/toggle-status') ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                    class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center btn-edit" 
                                                    style="width: 32px; height: 32px;"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal"
                                                    data-id="<?= $item['id_footer_social'] ?>"
                                                    data-platform="<?= esc($item['platform_name']) ?>"
                                                    data-icon="<?= esc($item['platform_icon']) ?>"
                                                    data-account="<?= esc($item['account_name']) ?>"
                                                    data-url="<?= esc($item['account_url']) ?>"
                                                    data-sorting="<?= esc($item['sorting']) ?>"
                                                    title="Edit Akun">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/footer_social/<?= $item['id_footer_social'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
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
                <i class="fas fa-sort-amount-down me-2 text-primary"></i>
                <span>Gunakan kolom <strong>Urutan</strong> untuk mengatur posisi ikon di footer website.</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold text-primary" id="createModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Akun Sosial Media
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/footer_social" method="post">
                <div class="modal-body p-4">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Platform <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="platform_name" placeholder="Contoh: Instagram" value="<?= old('platform_name') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Pilih Icon <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i id="icon-preview-create" class="fab fa-instagram fs-5"></i></span>
                                    <select class="form-select" name="platform_icon" id="platform_icon_create" required onchange="updateIconPreview('create')">
                                        <option value="instagram" <?= old('platform_icon') == 'instagram' ? 'selected' : '' ?>>Instagram</option>
                                        <option value="facebook" <?= old('platform_icon') == 'facebook' ? 'selected' : '' ?>>Facebook</option>
                                        <option value="twitter" <?= old('platform_icon') == 'twitter' ? 'selected' : '' ?>>Twitter / X</option>
                                        <option value="youtube" <?= old('platform_icon') == 'youtube' ? 'selected' : '' ?>>YouTube</option>
                                        <option value="tiktok" <?= old('platform_icon') == 'tiktok' ? 'selected' : '' ?>>TikTok</option>
                                        <option value="linkedin" <?= old('platform_icon') == 'linkedin' ? 'selected' : '' ?>>LinkedIn</option>
                                        <option value="whatsapp" <?= old('platform_icon') == 'whatsapp' ? 'selected' : '' ?>>WhatsApp</option>
                                        <option value="telegram" <?= old('platform_icon') == 'telegram' ? 'selected' : '' ?>>Telegram</option>
                                        <option value="globe" <?= old('platform_icon') == 'globe' ? 'selected' : '' ?>>Website (Globe)</option>
                                    </select>
                                </div>
                                <div class="form-text small">Icon menggunakan FontAwesome Brand Icons.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Nama Akun <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted">@</span>
                                    <input type="text" class="form-control" name="account_name" placeholder="username" value="<?= old('account_name') ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Link URL <span class="text-danger">*</span></label>
                                <input type="url" class="form-control" name="account_url" placeholder="https://instagram.com/username" value="<?= old('account_url') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mt-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Urutan</label>
                                <input type="number" class="form-control" name="sorting" value="<?= old('sorting', 0) ?>">
                                <div class="form-text small">Angka kecil tampil lebih dulu.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input ms-0 me-2" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light border-bottom-0">
                <h5 class="modal-title fw-bold text-primary" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Akun Sosial Media
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post" id="form-edit">
                <div class="modal-body p-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Platform <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="platform_name" id="edit_platform_name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Pilih Icon <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i id="icon-preview-edit" class="fab fa-instagram fs-5"></i></span>
                                    <select class="form-select" name="platform_icon" id="platform_icon_edit" required onchange="updateIconPreview('edit')">
                                        <option value="instagram">Instagram</option>
                                        <option value="facebook">Facebook</option>
                                        <option value="twitter">Twitter / X</option>
                                        <option value="youtube">YouTube</option>
                                        <option value="tiktok">TikTok</option>
                                        <option value="linkedin">LinkedIn</option>
                                        <option value="whatsapp">WhatsApp</option>
                                        <option value="telegram">Telegram</option>
                                        <option value="globe">Website (Globe)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Nama Akun <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted">@</span>
                                    <input type="text" class="form-control" name="account_name" id="edit_account_name" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Link URL <span class="text-danger">*</span></label>
                                <input type="url" class="form-control" name="account_url" id="edit_account_url" required>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mt-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Urutan</label>
                                <input type="number" class="form-control" name="sorting" id="edit_sorting">
                                <div class="form-text small">Angka kecil tampil lebih dulu.</div>
                            </div>
                        </div>
                         </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi Preview Icon yang Dinamis (Bisa untuk Create maupun Edit)
    function updateIconPreview(type) {
        const select = document.getElementById(type === 'create' ? 'platform_icon_create' : 'platform_icon_edit');
        const preview = document.getElementById(type === 'create' ? 'icon-preview-create' : 'icon-preview-edit');
        const iconClass = select.value;
        
        // Reset class
        preview.className = '';
        
        // Handle 'globe' as fas (solid), others as fab (brands)
        if(iconClass === 'globe' || iconClass === 'envelope' || iconClass === 'phone') {
            preview.className = `fas fa-${iconClass} fs-5`;
        } else {
            preview.className = `fab fa-${iconClass} fs-5`;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize Icon Preview untuk Create
        updateIconPreview('create');

        // Logic untuk Mengisi Modal Edit secara Dinamis
        const editButtons = document.querySelectorAll('.btn-edit');
        const editForm = document.getElementById('form-edit');
        const editPlatform = document.getElementById('edit_platform_name');
        const editIcon = document.getElementById('platform_icon_edit');
        const editAccount = document.getElementById('edit_account_name');
        const editUrl = document.getElementById('edit_account_url');
        const editSorting = document.getElementById('edit_sorting');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil data dari atribut tombol
                const id = this.getAttribute('data-id');
                const platform = this.getAttribute('data-platform');
                const icon = this.getAttribute('data-icon');
                const account = this.getAttribute('data-account');
                const url = this.getAttribute('data-url');
                const sorting = this.getAttribute('data-sorting');

                // Isi nilai ke dalam form modal edit
                editForm.action = '/footer_social/' + id; // Update action URL
                editPlatform.value = platform;
                editIcon.value = icon;
                editAccount.value = account;
                editUrl.value = url;
                editSorting.value = sorting;

                // Update preview icon di modal edit
                updateIconPreview('edit');
            });
        });

        // Tampilkan Modal Create jika terjadi error validasi saat create (Session flash)
        <?php if(session()->has('errors') && !session()->has('edit_error')) : ?>
            var createModal = new bootstrap.Modal(document.getElementById('createModal'));
            createModal.show();
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>