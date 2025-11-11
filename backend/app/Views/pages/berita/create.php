<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>


<div class="container py-4">
    <h3>📝 Tambah Berita</h3>
    <form action="<?= site_url('berita') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Judul -->
        <div class="mb-3">
            <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul berita" value="<?= old('judul') ?>">
        </div>

        <!-- Topik -->
        <div class="mb-3">
            <label class="form-label">Topik</label>
            <input type="text" name="topik" class="form-control" placeholder="Masukkan topik berita" value="<?= old('topik') ?>">
        </div>

        <!-- Isi Berita dengan Rich Text Editor -->
        <div class="mb-3">
            <label class="form-label">Isi Berita <span class="text-danger">*</span></label>
            <div id="toolbar-content" class="ql-toolbar-custom mb-2">
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
                <select class="ql-font">
                    <option selected>Sans Serif</option>
                    <option value="serif">Serif</option>
                    <option value="monospace">Monospace</option>
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
            <div id="editor-content" style="min-height: 250px; background: white; border: 1px solid #ced4da; border-radius: 0.375rem;"><?= old('content') ?></div>
            <textarea name="content" id="content-hidden" style="display:none;"></textarea>
        </div>

        <!-- Isi Berita 2 dengan Rich Text Editor -->
        <div class="mb-3">
            <label class="form-label">Isi Berita 2 <span class="text-danger">*</span></label>
            <div id="toolbar-content2" class="ql-toolbar-custom mb-2">
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
                <select class="ql-font">
                    <option selected>Sans Serif</option>
                    <option value="serif">Serif</option>
                    <option value="monospace">Monospace</option>
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
            <div id="editor-content2" style="min-height: 250px; background: white; border: 1px solid #ced4da; border-radius: 0.375rem;"><?= old('content2') ?></div>
            <textarea name="content2" id="content2-hidden" style="display:none;"></textarea>
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label class="form-label">Kategori <span class="text-danger">*</span></label>
            <div id="kategori-buttons" class="mb-3">
                <?php foreach ($kategori as $kat): ?>
                    <button type="button" 
                            class="btn btn-outline-primary kategori-btn me-2 mb-2" 
                            data-id="<?= $kat['id_kategori'] ?>" 
                            data-name="<?= esc($kat['kategori']) ?>">
                        <?= esc($kat['kategori']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div id="selected-kategori" class="mb-2">
                <small class="text-muted">Kategori terpilih akan muncul di sini</small>
            </div>
            <input type="hidden" name="id_kategori" id="kategori-hidden" value="<?= old('id_kategori') ?>">
            <small class="text-muted">Klik kategori untuk memilih/membatalkan. Minimal 1 kategori wajib dipilih.</small>
        </div>

        <!-- Sub Kategori -->
        <div class="mb-3">
            <label class="form-label">Sub Kategori</label>
            <input type="text" name="id_sub_kategori" class="form-control" placeholder="Sub kategori (optional)" value="<?= old('id_sub_kategori') ?>">
        </div>

        <!-- Foto Cover -->
        <div class="mb-3">
            <label class="form-label">Foto Cover (Utama) <span class="text-danger">*</span></label>
            <input type="file" name="feat_image" class="form-control" accept="image/*" id="cover-image" required>
            <small class="text-muted">Format: JPG, PNG, GIF (Maks 2MB)</small>
            <div id="cover-preview" class="mt-2"></div>
        </div>

        <!-- Foto Tambahan -->
        <div class="mb-3">
            <label class="form-label">Foto Tambahan (Opsional)</label>
            <input type="file" name="additional_images[]" class="form-control" accept="image/*" id="additional-images" multiple>
            <small class="text-muted">Pilih beberapa foto sekaligus (maks 5 foto, @2MB)</small>
            <div id="additional-preview" class="mt-2 row g-2"></div>
        </div>

        <!-- Caption Gambar -->
        <div class="mb-3">
            <label class="form-label">Caption Gambar</label>
            <textarea name="caption" class="form-control" rows="2" placeholder="Tuliskan keterangan gambar"><?= old('caption') ?></textarea>
        </div>

        <!-- Intro -->
        <div class="mb-3">
            <label class="form-label">Intro Singkat</label>
            <textarea name="intro" class="form-control" rows="3" placeholder="Deskripsi singkat sebelum isi utama"><?= old('intro') ?></textarea>
        </div>

        <!-- Berita Terkait 1 -->
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

        <!-- Berita Terkait 2 -->
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

        <!-- Link Video -->
        <div class="mb-3">
            <label class="form-label">Link Video (YouTube / lainnya)</label>
            <input type="text" name="link_video" class="form-control" placeholder="https://youtube.com/..." value="<?= old('link_video') ?>">
        </div>

        <!-- Keyword/Tag -->
        <div class="mb-3">
            <label class="form-label">Kata Kunci (SEO Keyword)</label>
            <textarea name="keyword" class="form-control" rows="2" placeholder="Pisahkan dengan koma"><?= old('keyword') ?></textarea>
        </div>

        <!-- Sumber -->
        <div class="mb-3">
            <label class="form-label">Sumber Berita</label>
            <input type="text" name="sumber" class="form-control" placeholder="Contoh: Detik.com, Kompas, dll" value="<?= old('sumber') ?>">
        </div>


        <!-- Status otomatis -->
        <input type="hidden" name="status" value="0">
        <input type="hidden" name="status_berita" value="2">

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
            <a href="<?= site_url('berita') ?>" class="btn btn-secondary ms-2">Kembali</a>
        </div>
    </form>
</div>

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
.kategori-btn {
    transition: all 0.3s ease;
}
.kategori-btn.active {
    background-color: #0d6efd !important;
    color: white !important;
    border-color: #0d6efd !important;
    font-weight: 600;
}
.selected-kategori-badge {
    display: inline-block;
    background: #198754;
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    margin: 5px;
    font-size: 14px;
    font-weight: 500;
}
.preview-img {
    max-width: 200px;
    max-height: 200px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #ddd;
}
.ql-toolbar-custom {
    background: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 8px;
}
.ql-toolbar-custom button,
.ql-toolbar-custom select {
    margin: 2px;
}
.ql-editor {
    min-height: 250px;
    font-size: 16px;
}
</style>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Quill Editors
    const quillContent = new Quill('#editor-content', {
        modules: {
            toolbar: '#toolbar-content'
        },
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...'
    });

    const quillContent2 = new Quill('#editor-content2', {
        modules: {
            toolbar: '#toolbar-content2'
        },
        theme: 'snow',
        placeholder: 'Tulis isi berita di sini...'
    });

    // Update hidden textareas before form submit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const content1 = quillContent.root.innerHTML.trim();
        const content2 = quillContent2.root.innerHTML.trim();
        
        // Check if content is empty (only has <p><br></p> or similar)
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

    // Kategori Selection
    let selectedKategori = [];

    const oldKategori = document.getElementById('kategori-hidden').value;
    if (oldKategori) {
        selectedKategori = oldKategori.split(',').map(k => k.trim()).filter(k => k);
        updateKategoriUI();
    }

    document.querySelectorAll('.kategori-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            const index = selectedKategori.findIndex(k => k.id === id);
            if (index > -1) {
                selectedKategori.splice(index, 1);
            } else {
                selectedKategori.push({id: id, name: name});
            }

            updateKategoriUI();
        });
    });

    function updateKategoriUI() {
        const container = document.getElementById('selected-kategori');
        container.innerHTML = selectedKategori.length
            ? selectedKategori.map(k => `<span class="selected-kategori-badge">✓ ${k.name}</span>`).join(' ')
            : '<small class="text-muted">Kategori terpilih akan muncul di sini</small>';
        document.getElementById('kategori-hidden').value = selectedKategori.map(k => k.id).join(',');
        document.querySelectorAll('.kategori-btn').forEach(btn => {
            const btnId = btn.getAttribute('data-id');
            btn.classList.toggle('active', selectedKategori.some(k => k.id === btnId));
        });
    }

    // Preview Cover Image
    document.getElementById('cover-image').addEventListener('change', function(e) {
        const preview = document.getElementById('cover-preview');
        preview.innerHTML = '';
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => preview.innerHTML = `<img src="${e.target.result}" class="preview-img" alt="Preview">`;
            reader.readAsDataURL(file);
        }
    });

    // Preview Additional Images
    document.getElementById('additional-images').addEventListener('change', function(e) {
        const preview = document.getElementById('additional-preview');
        preview.innerHTML = '';
        Array.from(e.target.files).slice(0,5).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const col = document.createElement('div');
                col.className = 'col-md-3';
                col.innerHTML = `<img src="${e.target.result}" class="preview-img w-100" alt="Preview">`;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>

<?= $this->endSection() ?>