<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    /* ... CSS yang sudah ada tetap sama ... */
    
    /* Tambahan CSS untuk Temporary Images */
    .retained-image-info {
        background-color: #e0f2fe;
        border-left: 4px solid #0284c7;
        padding: 12px 16px;
        border-radius: 8px;
        margin-top: 12px;
        font-size: 0.875rem;
        color: #0c4a6e;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .retained-image-info i {
        color: #0284c7;
        font-size: 1rem;
    }

    .temp-image-badge {
        display: inline-block;
        background: var(--info);
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        margin-top: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .temp-image-badge i {
        margin-right: 4px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <h1>
        <i class="bi bi-file-earmark-plus"></i>
        Tambah Berita Baru
    </h1>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Form Card -->
<div class="form-card">
    <form action="<?= site_url('berita') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- SECTION: Informasi Dasar -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-info-circle"></i>
                Informasi Dasar
            </div>

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
                    <div class="ql-editor" data-placeholder="Tulis isi berita di sini..."></div>
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
                    <div class="ql-editor" data-placeholder="Tulis isi berita bagian kedua di sini..."></div>
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
                            $oldKategori = old('id_kategori', []);
                            if (!is_array($oldKategori)) {
                                $oldKategori = explode(',', $oldKategori);
                            }
                            ?>
                            <?php foreach ($kategori as $kat): ?>
                                <div class="form-check ps-3 py-1 kategori-item" 
                                     data-name="<?= esc(strtolower($kat['kategori'])) ?>">
                                    <input class="form-check-input kategori-checkbox" 
                                           type="checkbox" 
                                           name="id_kategori[]" 
                                           id="kat-<?= $kat['id_kategori'] ?>" 
                                           value="<?= $kat['id_kategori'] ?>"
                                           <?= in_array($kat['id_kategori'], $oldKategori) ? 'checked' : '' ?>>
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

                <!-- Hidden input untuk JS multi-select -->
                <input type="hidden" name="id_kategori" id="kategori-hidden" value="<?= implode(',', $oldKategori) ?>">

                <!-- Container badge pilihan -->
                <div id="selected-kategori-badges" class="mt-2 d-flex flex-wrap"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Sub Kategori</label>
                <input type="text" name="id_sub_kategori" class="form-control" placeholder="Sub kategori (opsional)" value="<?= old('id_sub_kategori') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Kunci (SEO)</label>
                <textarea name="keyword" class="form-control" rows="2" placeholder="Pisahkan dengan koma, contoh: teknologi, inovasi, digital"><?= old('keyword') ?></textarea>
                <small class="text-muted">Kata kunci untuk optimasi mesin pencari</small>
            </div>
        </div>

        <!-- SECTION: Media & Gambar -->
        <div class="form-section">
            <div class="section-title">
                <i class="bi bi-images"></i>
                Media & Gambar
            </div>

            <!-- COVER IMAGE dengan Support Temporary -->
            <div class="mb-4">
                <label class="form-label">Foto Cover (Utama) <span class="text-danger">*</span></label>
                <input type="file" 
                       name="feat_image" 
                       class="form-control" 
                       accept="image/*" 
                       id="cover-image" 
                       <?= empty($tempCoverImage) ? 'required' : '' ?>>
                <small class="text-muted">Format: JPG, PNG, GIF (Maksimal 2MB)</small>
                
                <?php if (!empty($tempCoverImage)): ?>
                    <div class="retained-image-info">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong>Gambar sebelumnya tersimpan.</strong> Upload gambar baru jika ingin menggantinya.
                    </div>
                <?php endif; ?>
                
                <div id="cover-preview" class="preview-container"></div>
            </div>

            <!-- ADDITIONAL IMAGES dengan Support Temporary -->
            <div class="mb-4">
                <label class="form-label">Foto Tambahan</label>
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
                <textarea name="caption" class="form-control" rows="2" placeholder="Keterangan untuk gambar"><?= old('caption') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Link Video</label>
                <input type="text" name="link_video" class="form-control" placeholder="https://youtube.com/watch?v=..." value="<?= old('link_video') ?>">
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
                        <option value="<?= $b['id_berita'] ?>" <?= old('id_berita_terkait') == $b['id_berita'] ? 'selected' : '' ?>>
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
                        <option value="<?= $b['id_berita'] ?>" <?= old('id_berita_terkait2') == $b['id_berita'] ? 'selected' : '' ?>>
                            <?= esc($b['judul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Sumber Berita</label>
                <input type="text" name="sumber" class="form-control" placeholder="Contoh: Kompas.com, Detik, Internal" value="<?= old('sumber') ?>">
                <small class="text-muted">Sumber atau referensi berita</small>
            </div>
        </div>

        <!-- Hidden Status Fields -->
        <input type="hidden" name="status" value="0">
        <input type="hidden" name="status_berita" value="2">

        <!-- Action Buttons -->
        <div class="action-buttons d-flex justify-content-end gap-2">
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Berita
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- Inisialisasi Quill Editor ---
    const quillContent = new Quill('#editor-content', {
        modules: { toolbar: '#toolbar-content' },
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...'
    });

    const quillContent2 = new Quill('#editor-content2', {
        modules: { toolbar: '#toolbar-content2' },
        theme: 'snow',
        placeholder: 'Tulis isi berita bagian kedua di sini...'
    });

    // --- Masukkan old content dari server ---
    const oldContent1 = <?= json_encode(old('content', '')) ?>;
    const oldContent2 = <?= json_encode(old('content2', '')) ?>;
    if (oldContent1.trim() !== '') quillContent.clipboard.dangerouslyPasteHTML(oldContent1);
    if (oldContent2.trim() !== '') quillContent2.clipboard.dangerouslyPasteHTML(oldContent2);

    // --- Update hidden textarea sebelum submit ---
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const content1 = quillContent.root.innerHTML.trim();
        const content2 = quillContent2.root.innerHTML.trim();

        if (quillContent.getText().trim() === '') {
            e.preventDefault(); 
            alert('Isi Berita tidak boleh kosong!'); 
            quillContent.focus(); 
            return false;
        }
        if (quillContent2.getText().trim() === '') {
            e.preventDefault(); 
            alert('Isi Berita 2 tidak boleh kosong!'); 
            quillContent2.focus(); 
            return false;
        }

        document.getElementById('content-hidden').value = content1;
        document.getElementById('content2-hidden').value = content2;
    });

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

    // ========================================================
    // DROPDOWN KATEGORI Multi-Select
    // ========================================================
    const toggleBtn = document.getElementById('kategori-toggle');
    const dropdownMenu = toggleBtn.nextElementSibling;
    const searchInput = document.getElementById('kategori-search');
    const kategoriItems = Array.from(document.querySelectorAll('.kategori-item'));
    const checkboxes = document.querySelectorAll('.kategori-checkbox');
    const hiddenInput = document.getElementById('kategori-hidden');
    const placeholder = document.getElementById('kategori-placeholder');
    const badgesContainer = document.getElementById('selected-kategori-badges');
    const noResultsEl = document.getElementById('kategori-no-results');

    function updateKategoriUI() {
        const selected = Array.from(checkboxes).filter(cb => cb.checked);
        const ids = selected.map(cb => cb.value);
        const names = selected.map(cb => cb.closest('.kategori-item').querySelector('.form-check-label').textContent.trim());
        hiddenInput.value = ids.join(',');
        placeholder.textContent = names.length ? `${names.length} kategori dipilih` : 'Pilih minimal 1 kategori';
        placeholder.classList.toggle('text-gray-500', !names.length);
        placeholder.classList.toggle('text-gray-700', !!names.length);

        // Render badges
        badgesContainer.innerHTML = names.map((name, idx) =>
            `<span class="selected-badge">${name} <i class="bi bi-x-circle-fill" data-index="${idx}"></i></span>`
        ).join('');

        badgesContainer.querySelectorAll('.bi-x-circle-fill').forEach(icon => {
            icon.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                const cb = selected[idx]; 
                if(cb){ 
                    cb.checked = false; 
                    updateKategoriUI(); 
                }
            });
        });
    }

    // Inisialisasi checkbox dari hidden input lama
    const oldValues = hiddenInput.value ? hiddenInput.value.split(',') : [];
    oldValues.forEach(id => { 
        const cb = document.getElementById('kat-' + id); 
        if(cb) cb.checked = true; 
    });
    updateKategoriUI();
    checkboxes.forEach(cb => cb.addEventListener('change', updateKategoriUI));

    // Filter kategori
    searchInput.addEventListener('input', function(){
        const q = searchInput.value.trim().toLowerCase();
        let visible = false;
        kategoriItems.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            const match = name.includes(q);
            item.style.display = match ? 'flex' : 'none';
            if(match) visible = true;
        });
        noResultsEl.style.display = visible ? 'none' : 'block';
    });

    // Toggle dropdown
    toggleBtn.addEventListener('click', function(e){
        e.stopPropagation();
        const show = toggleBtn.getAttribute('aria-expanded') !== 'true';
        toggleBtn.setAttribute('aria-expanded', show);
        dropdownMenu.classList.toggle('show', show);
        if(show) setTimeout(() => searchInput.focus(), 50);
    });

    // Tutup dropdown klik luar
    document.addEventListener('click', function(e){
        if(!toggleBtn.contains(e.target) && !dropdownMenu.contains(e.target)){
            toggleBtn.setAttribute('aria-expanded', 'false');
            dropdownMenu.classList.remove('show');
        }
    });

    // Reset pencarian saat dropdown ditutup
    new MutationObserver(() => {
        if(!dropdownMenu.classList.contains('show')){ 
            searchInput.value = ''; 
            searchInput.dispatchEvent(new Event('input')); 
        }
    }).observe(dropdownMenu, {attributes: true, attributeFilter: ['class']});

});
</script>

<?= $this->endSection() ?>