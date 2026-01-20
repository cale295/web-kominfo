<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --success: #059669;
        --warning: #d97706;
        --info: #0284c7;
        --danger: #dc2626;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    body {
        background-color: var(--gray-50);
    }

    /* Header Styles */
    .gov-header {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        border: 1px solid var(--gray-200);
        border-left: 4px solid var(--primary);
    }

    .gov-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .gov-header h1 i {
        color: var(--primary);
        margin-right: 10px;
    }

    .action-buttons .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .action-buttons .btn-primary {
        background: var(--primary);
        border: none;
    }

    .action-buttons .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .action-buttons .btn-secondary {
        background: var(--gray-600);
        border: none;
    }

    .action-buttons .btn-secondary:hover {
        background: var(--gray-700);
        transform: translateY(-2px);
    }

    /* Table Card */
    .table-card {
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
    }

    /* Custom Table */
    .gov-table {
        margin: 0;
        font-size: 0.85rem;
    }

    .gov-table thead {
        background: var(--gray-100);
    }

    .gov-table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        padding: 12px 10px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .gov-table tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.8rem;
    }

    .gov-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .gov-table tbody tr:hover {
        background-color: var(--gray-50);
    }

    /* Image Thumbnails */
    .img-thumbnail {
        border: 2px solid var(--gray-200);
        border-radius: 6px;
        padding: 3px;
        background: white;
        transition: all 0.2s;
        width: 70px !important;
        height: 55px !important;
        object-fit: cover;
    }

    .img-thumbnail:hover {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    /* Badges */
    .badge {
        padding: 4px 8px;
        font-weight: 500;
        border-radius: 4px;
        font-size: 0.7rem;
        letter-spacing: 0.3px;
        display: inline-block;
        margin-bottom: 2px;
    }

    .bg-success { background-color: var(--success) !important; }
    .bg-secondary { background-color: var(--gray-500) !important; }
    .bg-warning { background-color: var(--warning) !important; color: white !important; }
    .bg-info { background-color: var(--info) !important; color: white !important; }
    .bg-danger { background-color: var(--danger) !important; }

    /* Action Buttons in Table */
    .gov-table .btn {
        font-size: 0.7rem;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
        width: 100%;
        margin-bottom: 3px;
    }

    .gov-table .btn-warning { background: var(--warning); color: white; }
    .gov-table .btn-warning:hover { background: #b45309; transform: translateY(-1px); }

    .gov-table .btn-danger { background: var(--danger); color: white; }
    .gov-table .btn-danger:hover { background: #b91c1c; transform: translateY(-1px); }

    .gov-table .btn-info { background: var(--info); color: white; }
    .gov-table .btn-info:hover { background: #0369a1; transform: translateY(-1px); }

    .content-preview {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 1.4;
        font-size: 0.8rem;
    }

    /* Compact Date Cells */
    .compact-date {
        font-size: 0.75rem;
        white-space: nowrap;
    }

    /* Status Toggle */
.status-btn {
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        outline: none;
    }
    
    .status-btn .switch {
        position: relative;
        width: 36px;
        height: 20px;
        background-color: #cbd5e1;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .status-btn .switch::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        background-color: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    
    .status-btn .switch.active {
        background-color: #059669;
    }
    
    .status-btn .switch.active::after {
        left: 18px;
    }
    
    .status-btn .switch-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #334155;
        min-width: 60px;
        text-align: left;
    }
    
    /* Disabled state for status button */
    .status-btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gov-header { padding: 16px; }
        .gov-header h1 { font-size: 1.25rem; }
        .action-buttons { flex-direction: column; gap: 8px; }
        .action-buttons .btn { width: 100%; }
        .gov-table { font-size: 0.8rem; }
        .content-preview { max-width: 150px; }
    }

    .no-data {
        text-align: center;
        padding: 40px 20px;
        color: var(--gray-500);
    }
    
    .no-data i {
        font-size: 3rem;
        color: var(--gray-300);
        margin-bottom: 12px;
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background-color: var(--gray-50);
        border-top: 1px solid var(--gray-200);
    }

    .pagination-info {
        font-size: 0.85rem;
        color: var(--gray-600);
    }

    .pagination-controls {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .page-info {
        font-size: 0.85rem;
        color: var(--gray-600);
        margin: 0 10px;
    }

    .pagination-controls .btn {
        padding: 6px 12px;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    .pagination-controls .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-input {
        width: 60px;
        text-align: center;
        font-size: 0.85rem;
        padding: 4px 8px;
        border: 1px solid var(--gray-300);
        border-radius: 4px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1><i class="bi bi-newspaper"></i> Daftar Berita</h1>
        </div>
        <div class="action-buttons d-flex gap-2">
            <?php if (!empty($can_create)): ?>
                <a href="<?= site_url('berita/new') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Berita
                </a>
            <?php endif; ?>
            <a href="<?= site_url('berita/trash') ?>" class="btn btn-secondary">
                <i class="bi bi-trash"></i> Sampah
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<div class="card mb-3 shadow-sm border-0">
    <div class="card-body py-3">
        <div class="row align-items-center">
            <div class="col-md-3 col-lg-2 mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <label for="limitSelect" class="me-2 small fw-bold text-muted">Tampil:</label>
                    <select id="limitSelect" class="form-select form-select-sm shadow-none border-gray-300" style="width: 90px;">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="-1">Semua</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5 col-lg-6"></div>
            <div class="col-md-4 col-lg-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 shadow-none ps-0" placeholder="Cari Judul, atau Penulis...">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table gov-table mb-0" id="beritaTable">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Cover</th>
                        <th class="text-center">Foto</th>
                        <th>Judul</th>
                        <th>Konten</th>
                        <th>Kategori</th>
                        <th>Tags</th>
                        <th class="text-center">Status Berita</th>
                        <th class="text-center">Dibuat</th>
                        <th class="text-center">Dilihat</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                        
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (empty($berita)): ?>
                        <tr>
                            <td colspan="12">
                                <div class="no-data">
                                    <i class="bi bi-inbox"></i>
                                    <p class="mb-0">Belum ada data berita</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
<?php foreach ($berita as $i => $row): ?>
                    <?php 
                        // ===========================================
                        // LOGIKA PERMISSION FINAL
                        // ===========================================
                        
                        $currentRole   = session()->get('role'); 
                        $currentUserId = session()->get('id_user');
                        
                        // 1. Setting Default (Untuk Admin)
                        // Admin ikut settingan controller ($can_update)
                        $allowEdit   = !empty($can_update);
                        $allowDelete = !empty($can_delete) && ($row['status'] != '1'); 
                        $isLayakTayang = ($row['status_berita'] == '4');
                        $disableToggle = false;

                        // 2. Setting Khusus EDITOR
                        if ($currentRole == 'editor') {
                            // A. Matikan dulu semua izin editor (Default: Dilarang)
                            $allowEdit   = false; 
                            $allowDelete = false;
                            $disableToggle = true; // Editor tidak boleh publish langsung

                            // B. Cek Kepemilikan (Apakah ini berita buatannya?)
                            $authorId = $row['created_by_id'] ?? $row['created_by'] ?? $row['id_user'] ?? null;
                            
                            if ($authorId == $currentUserId) {
                                // C. Cek Status Berita
                                // 0 = Draft
                                // 3 = Perbaikan
                                // 6 = Revisi
                                // Jika statusnya salah satu di atas => IZINKAN EDIT
                                if (in_array($row['status_berita'], ['0', '3', '6'])) {
                                    $allowEdit   = true;
                                    $allowDelete = true;
                                }
                                // Catatan: Jika status '2' (Verifikasi) atau '4' (Layak Tayang),
                                // maka kode masuk ke 'else' (tidak melakukan apa-apa), 
                                // sehingga $allowEdit tetap FALSE.
                            }
                        }

                        // 3. Logika Toggle untuk Non-Editor (Admin)
                        if (!$isLayakTayang && $currentRole != 'editor') {
                            $disableToggle = true;
                        }
                    ?>

                    <tr class="data-row">
                                <td class="text-center row-number"><?= $i + 1 ?></td>

                                <td class="text-center">
                                    <?php if (!empty($row['feat_image'])): ?>
                                        <img src="<?= base_url($row['feat_image']) ?>" alt="Cover" class="img-thumbnail">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $additional = !empty($row['additional_images']) ? json_decode($row['additional_images'], true) : [];
                                    $hasValidImage = false;
                                    if (!empty($additional)):
                                        foreach ($additional as $img):
                                            if (!$hasValidImage): // Hanya tampilkan satu gambar pertama
                                                $pathGambar = is_array($img) ? ($img['path'] ?? '') : $img;
                                                $captionTooltip = is_array($img) ? ($img['caption'] ?? '') : '';
                                                if (!empty($pathGambar)):
                                                    $filePath = FCPATH . ltrim($pathGambar, '/');
                                                    if (file_exists($filePath)):
                                                        $hasValidImage = true;
                                                    ?>
                                                    <img src="<?= base_url($pathGambar) ?>" alt="Foto" title="<?= esc($captionTooltip) ?>" class="img-thumbnail">
                                                    <?php endif;
                                                endif;
                                            endif;
                                        endforeach;
                                    endif;
                                    if (!$hasValidImage): ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td style="min-width: 180px;">
                                    <strong class="searchable"><?= esc($row['judul']) ?></strong>
                                </td>


                                <td>
                                    <div class="content-preview" title="<?= strip_tags($row['content']) ?>">
                                        <?= strip_tags(mb_substr($row['content'], 0, 100)) ?>...
                                    </div>
                                </td>

                                <td style="min-width: 120px;">
                                    <?php if (!empty($row['kategori'])): ?>
                                        <?php 
                                        $displayCount = 0;
                                        foreach ($row['kategori'] as $katName):
                                            if ($displayCount < 2): ?>
                                                <span class="badge bg-secondary d-block mb-1"><?= esc($katName) ?></span>
                                                <?php 
                                                $displayCount++;
                                            endif;
                                        endforeach;
                                        if (count($row['kategori']) > 2): ?>
                                            <small class="text-muted">+<?= count($row['kategori']) - 2 ?> lainnya</small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if (!empty($row['tags'])): ?>
                                        <?php 
                                        $displayCount = 0;
                                        foreach ($row['tags'] as $tagName):
                                            if ($displayCount < 2): ?>
                                                <span class="badge bg-secondary d-block mb-1"><?= esc($tagName) ?></span>
                                                <?php 
                                                $displayCount++;
                                            endif;
                                        endforeach;
                                        if (count($row['tags']) > 2): ?>
                                            <small class="text-muted">+<?= count($row['tags']) - 2 ?> lainnya</small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>



                                <td class="text-center">
                                    <?php
                                    $statusBerita = [
                                        '0' => ['bg-secondary', 'Draft'],
                                        '2' => ['bg-info', 'Verifikasi'],
                                        '3' => ['bg-success', 'Perbaikan'],
                                        '4' => ['bg-warning', 'Layak Tayang'],
                                        '6' => ['bg-danger', 'Revisi']
                                    ];
                                    [$class, $text] = $statusBerita[$row['status_berita']] ?? ['bg-secondary', '-'];
                                    ?>
                                    <span class="badge <?= $class ?>"><?= $text ?></span>
                                </td>

                                <td class="text-center compact-date">
                                    <?= !empty($row['created_at']) ? date('d/m/y', strtotime($row['created_at'])) : '-' ?>
                                </td>

                            <td style="min-width: 180px;">
                                    <strong class="searchable"><?= esc($row['hit']) ?></strong>
                                </td>

                                
                                
                                <td class="text-center">
                                    <button type="button" class="status-btn" 
                                            data-id="<?= $row['id_berita'] ?>" 
                                            data-url="<?= site_url('berita/toggle-status') ?>"
                                            <?= $disableToggle ? 'disabled' : '' ?>
                                            title="<?= $currentRole == 'editor' ? 'Editor tidak memiliki akses publish' : (!$isLayakTayang ? 'Status belum Layak Tayang' : '') ?>">
                                        <div class="switch <?= ($row['status'] == '1' ? 'active' : '') ?>"></div>
                                        <span class="switch-label"><?= ($row['status'] == '1' ? 'Aktif' : 'Non-Aktif') ?></span>
                                    </button>
                                </td>
                                
                                <td class="text-center" style="min-width: 110px;">
                                    <div class="d-flex flex-column gap-1">
                                        <?php if (!empty($can_read)): ?>
                                            <a href="<?= site_url('berita/show/' . $row['slug']) ?>" class="btn btn-info btn-sm py-1" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php 
                                        // Tampilkan Tombol Edit jika Permission $allowEdit TRUE
                                        if ($allowEdit): 
                                        ?>
                                            <a href="<?= site_url('berita/' . $row['id_berita'] . '/edit') ?>" class="btn btn-warning btn-sm py-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php 
                                        // Tampilkan Tombol Hapus jika Permission $allowDelete TRUE
                                        if ($allowDelete): 
                                        ?>
                                            <form action="<?= site_url('berita/' . $row['id_berita'] . '/delete') ?>" method="post" class="d-inline delete-form">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger btn-sm py-1 w-100" 
                                                        onclick="return confirm('Yakin membuang berita ini ke sampah?')"
                                                        title="Pindah ke Sampah">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <a href="<?= site_url('berita/' . $row['id_berita'] . '/log') ?>" class="btn btn-info btn-sm py-1" title="Log Aktivitas">
                                            <i class="bi bi-journal-text"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            <div class="pagination-info">
                Menampilkan <span id="showingStart">0</span> - <span id="showingEnd">0</span> dari <span id="totalData">0</span> data
            </div>
            
            <div class="pagination-controls">
                <button id="firstPage" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-chevron-double-left"></i>
                </button>
                <button id="prevPage" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-chevron-left"></i>
                </button>
                
                <span class="page-info">
                    Halaman <input type="number" id="currentPageInput" class="page-input" value="1" min="1"> dari <span id="totalPages">1</span>
                </span>
                
                <button id="nextPage" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-chevron-right"></i>
                </button>
                <button id="lastPage" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. GLOBAL VARIABLES & CSRF HANDLING
    // ==========================================
    // Simpan token saat ini di variable global agar bisa diupdate via AJAX
    let currentCsrfName = '<?= csrf_token() ?>';
    let currentCsrfHash = '<?= csrf_hash() ?>';

    // Fungsi helper untuk update token di semua form input yang ada di halaman
    function updateAllCsrfInputs(newHash) {
        currentCsrfHash = newHash;
        document.querySelectorAll('input[name="' + currentCsrfName + '"]').forEach(el => {
            el.value = newHash;
        });
    }

    // ==========================================
    // 2. BAGIAN PAGINATION & SEARCH
    // ==========================================
    
    // Elements
    const searchInput = document.getElementById('searchInput');
    const limitSelect = document.getElementById('limitSelect');
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody ? Array.from(tableBody.querySelectorAll('tr.data-row')) : [];
    
    // Pagination elements
    const showingStartSpan = document.getElementById('showingStart');
    const showingEndSpan = document.getElementById('showingEnd');
    const totalDataSpan = document.getElementById('totalData');
    const totalPagesSpan = document.getElementById('totalPages');
    const currentPageInput = document.getElementById('currentPageInput');
    
    // Button elements
    const firstPageBtn = document.getElementById('firstPage');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const lastPageBtn = document.getElementById('lastPage');
    
    // State
    let currentPage = 1;
    let currentLimit = 10;
    let currentSearch = '';
    let totalFilteredRows = 0;
    let totalPages = 1;
    
    if(rows.length > 0) {
        initTable();
    }

    // Search Logic
    if(searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearch = this.value.toLowerCase();
            currentPage = 1;
            if(currentPageInput) currentPageInput.value = 1;
            filterAndPaginate();
        });
    }
    
    // Limit Logic
    if(limitSelect) {
        limitSelect.addEventListener('change', function() {
            currentLimit = this.value === '-1' ? rows.length : parseInt(this.value);
            currentPage = 1;
            if(currentPageInput) currentPageInput.value = 1;
            filterAndPaginate();
        });
    }
    
    // Pagination Button Clicks
    function addClick(elem, fn) { if(elem) elem.addEventListener('click', fn); }

    addClick(firstPageBtn, () => changePage(1));
    addClick(prevPageBtn, () => changePage(currentPage - 1));
    addClick(nextPageBtn, () => changePage(currentPage + 1));
    addClick(lastPageBtn, () => changePage(totalPages));
    
    if(currentPageInput) {
        currentPageInput.addEventListener('change', function() {
            changePage(parseInt(this.value));
        });
    }

    function changePage(newPage) {
        if (newPage < 1) newPage = 1;
        if (newPage > totalPages) newPage = totalPages;
        currentPage = newPage;
        if(currentPageInput) currentPageInput.value = newPage;
        filterAndPaginate();
    }
    
    function initTable() {
        limitSelect.value = '10';
        currentLimit = 10;
        rows.forEach((row, index) => {
            row.style.display = '';
            row.dataset.index = index;
        });
        filterAndPaginate();
    }
    
    function filterAndPaginate() {
        const filteredRows = rows.filter(row => {
            if (currentSearch === '') return true;
            // Cari hanya di elemen yang punya class 'searchable' atau text content umum
            const textContent = row.textContent.toLowerCase();
            return textContent.includes(currentSearch);
        });
        
        totalFilteredRows = filteredRows.length;
        
        if (currentLimit === -1) {
            totalPages = 1;
            currentPage = 1;
        } else {
            totalPages = Math.ceil(totalFilteredRows / currentLimit);
            if (totalPages === 0) totalPages = 1;
            if (currentPage > totalPages) {
                currentPage = totalPages;
                if(currentPageInput) currentPageInput.value = currentPage;
            }
        }
        
        updatePaginationInfo();
        updatePaginationButtons();
        
        rows.forEach(row => row.style.display = 'none');
        
        let displayRows = [];
        if (currentLimit === -1) {
            displayRows = filteredRows;
        } else {
            const startIndex = (currentPage - 1) * currentLimit;
            const endIndex = startIndex + currentLimit;
            displayRows = filteredRows.slice(startIndex, endIndex);
        }

        displayRows.forEach((row, index) => {
            row.style.display = '';
            // Update nomor urut
            const rowNum = (currentLimit === -1) ? (index + 1) : ((currentPage - 1) * currentLimit + index + 1);
            const rowNumberCell = row.querySelector('.row-number');
            if (rowNumberCell) rowNumberCell.textContent = rowNum;
        });
        
        const noDataRow = tableBody.querySelector('tr:not(.data-row)');
        if (noDataRow) {
            noDataRow.style.display = totalFilteredRows === 0 ? '' : 'none';
        }
    }
    
    function updatePaginationInfo() {
        if(!showingStartSpan) return;
        if (totalFilteredRows === 0) {
            showingStartSpan.textContent = '0';
            showingEndSpan.textContent = '0';
            totalDataSpan.textContent = '0';
            totalPagesSpan.textContent = '1';
            return;
        }
        
        let start, end;
        if (currentLimit === -1) {
            start = 1;
            end = totalFilteredRows;
        } else {
            start = (currentPage - 1) * currentLimit + 1;
            end = Math.min(currentPage * currentLimit, totalFilteredRows);
        }
        
        showingStartSpan.textContent = start;
        showingEndSpan.textContent = end;
        totalDataSpan.textContent = totalFilteredRows;
        totalPagesSpan.textContent = totalPages;
    }
    
    function updatePaginationButtons() {
        if(!prevPageBtn) return;
        firstPageBtn.disabled = currentPage === 1;
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
        lastPageBtn.disabled = currentPage === totalPages;
    }

    // ==========================================
// 3. TOGGLE STATUS (Publish/Unpublish) - FIXED
// ==========================================
const statusBtns = document.querySelectorAll('.status-btn');

statusBtns.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Cek jika disabled (misal role Editor)
        if(this.hasAttribute('disabled')) return;
        
        const id = this.dataset.id;
        const url = this.dataset.url;
        const switchEl = this.querySelector('.switch');
        const labelEl = this.querySelector('.switch-label');
        const row = this.closest('tr');
        const statusBadgeCell = row.querySelector('.status-badge-cell');
        
        // Konfirmasi sebelum toggle (opsional tapi direkomendasikan)
        const currentStatus = switchEl.classList.contains('active') ? 'Aktif' : 'Non-Aktif';
        const newStatus = currentStatus === 'Aktif' ? 'Non-Aktif' : 'Aktif';
        
        if(!confirm(`Ubah status dari ${currentStatus} ke ${newStatus}?`)) {
            return;
        }
        
        // Loading state
        this.style.opacity = '0.5';
        this.disabled = true;
        
        // Buat FormData untuk mengirim data
        const formData = new FormData();
        formData.append('id', id);
        formData.append(currentCsrfName, currentCsrfHash);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            // Cek apakah response OK
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            this.style.opacity = '1';
            this.disabled = false;
            
            // Update CSRF token
            if(data.token && data.tokenName) {
                currentCsrfHash = data.token;
                currentCsrfName = data.tokenName;
                updateAllCsrfInputs(data.token);
            }
            
            if (data.status === 'success') {
                // Update Switch UI
                if (data.new_status == '1') {
                    switchEl.classList.add('active');
                    labelEl.textContent = 'Aktif';
                    if(statusBadgeCell) {
                        statusBadgeCell.innerHTML = '<span class="badge bg-success">Tayang</span>';
                    }
                } else {
                    switchEl.classList.remove('active');
                    labelEl.textContent = 'Non-Aktif';
                    if(statusBadgeCell) {
                        statusBadgeCell.innerHTML = '<span class="badge bg-secondary">Tidak Tayang</span>';
                    }
                }
                
                // Optional: Tampilkan notifikasi sukses
                showNotification('success', data.message || 'Status berhasil diubah');
            } else {
                alert('Gagal mengubah status: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            this.style.opacity = '1';
            this.disabled = false;
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        });
    });
});

// Helper function untuk notifikasi (opsional)
function showNotification(type, message) {
    // Bisa menggunakan toast library atau alert sederhana
    console.log(`[${type.toUpperCase()}] ${message}`);
    // Atau gunakan alert jika tidak ada toast library
    // alert(message);
}
});
</script>
<?= $this->endSection() ?>