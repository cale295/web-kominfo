<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 py-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bolder">Pejabat Struktural</h1>
            <p class="text-muted small mb-0 mt-1">
                <i class="fas fa-sitemap me-1 text-primary"></i>
                Kelola daftar struktur organisasi dan pejabat terkait.
            </p>
        </div>
        <ol class="breadcrumb mb-0 bg-white shadow-sm px-3 py-2 rounded-pill small border">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none fw-bold"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Pejabat Struktural</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden card-hover-effect">
        
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-md-5 col-12">
                    <div class="input-group input-group-sm shadow-sm" style="border-radius: 20px; overflow: hidden;">
                        <span class="input-group-text bg-white border-end-0 ps-3 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari nama atau jabatan...">
                    </div>
                </div>
                
                <div class="col-md-7 col-12 text-md-end text-start">
                    <?php if ($can_create): ?>
                        <a href="<?= base_url('pejabat_struktural/new') ?>" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm hover-lift fw-bold">
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
                            <th class="text-center py-3 border-0" width="15%">Gambar</th>
                            <th class="py-3 border-0" width="40%">Info Struktur</th>
                            <th class="text-center py-3 border-0" width="15%">Status</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th class="text-center py-3 border-0" width="15%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($pejabat_struktural)): ?>
                            <tr>
                                <td colspan="<?= ($can_update || $can_delete) ? 5 : 4 ?>" class="text-center py-5">
                                    <div class="empty-state py-4">
                                        <div class="mb-3 text-muted opacity-25">
                                            <i class="fas fa-sitemap fa-4x"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Data Kosong</h6>
                                        <p class="small text-muted mb-0">Belum ada pejabat struktural yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pejabat_struktural as $index => $item): ?>
                                <tr class="transition-row border-bottom border-light">
                                    <td class="text-center text-muted fw-bold small"><?= $index + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <?php if (!empty($item['image_url'])): ?>
                                            <div class="position-relative d-inline-block rounded-circle overflow-hidden shadow-sm border bg-light" style="width: 50px; height: 50px;">
                                                <img src="<?= base_url('uploads/pejabat_struktural/' . $item['image_url']) ?>" 
                                                     alt="Img" 
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        <?php else: ?>
                                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle text-muted border" style="width: 50px; height: 50px;">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($item['title']) ?></div>
                                        <div class="small text-muted">
                                            <i class="fas fa-id-badge me-1 text-secondary"></i>
                                            <?= esc($item['subtitle']) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($item['id_pejabat_s'], $item['is_active'], 'pejabat_struktural/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <?php if ($can_update): ?>
                                                    <a href="<?= base_url('pejabat_struktural/' . $item['id_pejabat_s'] . '/edit') ?>" 
                                                       class="btn btn-light text-primary btn-sm hover-primary border shadow-sm me-1 rounded" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Data">
                                                        <i class="fas fa-pen fa-xs"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="<?= base_url('pejabat_struktural/' . $item['id_pejabat_s']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                    Menampilkan total <strong><?= count($pejabat_struktural) ?></strong> data
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reuse Styles from Tugas & Fungsi */
    .card-hover-effect { transition: box-shadow 0.3s ease; }
    .card-hover-effect:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important; }

    .transition-row { transition: all 0.2s ease; }
    .transition-row:hover { background-color: #f8f9fc; }

    .hover-primary:hover { background-color: #4e73df !important; color: white !important; border-color: #4e73df !important; }
    .hover-danger:hover { background-color: #e74a3b !important; color: white !important; border-color: #e74a3b !important; }

    .hover-lift { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }

    .form-control:focus { box-shadow: none; border-color: #bac8f3; }
    .input-group:focus-within { box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25) !important; border-color: #bac8f3; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Client-side Search Script
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
    });
</script>
<?= $this->endSection() ?>