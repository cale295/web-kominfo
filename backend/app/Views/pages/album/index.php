<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* --- VARIABLE & UTAMA --- */
    :root { 
        --primary-bg: #f4f6f9;
        --card-border-radius: 12px;
        --primary-color: #4361ee; 
        --danger-color: #ef233c;
    }

    /* --- HEADER PAGE --- */
    .page-header { 
        background: white; 
        padding: 1.5rem 2rem; 
        border-radius: var(--card-border-radius); 
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        margin-bottom: 1.5rem; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    .page-title { 
        font-weight: 700; 
        color: #2d3436; 
        margin: 0; 
        font-size: 1.5rem; 
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* --- TOOLBAR --- */
    .toolbar {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: var(--card-border-radius);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        margin-bottom: 1.5rem; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        gap: 15px;
    }
    
    .btn-toolbar {
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        transition: all 0.2s;
    }
    
    .btn-add { background: #4361ee; color: white; }
    .btn-refresh { background: #6c757d; color: white; }
    .btn-add:hover { background: #3451d4; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3); }
    .btn-refresh:hover { background: #5a6268; transform: translateY(-2px); }
    
    .view-toggle {
        display: flex;
        gap: 5px;
        background: #f1f3f5;
        padding: 4px;
        border-radius: 8px;
    }
    
    .view-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: transparent;
        border-radius: 6px;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .view-btn.active {
        background: white;
        color: #4361ee;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .search-box {
        flex: 1;
        max-width: 400px;
        position: relative;
    }
    
    .search-box input {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        padding-left: 2.5rem;
        width: 100%;
        transition: all 0.2s;
    }
    
    .search-box input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }
    
    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    /* --- GRID ALBUM --- */
    .album-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        padding: 0;
    }
    
    .album-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }
    
    .album-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    
    .album-cover {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .album-cover-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
    
    .album-info { padding: 1.2rem; }
    
    .album-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2d3436;
        margin-bottom: 0.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .album-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
    }
    
    .photo-count {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .photo-count i { color: #4361ee; }
    
    .album-author { font-size: 0.85rem; color: #6c757d; }
    
    .album-date { font-size: 0.8rem; color: #adb5bd; margin-bottom: 1rem; }
    
    .album-actions {
        display: flex;
        gap: 8px;
        padding-top: 1rem;
        border-top: 1px solid #f1f3f5;
    }
    
    .action-btn {
        flex: 1;
        padding: 0.5rem;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    
    .btn-view { background: #e3f2fd; color: #1976d2; }
    .btn-upload { background: #e8f5e9; color: #388e3c; }
    .btn-edit { background: #fff3e0; color: #f57c00; }
    .btn-delete { background: #ffebee; color: #d32f2f; }
    
    .btn-view:hover { background: #1976d2; color: white; }
    .btn-upload:hover { background: #388e3c; color: white; }
    .btn-edit:hover { background: #f57c00; color: white; }
    .btn-delete:hover { background: #d32f2f; color: white; }

    /* --- EMPTY STATE --- */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .empty-state img { opacity: 0.5; margin-bottom: 1.5rem; }

    /* --- LIST VIEW --- */
    .album-list { display: none; }
    .album-list.active { display: block; }
    .album-grid.active { display: grid; }
    
    .card-table { 
        border: none; 
        border-radius: var(--card-border-radius); 
        box-shadow: 0 5px 20px rgba(0,0,0,0.05); 
        overflow: hidden; 
    }
    
    .table thead th { 
        background-color: #f8f9fa; 
        color: #636e72; 
        font-weight: 700; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 1px; 
        padding: 1.2rem 1rem;
        border-bottom: 2px solid #edf2f7;
    }
    
    .table tbody td { 
        padding: 1.2rem 1rem; 
        vertical-align: middle; 
        border-bottom: 1px solid #f1f2f6; 
    }
    
    .album-cover-thumb { 
        width: 70px; 
        height: 70px; 
        object-fit: cover; 
        border-radius: 10px; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        transition: transform 0.2s;
    }
    
    .album-cover-thumb:hover { transform: scale(1.1); }
    
    .table-album-cover-placeholder { 
        width: 70px; 
        height: 70px; 
        background: #dfe6e9; 
        border-radius: 10px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        color: #b2bec3; 
        font-size: 1.8rem; 
    }
    
    .btn-action-group { display: flex; gap: 5px; justify-content: center; }
    
    .table .btn-action { 
        width: 38px; 
        height: 38px; 
        border-radius: 8px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border: none; 
        transition: all 0.2s; 
        color: white;
    }
    
    .table .btn-view { background: #3498db; }
    .table .btn-upload { background: #00b894; }
    .table .btn-edit { background: #f1c40f; color: #7f8c8d; }
    .table .btn-delete { background: #ff7675; }
    
    .table .btn-action:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 4px 6px rgba(0,0,0,0.15); 
        opacity: 0.9; 
    }

    /* --- NEW UPLOAD ROW STYLING --- */
    .upload-row {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        position: relative;
        transition: all 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .upload-row:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
    }
    .upload-row-img-box {
        width: 120px;
        height: 120px;
        background: #f1f5f9;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #cbd5e1;
        position: relative;
    }
    .upload-row-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-remove-row {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fee2e2;
        color: #ef4444;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-remove-row:hover {
        background: #ef4444;
        color: white;
    }
    
    /* Style untuk modal edit */
    .img-preview-container {
        width: 100%;
        height: 250px;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        overflow: hidden;
        position: relative;
    }

    .img-preview {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    .img-placeholder {
        text-align: center;
        color: #adb5bd;
    }
</style>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">

    <div class="page-header">
        <h3 class="page-title">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <?= esc($title) ?>
        </h3>
    </div>

    <div class="toolbar">
        <div class="d-flex gap-2">
            <button type="button" class="btn-toolbar btn-add" 
                    data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Album
            </button>
            
            <button type="button" class="btn-toolbar btn-refresh" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise"></i>
                Refresh Data
            </button>
        </div>
        
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control" placeholder="Cari Foto..." id="searchInput">
        </div>
        
        <div class="view-toggle">
            <button class="view-btn" onclick="toggleView('list')" title="List View">
                <i class="bi bi-list-ul"></i>
            </button>
            <button class="view-btn active" onclick="toggleView('grid')" title="Grid View">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </button>
        </div>
    </div>

    <?php if (empty($albums)): ?>
        <div class="empty-state">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="120" alt="Empty">
            <h5 class="text-muted mt-3">Belum ada album</h5>
            <p class="text-muted">Mulai dengan membuat album pertama Anda.</p>
            <button type="button" class="btn btn-primary mt-3 px-4" 
                    data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                <i class="bi bi-plus-lg me-2"></i>Buat Album Baru
            </button>
        </div>
    <?php else: ?>
        <div class="album-grid active" id="gridView">
            <?php foreach ($albums as $row): ?>
            <div class="album-card" onclick="window.location='<?= site_url('album/'.$row['id_album']) ?>'">
                <?php if ($row['cover_image'] && file_exists('uploads/album_covers/' . $row['cover_image'])): ?>
                    <img src="<?= base_url('uploads/album_covers/'.$row['cover_image']) ?>" class="album-cover" alt="Cover">
                <?php else: ?>
                    <div class="album-cover-placeholder">
                        <i class="bi bi-image"></i>
                    </div>
                <?php endif; ?>
                
                <div class="album-info">
                    <h5 class="album-title"><?= esc($row['album_name']) ?></h5>
                    
                    <div class="album-meta">
                        <div class="photo-count">
                            <i class="bi bi-images"></i>
                            <span>3 Foto</span>
                        </div>
                        <span class="album-author">
                            <i class="bi bi-person-circle"></i>
                            Admin
                        </span>
                    </div>
                    
                    <div class="album-date">
                        <i class="bi bi-calendar-event"></i>
                        <?= date('d M Y H:i', strtotime($row['created_at'] ?? 'now')) ?>
                    </div>
                    
                    <div class="album-actions" onclick="event.stopPropagation()">
                        <button class="action-btn btn-view" 
                                onclick="window.location='<?= site_url('album/'.$row['id_album']) ?>'"
                                title="Lihat Album">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                        
                        <button class="action-btn btn-upload"
                                data-bs-toggle="modal" 
                                data-bs-target="#uploadModal"
                                data-id="<?= $row['id_album'] ?>" 
                                data-name="<?= esc($row['album_name']) ?>"
                                title="Upload Foto">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                        </button>
                        
                        <!-- Tombol Edit dengan trigger modal -->
                        <button class="action-btn btn-edit"
                                data-bs-toggle="modal" 
                                data-bs-target="#editAlbumModal"
                                data-id="<?= $row['id_album'] ?>"
                                data-name="<?= esc($row['album_name']) ?>"
                                data-description="<?= esc($row['description']) ?>"
                                data-cover="<?= $row['cover_image'] ?>"
                                title="Edit Album">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        
                        <form action="<?= site_url('album/'.$row['id_album']) ?>" method="post" class="d-inline delete-form" style="margin: 0;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" class="action-btn btn-delete btn-delete-confirm" title="Hapus Album">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="album-list" id="listView">
            <div class="card card-table">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th width="10%">Cover</th>
                                    <th width="25%">Detail Album</th>
                                    <th width="35%">Deskripsi</th>
                                    <th class="text-center" width="25%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($albums as $i => $row): ?>
                                <tr>
                                    <td class="text-center text-muted fw-bold"><?= $i+1 ?></td>
                                    
                                    <td>
                                        <?php if ($row['cover_image'] && file_exists('uploads/album_covers/' . $row['cover_image'])): ?>
                                            <img src="<?= base_url('uploads/album_covers/'.$row['cover_image']) ?>" class="album-cover-thumb" alt="Cover">
                                        <?php else: ?>
                                            <div class="table-album-cover-placeholder"><i class="bi bi-image"></i></div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark fs-6"><?= esc($row['album_name']) ?></div>
                                        <span class="badge bg-light text-secondary border mt-1">ID: #<?= $row['id_album'] ?></span>
                                    </td>

                                    <td>
                                        <div class="text-muted small" style="line-height: 1.5;">
                                            <?= esc($row['description']) ?: '<i class="text-muted">- Tidak ada deskripsi -</i>' ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-action-group">
                                            <a href="<?= site_url('album/'.$row['id_album']) ?>" 
                                               class="btn-action btn-view" 
                                               data-bs-toggle="tooltip" title="Lihat Isi Galeri">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>

                                            <button type="button" class="btn-action btn-upload" 
                                                    data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                    data-id="<?= $row['id_album'] ?>" 
                                                    data-name="<?= esc($row['album_name']) ?>"
                                                    title="Upload Foto Baru">
                                                <i class="bi bi-cloud-arrow-up-fill"></i>
                                            </button>

                                            <!-- Tombol Edit dengan trigger modal -->
                                            <button type="button" class="btn-action btn-edit" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editAlbumModal"
                                                    data-id="<?= $row['id_album'] ?>"
                                                    data-name="<?= esc($row['album_name']) ?>"
                                                    data-description="<?= esc($row['description']) ?>"
                                                    data-cover="<?= $row['cover_image'] ?>"
                                                    title="Edit Info Album">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>

                                            <form action="<?= site_url('album/'.$row['id_album']) ?>" method="post" class="d-inline delete-form">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="btn-action btn-delete btn-delete-confirm" title="Hapus Album">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Tambah Album -->
<div class="modal fade" id="addAlbumModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header bg-white border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold text-primary"><i class="bi bi-folder-plus me-2"></i>Album Baru</h5>
                    <p class="text-muted small mb-0">Silakan lengkapi detail album di bawah ini.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body bg-light mt-3">
                <form action="<?= site_url('album/store') ?>" method="post" enctype="multipart/form-data" id="addAlbumForm">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Album</label>
                        <input type="text" name="album_name" class="form-control form-control-lg border-0 shadow-sm" placeholder="Contoh: Liburan Bali 2024" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Deskripsi</label>
                        <textarea name="description" class="form-control border-0 shadow-sm" rows="3" placeholder="Ceritakan sedikit tentang album ini..."></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold small text-uppercase text-muted">Cover Album (Opsional)</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white p-2 rounded shadow-sm border" style="width: 80px; height: 80px;">
                                <img id="coverPreview" src="https://cdn-icons-png.flaticon.com/512/83/83574.png" class="w-100 h-100 object-fit-cover rounded" style="opacity: 0.4;">
                            </div>
                            <div class="w-100">
                                <input type="file" name="cover_image" id="coverInput" class="form-control form-control-sm" accept="image/*">
                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Format JPG/PNG. Maks 2MB.</small>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top-0 bg-white">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" onclick="document.getElementById('addAlbumForm').submit()" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save me-2"></i> Simpan Album
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Album -->
<div class="modal fade" id="editAlbumModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header bg-white border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold text-primary"><i class="bi bi-pencil-square me-2"></i>Edit Album</h5>
                    <p class="text-muted small mb-0">Perbarui detail album di bawah ini.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body bg-light mt-3">
                <form action="" method="post" enctype="multipart/form-data" id="editAlbumForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id_album" id="editAlbumId">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Album</label>
                        <input type="text" name="album_name" id="editAlbumName" class="form-control form-control-lg border-0 shadow-sm" placeholder="Contoh: Liburan Bali 2024" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Deskripsi</label>
                        <textarea name="description" id="editAlbumDescription" class="form-control border-0 shadow-sm" rows="3" placeholder="Ceritakan sedikit tentang album ini..."></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold small text-uppercase text-muted">Cover Album (Opsional)</label>
                        
                        <!-- Preview Image Container -->
                        <div class="img-preview-container mb-3" style="height: 180px;">
                            <img src="" class="img-preview" id="editCoverPreview">
                            <div class="img-placeholder" id="editPlaceholder">
                                <i class="bi bi-image fs-1"></i>
                                <p class="mb-0 mt-2">Tidak ada cover</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3">
                            <div class="w-100">
                                <input type="file" name="cover_image" id="editCoverInput" class="form-control form-control-sm" accept="image/*">
                                <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Format JPG/PNG. Maks 2MB.</small>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="remove_cover" id="removeCoverCheck">
                                    <label class="form-check-label text-muted small" for="removeCoverCheck">
                                        Hapus cover saat ini
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top-0 bg-white">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" onclick="document.getElementById('editAlbumForm').submit()" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Foto -->
<div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header bg-white border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold text-primary"><i class="bi bi-cloud-upload me-2"></i>Upload Foto</h5>
                    <p class="text-muted small mb-0">Album: <strong id="modalAlbumName" class="text-dark">Loading...</strong></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body bg-light">
                <form action="<?= site_url('album/upload_store') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_album" id="modalAlbumId">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small text-uppercase fw-bold">Daftar Foto yang Akan Diupload</span>
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" onclick="addPhotoRow()">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Foto
                        </button>
                    </div>

                    <div id="uploadRowsContainer">
                        </div>

                    <div id="modalEmptyState" class="text-center py-5">
                        <i class="bi bi-images text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="text-muted mt-2">Belum ada foto. Klik tombol <strong>"Tambah Foto"</strong> di atas.</p>
                    </div>

                </form>
            </div>
            
            <div class="modal-footer border-top-0 bg-white">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" onclick="document.getElementById('uploadForm').submit()" class="btn btn-success rounded-pill px-4" id="btnSimpan" disabled>
                    <i class="bi bi-send me-2"></i> Mulai Upload
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // --- UTILITY SCRIPT (Toggle View & Search) ---
    function toggleView(view) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const viewButtons = document.querySelectorAll('.view-btn');
        
        viewButtons.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');
        
        if(view === 'list') {
            gridView.classList.remove('active'); gridView.style.display = 'none';
            listView.classList.add('active'); listView.style.display = 'block';
        } else {
            listView.classList.remove('active'); listView.style.display = 'none';
            gridView.classList.add('active'); gridView.style.display = 'grid';
        }
    }

    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.album-card').forEach(card => {
            const title = card.querySelector('.album-title').textContent.toLowerCase();
            card.style.display = title.includes(searchTerm) ? 'block' : 'none';
        });
        document.querySelectorAll('#listView tbody tr').forEach(row => {
            const title = row.querySelector('.fw-bold').textContent.toLowerCase();
            row.style.display = title.includes(searchTerm) ? '' : 'none';
        });
    });

    // --- COVER PREVIEW FOR NEW ALBUM ---
    const coverInput = document.getElementById('coverInput');
    const coverPreview = document.getElementById('coverPreview');
    if(coverInput) {
        coverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreview.src = e.target.result;
                    coverPreview.style.opacity = '1'; 
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // --- DELETE CONFIRMATION ---
    document.querySelectorAll('.btn-delete-confirm').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Yakin hapus album?',
                text: "Semua foto di dalamnya juga akan terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // --- EDIT MODAL LOGIC ---
    const editModalEl = document.getElementById('editAlbumModal');
    const editCoverPreview = document.getElementById('editCoverPreview');
    const editPlaceholder = document.getElementById('editPlaceholder');
    
    // Set data album saat modal edit dibuka
    editModalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const idAlbum = button.getAttribute('data-id');
        const nameAlbum = button.getAttribute('data-name');
        const description = button.getAttribute('data-description');
        const coverImage = button.getAttribute('data-cover');
        
        // Set form action URL
        const form = editModalEl.querySelector('#editAlbumForm');
        form.action = "<?= site_url('album/') ?>" + idAlbum;
        
        // Set form values
        editModalEl.querySelector('#editAlbumId').value = idAlbum;
        editModalEl.querySelector('#editAlbumName').value = nameAlbum;
        editModalEl.querySelector('#editAlbumDescription').value = description || '';
        
        // Handle cover image preview
        if (coverImage) {
            const coverUrl = "<?= base_url('uploads/album_covers/') ?>" + coverImage;
            editCoverPreview.src = coverUrl;
            editCoverPreview.classList.remove('d-none');
            editPlaceholder.classList.add('d-none');
        } else {
            editCoverPreview.src = '';
            editCoverPreview.classList.add('d-none');
            editPlaceholder.classList.remove('d-none');
        }
    });

    // Preview image untuk edit modal
    const editCoverInput = document.getElementById('editCoverInput');
    if(editCoverInput) {
        editCoverInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    editCoverPreview.src = e.target.result;
                    editCoverPreview.classList.remove('d-none');
                    editPlaceholder.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Handle remove cover checkbox
    const removeCoverCheck = document.getElementById('removeCoverCheck');
    if(removeCoverCheck) {
        removeCoverCheck.addEventListener('change', function() {
            if(this.checked) {
                editCoverPreview.src = '';
                editCoverPreview.classList.add('d-none');
                editPlaceholder.classList.remove('d-none');
            }
        });
    }

    // --- NEW UPLOAD LOGIC (TABLE / ROW BASED) ---
    const uploadModalEl = document.getElementById('uploadModal');
    const uploadRowsContainer = document.getElementById('uploadRowsContainer');
    const modalEmptyState = document.getElementById('modalEmptyState');
    const btnSimpan = document.getElementById('btnSimpan');
    
    // Set ID Album saat modal upload dibuka
    uploadModalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const idAlbum = button.getAttribute('data-id');
        const nameAlbum = button.getAttribute('data-name');
        
        uploadModalEl.querySelector('#modalAlbumId').value = idAlbum;
        uploadModalEl.querySelector('#modalAlbumName').textContent = nameAlbum;
        
        // Reset form content
        uploadRowsContainer.innerHTML = '';
        checkEmptyState();
        // Otomatis tambah 1 baris saat dibuka
        addPhotoRow();
    });

    // Fungsi Tambah Baris Foto
    function addPhotoRow() {
        const rowId = Date.now(); // Unique ID for element
        const rowHtml = `
            <div class="upload-row" id="row-${rowId}">
                <button type="button" class="btn-remove-row" onclick="removeRow('${rowId}')" title="Hapus Baris">
                    <i class="bi bi-x-lg"></i>
                </button>
                
                <div class="row g-3 align-items-start">
                    <div class="col-md-3 col-sm-4">
                        <div class="upload-row-img-box" onclick="triggerFileClick('${rowId}')">
                            <img src="https://cdn-icons-png.flaticon.com/512/126/126477.png" id="preview-${rowId}" style="opacity: 0.3; width: 40px; height: 40px;">
                        </div>
                        <input type="file" name="gallery_photos[]" id="file-${rowId}" class="d-none" accept="image/*" onchange="previewImage(this, '${rowId}')" required>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm py-0" style="font-size: 0.75rem;" onclick="triggerFileClick('${rowId}')">Pilih Foto</button>
                        </div>
                    </div>
                    
                    <div class="col-md-9 col-sm-8">
                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted">Nama Foto</label>
                            <input type="text" name="titles[]" class="form-control" placeholder="Beri nama foto ini..." required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Deskripsi</label>
                            <textarea name="descriptions[]" class="form-control" rows="2" placeholder="Keterangan foto (opsional)"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        uploadRowsContainer.insertAdjacentHTML('beforeend', rowHtml);
        checkEmptyState();
    }

    // Trigger File Input
    function triggerFileClick(rowId) {
        document.getElementById(`file-${rowId}`).click();
    }

    // Preview Image Logic
    function previewImage(input, rowId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(`preview-${rowId}`);
                img.src = e.target.result;
                img.style.opacity = '1';
                img.style.width = '100%';
                img.style.height = '100%';
                
                // Auto fill title with filename (optional)
                const row = document.getElementById(`row-${rowId}`);
                const titleInput = row.querySelector('input[name="titles[]"]');
                if(!titleInput.value) {
                    let filename = input.files[0].name;
                    titleInput.value = filename.split('.').slice(0, -1).join('.');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove Row Logic
    function removeRow(rowId) {
        const row = document.getElementById(`row-${rowId}`);
        if(row) {
            row.remove();
            checkEmptyState();
        }
    }

    // Check State (Tampilkan/Sembunyikan tombol Simpan)
    function checkEmptyState() {
        const rowCount = uploadRowsContainer.children.length;
        if (rowCount === 0) {
            modalEmptyState.style.display = 'block';
            btnSimpan.disabled = true;
        } else {
            modalEmptyState.style.display = 'none';
            btnSimpan.disabled = false;
        }
    }

</script>
<?= $this->endSection() ?>