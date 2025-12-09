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

    /* --- GAYA FILTER NAVIGATION --- */
    .filter-nav {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--gray-100);
        flex-wrap: wrap;
    }

    .filter-btn {
        background: var(--gray-100);
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-btn:hover {
        background: var(--gray-200);
        color: var(--gray-900);
    }

    .filter-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 2px 4px rgba(30, 64, 175, 0.2);
    }
    
    .filter-count {
        background: rgba(255,255,255,0.2);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
    }
    .filter-btn:not(.active) .filter-count {
        background: var(--gray-300);
        color: white;
    }

    /* Action Buttons */
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
        color: white;
    }

    .action-buttons .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
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

    /* Banner Image */
    .banner-image {
        width: 100px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .banner-image:hover {
        border-color: var(--primary);
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
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

    /* Banner Title */
    .banner-title {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.9375rem;
    }

    /* URL Link */
    .url-link {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }

    .url-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .url-link i {
        font-size: 1rem;
    }

    /* User Info */
    .user-info {
        font-size: 0.875rem;
    }

    .user-name {
        font-weight: 500;
        color: var(--gray-900);
    }

    .user-date {
        color: var(--gray-500);
        font-size: 0.75rem;
        margin-top: 2px;
    }

    /* Action Buttons in Table */
    .gov-table .btn {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
    }

    .gov-table .btn-warning {
        background: var(--warning);
        color: white;
    }

    .gov-table .btn-warning:hover {
        background: #b45309;
        transform: translateY(-1px);
    }

    .gov-table .btn-danger {
        background: var(--danger);
        color: white;
    }

    .gov-table .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }

    /* Image Modal */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
    }

    .image-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .image-modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        animation: zoomIn 0.3s ease;
    }

    .image-modal-content img {
        width: 100%;
        height: auto;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .modal-close {
        position: absolute;
        top: -50px;
        right: 0;
        color: white;
        font-size: 2rem;
        font-weight: bold;
        cursor: pointer;
        background: var(--danger);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s;
        border: 2px solid white;
    }

    .modal-close:hover {
        background: #b91c1c;
        transform: rotate(90deg) scale(1.1);
    }

    /* Empty State */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-500);
    }

    .no-data i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 16px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* --- SWITCH TOGGLE STATUS --- */
    .status-btn {
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .status-btn:hover {
        opacity: 0.8;
    }

    .status-btn .switch {
        position: relative;
        width: 42px;
        height: 22px;
        background-color: var(--gray-300);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .status-btn .switch::after {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        background-color: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    .status-btn .switch.active {
        background-color: var(--success);
    }

    .status-btn .switch.active::after {
        left: 22px;
    }

    .status-btn .switch-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--gray-700);
        min-width: 65px;
        text-align: left;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gov-header { padding: 20px; }
        .gov-header h1 { font-size: 1.375rem; }
        .filter-nav { gap: 8px; overflow-x: auto; padding-bottom: 5px; flex-wrap: nowrap; }
        .filter-btn { white-space: nowrap; }
        .gov-table thead th, .gov-table tbody td { padding: 10px 12px; font-size: 0.8125rem; }
        .action-buttons { flex-direction: column; gap: 8px; }
        .action-buttons .btn { width: 100%; }
        .banner-image { width: 80px; height: 50px; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-card-image"></i>
                Daftar Banner
            </h1>
        </div>
        <div class="action-buttons d-flex gap-2">
            <a href="<?= site_url('banner/new') ?>" id="btnAddBanner" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Banner
            </a>
        </div>
    </div>

    <div class="filter-nav">
        <button class="filter-btn active" onclick="filterTable('all', this)">
            <i class="bi bi-grid"></i> Semua
        </button>
        <button class="filter-btn" onclick="filterTable('1', this)">
            <i class="bi bi-house"></i> Banner Utama
        </button>
        <button class="filter-btn" onclick="filterTable('2', this)">
            <i class="bi bi-window"></i> Banner Popup
        </button>
        <button class="filter-btn" onclick="filterTable('3', this)">
            <i class="bi bi-newspaper"></i> Banner Berita
        </button>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<?php if (!empty($banners) && is_array($banners)): ?>
    <div class="card table-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table gov-table mb-0" id="bannerTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th style="min-width: 180px;">Judul</th>
                            <th class="text-center" style="width: 130px;">Kategori</th>
                            <th class="text-center" style="width: 100px;">Media</th>
                            <th class="text-center" style="width: 130px;">Gambar</th>
                            <th style="min-width: 150px;">URL</th>
                            <th class="text-center" style="width: 80px;">Sorting</th>
                            <th style="min-width: 140px;">Dibuat Oleh</th>
                            <th style="min-width: 140px;">Diperbarui</th>
                            <th class="text-center" style="min-width: 140px;">Toggle Status</th>
                            <th class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($banners as $b): ?>
                            <tr class="banner-row" data-category="<?= $b['category_banner'] ?>">
                                <td class="text-center">
                                    <strong><?= $no++ ?></strong>
                                </td>
                                <td>
                                    <div class="banner-title"><?= esc($b['title']) ?></div>
                                </td>
                                <td class="text-center">
                                    <?php
                                        $kategori = [
                                            1 => ['nama' => 'Banner Utama', 'class' => 'bg-info'],
                                            2 => ['nama' => 'Banner Popup', 'class' => 'bg-warning'],
                                            3 => ['nama' => 'Banner Berita', 'class' => 'bg-success']
                                        ];
                                        $kat = $kategori[$b['category_banner']] ?? ['nama' => '-', 'class' => 'bg-secondary'];
                                    ?>
                                    <span class="badge <?= $kat['class'] ?>"><?= $kat['nama'] ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($b['media_type'])): ?>
                                        <span class="badge bg-info">
                                            <i class="bi bi-film"></i> <?= esc($b['media_type']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($b['image'])): ?>
                                        <img 
                                            src="<?= base_url('uploads/banner/' . $b['image']) ?>" 
                                            alt="Banner" 
                                            class="banner-image"
                                            onclick="openImageModal(this.src, '<?= esc(addslashes($b['title'])) ?>')"
                                            title="Klik untuk memperbesar">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($b['url'])): ?>
                                        <a href="<?= esc($b['url']) ?>" target="_blank" class="url-link" title="<?= esc($b['url']) ?>">
                                            <i class="bi bi-link-45deg"></i>
                                            <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block;">
                                                <?= esc($b['url']) ?>
                                            </span>
                                        </a>
                                    <?php elseif (!empty($b['url_yt'])): ?>
                                        <a href="<?= esc($b['url_yt']) ?>" target="_blank" class="url-link">
                                            <i class="bi bi-youtube"></i> YouTube
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary"><?= esc($b['sorting'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name"><?= esc($b['created_by_name'] ?? '-') ?></div>
                                        <div class="user-date">
                                            <?= esc($b['created_at'] ? date('d/m/Y H:i', strtotime($b['created_at'])) : '-') ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-name"><?= esc($b['updated_by_name'] ?? '-') ?></div>
                                        <div class="user-date">
                                            <?= esc($b['updated_at'] ? date('d/m/Y H:i', strtotime($b['updated_at'])) : '-') ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="status-btn" 
                                            data-id="<?= $b['id_banner'] ?>">
                                        <div class="switch <?= ($b['status'] == '1' ? 'active' : '') ?>"></div>
                                        <span class="switch-label">
                                            <?= ($b['status'] == '1' ? 'Aktif' : 'Non-Aktif') ?>
                                        </span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-1">
                                        <a href="<?= site_url('banner/' . $b['id_banner'] . '/edit') ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit Banner">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="<?= site_url('banner/'.$b['id_banner']) ?>" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <?= csrf_field() ?>
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm w-100" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus banner ini?')"
                                                    title="Hapus Banner">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr id="noRowsMessage" style="display: none;">
                            <td colspan="12" class="text-center py-5 text-muted">
                                <i class="bi bi-filter-circle" style="font-size: 2rem;"></i>
                                <p class="mt-2">Tidak ada banner di kategori ini.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="card table-card">
        <div class="card-body">
            <div class="no-data">
                <i class="bi bi-inbox"></i>
                <p class="mb-0">Belum ada data banner</p>
            </div>
        </div>
    </div>
<?php endif; ?>

<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <div class="image-modal-content" onclick="event.stopPropagation()">
        <span class="modal-close" onclick="closeImageModal()" title="Tutup">&times;</span>
        <img id="modalImage" src="" alt="Preview">
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// --- MODIFIKASI 2: LOGIC FILTER TABLE ---
function filterTable(category, btnElement) {
    // 1. Update status tombol aktif
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    btnElement.classList.add('active');

    // 2. Filter Baris Tabel
    const rows = document.querySelectorAll('.banner-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const rowCat = row.getAttribute('data-category');
        if (category === 'all' || rowCat === category) {
            row.style.display = ''; // Tampilkan
            visibleCount++;
        } else {
            row.style.display = 'none'; // Sembunyikan
        }
    });

    // 3. Tampilkan pesan jika kosong
    const noMsg = document.getElementById('noRowsMessage');
    if (visibleCount === 0) {
        noMsg.style.display = '';
    } else {
        noMsg.style.display = 'none';
    }

    // 4. Update Link Tombol Tambah Banner (BAGIAN PENTING)
    const btnAdd = document.getElementById('btnAddBanner');
    const baseUrl = "<?= site_url('banner/new') ?>";

    if (category !== 'all') {
        btnAdd.href = baseUrl + "?kategori=" + category;
    } else {
        btnAdd.href = baseUrl;
    }
}

// Logic Modal Gambar
function openImageModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    
    modal.classList.add('show');
    modalImg.src = imageSrc;
    modalImg.alt = imageName;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// Logic Toggle Status
$(document).on('click', '.status-btn', function () {
    let btn = $(this);
    let id = btn.data('id');
    let switchEl = btn.find('.switch');
    let labelEl = btn.find('.switch-label');
    
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    btn.css('opacity', '0.6').prop('disabled', true);

    $.ajax({
        url: "<?= site_url('banner/toggle-status') ?>",
        type: "POST",
        data: { 
            id: id,
            [csrfName]: csrfHash 
        },
        dataType: "json",
        success: function(res) {
            btn.css('opacity', '1').prop('disabled', false);

            if (res.status === 'success') {
                if (res.token) {
                    csrfHash = res.token;
                    $('input[name="' + csrfName + '"]').val(csrfHash);
                }

                if (res.newStatus == 1) {
                    switchEl.addClass('active');
                    labelEl.text('Aktif');
                    $('.status-badge-' + id).removeClass('bg-secondary').addClass('bg-success').html('<i class="bi bi-check-circle"></i> Publish');
                } else {
                    switchEl.removeClass('active');
                    labelEl.text('Non-Aktif');
                    $('.status-badge-' + id).removeClass('bg-success').addClass('bg-secondary').html('<i class="bi bi-x-circle"></i> Unpublish');
                }
            } else {
                alert('Gagal: ' + (res.message || 'Terjadi kesalahan'));
            }
        },
        error: function(xhr, status, error) {
            btn.css('opacity', '1').prop('disabled', false);
            console.error(error);
            alert('Gagal menghubungi server.');
        }
    });
});
</script>

<?= $this->endSection() ?>