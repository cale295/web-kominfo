<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<?= $this->include('layouts/alerts') ?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

<style>
    /* --- VARIABLES --- */
    :root {
        --primary: #1e40af; --primary-dark: #1e3a8a; --primary-light: #3b82f6;
        --success: #059669; --warning: #d97706; --info: #0284c7; --danger: #dc2626;
        --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-300: #cbd5e1;
        --gray-400: #94a3b8; --gray-500: #64748b; --gray-600: #475569; --gray-700: #334155;
        --gray-800: #1e293b; --gray-900: #0f172a;
    }
    body { background-color: var(--gray-50); }

    /* --- HEADER --- */
    .gov-header {
        background: white; padding: 24px; border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 24px;
        border: 1px solid var(--gray-200); border-left: 4px solid var(--primary);
    }
    .gov-header h1 { font-size: 1.75rem; font-weight: 600; margin: 0; color: var(--gray-900); }
    .gov-header h1 i { color: var(--primary); margin-right: 10px; }

    /* --- FORM CARD --- */
    .form-card {
        background: white; border-radius: 12px; border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 32px;
    }
    .section-title {
        font-size: 1.125rem; font-weight: 600; color: var(--gray-900);
        margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid var(--gray-200);
        display: flex; align-items: center;
    }
    .section-title i { color: var(--primary); margin-right: 10px; font-size: 1.25rem; }

    /* --- INPUTS --- */
    .form-label { font-weight: 500; color: var(--gray-700); margin-bottom: 8px; font-size: 0.875rem; }
    .form-control, .form-select {
        border: 1px solid var(--gray-300); border-radius: 8px; padding: 10px 14px;
        font-size: 0.9375rem; transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
    .text-danger { color: var(--danger) !important; }
    small.text-muted { color: var(--gray-500); font-size: 0.8125rem; margin-top: 6px; display: block; }

    /* --- IMAGE STYLES --- */
    .preview-container { margin-top: 16px; }
    .preview-img {
        max-width: 200px; max-height: 200px; object-fit: cover;
        border-radius: 12px; border: 2px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); transition: all 0.2s;
    }
    
    .additional-preview { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px; }
    
    /* Card Gambar Lama */
    .old-image-card {
        width: 150px; border: 1px solid var(--gray-200); border-radius: 8px;
        overflow: hidden; background: #fff; position: relative; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .old-image-card img { width: 100%; height: 110px; object-fit: cover; }
    .old-image-card .card-body { padding: 6px 8px; background: #f8fafc; border-top: 1px solid #e2e8f0; }
    
    /* Tombol Hapus (X) - Universal untuk Lama & Baru */
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
    .current-image-wrapper { position: relative; display: inline-block; }
    .current-image-badge {
        position: absolute; top: 8px; left: 8px;
        background: var(--success); color: white; padding: 4px 12px;
        border-radius: 6px; font-size: 0.75rem; font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    /* --- DROPDOWN KATEGORI --- */
    #kategori-toggle { cursor: pointer; color: var(--gray-700); }
    .kategori-list .form-check { cursor: pointer; border-radius: 6px; margin: 2px 0; }
    .kategori-list .form-check:hover { background-color: var(--gray-50); }
    .selected-badge {
        display: inline-flex; align-items: center; background: var(--primary);
        color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.8125rem;
        margin: 2px 6px 2px 0;
    }
    .selected-badge i { margin-left: 6px; cursor: pointer; opacity: 0.8; }
    .kategori-item { display: flex; align-items: center; }

    /* --- QUILL --- */
    .ql-toolbar-custom { background: var(--gray-50); border-radius: 8px 8px 0 0; border: 1px solid var(--gray-300)!important;}
    .ql-container { border-radius: 0 0 8px 8px; border: 1px solid var(--gray-300)!important; font-size: 0.9375rem; }
    .ql-editor { min-height: 250px; }
    
    .form-section { margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--gray-100); }
    .form-section:last-child { border-bottom: none; }
    
    .action-buttons .btn { margin-left: 8px; }

/* --- Style Khusus Dropdown Berita Sisipan --- */
.sisipan-box {
    background: #eff6ff;
    border: 1px dashed #3b82f6;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
}

/* Container Item Dropdown */
.news-item-option {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: background 0.2s;
}

.news-item-option:hover {
    background-color: #f8fafc;
}

/* Style Gambar Kecil */
.news-item-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 12px;
    flex-shrink: 0;
    background: #eee;
    border: 1px solid #e2e8f0;
}

/* Style Konten Teks */
.news-item-content {
    flex-grow: 1;
    min-width: 0;
}

/* Style Judul */
.news-item-title {
    font-weight: 600;
    font-size: 0.9rem;
    color: #1e293b;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; /* Titik-titik jika judul kepanjangan */
}

/* Style Tanggal */
.news-item-date {
    font-size: 0.75rem;
    color: #64748b;
}

.dropdown-menu-custom {
    max-height: 300px;
    overflow-y: auto;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="gov-header">
    <h1><i class="bi bi-pencil-square"></i> Edit Berita</h1>
</div>

<div class="form-card">
    <form action="<?= site_url('berita/'.$berita['id_berita'].'/update') ?>" method="post" enctype="multipart/form-data" id="form-berita">
        <?= csrf_field() ?>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-info-circle"></i> Informasi Dasar</div>

            <div class="mb-3">
                <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" required placeholder="Judul berita" value="<?= esc(old('judul', $berita['judul'])) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Intro Singkat</label>
                <textarea name="intro" class="form-control" rows="3"><?= esc(old('intro', $berita['intro'])) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber Berita</label>
                <input type="text" name="sumber" class="form-control" 
                       placeholder="Contoh: Kompas.com, Detik, Internal" 
                       value="<?= esc(old('sumber', $berita['sumber'])) ?>">
            </div>
        </div>

 <div class="form-section">
    <div class="section-title"><i class="bi bi-file-text"></i> Konten & Struktur Berita</div>

    <div class="mb-4">
        <label class="form-label">Isi Berita 1 <span class="text-danger">*</span></label>
        <div id="toolbar-content" class="ql-toolbar-custom">
             <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button>
             <button class="ql-list" value="ordered"></button><button class="ql-list" value="bullet"></button>
             <button class="ql-link"></button><button class="ql-image"></button><button class="ql-clean"></button>
        </div>
        <div id="editor-content">
            <?= old('content', $berita['content']) ?>
        </div>
        <textarea name="content" id="content-hidden" style="display:none;"></textarea>
    </div>

    <?php 
        // Logika Baru: Toggle ON jika ada Sisipan 1 ATAU ada Content 2 ATAU input toggle bernilai 1
        $hasSisipan1 = !empty($berita['id_berita_terkait']) || old('id_berita_terkait');
        $hasContent2 = !empty($berita['content2']) || old('content2');
        $isToggleOn  = $hasSisipan1 || $hasContent2 || old('has_content2') == '1';
    ?>
    <div class="d-flex align-items-center mb-3 mt-4 p-3 bg-gray-50 border rounded">
        <div class="form-check form-switch m-0">
            <input class="form-check-input" type="checkbox" role="switch" id="toggle-advanced" <?= $isToggleOn ? 'checked' : '' ?>>
            <label class="form-check-label fw-bold" for="toggle-advanced">Tambah Sisipan / Halaman Kedua</label>
        </div>
        <input type="hidden" name="has_content2" id="has-content2-val" value="<?= $isToggleOn ? '1' : '0' ?>">
    </div>

    <div id="wrapper-advanced" style="display: <?= $isToggleOn ? 'block' : 'none' ?>;">

        <div class="sisipan-box mb-4">
            <label class="form-label d-flex align-items-center">
                <i class="bi bi-paperclip me-2"></i> Berita Sisipan 1 (Disisipkan di Artikel 1)
            </label>

            <?php 
                // --- LOGIKA PHP SISIPAN 1 ---
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
                            if (empty($g)) { $img_s1 = 'https://via.placeholder.com/60?text=IMG'; }
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

                <button class="form-select dropdown-toggle-custom text-start d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="sisipan1-preview-img" src="<?= $img_s1 ?>" class="rounded me-2 <?= $cls_s1 ?>" style="width:30px; height:30px; object-fit:cover;">
                    <span id="sisipan1-label" class="<?= $col_s1 ?> text-truncate"><?= esc($lbl_s1) ?></span>
                </button>

                <div class="dropdown-menu w-100 p-0 shadow border dropdown-menu-custom">
                    <div class="p-2 border-bottom sticky-top bg-white">
                        <input type="text" class="form-control form-control-sm search-sisipan" data-target="sisipan1-list" placeholder="Cari judul berita...">
                    </div>

                    <div id="sisipan1-list">
                        <div class="news-item-option" onclick="selectSisipan('sisipan1', '', '-- Tidak Ada Sisipan --', '', '')">
                            <div class="news-item-content text-center text-muted small">-- Kosongkan Sisipan --</div>
                        </div>

                        <?php foreach ($beritaAll as $b): 
                            if($b['id_berita'] == $berita['id_berita']) continue;
                            
                            // Helper Gambar
                            $gambarDB = $b['feat_image'];
                            if (empty($gambarDB)) { $imgSrc = 'https://via.placeholder.com/60?text=IMG'; }
                            elseif (strpos($gambarDB, 'http') === 0) { $imgSrc = $gambarDB; }
                            else {
                                $cleanPath = ltrim($gambarDB, '/');
                                $imgSrc = (strpos($cleanPath, 'uploads/') === 0) ? base_url($cleanPath) : base_url('uploads/' . $cleanPath);
                            }
                            $tgl = isset($b['tanggal']) ? date('d M Y', strtotime($b['tanggal'])) : '-';
                            $judulSafe = addslashes(esc($b['judul']));
                        ?>
                        <div class="news-item-option search-item" data-search="<?= strtolower(esc($b['judul'])) ?>"
                             onclick="selectSisipan('sisipan1', '<?= $b['id_berita'] ?>', '<?= $judulSafe ?>', '<?= $imgSrc ?>', '<?= $tgl ?>')">
                            <img src="<?= $imgSrc ?>" class="news-item-img" alt="Thumb">
                            <div class="news-item-content">
                                <div class="news-item-title"><?= esc($b['judul']) ?></div>
                                <div class="news-item-date"><i class="bi bi-calendar3"></i> <?= $tgl ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="p-3 text-center text-muted no-result-msg" style="display:none;">Tidak ditemukan</div>
                </div>
            </div>
            <small class="text-muted mt-2 d-block">Berita ini akan muncul di tengah paragraf Berita 1.</small>
        </div>
        <div class="mb-4 ps-3 border-start border-3 border-info">
            <label class="form-label">Isi Berita 2 (Halaman Kedua)</label>
            <div id="toolbar-content2" class="ql-toolbar-custom">
                 <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button>
                 <button class="ql-list" value="ordered"></button><button class="ql-list" value="bullet"></button>
                 <button class="ql-link"></button><button class="ql-clean"></button>
            </div>
            <div id="editor-content2">
                <?= old('content2', $berita['content2']) ?>
            </div>
            <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>
            
            <div class="sisipan-box mt-4">
                <label class="form-label d-flex align-items-center">
                    <i class="bi bi-paperclip me-2"></i> Sisipan Berita 2
                </label>

                <?php 
                    // --- LOGIKA PHP SISIPAN 2 ---
                    $val_s2 = old('id_berita_terkait2', $berita['id_berita_terkait2'] ?? '');
                    $lbl_s2 = '-- Pilih Berita Sisipan 2 --';
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
                                if (empty($g)) { $img_s2 = 'https://via.placeholder.com/60?text=IMG'; }
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

                    <button class="form-select dropdown-toggle-custom text-start d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img id="sisipan2-preview-img" src="<?= $img_s2 ?>" class="rounded me-2 <?= $cls_s2 ?>" style="width:30px; height:30px; object-fit:cover;">
                        <span id="sisipan2-label" class="<?= $col_s2 ?> text-truncate"><?= esc($lbl_s2) ?></span>
                    </button>

                    <div class="dropdown-menu w-100 p-0 shadow border dropdown-menu-custom">
                        <div class="p-2 border-bottom sticky-top bg-white">
                            <input type="text" class="form-control form-control-sm search-sisipan" data-target="sisipan2-list" placeholder="Cari judul berita...">
                        </div>
                        
                        <div id="sisipan2-list">
                            <div class="news-item-option" onclick="selectSisipan('sisipan2', '', '-- Tidak Ada Sisipan --', '', '')">
                                <div class="news-item-content text-center text-muted small">-- Kosongkan Sisipan --</div>
                            </div>
                            <?php foreach ($beritaAll as $b): 
                                if($b['id_berita'] == $berita['id_berita']) continue;
                                
                                $gambarDB = $b['feat_image'];
                                if (empty($gambarDB)) { $imgSrc = 'https://via.placeholder.com/60?text=IMG'; } 
                                elseif (strpos($gambarDB, 'http') === 0) { $imgSrc = $gambarDB; } 
                                 else {
                                    $cleanPath = ltrim($gambarDB, '/');
                                    $imgSrc = (strpos($cleanPath, 'uploads/') === 0) ? base_url($cleanPath) : base_url('uploads/' . $cleanPath);
                                }
                                $tgl = isset($b['tanggal']) ? date('d M Y', strtotime($b['tanggal'])) : '-';
                                $judulSafe = addslashes(esc($b['judul']));
                            ?>
                            <div class="news-item-option search-item" data-search="<?= strtolower(esc($b['judul'])) ?>"
                                 onclick="selectSisipan('sisipan2', '<?= $b['id_berita'] ?>', '<?= $judulSafe ?>', '<?= $imgSrc ?>', '<?= $tgl ?>')">
                                <img src="<?= $imgSrc ?>" class="news-item-img" alt="Thumb">
                                <div class="news-item-content">
                                    <div class="news-item-title"><?= esc($b['judul']) ?></div>
                                    <div class="news-item-date"><i class="bi bi-calendar3"></i> <?= $tgl ?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="p-3 text-center text-muted no-result-msg" style="display:none;">Tidak ditemukan</div>
                    </div>
                </div>
                <small class="text-muted mt-2 d-block">Berita ini akan muncul di akhir Berita 2.</small>
            </div>
            </div>
        </div> 
    </div>


        <div class="form-section">
            <div class="section-title"><i class="bi bi-tags"></i> Kategori & Klasifikasi</div>
            
            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <?php 
                    $selected = old('id_kategori', $selected ?? []);
                    if (!is_array($selected)) $selected = explode(',', $selected);
                ?>
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
                            <?php foreach ($kategori as $kat): ?>
                                <div class="form-check ps-3 py-1 kategori-item" data-name="<?= esc(strtolower($kat['kategori'])) ?>">
                                    <input class="form-check-input kategori-checkbox" type="checkbox" 
                                           id="kat-<?= $kat['id_kategori'] ?>" value="<?= $kat['id_kategori'] ?>"
                                           <?= in_array($kat['id_kategori'], $selected) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="kat-<?= $kat['id_kategori'] ?>"><?= esc($kat['kategori']) ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="kategori-no-results" class="px-3 py-2 text-center text-gray-500" style="display: none;">
                            <small>Tidak ada kategori yang cocok</small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_kategori" id="kategori-hidden" value="<?= implode(',', $selected) ?>">
                <div id="selected-kategori-badges" class="mt-2 d-flex flex-wrap"></div>
            </div>

<div class="mb-3">
    <label class="form-label">Tags</label>
    
    <?php 
        // ✅ PERBAIKAN LOGIKA - Prioritaskan $selectedTags (relasi many-to-many)
        // JANGAN pakai $berita['id_tags'] karena itu cuma single value!
        
        $currentTagsData = old('id_tags', $selectedTags ?? []); 
        
        // Normalisasi: Pastikan formatnya Array
        if (!is_array($currentTagsData)) {
            // Jika string comma-separated (dari old input atau fallback)
            $currentTagsData = array_filter(explode(',', $currentTagsData));
        }
        
        // Convert ke string untuk debugging (optional)
        // echo "<!-- DEBUG Tags: " . print_r($currentTagsData, true) . " -->";
    ?>

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
                <?php foreach ($tags as $tag): ?>
                    <div class="form-check ps-3 py-1 tags-item" data-name="<?= esc(strtolower($tag['nama_tag'])) ?>">
                        <?php
                            // ✅ PERBAIKAN: Konversi ke string untuk perbandingan yang akurat
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
            <div id="tags-no-results" class="px-3 py-2 text-center text-gray-500" style="display: none;">
                <small>Tidak ada tags yang cocok</small>
            </div>
        </div>
    </div>

    <input type="hidden" name="id_tags" id="tags-hidden" value="<?= implode(',', $currentTagsData) ?>">
    
    <div id="selected-tags-badges" class="mt-2 d-flex flex-wrap"></div>
</div>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-images"></i> Media & Gambar</div>

            <div class="mb-4">
                <label class="form-label">Foto Cover (Utama)</label>
                
                <div class="mb-3">
                    <?php if(!empty($tempCoverImage)): ?>
                        <div class="current-image-wrapper">
                            <span class="current-image-badge" style="background: var(--info);">
                                <i class="bi bi-clock-history me-1"></i>Gambar Temporary
                            </span>
                            <img src="<?= base_url('public/uploads/temp/' . $tempCoverImage) ?>" class="preview-img" alt="Temp Cover">
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
                    <label class="form-label text-muted small">Caption Cover:</label>
                    <input type="text" name="caption_cover" class="form-control" 
                           placeholder="Keterangan foto cover..." 
                           value="<?= esc(old('caption_cover', $berita['caption'])) ?>">
                </div>
            </div>

<div class="mb-4">
    <label class="form-label">Foto Tambahan</label>
    
    <?php 
    $oldAdditional = !empty($berita['additional_images']) ? json_decode($berita['additional_images'], true) : [];
    ?>
    
    <?php if (!empty($oldAdditional)): ?>
        <label class="form-label small text-muted mb-2">Gambar Sebelumnya (Klik X untuk menghapus, edit caption di bawah gambar)</label>
        <div class="row mb-3">
            <?php foreach ($oldAdditional as $index => $img): ?>
                <?php 
                    $path = is_array($img) ? $img['path'] : $img;
                    $cap  = is_array($img) ? ($img['caption'] ?? '') : '';
                    $filePath = FCPATH . ltrim($path, '/');
                    if (!file_exists($filePath)) continue; 
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border shadow-sm position-relative">
                        <span class="old-badge">Lama</span>
                        <button type="button" class="btn-delete-img delete-old-image" data-image="<?= $path ?>">✕</button>
                        
                        <img src="<?= base_url($path) ?>" alt="Old Image" class="card-img-top" style="height: 150px; object-fit: cover;">
                        
                        <div class="card-body p-2">
                            <label class="form-label text-muted small mb-1">Caption:</label>
                            <input type="text" 
                                   name="caption_existing[]" 
                                   class="form-control form-control-sm" 
                                   placeholder="Edit caption..." 
                                   value="<?= esc($cap) ?>"
                                   data-old-path="<?= esc($path) ?>">
                            <input type="hidden" name="existing_image_paths[]" value="<?= esc($path) ?>">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($tempAdditionalImages) && is_array($tempAdditionalImages)): ?>
        <label class="form-label small text-info mb-2">Gambar Baru (Temporary)</label>
        <div class="row mb-3" id="temp-additional-images">
            <?php $oldCaptions = old('caption_additional', []); ?>
            <?php foreach ($tempAdditionalImages as $index => $tempImage): ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-info shadow-sm">
                        <div class="position-relative">
                            <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" class="card-img-top" style="height: 120px; object-fit: cover;">
                            <div class="temp-image-badge"><i class="bi bi-clock-history"></i></div>
                        </div>
                        <div class="card-body p-2 bg-light">
                            <label class="form-label text-muted small mb-1">Caption:</label>
                            <input type="text" name="caption_additional[]" 
                                   class="form-control form-control-sm" 
                                   placeholder="Ket. foto..."
                                   value="<?= isset($oldCaptions[$index]) ? esc($oldCaptions[$index]) : '' ?>">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="retained-image-info mb-3">
            <i class="bi bi-info-circle-fill"></i>
            <strong><?= count($tempAdditionalImages) ?> gambar baru tersimpan sementara.</strong>
        </div>
    <?php endif; ?>

    <input type="file" name="additional_images[]" class="form-control" accept="image/*" id="additional-images" multiple>
    <small class="text-muted">Upload gambar baru lagi untuk menambah koleksi.</small>
    
    <div id="additional-preview-new" class="row mt-3"></div>
</div>

         

        <div class="mb-3">
            <label class="form-label">Waktu Publish</label>
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                <input type="text" id="datetime-picker" name="tanggal" class="form-control bg-white" 
                       placeholder="Pilih tanggal dan jam..." 
                       value="<?= old('tanggal', date('Y-m-d H:i', strtotime($berita['tanggal']))) ?>">
            </div>
        </div>

        
   <?php 
    // TENTUKAN LOGIKA CEK ROLE DI SINI
    // Sesuaikan dengan sistem login Anda (pilih salah satu contoh di bawah):
    
    // Opsi A: Jika pakai Session Manual
    $isAllowed = in_array(session('role'), ['admin', 'superadmin']);

    // Opsi B: Jika pakai Myth:Auth
    // $isAllowed = in_groups(['admin', 'superadmin']);

    // Opsi C: Jika pakai CI Shield
    // $isAllowed = auth()->user()->inGroup('admin', 'superadmin');
?>

<?php if ($isAllowed) : ?>

    <div class="form-section">
        <div class="section-title"><i class="bi bi-gear"></i> Status & Catatan Admin (Superadmin/Admin)</div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Status Tayang</label>
                <select name="status" id="status-publish" class="form-select">
                    <option value="1" <?= old('status', $berita['status']) == '1' ? 'selected' : '' ?>>🟢 Tayang</option>
                    <option value="5" <?= old('status', $berita['status']) == '5' ? 'selected' : '' ?>>🔴 Tidak Tayang</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Status Berita</label>
                <select name="status_berita" class="form-select bg-light">
                    <option value="0" <?= old('status_berita', $berita['status_berita']) == '0' ? 'selected' : '' ?>>📝 Draft</option>
                    <option value="2" <?= old('status_berita', $berita['status_berita']) == '2' ? 'selected' : '' ?>>⏳ Menunggu Verifikasi</option>
                    <option value="3" <?= old('status_berita', $berita['status_berita']) == '3' ? 'selected' : '' ?>>❌ Ditolak</option>
                    <option value="4" <?= old('status_berita', $berita['status_berita']) == '4' ? 'selected' : '' ?>>✅ Layak Tayang</option>
                    <option value="6" <?= old('status_berita', $berita['status_berita']) == '6' ? 'selected' : '' ?>>🔄 Revisi</option>
                </select>
                <small class="text-muted">Ubah status verifikasi di sini (Hak akses Admin/Superadmin).</small>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Admin/Superadmin</label>
            <textarea name="note" class="form-control" rows="3"><?= esc(old('note', $berita['note'])) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Note Revisi</label>
            <textarea name="note_revisi" class="form-control" rows="3"><?= esc(old('note_revisi', $berita['note_revisi'])) ?></textarea>
        </div>
    </div>

<?php endif; ?>
                <div class="action-buttons d-flex justify-content-end gap-2">
    <a href="<?= site_url('berita') ?>" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>

    <button type="submit" name="submit_type" value="pending" class="btn btn-warning text-white fw-semibold">
        <i class="bi bi-hourglass-split"></i> Ajukan Verifikasi
    </button>

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
document.addEventListener('DOMContentLoaded', function() {

    // ============================================================
    // 0. LOGIK STATUS TAYANG OTOMATIS
    // ============================================================
    const btnDraft = document.querySelector('button[value="draft"]');
    const btnVerif = document.querySelector('button[value="pending"]');
    const statusSelect = document.getElementById('status-publish');

    function forceStatusOff() {
        if(statusSelect) {
            statusSelect.value = '5';
        }
    }

    if(btnDraft) btnDraft.addEventListener('click', forceStatusOff);
    if(btnVerif) btnVerif.addEventListener('click', forceStatusOff);

    // ============================================================
    // 1. TOGGLE CONTENT 2 LOGIC
    // ============================================================
    const toggleContent2 = document.getElementById('toggle-content2');
    const wrapperContent2 = document.getElementById('wrapper-content2');
    const hasContent2Val = document.getElementById('has-content2-val');

    function handleToggleContent2() {
        if (toggleContent2.checked) {
            wrapperContent2.style.display = 'block';
            hasContent2Val.value = '1';
        } else {
            wrapperContent2.style.display = 'none';
            hasContent2Val.value = '0';
        }
    }

    if(toggleContent2) {
        toggleContent2.addEventListener('change', handleToggleContent2);
        handleToggleContent2();
    }

    // ============================================================
    // 2. CONFIG QUILL EDITOR
    // ============================================================
    const formBerita = document.getElementById('form-berita');
    const contentHidden = document.getElementById('content-hidden');
    const content2Hidden = document.getElementById('content2-hidden');

    const quillContent = new Quill('#editor-content .ql-editor', {
        modules: { toolbar: '#toolbar-content' },
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...'
    });

    const quillContent2 = new Quill('#editor-content2 .ql-editor', {
        modules: { toolbar: '#toolbar-content2' },
        theme: 'snow',
        placeholder: 'Tulis isi berita bagian kedua di sini...'
    });

    formBerita.addEventListener('submit', function() {
        contentHidden.value = quillContent.root.innerHTML;
        content2Hidden.value = quillContent2.root.innerHTML;
    });

    // ============================================================
    // 3. DELETE OLD IMAGE (DATABASE)
    // ============================================================
    document.querySelectorAll('.delete-old-image').forEach(btn => {
        btn.addEventListener('click', function() {
            let imgPath = this.getAttribute('data-image');
            
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_old_images[]';
            input.value = imgPath;
            formBerita.appendChild(input);

            this.closest('.old-image-card').remove();
        });
    });

    // ============================================================
    // 4. PREVIEW & DELETE NEW IMAGES
    // ============================================================
    const additionalInput = document.getElementById('additional-images');
    const additionalPreviewNew = document.getElementById('additional-preview-new');
    let dt = new DataTransfer();

    if(additionalInput) {
        additionalInput.addEventListener('change', function(){
            for(let i = 0; i < this.files.length; i++){
                dt.items.add(this.files[i]);
            }
            this.files = dt.files;
            renderPreview();
        });
    }

    function renderPreview(){
        if(!additionalPreviewNew) return;
        additionalPreviewNew.innerHTML = '';

        for(let i = 0; i < dt.files.length; i++){
            let file = dt.files[i];
            let col = document.createElement('div');
            col.className = 'col-md-3 mb-3 position-relative';
            
            let reader = new FileReader();
            reader.onload = function(e){
                col.innerHTML = `
                    <div class="card h-100 shadow-sm border-0">
                        <button type="button" class="btn-delete-img" onclick="removeNewImage(${i})">✕</button>
                        <img src="${e.target.result}" class="card-img-top" style="height: 100px; object-fit: cover; border-radius: 8px;">
                        <div class="card-body p-2">
                            <input type="text" name="caption_new[]" class="form-control form-control-sm" placeholder="Caption...">
                        </div>
                    </div>
                `;
                additionalPreviewNew.appendChild(col);
            }
            reader.readAsDataURL(file);
        }
    }

    window.removeNewImage = function(index) {
        let dtTemp = new DataTransfer();
        for(let i = 0; i < dt.files.length; i++){
            if(i !== index) dtTemp.items.add(dt.files[i]);
        }
        dt = dtTemp;
        additionalInput.files = dt.files;
        renderPreview();
    };

    // ============================================================
    // 5. FLAT PICKER (DATETIME)
    // ============================================================
    flatpickr("#datetime-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        locale: "id"
    });

    // ============================================================
    // 6. DROPDOWN KATEGORI (UNIFIED)
    // ============================================================
    const katDropdown = document.getElementById('kategori-dropdown');
    const katToggle = document.getElementById('kategori-toggle');
    const katMenu = katDropdown.querySelector('.dropdown-menu');
    const katSearch = document.getElementById('kategori-search');
    const katItems = document.querySelectorAll('.kategori-item');
    const katCheckboxes = document.querySelectorAll('.kategori-checkbox');
    const katHidden = document.getElementById('kategori-hidden');
    const katBadges = document.getElementById('selected-kategori-badges');
    const katPlaceholder = document.getElementById('kategori-placeholder');
    const katNoResults = document.getElementById('kategori-no-results');

    // Toggle dropdown
    katToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        katMenu.classList.toggle('show');
        if (katMenu.classList.contains('show')) katSearch.focus();
    });

    // Search functionality
    katSearch.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        let hasResult = false;
        katItems.forEach(item => {
            const text = item.getAttribute('data-name');
            if (text.includes(filter)) {
                item.style.display = '';
                hasResult = true;
            } else {
                item.style.display = 'none';
            }
        });
        katNoResults.style.display = hasResult ? 'none' : 'block';
    });

    // Checkbox change event
    katCheckboxes.forEach(chk => {
        chk.addEventListener('change', updateSelectedKategori);
    });

    function updateSelectedKategori() {
        const selected = [];
        katBadges.innerHTML = '';
        
        katCheckboxes.forEach(chk => {
            if (chk.checked) {
                selected.push(chk.value);
                const label = chk.nextElementSibling.innerText.trim();
                
                const badge = document.createElement('span');
                badge.className = 'selected-badge';
                badge.innerHTML = `${label} <i class="bi bi-x" onclick="uncheckKategori('${chk.value}')"></i>`;
                katBadges.appendChild(badge);
            }
        });
        
        katHidden.value = selected.join(',');
        katPlaceholder.innerText = selected.length > 0 
            ? `${selected.length} kategori dipilih` 
            : 'Pilih minimal 1 kategori';
    }

    window.uncheckKategori = function(val) {
        const chk = document.getElementById('kat-' + val);
        if (chk) {
            chk.checked = false;
            updateSelectedKategori();
        }
    };

    // Initialize kategori
    updateSelectedKategori();

    // ============================================================
    // 7. DROPDOWN TAGS (UNIFIED - FIXED)
    // ============================================================
    const tagDropdown = document.getElementById('tags-dropdown');
    const tagToggle = document.getElementById('tags-toggle');
    const tagMenu = tagDropdown.querySelector('.dropdown-menu');
    const tagSearch = document.getElementById('tags-search');
    const tagItems = document.querySelectorAll('.tags-item');
    const tagCheckboxes = document.querySelectorAll('.tags-checkbox');
    const tagHidden = document.getElementById('tags-hidden');
    const tagBadges = document.getElementById('selected-tags-badges');
    const tagPlaceholder = document.getElementById('tags-placeholder');
    const tagNoResults = document.getElementById('tags-no-results');

    // Toggle dropdown
    tagToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        tagMenu.classList.toggle('show');
        if (tagMenu.classList.contains('show')) tagSearch.focus();
    });

    // Search functionality
    tagSearch.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        let hasResult = false;
        tagItems.forEach(item => {
            const text = item.getAttribute('data-name');
            if (text.includes(filter)) {
                item.style.display = '';
                hasResult = true;
            } else {
                item.style.display = 'none';
            }
        });
        tagNoResults.style.display = hasResult ? 'none' : 'block';
    });

    // Checkbox change event
    tagCheckboxes.forEach(chk => {
        chk.addEventListener('change', updateSelectedTags);
    });

    function updateSelectedTags() {
        const selected = [];
        tagBadges.innerHTML = '';
        
        tagCheckboxes.forEach(chk => {
            if (chk.checked) {
                selected.push(chk.value);
                const label = chk.nextElementSibling.innerText.trim();
                
                const badge = document.createElement('span');
                badge.className = 'selected-badge bg-secondary';
                badge.innerHTML = `${label} <i class="bi bi-x" onclick="uncheckTag('${chk.value}')"></i>`;
                tagBadges.appendChild(badge);
            }
        });
        
        tagHidden.value = selected.join(',');
        tagPlaceholder.innerText = selected.length > 0 
            ? `${selected.length} tags dipilih` 
            : 'Pilih tags (opsional)';
    }

    window.uncheckTag = function(val) {
        const chk = document.getElementById('tag-' + val);
        if (chk) {
            chk.checked = false;
            updateSelectedTags();
        }
    };

    // Initialize tags
    updateSelectedTags();

    // ============================================================
    // 8. HIDE DROPDOWNS ON OUTSIDE CLICK
    // ============================================================
    document.addEventListener('click', (e) => {
        if (!katDropdown.contains(e.target)) {
            katMenu.classList.remove('show');
        }
        if (!tagDropdown.contains(e.target)) {
            tagMenu.classList.remove('show');
        }
    });

    // ============================================================
    // 9. COVER IMAGE PREVIEW
    // ============================================================
    const coverInput = document.getElementById('cover-image');
    const coverPreview = document.getElementById('new-cover-preview');
    
    if(coverInput){
        coverInput.addEventListener('change', function(e){
            const file = e.target.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function(e){
                    coverPreview.innerHTML = `<img src="${e.target.result}" class="preview-img mt-2" style="max-height:150px">`;
                }
                reader.readAsDataURL(file);
            } else {
                coverPreview.innerHTML = '';
            }
        });
    }

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
<script>
    // --- 1. SETUP QUILL EDITOR ---
    var quill1 = new Quill('#editor-content', {
        theme: 'snow',
        modules: { toolbar: '#toolbar-content' }
    });

    var quill2 = new Quill('#editor-content2', {
        theme: 'snow',
        modules: { toolbar: '#toolbar-content2' }
    });

    // Saat form disubmit, pindahkan isi editor ke textarea hidden
    document.querySelector('#form-berita').onsubmit = function() {
        document.querySelector('#content-hidden').value = quill1.root.innerHTML;
        document.querySelector('#content2-hidden').value = quill2.root.innerHTML;
    };


    // --- 2. LOGIKA DROPDOWN SISIPAN (PENTING) ---
    
    // Fungsi untuk memilih item
    function selectSisipan(targetPrefix, id, title, imgSrc, date) {
        // 1. Set nilai input hidden
        document.getElementById(targetPrefix + '-input').value = id;
        
        // 2. Update Label Tombol
        var labelEl = document.getElementById(targetPrefix + '-label');
        var imgEl = document.getElementById(targetPrefix + '-preview-img');

        if(id) {
            // Jika ada yang dipilih
            labelEl.innerHTML = '<span class="fw-bold text-dark">' + title + '</span> <br> <span class="small text-muted">' + date + '</span>';
            labelEl.classList.remove('text-muted');
            
            if(imgSrc) {
                imgEl.src = imgSrc;
                imgEl.classList.remove('d-none');
            }
        } else {
            // Jika dikosongkan (Reset)
            labelEl.textContent = '-- Pilih Berita Sisipan --';
            labelEl.classList.add('text-muted');
            imgEl.classList.add('d-none');
        }
    }

    // Fungsi Pencarian (Search) di dalam Dropdown
    document.querySelectorAll('.search-sisipan').forEach(input => {
        input.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let targetListId = this.getAttribute('data-target');
            let container = document.getElementById(targetListId);
            let items = container.querySelectorAll('.search-item');
            let hasResult = false;

            items.forEach(item => {
                let text = item.getAttribute('data-search');
                if (text.indexOf(filter) > -1) {
                    item.style.display = "flex";
                    hasResult = true;
                } else {
                    item.style.display = "none";
                }
            });

            // Tampilkan pesan jika tidak ada hasil
            let noResultMsg = container.parentNode.querySelector('.no-result-msg');
            if(noResultMsg) {
                noResultMsg.style.display = hasResult ? 'none' : 'block';
            }
        });
    });


    // --- 3. LOGIKA TOGGLE KONTEN 2 ---
    document.getElementById('toggle-content2').addEventListener('change', function() {
        var wrapper = document.getElementById('wrapper-content2');
        var hiddenInput = document.getElementById('has-content2-val');
        
        if(this.checked) {
            wrapper.style.display = 'block';
            hiddenInput.value = '1';
        } else {
            wrapper.style.display = 'none';
            hiddenInput.value = '0';
        }
    });

    // --- 4. PRELOAD NILAI LAMA (JIKA EDIT) ---
    // Jika sedang mode edit, kita perlu memicu UI update agar sisipan terpilih terlihat
    // Anda bisa menambahkan logika PHP kecil di sini untuk trigger selectSisipan() saat load page
    // Contoh sederhana manual trigger jika ada data (opsional)
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Jalankan pengecekan saat halaman pertama kali dibuka (untuk mode Edit)
    checkSisipanDependency();
});

// Fungsi Logika Dependency
function checkSisipanDependency() {
    const sisipan1Input = document.getElementById('sisipan1-input');
    const sisipan2Btn = document.querySelector('#sisipan2-wrapper button');
    const sisipan2Wrapper = document.getElementById('sisipan2-wrapper');
    
    // Cek apakah Sisipan 1 ada nilainya (tidak kosong)
    const isSisipan1Filled = sisipan1Input.value.trim() !== "";

    if (isSisipan1Filled) {
        // --- AKTIFKAN SISIPAN 2 ---
        sisipan2Btn.removeAttribute('disabled');
        sisipan2Btn.classList.remove('bg-light', 'text-muted');
        sisipan2Wrapper.style.cursor = 'default';
        sisipan2Btn.style.pointerEvents = 'auto';
    } else {
        // --- NONAKTIFKAN SISIPAN 2 ---
        sisipan2Btn.setAttribute('disabled', 'true');
        sisipan2Btn.classList.add('bg-light', 'text-muted'); // Visual abu-abu
        sisipan2Wrapper.style.cursor = 'not-allowed';
        sisipan2Btn.style.pointerEvents = 'none'; // Mencegah klik
    }
}

// Fungsi Utama Memilih Sisipan (Update fungsi yang sudah ada atau gunakan ini)
function selectSisipan(target, id, title, img, date) {
    // 1. Update Input Hidden
    document.getElementById(target + '-input').value = id;

    // 2. Update Tampilan Label & Gambar
    const label = document.getElementById(target + '-label');
    const previewImg = document.getElementById(target + '-preview-img');

    if (id) {
        // Jika memilih berita
        label.innerText = title;
        label.classList.remove('text-muted');
        label.classList.add('text-dark', 'fw-bold');
        
        previewImg.src = img;
        previewImg.classList.remove('d-none');
    } else {
        // Jika memilih "Kosongkan/Hapus"
        label.innerText = (target === 'sisipan1') ? '-- Pilih Berita Sisipan --' : '-- Pilih Berita Sisipan 2 --';
        label.classList.add('text-muted');
        label.classList.remove('text-dark', 'fw-bold');
        
        previewImg.src = '';
        previewImg.classList.add('d-none');
    }

    // 3. LOGIKA DEPENDENCY KHUSUS SISIPAN 1
    if (target === 'sisipan1') {
        // Jika Sisipan 1 dikosongkan, maka Sisipan 2 harus di-reset dan dimatikan
        if (!id) {
            resetSisipan2();
        }
        // Jalankan pengecekan status tombol
        checkSisipanDependency();
    }
}

// Fungsi Helper untuk Mereset Sisipan 2 (Jika Sisipan 1 dihapus)
function resetSisipan2() {
    document.getElementById('sisipan2-input').value = '';
    
    const label = document.getElementById('sisipan2-label');
    const previewImg = document.getElementById('sisipan2-preview-img');
    
    label.innerText = '-- Pilih Berita Sisipan 2 --';
    label.classList.add('text-muted');
    label.classList.remove('text-dark', 'fw-bold');
    
    previewImg.src = '';
    previewImg.classList.add('d-none');
}

// Fitur Pencarian di Dropdown (Opsional, agar search tetap jalan)
document.querySelectorAll('.search-sisipan').forEach(input => {
    input.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const targetList = document.getElementById(this.dataset.target);
        const items = targetList.querySelectorAll('.search-item');
        let hasResult = false;

        items.forEach(item => {
            const text = item.dataset.search;
            if (text.includes(filter)) {
                item.style.display = 'flex';
                hasResult = true;
            } else {
                item.style.display = 'none';
            }
        });

        const noResult = targetList.querySelector('.no-result-msg');
        if (noResult) noResult.style.display = hasResult ? 'none' : 'block';
    });
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Logika Toggle Advanced (Sisipan 1 + Content 2 + Sisipan 2)
        const toggleAdv = document.getElementById('toggle-advanced');
        const wrapperAdv = document.getElementById('wrapper-advanced');
        const hiddenVal = document.getElementById('has-content2-val');

        if(toggleAdv && wrapperAdv) {
            toggleAdv.addEventListener('change', function() {
                if(this.checked) {
                    wrapperAdv.style.display = 'block';
                    hiddenVal.value = '1';
                } else {
                    wrapperAdv.style.display = 'none';
                    hiddenVal.value = '0';
                    // Optional: Kosongkan value jika dimatikan agar tidak tersimpan
                    // tapi biasanya user ingin datanya tetap ada kalau kepencet off
                }
            });
        }
        
        // ... (Kode Javascript Select Sisipan/Quill/dll biarkan saja) ...
    });
</script>
<?= $this->endSection() ?>