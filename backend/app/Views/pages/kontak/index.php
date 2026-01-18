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
    
    .btn-soft-info { background-color: var(--info-soft); color: var(--info-text); border: none; }
    .btn-soft-info:hover { background-color: #3b82f6; color: white; }

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
    .badge-limit {
        background-color: #f3f4f6;
        color: #6b7280;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        border: 1px solid #e5e7eb;
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

    /* Contact Info */
    .contact-name {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2px;
    }
    .contact-address {
        font-size: 0.875rem;
        color: #6b7280;
        line-height: 1.4;
    }
    .contact-phone {
        font-size: 0.875rem;
        color: #374151;
    }
    .contact-phone i {
        width: 16px;
        color: var(--primary-text);
    }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Kontak Instansi</h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-address-book me-1 text-primary"></i> 
                Kelola informasi alamat, telepon, dan peta lokasi instansi.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Kontak</li>
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

    <?= $this->include('components/kontak_tabs') ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Daftar Kontak</h5>
                <span class="text-muted small">Informasi kontak dan lokasi instansi</span>
            </div>
            
            <?php if ($can_create): ?>
                <?php if (empty($kontak)): ?>
                    <button type="button" 
                            class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalTambahKontak">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Data
                    </button>
                <?php else: ?>
                    <span class="badge-limit">
                        <i class="fas fa-check-circle me-1 text-success"></i> Data Maksimal (1/1)
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php if (empty($kontak)) : ?>
                <div class="text-center py-5">
                    <div class="py-4">
                        <div class="mb-3 opacity-25">
                            <i class="fas fa-map-marked-alt fa-4x text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-secondary">Belum ada data kontak</h6>
                        <p class="small text-muted mb-0">Silakan tambahkan informasi kontak baru.</p>
                        <?php if ($can_create): ?>
                            <button type="button" 
                                    class="btn btn-primary rounded-pill px-4 mt-3 shadow-sm hover-scale" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalTambahKontak">
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
                                <th class="py-3" width="20%">Nama Instansi</th>
                                <th class="py-3" width="25%">Alamat</th>
                                <th class="py-3" width="20%">Telepon / Fax</th>
                                <th class="text-center py-3" width="10%">Peta</th>
                                <th class="text-center py-3" width="10%">Status</th>
                                <th class="text-center py-3" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kontak as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <div class="contact-name"><?= esc($item['nama_instansi']) ?></div>
                                    </td>
                                    
                                    <td>
                                        <div class="contact-address">
                                            <?= esc($item['alamat_lengkap']) ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="contact-phone mb-1">
                                            <i class="fas fa-phone-alt me-2"></i> <?= esc($item['telepon']) ?>
                                        </div>
                                        <div class="contact-phone">
                                            <i class="fas fa-fax me-2"></i> <?= esc($item['fax']) ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if ($item['map_link']): ?>
                                            <a href="<?= esc($item['map_link']) ?>" 
                                               target="_blank" 
                                               class="btn-action btn-soft-info hover-scale"
                                               data-bs-toggle="tooltip" 
                                               title="Lihat di Google Maps">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($item['id_kontak'], $item['status'], 'kontak/toggle-status') ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                        class="btn-action btn-soft-warning hover-scale btn-edit"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEditKontak"
                                                        data-id="<?= $item['id_kontak'] ?>"
                                                        data-nama="<?= esc($item['nama_instansi']) ?>"
                                                        data-alamat="<?= esc($item['alamat_lengkap']) ?>"
                                                        data-telepon="<?= esc($item['telepon']) ?>"
                                                        data-fax="<?= esc($item['fax']) ?>"
                                                        data-map="<?= esc($item['map_link']) ?>"
                                                        data-status="<?= $item['status'] ?>"
                                                        title="Edit">
                                                    <i class="fas fa-edit fa-xs"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/kontak/<?= $item['id_kontak'] ?>" 
                                                      method="post" 
                                                      class="d-inline delete-form"
                                                      onsubmit="return confirm('Hapus data ini?');">
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
                <span>Data kontak maksimal 1 entri. Gunakan link Google Maps untuk menunjukkan lokasi.</span>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kontak -->
<div class="modal fade" id="modalTambahKontak" tabindex="-1" aria-labelledby="modalTambahKontakLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-modern border-0">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalTambahKontakLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kontak Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/kontak" method="post">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-danger border-0 border-start border-4 border-danger rounded-3 small py-2 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>
                                    <strong>Periksa kesalahan berikut:</strong>
                                    <ul class="mb-0 ps-3 mt-1">
                                        <?php foreach (session('errors') as $error) : ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Nama Instansi <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="nama_instansi" 
                                   value="<?= old('nama_instansi') ?>" 
                                   placeholder="Contoh: Dinas Pendidikan" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat_lengkap" rows="3" 
                                      placeholder="Jl. Raya No. 123..."><?= old('alamat_lengkap') ?></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telepon</label>
                            <input type="text" class="form-control" name="telepon" 
                                   value="<?= old('telepon') ?>" 
                                   placeholder="021-xxxxxxx">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fax</label>
                            <input type="text" class="form-control" name="fax" 
                                   value="<?= old('fax') ?>" 
                                   placeholder="021-xxxxxxx">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Link Google Maps</label>
                            <input type="text" class="form-control" name="map_link" 
                                   value="<?= old('map_link') ?>" 
                                   placeholder="https://maps.google.com/...">
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

<!-- Modal Edit Kontak -->
<div class="modal fade" id="modalEditKontak" tabindex="-1" aria-labelledby="modalEditKontakLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-modern border-0">
            <div class="modal-header bg-warning text-white border-0">
                <h5 class="modal-title fw-bold" id="modalEditKontakLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kontak
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditKontak" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Nama Instansi <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_nama_instansi" name="nama_instansi" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea class="form-control" id="edit_alamat_lengkap" name="alamat_lengkap" rows="3" required></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telepon</label>
                            <input type="text" class="form-control" id="edit_telepon" name="telepon" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fax</label>
                            <input type="text" class="form-control" id="edit_fax" name="fax" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Link Google Maps</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input type="url" class="form-control" id="edit_map_link" name="map_link" required>
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

        // Auto-Open Modal Tambah jika ada Error (dari create)
        <?php if (session()->has('errors') && empty($kontak)) : ?>
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahKontak'));
            myModal.show();
        <?php endif; ?>

        // Logic Populate Data ke Modal Edit
        var modalEdit = document.getElementById('modalEditKontak');
        modalEdit.addEventListener('show.bs.modal', function (event) {
            // Tombol yang diklik
            var button = event.relatedTarget;
            
            // Ambil data dari atribut data-*
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var alamat = button.getAttribute('data-alamat');
            var telepon = button.getAttribute('data-telepon');
            var fax = button.getAttribute('data-fax');
            var map = button.getAttribute('data-map');

            // Update Action Form URL
            var form = document.getElementById('formEditKontak');
            form.action = '/kontak/' + id;

            // Isi Input Fields
            document.getElementById('edit_nama_instansi').value = nama;
            document.getElementById('edit_alamat_lengkap').value = alamat;
            document.getElementById('edit_telepon').value = telepon;
            document.getElementById('edit_fax').value = fax;
            document.getElementById('edit_map_link').value = map;
        });
    });
</script>
<?= $this->endSection() ?>