<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<?= $this->include('layouts/alerts') ?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

<style>
    :root {
        --primary: #1e40af; --primary-dark: #1e3a8a; --primary-light: #3b82f6;
        --success: #059669; --warning: #d97706; --info: #0284c7; --danger: #dc2626;
        --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-300: #cbd5e1;
        --gray-400: #94a3b8; --gray-500: #64748b; --gray-600: #475569; --gray-700: #334155;
        --gray-800: #1e293b; --gray-900: #0f172a;
    }

    .compact-form {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 24px;
    }

    .compact-header {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        border-left: 4px solid var(--primary);
    }

    .compact-header h1 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .compact-header h1 i {
        color: var(--primary);
        margin-right: 8px;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
    }

    .section-title i {
        color: var(--primary);
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 6px;
        font-size: 0.875rem;
    }

    .form-control, .form-select {
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .text-danger {
        color: var(--danger) !important;
        font-size: 0.75rem;
    }

    small.text-muted {
        color: var(--gray-500);
        font-size: 0.75rem;
        margin-top: 4px;
        display: block;
    }

    .compact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .compact-section {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--gray-100);
    }

    .compact-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    /* Editor yang lebih kompak */
    .ql-toolbar-custom {
        background: var(--gray-50);
        border: 1px solid var(--gray-300) !important;
        border-radius: 8px 8px 0 0;
        padding: 8px !important;
        min-height: 42px;
    }

    .ql-container {
        border: 1px solid var(--gray-300) !important;
        border-radius: 0 0 8px 8px;
        font-size: 0.875rem;
        height: 200px;
    }

    .ql-editor {
        min-height: 150px;
        font-size: 0.875rem;
        color: var(--gray-800);
        padding: 12px 15px;
    }

    /* Dropdown kompak */
    .dropdown-menu-custom {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .news-item-option {
        display: flex;
        align-items: center;
        padding: 8px;
        border-bottom: 1px solid var(--gray-100);
        cursor: pointer;
        transition: background 0.2s;
    }

    .news-item-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .news-item-content {
        flex-grow: 1;
        min-width: 0;
    }

    .news-item-title {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--gray-800);
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .news-item-date {
        font-size: 0.7rem;
        color: var(--gray-500);
    }

    /* Badge kompak */
    .selected-badge {
        display: inline-flex;
        align-items: center;
        background: var(--primary);
        color: white;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        margin: 2px 4px 2px 0;
    }

    .selected-badge i {
        margin-left: 4px;
        font-size: 0.7rem;
        cursor: pointer;
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

    /* Tombol aksi kompak */
    .action-buttons {
        padding-top: 20px;
        border-top: 2px solid var(--gray-200);
        margin-top: 20px;
    }

    .btn {
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
        font-size: 0.875rem;
    }

    /* Tombol draft dengan warna yang lebih jelas */
    .btn-draft {
        background-color: #fef3c7;
        color: #92400e !important;
        border: 1px solid #fbbf24;
    }
    
    .btn-draft:hover {
        background-color: #fde68a;
        color: #78350f !important;
    }

    /* Toggle switch kompak */
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
        margin-right: 8px;
    }

    /* Input group kompak */
    .input-group-text {
        padding: 8px 12px;
        font-size: 0.875rem;
    }

    /* Sisipan box kompak */
    .sisipan-box {
        background: #eff6ff;
        border: 1px dashed #3b82f6;
        padding: 12px;
        border-radius: 8px;
        margin-top: 12px;
    }

    /* Preview gambar kompak */
    .preview-img {
        max-width: 150px;
        max-height: 150px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        margin-top: 8px;
    }

    /* Image styles tetap sama dari edit */
    .current-image-wrapper { position: relative; display: inline-block; }
    .current-image-badge {
        position: absolute; top: 8px; left: 8px;
        background: var(--success); color: white; padding: 4px 12px;
        border-radius: 6px; font-size: 0.75rem; font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .temp-image-badge {
        position: absolute; top: 0; right: 0; margin: 4px;
        background: var(--info); color: white; padding: 4px 8px;
        border-radius: 4px; font-size: 0.7rem; z-index: 5;
    }
    .retained-image-info {
        background-color: #e0f2fe; border-left: 4px solid #0284c7;
        padding: 12px 16px; border-radius: 8px; margin-top: 12px;
        font-size: 0.875rem; color: #0c4a6e; display: flex; align-items: center; gap: 8px;
    }
    .btn-delete-img {
        position: absolute; top: 4px; right: 4px;
        background: rgba(220, 38, 38, 0.9); color: white;
        border: none; width: 24px; height: 24px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: 0.2s; z-index: 10; font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .btn-delete-img:hover { background: var(--danger); transform: scale(1.1); }
    .old-badge { 
        position: absolute; top: 4px; left: 4px; background: rgba(0,0,0,0.6); 
        color: white; font-size: 10px; padding: 2px 6px; border-radius: 4px; z-index: 5;
    }

    /* NEW: Styles untuk foto tambahan yang baru - GRID LAYOUT */
    .additional-images-container {
        margin-top: 12px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .additional-image-item {
        background: var(--gray-50);
        border: 2px dashed var(--gray-300);
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .additional-image-item:hover {
        border-color: var(--primary);
        background: #eff6ff;
    }

    .additional-image-item.has-image {
        border-style: solid;
        border-color: var(--success);
        background: #f0fdf4;
    }

    .image-upload-area {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .image-preview-box {
        width: 100%;
        height: 120px;
        border-radius: 6px;
        overflow: hidden;
        background: var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .image-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview-box .placeholder {
        color: var(--gray-400);
        font-size: 2.5rem;
    }

    .btn-remove-image {
        position: absolute;
        top: 4px;
        right: 4px;
        padding: 4px 8px;
        font-size: 0.7rem;
        border-radius: 4px;
        background: rgba(220, 38, 38, 0.95);
        color: white;
        border: none;
        cursor: pointer;
        opacity: 0.9;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .btn-remove-image:hover {
        opacity: 1;
        background: var(--danger);
    }

    .btn-remove-item {
        padding: 4px 10px;
        font-size: 0.75rem;
        border-radius: 4px;
        background: var(--gray-300);
        color: var(--gray-700);
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        align-self: stretch;
    }

    .btn-remove-item:hover {
        background: var(--danger);
        color: white;
    }

    .btn-add-more {
        background: var(--primary-light);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 8px;
        font-weight: 600;
        width: 100%;
        grid-column: 1 / -1;
    }

    .btn-add-more:hover {
        background: var(--primary);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(30, 64, 175, 0.3);
    }

    .btn-add-more i {
        font-size: 1.1rem;
    }

    /* Grid untuk existing dan temp images */
    .existing-images-grid,
    .temp-images-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    /* Style untuk existing images dengan card yang lebih kompak */
    .existing-image-card {
        background: var(--gray-50);
        border: 2px solid var(--warning);
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .existing-image-card:hover {
        border-color: #f59e0b;
        background: #fffbeb;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Accordion/Collapsible untuk foto tambahan */
    .photos-section {
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        margin-bottom: 16px;
        background: white;
        overflow: hidden;
    }

    .photos-section-header {
        padding: 12px 16px;
        background: var(--gray-50);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s;
        border-bottom: 1px solid var(--gray-200);
    }

    .photos-section-header:hover {
        background: var(--gray-100);
    }

    .photos-section-header.active {
        background: var(--primary-light);
        color: white;
    }

    .photos-section-title {
        font-weight: 600;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .photos-count-badge {
        background: var(--primary);
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .photos-section-header.active .photos-count-badge {
        background: white;
        color: var(--primary);
    }

    .collapse-icon {
        transition: transform 0.3s;
        font-size: 1.2rem;
    }

    .collapse-icon.rotated {
        transform: rotate(180deg);
    }

    .photos-section-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .photos-section-body.open {
        max-height: 2000px;
        transition: max-height 0.5s ease-in;
    }

    .photos-section-content {
        padding: 16px;
    }

    /* Limit tinggi dengan scroll untuk banyak foto */
    .photos-grid-wrapper {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 8px;
    }

    .photos-grid-wrapper::-webkit-scrollbar {
        width: 8px;
    }

    .photos-grid-wrapper::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }

    .photos-grid-wrapper::-webkit-scrollbar-thumb {
        background: var(--gray-400);
        border-radius: 4px;
    }

    .photos-grid-wrapper::-webkit-scrollbar-thumb:hover {
        background: var(--gray-500);
    }

    @media (max-width: 768px) {
        .compact-form {
            padding: 16px;
        }
        
        .compact-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .compact-header {
            padding: 16px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons .btn {
            width: 100%;
            margin: 4px 0 !important;
        }
        
        .ql-container {
            height: 180px;
        }

        /* Grid foto jadi 1 kolom di mobile */
        .additional-images-container,
        .existing-images-grid,
        .temp-images-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="compact-header">
    <h1><i class="bi bi-pencil-square"></i> Edit Berita</h1>
</div>

<div class="compact-form">
    <form action="<?= site_url('berita/'.$berita['id_berita'].'/update') ?>" method="post" enctype="multipart/form-data" id="form-berita">
        <?= csrf_field() ?>

        <div class="compact-section">
            <div class="section-title"><i class="bi bi-info-circle"></i> Informasi Dasar</div>
            
            <div class="compact-grid">
                <div>
                    <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" required placeholder="Judul berita" value="<?= esc(old('judul', $berita['judul'])) ?>">
                </div>
                
                <div>
                    <label class="form-label">Sumber Berita</label>
                    <input type="text" name="sumber" class="form-control" 
                           placeholder="Contoh: Kompas.com" 
                           value="<?= esc(old('sumber', $berita['sumber'])) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Intro Singkat</label>
                <textarea name="intro" class="form-control" rows="2" placeholder="Deskripsi singkat yang menarik pembaca"><?= esc(old('intro', $berita['intro'])) ?></textarea>
                <small class="text-muted">Ringkasan singkat untuk preview berita</small>
            </div>
        </div>

        <div class="compact-section">
            <div class="section-title"><i class="bi bi-file-text"></i> Konten Berita</div>

            <div class="mb-3">
                <label class="form-label">Isi Berita 1 <span class="text-danger">*</span></label>
                <div id="toolbar-content" class="ql-toolbar-custom">
                    <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button>
                    <select class="ql-header">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option selected></option>
                    </select>
                    <button class="ql-list" value="ordered"></button><button class="ql-list" value="bullet"></button>
                    <button class="ql-link"></button><button class="ql-image"></button>
                </div>
                <div id="editor-content" class="ql-container ql-snow">
                    <div class="ql-editor" data-placeholder="Tulis isi berita di sini..."><?= old('content', $berita['content']) ?></div>
                </div>
                <textarea name="content" id="content-hidden" style="display:none;"></textarea>
            </div>

            <?php 
                // Logika Baru: Toggle ON jika ada Sisipan 1 ATAU ada Content 2 ATAU input toggle bernilai 1
                $hasSisipan1 = !empty($berita['id_berita_terkait']) || old('id_berita_terkait');
                $hasContent2 = !empty($berita['content2']) || old('content2');
                $isToggleOn  = $hasSisipan1 || $hasContent2 || old('has_content2') == '1';
            ?>
            <div class="d-flex align-items-center mb-3 p-2 bg-gray-50 border rounded">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="toggle-content2" <?= $isToggleOn ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="toggle-content2" style="font-size: 0.875rem;">
                        Tambah Bagian Kedua Dan Sisipan
                    </label>
                </div>
                <input type="hidden" name="has_content2" id="has-content2-val" value="<?= $isToggleOn ? '1' : '0' ?>">
            </div>

            <div class="sisipan-box mb-3" id="box-sisipan-1" style="display: <?= $isToggleOn ? 'block' : 'none' ?>;">
                <label class="form-label d-flex align-items-center">
                    <i class="bi bi-paperclip me-2"></i> Berita Sisipan 1
                </label>

                <?php 
                    // Logika PHP SISIPAN 1
                    $val_s1 = old('id_berita_terkait', $berita['id_berita_terkait'] ?? '');
                    $lbl_s1 = '-- Pilih Berita Sisipan --';
                    $img_s1 = '';
                    $cls_s1 = 'd-none';
                    $col_s1 = 'text-muted';

                    if(!empty($val_s1)) {
                        foreach($beritaAll as $item) {
                            if($item['id_berita'] == $val_s1) {
                                $lbl_s1 = $item['judul'];
                                $col_s1 = 'text-dark fw-bold';
                                $cls_s1 = '';
                                $g = $item['feat_image'];
                                if (empty($g)) { $img_s1 = 'https://via.placeholder.com/50?text=IMG'; }
                                elseif (strpos($g, 'http') === 0) { $img_s1 = $g; }
                                else {
                                    $clean = ltrim($g, '/');
                                    $img_s1 = (strpos($clean, 'uploads/') === 0) ? base_url($clean) : base_url('uploads/' . $clean);
                                }
                                break;
                            }
                        }
                    }
                ?>

                <div class="dropdown custom-img-select" id="sisipan1-wrapper">
                    <input type="hidden" name="id_berita_terkait" id="sisipan1-input" value="<?= $val_s1 ?>">

                    <button class="form-select dropdown-toggle-custom" type="button" id="sisipan1-btn" data-bs-toggle="dropdown">
                        <span id="sisipan1-label" class="text-muted"><?= esc($lbl_s1) ?></span>
                    </button>
                    <div class="dropdown-menu w-100 p-0 shadow border dropdown-menu-custom">
                        <div class="p-2 border-bottom">
                            <input type="text" class="form-control form-control-sm" id="sisipan1-search" placeholder="Cari berita...">
                        </div>
                        <div id="sisipan1-list">
                            <div class="news-item-option" onclick="selectSisipan('sisipan1', '', 'No Sisipan', '', '')">
                                <div class="news-item-content text-center text-muted">-- Tidak Ada Sisipan --</div>
                            </div>
                            <?php foreach ($beritaAll as $b): 
                                if($b['id_berita'] == $berita['id_berita']) continue;
                                
                                $gambarDB = $b['feat_image'];
                                if (empty($gambarDB)) { $imgSrc = 'https://via.placeholder.com/50?text=IMG'; }
                                elseif (strpos($gambarDB, 'http') === 0) { $imgSrc = $gambarDB; }
                                else {
                                    $cleanPath = ltrim($gambarDB, '/');
                                    $imgSrc = (strpos($cleanPath, 'uploads/') === 0) ? base_url($cleanPath) : base_url('uploads/' . $cleanPath);
                                }
                                $tgl = isset($b['tanggal']) ? date('d M Y', strtotime($b['tanggal'])) : '-';
                                $judulSafe = addslashes(esc($b['judul']));
                            ?>
                                <div class="news-item-option" data-search="<?= strtolower(esc($b['judul'])) ?>"
                                    onclick="selectSisipan('sisipan1', '<?= $b['id_berita'] ?>', '<?= $judulSafe ?>', '<?= $imgSrc ?>', '<?= $tgl ?>')">
                                    <img src="<?= $imgSrc ?>" class="news-item-img" onerror="this.src='https://via.placeholder.com/50?text=Error'">
                                    <div class="news-item-content">
                                        <div class="news-item-title"><?= esc($b['judul']) ?></div>
                                        <div class="news-item-date"><i class="bi bi-calendar3"></i> <?= $tgl ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="sisipan1-noresult" class="p-2 text-center text-muted" style="display:none;">Tidak ditemukan</div>
                    </div>
                </div>
                <small class="text-muted mt-1">Akan muncul setelah paragraf akhir Berita 1</small>
            </div>

            <div id="wrapper-content2" style="display: <?= $isToggleOn ? 'block' : 'none' ?>;">
                <div class="mb-3 ps-2 border-start border-3 border-info">
                    <label class="form-label">Isi Berita 2</label>
                    <div id="toolbar-content2" class="ql-toolbar-custom">
                        <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button>
                        <select class="ql-header">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option selected></option>
                        </select>
                        <button class="ql-list" value="ordered"></button><button class="ql-list" value="bullet"></button>
                        <button class="ql-link"></button><button class="ql-image"></button>
                    </div>
                    <div id="editor-content2" class="ql-container ql-snow">
                        <div class="ql-editor" data-placeholder="Tulis isi berita bagian kedua di sini..."><?= old('content2', $berita['content2']) ?></div>
                    </div>
                    <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>

                    <div class="sisipan-box mt-2">
                        <label class="form-label d-flex align-items-center">
                            <i class="bi bi-paperclip me-2"></i> Berita Sisipan 2
                        </label>
                        
                        <?php 
                            // Logika PHP SISIPAN 2
                            $val_s2 = old('id_berita_terkait2', $berita['id_berita_terkait2'] ?? '');
                            $lbl_s2 = '-- Pilih Sisipan 1 Terlebih Dahulu --';
                            $img_s2 = '';
                            $cls_s2 = 'd-none';
                            $col_s2 = 'text-muted';

                            if(!empty($val_s2)) {
                                foreach($beritaAll as $item) {
                                    if($item['id_berita'] == $val_s2) {
                                        $lbl_s2 = $item['judul'];
                                        $col_s2 = 'text-dark fw-bold';
                                        $cls_s2 = '';
                                        $g = $item['feat_image'];
                                        if (empty($g)) { $img_s2 = 'https://via.placeholder.com/50?text=IMG'; }
                                        elseif (strpos($g, 'http') === 0) { $img_s2 = $g; }
                                        else {
                                            $clean = ltrim($g, '/');
                                            $img_s2 = (strpos($clean, 'uploads/') === 0) ? base_url($clean) : base_url('uploads/' . $clean);
                                        }
                                        break;
                                    }
                                }
                            }
                        ?>
                        
                        <div class="dropdown custom-img-select" id="sisipan2-wrapper">
                            <input type="hidden" name="id_berita_terkait2" id="sisipan2-input" value="<?= $val_s2 ?>">
                            <button class="form-select dropdown-toggle-custom" type="button" id="sisipan2-btn" data-bs-toggle="dropdown" <?= empty($val_s1) ? 'disabled' : '' ?>>
                                <span id="sisipan2-label" class="text-muted"><?= esc($lbl_s2) ?></span>
                            </button>
                            <div class="dropdown-menu w-100 p-0 shadow border dropdown-menu-custom">
                                <div class="p-2 border-bottom">
                                    <input type="text" class="form-control form-control-sm" id="sisipan2-search" placeholder="Cari berita...">
                                </div>
                                <div id="sisipan2-list">
                                    <div class="news-item-option" onclick="selectSisipan('sisipan2', '', 'No Sisipan', '', '')">
                                        <div class="news-item-content text-center text-muted">-- Tidak Ada Sisipan --</div>
                                    </div>
                                    <?php foreach ($beritaAll as $b): 
                                        if($b['id_berita'] == $berita['id_berita']) continue;
                                        
                                        $gambarDB = $b['feat_image'];
                                        if (empty($gambarDB)) { $imgSrc = 'https://via.placeholder.com/50?text=IMG'; }
                                        elseif (strpos($gambarDB, 'http') === 0) { $imgSrc = $gambarDB; }
                                        else {
                                            $cleanPath = ltrim($gambarDB, '/');
                                            $imgSrc = (strpos($cleanPath, 'uploads/') === 0) ? base_url($cleanPath) : base_url('uploads/' . $cleanPath);
                                        }
                                        $tgl = isset($b['tanggal']) ? date('d M Y', strtotime($b['tanggal'])) : '-';
                                        $judulSafe = addslashes(esc($b['judul']));
                                    ?>
                                        <div class="news-item-option" data-search="<?= strtolower(esc($b['judul'])) ?>"
                                            onclick="selectSisipan('sisipan2', '<?= $b['id_berita'] ?>', '<?= $judulSafe ?>', '<?= $imgSrc ?>', '<?= $tgl ?>')">
                                            <img src="<?= $imgSrc ?>" class="news-item-img" onerror="this.src='https://via.placeholder.com/50?text=Error'">
                                            <div class="news-item-content">
                                                <div class="news-item-title"><?= esc($b['judul']) ?></div>
                                                <div class="news-item-date"><i class="bi bi-calendar3"></i> <?= $tgl ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div id="sisipan2-noresult" class="p-2 text-center text-muted" style="display:none;">Tidak ditemukan</div>
                            </div>
                        </div>
                        <small class="text-muted mt-1">Akan muncul setelah paragraf akhir Berita 2</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="compact-section">
            <div class="section-title"><i class="bi bi-tags"></i> Kategori & Tags</div>
            
            <div class="compact-grid">
                <div>
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <?php 
                        $selected = old('id_kategori', $selected ?? []);
                        if (!is_array($selected)) $selected = explode(',', $selected);
                    ?>
                    <div class="dropdown" id="kategori-dropdown">
                        <button type="button" class="form-select text-start d-flex align-items-center pe-3" id="kategori-toggle">
                            <span id="kategori-placeholder">Pilih minimal 1 kategori</span>
                            <i class="ms-auto bi bi-chevron-down text-gray-500"></i>
                        </button>
                        <div class="dropdown-menu w-100 p-0 shadow border" style="max-height: 280px;">
                            <div class="px-2 py-2 border-bottom">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search text-gray-500"></i></span>
                                    <input type="text" class="form-control" id="kategori-search" placeholder="Cari kategori..." autocomplete="off">
                                </div>
                            </div>
                            <div class="kategori-list px-2 py-1" style="max-height: 200px; overflow-y: auto;">
                                <?php foreach ($kategori as $kat): ?>
                                    <div class="form-check ps-3 py-1 kategori-item" data-name="<?= esc(strtolower($kat['kategori'])) ?>">
                                        <input class="form-check-input kategori-checkbox" type="checkbox" 
                                               id="kat-<?= $kat['id_kategori'] ?>" value="<?= $kat['id_kategori'] ?>"
                                               <?= in_array($kat['id_kategori'], $selected) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="kat-<?= $kat['id_kategori'] ?>"><?= esc($kat['kategori']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div id="kategori-no-results" class="px-2 py-2 text-center text-gray-500" style="display: none;">
                                <small>Tidak ada kategori yang cocok</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_kategori" id="kategori-hidden" value="<?= implode(',', $selected) ?>">
                    <div id="selected-kategori-badges" class="mt-2 d-flex flex-wrap"></div>
                </div>

                <div>
                    <label class="form-label">Tags</label>
                    
                    <?php 
                        $currentTagsData = old('id_tags', $selectedTags ?? []); 
                        if (!is_array($currentTagsData)) {
                            $currentTagsData = array_filter(explode(',', $currentTagsData));
                        }
                    ?>

                    <div class="dropdown" id="tags-dropdown">
                        <button type="button" class="form-select text-start d-flex align-items-center pe-3" id="tags-toggle">
                            <span id="tags-placeholder">Pilih tags (opsional)</span>
                            <i class="ms-auto bi bi-chevron-down text-gray-500"></i>
                        </button>
                        <div class="dropdown-menu w-100 p-0 shadow border" style="max-height: 280px;">
                            <div class="px-2 py-2 border-bottom">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search text-gray-500"></i></span>
                                    <input type="text" class="form-control" id="tags-search" placeholder="Cari tags..." autocomplete="off">
                                </div>
                            </div>
                            <div class="tags-list px-2 py-1" style="max-height: 200px; overflow-y: auto;">
                                <?php foreach ($tags as $tag): ?>
                                    <div class="form-check ps-3 py-1 tags-item" data-name="<?= esc(strtolower($tag['nama_tag'])) ?>">
                                        <?php
                                            $tagIdStr = (string)$tag['id_tags'];
                                            $isChecked = in_array($tagIdStr, array_map('strval', $currentTagsData));
                                        ?>
                                        <input class="form-check-input tags-checkbox" type="checkbox" 
                                               id="tag-<?= $tag['id_tags'] ?>" 
                                               value="<?= $tag['id_tags'] ?>"
                                               <?= $isChecked ? 'checked' : '' ?>>
                                        
                                        <label class="form-check-label" for="tag-<?= $tag['id_tags'] ?>">
                                            <?= esc($tag['nama_tag']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div id="tags-no-results" class="px-2 py-2 text-center text-gray-500" style="display: none;">
                                <small>Tidak ada tags yang cocok</small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id_tags" id="tags-hidden" value="<?= implode(',', $currentTagsData) ?>">
                    
                    <div id="selected-tags-badges" class="mt-2 d-flex flex-wrap"></div>
                </div>
            </div>
        </div>

        <div class="compact-section">
            <div class="section-title"><i class="bi bi-images"></i> Media</div>
            
            <div class="compact-grid">
                <div>
                    <label class="form-label">Foto Cover</label>
                    
                    <div class="mb-3">
                        <?php if(!empty($tempCoverImage)): ?>
                            <div class="current-image-wrapper">
                                <span class="current-image-badge" style="background: var(--info);">
                                    <i class="bi bi-clock-history me-1"></i>Gambar Temporary
                                </span>
                                <img src="<?= base_url('uploads/temp/' . $tempCoverImage) ?>" class="preview-img" alt="Temp Cover">
                            </div>
                            <div class="retained-image-info">
                                <i class="bi bi-info-circle-fill"></i>
                                <strong>Gambar temporary tersimpan.</strong> Upload baru jika ingin mengganti.
                            </div>
                        <?php elseif(!empty($berita['feat_image'])): ?>
                            <div class="current-image-wrapper">
                                <span class="current-image-badge">
                                    <i class="bi bi-check-circle me-1"></i>Gambar Saat Ini
                                </span>
                                <img src="<?= base_url($berita['feat_image']) ?>" class="preview-img" alt="Current Cover">
                            </div>
                        <?php endif; ?>

                        <div id="new-cover-preview" class="mt-2"></div>
                    </div>

                    <input type="file" name="feat_image" class="form-control" accept="image/*" id="cover-image">
                    
                    <div class="mt-2">
                        <input type="text" name="caption_cover" class="form-control form-control-sm" placeholder="Caption cover..." value="<?= esc(old('caption_cover', $berita['caption'])) ?>">
                    </div>
                </div>
                
                <div>
                    <label class="form-label">Foto Tambahan</label>
                    <small class="text-muted d-block mb-2">Kelola foto dalam accordion (klik untuk buka/tutup)</small>
                    
                    <?php 
                    $oldAdditional = !empty($berita['additional_images']) ? json_decode($berita['additional_images'], true) : [];
                    ?>
                    
                    <!-- Accordion Gambar Lama -->
                    <?php if (!empty($oldAdditional)): ?>
                        <div class="photos-section">
                            <div class="photos-section-header" onclick="togglePhotoSection('existing-photos')">
                                <div class="photos-section-title">
                                    <i class="bi bi-folder-check text-warning"></i>
                                    <span>Gambar Lama</span>
                                    <span class="photos-count-badge"><?= count($oldAdditional) ?></span>
                                </div>
                                <i class="bi bi-chevron-down collapse-icon" id="existing-photos-icon"></i>
                            </div>
                            <div class="photos-section-body" id="existing-photos-body">
                                <div class="photos-section-content">
                                    <div class="photos-grid-wrapper">
                                        <div id="existing-images-container" class="existing-images-grid">
                                            <?php foreach ($oldAdditional as $index => $img): ?>
                                                <?php 
                                                    $path = is_array($img) ? $img['path'] : $img;
                                                    $cap  = is_array($img) ? ($img['caption'] ?? '') : '';
                                                    $filePath = FCPATH . ltrim($path, '/');
                                                    if (!file_exists($filePath)) continue; 
                                                ?>
                                                <div class="existing-image-card" id="existing-card-<?= $index ?>">
                                                    <input type="hidden" name="existing_image_paths[]" value="<?= esc($path) ?>">
                                                    <div class="image-upload-area">
                                                        <div class="image-preview-box">
                                                            <img src="<?= base_url($path) ?>" alt="Existing">
                                                            <button type="button" class="btn-remove-image delete-old-image" 
                                                                    data-image="<?= $path ?>" data-card-id="existing-card-<?= $index ?>"
                                                                    title="Hapus gambar">
                                                                ✕
                                                            </button>
                                                            <span class="old-badge">Lama</span>
                                                        </div>
                                                        <input type="text" 
                                                               name="caption_existing[]" 
                                                               class="form-control form-control-sm" 
                                                               placeholder="Caption..." 
                                                               value="<?= esc($cap) ?>"
                                                               data-old-path="<?= esc($path) ?>">
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Accordion Gambar Temporary -->
                    <?php if (!empty($tempAdditionalImages) && is_array($tempAdditionalImages)): ?>
                        <div class="photos-section">
                            <div class="photos-section-header" onclick="togglePhotoSection('temp-photos')">
                                <div class="photos-section-title">
                                    <i class="bi bi-clock-history text-info"></i>
                                    <span>Gambar Temporary</span>
                                    <span class="photos-count-badge"><?= count($tempAdditionalImages) ?></span>
                                </div>
                                <i class="bi bi-chevron-down collapse-icon" id="temp-photos-icon"></i>
                            </div>
                            <div class="photos-section-body" id="temp-photos-body">
                                <div class="photos-section-content">
                                    <div class="photos-grid-wrapper">
                                        <div id="temp-additional-images" class="temp-images-grid">
                                            <?php $oldCaptions = old('caption_additional', []); ?>
                                            <?php foreach ($tempAdditionalImages as $index => $tempImage): ?>
                                                <div class="additional-image-item has-image">
                                                    <div class="image-upload-area">
                                                        <div class="image-preview-box">
                                                            <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" alt="Temp">
                                                            <div class="temp-image-badge"><i class="bi bi-clock-history"></i></div>
                                                        </div>
                                                        <input type="text" name="caption_additional[]" 
                                                               class="form-control form-control-sm" 
                                                               placeholder="Caption..."
                                                               value="<?= isset($oldCaptions[$index]) ? esc($oldCaptions[$index]) : '' ?>">
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="retained-image-info mt-2">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <strong><?= count($tempAdditionalImages) ?> gambar tersimpan sementara.</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Accordion Tambah Foto Baru -->
                    <div class="photos-section">
                        <div class="photos-section-header active" onclick="togglePhotoSection('new-photos')">
                            <div class="photos-section-title">
                                <i class="bi bi-plus-circle text-success"></i>
                                <span>Tambah Foto Baru</span>
                                <span class="photos-count-badge" id="new-photos-count">0</span>
                            </div>
                            <i class="bi bi-chevron-down collapse-icon rotated" id="new-photos-icon"></i>
                        </div>
                        <div class="photos-section-body open" id="new-photos-body">
                            <div class="photos-section-content">
                                <div class="photos-grid-wrapper">
                                    <div id="additional-images-wrapper">
                                        <div id="additional-images-container" class="additional-images-container">
                                            <!-- Item foto tambahan akan ditambahkan di sini oleh JavaScript -->
                                        </div>
                                        
                                        <!-- Tombol tambah foto baru -->
                                        <button type="button" class="btn-add-more" id="btn-add-additional-image">
                                            <i class="bi bi-plus-circle"></i>
                                            Tambah Foto Baru
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <label class="form-label">Waktu Publish</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    <input type="text" id="datetime-picker" name="tanggal" class="form-control" 
                           placeholder="Pilih tanggal dan jam..." 
                           value="<?= old('tanggal', date('Y-m-d H:i', strtotime($berita['tanggal']))) ?>">
                </div>
            </div>
        </div>

        <?php 
            $isAllowed = in_array(session('role'), ['admin', 'superadmin']);
        ?>

        <?php if ($isAllowed) : ?>
            <div class="compact-section">
                <div class="section-title"><i class="bi bi-gear"></i> Catatan Admin</div>

                <div class="mb-3">
                    <label class="form-label">Catatan Admin/Superadmin</label>
                    <textarea name="note" class="form-control" rows="2" placeholder="Catatan internal untuk admin..."><?= esc(old('note', $berita['note'])) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Note Revisi</label>
                    <textarea name="note_revisi" class="form-control" rows="2" placeholder="Catatan revisi..."><?= esc(old('note_revisi', $berita['note_revisi'])) ?></textarea>
                </div>
            </div>
        <?php endif; ?>

        <input type="hidden" name="status" value="0">
        <input type="hidden" name="status_berita" value="2">

        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            
            <?php $role = session()->get('role'); ?>
            <?php if ($role == 'editor') : ?>
            <button type="submit" name="submit_type" value="pending" class="btn btn-warning text-white">
                <i class="bi bi-hourglass-split"></i> Ajukan Verifikasi
            </button>
            <?php endif; ?>
            
             <?php if ($role == 'admin' || $role == 'superadmin') : ?>
                <button type="submit" name="submit_type" value="revisi" class="btn btn-danger">
                    <i class="bi bi-hourglass-split"></i> Revisi
                </button>
            <?php endif; ?>

            <?php if ($berita['status_berita'] == 2 || $berita['status_berita'] == 4 || $berita['status_berita'] == 6 ): ?>
            <button type="submit" name="submit_type" value="draft" class="btn btn-draft">
                <i class="bi bi-file-earmark-text"></i> Draft
            </button>
            <?php endif; ?>
            
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
// Global Functions (sama dengan create)
function selectSisipan(prefix, id, judul, img, tgl) {
    document.getElementById(prefix + '-input').value = id;
    const label = document.getElementById(prefix + '-label');
    
    if (id) {
        label.innerHTML = `<img src="${img}" style="width:24px; height:24px; object-fit:cover; border-radius:4px; margin-right:6px;"> ${judul}`;
        label.classList.remove('text-muted');
    } else {
        label.innerHTML = '-- Pilih Berita Sisipan --';
        label.classList.add('text-muted');
    }

    const items = document.querySelectorAll(`#${prefix}-list .news-item-option`);
    items.forEach(el => el.classList.remove('active'));
    
    if (prefix === 'sisipan1') {
        const sisipan2Btn = document.getElementById('sisipan2-btn');
        if (id) {
            sisipan2Btn.removeAttribute('disabled');
            document.getElementById('sisipan2-label').innerText = '-- Pilih Berita Sisipan --';
        } else {
            sisipan2Btn.setAttribute('disabled', 'true');
            selectSisipan('sisipan2', '', 'No Sisipan', '', '');
            document.getElementById('sisipan2-label').innerText = '-- Pilih Sisipan 1 Terlebih Dahulu --';
        }
    }
}

function uncheck(type, id) {
    const cb = document.getElementById((type === 'kategori' ? 'kat-' : 'tag-') + id);
    if (cb) {
        cb.checked = false;
        cb.dispatchEvent(new Event('change'));
    }
}

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

        noResult.style.display = visibleCount === 0 && term !== '' ? 'block' : 'none';
    });
}

function setupSearchEnter(type) {
    const searchInput = document.getElementById(type + '-search');
    const items = document.querySelectorAll('.' + type + '-item');
    const noResults = document.getElementById(type + '-no-results');

    if (!searchInput) return;

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            let firstVisibleItem = null;
            for (let item of items) {
                if (item.style.display !== 'none' && item.style.display !== '') {
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        firstVisibleItem = checkbox;
                        break;
                    }
                }
            }

            if (firstVisibleItem) {
                firstVisibleItem.checked = !firstVisibleItem.checked;
                const event = new Event('change');
                firstVisibleItem.dispatchEvent(event);
                
                const parentItem = firstVisibleItem.closest('.' + type + '-item');
                if (parentItem) {
                    parentItem.style.backgroundColor = firstVisibleItem.checked ? '#dbeafe' : '';
                    setTimeout(() => {
                        parentItem.style.backgroundColor = '';
                    }, 300);
                }
            }
        }
    });
}

// NEW: Fungsi untuk menambah item foto tambahan (sama dengan create)
let additionalImageCounter = 0;

function addAdditionalImageItem() {
    const container = document.getElementById('additional-images-container');
    const itemId = 'additional-item-' + additionalImageCounter;
    const inputId = 'additional-input-' + additionalImageCounter;
    const previewId = 'additional-preview-' + additionalImageCounter;
    
    const itemHTML = `
        <div class="additional-image-item" id="${itemId}">
            <div class="image-upload-area">
                <div class="image-preview-box" id="${previewId}">
                    <i class="bi bi-image placeholder"></i>
                </div>
                <input type="file" name="additional_images[]" class="form-control form-control-sm" 
                       accept="image/*" id="${inputId}" data-item-id="${itemId}" data-preview-id="${previewId}">
                <input type="text" name="caption_new[]" class="form-control form-control-sm" 
                       placeholder="Caption..." disabled>
                <button type="button" class="btn-remove-item" onclick="removeAdditionalItem('${itemId}')">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        </div>
    `;
    
    // Insert before the "Tambah Foto" button
    const addButton = document.getElementById('btn-add-additional-image');
    addButton.insertAdjacentHTML('beforebegin', itemHTML);
    
    const fileInput = document.getElementById(inputId);
    fileInput.addEventListener('change', function(e) {
        handleAdditionalImagePreview(e, previewId, itemId);
    });
    
    additionalImageCounter++;
    updateNewPhotosCount();
}

function handleAdditionalImagePreview(e, previewId, itemId) {
    const file = e.target.files[0];
    const previewBox = document.getElementById(previewId);
    const item = document.getElementById(itemId);
    const captionInput = item.querySelector('input[name="caption_new[]"]');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            previewBox.innerHTML = `
                <img src="${event.target.result}" alt="Preview">
                <button type="button" class="btn-remove-image" onclick="clearAdditionalImage('${e.target.id}', '${previewId}', '${itemId}')" title="Hapus gambar">
                    ✕
                </button>
            `;
            item.classList.add('has-image');
            captionInput.disabled = false;
        };
        reader.readAsDataURL(file);
    }
}

function clearAdditionalImage(inputId, previewId, itemId) {
    const fileInput = document.getElementById(inputId);
    const previewBox = document.getElementById(previewId);
    const item = document.getElementById(itemId);
    const captionInput = item.querySelector('input[name="caption_new[]"]');
    
    fileInput.value = '';
    previewBox.innerHTML = '<i class="bi bi-image placeholder"></i>';
    item.classList.remove('has-image');
    captionInput.disabled = true;
    captionInput.value = '';
}

function removeAdditionalItem(itemId) {
    const item = document.getElementById(itemId);
    if (item) {
        item.remove();
        updateNewPhotosCount();
    }
}

// Fungsi untuk toggle accordion foto
function togglePhotoSection(sectionId) {
    const body = document.getElementById(sectionId + '-body');
    const icon = document.getElementById(sectionId + '-icon');
    const header = body.previousElementSibling;
    
    if (body.classList.contains('open')) {
        body.classList.remove('open');
        icon.classList.remove('rotated');
        header.classList.remove('active');
    } else {
        body.classList.add('open');
        icon.classList.add('rotated');
        header.classList.add('active');
    }
}

// Fungsi untuk update counter foto baru
function updateNewPhotosCount() {
    const container = document.getElementById('additional-images-container');
    const count = container.querySelectorAll('.additional-image-item').length;
    const badge = document.getElementById('new-photos-count');
    if (badge) {
        badge.textContent = count;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Init Quill Editors
    var quill1 = new Quill('#editor-content', {
        theme: 'snow',
        modules: { toolbar: '#toolbar-content' }
    });

    var quill2 = new Quill('#editor-content2', {
        theme: 'snow',
        modules: { toolbar: '#toolbar-content2' }
    });

    document.getElementById('form-berita').onsubmit = function() {
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

    // 4. Toggle Content 2
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
    function setupDropdownSearch(type) {
        const toggleBtn = document.getElementById(type + '-toggle');
        const dropdownMenu = toggleBtn.nextElementSibling;
        const searchInput = document.getElementById(type + '-search');
        const checkboxes = document.querySelectorAll('.' + type + '-checkbox');
        const badgeContainer = document.getElementById('selected-' + type + '-badges');
        const hiddenInput = document.getElementById(type + '-hidden');
        const placeholder = document.getElementById(type + '-placeholder');
        const noResults = document.getElementById(type + '-no-results');

        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = dropdownMenu.classList.contains('show');
            document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
            if (!isOpen) {
                dropdownMenu.classList.add('show');
                searchInput.focus();
            }
        });

        document.addEventListener('click', function(e) {
            if (!toggleBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });

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

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        });

        setupSearchEnter(type);

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                updateBadges(type);
            });
        });

        function updateBadges(t) {
            badgeContainer.innerHTML = '';
            const selectedIds = [];
            let count = 0;

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selectedIds.push(cb.value);
                    const label = cb.nextElementSibling.innerText;
                    const badge = document.createElement('span');
                    badge.className = 'selected-badge';
                    badge.innerHTML = `${label} <i class="bi bi-x" onclick="uncheck('${t}', '${cb.value}')"></i>`;
                    badgeContainer.appendChild(badge);
                    count++;
                }
            });

            hiddenInput.value = selectedIds.join(',');
            placeholder.innerText = count > 0 ? count + ' ' + t + ' terpilih' : 
                (t === 'kategori' ? 'Pilih minimal 1 kategori' : 'Pilih tags (opsional)');
            if (count > 0) {
                placeholder.classList.add('text-primary', 'fw-bold');
            } else {
                placeholder.classList.remove('text-primary', 'fw-bold');
            }
        }

        updateBadges(type);
    }

    setupDropdownSearch('kategori');
    setupDropdownSearch('tags');

    // 7. Image Preview - Cover
    document.getElementById('cover-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('new-cover-preview').innerHTML = `
                    <img src="${e.target.result}" class="preview-img" alt="Preview Cover">
                `;
            }
            reader.readAsDataURL(file);
        }
    });

    // 8. Delete Old Images (existing images)
    document.querySelectorAll('.delete-old-image').forEach(btn => {
        btn.addEventListener('click', function() {
            let imgPath = this.getAttribute('data-image');
            let cardId = this.getAttribute('data-card-id');
            
            // Tambahkan hidden input untuk menandai gambar yang dihapus
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_old_images[]';
            input.value = imgPath;
            document.getElementById('form-berita').appendChild(input);

            // Hapus card dari DOM
            document.getElementById(cardId).remove();
        });
    });

    // 9. NEW: Event listener untuk tombol tambah foto
    document.getElementById('btn-add-additional-image').addEventListener('click', function() {
        addAdditionalImageItem();
    });
    
    // Tambahkan 1 item foto tambahan secara default
    addAdditionalImageItem();
});
</script>
<?= $this->endSection() ?>