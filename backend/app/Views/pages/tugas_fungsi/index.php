<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 py-4">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bolder">Tugas & Fungsi</h1>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-info-circle me-1 text-primary"></i>
                Kelola data tugas pokok dan fungsi organisasi Anda di sini.
            </p>
        </div>
        <ol class="breadcrumb mb-0 bg-white shadow-sm px-3 py-2 rounded-pill small">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Tugas Fungsi</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-6 col-12">
                    <div class="input-group input-group-sm shadow-sm" style="max-width: 300px;">
                        <span class="input-group-text bg-white border-end-0 ps-3 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari deskripsi...">
                    </div>
                </div>
                
                <div class="col-md-6 col-12 text-md-end text-start">
                    <?php if ($can_create): ?>
                        <a href="/tugas_fungsi/new" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm hover-lift">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Data
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr class="text-uppercase text-secondary text-xs fw-bolder">
                            <th class="text-center py-3 border-0" width="5%">#</th>
                            <th class="py-3 border-0" width="15%">Kategori</th>
                            <th class="py-3 border-0" width="45%">Deskripsi Tugas/Fungsi</th>
                            <th class="text-center py-3 border-0" width="15%">Status</th>
                            <th class="text-center py-3 border-0" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($tugas_fungsi)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="mb-3 text-muted opacity-25">
                                            <i class="fas fa-folder-open fa-4x"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Data Kosong</h6>
                                        <p class="small text-muted">Belum ada tugas atau fungsi yang ditambahkan.</p>
                                        <?php if ($can_create): ?>
                                            <a href="/tugas_fungsi/new" class="btn btn-outline-primary btn-sm rounded-pill mt-2">
                                                Buat Data Baru
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($tugas_fungsi as $index => $item) : ?>
                                <tr class="transition-row">
                                    <td class="text-center text-muted fw-bold small"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <?php if ($item['type'] == 'tugas') : ?>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-sm bg-primary bg-opacity-10 text-primary rounded-circle me-2 p-2">
                                                    <i class="fas fa-clipboard-check fa-sm"></i>
                                                </div>
                                                <span class="fw-bold text-dark small">Tugas Pokok</span>
                                            </div>
                                        <?php else : ?>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape icon-sm bg-info bg-opacity-10 text-info rounded-circle me-2 p-2">
                                                    <i class="fas fa-cogs fa-sm"></i>
                                                </div>
                                                <span class="fw-bold text-dark small">Fungsi</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <p class="mb-0 text-secondary small lh-sm text-wrap">
                                            <?= nl2br(esc(strip_tags($item['description']))) ?>
                                        </p>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($item['is_active'] == 1) : ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i> Aktif
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-2">
                                                <i class="fas fa-ban me-1"></i> Non-Aktif
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?php if ($can_update): ?>
                                                <a href="/tugas_fungsi/<?= $item['id_tugas'] ?>/edit" 
                                                   class="btn btn-light text-primary btn-sm hover-primary" 
                                                   data-bs-toggle="tooltip" 
                                                   data-bs-placement="top"
                                                   title="Edit Data">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/tugas_fungsi/<?= $item['id_tugas'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" 
                                                            class="btn btn-light text-danger btn-sm hover-danger" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top"
                                                            title="Hapus Data">
                                                        <i class="fas fa-trash"></i>
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
                <div class="small text-muted">
                    Menampilkan <?= count($tugas_fungsi) ?> data
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gradient line di atas card */
    .card.rounded-4 {
        border-top: 4px solid #4e73df; /* Sesuaikan dengan warna primary Anda */
    }

    /* Table Styling */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #8898aa;
    }
    
    .table tbody td {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Hover effect pada baris tabel */
    .transition-row {
        transition: all 0.2s ease;
    }
    .transition-row:hover {
        background-color: #f8f9fc;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        z-index: 1;
        position: relative;
    }

    /* Action Buttons Hover */
    .hover-primary:hover {
        background-color: #4e73df !important;
        color: white !important;
    }
    .hover-danger:hover {
        background-color: #e74a3b !important;
        color: white !important;
    }

    /* Button Lift Effect */
    .hover-lift {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }

    /* Input Search Focus */
    .form-control:focus {
        box-shadow: none;
        border-color: #bac8f3;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        border-radius: 0.375rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Simple Client-side Search Script
        const searchInput = document.getElementById('searchInput');
        if(searchInput){
            searchInput.addEventListener('keyup', function() {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#datatablesSimple tbody tr:not(:first-child)'); 
                
                rows.forEach(row => {
                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
<?= $this->endSection() ?>