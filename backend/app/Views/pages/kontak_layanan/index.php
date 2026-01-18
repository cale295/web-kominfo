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

    /* Icon Preview */
    .icon-preview-box {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background-color: #f8fafc;
        border: 1px solid #e5e7eb;
        font-size: 2.5rem;
    }

    /* Service Info */
    .service-title {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }
    .service-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
    }

    /* Link Button */
    .link-btn {
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #374151;
        font-size: 0.875rem;
    }
    .link-btn:hover {
        background-color: #e5e7eb;
        color: var(--primary-text);
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Kontak Layanan</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-headset me-1 text-primary"></i> 
                Kelola daftar layanan, icon, dan tautan kontak terkait.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Kontak Layanan</li>
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

    <?php if (session()->has('errors')) : ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-danger me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="fw-medium">
                    <strong>Perhatian:</strong>
                    <ul class="mb-0 ps-3 mt-2">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif ?>
    
    <?= $this->include('components/kontak_tabs') ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Data Layanan</h5>
                <span class="text-muted small">Icon dan tautan layanan kontak</span>
            </div>
            
            <?php if ($can_create): ?>
                <button type="button" 
                        class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalCreate">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Baru
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php if (empty($kontaklayanan)) : ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-folder-open fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada data layanan</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan data baru.</p>
                        <?php if ($can_create): ?>
                            <button type="button" 
                                    class="btn btn-primary rounded-pill px-4 mt-3 shadow-sm hover-scale" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalCreate">
                                <i class="fas fa-plus me-1"></i>Tambah Data
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3" width="25%">Judul Info</th>
                                <th class="text-center py-3" width="10%">Icon</th>
                                <th class="py-3" width="20%">Tautan / Link</th>
                                <th class="text-center py-3" width="10%">Urutan</th>
                                <th class="text-center py-3" width="10%">Status</th>
                                <th class="text-center py-3" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kontaklayanan as $i => $row) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $i + 1 ?></td>
                                    
                                    <td>
                                        <div class="service-title"><?= esc($row['judul']) ?></div>
                                        <div class="service-subtitle"><?= esc($row['subjudul']) ?></div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="d-flex justify-content-center align-items-center text-white shadow-sm rounded-circle mb-1" 
                                                 style="width: 40px; height: 40px; background-color: <?= esc($row['icon_bg_color']) ?>;">
                                                <i class="<?= esc($row['icon_class']) ?>"></i>
                                            </div>
                                            <span class="badge bg-light text-muted border px-2 py-1 rounded-pill mt-1" style="font-size: 0.6rem; font-family: monospace;">
                                                <?= esc($row['icon_class']) ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if ($row['link_url']) : ?>
                                            <a href="<?= esc($row['link_url']) ?>" 
                                               target="_blank" 
                                               class="btn btn-sm link-btn hover-scale w-100" 
                                               data-bs-toggle="tooltip" 
                                               title="<?= esc($row['link_url']) ?>">
                                                <i class="fas fa-external-link-alt me-1 small"></i> Buka Link
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border shadow-sm px-3 py-2 rounded-pill font-monospace">
                                            <?= esc($row['urutan']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($row['id_kontak_layanan'], $row['status'], 'kontak_layanan/toggle-status') ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update) : ?>
                                                <button type="button" 
                                                        class="btn-action btn-soft-warning hover-scale btn-edit" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEdit"
                                                        data-id="<?= $row['id_kontak_layanan'] ?>"
                                                        data-judul="<?= esc($row['judul']) ?>"
                                                        data-subjudul="<?= esc($row['subjudul']) ?>"
                                                        data-icon="<?= esc($row['icon_class']) ?>"
                                                        data-color="<?= esc($row['icon_bg_color']) ?>"
                                                        data-link="<?= esc($row['link_url']) ?>"
                                                        data-urutan="<?= esc($row['urutan']) ?>"
                                                        title="Edit">
                                                    <i class="fas fa-pencil-alt fa-xs"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if ($can_delete) : ?>
                                                <form action="/kontak_layanan/<?= $row['id_kontak_layanan'] ?>" 
                                                      method="post" 
                                                      class="d-inline delete-form"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                <span>Icon dan tautan layanan akan ditampilkan di halaman publik untuk kemudahan akses.</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Kontak Layanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/kontak_layanan" method="post">
                <div class="modal-body p-4">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="create_judul" class="form-label fw-semibold">
                                Judul Layanan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="create_judul" name="judul" 
                                   value="<?= old('judul') ?>" placeholder="Misal: Call Center" required maxlength="150">
                        </div>
                        <div class="col-md-6">
                            <label for="create_subjudul" class="form-label fw-semibold">Sub Judul</label>
                            <input type="text" class="form-control" id="create_subjudul" name="subjudul" 
                                   value="<?= old('subjudul') ?>" placeholder="Keterangan singkat..." maxlength="255">
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        <div class="col-md-6">
                            <label for="create_icon_class" class="form-label fw-semibold">
                                Pilih Icon <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-preview-box" id="create_iconPreviewBox">
                                    <i id="create_iconPreview" class="fas fa-icons text-muted"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <select class="form-select" id="create_icon_class" name="icon_class" required>
                                        <option value="" disabled selected>-- Pilih Icon --</option>
                                        <optgroup label="Media Sosial & Kontak">
                                            <option value="fab fa-whatsapp">WhatsApp Brand</option>
                                            <option value="fas fa-phone">Telepon (Gagang)</option>
                                            <option value="fas fa-phone-alt">Telepon (Alternative)</option>
                                            <option value="fas fa-envelope">Email / Surat</option>
                                            <option value="fab fa-telegram">Telegram</option>
                                            <option value="fab fa-instagram">Instagram</option>
                                            <option value="fab fa-facebook">Facebook</option>
                                            <option value="fas fa-globe">Website / Globe</option>
                                        </optgroup>
                                        <optgroup label="Dokumen & Download">
                                            <option value="fas fa-download">Download (Panah Bawah)</option>
                                            <option value="fas fa-file-pdf">File PDF</option>
                                            <option value="fas fa-file-alt">Dokumen Teks</option>
                                            <option value="fas fa-folder-open">Folder</option>
                                        </optgroup>
                                        <optgroup label="Layanan & Umum">
                                            <option value="fas fa-headset">Customer Service</option>
                                            <option value="fas fa-info-circle">Informasi</option>
                                            <option value="fas fa-exclamation-triangle">Peringatan / Darurat</option>
                                            <option value="fas fa-ambulance">Ambulans</option>
                                            <option value="fas fa-map-marker-alt">Lokasi / Peta</option>
                                            <option value="fas fa-bullhorn">Pengumuman</option>
                                            <option value="fas fa-user-tie">Pejabat / Petugas</option>
                                        </optgroup>
                                    </select>
                                    <div class="form-text small mt-1">Pilih icon FontAwesome</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="create_icon_bg_color" class="form-label fw-semibold">Warna Background Icon</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" class="form-control form-control-color" 
                                       id="create_colorPicker" value="<?= old('icon_bg_color', '#ffc107') ?>" 
                                       title="Pilih warna" style="width: 60px; height: 60px;">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" id="create_icon_bg_color" 
                                           name="icon_bg_color" value="<?= old('icon_bg_color', '#ffc107') ?>" 
                                           maxlength="20" placeholder="#ffc107">
                                    <div class="form-text small">Hex color code</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        <div class="col-md-8">
                            <label for="create_link_url" class="form-label fw-semibold">Link URL</label>
                            <input type="url" class="form-control" id="create_link_url" name="link_url" 
                                   value="<?= old('link_url') ?>" placeholder="https://...">
                            <div class="form-text small">Link akan terbuka di tab baru</div>
                        </div>

                        <div class="col-md-4">
                            <label for="create_urutan" class="form-label fw-semibold">Urutan</label>
                            <input type="number" class="form-control" id="create_urutan" name="urutan" 
                                   value="<?= old('urutan', 0) ?>">
                            <div class="form-text small">Angka untuk sorting</div>
                        </div>
                        
                        <div class="col-md-12">
                             <label for="create_status" class="form-label fw-semibold">Status Awal</label>
                             <select class="form-select" id="create_status" name="status">
                                <option value="aktif" selected>Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg card-modern">
            <div class="modal-header bg-warning text-white border-0">
                <h5 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i> Edit Kontak Layanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post" id="formEdit">
                <div class="modal-body p-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_judul" class="form-label fw-semibold">
                                Judul Layanan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_judul" name="judul" required maxlength="150">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_subjudul" class="form-label fw-semibold">Sub Judul</label>
                            <input type="text" class="form-control" id="edit_subjudul" name="subjudul" maxlength="255">
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        <div class="col-md-6">
                            <label for="edit_icon_class" class="form-label fw-semibold">
                                Pilih Icon <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-preview-box" id="edit_iconPreviewBox">
                                    <i id="edit_iconPreview" class="fas fa-icons text-muted"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <select class="form-select" id="edit_icon_class" name="icon_class" required>
                                        <option value="" disabled>-- Pilih Icon --</option>
                                        <optgroup label="Media Sosial & Kontak">
                                            <option value="fab fa-whatsapp">WhatsApp Brand</option>
                                            <option value="fas fa-phone">Telepon (Gagang)</option>
                                            <option value="fas fa-phone-alt">Telepon (Alternative)</option>
                                            <option value="fas fa-envelope">Email / Surat</option>
                                            <option value="fab fa-telegram">Telegram</option>
                                            <option value="fab fa-instagram">Instagram</option>
                                            <option value="fab fa-facebook">Facebook</option>
                                            <option value="fas fa-globe">Website / Globe</option>
                                        </optgroup>
                                        <optgroup label="Dokumen & Download">
                                            <option value="fas fa-download">Download (Panah Bawah)</option>
                                            <option value="fas fa-file-pdf">File PDF</option>
                                            <option value="fas fa-file-alt">Dokumen Teks</option>
                                            <option value="fas fa-folder-open">Folder</option>
                                        </optgroup>
                                        <optgroup label="Layanan & Umum">
                                            <option value="fas fa-headset">Customer Service</option>
                                            <option value="fas fa-info-circle">Informasi</option>
                                            <option value="fas fa-exclamation-triangle">Peringatan / Darurat</option>
                                            <option value="fas fa-ambulance">Ambulans</option>
                                            <option value="fas fa-map-marker-alt">Lokasi / Peta</option>
                                            <option value="fas fa-bullhorn">Pengumuman</option>
                                            <option value="fas fa-user-tie">Pejabat / Petugas</option>
                                        </optgroup>
                                    </select>
                                    <div class="form-text small mt-1">Pilih icon FontAwesome</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_icon_bg_color" class="form-label fw-semibold">Warna Background Icon</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" class="form-control form-control-color" 
                                       id="edit_colorPicker" title="Pilih warna" style="width: 60px; height: 60px;">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" id="edit_icon_bg_color" 
                                           name="icon_bg_color" maxlength="20" placeholder="#ffc107">
                                    <div class="form-text small">Hex color code</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        <div class="col-md-8">
                            <label for="edit_link_url" class="form-label fw-semibold">Link URL</label>
                            <input type="url" class="form-control" id="edit_link_url" name="link_url">
                            <div class="form-text small">Link akan terbuka di tab baru</div>
                        </div>

                        <div class="col-md-4">
                            <label for="edit_urutan" class="form-label fw-semibold">Urutan</label>
                            <input type="number" class="form-control" id="edit_urutan" name="urutan">
                            <div class="form-text small">Angka untuk sorting</div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // --- 1. Logic Modal Create ---
        const createColorPicker = document.getElementById('create_colorPicker');
        const createColorInput = document.getElementById('create_icon_bg_color');
        const createIconPreviewBox = document.getElementById('create_iconPreviewBox');
        const createIconPreview = document.getElementById('create_iconPreview');
        const createIconSelect = document.getElementById('create_icon_class');

        // Sync Color (Create)
        createColorPicker.addEventListener('input', function() {
            createColorInput.value = this.value;
            updateColorPreview(createIconPreviewBox, this.value);
        });
        
        createColorInput.addEventListener('input', function() {
            createColorPicker.value = this.value;
            updateColorPreview(createIconPreviewBox, this.value);
        });

        // Preview Icon (Create)
        createIconSelect.addEventListener('change', function() {
            createIconPreview.className = this.value || 'fas fa-icons';
        });

        // Initial color setup
        updateColorPreview(createIconPreviewBox, createColorInput.value);

        // --- 2. Logic Modal Edit ---
        const modalEdit = document.getElementById('modalEdit');
        const editColorPicker = document.getElementById('edit_colorPicker');
        const editColorInput = document.getElementById('edit_icon_bg_color');
        const editIconPreviewBox = document.getElementById('edit_iconPreviewBox');
        const editIconPreview = document.getElementById('edit_iconPreview');
        const editIconSelect = document.getElementById('edit_icon_class');
        const formEdit = document.getElementById('formEdit');

        // Saat Modal Edit Dibuka
        modalEdit.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            // Ambil data dari tombol
            const id = button.getAttribute('data-id');
            const judul = button.getAttribute('data-judul');
            const subjudul = button.getAttribute('data-subjudul');
            const icon = button.getAttribute('data-icon');
            const color = button.getAttribute('data-color');
            const link = button.getAttribute('data-link');
            const urutan = button.getAttribute('data-urutan');

            // Isi form
            formEdit.action = '/kontak_layanan/' + id;
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_subjudul').value = subjudul;
            document.getElementById('edit_link_url').value = link;
            document.getElementById('edit_urutan').value = urutan;
            
            // Set Icon
            editIconSelect.value = icon;
            editIconPreview.className = icon;
            
            // Set Color
            editColorPicker.value = color;
            editColorInput.value = color;
            updateColorPreview(editIconPreviewBox, color);
        });

        // Sync Color (Edit)
        editColorPicker.addEventListener('input', function() {
            editColorInput.value = this.value;
            updateColorPreview(editIconPreviewBox, this.value);
        });
        
        editColorInput.addEventListener('input', function() {
            editColorPicker.value = this.value;
            updateColorPreview(editIconPreviewBox, this.value);
        });

        // Preview Icon (Edit)
        editIconSelect.addEventListener('change', function() {
            editIconPreview.className = this.value;
        });

        // --- Helper Function ---
        function updateColorPreview(element, color) {
            element.style.backgroundColor = color;
            const brightness = getBrightness(color);
            element.style.color = brightness > 128 ? '#000' : '#fff';
        }

        function getBrightness(hexColor) {
            if(!hexColor) return 255; 
            const hex = hexColor.replace('#', '');
            const r = parseInt(hex.substr(0, 2), 16);
            const g = parseInt(hex.substr(2, 2), 16);
            const b = parseInt(hex.substr(4, 2), 16);
            return (r * 299 + g * 587 + b * 114) / 1000;
        }
    });
</script>

<?= $this->endSection() ?>