<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<?= $this->include('layouts/alerts') ?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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

    .old-additional-img {
    position: relative;
    width: 130px;
    height: 130px;
    overflow: hidden;
    border-radius: 8px;
}

.old-additional-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}

.old-additional-badge {
    position: absolute;
    bottom: 6px;
    left: 6px;
    background: var(--primary);
    color: #fff;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
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

    /* Form Card */
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

    /* Form Controls */
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

    /* Dropdown Kategori dengan Pencarian */
    #kategori-toggle {
        cursor: pointer;
        font-size: 0.9375rem;
        color: var(--gray-700);
    }
    #kategori-toggle:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }
    .kategori-list .form-check {
        cursor: pointer;
        border-radius: 6px;
        margin: 2px 0;
    }
    .kategori-list .form-check:hover {
        background-color: var(--gray-50);
    }
    .kategori-list .form-check-label {
        font-size: 0.9375rem;
        user-select: none;
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
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .selected-badge i {
        margin-left: 6px;
        font-size: 0.75rem;
        cursor: pointer;
        opacity: 0.8;
    }
    .selected-badge i:hover {
        opacity: 1;
        color: rgba(255,255,255,0.9);
    }
    .kategori-item {
        display: flex;
        align-items: center;
    }
    .kategori-no-results {
        font-size: 0.875rem;
    }

    /* Image Preview */
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

    .preview-img:hover {
        border-color: var(--primary);
        transform: scale(1.02);
    }

    /* Quill Editor */
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

    .ql-editor.ql-blank::before {
        color: var(--gray-400);
        font-style: normal;
    }

    /* Action Buttons */
    .action-buttons {
        padding-top: 24px;
        border-top: 2px solid var(--gray-200);
        margin-top: 32px;
    }

    .btn {
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9375rem;
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

    .btn i {
        margin-right: 6px;
    }

    /* Helper Text */
    .form-text,
    small.text-muted {
        color: var(--gray-500);
        font-size: 0.8125rem;
        margin-top: 6px;
        display: block;
    }

    .delete-old-image {
    position: absolute;
    top: 6px;
    right: 6px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    border: none;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}

.delete-old-image:hover {
    background: var(--danger);
}


    /* Section Spacing */
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

    /* Responsive */
    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .gov-header {
            padding: 20px;
        }

        .gov-header h1 {
            font-size: 1.375rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            margin: 4px 0 !important;
        }
    }

    /* Additional Images Grid */
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

    /* Current Image Display */
    .current-image-wrapper {
        position: relative;
        display: inline-block;
    }

    .current-image-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: var(--success);
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <h1>
        <i class="bi bi-pencil-square"></i>
        Edit Berita
    </h1>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Form Card -->
<div class="form-card">
    <form action="<?= site_url('berita/'.$berita['id_berita'].'/update') ?>" method="post" enctype="multipart/form-data" id="form-berita">
        <?= csrf_field() ?>

        <!-- SECTION: Informasi Dasar -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-info-circle"></i>
                Informasi Dasar
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" required 
                       placeholder="Masukkan judul berita yang menarik" 
                       value="<?= esc(old('judul', $berita['judul'])) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Topik</label>
                <input type="text" name="topik" class="form-control" 
                       placeholder="Masukkan topik berita" 
                       value="<?= esc(old('topik', $berita['topik'])) ?>">
                <small class="text-muted">Topik utama dari berita ini</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Intro Singkat</label>
                <textarea name="intro" class="form-control" rows="3" 
                          placeholder="Deskripsi singkat yang menarik pembaca"><?= esc(old('intro', $berita['intro'])) ?></textarea>
                <small class="text-muted">Ringkasan singkat yang akan ditampilkan di preview berita</small>
            </div>
        </div>

        <!-- SECTION: Konten Berita -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-file-text"></i>
                Konten Berita
            </div>

            <div class="mb-4">
                <label class="form-label">Isi Berita <span class="text-danger">*</span></label>
                <div id="toolbar-content" class="ql-toolbar-custom">
                    <button class="ql-bold" title="Bold"></button>
                    <button class="ql-italic" title="Italic"></button>
                    <button class="ql-underline" title="Underline"></button>
                    <button class="ql-strike" title="Strike"></button>
                    <select class="ql-header">
                        <option value="1">Heading 1</option>
                        <option value="2">Heading 2</option>
                        <option value="3">Heading 3</option>
                        <option selected>Normal</option>
                    </select>
                    <select class="ql-size">
                        <option value="small">Small</option>
                        <option selected>Normal</option>
                        <option value="large">Large</option>
                        <option value="huge">Huge</option>
                    </select>
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                    <button class="ql-list" value="ordered" title="Ordered List"></button>
                    <button class="ql-list" value="bullet" title="Bullet List"></button>
                    <button class="ql-align" value="" title="Left Align"></button>
                    <button class="ql-align" value="center" title="Center"></button>
                    <button class="ql-align" value="right" title="Right Align"></button>
                    <button class="ql-align" value="justify" title="Justify"></button>
                    <button class="ql-link" title="Insert Link"></button>
                    <button class="ql-image" title="Insert Image"></button>
                    <button class="ql-clean" title="Clear Formatting"></button>
                </div>
                <div id="editor-content" class="ql-container ql-snow">
                    <div class="ql-editor" data-placeholder="Tulis isi berita di sini..."><?= old('content', $berita['content']) ?></div>
                </div>
                <textarea name="content" id="content-hidden" style="display:none;"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Berita 2 <span class="text-danger">*</span></label>
                <div id="toolbar-content2" class="ql-toolbar-custom">
                    <button class="ql-bold" title="Bold"></button>
                    <button class="ql-italic" title="Italic"></button>
                    <button class="ql-underline" title="Underline"></button>
                    <button class="ql-strike" title="Strike"></button>
                    <select class="ql-header">
                        <option value="1">Heading 1</option>
                        <option value="2">Heading 2</option>
                        <option value="3">Heading 3</option>
                        <option selected>Normal</option>
                    </select>
                    <select class="ql-size">
                        <option value="small">Small</option>
                        <option selected>Normal</option>
                        <option value="large">Large</option>
                        <option value="huge">Huge</option>
                    </select>
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                    <button class="ql-list" value="ordered" title="Ordered List"></button>
                    <button class="ql-list" value="bullet" title="Bullet List"></button>
                    <button class="ql-align" value="" title="Left Align"></button>
                    <button class="ql-align" value="center" title="Center"></button>
                    <button class="ql-align" value="right" title="Right Align"></button>
                    <button class="ql-align" value="justify" title="Justify"></button>
                    <button class="ql-link" title="Insert Link"></button>
                    <button class="ql-image" title="Insert Image"></button>
                    <button class="ql-clean" title="Clear Formatting"></button>
                </div>
                <div id="editor-content2" class="ql-container ql-snow">
                    <div class="ql-editor" data-placeholder="Tulis isi berita bagian kedua di sini..."><?= old('content2', $berita['content2']) ?></div>
                </div>
                <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>
            </div>
        </div>

        <!-- SECTION: Kategori & Klasifikasi -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-tags"></i>
                Kategori & Klasifikasi
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <div class="dropdown" id="kategori-dropdown">
                    <button type="button" class="form-select text-start d-flex align-items-center pe-3" 
                            id="kategori-toggle" aria-haspopup="true" aria-expanded="false">
                        <span id="kategori-placeholder">Pilih minimal 1 kategori</span>
                        <i class="ms-auto bi bi-chevron-down text-gray-500"></i>
                    </button>
                    <div class="dropdown-menu w-100 p-0 shadow border" 
                         style="max-height: 320px; overflow: hidden; z-index: 1000;">
                        <!-- Search Box -->
                        <div class="px-3 py-2 border-bottom">
                            <div class="input-group">
                                <span class="input-group-text bg-gray-100 border-gray-300">
                                    <i class="bi bi-search text-gray-500"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-gray-300" 
                                       id="kategori-search" 
                                       placeholder="Cari kategori..."
                                       autocomplete="off">
                            </div>
                        </div>
                        <!-- Scrollable List -->
                        <div class="kategori-list px-2 py-1" style="max-height: 240px; overflow-y: auto;">
                            <?php 
                            $oldKategori = old('id_kategori');
                            if (!empty($oldKategori) && !is_array($oldKategori)) {
                                $oldKategori = explode(',', $oldKategori);
                            }
                            $selected = !empty($oldKategori) ? $oldKategori : ($selected ?? []);
                            
                            foreach ($kategori as $kat): 
                            ?>
                            <div class="form-check ps-3 py-1 kategori-item" 
                                 data-name="<?= esc(strtolower($kat['kategori'])) ?>">
                                <input class="form-check-input kategori-checkbox" 
                                       type="checkbox" 
                                       id="kat-<?= $kat['id_kategori'] ?>" 
                                       value="<?= $kat['id_kategori'] ?>"
                                       <?= in_array($kat['id_kategori'], $selected) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="kat-<?= $kat['id_kategori'] ?>">
                                    <?= esc($kat['kategori']) ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div id="kategori-no-results" class="px-3 py-2 text-center text-gray-500" style="display: none;">
                            <small>Tidak ada kategori yang cocok</small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_kategori" id="kategori-hidden" 
                       value="<?= is_array($selected) ? implode(',', $selected) : $selected ?>">
                <div id="selected-kategori-badges" class="mt-2 d-flex flex-wrap"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Sub Kategori</label>
                <input type="text" name="id_sub_kategori" class="form-control" 
                       placeholder="Sub kategori (opsional)" 
                       value="<?= esc(old('id_sub_kategori', $berita['id_sub_kategori'])) ?>">
            </div>
        </div>

        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-images"></i>
                Media & Gambar
            </div>

            <!-- COVER IMAGE dengan Support Temporary -->
            <div class="mb-4">
                <label class="form-label">Foto Cover (Utama)</label>
                
                <?php if(!empty($berita['feat_image']) || !empty($tempCoverImage)): ?>
                    <div class="preview-container">
                        <div class="current-image-wrapper">
                            <?php if(!empty($tempCoverImage)): ?>
                                <span class="current-image-badge" style="background: var(--info);">
                                    <i class="bi bi-clock-history me-1"></i>Gambar Temporary
                                </span>
                                <img src="<?= base_url('uploads/temp/' . $tempCoverImage) ?>" 
                                     class="preview-img" 
                                     alt="Temporary Cover">
                            <?php else: ?>
                                <span class="current-image-badge">
                                    <i class="bi bi-check-circle me-1"></i>Gambar Saat Ini
                                </span>
                                <img src="<?= base_url($berita['feat_image']) ?>" 
                                     class="preview-img" 
                                     alt="Current Cover">
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <input type="file" name="feat_image" class="form-control" accept="image/*" id="cover-image">
                <small class="text-muted">Upload gambar baru untuk mengganti yang lama. Format: JPG, PNG, GIF (Maksimal 2MB)</small>
                
                <?php if (!empty($tempCoverImage)): ?>
                    <div class="retained-image-info">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong>Gambar temporary tersimpan.</strong> Upload gambar baru jika ingin menggantinya.
                    </div>
                <?php endif; ?>
                
                <div id="cover-preview" class="preview-container"></div>
            </div>

            <!-- ADDITIONAL IMAGES dengan Support Temporary -->
            <div class="mb-4">
                <label class="form-label">Foto Tambahan</label>
                <!-- FOTO TAMBAHAN LAMA (Sebelumnya) -->
<?php 
$oldAdditional = !empty($berita['additional_images']) 
    ? json_decode($berita['additional_images'], true) 
    : [];
?>

<?php if (!empty($oldAdditional)): ?>
    <label class="form-label mb-2">Foto Tambahan Sebelumnya</label>
    <div class="additional-preview mb-3">
        <?php foreach ($oldAdditional as $img): ?>

            <?php 
            // CEK apakah file benar-benar masih ada di folder
            $filePath = FCPATH . ltrim($img, '/');
            if (!file_exists($filePath)) {
                continue; // lewati gambar rusak
            }
            ?>

            <div class="old-additional-img position-relative">
                <img src="<?= base_url($img) ?>" alt="Old Additional">

                <!-- TOMBOL X -->
                <button type="button" 
                        class="delete-old-image" 
                        data-image="<?= $img ?>">
                    ✕
                </button>

                <span class="old-additional-badge">Lama</span>
            </div>

        <?php endforeach; ?>
    </div>
<?php endif; ?>


                <?php if (!empty($tempAdditionalImages) && is_array($tempAdditionalImages)): ?>
                    <div class="additional-preview" id="temp-additional-images">
                        <?php foreach ($tempAdditionalImages as $tempImage): ?>
                            <div class="position-relative">
                                <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" alt="Preview">
                                <div class="temp-image-badge position-absolute top-0 end-0 m-1">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <input type="file" 
                       name="additional_images[]" 
                       class="form-control" 
                       accept="image/*" 
                       id="additional-images" 
                       multiple>
                <small class="text-muted">Pilih beberapa foto sekaligus (maksimal 5 foto, @2MB)</small>
                
                <?php if (!empty($tempAdditionalImages)): ?>
                    <div class="retained-image-info">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong><?= count($tempAdditionalImages) ?> gambar tambahan tersimpan.</strong> Upload gambar baru untuk menambah atau mengganti.
                    </div>
                <?php endif; ?>
                
                <div id="additional-preview" class="additional-preview"></div>
            </div>


            <div class="mb-3">
                <label class="form-label">Caption Gambar</label>
                <textarea name="caption" class="form-control" rows="2" 
                          placeholder="Keterangan untuk gambar"><?= esc(old('caption', $berita['caption'])) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Link Video</label>
                <input type="text" name="link_video" class="form-control" 
                       placeholder="https://youtube.com/watch?v=..." 
                       value="<?= esc(old('link_video', $berita['link_video'])) ?>">
                <small class="text-muted">Link video YouTube atau platform video lainnya</small>
            </div>
        </div>

        <!-- SECTION: Berita Terkait -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-link-45deg"></i>
                Berita Terkait & Referensi
            </div>

            <div class="mb-3">
                <label class="form-label">Berita Terkait 1</label>
                <select name="id_berita_terkait" class="form-select">
                    <option value="">-- Pilih Berita Terkait --</option>
                    <?php foreach ($beritaAll as $b): ?>
                        <option value="<?= $b['id_berita'] ?>" 
                                <?= $b['id_berita'] == old('id_berita_terkait', $berita['id_berita_terkait']) ? 'selected' : '' ?>>
                            <?= esc($b['judul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Berita Terkait 2</label>
                <select name="id_berita_terkait2" class="form-select">
                    <option value="">-- Pilih Berita Terkait --</option>
                    <?php foreach ($beritaAll as $b): ?>
                        <option value="<?= $b['id_berita'] ?>" 
                                <?= $b['id_berita'] == old('id_berita_terkait2', $berita['id_berita_terkait2']) ? 'selected' : '' ?>>
                            <?= esc($b['judul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber Berita</label>
                <input type="text" name="sumber" class="form-control" 
                       placeholder="Contoh: Kompas.com, Detik, Internal" 
                       value="<?= esc(old('sumber', $berita['sumber'])) ?>">
                <small class="text-muted">Sumber atau referensi berita</small>
            </div>
        </div>

        <!-- SECTION: Status & Catatan -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-gear"></i>
                Status & Catatan Admin
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status Tayang</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= old('status', $berita['status']) == '1' ? 'selected' : '' ?>>🟢 Tayang</option>
                        <option value="5" <?= old('status', $berita['status']) == '5' ? 'selected' : '' ?>>🔴 Tidak Tayang</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status Berita</label>
                    <select name="status_berita" class="form-select">
                        <option value="0" <?= old('status_berita', $berita['status_berita']) == '0' ? 'selected' : '' ?>>📝 Draft</option>
                        <option value="2" <?= old('status_berita', $berita['status_berita']) == '2' ? 'selected' : '' ?>>⏳ Menunggu Verifikasi</option>
                        <option value="3" <?= old('status_berita', $berita['status_berita']) == '3' ? 'selected' : '' ?>>❌ Ditolak</option>
                        <option value="4" <?= old('status_berita', $berita['status_berita']) == '4' ? 'selected' : '' ?>>✅ Layak Tayang</option>
                        <option value="6" <?= old('status_berita', $berita['status_berita']) == '6' ? 'selected' : '' ?>>🔄 Revisi</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan Admin</label>
                <textarea name="note" class="form-control" rows="3" 
                          placeholder="Catatan internal untuk admin"><?= esc(old('note', $berita['note'])) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Note Revisi</label>
                <textarea name="note_revisi" class="form-control" rows="3" 
                          placeholder="Catatan revisi atau feedback"><?= esc(old('note_revisi', $berita['note_revisi'])) ?></textarea>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Berita
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill Editors
    const quillContent = new Quill('#editor-content .ql-editor', {
        modules: {
            toolbar: '#toolbar-content'
        },
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...'
    });

    const quillContent2 = new Quill('#editor-content2 .ql-editor', {
        modules: {
            toolbar: '#toolbar-content2'
        },
        theme: 'snow',
        placeholder: 'Tulis isi berita bagian kedua di sini...'
    });

document.querySelectorAll('.delete-old-image').forEach(btn => {
    btn.addEventListener('click', function() {
        let img = this.getAttribute('data-image');

        // buat input hidden agar controller tau gambar mana yang dihapus
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_old_images[]';
        input.value = img;
        document.getElementById('form-berita').appendChild(input);

        // sembunyikan preview gambarnya
        this.parentElement.remove();
    });
});

    // Update hidden textareas before form submit
    const form = document.getElementById('form-berita');
    form.addEventListener('submit', function(e) {
        const content1 = quillContent.root.innerHTML.trim();
        const content2 = quillContent2.root.innerHTML.trim();
        
        const isEmpty1 = content1 === '<p><br></p>' || content1 === '' || quillContent.getText().trim() === '';
        const isEmpty2 = content2 === '<p><br></p>' || content2 === '' || quillContent2.getText().trim() === '';
        
        if (isEmpty1) {
            e.preventDefault();
            alert('Isi Berita tidak boleh kosong!');
            quillContent.focus();
            return false;
        }
        
        if (isEmpty2) {
            e.preventDefault();
            alert('Isi Berita 2 tidak boleh kosong!');
            quillContent2.focus();
            return false;
        }
        
        document.getElementById('content-hidden').value = content1;
        document.getElementById('content2-hidden').value = content2;
    });

    // Dropdown Kategori dengan Pencarian & Multi-Select
    const toggleBtn = document.getElementById('kategori-toggle');
    const dropdownMenu = toggleBtn.nextElementSibling;
    const searchInput = document.getElementById('kategori-search');
    const kategoriItems = Array.from(document.querySelectorAll('.kategori-item'));
    const checkboxes = document.querySelectorAll('.kategori-checkbox');
    const hiddenInput = document.getElementById('kategori-hidden');
    const placeholder = document.getElementById('kategori-placeholder');
    const badgesContainer = document.getElementById('selected-kategori-badges');
    const noResultsEl = document.getElementById('kategori-no-results');

    // Map ID → Nama
    const kategoriMap = {};
    checkboxes.forEach(cb => {
        const item = cb.closest('.kategori-item');
        const label = item.querySelector('.form-check-label');
        kategoriMap[cb.value] = label.textContent.trim();
    });

    // Update tampilan berdasarkan pilihan
    function updateUI() {
        const selected = Array.from(checkboxes).filter(cb => cb.checked);
        const ids = selected.map(cb => cb.value);
        const names = selected.map(cb => kategoriMap[cb.value]);

        // Simpan ke hidden input
        hiddenInput.value = ids.join(',');

        // Update placeholder
        if (names.length === 0) {
            placeholder.textContent = 'Pilih minimal 1 kategori';
            placeholder.classList.add('text-gray-500');
            placeholder.classList.remove('text-gray-700');
        } else {
            placeholder.textContent = names.length + ' kategori dipilih';
            placeholder.classList.remove('text-gray-500');
            placeholder.classList.add('text-gray-700');
        }

        // Render badges
        badgesContainer.innerHTML = names.map((name, idx) => {
            const cbValue = ids[idx];
            return `<span class="selected-badge">
                ${name}
                <i class="bi bi-x-circle-fill" data-cb-value="${cbValue}" title="Hapus"></i>
            </span>`;
        }).join('');

        // Event hapus badge
        badgesContainer.querySelectorAll('.bi-x-circle-fill').forEach(icon => {
            icon.addEventListener('click', function() {
                const cbValue = this.getAttribute('data-cb-value');
                const cb = document.querySelector(`input[value="${cbValue}"]`);
                if (cb) {
                    cb.checked = false;
                    updateUI();
                }
            });
        });
    }

    // Filter kategori berdasarkan input pencarian
    function filterKategori() {
        const query = searchInput.value.trim().toLowerCase();
        let hasVisible = false;

        kategoriItems.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            const match = name.includes(query);
            item.style.display = match ? 'flex' : 'none';
            if (match) hasVisible = true;
        });

        noResultsEl.style.display = hasVisible ? 'none' : 'block';
    }

    // Toggle dropdown
    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        toggleBtn.setAttribute('aria-expanded', !isExpanded);
        dropdownMenu.classList.toggle('show', !isExpanded);
        if (!isExpanded) {
            setTimeout(() => searchInput.focus(), 50);
        }
    });

    // Tutup dropdown saat klik luar
    document.addEventListener('click', function(e) {
        if (!toggleBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            toggleBtn.setAttribute('aria-expanded', 'false');
            dropdownMenu.classList.remove('show');
        }
    });

    // Event: checkbox berubah
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateUI);
    });

    // Event: ketik di search
    searchInput.addEventListener('input', filterKategori);

    // Reset pencarian saat dropdown ditutup
    const observer = new MutationObserver(() => {
        if (!dropdownMenu.classList.contains('show')) {
            searchInput.value = '';
            filterKategori();
        }
    });
    observer.observe(dropdownMenu, { attributes: true, attributeFilter: ['class'] });

// ========================================================
// PREVIEW COVER IMAGE dengan Temporary Support
// ========================================================
const coverInput = document.getElementById('cover-image');
const coverPreview = document.getElementById('cover-preview');

// Tampilkan gambar temporary dari session jika ada
<?php if (!empty($tempCoverImage)): ?>
    coverPreview.innerHTML = `
        <div class="position-relative d-inline-block mt-3">
            <img src="<?= base_url('uploads/temp/' . $tempCoverImage) ?>" 
                 class="preview-img"
                 alt="Preview Cover">
            <div class="temp-image-badge">
                <i class="bi bi-clock-history"></i> Gambar Sebelumnya
            </div>
        </div>
    `;
<?php endif; ?>

coverInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
            coverPreview.innerHTML = `
                <div class="mt-3">
                    <img src="${evt.target.result}" class="preview-img" alt="Preview">
                </div>
            `;
        }
        reader.readAsDataURL(file);
    } else {
        <?php if (!empty($tempCoverImage)): ?>
            coverPreview.innerHTML = `
                <div class="position-relative d-inline-block mt-3">
                    <img src="<?= base_url('uploads/temp/' . $tempCoverImage) ?>" 
                         class="preview-img"
                         alt="Preview Cover">
                    <div class="temp-image-badge">
                        <i class="bi bi-clock-history"></i> Gambar Sebelumnya
                    </div>
                </div>
            `;
        <?php endif; ?>
    }
});

// ========================================================
// PREVIEW ADDITIONAL IMAGES dengan Temporary Support
// ========================================================
const additionalInput = document.getElementById('additional-images');
const additionalPreview = document.getElementById('additional-preview');

<?php if (!empty($tempAdditionalImages) && is_array($tempAdditionalImages)): ?>
    additionalPreview.innerHTML = '';
    <?php foreach ($tempAdditionalImages as $tempImage): ?>
        const tempDiv<?= md5($tempImage) ?> = document.createElement('div');
        tempDiv<?= md5($tempImage) ?>.className = 'position-relative';
        tempDiv<?= md5($tempImage) ?>.innerHTML = `
            <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" alt="Preview">
            <div class="temp-image-badge position-absolute top-0 end-0 m-1">
                <i class="bi bi-clock-history"></i>
            </div>
        `;
        additionalPreview.appendChild(tempDiv<?= md5($tempImage) ?>);
    <?php endforeach; ?>
<?php endif; ?>

additionalInput.addEventListener('change', function(e) {
    if (e.target.files.length === 0) {
        additionalPreview.innerHTML = '';
        <?php if (!empty($tempAdditionalImages) && is_array($tempAdditionalImages)): ?>
            <?php foreach ($tempAdditionalImages as $tempImage): ?>
                const tempDiv<?= md5($tempImage) ?> = document.createElement('div');
                tempDiv<?= md5($tempImage) ?>.className = 'position-relative';
                tempDiv<?= md5($tempImage) ?>.innerHTML = `
                    <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" alt="Preview">
                    <div class="temp-image-badge position-absolute top-0 end-0 m-1">
                        <i class="bi bi-clock-history"></i>
                    </div>
                `;
                additionalPreview.appendChild(tempDiv<?= md5($tempImage) ?>);
            <?php endforeach; ?>
        <?php endif; ?>
    } else {
        additionalPreview.innerHTML = '';
        Array.from(e.target.files).slice(0, 5).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'position-relative';
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview';
                div.appendChild(img);
                additionalPreview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
});

    // Inisialisasi UI kategori saat pertama load
    updateUI();
});
</script>

<?= $this->endSection() ?>