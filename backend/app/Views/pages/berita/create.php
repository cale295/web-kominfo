<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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

    /* --- DROPDOWN KATEGORI --- */
    #kategori-toggle { cursor: pointer; font-size: 0.9375rem; color: var(--gray-700); }
    #kategori-toggle:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1); }
    .kategori-list .form-check { cursor: pointer; border-radius: 6px; margin: 2px 0; }
    .kategori-list .form-check:hover { background-color: var(--gray-50); }
    .kategori-list .form-check-label { font-size: 0.9375rem; user-select: none; }
    .selected-badge {
        display: inline-flex; align-items: center; background: var(--primary);
        color: white; padding: 4px 10px; border-radius: 6px; font-size: 0.8125rem;
        margin: 2px 6px 2px 0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .selected-badge i { margin-left: 6px; font-size: 0.75rem; cursor: pointer; opacity: 0.8; }
    .kategori-item { display: flex; align-items: center; }
    .kategori-no-results { font-size: 0.875rem; }

    /* --- IMAGE PREVIEW & TEMP --- */
    .preview-container { margin-top: 16px; }
    .preview-img {
        max-width: 200px; max-height: 200px; object-fit: cover;
        border-radius: 12px; border: 2px solid var(--gray-200);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); transition: all 0.2s;
    }
    .additional-preview {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px; margin-top: 16px;
    }
    .additional-preview img {
        width: 100%; height: 150px; object-fit: cover;
        border-radius: 8px; border: 2px solid var(--gray-200);
    }
    .retained-image-info {
        background-color: #e0f2fe; border-left: 4px solid #0284c7;
        padding: 12px 16px; border-radius: 8px; margin-top: 12px;
        font-size: 0.875rem; color: #0c4a6e; display: flex; align-items: center; gap: 8px;
    }
    .retained-image-info i { color: #0284c7; font-size: 1rem; }
    .temp-image-badge {
        display: inline-block; background: var(--info); color: white;
        padding: 4px 10px; border-radius: 6px; font-size: 0.75rem;
        margin-top: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .temp-image-badge i { margin-right: 4px; }

    /* --- TOMBOL HAPUS GAMBAR BARU (FITUR BARU) --- */
    .btn-delete-new-img {
        position: absolute; top: 5px; right: 5px;
        background: rgba(220, 38, 38, 0.9); color: white;
        border: none; width: 24px; height: 24px; border-radius: 50%;
        font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center;
        z-index: 10; transition: 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .btn-delete-new-img:hover { background: #dc2626; transform: scale(1.1); }
    .preview-card-wrapper { position: relative; }

    /* --- QUILL EDITOR --- */
    .ql-toolbar-custom { background: var(--gray-50); border: 1px solid var(--gray-300) !important; border-radius: 8px 8px 0 0; padding: 12px; }
    .ql-container { border: 1px solid var(--gray-300) !important; border-radius: 0 0 8px 8px; font-size: 0.9375rem; }
    .ql-editor { min-height: 250px; font-size: 0.9375rem; color: var(--gray-800); }
    
    /* --- ACTION BUTTONS --- */
    .action-buttons { padding-top: 24px; border-top: 2px solid var(--gray-200); margin-top: 32px; }
    .btn { padding: 12px 28px; border-radius: 8px; font-weight: 500; transition: all 0.2s; border: none; }
    .btn-primary { background: var(--primary); }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3); }
    .btn-secondary { background: var(--gray-600); }
    .btn-secondary:hover { background: var(--gray-700); transform: translateY(-2px); }
    .form-section { margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--gray-100); }
    .form-section:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    
    @media (max-width: 768px) {
        .form-card { padding: 20px; }
        .action-buttons { flex-direction: column; }
        .action-buttons .btn { width: 100%; margin: 4px 0 !important; }
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
                <label class="form-label">Topik</label>
                <input type="text" name="topik" class="form-control" placeholder="Masukkan topik berita" value="<?= old('topik') ?>">
                <small class="text-muted">Topik utama dari berita ini</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Intro Singkat</label>
                <textarea name="intro" class="form-control" rows="3" placeholder="Deskripsi singkat yang menarik pembaca"><?= old('intro') ?></textarea>
                <small class="text-muted">Ringkasan singkat yang akan ditampilkan di preview berita</small>
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-file-text"></i> Konten Berita</div>

            <div class="mb-4">
                <label class="form-label">Isi Berita <span class="text-danger">*</span></label>
                <div id="toolbar-content" class="ql-toolbar-custom">
                    <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button><button class="ql-strike"></button>
                    <select class="ql-header"><option value="1"></option><option value="2"></option><option value="3"></option><option selected></option></select>
                    <button class="ql-list" value="ordered"></button><button class="ql-list" value="bullet"></button>
                    <button class="ql-link"></button><button class="ql-image"></button><button class="ql-clean"></button>
                </div>
                <div id="editor-content" class="ql-container ql-snow">
                    <div class="ql-editor" data-placeholder="Tulis isi berita di sini..."></div>
                </div>
                <textarea name="content" id="content-hidden" style="display:none;"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Berita 2 (Opsional)</label>
                <div id="toolbar-content2" class="ql-toolbar-custom">
                    <button class="ql-bold"></button><button class="ql-italic"></button><button class="ql-underline"></button>
                </div>
                <div id="editor-content2" class="ql-container ql-snow">
                    <div class="ql-editor" data-placeholder="Tulis isi berita bagian kedua di sini..."></div>
                </div>
                <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>
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
                <label class="form-label">Sub Kategori</label>
                <input type="text" name="id_sub_kategori" class="form-control" placeholder="Sub kategori (opsional)" value="<?= old('id_sub_kategori') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Kunci (SEO)</label>
                <textarea name="keyword" class="form-control" rows="2" placeholder="Pisahkan dengan koma"><?= old('keyword') ?></textarea>
            </div>
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
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-info shadow-sm">
                                    <div class="position-relative">
                                        <img src="<?= base_url('uploads/temp/' . $tempImage) ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="temp-image-badge position-absolute top-0 end-0 m-1">
                                            <i class="bi bi-clock-history"></i> Temp
                                        </div>
                                    </div>
                                    <div class="card-body p-2 bg-light">
                                        <input type="text" name="caption_additional[]" class="form-control form-control-sm" 
                                               placeholder="Caption foto ini..." 
                                               value="<?= isset($oldCaptions[$index]) ? esc($oldCaptions[$index]) : '' ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="retained-image-info">
                        <i class="bi bi-info-circle-fill"></i> <strong>Gambar sebelumnya tersimpan sementara.</strong>
                    </div>
                <?php endif; ?>

                <div id="additional-preview-new" class="row mt-3"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Link Video</label>
                <input type="text" name="link_video" class="form-control" placeholder="https://youtube.com/watch?v=..." value="<?= old('link_video') ?>">
            </div>
        </div>

        <div class="form-section">
            <div class="section-title"><i class="bi bi-link-45deg"></i> Berita Terkait</div>
            
            <div class="mb-3">
                <label class="form-label">Berita Terkait 1</label>
                <select name="id_berita_terkait" class="form-select">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($beritaAll as $b): ?>
                        <option value="<?= $b['id_berita'] ?>" <?= old('id_berita_terkait') == $b['id_berita'] ? 'selected' : '' ?>>
                            <?= esc($b['judul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Berita Terkait 2</label>
                <select name="id_berita_terkait2" class="form-select">
                    <option value="">-- Pilih --</option>
                    <?php foreach ($beritaAll as $b): ?>
                        <option value="<?= $b['id_berita'] ?>" <?= old('id_berita_terkait2') == $b['id_berita'] ? 'selected' : '' ?>>
                            <?= esc($b['judul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber Berita</label>
                <input type="text" name="sumber" class="form-control" placeholder="Contoh: Kompas.com" value="<?= old('sumber') ?>">
            </div>
        </div>

        <input type="hidden" name="status" value="0">
        <input type="hidden" name="status_berita" value="2">

        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Berita</button>
        </div>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ============================================================
    // 1. CONFIG QUILL EDITOR
    // ============================================================
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

    // Load old content if validation failed
    const oldContent1 = <?= json_encode($oldContent1) ?>;
    const oldContent2 = <?= json_encode($oldContent2) ?>;

    if (oldContent1 && typeof oldContent1 === 'string') {
        quillContent.clipboard.dangerouslyPasteHTML(0, oldContent1);
    }
    if (oldContent2 && typeof oldContent2 === 'string') {
        quillContent2.clipboard.dangerouslyPasteHTML(0, oldContent2);
    }

    // ============================================================
    // 2. PREVIEW COVER IMAGE
    // ============================================================
    const coverInput = document.getElementById('cover-image');
    const coverPreview = document.getElementById('cover-preview');

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
        }
    });

    // ============================================================
    // 3. PREVIEW ADDITIONAL IMAGES + CAPTION + DELETE (DataTransfer)
    // ============================================================
    const additionalInput = document.getElementById('additional-images');
    const additionalPreviewNew = document.getElementById('additional-preview-new');
    
    // Variabel penampung file
    let dt = new DataTransfer(); 

    additionalInput.addEventListener('change', function(e) {
        // Reset setiap kali browse baru
        dt = new DataTransfer();
        for (let i = 0; i < this.files.length; i++) {
            dt.items.add(this.files[i]);
        }
        renderNewPreviews();
    });

    function renderNewPreviews() {
        additionalPreviewNew.innerHTML = ''; // Clear container

        Array.from(dt.files).forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(evt) {
                // Wrapper Column
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3 fade-in';

                col.innerHTML = `
                    <div class="card h-100 border-gray-200 shadow-sm preview-card-wrapper">
                        <button type="button" class="btn-delete-new-img" data-index="${index}" title="Hapus gambar ini">✕</button>
                        
                        <img src="${evt.target.result}" class="card-img-top" style="height: 120px; object-fit: cover;">
                        
                        <div class="card-body p-2 bg-light">
                            <label class="form-label text-muted small mb-1">Caption:</label>
                            <input type="text" 
                                   name="caption_additional[]" 
                                   class="form-control form-control-sm" 
                                   placeholder="Ket. foto...">
                        </div>
                    </div>
                `;
                additionalPreviewNew.appendChild(col);

                // Event Listener Hapus
                col.querySelector('.btn-delete-new-img').addEventListener('click', function() {
                    removeNewFile(index);
                });
            }
            reader.readAsDataURL(file);
        });
    }

    function removeNewFile(indexToRemove) {
        const newDt = new DataTransfer();
        // Salin semua kecuali yang dihapus
        Array.from(dt.files).forEach((file, i) => {
            if (i !== indexToRemove) {
                newDt.items.add(file);
            }
        });
        
        dt = newDt; // Update penampung
        additionalInput.files = dt.files; // Update input element
        renderNewPreviews(); // Render ulang
    }

    // ============================================================
    // 4. DROPDOWN KATEGORI
    // ============================================================
    const toggleBtn = document.getElementById('kategori-toggle');
    const dropdownMenu = toggleBtn.nextElementSibling;
    const searchInput = document.getElementById('kategori-search');
    const kategoriItems = Array.from(document.querySelectorAll('.kategori-item'));
    const checkboxes = document.querySelectorAll('.kategori-checkbox');
    const hiddenInput = document.getElementById('kategori-hidden');
    const placeholder = document.getElementById('kategori-placeholder');
    const badgeContainer = document.getElementById('selected-kategori-badges');
    const noResults = document.getElementById('kategori-no-results');

    // Toggle
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const isShown = dropdownMenu.classList.contains('show');
        dropdownMenu.classList.toggle('show', !isShown);
        toggleBtn.setAttribute('aria-expanded', !isShown);
        if (!isShown) setTimeout(() => searchInput.focus(), 100);
    });

    // Close outside
    document.addEventListener('click', function(e) {
        if (!toggleBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
            toggleBtn.setAttribute('aria-expanded', 'false');
        }
    });

    // Search
    searchInput.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        let hasVisible = false;
        kategoriItems.forEach(item => {
            const text = item.getAttribute('data-name');
            if (text.includes(term)) {
                item.style.display = 'flex'; hasVisible = true;
            } else {
                item.style.display = 'none';
            }
        });
        noResults.style.display = hasVisible ? 'none' : 'block';
    });

    // Badges logic
    function updateSelection() {
        const selectedIds = [];
        const selectedNames = [];
        checkboxes.forEach(cb => {
            if (cb.checked) {
                selectedIds.push(cb.value);
                selectedNames.push(cb.nextElementSibling.innerText.trim());
                cb.closest('.kategori-item').style.backgroundColor = '#eff6ff';
            } else {
                cb.closest('.kategori-item').style.backgroundColor = '';
            }
        });

        hiddenInput.value = selectedIds.join(',');
        badgeContainer.innerHTML = '';
        
        selectedNames.forEach((name, index) => {
            const badge = document.createElement('div');
            badge.className = 'selected-badge';
            badge.innerHTML = `<span>${name}</span><i class="bi bi-x ms-2 remove-badge" data-id="${selectedIds[index]}"></i>`;
            badgeContainer.appendChild(badge);
        });

        if (selectedNames.length > 0) {
            placeholder.textContent = `${selectedNames.length} Kategori Dipilih`;
            placeholder.classList.add('text-primary', 'fw-bold');
        } else {
            placeholder.textContent = 'Pilih minimal 1 kategori';
            placeholder.classList.remove('text-primary', 'fw-bold');
        }

        // Remove badge event
        document.querySelectorAll('.remove-badge').forEach(icon => {
            icon.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = this.getAttribute('data-id');
                const cb = document.getElementById('kat-' + id);
                if(cb) { cb.checked = false; updateSelection(); }
            });
        });
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateSelection));
    updateSelection(); // init

    // ============================================================
    // 5. FORM SUBMIT
    // ============================================================
    const form = document.getElementById('form-berita');
    form.addEventListener('submit', function(e) {
        const content1 = quillContent.root.innerHTML.trim();
        const content2 = quillContent2.root.innerHTML.trim();
        const cleanContent1 = content1.replace(/<[^>]*>/g, '').trim();

        if (cleanContent1 === '') {
            e.preventDefault();
            alert('Isi Berita tidak boleh kosong!');
            quillContent.focus();
            return false;
        }
        document.getElementById('content-hidden').value = content1;
        document.getElementById('content2-hidden').value = content2;
    });
});
</script>

<?= $this->endSection() ?>