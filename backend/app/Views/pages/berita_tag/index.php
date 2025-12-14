<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Tag Berita</h1>
            <p class="text-muted small mb-0">Kelola label atau kategori topik berita.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Tag Berita</li>
        </ol>
    </div>

    <form action="<?= base_url('berita_tag/bulk_delete') ?>" method="POST" id="bulkForm" onsubmit="return confirm('Yakin ingin menghapus data yang dipilih?');">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="DELETE">

        <div class="card shadow border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tags me-2"></i>Daftar Tag
                    </h6>
                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm d-none" id="btn-bulk-delete">
                        <i class="fas fa-trash-alt me-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>
                </div>
                
                <?php if ($can_create ?? true): ?>
                    <a href="<?= site_url('berita_tag/new') ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                        <i class="fas fa-plus me-1"></i> Tambah Tag
                    </a>
                <?php endif; ?>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="dataTable">
                        <thead class="bg-light text-secondary text-uppercase small fw-bold">
                            <tr>
                                <th class="text-center py-3" width="5%">
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="select_all">
                                    </div>
                                </th>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3" width="25%">Nama Tag</th>
                                <th class="py-3" width="20%">Slug</th>
                                <th class="py-3" width="20%">Info Pembuat</th>
                                <th class="text-center py-3" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tags) && is_array($tags)): ?>
                                <?php foreach ($tags as $i => $tag): ?>
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input select-item" type="checkbox" name="ids[]" value="<?= $tag['id_tags'] ?>">
                                            </div>
                                        </td>
                                        
                                        <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                                        
                                        <td>
                                            <span class="fw-bold text-dark"><?= esc($tag['nama_tag']) ?></span>
                                        </td>
                                        
                                        <td>
                                            <code class="text-muted bg-light border rounded px-2 py-1 small"><?= esc($tag['slug']) ?></code>
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex flex-column small">
                                                <span class="fw-bold text-dark">
                                                    <i class="fas fa-user-circle me-1 text-secondary"></i> 
                                                    <?= esc($tag['created_by_name'] ?? 'System') ?>
                                                </span>
                                                <span class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i> 
                                                    <?= !empty($tag['created_at']) ? date('d M Y', strtotime($tag['created_at'])) : '-' ?>
                                                </span>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= site_url('berita_tag/'.$tag['id_tags'].'/edit') ?>" 
                                                   class="btn btn-outline-warning btn-sm rounded-circle shadow-sm"
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Hapus"
                                                        onclick="confirmDelete('<?= site_url('berita_tag/'.$tag['id_tags']) ?>')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted opacity-50 mb-2">
                                            <i class="fas fa-tags fa-3x"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada tag</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan tag baru.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<form id="deleteForm" action="" method="post" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    /* Agar checkbox terlihat lebih jelas */
    .form-check-input { cursor: pointer; }
</style>

<script>
    // 1. Logic Select All
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select_all');
        const items = document.querySelectorAll('.select-item');
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const countSpan = document.getElementById('selected-count');

        // Fungsi update tampilan tombol bulk delete
        function updateBulkButton() {
            const checkedCount = document.querySelectorAll('.select-item:checked').length;
            countSpan.textContent = checkedCount;
            
            if(checkedCount > 0) {
                bulkBtn.classList.remove('d-none');
            } else {
                bulkBtn.classList.add('d-none');
            }
        }

        // Event klik Select All
        if(selectAll) {
            selectAll.addEventListener('change', function() {
                items.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkButton();
            });
        }

        // Event klik per item
        items.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Jika salah satu tidak dicentang, uncheck selectAll
                if(!this.checked) {
                    selectAll.checked = false;
                }
                // Jika semua dicentang manual, check selectAll
                if(document.querySelectorAll('.select-item:checked').length === items.length) {
                    selectAll.checked = true;
                }
                updateBulkButton();
            });
        });

        // 2. Tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // 3. Helper Delete Satuan
    function confirmDelete(url) {
        if(confirm('Apakah Anda yakin ingin menghapus tema ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            form.submit();
        }
    }
</script>

<?= $this->endSection() ?>