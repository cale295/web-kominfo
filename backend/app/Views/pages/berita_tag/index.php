<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Tag Berita</h1>
            <p class="text-muted small mb-0">Kelola label atau kategori topik berita.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Tag Berita</li>
        </ol>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tags me-2"></i>Daftar Tag
                </h6>
            </div>
            
            <?php if ($can_create ?? true): ?>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="fas fa-plus me-1"></i> Tambah Tag
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="dataTable">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="25%">Nama Tag</th>
                            <th class="py-3" width="20%">Slug</th>
                            <th class="py-3" width="20%">Info Pembuat</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tags) && is_array($tags)): ?>
                            <?php foreach ($tags as $i => $tag): ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark"><?= esc($tag['nama_tag']) ?></span>
                                    </td>
                                    
                                    <td>
                                        <code class="text-muted bg-light border rounded px-2 py-1 small"><?= esc($tag['slug']) ?></code>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex flex-column small">
                                            <span class="fw-bold text-dark">
                                                <i class="fas fa-user-circle me-1 text-secondary"></i> 
                                                <?= esc($tag['created_by_name'] ?? 'System') ?>
                                            </span>
                                            <span class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i> 
                                                <?= !empty($tag['created_at']) ? date('d M Y', strtotime($tag['created_at'])) : '-' ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button"
                                               class="btn btn-outline-warning btn-sm rounded-circle shadow-sm"
                                               data-bs-toggle="tooltip" 
                                               title="Edit"
                                               onclick="openEditModal(<?= $tag['id_tags'] ?>, '<?= esc($tag['nama_tag']) ?>')">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>

                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus"
                                                    onclick="confirmDelete('<?= site_url('berita_tag/'.$tag['id_tags']) ?>')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-tags fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada tag</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan tag baru.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Tag Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('berita_tag') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">
                            Nama Tag <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Teknologi, Olahraga, Politik" required autofocus>
                        <small class="text-muted">Masukkan nama tag yang akan digunakan untuk mengkategorikan berita.</small>
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Tag
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-bold">
                            Nama Tag <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                        <small class="text-muted">Update nama tag sesuai kebutuhan.</small>
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

<!-- Form untuk delete satuan -->
<form id="deleteForm" action="" method="post" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    
    /* Modal animations */
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Auto-show modal jika ada error validation
        <?php if (session()->get('errors') || session()->getFlashdata('error')): ?>
            <?php if (isset($tag)): ?>
                // Jika ada data tag, berarti dari edit
                openEditModal(<?= $tag['id_tags'] ?? 0 ?>, '<?= esc($tag['nama_tag'] ?? '') ?>');
            <?php else: ?>
                // Jika tidak ada data tag, berarti dari create
                var modalCreate = new bootstrap.Modal(document.getElementById('modalCreate'));
                modalCreate.show();
            <?php endif; ?>
        <?php endif; ?>
    });

    // Function untuk membuka modal edit
    function openEditModal(id, name) {
        document.getElementById('edit_name').value = name;
        document.getElementById('formEdit').action = '<?= site_url('berita_tag/') ?>' + id;
        
        var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        modalEdit.show();
    }

    // Helper Delete Satuan
    function confirmDelete(url) {
        if(confirm('Apakah Anda yakin ingin menghapus tag ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            form.submit();
        }
    }

    // Reset form ketika modal ditutup
    document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
        document.getElementById('name').value = '';
    });

    document.getElementById('modalEdit').addEventListener('hidden.bs.modal', function () {
        document.getElementById('edit_name').value = '';
    });
</script>

<?= $this->endSection() ?>