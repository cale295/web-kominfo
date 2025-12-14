<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 py-4">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bolder">Tugas & Fungsi</h1>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-info-circle me-1 text-primary"></i>
                Kelola data tugas pokok dan fungsi organisasi secara terstruktur.
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
                        <a href="/tugas_fungsi/new" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm hover-lift fw-bold">
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
                                        <p class="mb-0 text-secondary small lh-sm text-wrap" style="max-height: 100px; overflow-y: auto;">
                                            <?= nl2br(esc(strip_tags($item['description']))) ?>
                                        </p>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($item['id_tugas'], $item['is_active'], 'tugas_fungsi/toggle-status') ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <?php if (isset($can_update) && $can_update): ?>
                                                <a href="/tugas_fungsi/<?= $item['id_tugas'] ?>/edit" 
                                                   class="btn btn-light text-primary btn-sm hover-primary border shadow-sm me-1 rounded" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit Data">
                                                    <i class="fas fa-pen fa-xs"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (isset($can_delete) && $can_delete): ?>
                                                <form action="/tugas_fungsi/<?= $item['id_tugas'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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

<style>
    /* Styling Tambahan */
    .card-hover-effect {
        transition: box-shadow 0.3s ease;
    }
    .card-hover-effect:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }

    /* Hover effect pada baris tabel */
    .transition-row {
        transition: all 0.2s ease;
    }
    .transition-row:hover {
        background-color: #f8f9fc;
    }

    /* Action Buttons Hover */
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
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25) !important;
        border-color: #bac8f3;
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
                // Select rows (skip header)
                let rows = document.querySelectorAll('#datatablesSimple tbody tr'); 
                
                rows.forEach(row => {
                    // Cek jika baris adalah 'empty state'
                    if(row.querySelector('.empty-state')) return;

                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
<?= $this->endSection() ?>