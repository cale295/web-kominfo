<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Kategori Berita</h1>
            <p class="text-muted small mb-0">Kelola pengelompokan konten berita dan artikel.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kategori</li>
        </ol>
    </div>

    <form action="<?= base_url('kategori/bulk_delete') ?>" method="POST" id="bulkForm" onsubmit="return confirm('Yakin ingin menghapus data yang dipilih?');">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="DELETE">

        <div class="card shadow border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list-alt me-2"></i>Daftar Kategori
                    </h6>
                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm d-none" id="btn-bulk-delete">
                        <i class="fas fa-trash-alt me-1"></i> Hapus (<span id="selected-count">0</span>)
                    </button>
                </div>
                
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="fas fa-plus me-1"></i> Tambah Kategori
                </button>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary text-uppercase small fw-bold">
                            <tr>
                                <th class="text-center py-3" width="5%">
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="select_all">
                                    </div>
                                </th>
                                <th class="text-center py-3" width="5%">No</th>
                                <th class="py-3" width="20%">Nama Kategori</th>
                                <th class="text-center py-3" width="10%">Tampil Nav</th>
                                <th class="text-center py-3" width="10%">Urutan</th>
                                <th class="py-3" width="15%">Info Waktu</th>
                                <th class="text-center py-3" width="10%">Status</th>
                                <th class="text-center py-3" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kategori)): ?>
                                <?php foreach ($kategori as $i => $row): ?>
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input select-item" type="checkbox" name="ids[]" value="<?= $row['id_kategori'] ?>">
                                            </div>
                                        </td>

                                        <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                                        
                                        <td>
                                            <div class="fw-bold text-dark"><?= esc($row['kategori']) ?></div>
                                            <div class="small text-muted text-truncate" style="max-width: 250px;">
                                                <?= esc($row['keterangan']) ?>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <?php if ($row['is_show_nav'] == '1'): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill">
                                                    <i class="fas fa-check me-1"></i> Ya
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-secondary border rounded-pill">Tidak</span>
                                            <?php endif ?>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border"><?= $row['sorting_nav'] ?? '-' ?></span>
                                        </td>

                                        <td>
                                            <div class="d-flex flex-column small">
                                                <span class="text-muted">
                                                    <i class="far fa-clock me-1"></i> Cre: <?= date('d/m/y', strtotime($row['created_on'])) ?>
                                                </span>
                                                <?php if($row['modified_on']): ?>
                                                <span class="text-muted">
                                                    <i class="fas fa-pencil-alt me-1" style="font-size: 0.7em;"></i> Upd: <?= date('d/m/y', strtotime($row['modified_on'])) ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <?= btn_toggle($row['id_kategori'], $row['status'], 'kategori/toggle-status') ?>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button type="button"
                                                   class="btn btn-outline-warning btn-sm rounded-circle shadow-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit"
                                                   onclick='openEditModal(<?= json_encode($row) ?>)'>
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>

                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Hapus"
                                                        onclick="confirmDelete('<?= site_url('kategori/'.$row['id_kategori']) ?>')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted opacity-50 mb-2">
                                            <i class="fas fa-list-alt fa-3x"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada kategori</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan data baru.</p>
                                    </td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCreateLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= site_url('kategori') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Politik, Ekonomi, Olahraga" required autofocus>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Deskripsi singkat kategori (opsional)"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tampilkan di Navigasi?</label>
                            <select name="is_show_nav" class="form-select">
                                <option value="0" selected>Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            <small class="text-muted">Apakah kategori ini ditampilkan di menu navigasi?</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Urutan Navigasi</label>
                            <input type="number" name="sorting_nav" class="form-control" placeholder="Contoh: 1, 2, 3" min="0">
                            <small class="text-muted">Urutan tampilan di menu (angka kecil = lebih dulu)</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditLabel">
                    <i class="fas fa-edit me-2"></i>Edit Kategori
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kategori" id="edit_kategori" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tampilkan di Navigasi?</label>
                            <select name="is_show_nav" id="edit_is_show_nav" class="form-select">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Urutan Navigasi</label>
                            <input type="number" name="sorting_nav" id="edit_sorting_nav" class="form-control" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form untuk delete satuan -->
<form id="deleteSingleForm" action="" method="post" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    .form-check-input { cursor: pointer; }
    
    /* Modal animations */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }
    
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
    }
    
    .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. TOOLTIP INIT ---
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // --- 2. SELECT ALL & BULK DELETE LOGIC ---
        const selectAll = document.getElementById('select_all');
        const items = document.querySelectorAll('.select-item');
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const countSpan = document.getElementById('selected-count');

        function updateBulkButton() {
            const checkedCount = document.querySelectorAll('.select-item:checked').length;
            countSpan.textContent = checkedCount;
            if(checkedCount > 0) {
                bulkBtn.classList.remove('d-none');
            } else {
                bulkBtn.classList.add('d-none');
            }
        }

        if(selectAll) {
            selectAll.addEventListener('change', function() {
                items.forEach(checkbox => checkbox.checked = this.checked);
                updateBulkButton();
            });
        }

        items.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if(!this.checked) selectAll.checked = false;
                if(document.querySelectorAll('.select-item:checked').length === items.length) selectAll.checked = true;
                updateBulkButton();
            });
        });

        // --- 3. TOGGLE STATUS AJAX LOGIC ---
        const toggles = document.querySelectorAll('.form-check-input[type="checkbox"]:not(.select-item):not(#select_all)');
        const base_url = "<?= base_url() ?>";

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const url = this.dataset.url;
                const isChecked = this.checked ? 1 : 0; 
                
                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = '<?= csrf_hash() ?>';

                let formData = new FormData();
                formData.append('id', id);
                formData.append('status', isChecked);
                formData.append(csrfName, csrfHash);

                fetch(base_url + '/' + url, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Status updated');
                    } else {
                        alert('Gagal update: ' + (data.message || 'Error'));
                        this.checked = !isChecked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !isChecked;
                });
            });
        });

        // --- 4. AUTO-SHOW MODAL JIKA ADA ERROR ---
        <?php if (session()->get('errors') || session()->getFlashdata('error')): ?>
            <?php if (isset($kategori) && isset($kategori['id_kategori'])): ?>
                // Jika ada data kategori, berarti dari edit
                openEditModal(<?= json_encode($kategori) ?>);
            <?php else: ?>
                // Jika tidak ada data kategori, berarti dari create
                var modalCreate = new bootstrap.Modal(document.getElementById('modalCreate'));
                modalCreate.show();
            <?php endif; ?>
        <?php endif; ?>
    });

    // --- 5. FUNCTION OPEN EDIT MODAL ---
    function openEditModal(data) {
        document.getElementById('edit_kategori').value = data.kategori || '';
        document.getElementById('edit_keterangan').value = data.keterangan || '';
        document.getElementById('edit_status').value = data.status || '1';
        document.getElementById('edit_is_show_nav').value = data.is_show_nav || '0';
        document.getElementById('edit_sorting_nav').value = data.sorting_nav || '';
        
        document.getElementById('formEdit').action = '<?= site_url('kategori/') ?>' + data.id_kategori;
        
        var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        modalEdit.show();
    }

    // --- 6. HELPER DELETE SATUAN ---
    function confirmDelete(url) {
        if(confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            const form = document.getElementById('deleteSingleForm');
            form.action = url;
            form.submit();
        }
    }

    // --- 7. RESET FORM KETIKA MODAL DITUTUP ---
    document.getElementById('modalCreate').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
    });

    document.getElementById('modalEdit').addEventListener('hidden.bs.modal', function () {
        this.querySelector('form').reset();
    });
</script>

<?= $this->endSection() ?>