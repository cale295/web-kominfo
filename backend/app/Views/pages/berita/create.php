<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
<style>
    /* --- VARIABLES --- */
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

    /* --- HEADER --- */
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

    /* --- FORM CARD --- */
    .form-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 32px;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
    }

    .section-title i {
        color: var(--primary);
        margin-right: 10px;
        font-size: 1.25rem;
    }

    /* --- INPUTS --- */
    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 8px;
        font-size: 0.875rem;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 0.9375rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .text-danger {
        color: var(--danger) !important;
    }

    small.text-muted {
        color: var(--gray-500);
        font-size: 0.8125rem;
        margin-top: 6px;
        display: block;
    }

    /* --- DROPDOWN KATEGORI & CUSTOM --- */
    .dropdown-toggle-custom {
        cursor: pointer;
        text-align: left;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
    }

    .dropdown-toggle-custom[disabled] {
        background-color: var(--gray-100);
        cursor: not-allowed;
        opacity: 0.7;
    }

    .dropdown-menu-custom {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Style untuk Item Dropdown Berita (Gambar + Teks) */
    .news-item-option {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid var(--gray-100);
        cursor: pointer;
        transition: background 0.2s;
    }

    .news-item-option:hover {
        background-color: var(--gray-50);
    }

    .news-item-option.active {
        background-color: #eff6ff;
        border-left: 3px solid var(--primary);
    }

    .news-item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 12px;
        flex-shrink: 0;
        background: #eee;
    }

    .news-item-content {
        flex-grow: 1;
        min-width: 0;
    }

    .news-item-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--gray-800);
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .news-item-date {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    /* Kategori styles */
    .kategori-list .form-check {
        cursor: pointer;
        border-radius: 6px;
        margin: 5px 20px;
    }

    .form-check-input {
        margin-right: 10px;
        outline: 1px solid black;
    }

    .kategori-list .form-check:hover {
        background-color: var(--gray-50);
    }

    .tags-list .form-check {
        cursor: pointer;
        border-radius: 6px;
        margin: 5px 20px;
    }

    .tags-list .form-check:hover {
        background-color: var(--gray-50);
    }

    .selected-badge {
        display: inline-flex;
        align-items: center;
        background: var(--primary);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.8125rem;
        margin: 2px 6px 2px 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .selected-badge i {
        margin-left: 6px;
        font-size: 0.75rem;
        cursor: pointer;
        opacity: 0.8;
    }

    .kategori-item {
        display: flex;
        align-items: center;
    }

    /* --- IMAGE PREVIEW & TEMP --- */
    .preview-container {
        margin-top: 16px;
    }

    .preview-img {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.2s;
    }

    .additional-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .additional-preview img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
    }

    .temp-image-badge {
        display: inline-block;
        background: var(--info);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        margin-top: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .btn-delete-new-img {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 38, 38, 0.9);
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: 0.2s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-delete-new-img:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .preview-card-wrapper {
        position: relative;
    }

    /* --- QUILL EDITOR --- */
    .ql-toolbar-custom {
        background: var(--gray-50);
        border: 1px solid var(--gray-300) !important;
        border-radius: 8px 8px 0 0;
        padding: 12px;
    }

    .ql-container {
        border: 1px solid var(--gray-300) !important;
        border-radius: 0 0 8px 8px;
        font-size: 0.9375rem;
    }

    .ql-editor {
        min-height: 250px;
        font-size: 0.9375rem;
        color: var(--gray-800);
    }

    /* --- ACTION BUTTONS --- */
    .action-buttons {
        padding-top: 24px;
        border-top: 2px solid var(--gray-200);
        margin-top: 32px;
    }

    .btn {
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
    }

    .btn-primary {
        background: var(--primary);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    .btn-secondary {
        background: var(--gray-600);
    }

    .btn-secondary:hover {
        background: var(--gray-700);
        transform: translateY(-2px);
    }

    .form-section {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid var(--gray-100);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* --- SISIPAN BOX STYLE --- */
    .sisipan-box {
        background: #eff6ff;
        border: 1px dashed #3b82f6;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            margin: 4px 0 !important;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?=
$oldContent1 = old('content', '');
$oldContent2 = old('content2', '');
// Sanitasi HTML
$oldContent1 = htmlspecialchars_decode($oldContent1, ENT_QUOTES);
$oldContent2 = htmlspecialchars_decode($oldContent2, ENT_QUOTES);
?>

<div class="gov-header">
    <h1><i class="bi bi-file-earmark-plus"></i> Tambah Berita Baru</h1>
</div>

<?= $this->include('layouts/alerts') ?>

<div class="form-card">
    <form action="<?= site_url('berita') ?>" method="post" enctype="multipart/form-data" id="form-berita">
        <?= csrf_field() ?>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-info-circle"></i> Informasi Dasar</div>

            <div class="mb-3">
                <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul berita yang menarik" value="<?= old('judul') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Intro Singkat</label>
                <textarea name="intro" class="form-control" rows="3" placeholder="Deskripsi singkat yang menarik pembaca"><?= old('intro') ?></textarea>
                <small class="text-muted">Ringkasan singkat yang akan ditampilkan di preview berita</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber Berita</label>
                <input type="text" name="sumber" class="form-control" placeholder="Contoh: Kompas.com" value="<?= old('sumber') ?>">
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-file-text"></i> Konten & Struktur Berita</div>

            <div class="mb-4">
                <label class="form-label">Isi Berita 1 <span class="text-danger">*</span></label>
                <div id="toolbar-content" class="ql-toolbar-custom">
                    <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button><button class="ql-strike"></button>
                    <select class="ql-header">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option selected></option>
                    </select>
                    <button class="ql-list" value="ordered"></button><button class="ql-list" value="bullet"></button>
                    <button class="ql-link"></button><button class="ql-image"></button><button class="ql-clean"></button>
                </div>
                <div id="editor-content" class="ql-container ql-snow">
                    <div class="ql-editor" data-placeholder="Tulis isi berita di sini..."></div>
                </div>
                <textarea name="content" id="content-hidden" style="display:none;"></textarea>

            </div>

            <div class="d-flex align-items-center mb-3 mt-5 p-3 bg-gray-50 border rounded">
<div class="form-check form-switch m-0">
    <input class="form-check-input" type="checkbox" role="switch" id="toggle-content2"
        <?= (old('has_content2') == '1' || !empty($oldContent2)) ? 'checked' : '' ?>>
    <label class="form-check-label fw-bold" for="toggle-content2">Tambah Halaman/Bagian Kedua (Isi Berita 2 & Sisipan)</label>
</div>
<input type="hidden" name="has_content2" id="has-content2-val" value="<?= (old('has_content2') == '1' || !empty($oldContent2)) ? '1' : '0' ?>">
            </div>

            <div class="sisipan-box mb-4" id="box-sisipan-1" style="display: none;">
                <label class="form-label d-flex align-items-center">
                    <i class="bi bi-paperclip me-2"></i> Berita Sisipan 1 (Baca Juga)
                </label>

                <div class="dropdown custom-img-select" id="sisipan1-wrapper">
                    <input type="hidden" name="id_berita_terkait" id="sisipan1-input" value="<?= old('id_berita_terkait') ?>">

                    <button class="form-select dropdown-toggle-custom" type="button" id="sisipan1-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <span id="sisipan1-label" class="text-muted">-- Pilih Berita Sisipan --</span>
                    </button>

                    <div class="dropdown-menu w-100 p-0 shadow border dropdown-menu-custom">
                        <div class="p-2 border-bottom sticky-top bg-white">
                            <input type="text" class="form-control form-control-sm" id="sisipan1-search" placeholder="Cari berita...">
                        </div>
                        <div id="sisipan1-list">
                            <div class="news-item-option" onclick="selectSisipan('sisipan1', '', 'No Sisipan', '', '')">
                                <div class="news-item-content text-center text-muted">-- Tidak Ada Sisipan --</div>
                            </div>
                            <?php foreach ($beritaAll as $b):
                                $gambarDB = $b['feat_image'];
                                if (empty($gambarDB)) {
                                    $imgSrc = 'https://via.placeholder.com/60?text=IMG';
                                } elseif (strpos($gambarDB, 'http') === 0) {
                                    $imgSrc = $gambarDB;
                                } elseif (strpos($gambarDB, 'uploads/') !== false) {
                                    $imgSrc = base_url($gambarDB);
                                } else {
                                    $imgSrc = base_url('uploads/' . $gambarDB);
                                }

                                $tgl = isset($b['tanggal']) ? date('d M Y', strtotime($b['tanggal'])) : '-';
                                $judulSafe = addslashes(esc($b['judul']));
                            ?>
                                <div class="news-item-option" data-search="<?= strtolower(esc($b['judul'])) ?>"
                                    onclick="selectSisipan('sisipan1', '<?= $b['id_berita'] ?>', '<?= $judulSafe ?>', '<?= $imgSrc ?>', '<?= $tgl ?>')">
                                    <img src="<?= $imgSrc ?>" class="news-item-img" onerror="this.src='https://via.placeholder.com/60?text=Error'">
                                    <div class="news-item-content">
                                        <div class="news-item-title"><?= esc($b['judul']) ?></div>
                                        <div class="news-item-date"><i class="bi bi-calendar3"></i> <?= $tgl ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="sisipan1-noresult" class="p-3 text-center text-muted" style="display:none;">Tidak ditemukan</div>
                    </div>
                </div>

                <small class="text-muted mt-2">Berita ini akan muncul disisipkan setelah paragraf akhir Berita 1.</small>
            </div>

            <div id="wrapper-content2" style="display: none;">
                <div class="mb-4 ps-3 border-start border-3 border-info">
                    <label class="form-label">Isi Berita 2</label>
                    <div id="toolbar-content2" class="ql-toolbar-custom">
                        <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button><button class="ql-strike"></button>
                        <select class="ql-header">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option selected></option>
                        </select>
                        <button class="ql-list" value="ordered"></button><button class="ql-list" value="bullet"></button>
                        <button class="ql-link"></button><button class="ql-image"></button><button class="ql-clean"></button>
                    </div>
                    <div id="editor-content2" class="ql-container ql-snow">
                        <div class="ql-editor" data-placeholder="Tulis isi berita bagian kedua di sini..."></div>
                    </div>
                    <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>

                    <div class="sisipan-box mt-3">
                        <label class="form-label d-flex align-items-center">
                            <i class="bi bi-paperclip me-2"></i> Berita Sisipan 2 (Baca Juga)
                        </label>

                        <div class="dropdown custom-img-select" id="sisipan2-wrapper">
                            <input type="hidden" name="id_berita_terkait2" id="sisipan2-input" value="<?= old('id_berita_terkait2') ?>">

                            <button class="form-select dropdown-toggle-custom" type="button" id="sisipan2-btn" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                <span id="sisipan2-label" class="text-muted">-- Pilih Sisipan 1 Terlebih Dahulu --</span>
                            </button>

                            <div class="dropdown-menu w-100 p-0 shadow border dropdown-menu-custom">
                                <div class="p-2 border-bottom sticky-top bg-white">
                                    <input type="text" class="form-control form-control-sm" id="sisipan2-search" placeholder="Cari berita...">
                                </div>
                                <div id="sisipan2-list">
                                    <div class="news-item-option" onclick="selectSisipan('sisipan2', '', 'No Sisipan', '', '')">
                                        <div class="news-item-content text-center text-muted">-- Tidak Ada Sisipan --</div>
                                    </div>
                                    <?php foreach ($beritaAll as $b):
                                        $gambarDB = $b['feat_image'];
                                        if (empty($gambarDB)) {
                                            $imgSrc = 'https://via.placeholder.com/60?text=IMG';
                                        } elseif (strpos($gambarDB, 'http') === 0) {
                                            $imgSrc = $gambarDB;
                                        } elseif (strpos($gambarDB, 'uploads/') !== false) {
                                            $imgSrc = base_url($gambarDB);
                                        } else {
                                            $imgSrc = base_url('uploads/' . $gambarDB);
                                        }

                                        $tgl = isset($b['tanggal']) ? date('d M Y', strtotime($b['tanggal'])) : '-';
                                        $judulSafe = addslashes(esc($b['judul']));
                                    ?>
                                        <div class="news-item-option" data-search="<?= strtolower(esc($b['judul'])) ?>"
                                            onclick="selectSisipan('sisipan2', '<?= $b['id_berita'] ?>', '<?= $judulSafe ?>', '<?= $imgSrc ?>', '<?= $tgl ?>')">
                                            <img src="<?= $imgSrc ?>" class="news-item-img" onerror="this.src='https://via.placeholder.com/60?text=Error'">
                                            <div class="news-item-content">
                                                <div class="news-item-title"><?= esc($b['judul']) ?></div>
                                                <div class="news-item-date"><i class="bi bi-calendar3"></i> <?= $tgl ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div id="sisipan2-noresult" class="p-3 text-center text-muted" style="display:none;">Tidak ditemukan</div>
                            </div>
                        </div>

                        <small class="text-muted mt-2">Berita ini akan muncul disisipkan setelah paragraf akhir Berita 2.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-tags"></i> Kategori & Klasifikasi</div>

            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <div class="dropdown" id="kategori-dropdown">
                    <button type="button" class="form-select text-start d-flex align-items-center pe-3" id="kategori-toggle" aria-haspopup="true" aria-expanded="false">
                        <span id="kategori-placeholder">Pilih minimal 1 kategori</span>
                        <i class="ms-auto bi bi-chevron-down text-gray-500"></i>
                    </button>
                    <div class="dropdown-menu w-100 p-0 shadow border" style="max-height: 320px; overflow: hidden; z-index: 1000;">
                        <div class="px-3 py-2 border-bottom">
                            <div class="input-group">
                                <span class="input-group-text bg-gray-100 border-gray-300"><i class="bi bi-search text-gray-500"></i></span>
                                <input type="text" class="form-control border-gray-300" id="kategori-search" placeholder="Cari kategori..." autocomplete="off">
                            </div>
                        </div>
                        <div class="kategori-list px-2 py-1" style="max-height: 240px; overflow-y: auto;">
                            <?php
                            $oldKategori = old('id_kategori', []);
                            if (!is_array($oldKategori)) $oldKategori = explode(',', $oldKategori);
                            ?>
                            <?php foreach ($kategori as $kat): ?>
                                <div class="form-check ps-3 py-1 kategori-item" data-name="<?= esc(strtolower($kat['kategori'])) ?>">
                                    <input class="form-check-input kategori-checkbox" type="checkbox"
                                        id="kat-<?= $kat['id_kategori'] ?>" value="<?= $kat['id_kategori'] ?>"
                                        <?= in_array($kat['id_kategori'], $oldKategori) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="kat-<?= $kat['id_kategori'] ?>"><?= esc($kat['kategori']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="kategori-no-results" class="px-3 py-2 text-center text-gray-500" style="display: none;">
                            <small>Tidak ada kategori yang cocok</small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_kategori" id="kategori-hidden" value="<?= implode(',', $oldKategori) ?>">
                <div id="selected-kategori-badges" class="mt-2 d-flex flex-wrap"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tags</label>
                <div class="dropdown" id="tags-dropdown">
                    <button type="button" class="form-select text-start d-flex align-items-center pe-3" id="tags-toggle" aria-haspopup="true" aria-expanded="false">
                        <span id="tags-placeholder">Pilih tags (opsional)</span>
                        <i class="ms-auto bi bi-chevron-down text-gray-500"></i>
                    </button>
                    <div class="dropdown-menu w-100 p-0 shadow border" style="max-height: 320px; overflow: hidden; z-index: 1000;">
                        <div class="px-3 py-2 border-bottom">
                            <div class="input-group">
                                <span class="input-group-text bg-gray-100 border-gray-300"><i class="bi bi-search text-gray-500"></i></span>
                                <input type="text" class="form-control border-gray-300" id="tags-search" placeholder="Cari tags..." autocomplete="off">
                            </div>
                        </div>
                        <div class="tags-list px-2 py-1" style="max-height: 240px; overflow-y: auto;">
                            <?php
                            $oldTags = old('id_tags', []);
                            if (!is_array($oldTags)) $oldTags = !empty($oldTags) ? explode(',', $oldTags) : [];
                            ?>
                            <?php foreach ($tags as $tag): ?>
                                <div class="form-check ps-3 py-1 tags-item" data-name="<?= esc(strtolower($tag['nama_tag'])) ?>">
                                    <input class="form-check-input tags-checkbox" type="checkbox"
                                        id="tag-<?= $tag['id_tags'] ?>" value="<?= $tag['id_tags'] ?>"
                                        <?= in_array($tag['id_tags'], $oldTags) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="tag-<?= $tag['id_tags'] ?>"><?= esc($tag['nama_tag']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="tags-no-results" class="px-3 py-2 text-center text-gray-500" style="display: none;">
                            <small>Tidak ada tags yang cocok</small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_tags" id="tags-hidden" value="<?= implode(',', $oldTags) ?>">
                <div id="selected-tags-badges" class="mt-2 d-flex flex-wrap"></div>
            </div>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-images"></i> Media & Gambar</div>

            <div class="mb-4">
                <label class="form-label">Foto Cover (Utama) <span class="text-danger">*</span></label>
                <input type="file" name="feat_image" class="form-control" accept="image/*" id="cover-image" <?= empty($tempCoverImage) ? 'required' : '' ?>>
                <small class="text-muted">Format: JPG, PNG, GIF (Maksimal 2MB)</small>

                <div id="cover-preview" class="preview-container">
                    <?php if (!empty($tempCoverImage)): ?>
                        <div class="position-relative d-inline-block mt-3">
                            <img src="<?= base_url('uploads/temp/' . $tempCoverImage) ?>" class="preview-img" alt="Preview Cover">
                            <div class="temp-image-badge"><i class="bi bi-clock-history"></i> Gambar Sebelumnya</div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-2">
                    <label class="form-label text-muted small">Caption Cover:</label>
                    <input type="text" name="caption_cover" class="form-control"
                        placeholder="Tulis keterangan untuk foto cover..."
                        value="<?= old('caption_cover') ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Foto Tambahan</label>
                <input type="file" name="additional_images[]" class="form-control" accept="image/*" id="additional-images" multiple>
                <small class="text-muted">Pilih beberapa foto. Caption akan muncul di bawah setiap foto.</small>

                <?php if (!empty($tempAdditionalImages) && is_array($tempAdditionalImages)):
                    $oldCaptions = old('caption_additional', []);
                ?>
                    <div class="row mt-3">
<?php foreach ($tempAdditionalImages as $index => $tempImage): ?>
    <div class="col-md-4 mb-3" id="temp-img-card-<?= $index ?>">
        <input type="hidden" name="temp_uploaded_files[]" value="<?= esc($tempImage) ?>">
        
        <div class="card h-100 border-info shadow-sm">
            <div class="position-relative">
                <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                
                <div class="temp-image-badge position-absolute top-0 start-0 m-1">
                    <i class="bi bi-clock-history"></i> Temp
                </div>

                <button type="button" class="btn-delete-new-img" onclick="removeTempImage('temp-img-card-<?= $index ?>')">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <div class="card-body p-2 bg-light">
                <input type="text" name="caption_additional_temp[]" class="form-control form-control-sm"
                    placeholder="Caption foto ini..."
                    value="<?= isset($oldCaptions[$index]) ? esc($oldCaptions[$index]) : '' ?>">
            </div>
        </div>
    </div>
<?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div id="additional-preview-new" class="row mt-3"></div>
            </div>

        <div class="mb-3">
            <label class="form-label">Waktu Publish</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                <input type="text" id="datetime-picker" name="tanggal" class="form-control bg-white"
                    placeholder="Pilih tanggal dan jam..."
                    value="<?= old('tanggal') ?>">
            </div>
        </div>

        <input type="hidden" name="status" value="0">
        <input type="hidden" name="status_berita" value="2">

         <div class="action-buttons d-flex justify-content-end gap-2">
    <a href="<?= site_url('berita') ?>" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>

    <?php $role = session()->get('role'); ?>
    <?php if ($role == 'editor') : ?>
    <button type="submit" name="submit_type" value="pending" class="btn btn-warning text-white fw-semibold">
        <i class="bi bi-hourglass-split"></i> Ajukan Verifikasi
    </button>
    <?php endif; ?>

    <button type="submit" name="submit_type" value="draft" class="btn btn-warning text-white">
        <i class="bi bi-file-earmark-text"></i> Simpan Draft
    </button>
    <?php $role = session()->get('role'); ?>
    <?php if ($role == 'admin' || $role == 'superadmin') : ?>
        <button type="submit" name="submit_type" value="publish" class="btn btn-primary">
            <i class="bi bi-send"></i> Publikasikan
        </button>
    <?php endif; ?>
</div>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// ============================================================
// GLOBAL FUNCTION UNTUK MEMILIH SISIPAN (Harus di luar DOMContentLoaded)
// ============================================================
function selectSisipan(prefix, id, judul, img, tgl) {
    // 1. Set Value ke Hidden Input
    document.getElementById(prefix + '-input').value = id;

    // 2. Update Label Tombol Trigger
    const label = document.getElementById(prefix + '-label');
    if (id) {
        label.innerHTML = `
            <div class="d-flex align-items-center">
                <img src="${img}" style="width:30px; height:30px; object-fit:cover; border-radius:4px; margin-right:8px;">
                <div class="text-truncate" style="max-width: 200px; font-weight:600;">${judul}</div>
            </div>
        `;
        label.classList.remove('text-muted');
    } else {
        // Jika batal memilih, kembalikan text default
        label.innerHTML = '-- Pilih Berita Sisipan --';
        label.classList.add('text-muted');
    }

    // 3. Highlight Item di List
    const items = document.querySelectorAll(`#${prefix}-list .news-item-option`);
    items.forEach(el => el.classList.remove('active'));

    if (id) {
        items.forEach(el => {
            if (el.getAttribute('onclick') && el.getAttribute('onclick').includes(`'${id}'`)) {
                el.classList.add('active');
            }
        });
    }

    // 4. LOGIKA DEPENDENCY: SISIPAN 1 MENGONTROL SISIPAN 2
    if (prefix === 'sisipan1') {
        const sisipan2Btn = document.getElementById('sisipan2-btn');
        const sisipan2Label = document.getElementById('sisipan2-label');

        if (id) {
            // Jika Sisipan 1 dipilih, enable Sisipan 2
            sisipan2Btn.removeAttribute('disabled');
            if (sisipan2Label.innerText === '-- Pilih Sisipan 1 Terlebih Dahulu --') {
                sisipan2Label.innerText = '-- Pilih Berita Sisipan --';
            }
        } else {
            // Jika Sisipan 1 dikosongkan, disable Sisipan 2
            sisipan2Btn.setAttribute('disabled', 'true');
            
            // Reset nilai Sisipan 2
            selectSisipan('sisipan2', '', 'No Sisipan', '', '');
            sisipan2Label.innerText = '-- Pilih Sisipan 1 Terlebih Dahulu --';
        }
    }
}

// Global function to uncheck from badge x
function uncheck(type, id) {
    const cb = document.getElementById((type === 'kategori' ? 'kat-' : 'tag-') + id);
    if (cb) {
        cb.checked = false;
        // Trigger change event
        const event = new Event('change');
        cb.dispatchEvent(event);
    }
}

// Global function untuk delete additional image preview
function deleteAdditionalPreview(index) {
    const preview = document.getElementById('additional-preview-' + index);
    if (preview) {
        preview.remove();
    }
    
    // Update file input - remove the deleted file
    const input = document.getElementById('additional-images');
    const dt = new DataTransfer();
    const files = input.files;
    
    for (let i = 0; i < files.length; i++) {
        if (i !== index) {
            dt.items.add(files[i]);
        }
    }
    
    input.files = dt.files;
    
    // Reindex remaining previews
    const allPreviews = document.querySelectorAll('[id^="additional-preview-"]');
    allPreviews.forEach((preview, idx) => {
        preview.id = 'additional-preview-' + idx;
        const deleteBtn = preview.querySelector('.btn-delete-new-img');
        if (deleteBtn) {
            deleteBtn.setAttribute('onclick', `deleteAdditionalPreview(${idx})`);
        }
    });
}

function removeTempImage(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        // Hapus elemen dari DOM
        element.remove();
    }
}
// Function Inisialisasi Pencarian Sisipan
function initSisipanSearch(prefix) {
    const searchInput = document.getElementById(prefix + '-search');
    const listContainer = document.getElementById(prefix + '-list');
    const noResult = document.getElementById(prefix + '-noresult');
    const items = listContainer.querySelectorAll('.news-item-option');

    searchInput.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        let visibleCount = 0;

        items.forEach(item => {
            if (item.innerText.includes('-- Tidak Ada Sisipan --')) {
                item.style.display = 'flex';
                return;
            }

            const searchText = item.getAttribute('data-search');
            if (searchText && searchText.includes(term)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (visibleCount === 0 && term !== '') {
            noResult.style.display = 'block';
        } else {
            noResult.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    

    // 1. Init Quill Editors
    var quill1 = new Quill('#editor-content', {
        theme: 'snow',
        modules: {
            toolbar: '#toolbar-content'
        }
    });

    var quill2 = new Quill('#editor-content2', {
        theme: 'snow',
        modules: {
            toolbar: '#toolbar-content2'
        }
    });

    // Load old content if exists
    var oldContent1 = <?= json_encode($oldContent1) ?>;
    if (oldContent1) quill1.root.innerHTML = oldContent1;

    var oldContent2 = <?= json_encode($oldContent2) ?>;
    if (oldContent2) quill2.root.innerHTML = oldContent2;

    // Sync to textarea on submit
    var form = document.getElementById('form-berita');
    form.onsubmit = function() {
        document.getElementById('content-hidden').value = quill1.root.innerHTML;
        document.getElementById('content2-hidden').value = quill2.root.innerHTML;
    };

    // 2. Init Flatpickr
    flatpickr("#datetime-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        locale: "id",
        allowInput: true
    });

    // 3. Init Sisipan Search
    initSisipanSearch('sisipan1');
    initSisipanSearch('sisipan2');

    // 4. Toggle Content 2 & SISIPAN 1 Logic
    const toggle = document.getElementById('toggle-content2');
    const wrapper = document.getElementById('wrapper-content2');
    const boxSisipan1 = document.getElementById('box-sisipan-1');
    const hasContent2Val = document.getElementById('has-content2-val');

    function updateToggleState() {
        if (toggle.checked) {
            wrapper.style.display = 'block';
            boxSisipan1.style.display = 'block';
            hasContent2Val.value = '1';
        } else {
            wrapper.style.display = 'none';
            boxSisipan1.style.display = 'none';
            hasContent2Val.value = '0';
        }
    }

    toggle.addEventListener('change', updateToggleState);
    updateToggleState(); // Run on load

    // 5. Check Initial Dependency State for Sisipan 2
    const sisipan1Val = document.getElementById('sisipan1-input').value;
    const sisipan2Btn = document.getElementById('sisipan2-btn');
    if (sisipan1Val) {
        sisipan2Btn.removeAttribute('disabled');
        const sisipan2Label = document.getElementById('sisipan2-label');
        if (sisipan2Label.innerText.includes('Terlebih Dahulu')) {
            sisipan2Label.innerText = '-- Pilih Berita Sisipan --';
        }
    }

    // 6. Kategori & Tags Dropdown Logic
    setupDropdownSearch('kategori');
    setupDropdownSearch('tags');

    function setupDropdownSearch(type) {
        const toggleBtn = document.getElementById(type + '-toggle');
        const dropdownMenu = toggleBtn.nextElementSibling;
        const searchInput = document.getElementById(type + '-search');
        const checkboxes = document.querySelectorAll('.' + type + '-checkbox');
        const badgeContainer = document.getElementById('selected-' + type + '-badges');
        const hiddenInput = document.getElementById(type + '-hidden');
        const placeholder = document.getElementById(type + '-placeholder');
        const noResults = document.getElementById(type + '-no-results');

        // Toggle dropdown
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = dropdownMenu.classList.contains('show');
            
            // Close all others
            document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));

            if (!isOpen) {
                dropdownMenu.classList.add('show');
                searchInput.focus();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!toggleBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });

        // Prevent dropdown close when clicking inside
        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Search functionality
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            let visibleCount = 0;
            const items = dropdownMenu.querySelectorAll('.' + type + '-item');

            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name && name.includes(term)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });

        // Checkbox change & badge update
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBadges);
        });

        function updateBadges() {
            badgeContainer.innerHTML = '';
            const selectedIds = [];
            let count = 0;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selectedIds.push(cb.value);
                    const label = cb.nextElementSibling.innerText;

                    const badge = document.createElement('span');
                    badge.className = 'selected-badge';
                    badge.innerHTML = `${label} <i class="bi bi-x" onclick="uncheck('${type}', '${cb.value}')"></i>`;
                    badgeContainer.appendChild(badge);
                    count++;
                }
            });

            hiddenInput.value = selectedIds.join(',');

            if (count > 0) {
                placeholder.innerText = count + ' ' + type + ' terpilih';
                placeholder.classList.add('text-primary', 'fw-bold');
            } else {
                placeholder.innerText = type === 'kategori' ? 'Pilih minimal 1 kategori' : 'Pilih tags (opsional)';
                placeholder.classList.remove('text-primary', 'fw-bold');
            }
        }

        // Run once on load
        updateBadges();
    }

    // 7. Image Preview Logic - Cover Image
    const coverInput = document.getElementById('cover-image');
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cover-preview').innerHTML = `
                    <div class="mt-3">
                        <img src="${e.target.result}" class="preview-img" alt="Preview Cover">
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        }
    });

    // 8. Image Preview Logic - Additional Images dengan Caption & Tombol Delete
    const additionalInput = document.getElementById('additional-images');
    additionalInput.addEventListener('change', function(e) {
        const container = document.getElementById('additional-preview-new');
        container.innerHTML = '';
        
        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                col.id = 'additional-preview-' + index;
                col.innerHTML = `
                    <div class="card h-100 border shadow-sm preview-card-wrapper">
                        <button type="button" class="btn-delete-new-img" onclick="deleteAdditionalPreview(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                        <img src="${ev.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview ${index + 1}">
                        <div class="card-body p-2">
                            <input type="text" name="caption_new[]" class="form-control form-control-sm" 
                                placeholder="Caption foto ini..." 
                                data-index="${index}">
                        </div>
                    </div>
                `;
                container.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- FUNGSI UTAMA: PENCARIAN & ENTER SELECT ---
    function setupSearchEnter(inputId, itemClass, noResultId) {
        const input = document.getElementById(inputId);
        const items = document.querySelectorAll('.' + itemClass);
        const noResult = document.getElementById(noResultId);

        if (!input) return;

        // 1. Logika Filtering (Pencarian)
        input.addEventListener('keyup', function(e) {
            // Jangan filter jika menekan enter (biarkan event keydown menangani)
            if (e.key === 'Enter') return;

            const filter = input.value.toLowerCase();
            let hasResult = false;

            items.forEach(item => {
                // Ambil data-name untuk pencarian
                const name = item.getAttribute('data-name');
                if (name.includes(filter)) {
                    item.style.display = 'flex'; // Tampilkan (flex agar layout rapi)
                    hasResult = true;
                } else {
                    item.style.display = 'none'; // Sembunyikan
                }
            });

            // Tampilkan pesan jika tidak ada hasil
            if (noResult) {
                noResult.style.display = hasResult ? 'none' : 'block';
            }
        });

        // 2. Logika Tombol ENTER
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Mencegah form submit tidak sengaja

                // Cari item PERTAMA yang sedang tampil (display != none)
                let firstVisibleItem = null;
                for (let item of items) {
                    if (item.style.display !== 'none') {
                        firstVisibleItem = item;
                        break; // Stop setelah ketemu yang paling atas
                    }
                }

                // Jika ada item yang cocok
                if (firstVisibleItem) {
                    const checkbox = firstVisibleItem.querySelector('input[type="checkbox"]');
                    
                    // Jika belum tercentang, klik!
                    if (checkbox && !checkbox.checked) {
                        checkbox.click(); 
                        
                        // Opsional: Kosongkan search bar setelah memilih
                        // input.value = ''; 
                        // input.dispatchEvent(new Event('keyup')); // Reset list
                        
                        // Opsional: Beri feedback visual (kedip)
                        firstVisibleItem.style.backgroundColor = '#dbeafe';
                        setTimeout(() => {
                            firstVisibleItem.style.backgroundColor = '';
                        }, 300);
                    }
                }
            }
        });
    }

    // --- JALANKAN FUNGSI UNTUK KATEGORI & TAGS ---
    setupSearchEnter('kategori-search', 'kategori-item', 'kategori-no-results');
    setupSearchEnter('tags-search', 'tags-item', 'tags-no-results');


    // --- LOGIKA UPDATE BADGE (TAMPILAN PILIHAN) ---
    // Kode ini diperlukan agar saat di-enter (klik otomatis), badge di atas muncul
    
    function updateBadges(containerId, checkboxClass, hiddenInputId) {
        const container = document.getElementById(containerId);
        const checkboxes = document.querySelectorAll('.' + checkboxClass);
        const hiddenInput = document.getElementById(hiddenInputId);
        
        const selectedValues = [];
        container.innerHTML = ''; // Reset badge

        checkboxes.forEach(cb => {
            if (cb.checked) {
                selectedValues.push(cb.value);
                const label = cb.nextElementSibling.innerText;
                
                // Buat Badge HTML
                const badge = document.createElement('span');
                badge.className = 'selected-badge';
                badge.innerHTML = `${label} <i class="bi bi-x" onclick="uncheckItem('${cb.id}')"></i>`;
                container.appendChild(badge);
            }
        });

        // Update value hidden input untuk dikirim ke database
        if(hiddenInput) hiddenInput.value = selectedValues.join(',');
    }

    // Event Listener untuk update badge saat checkbox berubah (diklik manual atau via Enter)
    document.querySelectorAll('.kategori-checkbox').forEach(cb => {
        cb.addEventListener('change', () => updateBadges('selected-kategori-badges', 'kategori-checkbox', 'kategori-hidden'));
    });

    document.querySelectorAll('.tags-checkbox').forEach(cb => {
        cb.addEventListener('change', () => updateBadges('selected-tags-badges', 'tags-checkbox', 'tags-hidden'));
    });

    // Jalankan sekali saat load untuk menampilkan data old()
    updateBadges('selected-kategori-badges', 'kategori-checkbox', 'kategori-hidden');
    updateBadges('selected-tags-badges', 'tags-checkbox', 'tags-hidden');

});

// Fungsi global untuk menghapus badge (uncheck checkbox)
window.uncheckItem = function(checkboxId) {
    const cb = document.getElementById(checkboxId);
    if (cb) {
        cb.click(); // Klik lagi untuk uncheck dan trigger event change
    }
};
</script>

<?= $this->endSection() ?>