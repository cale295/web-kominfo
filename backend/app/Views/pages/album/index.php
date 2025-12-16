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
        padding: 2rem; 
        border-radius: var(--card-border-radius); 
        box-shadow: 0 4px 20px rgba(0,0,0,0.03); 
        margin-bottom: 2rem; 
        border-left: 5px solid var(--primary-color);
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }
    .page-title { font-weight: 800; color: #2d3436; margin: 0; font-size: 1.6rem; }
    
    /* --- TABEL ALBUM --- */
    .card-table { border: none; border-radius: var(--card-border-radius); box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; }
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
    .table tbody td { padding: 1.2rem 1rem; vertical-align: middle; border-bottom: 1px solid #f1f2f6; }
    
    /* Cover Image */
    .album-cover-thumb { 
        width: 70px; height: 70px; 
        object-fit: cover; border-radius: 10px; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        transition: transform 0.2s;
    }
    .album-cover-thumb:hover { transform: scale(1.1); }
    .album-cover-placeholder { 
        width: 70px; height: 70px; 
        background: #dfe6e9; border-radius: 10px; 
        display: flex; align-items: center; justify-content: center; 
        color: #b2bec3; font-size: 1.8rem; 
    }

    /* Tombol Aksi */
    .btn-action-group { display: flex; gap: 5px; justify-content: center; }
    .btn-action { 
        width: 38px; height: 38px; 
        border-radius: 8px; 
        display: flex; align-items: center; justify-content: center; 
        border: none; transition: all 0.2s; 
        color: white;
    }
    .btn-view { background: #3498db; } /* Biru: Lihat */
    .btn-upload { background: #00b894; } /* Hijau: Upload */
    .btn-edit { background: #f1c40f; color: #7f8c8d; } /* Kuning: Edit */
    .btn-delete { background: #ff7675; } /* Merah: Hapus */
    
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 4px 6px rgba(0,0,0,0.15); opacity: 0.9; }

    /* --- MODAL UPLOAD STYLING --- */
    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background-color: #f8fafc;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .upload-area:hover, .upload-area.dragover {
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
    .preview-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .preview-img-container { height: 140px; overflow: hidden; position: relative; }
    .preview-img { width: 100%; height: 100%; object-fit: cover; }
    .btn-remove-preview {
        position: absolute; top: 5px; right: 5px;
        width: 24px; height: 24px;
        border-radius: 50%; background: rgba(239, 35, 60, 0.9);
        color: white; border: none;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; cursor: pointer; z-index: 10;
    }
</style>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">

    <div class="page-header">
        <div>
            <h3 class="page-title"><i class="bi bi-collection-fill me-2 text-primary"></i><?= esc($title) ?></h3>
            <p class="text-muted mb-0 mt-1">Kelola album dan koleksi foto Anda di sini.</p>
        </div>
        
        <button type="button" class="btn btn-primary px-4 py-2 shadow-sm rounded-pill fw-bold" 
                data-bs-toggle="modal" data-bs-target="#addAlbumModal">
            <i class="bi bi-plus-lg me-2"></i>Album Baru
        </button>
    </div>

    <div class="card card-table">
        <div class="card-body p-0">
            <?php if (empty($albums)): ?>
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="120" alt="Empty" class="mb-3 opacity-50">
                    <h5 class="text-muted">Belum ada album</h5>
                    <p class="text-muted small">Mulai dengan membuat album pertama Anda.</p>
                </div>
            <?php else: ?>
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
                                        <div class="album-cover-placeholder"><i class="bi bi-image"></i></div>
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

                                        <a href="<?= site_url('album/'.$row['id_album'].'/edit') ?>" 
                                           class="btn-action btn-edit" title="Edit Info Album">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

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
            <?php endif; ?>
        </div>
    </div>
</div>

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

                    <div id="previewContainer" class="preview-grid">
                        </div>

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
    // ----------------------------------------------------------------
    // LOGIC MODAL TAMBAH ALBUM (NEW)
    // ----------------------------------------------------------------
    
    // Preview Cover Image saat dipilih
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

    // Reset Form Tambah Album saat modal ditutup
    const addAlbumModalEl = document.getElementById('addAlbumModal');
    if(addAlbumModalEl) {
        addAlbumModalEl.addEventListener('hidden.bs.modal', function () {
            document.getElementById('addAlbumForm').reset();
            if(coverPreview) {
                coverPreview.src = "https://cdn-icons-png.flaticon.com/512/83/83574.png";
                coverPreview.style.opacity = '0.4';
            }
        });
    }

    // ----------------------------------------------------------------
    // LOGIC LAINNYA (HAPUS & UPLOAD - SUDAH ADA SEBELUMNYA)
    // ----------------------------------------------------------------

    // 1. Script Hapus Album (SweetAlert)
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

    // 2. Logic Upload Modern
    const uploadModalEl = document.getElementById('uploadModal');
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');
    const emptyState = document.getElementById('emptyState');
    const btnSimpan = document.getElementById('btnSimpan');
    const dropZone = document.getElementById('dropZone');

    let dataTransfer = new DataTransfer(); 

    uploadModalEl.addEventListener('show.bs.modal', function (event) {
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
    function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
    });
    
    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles({ target: { files: files } });
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

    uploadModalEl.addEventListener('hidden.bs.modal', function () {
        dataTransfer = new DataTransfer();
        fileInput.files = dataTransfer.files;
        previewContainer.innerHTML = '';
        updateUI();
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?= $this->endSection() ?>