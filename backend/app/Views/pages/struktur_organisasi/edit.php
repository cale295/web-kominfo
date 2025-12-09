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
    
    /* Styling Visual Tree di Dropdown */
    .level-0 { font-weight: 700; color: #2c3e50; } 
    .level-1 { font-weight: 500; color: #444; }    
    .level-2 { color: #666; font-size: 0.95em; }    
    .level-deep { color: #888; font-size: 0.9em; font-style: italic; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Struktur Organisasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/struktur_organisasi">Struktur</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit</h6>
        </div>
        <div class="card-body">
            <form action="/struktur_organisasi/<?= $struktur['id_struktur'] ?>" method="post" id="formStruktur">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Unit/Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="<?= old('nama', $struktur['nama']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Induk (Parent)</label>
                            
                            <select class="form-select select2" name="parent_id" id="parent_id">
                                <option value="" data-depth="0">- Tidak Ada (Root) -</option>
                                <?php foreach ($parents as $p): ?>
                                    <option value="<?= $p['id_struktur'] ?>" 
                                            data-depth="<?= $p['depth'] ?>"
                                            <?= (old('parent_id', $struktur['parent_id']) == $p['id_struktur']) ? 'selected' : '' ?>>
                                        <?= $p['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Pilih induk jika unit ini adalah bawahan.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <div id="editor-container"></div>
                            
                            <input type="hidden" name="deskripsi" id="deskripsi_input" value="<?= htmlspecialchars(old('deskripsi', $struktur['deskripsi'] ?? '')) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Urutan Tampilan</label>
                                    <input type="number" class="form-control" name="sorting" value="<?= old('sorting', $struktur['sorting']) ?>">
                                    <div class="form-text">Semakin kecil angka, semakin prioritas.</div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/struktur_organisasi" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
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
        // --- LOGIKA SELECT2 (SAMA PERSIS DENGAN CREATE) ---
        
        function formatStruktur(state) {
            if (!state.id) { return state.text; }
            
            var depth = $(state.element).data('depth'); 
            var paddingLeft = depth * 20; 
            var icon = '';
            var cssClass = '';

            if (depth == 0) {
                icon = '<i class="fas fa-building text-primary me-2"></i>';
                cssClass = 'level-0';
            } else if (depth == 1) {
                icon = '<i class="fas fa-folder-open text-warning me-2"></i>';
                cssClass = 'level-1';
            } else {
                icon = '<i class="fas fa-turn-up fa-rotate-90 text-secondary me-2"></i>'; 
                cssClass = depth == 2 ? 'level-2' : 'level-deep';
            }

            var $state = $(
                '<span style="padding-left:' + paddingLeft + 'px" class="' + cssClass + '">' + 
                    icon + state.text + 
                '</span>'
            );
            return $state;
        }

        function formatSelection(state) {
            if (!state.id) { return state.text; }
            var depth = $(state.element).data('depth');
            var icon = (depth == 0) ? '<i class="fas fa-building text-primary me-1"></i>' : '';
            return $('<span>' + icon + state.text + '</span>');
        }

        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Cari Unit Induk...',
            allowClear: true,
            templateResult: formatStruktur,    
            templateSelection: formatSelection 
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // --- LOGIKA QUILL ---
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

        // Load data lama (dari database atau old input) ke Editor
        var oldContent = document.getElementById('deskripsi_input').value;
        if (oldContent) { quill.clipboard.dangerouslyPasteHTML(oldContent); }

        document.getElementById('formStruktur').onsubmit = function() {
            var input = document.querySelector('input[name=deskripsi]');
            input.value = (quill.root.innerHTML === '<p><br></p>') ? '' : quill.root.innerHTML;
        };
    });
</script>
<?= $this->endSection() ?>