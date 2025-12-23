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

    /* --- SISIPAN BOX STYLE --- */
    .sisipan-box {
        background: #eff6ff;
        border: 1px dashed #3b82f6;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
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
                <label class="form-label">Topik</label>
                <input type="text" name="topik" class="form-control" placeholder="Topik berita" value="<?= esc(old('topik', $berita['topik'])) ?>">
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
                <div id="editor-content" class="ql-container ql-snow">
                    <div class="ql-editor"><?= old('content', $berita['content']) ?></div>
                </div>
                <textarea name="content" id="content-hidden" style="display:none;"></textarea>

                <div class="sisipan-box">
                    <label class="form-label d-flex align-items-center">
                        <i class="bi bi-paperclip me-2"></i> Berita Sisipan 1 (Baca Juga)
                    </label>
                    <select name="id_berita_terkait" class="form-select">
                        <option value="">-- Pilih Berita Sisipan --</option>
                        <?php foreach ($beritaAll as $b): ?>
                            <option value="<?= $b['id_berita'] ?>" 
                                    <?= $b['id_berita'] == old('id_berita_terkait', $berita['id_berita_terkait']) ? 'selected' : '' ?>>
                                <?= esc($b['judul']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Berita ini akan muncul disisipkan setelah paragraf akhir Berita 1.</small>
                </div>
            </div>

            <?php 
                // Cek apakah konten 2 sebelumnya ada isinya (dari DB atau old input)
                $hasContent2 = !empty($berita['content2']) || old('has_content2') == '1'; 
            ?>

            <div class="d-flex align-items-center mb-3 mt-5 p-3 bg-gray-50 border rounded">
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="toggle-content2" 
                           <?= $hasContent2 ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold" for="toggle-content2">Edit/Tambah Halaman Kedua (Isi Berita 2)</label>
                </div>
                <input type="hidden" name="has_content2" id="has-content2-val" value="<?= $hasContent2 ? '1' : '0' ?>">
            </div>

            <div id="wrapper-content2" style="display: <?= $hasContent2 ? 'block' : 'none' ?>;">
                <div class="mb-4 ps-3 border-start border-3 border-info">
                    <label class="form-label">Isi Berita 2</label>
                    <div id="toolbar-content2" class="ql-toolbar-custom">
                         <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button>
                    </div>
                    <div id="editor-content2" class="ql-container ql-snow">
                        <div class="ql-editor"><?= old('content2', $berita['content2']) ?></div>
                    </div>
                    <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>

                    <div class="sisipan-box mt-3">
                        <label class="form-label d-flex align-items-center">
                            <i class="bi bi-paperclip me-2"></i> Berita Sisipan 2 (Baca Juga)
                        </label>
                        <select name="id_berita_terkait2" class="form-select">
                            <option value="">-- Pilih Berita Sisipan --</option>
                            <?php foreach ($beritaAll as $b): ?>
                                <option value="<?= $b['id_berita'] ?>" 
                                        <?= $b['id_berita'] == old('id_berita_terkait2', $berita['id_berita_terkait2']) ? 'selected' : '' ?>>
                                    <?= esc($b['judul']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                         <small class="text-muted">Berita ini akan muncul disisipkan setelah paragraf akhir Berita 2.</small>
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
                                    <input class="form-check-input tags-checkbox" type="checkbox" 
                                           id="tag-<?= $tag['id_tags'] ?>" 
                                           value="<?= $tag['id_tags'] ?>"
                                           <?= in_array($tag['id_tags'], $selectedTags) ? 'checked' : '' ?>>
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
                <input type="hidden" name="id_tags" id="tags-hidden" value="<?= implode(',', $selectedTags) ?>">
                <div id="selected-tags-badges" class="mt-2 d-flex flex-wrap"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Kunci (SEO)</label>
                <textarea name="keyword" class="form-control" rows="2" placeholder="Pisahkan dengan koma"><?= old('keyword') ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Sub Kategori</label>
                <input type="text" name="id_sub_kategori" class="form-control" value="<?= esc(old('id_sub_kategori', $berita['id_sub_kategori'])) ?>">
            </div>
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
                    <label class="form-label small text-muted mb-2">Gambar Sebelumnya (Klik X untuk menghapus)</label>
                    <div class="additional-preview mb-3">
                        <?php foreach ($oldAdditional as $img): ?>
                            <?php 
                                $path = is_array($img) ? $img['path'] : $img;
                                $cap  = is_array($img) ? $img['caption'] : '';
                                $filePath = FCPATH . ltrim($path, '/');
                                if (!file_exists($filePath)) continue; 
                            ?>
                            <div class="old-image-card">
                                <span class="old-badge">Lama</span>
                                <button type="button" class="btn-delete-img delete-old-image" data-image="<?= $path ?>">✕</button>
                                <img src="<?= base_url($path) ?>" alt="Old Image">
                                <div class="card-body">
                                    <p class="text-muted small mb-0 text-truncate" title="<?= esc($cap) ?>">
                                        <?= !empty($cap) ? esc($cap) : '<i>-</i>' ?>
                                    </p>
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
                <label class="form-label">Link Video</label>
                <input type="text" name="link_video" class="form-control" value="<?= esc(old('link_video', $berita['link_video'])) ?>">
            </div>
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

        <div class="form-section">
            <div class="section-title"><i class="bi bi-gear"></i> Status & Catatan Admin</div>

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
                <textarea name="note" class="form-control" rows="3"><?= esc(old('note', $berita['note'])) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Note Revisi</label>
                <textarea name="note_revisi" class="form-control" rows="3"><?= esc(old('note_revisi', $berita['note_revisi'])) ?></textarea>
            </div>
        </div>

        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            <button type="submit" name="submit_type" value="draft" class="btn btn-warning text-white"><i class="bi bi-file-earmark-text"></i> Simpan Draft</button>
            <button type="submit" name="submit_type" value="publish" class="btn btn-primary"><i class="bi bi-send"></i> Publikasikan</button>
        </div>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ============================================================
    // 0. TOGGLE CONTENT 2 LOGIC
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

    toggleContent2.addEventListener('change', handleToggleContent2);
    // Initial Run (in case DB has value)
    handleToggleContent2();

    // ============================================================
    // 1. CONFIG QUILL EDITOR
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

    // Sync content saat form submit
    formBerita.addEventListener('submit', function() {
        contentHidden.value = quillContent.root.innerHTML;
        content2Hidden.value = quillContent2.root.innerHTML;
    });

    // ============================================================
    // 2. DELETE OLD IMAGE (DATABASE)
    // ============================================================
    document.querySelectorAll('.delete-old-image').forEach(btn => {
        btn.addEventListener('click', function() {
            let imgPath = this.getAttribute('data-image');
            
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_old_images[]';
            input.value = imgPath;
            document.getElementById('form-berita').appendChild(input);

            this.closest('.old-image-card').remove();
        });
    });

    // ============================================================
    // 3. PREVIEW & DELETE NEW IMAGES (DATATRANSFER)
    // ============================================================
    const additionalInput = document.getElementById('additional-images');
    const additionalPreviewNew = document.getElementById('additional-preview-new');
    let dt = new DataTransfer();

    additionalInput.addEventListener('change', function(e) {
        dt = new DataTransfer();
        for (let i = 0; i < this.files.length; i++) {
            dt.items.add(this.files[i]);
        }
        renderNewPreviews();
    });

    function renderNewPreviews() {
        additionalPreviewNew.innerHTML = '';

        Array.from(dt.files).forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(evt) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';

                col.innerHTML = `
                    <div class="card h-100 border-gray-200 shadow-sm position-relative">
                        <button type="button" class="btn-delete-img remove-new-image" data-index="${index}" title="Hapus">✕</button>
                        <img src="${evt.target.result}" class="card-img-top" style="height: 120px; object-fit: cover;">
                        <div class="card-body p-2 bg-light">
                            <label class="form-label text-muted small mb-1">Caption:</label>
                            <input type="text" name="caption_additional[]" class="form-control form-control-sm" placeholder="Ket. foto...">
                        </div>
                    </div>
                `;
                additionalPreviewNew.appendChild(col);

                col.querySelector('.remove-new-image').addEventListener('click', function() {
                    removeFile(index);
                });
            }
            reader.readAsDataURL(file);
        });
    }

    function removeFile(indexToRemove) {
        const newDt = new DataTransfer();
        Array.from(dt.files).forEach((file, i) => {
            if (i !== indexToRemove) {
                newDt.items.add(file);
            }
        });
        dt = newDt;
        additionalInput.files = dt.files;
        renderNewPreviews();
    }

    // ============================================================
    // 4. PREVIEW COVER BARU
    // ============================================================
    const coverInput = document.getElementById('cover-image');
    const newCoverPreview = document.getElementById('new-cover-preview');

    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                newCoverPreview.innerHTML = `
                    <div class="position-relative d-inline-block">
                        <img src="${evt.target.result}" class="preview-img" style="border: 2px solid var(--success);">
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Akan Diganti</span>
                    </div>
                `;
            }
            reader.readAsDataURL(file);
        }
    });

    // ============================================================
    // 5. DROPDOWN KATEGORI & TAGS
    // ============================================================
    function setupDropdown(type) {
        const toggleBtn = document.getElementById(type + '-toggle');
        const dropdownMenu = toggleBtn.nextElementSibling;
        const searchInput = document.getElementById(type + '-search');
        const items = Array.from(document.querySelectorAll('.' + type + '-item'));
        const checkboxes = document.querySelectorAll('.' + type + '-checkbox');
        const hiddenInput = document.getElementById(type + '-hidden');
        const placeholder = document.getElementById(type + '-placeholder');
        const badgeContainer = document.getElementById('selected-' + type + '-badges');
        const noResults = document.getElementById(type + '-no-results');

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const isShown = dropdownMenu.classList.contains('show');
            dropdownMenu.classList.toggle('show', !isShown);
            if (!isShown) setTimeout(() => searchInput.focus(), 100);
        });

        document.addEventListener('click', (e) => {
            if (!toggleBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });

        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            let hasVisible = false;
            items.forEach(item => {
                const text = item.getAttribute('data-name');
                if (text.includes(term)) { item.style.display = 'flex'; hasVisible = true; } 
                else { item.style.display = 'none'; }
            });
            noResults.style.display = hasVisible ? 'none' : 'block';
        });

        function updateSelection() {
            const selectedIds = [];
            const selectedNames = [];
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    selectedIds.push(cb.value);
                    selectedNames.push(cb.nextElementSibling.innerText.trim());
                    cb.closest('.' + type + '-item').style.backgroundColor = '#eff6ff';
                } else {
                    cb.closest('.' + type + '-item').style.backgroundColor = '';
                }
            });
            hiddenInput.value = selectedIds.join(',');
            badgeContainer.innerHTML = '';
            selectedNames.forEach((name, idx) => {
                const badge = document.createElement('div');
                badge.className = 'selected-badge';
                badge.innerHTML = `<span>${name}</span><i class="bi bi-x ms-2 remove-badge" data-id="${selectedIds[idx]}"></i>`;
                badgeContainer.appendChild(badge);
            });
            
            badgeContainer.querySelectorAll('.remove-badge').forEach(icon => {
                icon.addEventListener('click', function() {
                    const idToRemove = this.getAttribute('data-id');
                    const cbToUncheck = document.getElementById((type === 'kategori' ? 'kat-' : 'tag-') + idToRemove);
                    if(cbToUncheck) { cbToUncheck.checked = false; updateSelection(); }
                });
            });

            if (selectedNames.length > 0) {
                placeholder.textContent = `${selectedNames.length} ${type === 'kategori' ? 'Kategori' : 'Tag'} Dipilih`;
                placeholder.classList.add('text-primary', 'fw-bold');
            } else {
                placeholder.textContent = type === 'kategori' ? 'Pilih minimal 1 kategori' : 'Pilih tags (opsional)';
                placeholder.classList.remove('text-primary', 'fw-bold');
            }
        }

        items.forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target !== this.querySelector('input')) {
                    const cb = this.querySelector('input');
                    cb.checked = !cb.checked;
                }
                updateSelection();
            });
        });
        
        updateSelection(); // Init
    }

    setupDropdown('kategori');
    setupDropdown('tags');

    // --- INIT FLATPICKR (TANGGAL & WAKTU) ---
    // minDate: "today" dihapus agar bisa pilih tanggal lampau
    flatpickr("#datetime-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        locale: "id",
        altInput: true,
        altFormat: "j F Y, H:i",
        defaultDate: "<?= old('tanggal', date('Y-m-d H:i', strtotime($berita['tanggal']))) ?>"
    });
});
</script>
<?= $this->endSection() ?>