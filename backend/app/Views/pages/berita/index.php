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
    }

    .gov-table thead {
        background: var(--gray-100);
    }

    .gov-table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .gov-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
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
        border-radius: 8px;
        padding: 4px;
        background: white;
        transition: all 0.2s;
    }

    .img-thumbnail:hover {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    /* Badges */
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
    }

    .bg-success { background-color: var(--success) !important; }
    .bg-secondary { background-color: var(--gray-500) !important; }
    .bg-warning { background-color: var(--warning) !important; color: white !important; }
    .bg-info { background-color: var(--info) !important; color: white !important; }
    .bg-danger { background-color: var(--danger) !important; }

    /* Action Buttons in Table */
    .gov-table .btn {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
    }

    .gov-table .btn-warning { background: var(--warning); color: white; }
    .gov-table .btn-warning:hover { background: #b45309; transform: translateY(-1px); }

    .gov-table .btn-danger { background: var(--danger); color: white; }
    .gov-table .btn-danger:hover { background: #b91c1c; transform: translateY(-1px); }

    .gov-table .btn-info { background: var(--info); color: white; }
    .gov-table .btn-info:hover { background: #0369a1; transform: translateY(-1px); }

    .content-preview {
        max-width: 300px; overflow: hidden; text-overflow: ellipsis;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;
    }

    @media (max-width: 768px) {
        .gov-header { padding: 20px; }
        .gov-header h1 { font-size: 1.375rem; }
        .action-buttons { flex-direction: column; gap: 8px; }
        .action-buttons .btn { width: 100%; }
    }

    .no-data { text-align: center; padding: 60px 20px; color: var(--gray-500); }
    .no-data i { font-size: 4rem; color: var(--gray-300); margin-bottom: 16px; }

    /* Style Toggle Switch */
    .status-btn {
        background: none; border: none; padding: 0;
        display: flex; align-items: center; gap: 8px; cursor: pointer; transition: opacity 0.3s;
    }
    .status-btn:hover { opacity: 0.8; }
    .status-btn:disabled { cursor: not-allowed !important; opacity: 0.4; }

    .status-btn .switch {
        position: relative; width: 42px; height: 22px;
        background-color: #cbd5e1; border-radius: 20px; transition: all 0.3s ease;
    }
    .status-btn .switch::after {
        content: ''; position: absolute; width: 18px; height: 18px;
        background-color: white; border-radius: 50%;
        top: 2px; left: 2px; transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    .status-btn .switch.active { background-color: #059669; }
    .status-btn .switch.active::after { left: 22px; }

    .status-btn .switch-label {
        font-size: 0.8rem; font-weight: 600; color: #334155;
        min-width: 65px; text-align: left;
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
            <div class="col-md-2 mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <label for="limitSelect" class="me-2 small fw-bold text-muted">Tampil:</label>
                    <select id="limitSelect" class="form-select form-select-sm shadow-none border-gray-300" style="width: 80px;">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="-1">Semua</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 shadow-none ps-0" placeholder="Cari Judul, Topik, atau Penulis...">
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
                        <th>Cover</th>
                        <th>Foto Tambahan</th>
                        <th>Judul</th>
                        <th>Topik</th>
                        <th>Konten</th>
                        <th>Konten 2</th>
                        <th>Kategori</th>
                        <th>Tags</th>
                        <th>Tanggal Tayang</th>
                        <th class="text-center">Status Tayang</th>
                        <th class="text-center">Status Berita</th>
                        <th>Dibuat Oleh</th>
                        <th class="text-center">Waktu Dibuat</th>
                        <th>Diupdate Oleh</th>
                        <th class="text-center">Update Terakhir</th>
                        <th>Dilihat</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (empty($berita)): ?>
                        <tr>
                            <td colspan="19">
                                <div class="no-data">
                                    <i class="bi bi-inbox"></i>
                                    <p class="mb-0">Belum ada data berita</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($berita as $i => $row): ?>
                            <?php 
                                // LOGIKA KONDISI
                                $isTayang = ($row['status'] == '1');
                                $isDraft  = ($row['status'] != '1' && $row['status'] != '5');
                            ?>
                            <tr class="data-row">
                                <td class="text-center row-number"><?= $i + 1 ?></td>

                                <td class="text-center">
                                    <?php if (!empty($row['feat_image'])): ?>
                                        <img src="<?= base_url($row['feat_image']) ?>" alt="Cover" class="img-thumbnail" style="width:80px;height:60px;object-fit:cover;">
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
                                            $pathGambar = is_array($img) ? ($img['path'] ?? '') : $img;
                                            $captionTooltip = is_array($img) ? ($img['caption'] ?? '') : '';
                                            if (empty($pathGambar)) continue;
                                            $filePath = FCPATH . ltrim($pathGambar, '/');
                                            if (!file_exists($filePath)) continue;
                                            $hasValidImage = true; 
                                            ?>
                                            <img src="<?= base_url($pathGambar) ?>" alt="Foto Tambahan" title="<?= esc($captionTooltip) ?>" class="img-thumbnail mb-1" style="width:50px;height:40px;object-fit:cover;cursor:help;">
                                        <?php endforeach;
                                        if (!$hasValidImage): ?><span class="text-muted">-</span><?php endif;
                                    else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <td style="min-width: 200px;"><strong class="searchable"><?= esc($row['judul']) ?></strong></td>
                                <td class="searchable"><?= esc($row['topik'] ?? '-') ?></td>
                                <td><div class="content-preview"><?= strip_tags($row['content']) ?></div></td>
                                <td><div class="content-preview"><?= strip_tags($row['content2'] ?? '-') ?></div></td>

                                <td>
                                    <?php if (!empty($row['kategori'])): ?>
                                        <?php foreach ($row['kategori'] as $katName): ?>
                                            <span class="badge bg-secondary me-1 mb-1"><?= esc($katName) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['tags'])): ?>
                                        <?php foreach ($row['tags'] as $tag): ?>
                                            <span class="badge bg-secondary me-1 mb-1"><?= esc($tag) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['tanggal'])): ?>
                                        <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                    <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($row['status'] == '1'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Tayang</span>
                                    <?php elseif ($row['status'] == '5'): ?>
                                        <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Tidak Tayang</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning"><i class="bi bi-clock"></i> Draft</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $statusBerita = [
                                        '0' => ['bg-secondary', 'Draft', 'file-earmark'],
                                        '2' => ['bg-info', 'Menunggu Verifikasi', 'hourglass-split'],
                                        '3' => ['bg-success', 'Perbaikan', 'wrench'],
                                        '4' => ['bg-warning', 'Layak Tayang', 'check-circle'],
                                        '6' => ['bg-danger', 'Revisi', 'arrow-clockwise']
                                    ];
                                    [$class, $text, $icon] = $statusBerita[$row['status_berita']] ?? ['bg-secondary', '-', 'question-circle'];
                                    ?>
                                    <span class="badge <?= $class ?>"><i class="bi bi-<?= $icon ?>"></i> <?= $text ?></span>
                                </td>

                                <td class="searchable"><?= esc($row['created_by_name'] ?? '-') ?></td>
                                <td class="text-center" style="white-space: nowrap;"><?= !empty($row['created_at']) ? date('d M Y H:i', strtotime($row['created_at'])) : '-' ?></td>
                                <td><?= esc($row['updated_by_name'] ?? '-') ?></td>
                                <td class="text-center" style="white-space: nowrap;"><?= !empty($row['updated_at']) ? date('d M Y H:i', strtotime($row['updated_at'])) : '-' ?></td>
                                <td><?= esc($row['hit'] ?? '-') ?></td>
                                
                                <td class="text-center">
                                    <?php if ($isDraft): ?>
                                        <span class="text-muted">-</span>
                                    <?php else: ?>
                                        <button type="button" class="status-btn" 
                                                data-id="<?= $row['id_berita'] ?>" 
                                                data-url="<?= site_url('berita/toggle-status') ?>"> 
                                            <div class="switch <?= ($row['status'] == '1' ? 'active' : '') ?>"></div>
                                            <span class="switch-label"><?= ($row['status'] == '1' ? 'Aktif' : 'Non-Aktif') ?></span>
                                        </button>
                                    <?php endif; ?>
                                </td>
                                
                                <td class="text-center" style="white-space: nowrap;">
                                    <div class="d-flex flex-column gap-1">
                                        <?php if ($isDraft): ?>
                                            <?php if (!empty($can_update)): ?>
                                                <a href="<?= site_url('berita/' . $row['id_berita'] . '/edit') ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                                            <?php endif; ?>

                                            <?php if (!empty($can_delete)): ?>
                                                <form action="<?= site_url('berita/' . $row['id_berita'] . '/delete') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin membuang berita ini ke sampah?')">
                                                        <i class="bi bi-trash"></i> Trash
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                        <?php else: ?>
                                            <?php if (!empty($can_read)): ?>
                                                <a href="<?= site_url('berita/show/' . $row['slug']) ?>" class="btn btn-info"><i class="bi bi-eye"></i> Lihat</a>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($can_update)): ?>
                                                <a href="<?= site_url('berita/' . $row['id_berita'] . '/edit') ?>" class="btn btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                                            <?php endif; ?>

                                            <?php if (!empty($can_delete) && !$isTayang): ?>
                                                <form action="<?= site_url('berita/' . $row['id_berita'] . '/delete') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin membuang berita ini ke sampah?')">
                                                        <i class="bi bi-trash"></i> Trash
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <a href="<?= site_url('berita/' . $row['id_berita'] . '/log') ?>" class="btn btn-info btn-sm"><i class="bi bi-journal-text"></i> Log</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center" id="paginationInfo">
            <small class="text-muted">Menampilkan <span id="showingStart">0</span> - <span id="showingEnd">0</span> dari <span id="totalData">0</span> data</small>
        </div>
    </div>
</div>

<script>
// --- Script Toggle Status ---
$(document).on('click', '.status-btn', function () {
    let btn = $(this);
    let id = btn.data('id');
    let url = btn.data('url'); 
    let switchEl = btn.find('.switch');
    let labelEl = btn.find('.switch-label');
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = $('input[name="'+csrfName+'"]').val(); 

    btn.prop('disabled', true);
    btn.css('opacity', '0.5');

    $.ajax({
        url: url, type: "POST",
        data: { id: id, [csrfName]: csrfHash },
        dataType: "json",
        success: function(res) {
            btn.prop('disabled', false);
            btn.css('opacity', '1');
            if (res.status === 'success') {
                if (res.newStatus == 1) {
                    switchEl.addClass('active'); labelEl.text('Aktif');
                } else {
                    switchEl.removeClass('active'); labelEl.text('Non-Aktif');
                }
                $('input[name="'+csrfName+'"]').val(res.token);
            } else {
                alert('Gagal: ' + res.message);
                if(res.token) $('input[name="'+csrfName+'"]').val(res.token);
            }
        },
        error: function() {
            btn.prop('disabled', false); btn.css('opacity', '1');
            alert('Terjadi kesalahan koneksi ke server.');
        }
    });
});

// --- Script Search & Filter ---
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const limitSelect = document.getElementById('limitSelect');
    const tableBody = document.getElementById('tableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr.data-row'));
    const totalDataSpan = document.getElementById('totalData');
    const showingStartSpan = document.getElementById('showingStart');
    const showingEndSpan = document.getElementById('showingEnd');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const limit = parseInt(limitSelect.value);
        let visibleCount = 0;
        let totalFiltered = 0;

        rows.forEach(row => {
            const textContent = row.textContent.toLowerCase();
            const matchesSearch = textContent.includes(searchTerm);
            
            if (matchesSearch) {
                totalFiltered++;
                if (limit === -1 || visibleCount < limit) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            } else {
                row.style.display = 'none';
            }
        });

        showingStartSpan.textContent = totalFiltered > 0 ? 1 : 0;
        showingEndSpan.textContent = visibleCount;
        totalDataSpan.textContent = totalFiltered;
    }

    searchInput.addEventListener('keyup', filterTable);
    limitSelect.addEventListener('change', filterTable);
    filterTable();
});
</script>

<?= $this->endSection() ?>