<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Sedikit styling agar editor terlihat menyatu dengan Bootstrap */
    #editor-container {
        height: 300px;
        font-family: inherit;
        font-size: 1rem;
    }
    .ql-toolbar {
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
    }
    .ql-container {
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Struktur Organisasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/struktur_organisasi">Struktur</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Input</h6>
        </div>
        <div class="card-body">
            <form action="/struktur_organisasi" method="post" id="formStruktur">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Unit/Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" placeholder="Contoh: Bidang Informasi dan Komunikasi Publik" value="<?= old('nama') ?>" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <input class="form-control" list="kategoriList" name="kategori" placeholder="Pilih atau ketik..." value="<?= old('kategori') ?>" required>
                                <datalist id="kategoriList">
                                    <option value="sekretariat">Sekretariat</option>
                                    <option value="bidang">Bidang</option>
                                    <option value="seksi">Seksi</option>
                                    <option value="upt">UPT</option>
                                    <option value="kelompok_jabatan">Kelompok Jabatan</option>
                                </datalist>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Induk (Parent)</label>
                                <select class="form-select" name="parent_id">
                                    <option value="">- Tidak Ada (Root) -</option>
                                    <?php foreach ($parents as $p): ?>
                                        <option value="<?= $p['id_struktur'] ?>" <?= old('parent_id') == $p['id_struktur'] ? 'selected' : '' ?>>
                                            <?= $p['nama'] ?> (<?= ucfirst($p['kategori']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">Pilih jika unit ini berada di bawah unit lain.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            
                            <div id="editor-container"></div>
                            
                            <input type="hidden" name="deskripsi" id="deskripsi_input" value="<?= htmlspecialchars(old('deskripsi') ?? '') ?>">
                        </div>

                        </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Urutan Tampilan</label>
                                    <input type="number" class="form-control" name="sorting" value="<?= old('sorting', 0) ?>">
                                    <div class="form-text">Semakin kecil angkanya, semakin di atas.</div>
                                </div>

                                <div class="mb-3 pt-2">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/struktur_organisasi" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Inisialisasi Quill
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi tugas pokok dan fungsi di sini...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],        // toggled buttons
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, false] }],
                    ['link', 'clean']                       // remove formatting button
                ]
            }
        });

        // 2. Load Old Data (Jika validasi gagal dan halaman reload)
        var oldContent = document.getElementById('deskripsi_input').value;
        if (oldContent) {
            // Gunakan clipboard.dangerouslyPasteHTML agar tag HTML terbaca
            quill.clipboard.dangerouslyPasteHTML(oldContent);
        }

        // 3. Tangkap event Submit Form
        var form = document.getElementById('formStruktur');
        form.onsubmit = function() {
            // Pindahkan HTML dari editor Quill ke dalam input hidden sebelum submit
            var deskripsiContent = document.querySelector('input[name=deskripsi]');
            
            // Cek apakah editor kosong (hanya berisi tag p kosong)
            if (quill.root.innerHTML === '<p><br></p>') {
                 deskripsiContent.value = ''; 
            } else {
                 deskripsiContent.value = quill.root.innerHTML;
            }
        };
    });
</script>
<?= $this->endSection() ?> 