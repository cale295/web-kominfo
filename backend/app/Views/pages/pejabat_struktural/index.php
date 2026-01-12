<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 py-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bolder">Pejabat Struktural</h1>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-sitemap me-1 text-primary"></i>
                Kelola daftar struktur organisasi dan pejabat terkait.
            </p>
        </div>
        <ol class="breadcrumb mb-0 bg-white shadow-sm px-3 py-2 rounded-pill small border">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none fw-bold"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Pejabat Struktural</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-hover-effect">
        
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-5 col-12">
                    <div class="input-group input-group-sm shadow-sm" style="border-radius: 20px; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 ps-3 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari nama atau jabatan...">
                    </div>
                </div>
                
                <div class="col-md-7 col-12 text-md-end text-start">
                    <?php if ($can_create && count($pejabat_struktural) < 1): ?>
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm hover-lift fw-bold" data-bs-toggle="modal" data-bs-target="#modalCreate">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Data
                        </button>
                    <?php elseif (count($pejabat_struktural) >= 1): ?>
                        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4 shadow-sm" disabled>
                            <i class="fas fa-info-circle me-2"></i>Maksimal 1 Data
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr class="text-uppercase text-secondary text-xs fw-bolder" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            <th class="text-center py-3 border-0" width="5%">#</th>
                            <th class="text-center py-3 border-0" width="15%">Gambar</th>
                            <th class="py-3 border-0" width="40%">Info Struktur</th>
                            <th class="text-center py-3 border-0" width="15%">Status</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th class="text-center py-3 border-0" width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($pejabat_struktural)): ?>
                            <tr>
                                <td colspan="<?= ($can_update || $can_delete) ? 5 : 4 ?>" class="text-center py-5">
                                    <div class="empty-state py-4">
                                        <div class="mb-3 text-muted opacity-25">
                                            <i class="fas fa-sitemap fa-4x"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Data Kosong</h6>
                                        <p class="small text-muted mb-0">Belum ada pejabat struktural yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pejabat_struktural as $index => $item): ?>
                                <tr class="transition-row border-bottom border-light">
                                    <td class="text-center text-muted fw-bold small"><?= $index + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <?php if (!empty($item['image_url'])): ?>
                                            <div class="position-relative d-inline-block rounded-circle overflow-hidden shadow-sm border bg-light" style="width: 50px; height: 50px;">
                                                <img src="<?= base_url('uploads/pejabat_struktural/' . $item['image_url']) ?>" 
                                                     alt="Img" 
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        <?php else: ?>
                                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle text-muted border" style="width: 50px; height: 50px;">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['title']) ?></div>
                                        <div class="small text-muted">
                                            <i class="fas fa-id-badge me-1 text-secondary"></i>
                                            <?= esc($item['subtitle']) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($item['id_pejabat_s'], $item['is_active'], 'pejabat_struktural/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <?php if ($can_update): ?>
                                                    <button type="button" 
                                                            class="btn btn-light text-primary btn-sm hover-primary border shadow-sm me-1 rounded btn-edit"
                                                            data-id="<?= $item['id_pejabat_s'] ?>"
                                                            data-title="<?= esc($item['title']) ?>"
                                                            data-subtitle="<?= esc($item['subtitle']) ?>"
                                                            data-description="<?= esc($item['description']) ?>"
                                                            data-is-active="<?= $item['is_active'] ?>"
                                                            data-image="<?= !empty($item['image_url']) ? base_url('uploads/pejabat_struktural/' . $item['image_url']) : '' ?>"
                                                            data-bs-toggle="tooltip" 
                                                            title="Edit Data">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="<?= base_url('pejabat_struktural/' . $item['id_pejabat_s']) ?>" method="POST" class="d-inline delete-form">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="button" 
                                                                class="btn btn-light text-danger btn-sm hover-danger border shadow-sm rounded btn-delete" 
                                                                data-bs-toggle="tooltip" 
                                                                title="Hapus Data">
                                                            <i class="fas fa-trash fa-xs"></i>
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

            <div class="card-footer bg-white border-top border-light py-3">
                <div class="small text-muted d-flex align-items-center">
                    <i class="fas fa-list-ol me-2"></i>
                    Menampilkan total <strong><?= count($pejabat_struktural) ?></strong> data
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Pejabat Struktural
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pejabat_struktural') ?>" method="POST" enctype="multipart/form-data" id="formCreate">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Contoh: Daftar Pejabat Struktural" required>
                                <div class="form-text"><i class="fas fa-info-circle me-1"></i>Masukkan judul utama halaman</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub Judul</label>
                                <input type="text" name="subtitle" class="form-control" placeholder="Contoh: Dinas Komunikasi dan Informatika">
                                <div class="form-text"><i class="fas fa-info-circle me-1"></i>Sub judul sebagai keterangan tambahan</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Masukkan deskripsi singkat..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select name="is_active" class="form-select">
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload Gambar <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control" accept="image/*" id="imageCreate" required>
                                <div class="form-text">Format: JPG, PNG. Max: 5MB</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Preview:</label>
                                <div class="preview-container border rounded p-2 bg-light text-center" style="min-height: 200px;">
                                    <img id="previewCreate" src="" class="img-fluid rounded" style="max-height: 200px; display: none;">
                                    <div id="previewPlaceholder" class="d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                        <div class="text-muted">
                                            <i class="fas fa-image fa-3x mb-2 opacity-25"></i>
                                            <p class="small mb-0">Preview gambar akan muncul di sini</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light px-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-warning text-white border-0">
                <h5 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Pejabat Struktural
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="formEdit">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body px-4 py-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Halaman <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="editTitle" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub Judul</label>
                                <input type="text" name="subtitle" id="editSubtitle" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea name="description" id="editDescription" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select name="is_active" id="editStatus" class="form-select">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*" id="imageEdit">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengubah</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Preview:</label>
                                <div class="preview-container border rounded p-2 bg-light text-center" style="min-height: 200px;">
                                    <img id="previewEdit" src="" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light px-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="fas fa-save me-1"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card-hover-effect { transition: box-shadow 0.3s ease; }
    .card-hover-effect:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }

    .transition-row { transition: all 0.2s ease; }
    .transition-row:hover { background-color: #f8f9fc; }

    .hover-primary:hover { background-color: #4e73df !important; color: white !important; border-color: #4e73df !important; }
    .hover-danger:hover { background-color: #e74a3b !important; color: white !important; border-color: #e74a3b !important; }

    .hover-lift { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }

    .form-control:focus { box-shadow: none; border-color: #bac8f3; }
    .input-group:focus-within { box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25) !important; border-color: #bac8f3; }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .preview-container {
        transition: all 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Client-side Search
        const searchInput = document.getElementById('searchInput');
        if(searchInput){
            searchInput.addEventListener('keyup', function() {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#datatablesSimple tbody tr'); 
                
                rows.forEach(row => {
                    if(row.querySelector('.empty-state')) return;
                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }

        // Preview Image Create
        const imageCreate = document.getElementById('imageCreate');
        const previewCreate = document.getElementById('previewCreate');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        if(imageCreate) {
            imageCreate.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewCreate.src = event.target.result;
                        previewCreate.style.display = 'block';
                        previewPlaceholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Preview Image Edit
        const imageEdit = document.getElementById('imageEdit');
        const previewEdit = document.getElementById('previewEdit');

        if(imageEdit) {
            imageEdit.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewEdit.src = event.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Handle Edit Button Click
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const title = this.dataset.title;
                const subtitle = this.dataset.subtitle;
                const description = this.dataset.description;
                const isActive = this.dataset.isActive;
                const image = this.dataset.image;

                // Set form action
                document.getElementById('formEdit').action = '<?= base_url('pejabat_struktural/') ?>' + id;

                // Fill form fields
                document.getElementById('editTitle').value = title;
                document.getElementById('editSubtitle').value = subtitle;
                document.getElementById('editDescription').value = description;
                document.getElementById('editStatus').value = isActive;

                // Set preview image
                if(image) {
                    document.getElementById('previewEdit').src = image;
                } else {
                    document.getElementById('previewEdit').src = '';
                }

                // Show modal
                new bootstrap.Modal(document.getElementById('modalEdit')).show();
            });
        });

        // Handle Delete with Confirmation
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                if(confirm('Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
                    this.closest('.delete-form').submit();
                }
            });
        });

        // Reset form when modal is closed
        document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
            document.getElementById('formCreate').reset();
            previewCreate.style.display = 'none';
            previewPlaceholder.style.display = 'flex';
        });
    });
</script>
<?= $this->endSection() ?>