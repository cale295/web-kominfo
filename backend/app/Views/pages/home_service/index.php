<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #95a5a6;
        --accent-color: #3498db;
    }

    /* Header Styling */
    .page-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border-left: 5px solid var(--accent-color);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Card Styling */
    .card-table {
        background: white;
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* Table Styling */
    .table thead th {
        background-color: #f8f9fa;
        color: var(--primary-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        border-bottom: 2px solid #eaecf0;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f2f5;
    }

    /* Thumbnail Gallery Styling */
    .gallery-thumb-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        border: 2px solid #f0f2f5;
        transition: transform 0.2s;
    }

    .gallery-thumb-wrapper:hover {
        transform: scale(1.05);
        border-color: var(--accent-color);
    }

    .gallery-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Mencegah gambar gepeng */
    }

    /* Badge Album */
    .badge-album {
        background-color: #e3f2fd;
        color: #1565c0;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
    }
    .badge-album:hover {
        background-color: #bbdefb;
        color: #0d47a1;
    }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        margin: 0 2px;
    }
    
    .btn-edit-custom { background-color: #fff3cd; color: #856404; }
    .btn-edit-custom:hover { background-color: #ffeeba; }

    .btn-delete-custom { background-color: #f8d7da; color: #721c24; }
    .btn-delete-custom:hover { background-color: #f5c6cb; }

    /* Empty State */
    .empty-state {
        padding: 4rem;
        text-align: center;
        color: #95a5a6;
    }
</style>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">

    <div class="page-header">
        <div>
            <h3 class="m-0 fw-bold" style="color: var(--primary-color);">
                <i class="bi bi-camera me-2"></i>Daftar Foto
            </h3>
            <p class="text-muted m-0 mt-1">Kelola semua materi foto dalam galeri Anda</p>
        </div>
        <div>
            <a href="<?= site_url('gallery/new') ?>" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Upload Foto
            </a>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body p-0">
            
            <?php if (empty($gallery)): ?>
                <div class="empty-state">
                    <i class="bi bi-images display-4 mb-3 d-block text-secondary"></i>
                    <h5>Belum ada foto</h5>
                    <p>Mulai dengan mengupload foto pertama Anda.</p>
                    <a href="<?= site_url('gallery/new') ?>" class="btn btn-outline-primary mt-2">Upload Sekarang</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="12%">Preview</th>
                                <th width="35%">Detail Foto</th>
                                <th width="20%">Album</th>
                                <th width="15%">Tanggal Upload</th>
                                <th width="13%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gallery as $i => $row): ?>
                            <tr>
                                <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                                
                                <td>
                                    <?php if (!empty($row['file_path']) && file_exists('uploads/gallery/' . $row['file_path'])): ?>
                                        <div class="gallery-thumb-wrapper shadow-sm" 
                                             onclick="showImageModal('<?= base_url('uploads/gallery/' . $row['file_path']) ?>', '<?= esc($row['photo_title']) ?>')">
                                            <img src="<?= base_url('uploads/gallery/' . $row['file_path']) ?>" 
                                                 class="gallery-thumb" 
                                                 alt="Thumbnail">
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted small p-2 bg-light rounded text-center">No File</div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark mb-1"><?= esc($row['photo_title']) ?></div>
                                    <div class="text-muted small text-truncate" style="max-width: 250px;">
                                        <?= esc($row['deskripsi']) ?: '<em class="text-light">Tidak ada deskripsi</em>' ?>
                                    </div>
                                </td>

                                <td>
                                    <?php if($row['album_name']): ?>
                                        <span class="badge-album">
                                            <i class="bi bi-folder2-open me-1"></i><?= esc($row['album_name']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">- Tanpa Album -</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center text-secondary">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        <?= date('d M Y', strtotime($row['created_at'])) ?>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <a href="<?= site_url('gallery/' . $row['id_photo'] . '/edit') ?>" 
                                       class="btn-action btn-edit-custom" 
                                       title="Edit Foto">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="<?= site_url('gallery/' . $row['id_photo']) ?>" method="post" class="d-inline delete-form">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="button" class="btn-action btn-delete-custom btn-delete" title="Hapus Foto">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg bg-transparent">
            <div class="modal-body p-0 position-relative text-center">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <img src="" id="modalImage" class="img-fluid rounded shadow" style="max-height: 85vh;">
                <h5 class="mt-3 text-white text-shadow" id="modalCaption"></h5>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Script untuk Modal Preview Gambar
    function showImageModal(src, title) {
        document.getElementById('modalImage').src = src;
        document.getElementById('modalCaption').innerText = title;
        var myModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        myModal.show();
    }

    // 2. Script untuk SweetAlert2 Delete
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Hapus Foto?',
                text: "Foto ini akan dihapus permanen dari galeri!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>