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

    /* Action Buttons Soft */
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
    
    .icon-box {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 8px;
    }

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
            <h1 class="h3 fw-bolder mb-1 text-gradient">Manajemen Footer</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-info-circle me-1 text-primary"></i> 
                Pusat kendali informasi identitas, sosial media, dan statistik footer.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Footer OPD</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm border-start border-4 border-danger rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="icon-box bg-white text-danger me-3 shadow-sm" style="width: 32px; height: 32px;">
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
                <h5 class="fw-bold text-dark mb-0">Daftar Informasi OPD</h5>
                <span class="text-muted small">Kelola data identitas dinas/instansi</span>
            </div>
            
            <?php if ($can_create): ?>
                <?php 
                    // Logika Pengecekan Jumlah Data
                    $jumlahData = count($footer_opd);
                    $isFull = $jumlahData >= 1; 
                ?>

                <?php if ($isFull): ?>
                    <button type="button" class="btn btn-secondary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0" disabled 
                            data-bs-toggle="tooltip" title="Hanya diperbolehkan 1 data Footer. Hapus data lama untuk menambah baru.">
                        <i class="fas fa-ban me-2"></i>Data Penuh
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Data Baru
                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">#</th>
                            <th class="py-3 text-uppercase" width="25%">Identitas Website</th>
                            <th class="py-3 text-uppercase" width="25%">Kontak & Alamat</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aset Visual</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($footer_opd)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486777.png" alt="Empty" width="80" class="opacity-25 mb-3">
                                        <h6 class="fw-bold text-secondary">Belum ada data tersedia</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan data baru untuk memulai pengaturan footer.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($footer_opd as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 45px; height: 45px; min-width: 45px;">
                                                <i class="fas fa-globe text-primary fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?= esc($item['website_name']) ?></div>
                                                <div class="small text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                                    <?= esc($item['official_title']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column gap-2 small">
                                            <div class="d-flex align-items-start text-muted">
                                                <span class="icon-box bg-light text-danger shadow-sm me-2 flex-shrink-0" style="width:24px; height:24px; font-size:10px;">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </span>
                                                <span class="lh-sm"><?= esc($item['address']) ?></span>
                                            </div>
                                            <?php if($item['email']): ?>
                                                <div class="d-flex align-items-center text-muted">
                                                    <span class="icon-box bg-light text-warning shadow-sm me-2 flex-shrink-0" style="width:24px; height:24px; font-size:10px;">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <span><?= esc($item['email']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <?php 
                                            $hasImage = false;
                                            $renderImg = function($path, $title) {
                                                if (!empty($path) && file_exists($path)) {
                                                    return '<div class="position-relative" data-bs-toggle="tooltip" title="'.$title.'">
                                                                <img src="'.base_url($path).'" 
                                                                     class="img-thumbnail rounded-3 shadow-sm img-hover-zoom bg-white" 
                                                                     style="height: 40px; width: 40px; object-fit: contain; padding: 2px;">
                                                            </div>';
                                                }
                                                return '';
                                            };
                                            
                                            echo $renderImg($item['logo_cominfo'], 'Logo Kominfo');
                                            if (!empty($item['logo_cominfo']) && file_exists($item['logo_cominfo'])) $hasImage = true;
                                            ?>
                                            <?php if (!$hasImage): ?>
                                                <span class="badge bg-light text-secondary border rounded-pill px-3">Kosong</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-1">
                                                <?= btn_toggle($item['id_opd_info'], $item['is_active'], 'footer_opd/toggle-status') ?>
                                            </div>
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
                                                        data-id="<?= $item['id_opd_info'] ?>"
                                                        data-website="<?= esc($item['website_name']) ?>"
                                                        data-title="<?= esc($item['official_title']) ?>"
                                                        data-address="<?= esc($item['address']) ?>"
                                                        data-email="<?= esc($item['email']) ?>"
                                                        data-phone="<?= esc($item['phone']) ?>"
                                                        data-link-url="<?= esc($item['link_url_logo']) ?>"
                                                        data-logo-src="<?= (!empty($item['logo_cominfo']) && file_exists($item['logo_cominfo'])) ? base_url($item['logo_cominfo']) : '#' ?>"
                                                        title="Edit Data">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/footer_opd/<?= $item['id_opd_info'] ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                <i class="fas fa-shield-alt me-2 text-primary"></i>
                <span>Pastikan data berstatus <strong>"AKTIF"</strong> agar muncul di halaman depan website.</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"><i class="fas fa-plus me-1"></i> Tambah Footer OPD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/footer_opd" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="website_name" class="form-label">Nama Website <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="website_name" name="website_name" value="<?= old('website_name') ?>" required placeholder="Contoh: tangerangkota.go.id">
                        </div>
                        <div class="col-md-6">
                            <label for="official_title" class="form-label">Judul Resmi (Official Title) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="official_title" name="official_title" value="<?= old('official_title') ?>" required placeholder="Contoh: Official Website of Tangerang City Government">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>">
                        </div>
                        <div class="col-md-12 mt-3">
                             <label for="link_url_logo" class="form-label">Link Url Logo</label>
                             <input type="text" class="form-control" id="link_url_logo" name="link_url_logo" value="<?= old('link_url_logo') ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="logo_cominfo" class="form-label">Logo Kominfo</label>
                            <div class="mb-2">
                                <img id="preview_logo" src="#" alt="Preview Logo" class="d-none img-thumbnail" style="height: 100px; object-fit: contain;">
                            </div>
                            <input class="form-control" type="file" id="logo_cominfo" name="logo_cominfo" accept="image/*" onchange="previewImage(this, 'preview_logo')">
                            <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="election_badge" class="form-label">Badge Pemilu / Lainnya</label>
                            <div class="mb-2">
                                <img id="preview_badge" src="#" alt="Preview Badge" class="d-none img-thumbnail" style="height: 100px; object-fit: contain;">
                            </div>
                            <input class="form-control" type="file" id="election_badge" name="election_badge" accept="image/*" onchange="previewImage(this, 'preview_badge')">
                            <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">Status Aktif</label>
                        </div>
                    </div>

                    <div class="modal-footer px-0 pb-0 border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit me-1"></i> Edit Footer OPD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit" action="" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_website_name" class="form-label">Nama Website <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_website_name" name="website_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_official_title" class="form-label">Judul Resmi (Official Title) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_official_title" name="official_title" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_address" name="address" rows="3" required></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="edit_link_url_logo" class="form-label">Link Url Logo</label>
                            <input type="text" class="form-control" id="edit_link_url_logo" name="link_url_logo">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_logo_cominfo" class="form-label">Logo Kominfo</label>
                            <div class="mb-2 p-2 border rounded bg-light d-inline-block">
                                <img id="preview_logo_edit" src="#" alt="Preview Logo" class="img-fluid d-none" style="height: 80px; object-fit: contain;">
                                <span id="logo_placeholder_edit" class="text-muted small fst-italic">Belum ada logo</span>
                            </div>
                            <input class="form-control" type="file" id="edit_logo_cominfo" name="logo_cominfo" accept="image/*" onchange="previewImage(this, 'preview_logo_edit', 'logo_placeholder_edit')">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah logo.</div>
                        </div>
                    </div>

                    <div class="modal-footer px-0 pb-0 border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                    </div>
                </form>
            </div>
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

        // Script untuk Menangani Modal Edit (Populasi Data)
        const editButtons = document.querySelectorAll('.btn-edit');
        const formEdit = document.getElementById('formEdit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil data dari atribut tombol
                const id = this.dataset.id;
                const website = this.dataset.website;
                const title = this.dataset.title;
                const address = this.dataset.address;
                const email = this.dataset.email;
                const phone = this.dataset.phone;
                const linkUrl = this.dataset.linkUrl;
                const logoSrc = this.dataset.logoSrc;

                // Set Action Form
                formEdit.action = '/footer_opd/' + id;

                // Isi Field Input
                document.getElementById('edit_website_name').value = website;
                document.getElementById('edit_official_title').value = title;
                document.getElementById('edit_address').value = address;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_phone').value = phone;
                document.getElementById('edit_link_url_logo').value = linkUrl;

                // Handle Preview Image
                const preview = document.getElementById('preview_logo_edit');
                const placeholder = document.getElementById('logo_placeholder_edit');

                if(logoSrc && logoSrc !== '#') {
                    preview.src = logoSrc;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                } else {
                    preview.src = '#';
                    preview.classList.add('d-none');
                    placeholder.classList.remove('d-none');
                }
            });
        });
    });

    // Fungsi Preview Image Universal (Bisa dipakai Create & Edit)
    function previewImage(input, previewId, placeholderId = null) {
        const preview = document.getElementById(previewId);
        const placeholder = placeholderId ? document.getElementById(placeholderId) : null;

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none'); // Tampilkan gambar
                if(placeholder) placeholder.classList.add('d-none'); // Sembunyikan placeholder
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // Jika batal pilih, biarkan gambar lama (logic ini bisa disesuaikan)
            // Di sini kita tidak mereset src ke # agar preview gambar lama tidak hilang saat batal pilih file
        }
    }
</script>

<?= $this->endSection() ?>