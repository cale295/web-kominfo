<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    /* Styling Editor */
    #editor-container { height: 300px; font-family: inherit; font-size: 1rem; }
    .ql-toolbar { border-top-left-radius: 0.375rem; border-top-right-radius: 0.375rem; }
    .ql-container { border-bottom-left-radius: 0.375rem; border-bottom-right-radius: 0.375rem; }
    
    /* Tweaking Select2 */
    .select2-container .select2-selection--single {
        height: 38px !important; 
        display: flex;
        align-items: center;
    }
    
    /* Styling Pilihan Dropdown */
    .level-0 { font-weight: 700; color: #2c3e50; } /* Induk Utama (Tebal) */
    .level-1 { font-weight: 500; color: #444; }    /* Anak Pertama */
    .level-2 { color: #666; font-size: 0.95em; }    /* Cucu */
    .level-deep { color: #888; font-size: 0.9em; font-style: italic; }
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

                        <div class="mb-3">
                            <label class="form-label fw-bold">Induk (Parent)</label>
                            
                            <select class="form-select select2" name="parent_id" id="parent_id">
                                <option value="" data-depth="0">- Tidak Ada (Root) -</option>
                                <?php foreach ($parents as $p): ?>
                                    <option value="<?= $p['id_struktur'] ?>" 
                                            data-depth="<?= $p['depth'] ?>" 
                                            <?= old('parent_id') == $p['id_struktur'] ? 'selected' : '' ?>>
                                        <?= $p['nama'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                            
                            <div class="form-text">Pilih induk jika unit ini adalah bawahan.</div>
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
                                    <div class="form-text">Semakin kecil angka, semakin prioritas.</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    $(document).ready(function() {
        // --- LOGIKA SELECT2 YANG DIPERCANTIK ---
        
        // Fungsi untuk mengatur tampilan per baris option
        function formatStruktur(state) {
            if (!state.id) { return state.text; } // Untuk placeholder
            
            // Ambil data depth dari atribut HTML
            var depth = $(state.element).data('depth'); 
            var paddingLeft = depth * 20; // 20px per level
            var icon = '';
            var cssClass = '';

            // Tentukan Icon & Style berdasarkan Level kedalaman
            if (depth == 0) {
                icon = '<i class="fas fa-building text-primary me-2"></i>'; // Icon Gedung utk Induk
                cssClass = 'level-0';
            } else if (depth == 1) {
                icon = '<i class="fas fa-folder-open text-warning me-2"></i>'; // Icon Folder utk Sub
                cssClass = 'level-1';
            } else {
                icon = '<i class="fas fa-turn-up fa-rotate-90 text-secondary me-2"></i>'; // Icon Panah L utk Cucu
                cssClass = depth == 2 ? 'level-2' : 'level-deep';
            }

            // Gabungkan Padding (CSS) + Icon + Teks
            var $state = $(
                '<span style="padding-left:' + paddingLeft + 'px" class="' + cssClass + '">' + 
                    icon + state.text + 
                '</span>'
            );
            return $state;
        }

        // Fungsi untuk tampilan saat item SUDAH DIPILIH (Selection Box)
        function formatSelection(state) {
            if (!state.id) { return state.text; }
            // Saat dipilih, kita tidak butuh padding/indentasi berlebih, cukup icon saja
            // Ambil depth untuk cek icon apa yg cocok
            var depth = $(state.element).data('depth');
            var icon = (depth == 0) ? '<i class="fas fa-building text-primary me-1"></i>' : '';
            
            return $('<span>' + icon + state.text + '</span>');
        }

        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Cari Unit Induk...',
            allowClear: true,
            templateResult: formatStruktur,    // Tampilan saat dropdown dibuka
            templateSelection: formatSelection // Tampilan setelah dipilih
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // --- LOGIKA QUILL (TETAP SAMA) ---
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Tulis deskripsi tugas pokok dan fungsi...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, false] }],
                    ['link', 'clean']
                ]
            }
        });

        var oldContent = document.getElementById('deskripsi_input').value;
        if (oldContent) { quill.clipboard.dangerouslyPasteHTML(oldContent); }

        document.getElementById('formStruktur').onsubmit = function() {
            var input = document.querySelector('input[name=deskripsi]');
            input.value = (quill.root.innerHTML === '<p><br></p>') ? '' : quill.root.innerHTML;
        };
    });
</script>
<?= $this->endSection() ?>