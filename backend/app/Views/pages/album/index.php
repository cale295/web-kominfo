<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Styling Khusus Halaman Index */
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
        border-left: 5px solid var(--primary-color);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
    }

    .page-subtitle {
        font-size: 0.9rem;
        color: #7f8c8d;
        margin: 5px 0 0 0;
    }

    /* Card Table Styling */
    .card-table {
        background: white;
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8f9fa;
        color: var(--primary-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #eaecf0;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #555;
        font-size: 0.95rem;
        border-bottom: 1px solid #f0f2f5;
    }

    /* Image Thumbnail Styling */
    .album-cover-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border: 2px solid #fff;
    }

    .album-cover-placeholder {
        width: 60px;
        height: 60px;
        background-color: #ecf0f1;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bdc3c7;
        font-size: 1.5rem;
    }

    /* Action Buttons */
    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        margin: 0 2px;
    }

    .btn-edit-custom {
        background-color: #fff3cd;
        color: #856404;
    }
    .btn-edit-custom:hover { background-color: #ffeeba; transform: translateY(-2px); }

    .btn-delete-custom {
        background-color: #f8d7da;
        color: #721c24;
    }
    .btn-delete-custom:hover { background-color: #f5c6cb; transform: translateY(-2px); }

    /* Empty State */
    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #95a5a6;
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dcdde1;
    }
</style>

<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">

    <div class="page-header">
        <div>
            <h3 class="page-title"><i class="bi bi-journal-album me-2"></i><?= esc($title) ?></h3>
            <p class="page-subtitle">Kelola galeri dan koleksi album foto Anda</p>
        </div>
        <div>
            <a href="<?= site_url('album/new') ?>" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Album
            </a>
        </div>
    </div>

    <div class="card card-table">
        <div class="card-body p-0">
            
            <?php if (empty($albums)): ?>
                <div class="empty-state">
                    <i class="bi bi-images"></i>
                    <h5>Belum ada album</h5>
                    <p>Silakan tambahkan album baru untuk memulai koleksi.</p>
                    <a href="<?= site_url('album/new') ?>" class="btn btn-outline-primary btn-sm mt-2">Buat Album Baru</a>
                </div>
            <?php else: ?>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="15%">Cover</th>
                                <th width="25%">Nama Album</th>
                                <th width="40%">Deskripsi</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($albums as $i => $row): ?>
                            <tr>
                                <td class="text-center fw-bold text-secondary"><?= $i+1 ?></td>
                                
                                <td>
                                    <?php if ($row['cover_image'] && file_exists('uploads/album_covers/' . $row['cover_image'])): ?>
                                        <img src="<?= base_url('uploads/album_covers/'.$row['cover_image']) ?>" 
                                             class="album-cover-thumb" 
                                             alt="Cover">
                                    <?php else: ?>
                                        <div class="album-cover-placeholder" title="No Image">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark"><?= esc($row['album_name']) ?></div>
                                    <small class="text-muted">ID: #<?= $row['id_album'] ?></small>
                                </td>
                                
                                <td>
                                    <span class="text-muted text-truncate d-block" style="max-width: 300px;">
                                        <?= esc($row['description']) ?: '-' ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="<?= site_url('album/'.$row['id_album'].'/edit') ?>" 
                                       class="btn-action btn-edit-custom" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Album">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="<?= site_url('album/'.$row['id_album']) ?>" method="post" class="d-inline delete-form">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="button" 
                                                class="btn-action btn-delete-custom btn-delete" 
                                                title="Hapus Album">
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Script untuk SweetAlert2 Konfirmasi Hapus
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Hapus Album?',
                text: "Data album ini tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Inisialisasi Tooltip Bootstrap (Opsional, agar hover text muncul cantik)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<?= $this->endSection() ?>