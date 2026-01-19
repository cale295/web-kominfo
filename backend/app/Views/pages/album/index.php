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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

    .btn-add {
        background: #4361ee;
        color: white;
    }

    .btn-refresh {
        background: #6c757d;
        color: white;
    }

    .btn-add:hover {
        background: #3451d4;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .btn-refresh:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .search-box {
        flex: 1;
        max-width: 400px;
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

    .search-box {
        position: relative;
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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }

    .album-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
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

    .album-info {
        padding: 1.2rem;
    }

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

    .photo-count i {
        color: #4361ee;
    }

    .album-author {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .album-date {
        font-size: 0.8rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

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

    .btn-view {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-upload {
        background: #e8f5e9;
        color: #388e3c;
    }

    .btn-edit {
        background: #fff3e0;
        color: #f57c00;
    }

    .btn-delete {
        background: #ffebee;
        color: #d32f2f;
    }

    .btn-view:hover {
        background: #1976d2;
        color: white;
    }

    .btn-upload:hover {
        background: #388e3c;
        color: white;
    }

    .btn-edit:hover {
        background: #f57c00;
        color: white;
    }

    .btn-delete:hover {
        background: #d32f2f;
        color: white;
    }

    /* --- EMPTY STATE --- */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .empty-state img {
        opacity: 0.5;
        margin-bottom: 1.5rem;
    }

    /* --- LIST VIEW --- */
    .album-list {
        display: none;
    }

    .album-list.active {
        display: block;
    }

    .album-grid.active {
        display: grid;
    }

    .card-table {
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .album-cover-thumb:hover {
        transform: scale(1.1);
    }

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

    .btn-action-group {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

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

    .table .btn-view {
        background: #3498db;
    }

    .table .btn-upload {
        background: #00b894;
    }

    .table .btn-edit {
        background: #f1c40f;
        color: #7f8c8d;
    }

    .table .btn-delete {
        background: #ff7675;
    }

    .table .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        opacity: 0.9;
    }

    /* --- MODAL UPLOAD STYLING --- */
    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background-color: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-area:hover,
    .upload-area.dragover {
        border-color: var(--primary-color);
        background-color: #eff6ff;
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
        max-height: 400px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .preview-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        background: white;
        position: relative;
        transition: box-shadow 0.2s;
    }

    .preview-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .preview-img-container {
        height: 140px;
        overflow: hidden;
        position: relative;
    }

    .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-remove-preview {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(239, 35, 60, 0.9);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        z-index: 10;
    }
</style>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">

    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <?= esc($title) ?>
        </h3>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="d-flex gap-2">
            <button type="button" class="btn-toolbar btn-add"
                data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                <i class="bi bi-plus-circle-fill"></i>
                Tambah Foto
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

    <!-- Album Grid -->
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
        <!-- Grid View -->
        <div class="album-grid active" id="gridView">
            <?php foreach ($albums as $row): ?>
                <div class="album-card" onclick="window.location='<?= site_url('album/' . $row['id_album']) ?>'">
                    <?php if ($row['cover_image'] && file_exists('uploads/album_covers/' . $row['cover_image'])): ?>
                        <img src="<?= base_url('uploads/album_covers/' . $row['cover_image']) ?>" class="album-cover" alt="Cover">
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
                                <?= $row['photo_count'] ?? 0; ?> Foto
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
                                onclick="window.location='<?= site_url('album/' . $row['id_album']) ?>'"
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

                            <button class="action-btn btn-edit"
                                onclick="window.location='<?= site_url('album/' . $row['id_album'] . '/edit') ?>'"
                                title="Edit Album">
                                <i class="bi bi-pencil-fill"></i>
                            </button>

                            <form action="<?= site_url('album/' . $row['id_album']) ?>" method="post" class="d-inline delete-form" style="margin: 0;">
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

        <!-- List View -->
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
                                        <td class="text-center text-muted fw-bold"><?= $i + 1 ?></td>

                                        <td>
                                            <?php if ($row['cover_image'] && file_exists('uploads/album_covers/' . $row['cover_image'])): ?>
                                                <img src="<?= base_url('uploads/album_covers/' . $row['cover_image']) ?>" class="album-cover-thumb" alt="Cover">
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
                                                <a href="<?= site_url('album/' . $row['id_album']) ?>"
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

                                                <a href="<?= site_url('album/' . $row['id_album'] . '/edit') ?>"
                                                    class="btn-action btn-edit" title="Edit Info Album">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>

                                                <form action="<?= site_url('album/' . $row['id_album']) ?>" method="post" class="d-inline delete-form">
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

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-white border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold text-primary"><i class="bi bi-cloud-upload me-2"></i>Upload Foto</h5>
                    <p class="text-muted small mb-0">Menambahkan foto ke album: <strong id="modalAlbumName" class="text-dark">Loading...</strong></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <form action="<?= site_url('album/upload_store') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_album" id="modalAlbumId">

                    <div class="upload-area p-5 text-center mb-3" id="dropZone" onclick="document.getElementById('fileInput').click()">
                        <input type="file" class="d-none" name="gallery_photos[]" id="fileInput" multiple accept="image/*">
                        <div class="mb-3">
                            <i class="bi bi-images text-primary" style="font-size: 3rem; opacity: 0.7;"></i>
                        </div>
                        <h6 class="fw-bold">Klik atau Tarik Foto ke Sini</h6>
                        <p class="text-muted small mb-0">Mendukung banyak file sekaligus (JPG, PNG)</p>
                    </div>

                    <div id="previewContainer" class="preview-grid"></div>

                    <div id="emptyState" class="text-center py-4 text-muted">
                        <small>Belum ada foto yang dipilih untuk diupload.</small>
                    </div>

                </form>
            </div>

            <div class="modal-footer border-top-0 bg-white">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" onclick="document.getElementById('uploadForm').submit()" class="btn btn-primary rounded-pill px-4" id="btnSimpan" disabled>
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
    // Toggle View
    function toggleView(view) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const viewButtons = document.querySelectorAll('.view-btn');

        // Update button states
        viewButtons.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        if (view === 'list') {
            gridView.classList.remove('active');
            gridView.style.display = 'none';
            listView.classList.add('active');
            listView.style.display = 'block';
        } else {
            listView.classList.remove('active');
            listView.style.display = 'none';
            gridView.classList.add('active');
            gridView.style.display = 'grid';
        }
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();

        // Search in grid view
        document.querySelectorAll('.album-card').forEach(card => {
            const title = card.querySelector('.album-title').textContent.toLowerCase();
            card.style.display = title.includes(searchTerm) ? 'block' : 'none';
        });

        // Search in list view
        document.querySelectorAll('#listView tbody tr').forEach(row => {
            const title = row.querySelector('.fw-bold').textContent.toLowerCase();
            row.style.display = title.includes(searchTerm) ? '' : 'none';
        });
    });

    // Preview Cover Image
    const coverInput = document.getElementById('coverInput');
    const coverPreview = document.getElementById('coverPreview');

    if (coverInput) {
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

    // Reset Form
    const addAlbumModalEl = document.getElementById('addAlbumModal');
    if (addAlbumModalEl) {
        addAlbumModalEl.addEventListener('hidden.bs.modal', function() {
            document.getElementById('addAlbumForm').reset();
            if (coverPreview) {
                coverPreview.src = "https://cdn-icons-png.flaticon.com/512/83/83574.png";
                coverPreview.style.opacity = '0.4';
            }
        });
    }

    // Delete Confirmation
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

    // Upload Logic
    const uploadModalEl = document.getElementById('uploadModal');
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');
    const emptyState = document.getElementById('emptyState');
    const btnSimpan = document.getElementById('btnSimpan');
    const dropZone = document.getElementById('dropZone');

    let dataTransfer = new DataTransfer();

    uploadModalEl.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const idAlbum = button.getAttribute('data-id');
        const nameAlbum = button.getAttribute('data-name');
        uploadModalEl.querySelector('#modalAlbumId').value = idAlbum;
        uploadModalEl.querySelector('#modalAlbumName').textContent = nameAlbum;
    });

    fileInput.addEventListener('change', handleFiles);

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
    });

    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles({
            target: {
                files: files
            }
        });
    });

    function handleFiles(e) {
        const newFiles = Array.from(e.target.files);
        newFiles.forEach(file => {
            if (!file.type.match('image.*')) return;
            dataTransfer.items.add(file);
            const reader = new FileReader();
            reader.onload = function(evt) {
                createCard(evt.target.result, file.name);
            }
            reader.readAsDataURL(file);
        });
        fileInput.files = dataTransfer.files;
        updateUI();
    }

    function createCard(imgSrc, fileName) {
        const div = document.createElement('div');
        div.className = 'preview-card';
        div.innerHTML = `
            <button type="button" class="btn-remove-preview" onclick="removeFile(this, '${fileName}')">
                <i class="bi bi-x"></i>
            </button>
            <div class="preview-img-container">
                <img src="${imgSrc}" class="preview-img">
            </div>
            <div class="p-2">
                <input type="text" name="titles[]" class="form-control form-control-sm mb-2" 
                       placeholder="Judul" value="${fileName.split('.')[0]}">
                <textarea name="descriptions[]" class="form-control form-control-sm" 
                          rows="1" placeholder="Deskripsi..."></textarea>
            </div>
        `;
        previewContainer.appendChild(div);
    }

    window.removeFile = function(btn, fileName) {
        btn.closest('.preview-card').remove();
        const newDataTransfer = new DataTransfer();
        Array.from(dataTransfer.files).forEach(file => {
            if (file.name !== fileName) newDataTransfer.items.add(file);
        });
        dataTransfer = newDataTransfer;
        fileInput.files = dataTransfer.files;
        updateUI();
    }

    function updateUI() {
        if (dataTransfer.files.length > 0) {
            emptyState.style.display = 'none';
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = `<i class="bi bi-cloud-arrow-up-fill me-2"></i>Upload ${dataTransfer.files.length} Foto`;
        } else {
            emptyState.style.display = 'block';
            btnSimpan.disabled = true;
            btnSimpan.innerHTML = `<i class="bi bi-send me-2"></i> Mulai Upload`;
        }
    }

    uploadModalEl.addEventListener('hidden.bs.modal', function() {
        dataTransfer = new DataTransfer();
        fileInput.files = dataTransfer.files;
        previewContainer.innerHTML = '';
        updateUI();
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?= $this->endSection() ?>