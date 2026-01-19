<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
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

    /* Preview gambar kompak */
    .preview-img {
        max-width: 150px;
        max-height: 150px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        margin-top: 8px;
    }

    .additional-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 8px;
        margin-top: 12px;
    }

    .additional-preview img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 6px;
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
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$oldContent1 = old('content', '');
$oldContent2 = old('content2', '');
$oldContent1 = htmlspecialchars_decode($oldContent1, ENT_QUOTES);
$oldContent2 = htmlspecialchars_decode($oldContent2, ENT_QUOTES);
?>

<div class="compact-header">
    <h1><i class="bi bi-file-earmark-plus"></i> Tambah Berita Baru</h1>
</div>

<?= $this->include('layouts/alerts') ?>

<div class="compact-form">
    <form action="<?= site_url('berita') ?>" method="post" enctype="multipart/form-data" id="form-berita">
        <?= csrf_field() ?>

        <!-- Hidden input untuk menyimpan daftar gambar temporary yang dihapus -->
        <input type="hidden" name="deleted_temp_images" id="deleted-temp-images" value="<?= old('deleted_temp_images', '') ?>">

        <div class="compact-section">
            <div class="section-title"><i class="bi bi-info-circle"></i> Informasi Dasar</div>
            
            <div class="compact-grid">
                <div>
                    <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul berita" value="<?= old('judul') ?>">
                </div>
                
                <div>
                    <label class="form-label">Sumber Berita</label>
                    <input type="text" name="sumber" class="form-control" placeholder="Contoh: Kompas.com" value="<?= old('sumber') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Intro Singkat</label>
                <textarea name="intro" class="form-control" rows="2" placeholder="Deskripsi singkat yang menarik pembaca"><?= old('intro') ?></textarea>
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
                    <div class="ql-editor" data-placeholder="Tulis isi berita di sini..."></div>
                </div>
                <textarea name="content" id="content-hidden" style="display:none;"></textarea>
            </div>

            <div class="d-flex align-items-center mb-3 p-2 bg-gray-50 border rounded">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="toggle-content2"
                        <?= (old('has_content2') == '1' || !empty($oldContent2)) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="toggle-content2" style="font-size: 0.875rem;">
                        Tambah Bagian Kedua
                    </label>
                </div>
                <input type="hidden" name="has_content2" id="has-content2-val" value="<?= (old('has_content2') == '1' || !empty($oldContent2)) ? '1' : '0' ?>">
            </div>

            <div class="sisipan-box mb-3" id="box-sisipan-1" style="display: none;">
                <label class="form-label d-flex align-items-center">
                    <i class="bi bi-paperclip me-2"></i> Berita Sisipan 1
                </label>

                <div class="dropdown custom-img-select" id="sisipan1-wrapper">
                    <input type="hidden" name="id_berita_terkait" id="sisipan1-input" value="<?= old('id_berita_terkait') ?>">
                    <button class="form-select dropdown-toggle-custom" type="button" id="sisipan1-btn" data-bs-toggle="dropdown">
                        <span id="sisipan1-label" class="text-muted">-- Pilih Berita Sisipan --</span>
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
                                $gambarDB = $b['feat_image'];
                                if (empty($gambarDB)) {
                                    $imgSrc = 'https://via.placeholder.com/50?text=IMG';
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

            <div id="wrapper-content2" style="display: none;">
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
                        <div class="ql-editor" data-placeholder="Tulis isi berita bagian kedua di sini..."></div>
                    </div>
                    <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>

                    <div class="sisipan-box mt-2">
                        <label class="form-label d-flex align-items-center">
                            <i class="bi bi-paperclip me-2"></i> Berita Sisipan 2
                        </label>
                        <div class="dropdown custom-img-select" id="sisipan2-wrapper">
                            <input type="hidden" name="id_berita_terkait2" id="sisipan2-input" value="<?= old('id_berita_terkait2') ?>">
                            <button class="form-select dropdown-toggle-custom" type="button" id="sisipan2-btn" data-bs-toggle="dropdown" disabled>
                                <span id="sisipan2-label" class="text-muted">-- Pilih Sisipan 1 Terlebih Dahulu --</span>
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
                                        $gambarDB = $b['feat_image'];
                                        if (empty($gambarDB)) {
                                            $imgSrc = 'https://via.placeholder.com/50?text=IMG';
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
                            <div id="kategori-no-results" class="px-2 py-2 text-center text-gray-500" style="display: none;">
                                <small>Tidak ada kategori yang cocok</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_kategori" id="kategori-hidden" value="<?= implode(',', $oldKategori) ?>">
                    <div id="selected-kategori-badges" class="mt-2 d-flex flex-wrap"></div>
                </div>

                <div>
                    <label class="form-label">Tags</label>
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
                            <div id="tags-no-results" class="px-2 py-2 text-center text-gray-500" style="display: none;">
                                <small>Tidak ada tags yang cocok</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_tags" id="tags-hidden" value="<?= implode(',', $oldTags) ?>">
                    <div id="selected-tags-badges" class="mt-2 d-flex flex-wrap"></div>
                </div>
            </div>
        </div>

        <div class="compact-section">
            <div class="section-title"><i class="bi bi-images"></i> Media</div>
            
            <div class="compact-grid">
                <div>
                    <label class="form-label">Foto Cover <span class="text-danger">*</span></label>
                    <input type="file" name="feat_image" class="form-control" accept="image/*" id="cover-image" <?= empty($tempCoverImage) ? 'required' : '' ?>>
                    <small class="text-muted">JPG, PNG, GIF (Maks. 2MB)</small>
                    
                    <div id="cover-preview" class="mt-2">
                        <?php if (!empty($tempCoverImage)): ?>
                            <div class="position-relative d-inline-block">
                                <img src="<?= base_url('uploads/temp/' . $tempCoverImage) ?>" class="preview-img">
                                <div class="badge bg-info mt-1"><i class="bi bi-clock-history"></i> Gambar Sebelumnya</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mt-2">
                        <input type="text" name="caption_cover" class="form-control form-control-sm" placeholder="Caption cover..." value="<?= old('caption_cover') ?>">
                    </div>
                </div>
                
                <div>
                    <label class="form-label">Foto Tambahan</label>
                    <input type="file" name="additional_images[]" class="form-control" accept="image/*" id="additional-images" multiple>
                    <small class="text-muted">Pilih beberapa foto</small>
                    
                    <?php 
                    // PERBAIKAN: Filter temp images yang belum dihapus dengan cara yang benar
                    $displayTempImages = [];
                    if (!empty($tempAdditionalImages) && is_array($tempAdditionalImages)) {
                        // Ambil daftar gambar yang sudah dihapus dari old()
                        $deletedTempImages = old('deleted_temp_images', '');
                        
                        // Debug: Tampilkan informasi debugging
                        // echo "<!-- DEBUG: tempAdditionalImages count: " . count($tempAdditionalImages) . " -->";
                        // echo "<!-- DEBUG: deletedTempImages: " . $deletedTempImages . " -->";
                        
                        if (!empty($deletedTempImages)) {
                            // Jika ada string deleted_temp_images, konversi ke array
                            if (is_string($deletedTempImages)) {
                                $deletedArray = explode(',', $deletedTempImages);
                            } elseif (is_array($deletedTempImages)) {
                                $deletedArray = $deletedTempImages;
                            } else {
                                $deletedArray = [];
                            }
                            
                            // Debug
                            // echo "<!-- DEBUG: deletedArray count: " . count($deletedArray) . " -->";
                            
                            // Filter gambar yang TIDAK ada di daftar deleted
                            foreach ($tempAdditionalImages as $index => $tempImage) {
                                if (!in_array($tempImage, $deletedArray)) {
                                    $displayTempImages[] = $tempImage;
                                }
                            }
                        } else {
                            // Jika tidak ada deleted_temp_images, tampilkan semua
                            $displayTempImages = $tempAdditionalImages;
                        }
                    }
                    
                    if (!empty($displayTempImages)):
                        $oldCaptions = old('caption_additional_temp', []);
                        // Debug
                        // echo "<!-- DEBUG: displayTempImages count: " . count($displayTempImages) . " -->";
                        // echo "<!-- DEBUG: oldCaptions count: " . count($oldCaptions) . " -->";
                    ?>
                        <div class="additional-preview mt-2" id="temp-additional-preview">
                            <?php foreach ($displayTempImages as $index => $tempImage): ?>
                                <?php 
                                // Cari caption yang sesuai untuk gambar ini
                                $captionIndex = array_search($tempImage, $tempAdditionalImages);
                                $captionValue = '';
                                if ($captionIndex !== false && isset($oldCaptions[$captionIndex])) {
                                    $captionValue = $oldCaptions[$captionIndex];
                                }
                                ?>
                                <div class="position-relative" id="temp-img-card-<?= $index ?>">
                                    <input type="hidden" name="temp_uploaded_files[]" value="<?= esc($tempImage) ?>">
                                    <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" class="img-fluid rounded">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" 
                                            onclick="removeTempImage('<?= esc($tempImage) ?>', 'temp-img-card-<?= $index ?>', <?= $index ?>)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    <input type="text" name="caption_additional_temp[]" class="form-control form-control-sm mt-1" 
                                           placeholder="Caption..." 
                                           value="<?= esc($captionValue) ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div id="additional-preview-new" class="additional-preview mt-2"></div>
                </div>
            </div>
            
            <div class="mt-3">
                <label class="form-label">Waktu Publish</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                    <input type="text" id="datetime-picker" name="tanggal" class="form-control" placeholder="Pilih tanggal dan jam..." value="<?= old('tanggal') ?>">
                </div>
            </div>
        </div>

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
            
            <button type="submit" name="submit_type" value="draft" class="btn btn-draft">
                <i class="bi bi-file-earmark-text"></i> Draft
            </button>
            
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
// Global Functions
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

function deleteAdditionalPreview(index) {
    const preview = document.getElementById('additional-preview-' + index);
    if (preview) preview.remove();
    
    const input = document.getElementById('additional-images');
    const dt = new DataTransfer();
    const files = input.files;
    
    for (let i = 0; i < files.length; i++) {
        if (i !== index) dt.items.add(files[i]);
    }
    
    input.files = dt.files;
}

// PERBAIKAN: Fungsi removeTempImage yang menyimpan daftar gambar yang dihapus
function removeTempImage(imageName, elementId, index) {
    const element = document.getElementById(elementId);
    if (element) {
        // Tambahkan nama gambar ke daftar yang dihapus
        const deletedInput = document.getElementById('deleted-temp-images');
        let deletedArray = [];
        
        // PERBAIKAN: Jangan lupa ambil nilai yang sudah ada
        if (deletedInput.value && deletedInput.value.trim() !== '') {
            deletedArray = deletedInput.value.split(',');
            // Bersihkan array dari nilai kosong
            deletedArray = deletedArray.filter(item => item.trim() !== '');
        }
        
        // Cegah duplikasi
        if (!deletedArray.includes(imageName)) {
            deletedArray.push(imageName);
            deletedInput.value = deletedArray.join(',');
            console.log('Deleted images:', deletedInput.value);
        }
        
        // Hapus dari DOM
        element.remove();
        
        // PERBAIKAN: Update session storage jika perlu (opsional)
        if (typeof(Storage) !== "undefined") {
            let sessionDeleted = JSON.parse(sessionStorage.getItem('deleted_temp_images') || '[]');
            if (!sessionDeleted.includes(imageName)) {
                sessionDeleted.push(imageName);
                sessionStorage.setItem('deleted_temp_images', JSON.stringify(sessionDeleted));
            }
        }
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

// Fungsi khusus untuk ENTER pada kategori dan tags
function setupSearchEnter(type) {
    const searchInput = document.getElementById(type + '-search');
    const items = document.querySelectorAll('.' + type + '-item');
    const noResults = document.getElementById(type + '-no-results');

    if (!searchInput) return;

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            // Cari item pertama yang terlihat (display != none)
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

            // Jika ada checkbox yang terlihat, toggle statusnya
            if (firstVisibleItem) {
                firstVisibleItem.checked = !firstVisibleItem.checked;
                
                // Trigger event change untuk update badge
                const event = new Event('change');
                firstVisibleItem.dispatchEvent(event);
                
                // Beri feedback visual
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

document.addEventListener('DOMContentLoaded', function() {
    // PERBAIKAN: Set nilai deleted-temp-images dari old() saat halaman pertama kali dimuat
    const deletedTempImages = '<?= old("deleted_temp_images", "") ?>';
    if (deletedTempImages) {
        document.getElementById('deleted-temp-images').value = deletedTempImages;
    }
    
    // PERBAIKAN: Juga cek session storage untuk backup
    if (typeof(Storage) !== "undefined") {
        const sessionDeleted = JSON.parse(sessionStorage.getItem('deleted_temp_images') || '[]');
        if (sessionDeleted.length > 0) {
            const currentDeleted = document.getElementById('deleted-temp-images').value;
            const currentArray = currentDeleted ? currentDeleted.split(',') : [];
            const combinedArray = [...new Set([...currentArray, ...sessionDeleted])].filter(item => item.trim() !== '');
            document.getElementById('deleted-temp-images').value = combinedArray.join(',');
        }
    }

    // 1. Init Quill Editors
    var quill1 = new Quill('#editor-content', {
        theme: 'snow',
        modules: { toolbar: '#toolbar-content' }
    });

    var quill2 = new Quill('#editor-content2', {
        theme: 'snow',
        modules: { toolbar: '#toolbar-content2' }
    });

    var oldContent1 = <?= json_encode($oldContent1) ?>;
    if (oldContent1) quill1.root.innerHTML = oldContent1;

    var oldContent2 = <?= json_encode($oldContent2) ?>;
    if (oldContent2) quill2.root.innerHTML = oldContent2;

    document.getElementById('form-berita').onsubmit = function() {
        document.getElementById('content-hidden').value = quill1.root.innerHTML;
        document.getElementById('content2-hidden').value = quill2.root.innerHTML;
        
        // PERBAIKAN: Pastikan deleted_temp_images di-submit
        console.log('Submitting deleted_temp_images:', document.getElementById('deleted-temp-images').value);
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
    updateToggleState();

    // 5. Check Initial Dependency State
    const sisipan1Val = document.getElementById('sisipan1-input').value;
    const sisipan2Btn = document.getElementById('sisipan2-btn');
    if (sisipan1Val) {
        sisipan2Btn.removeAttribute('disabled');
    }

    // 6. Kategori & Tags Dropdown Logic dengan ENTER support
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

        // Setup ENTER key functionality
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

    // 7. Image Previews
    document.getElementById('cover-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cover-preview').innerHTML = `
                    <img src="${e.target.result}" class="preview-img" alt="Preview Cover">
                `;
            }
            reader.readAsDataURL(file);
        }
    });

    // 8. Image Previews - Additional Images
    document.getElementById('additional-images').addEventListener('change', function(e) {
        const container = document.getElementById('additional-preview-new');
        container.innerHTML = '';
        
        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const div = document.createElement('div');
                div.className = 'position-relative';
                div.id = 'additional-preview-' + index;
                div.innerHTML = `
                    <img src="${ev.target.result}" class="img-fluid rounded">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" 
                        onclick="deleteAdditionalPreview(${index})">
                        <i class="bi bi-x"></i>
                    </button>
                    <input type="text" name="caption_new[]" class="form-control form-control-sm mt-1" placeholder="Caption...">
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });
});
</script>
<?= $this->endSection() ?>