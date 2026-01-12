<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Editor Custom Styling */
    .ql-toolbar-custom {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .ql-container {
        border-radius: 0 0 0.5rem 0.5rem;
        font-family: inherit;
        font-size: 0.95rem;
        background: white;
    }
    .ql-editor {
        min-height: 250px;
        max-height: 400px;
        overflow-y: auto;
    }

    /* Radio Button Custom */
    .btn-check:checked + .btn-outline-custom {
        background-color: #e8f0fe;
        border-color: #0d6efd;
        color: #0d6efd;
    }
    /* Style for Disabled Radio Label */
    .btn-check:disabled + .btn-outline-custom {
        background-color: #f2f2f2;
        border-color: #e9ecef;
        color: #adb5bd;
        opacity: 0.7;
        cursor: not-allowed;
    }
    .btn-check:disabled + .btn-outline-custom .icon-shape {
        background-color: #e9ecef !important;
        color: #adb5bd !important;
    }
    
    .hover-card:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }
    /* Disable hover effect on disabled inputs */
    .btn-check:disabled + .btn-outline-custom:hover {
        transform: none;
        box-shadow: none !important;
    }

    /* Card & Table Effects */
    .card-hover-effect {
        transition: box-shadow 0.3s ease;
    }
    .card-hover-effect:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }

    .transition-row {
        transition: all 0.2s ease;
    }
    .transition-row:hover {
        background-color: #f8f9fc;
    }

    .hover-primary:hover {
        background-color: #4e73df !important;
        color: white !important;
        border-color: #4e73df !important;
    }
    .hover-danger:hover {
        background-color: #e74a3b !important;
        color: white !important;
        border-color: #e74a3b !important;
    }

    .hover-lift {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #bac8f3;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25) !important;
        border-color: #bac8f3;
    }

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

    /* Modal Size Adjustments */
    .modal-xl-custom {
        max-width: 900px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// LOGIKA PEMBATASAN DATA (LIMIT 1 TUGAS, 1 FUNGSI)
$hasTugas = false;
$hasFungsi = false;

if (!empty($tugas_fungsi)) {
    foreach ($tugas_fungsi as $tf) {
        if ($tf['type'] == 'tugas') {
            $hasTugas = true;
        }
        if ($tf['type'] == 'fungsi') {
            $hasFungsi = true;
        }
    }
}

// Boleh tambah jika salah satu belum ada
$allowAdd = (!$hasTugas || !$hasFungsi);
?>

<div class="container-fluid px-4 py-4">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bolder">Tugas & Fungsi</h1>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-info-circle me-1 text-primary"></i>
                Kelola data tugas pokok dan fungsi organisasi (Maksimal 1 Tugas & 1 Fungsi).
            </p>
        </div>
        <ol class="breadcrumb mb-0 bg-white shadow-sm px-3 py-2 rounded-pill small border">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Tugas Fungsi</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-hover-effect">
        
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-5 col-12">
                    <div class="input-group input-group-sm shadow-sm" style="border-radius: 20px; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 ps-3 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari deskripsi tugas/fungsi...">
                    </div>
                </div>
                
                <div class="col-md-7 col-12 text-md-end text-start">
                    <?php if (isset($can_create) && $can_create): ?>
                        <?php if ($allowAdd): ?>
                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm hover-lift fw-bold" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Data
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4 shadow-sm" disabled>
                                <i class="fas fa-check-circle me-2"></i>Data Lengkap
                            </button>
                        <?php endif; ?>
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
                            <th class="py-3 border-0" width="15%">Kategori</th>
                            <th class="py-3 border-0" width="55%">Deskripsi Tugas/Fungsi</th>
                            <th class="text-center py-3 border-0" width="10%">Status</th>
                            <th class="text-center py-3 border-0" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($tugas_fungsi)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state py-4">
                                        <div class="mb-3 text-muted opacity-25">
                                            <i class="fas fa-folder-open fa-4x"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Data Kosong</h6>
                                        <p class="small text-muted mb-0">Belum ada tugas atau fungsi yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($tugas_fungsi as $index => $item) : ?>
                                <tr class="transition-row border-bottom border-light">
                                    <td class="text-center text-muted fw-bold small"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <?php if ($item['type'] == 'tugas') : ?>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-sm bg-primary bg-opacity-10 text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-clipboard-check fa-sm"></i>
                                                </div>
                                                <span class="fw-bold text-dark small">Tugas Pokok</span>
                                            </div>
                                        <?php else : ?>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-sm bg-info bg-opacity-10 text-info rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-cogs fa-sm"></i>
                                                </div>
                                                <span class="fw-bold text-dark small">Fungsi</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="text-secondary small lh-sm" style="max-height: 100px; overflow-y: auto;">
                                            <?= $item['description'] ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($item['id_tugas'], $item['is_active'], 'tugas_fungsi/toggle-status') ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?php if (isset($can_update) && $can_update): ?>
                                                <button type="button" 
                                                        class="btn btn-light text-primary btn-sm hover-primary border shadow-sm me-1 rounded btn-edit"
                                                        data-id="<?= $item['id_tugas'] ?>"
                                                        data-type="<?= $item['type'] ?>"
                                                        data-description="<?= htmlspecialchars($item['description']) ?>"
                                                        data-is-active="<?= $item['is_active'] ?>"
                                                        data-bs-toggle="tooltip" 
                                                        title="Edit Data">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if (isset($can_delete) && $can_delete): ?>
                                                <form action="/tugas_fungsi/<?= $item['id_tugas'] ?>" method="post" class="d-inline delete-form">
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
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-top border-light py-3">
                <div class="small text-muted d-flex align-items-center">
                    <i class="fas fa-list-ol me-2"></i>
                    Menampilkan total <strong><?= count($tugas_fungsi) ?></strong> data
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl-custom modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Tugas/Fungsi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/tugas_fungsi" method="POST" id="formCreate">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-4">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Deskripsi Tugas/Fungsi <span class="text-danger">*</span></label>
                            
                            <div id="toolbar-create" class="ql-toolbar-custom">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                                <select class="ql-header">
                                    <option value="1"></option>
                                    <option value="2"></option>
                                    <option value="3"></option>
                                    <option selected></option>
                                </select>
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-link"></button>
                                <button class="ql-clean"></button>
                            </div>
                            
                            <div id="editor-create" class="ql-container ql-snow">
                                <div class="ql-editor"></div>
                            </div>
                            
                            <textarea name="description" id="description-create" style="display:none;"></textarea>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Tipe Kategori <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-2">
                                    
                                    <input type="radio" class="btn-check" name="type" id="typeTugasCreate" value="tugas" 
                                        <?= $hasTugas ? 'disabled' : '' ?> 
                                        <?= (!$hasTugas) ? 'checked' : '' ?> >
                                    
                                    <label class="btn btn-outline-custom border text-start p-3 rounded-3 hover-card d-flex align-items-center" for="typeTugasCreate">
                                        <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">TUGAS POKOK</div>
                                            <div class="small text-muted">
                                                <?= $hasTugas ? '<span class="text-danger fst-italic">Data sudah ada (Limit 1)</span>' : 'Kegiatan utama organisasi' ?>
                                            </div>
                                        </div>
                                    </label>

                                    <input type="radio" class="btn-check" name="type" id="typeFungsiCreate" value="fungsi" 
                                        <?= $hasFungsi ? 'disabled' : '' ?> 
                                        <?= ($hasTugas && !$hasFungsi) ? 'checked' : '' ?> >
                                        
                                    <label class="btn btn-outline-custom border text-start p-3 rounded-3 hover-card d-flex align-items-center" for="typeFungsiCreate">
                                        <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                                            <i class="fas fa-cogs"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">FUNGSI</div>
                                            <div class="small text-muted">
                                                 <?= $hasFungsi ? '<span class="text-danger fst-italic">Data sudah ada (Limit 1)</span>' : 'Peran penunjang organisasi' ?>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-check form-switch p-0 m-0 d-flex justify-content-between align-items-center bg-light p-3 rounded-3 border">
                                <label class="form-check-label fw-bold text-gray-700" for="is_active_create">Status Aktif</label>
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input ms-0" type="checkbox" role="switch" id="is_active_create" name="is_active" value="1" checked style="float: none;">
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

<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl-custom modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-warning text-white border-0">
                <h5 class="modal-title fw-bold" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Tugas/Fungsi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="formEdit">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body px-4 py-4">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Deskripsi Tugas/Fungsi <span class="text-danger">*</span></label>
                            
                            <div id="toolbar-edit" class="ql-toolbar-custom">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                                <select class="ql-header">
                                    <option value="1"></option>
                                    <option value="2"></option>
                                    <option value="3"></option>
                                    <option selected></option>
                                </select>
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-link"></button>
                                <button class="ql-clean"></button>
                            </div>
                            
                            <div id="editor-edit" class="ql-container ql-snow">
                                <div class="ql-editor"></div>
                            </div>
                            
                            <textarea name="description" id="description-edit" style="display:none;"></textarea>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Tipe Kategori <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-2">
                                    <input type="radio" class="btn-check" name="type" id="typeTugasEdit" value="tugas">
                                    <label class="btn btn-outline-custom border text-start p-3 rounded-3 hover-card d-flex align-items-center" for="typeTugasEdit">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">TUGAS POKOK</div>
                                            <div class="small text-muted">Kegiatan utama organisasi</div>
                                        </div>
                                    </label>

                                    <input type="radio" class="btn-check" name="type" id="typeFungsiEdit" value="fungsi">
                                    <label class="btn btn-outline-custom border text-start p-3 rounded-3 hover-card d-flex align-items-center" for="typeFungsiEdit">
                                        <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 me-3">
                                            <i class="fas fa-cogs"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">FUNGSI</div>
                                            <div class="small text-muted">Peran penunjang organisasi</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-check form-switch p-0 m-0 d-flex justify-content-between align-items-center bg-light p-3 rounded-3 border">
                                <label class="form-check-label fw-bold text-gray-700" for="is_active_edit">Status Aktif</label>
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input ms-0" type="checkbox" role="switch" id="is_active_edit" name="is_active" value="1" style="float: none;">
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

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
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

        // Initialize Quill Editor for Create Modal
        var quillCreate = new Quill('#editor-create', {
            modules: {
                toolbar: '#toolbar-create'
            },
            theme: 'snow',
            placeholder: 'Tulis deskripsi tugas atau fungsi di sini...'
        });

        // Initialize Quill Editor for Edit Modal
        var quillEdit = new Quill('#editor-edit', {
            modules: {
                toolbar: '#toolbar-edit'
            },
            theme: 'snow',
            placeholder: 'Tulis deskripsi tugas atau fungsi di sini...'
        });

        // Handle Create Form Submit
        document.getElementById('formCreate').addEventListener('submit', function(e) {
            var editorHTML = quillCreate.root.innerHTML;
            var hiddenInput = document.getElementById('description-create');
            
            // Cek jika kosong atau hanya <p><br></p>
            var textContent = quillCreate.getText().trim();
            if (textContent === '' || editorHTML === '<p><br></p>') {
                e.preventDefault();
                alert('Deskripsi tidak boleh kosong!');
                return false;
            }
            
            // Set value ke hidden textarea
            hiddenInput.value = editorHTML;
            return true;
        });

        // Handle Edit Form Submit
        document.getElementById('formEdit').addEventListener('submit', function(e) {
            var editorHTML = quillEdit.root.innerHTML;
            var hiddenInput = document.getElementById('description-edit');
            
            // Cek jika kosong atau hanya <p><br></p>
            var textContent = quillEdit.getText().trim();
            if (textContent === '' || editorHTML === '<p><br></p>') {
                e.preventDefault();
                alert('Deskripsi tidak boleh kosong!');
                return false;
            }
            
            // Set value ke hidden textarea
            hiddenInput.value = editorHTML;
            return true;
        });

        // Handle Edit Button Click
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const type = this.dataset.type;
                const description = this.dataset.description;
                const isActive = this.dataset.isActive;

                // Set form action
                document.getElementById('formEdit').action = '/tugas_fungsi/' + id;

                // Set radio button
                if(type === 'tugas') {
                    document.getElementById('typeTugasEdit').checked = true;
                } else {
                    document.getElementById('typeFungsiEdit').checked = true;
                }

                // Set Quill content
                quillEdit.root.innerHTML = description;

                // Set status
                document.getElementById('is_active_edit').checked = isActive == '1';

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

        // Reset Create Form when modal is closed
        document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
            document.getElementById('formCreate').reset();
            quillCreate.root.innerHTML = '';
        });
    });
</script>
<?= $this->endSection() ?>