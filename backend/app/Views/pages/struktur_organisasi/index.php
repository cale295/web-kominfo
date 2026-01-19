<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
    /* Styling Editor Quill */
    #editor-container-create, #editor-container-edit { 
        height: 250px; 
        font-family: inherit; 
        font-size: 0.95rem; 
    }
    .ql-toolbar { 
        border-top-left-radius: 0.375rem; 
        border-top-right-radius: 0.375rem; 
        background: #f8f9fa;
    }
    .ql-container { 
        border-bottom-left-radius: 0.375rem; 
        border-bottom-right-radius: 0.375rem; 
    }
    
    /* Tweaking Select2 */
    .select2-container .select2-selection--single {
        height: 38px !important; 
        display: flex;
        align-items: center;
    }
    
    /* Styling Visual Tree di Dropdown */
    .level-0 { font-weight: 700; color: #2c3e50; } 
    .level-1 { font-weight: 500; color: #444; }    
    .level-2 { color: #666; font-size: 0.95em; }    
    .level-deep { color: #888; font-size: 0.9em; font-style: italic; }

    /* Modal Custom Styling */
    .modal-content {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .modal-header {
        background: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
        border-radius: 10px 10px 0 0;
        padding: 1.25rem 1.5rem;
    }
    
    .modal-header .modal-title {
        color: #5a5c69;
        font-weight: 600;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .form-control, .form-select {
        border: 1px solid #d1d3e2;
        border-radius: 5px;
        padding: 0.625rem 0.875rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }
    
    .info-box {
        background: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-radius: 5px;
        padding: 1rem;
    }
    
    .info-box .icon {
        width: 38px;
        height: 38px;
        background: #4e73df;
        color: white;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    /* Card Styling */
    .card-hover-effect { transition: box-shadow 0.3s ease; }
    .card-hover-effect:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }

    .transition-row { transition: all 0.2s ease; }
    .transition-row:hover { background-color: #f8f9fc; }

    .hover-primary:hover { background-color: #4e73df !important; color: white !important; border-color: #4e73df !important; }
    .hover-danger:hover { background-color: #e74a3b !important; color: white !important; border-color: #e74a3b !important; }

    .hover-lift { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }

    .input-group:focus-within { box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25) !important; border-color: #bac8f3; }
    
    /* Style untuk indikator deskripsi */
    .deskripsi-info {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 4px;
        margin-top: 5px;
    }
    .deskripsi-info-normal {
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #e9ecef;
    }
    .deskripsi-info-child {
        background-color: #e7f4ff;
        color: #0066cc;
        border: 1px solid #b3d9ff;
    }
    .deskripsi-info-parent {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    /* Style untuk tampilan deskripsi di tabel */
    .deskripsi-preview {
        max-height: 60px;
        overflow: hidden;
        position: relative;
    }
    .deskripsi-preview::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(to bottom, transparent, #f8f9fc);
    }
    .deskripsi-empty {
        color: #999;
        font-style: italic;
        font-size: 0.85rem;
    }
    
    /* Style untuk deskripsi yang tersembunyi */
    .deskripsi-hidden {
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 5px;
        padding: 15px;
        text-align: center;
        color: #6c757d;
        font-style: italic;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// --- LOGIKA SORTING HIERARKI (TREE) ---
$hierarchicalData = [];
$parents = []; // Untuk dropdown parent

if (!empty($struktur)) {
    $grouped = [];
    $roots   = [];

    foreach ($struktur as $row) {
        $pid = $row['parent_id'];
        if (empty($pid)) {
            $roots[] = $row;
        } else {
            $grouped[$pid][] = $row;
        }
    }

    function buildFlatTree($nodes, &$grouped, $depth = 0) {
        $result = [];
        foreach ($nodes as $node) {
            $node['depth'] = $depth;
            $result[] = $node;

            if (isset($grouped[$node['id_struktur']])) {
                $children = buildFlatTree($grouped[$node['id_struktur']], $grouped, $depth + 1);
                $result = array_merge($result, $children);
            }
        }
        return $result;
    }

    $hierarchicalData = buildFlatTree($roots, $grouped);
    
    // Copy hierarchicalData ke parents untuk dropdown (semua data untuk dropdown)
    $parents = $hierarchicalData;
}
?>

<div class="container-fluid px-4 py-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bolder">Struktur Organisasi</h1>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-sitemap me-1 text-primary"></i>
                Kelola unit kerja, bidang, dan jabatan dalam organisasi.
            </p>
        </div>
        <ol class="breadcrumb mb-0 bg-white shadow-sm px-3 py-2 rounded-pill small border">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Struktur</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-hover-effect">
        
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-5 col-12">
                    <div class="input-group input-group-sm shadow-sm" style="border-radius: 20px; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 ps-3 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari nama unit...">
                    </div>
                </div>
                
                <div class="col-md-7 col-12 text-md-end text-start">
                    <?php if ($can_create): ?>
                        <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm hover-lift fw-bold" data-bs-toggle="modal" data-bs-target="#modalCreate">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Unit
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
                            <th class="py-3 border-0" width="40%">Nama Unit (Hierarki)</th>
                            <th class="py-3 border-0" width="25%">Deskripsi</th>
                            <th class="text-center py-3 border-0" width="10%">Urutan</th>
                            <th class="text-center py-3 border-0" width="10%">Status</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th class="text-center py-3 border-0" width="10%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($hierarchicalData)) : ?>
                            <tr>
                                <td colspan="<?= ($can_update || $can_delete) ? 6 : 5 ?>" class="text-center py-5">
                                    <div class="empty-state py-4">
                                        <div class="mb-3 text-muted opacity-25">
                                            <i class="fas fa-sitemap fa-4x"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Data Kosong</h6>
                                        <p class="small text-muted mb-0">Belum ada unit organisasi yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php 
                                foreach ($hierarchicalData as $index => $item) : 
                                    $paddingLeft = $item['depth'] * 30;
                                    $isRoot = empty($item['parent_id']);
                                    $deskripsi = $item['deskripsi'] ?? '';
                                    $hasDeskripsi = !empty($deskripsi) && trim(strip_tags($deskripsi)) !== '';
                            ?>
                                <tr class="transition-row border-bottom border-light">
                                    <td class="text-center text-muted fw-bold small"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center" style="padding-left: <?= $paddingLeft ?>px;">
                                            <?php if ($item['depth'] > 0): ?>
                                                <span class="text-muted opacity-50 me-2">
                                                    <i class="fas fa-level-up-alt fa-rotate-90"></i>
                                                </span>
                                            <?php endif; ?>
                                            
                                            <div>
                                                <div class="<?= $item['depth'] == 0 ? 'fw-bold text-primary' : 'fw-semibold text-dark' ?>">
                                                    <?= esc($item['nama']) ?>
                                                    <?php if ($isRoot): ?>
                                                        <span class="badge bg-light text-dark border ms-2" title="Root Unit">
                                                            <i class="fas fa-building me-1"></i>Root
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-info text-white border ms-2" title="Child Unit">
                                                            <i class="fas fa-sitemap me-1"></i>Child
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($item['slug'])): ?>
                                                    <div class="small text-muted fst-italic" style="font-size: 0.75rem;">
                                                        <i class="fas fa-link fa-xs me-1"></i><?= esc($item['slug']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if ($isRoot): ?>
                                            <!-- Root unit - tidak perlu deskripsi -->
                                            <div class="deskripsi-empty">
                                                <i class="fas fa-minus-circle me-1 text-muted"></i>
                                                Root unit tidak perlu deskripsi
                                            </div>
                                        <?php elseif (!$hasDeskripsi): ?>
                                            <!-- Child unit tapi belum ada deskripsi -->
                                            <div class="deskripsi-empty">
                                                <i class="fas fa-exclamation-triangle me-1 text-warning"></i>
                                                Belum ada deskripsi
                                            </div>
                                        <?php else: ?>
                                            <!-- Child unit dengan deskripsi -->
                                            <div class="deskripsi-preview small">
                                                <?= strip_tags(substr($deskripsi, 0, 150)) ?>...
                                            </div>
                                            <button class="btn btn-link btn-sm p-0 mt-1 text-primary view-deskripsi" 
                                                data-bs-toggle="tooltip" 
                                                title="Lihat deskripsi lengkap"
                                                data-deskripsi="<?= htmlspecialchars($deskripsi) ?>"
                                                data-nama="<?= esc($item['nama']) ?>">
                                                <i class="fas fa-eye me-1"></i>Lihat lengkap
                                            </button>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-secondary border border-light shadow-sm">
                                            <?= esc($item['sorting']) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($item['id_struktur'], $item['is_active'], 'struktur_organisasi/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <?php if ($can_update): ?>
                                                    <button class="btn btn-light text-primary btn-sm hover-primary border shadow-sm me-1 rounded btn-edit" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Data"
                                                       data-id="<?= $item['id_struktur'] ?>"
                                                       data-nama="<?= esc($item['nama']) ?>"
                                                       data-parent="<?= $item['parent_id'] ?>"
                                                       data-deskripsi="<?= htmlspecialchars($item['deskripsi'] ?? '') ?>"
                                                       data-sorting="<?= $item['sorting'] ?>"
                                                       data-isroot="<?= $isRoot ? '1' : '0' ?>">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="/struktur_organisasi/<?= $item['id_struktur'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini? Jika dihapus, child unit mungkin akan kehilangan parent.');">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" 
                                                                class="btn btn-light text-danger btn-sm hover-danger border shadow-sm rounded" 
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
                    Menampilkan total <strong><?= count($hierarchicalData) ?></strong> unit organisasi
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Deskripsi -->
<div class="modal fade" id="modalViewDeskripsi" tabindex="-1" aria-labelledby="modalViewDeskripsiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalViewDeskripsiLabel">
                    <i class="fas fa-file-alt me-2"></i>Deskripsi Unit
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="view-deskripsi-title" class="mb-3"></h6>
                <div id="view-deskripsi-content" class="border rounded p-3 bg-light" style="min-height: 200px;">
                    <!-- Deskripsi akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Struktur Organisasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/struktur_organisasi" method="post" id="formCreate">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Nama Unit/Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" placeholder="Contoh: Bidang Informasi dan Komunikasi Publik" required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Masukkan nama lengkap unit atau jabatan
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Induk (Parent)</label>
                                <select class="form-select select2-create" name="parent_id" id="select2-create">
                                    <option value="" data-depth="0">- Tidak Ada (Root) -</option>
                                    <?php if (!empty($parents)): ?>
                                        <?php foreach ($parents as $p): ?>
                                            <option value="<?= $p['id_struktur'] ?>" data-depth="<?= $p['depth'] ?>">
                                                <?= esc($p['nama']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-sitemap me-1"></i>Pilih unit induk jika ini adalah sub-unit
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Tugas & Fungsi</label>
                                <div id="editor-container-create"></div>
                                <input type="hidden" name="deskripsi" id="deskripsi_input_create">
                                <div class="form-text mt-2">
                                    <div id="deskripsi-info-create" class="deskripsi-info deskripsi-info-normal">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <span>Deskripsi opsional untuk semua unit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="d-flex align-items-center">
                                    <div class="icon me-3">
                                        <i class="fas fa-sort-numeric-down"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label mb-1">Urutan Tampilan</label>
                                        <input type="number" class="form-control" name="sorting" value="0">
                                        <small class="text-muted">Angka kecil = prioritas tinggi</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="d-flex align-items-center">
                                    <div class="icon me-3">
                                        <i class="fas fa-toggle-on"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label mb-1">Status</label>
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_active" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_active_create" name="is_active" value="1" checked>
                                            <label class="form-check-label" for="is_active_create">Aktifkan unit ini</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" form="formCreate" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Struktur Organisasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="formEdit">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Nama Unit/Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="edit_nama" required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Masukkan nama lengkap unit atau jabatan
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Induk (Parent)</label>
                                <select class="form-select select2-edit" name="parent_id" id="select2-edit">
                                    <option value="" data-depth="0">- Tidak Ada (Root) -</option>
                                    <?php if (!empty($parents)): ?>
                                        <?php foreach ($parents as $p): ?>
                                            <option value="<?= $p['id_struktur'] ?>" data-depth="<?= $p['depth'] ?>">
                                                <?= esc($p['nama']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-sitemap me-1"></i>Pilih unit induk jika ini adalah sub-unit
                                </div>
                            </div>

                            <!-- Bagian Deskripsi (akan ditampilkan/sembunyikan berdasarkan kondisi) -->
                            <div class="mb-3" id="edit-deskripsi-container">
                                <label class="form-label">Deskripsi Tugas & Fungsi</label>
                                <div id="editor-container-edit"></div>
                                <input type="hidden" name="deskripsi" id="deskripsi_input_edit">
                                <div class="form-text mt-2">
                                    <div id="deskripsi-info-edit" class="deskripsi-info deskripsi-info-normal">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <span>Deskripsi opsional untuk semua unit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-box">
                                <div class="d-flex align-items-center">
                                    <div class="icon me-3">
                                        <i class="fas fa-sort-numeric-down"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label mb-1">Urutan Tampilan</label>
                                        <input type="number" class="form-control" name="sorting" id="edit_sorting">
                                        <small class="text-muted">Angka kecil = prioritas tinggi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="submit" form="formEdit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Data
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
$(document).ready(function() {
    // Initialize Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
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

    // --- QUILL EDITOR FOR CREATE ---
    var quillCreate = new Quill('#editor-container-create', {
        theme: 'snow',
        placeholder: 'Tulis tugas pokok dan fungsi unit...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'header': [1, 2, 3, false] }],
                ['link', 'clean']
            ]
        }
    });

    // --- QUILL EDITOR FOR EDIT ---
    var quillEdit = new Quill('#editor-container-edit', {
        theme: 'snow',
        placeholder: 'Tulis tugas pokok dan fungsi unit...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'header': [1, 2, 3, false] }],
                ['link', 'clean']
            ]
        }
    });

    // --- SELECT2 FORMATTING FUNCTIONS ---
    function formatStruktur(state) {
        if (!state.id) { return state.text; }
        
        var depth = $(state.element).data('depth'); 
        var paddingLeft = depth * 20; 
        var icon = '';
        var cssClass = '';

        if (depth == 0) {
            icon = '<i class="fas fa-building text-primary me-2"></i>';
            cssClass = 'level-0';
        } else if (depth == 1) {
            icon = '<i class="fas fa-folder-open text-warning me-2"></i>';
            cssClass = 'level-1';
        } else {
            icon = '<i class="fas fa-turn-up fa-rotate-90 text-secondary me-2"></i>'; 
            cssClass = depth == 2 ? 'level-2' : 'level-deep';
        }

        var $state = $(
            '<span style="padding-left:' + paddingLeft + 'px" class="' + cssClass + '">' + 
                icon + state.text + 
            '</span>'
        );
        return $state;
    }

    function formatSelection(state) {
        if (!state.id) { return state.text; }
        var depth = $(state.element).data('depth');
        var icon = (depth == 0) ? '<i class="fas fa-building text-primary me-1"></i>' : '';
        return $('<span>' + icon + state.text + '</span>');
    }

    // --- INITIALIZE SELECT2 FOR CREATE ---
    $('#modalCreate').on('shown.bs.modal', function () {
        // Destroy existing select2 instance if any
        if ($('#select2-create').hasClass('select2-hidden-accessible')) {
            $('#select2-create').select2('destroy');
        }
        
        $('.select2-create').select2({
            theme: 'bootstrap-5',
            placeholder: 'Cari Unit Induk...',
            allowClear: true,
            dropdownParent: $('#modalCreate'),
            templateResult: formatStruktur,
            templateSelection: formatSelection
        });
        
        // Update info message based on parent selection
        updateDeskripsiInfo('create');
    });

    // --- INITIALIZE SELECT2 FOR EDIT ---
    $('#modalEdit').on('shown.bs.modal', function () {
        // Destroy existing select2 instance if any
        if ($('#select2-edit').hasClass('select2-hidden-accessible')) {
            $('#select2-edit').select2('destroy');
        }
        
        $('.select2-edit').select2({
            theme: 'bootstrap-5',
            placeholder: 'Cari Unit Induk...',
            allowClear: true,
            dropdownParent: $('#modalEdit'),
            templateResult: formatStruktur,
            templateSelection: formatSelection
        });
        
        // Update info message based on parent selection
        updateDeskripsiInfo('edit');
    });

    // Fungsi untuk update info deskripsi
    function updateDeskripsiInfo(type) {
        const selectElement = type === 'create' ? '#select2-create' : '#select2-edit';
        const infoSpan = type === 'create' ? $('#deskripsi-info-create span') : $('#deskripsi-info-edit span');
        const infoDiv = type === 'create' ? $('#deskripsi-info-create') : $('#deskripsi-info-edit');
        
        function updateInfo(hasParent) {
            if (!hasParent) {
                infoSpan.html('Deskripsi opsional (root unit jarang butuh deskripsi)');
                infoDiv.removeClass('deskripsi-info-child').addClass('deskripsi-info-parent');
            } else {
                infoSpan.html('<strong>Deskripsi diperlukan</strong> untuk child unit');
                infoDiv.removeClass('deskripsi-info-parent').addClass('deskripsi-info-child');
            }
        }
        
        // Initial state
        const currentValue = $(selectElement).val();
        updateInfo(currentValue && currentValue !== '');
        
        // Change event
        $(selectElement).off('change').on('change', function() {
            const selectedValue = $(this).val();
            const hasParent = selectedValue && selectedValue !== '';
            updateInfo(hasParent);
        });
    }

    // --- FORM CREATE SUBMISSION ---
    document.getElementById('formCreate').onsubmit = function() {
        var input = document.getElementById('deskripsi_input_create');
        input.value = (quillCreate.root.innerHTML === '<p><br></p>') ? '' : quillCreate.root.innerHTML;
        return true;
    };

    // --- FORM EDIT SUBMISSION ---
    document.getElementById('formEdit').onsubmit = function() {
        var input = document.getElementById('deskripsi_input_edit');
        input.value = (quillEdit.root.innerHTML === '<p><br></p>') ? '' : quillEdit.root.innerHTML;
        return true;
    };

    // --- VIEW DESKRIPSI MODAL ---
    $('.view-deskripsi').on('click', function() {
        var deskripsi = $(this).data('deskripsi');
        var nama = $(this).data('nama');
        
        $('#view-deskripsi-title').html('Deskripsi: ' + nama);
        $('#view-deskripsi-content').html(deskripsi);
        
        $('#modalViewDeskripsi').modal('show');
    });

    // --- HANDLE EDIT BUTTON CLICK ---
    $('.btn-edit').on('click', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');
        var parent = $(this).data('parent');
        var deskripsi = $(this).data('deskripsi');
        var sorting = $(this).data('sorting');
        var isRoot = $(this).data('isroot') === '1';

        // Set form action
        $('#formEdit').attr('action', '/struktur_organisasi/' + id);

        // Fill form fields
        $('#edit_nama').val(nama);
        $('#edit_sorting').val(sorting);

        // Set Quill content
        if (deskripsi) {
            setTimeout(function() {
                quillEdit.clipboard.dangerouslyPasteHTML(deskripsi);
            }, 500);
        }
        
        // Store data for when modal opens
        $('#modalEdit').data('edit-data', {
            parent: parent,
            isRoot: isRoot
        });

        // Show modal
        $('#modalEdit').modal('show');
    });
    
    // Handle when edit modal is shown
    $('#modalEdit').on('shown.bs.modal', function() {
        var editData = $(this).data('edit-data');
        if (editData) {
            // Set parent value
            if (editData.parent !== undefined) {
                $('#select2-edit').val(editData.parent).trigger('change');
            }
            
            // Tampilkan/sembunyikan bagian deskripsi berdasarkan apakah ini root/parent
            var isRoot = editData.isRoot;
            var deskripsiContainer = $('#edit-deskripsi-container');
            
            if (isRoot) {
                // Untuk parent/root unit: sembunyikan bagian deskripsi
                deskripsiContainer.hide();
                
                // Tambahkan placeholder untuk menjelaskan
                if (!deskripsiContainer.prev().hasClass('deskripsi-hidden-info')) {
                    $('<div class="deskripsi-hidden mb-3">' +
                        '<i class="fas fa-info-circle me-2"></i>' +
                        'Deskripsi tidak diperlukan untuk root/parent unit. ' +
                        'Hanya child unit yang memerlukan deskripsi tugas dan fungsi.' +
                      '</div>').insertBefore(deskripsiContainer)
                        .addClass('deskripsi-hidden-info');
                }
            } else {
                // Untuk child unit: tampilkan bagian deskripsi
                deskripsiContainer.show();
                
                // Hapus placeholder jika ada
                $('.deskripsi-hidden-info').remove();
            }
        }
    });

    // --- RESET FORMS WHEN MODALS CLOSE ---
    $('#modalCreate').on('hidden.bs.modal', function () {
        document.getElementById('formCreate').reset();
        quillCreate.setText('');
        $('#select2-create').val('').trigger('change');
        
        // Destroy select2 to prevent duplication
        if ($('#select2-create').hasClass('select2-hidden-accessible')) {
            $('#select2-create').select2('destroy');
        }
    });

    $('#modalEdit').on('hidden.bs.modal', function () {
        document.getElementById('formEdit').reset();
        quillEdit.setText('');
        $('#select2-edit').val('').trigger('change');
        
        // Destroy select2 to prevent duplication
        if ($('#select2-edit').hasClass('select2-hidden-accessible')) {
            $('#select2-edit').select2('destroy');
        }
        
        // Tampilkan kembali bagian deskripsi untuk next edit
        $('#edit-deskripsi-container').show();
        $('.deskripsi-hidden-info').remove();
        
        // Clear edit data
        $(this).removeData('edit-data');
    });
});
</script>

<?= $this->endSection() ?>