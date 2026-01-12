<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    /* --- CSS Custom --- */
    :root { --primary-soft: #eef2ff; --primary-text: #4f46e5; }
    .card-modern { border: none; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); transition: transform 0.2s ease; overflow: hidden; }
    .img-hover-zoom { transition: transform 0.3s ease; cursor: pointer; display: block; border-radius: 0.5rem; overflow: hidden; }
    .img-hover-zoom:hover { transform: scale(1.05); }
    
    /* Modal Styles */
    .modal-content { border-radius: 8px; border: none; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
    .modal-header { border-bottom: 1px solid #dee2e6; padding: 1.5rem; background-color: #fff; border-top-left-radius: 8px; border-top-right-radius: 8px; }
    .modal-body { padding: 2rem; background-color: #fff; }
    .modal-footer { background-color: #fff; border-top: none; padding: 1rem 2rem 2rem; justify-content: flex-end; gap: 10px; }

    /* Form Styles */
    .form-group-row { display: flex; align-items: center; margin-bottom: 1.25rem; }
    .form-group-row.align-items-start { align-items: flex-start; }
    .form-label-custom { font-weight: 600; font-size: 0.9rem; color: #444; margin-bottom: 0; width: 30%; padding-right: 15px; }
    .form-input-container { width: 70%; position: relative; }
    .form-control, .form-select { border-radius: 4px; border: 1px solid #ced4da; padding: 0.6rem 0.75rem; font-size: 0.9rem; }
    .form-control:focus, .form-select:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25); }
    .required-star { color: #dc3545; margin-left: 2px; }

    /* Image Preview Utils */
    .img-preview-box { width: 100px; height: 100px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-top: 10px; }
    .img-preview-box img { width: 100%; height: 100%; object-fit: cover; }
    .text-helper { font-size: 0.8rem; color: #6c757d; font-style: italic; margin-top: 4px; }
    .current-image-preview-box { width: 100px; height: 100px; border: 2px solid #4e73df; border-radius: 4px; overflow: hidden; margin-bottom: 10px; }
    .current-image-preview-box img { width: 100%; height: 100%; object-fit: cover; }

    /* Buttons */
    .btn-custom-cancel { background-color: #6c757d; color: white; padding: 8px 20px; border-radius: 4px; border: none; }
    .btn-custom-save { background-color: #2c449c; color: white; padding: 8px 20px; border-radius: 4px; border: none; }
    .btn-soft-primary { background-color: var(--primary-soft); color: var(--primary-text); border: none; }
    .btn-soft-danger { background-color: #fef2f2; color: #dc2626; border: none; }
    
    /* Modal Image Viewer */
    .image-modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.85); align-items: center; justify-content: center; }
    .image-modal.show { display: flex; }
    .image-modal-content { max-width: 90%; max-height: 85%; object-fit: contain; }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1">Agenda Kegiatan</h1>
            <p class="text-muted small mb-0">Kelola jadwal kegiatan, lokasi, dan dokumentasi.</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success fade show mb-4" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger fade show mb-4" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">Daftar Agenda</h5>
            <?php if ($can_create): ?>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAgenda">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Agenda
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3">No</th>
                            <th class="text-center py-3">Foto</th>
                            <th class="py-3">Nama Kegiatan</th>
                            <th class="py-3">Lokasi & Deskripsi</th>
                            <th class="py-3">Waktu</th>
                            <th class="text-center py-3">Status</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($agendas)): ?>
                            <?php foreach ($agendas as $i => $agenda): ?>
                                <tr>
                                    <td class="text-center text-muted"><?= $i + 1 ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($agenda['image'])): ?>
                                            <div class="img-hover-zoom shadow-sm border mx-auto" style="width: 50px; height: 50px;">
                                                <img src="<?= base_url('uploads/agenda/' . $agenda['image']) ?>" class="w-100 h-100 object-fit-cover" onclick="openImageModal(this.src)">
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto" style="width: 50px; height: 50px;"><i class="bi bi-image text-muted"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold"><?= esc($agenda['activity_name']) ?></td>
                                    <td>
                                        <div class="small fw-semibold"><i class="bi bi-geo-alt me-1 text-danger"></i><?= esc($agenda['location']) ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 200px;"><?= esc($agenda['description']) ?></div>
                                    </td>
                                    <td>
                                        <div class="small text-dark fw-bold"><?= date('d M Y H:i', strtotime($agenda['start_date'])) ?></div>
                                        <div class="small text-muted">s/d <?= date('d M Y H:i', strtotime($agenda['end_date'])) ?></div>
                                    </td>
                                    <td class="text-center">
                                    <?= btn_toggle($agenda['id_agenda'], $agenda['status'], 'agenda/toggle-status') ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                    class="btn btn-soft-primary btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px;"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditAgenda"
                                                    data-id="<?= $agenda['id_agenda'] ?>"
                                                    data-name="<?= esc($agenda['activity_name']) ?>"
                                                    data-location="<?= esc($agenda['location']) ?>"
                                                    data-description="<?= esc($agenda['description']) ?>"
                                                    data-start="<?= date('Y-m-d\TH:i', strtotime($agenda['start_date'])) ?>" 
                                                    data-end="<?= date('Y-m-d\TH:i', strtotime($agenda['end_date'])) ?>"
                                                    data-status="<?= $agenda['status'] ?>"
                                                    data-image="<?= $agenda['image'] ?>"
                                                >
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            <?php endif; ?>

                                            <form action="<?= base_url('agenda/delete/'.$agenda['id_agenda']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-soft-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada agenda.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAgenda" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Data Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('agenda') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group-row">
                        <label class="form-label-custom">Nama Kegiatan <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" name="activity_name" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Lokasi <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" name="location" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Mulai <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" name="start_date" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Selesai <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" name="end_date" required>
                        </div>
                    </div>
                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom" style="padding-top:8px">Deskripsi</label>
                        <div class="form-input-container">
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="active">
                    
                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom" style="padding-top:5px">Foto</label>
                        <div class="form-input-container">
                            <input type="file" class="form-control" name="image" id="add_image" accept="image/*" onchange="previewAddImage()">
                            <div class="img-preview-box" id="add-preview-box" style="display:none;">
                                <img id="add-img-preview" src="#">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditAgenda" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Data Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="" method="post" enctype="multipart/form-data" id="formEditAgenda">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body">
                    <div class="form-group-row">
                        <label class="form-label-custom">Nama Kegiatan <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" id="edit_activity_name" name="activity_name" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Lokasi <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="text" class="form-control" id="edit_location" name="location" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Mulai <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                    </div>
                    <div class="form-group-row">
                        <label class="form-label-custom">Selesai <span class="required-star">*)</span></label>
                        <div class="form-input-container">
                            <input type="datetime-local" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom" style="padding-top: 8px;">Deskripsi</label>
                        <div class="form-input-container">
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                    </div>  

                    <div class="form-group-row align-items-start">
                        <label class="form-label-custom" style="padding-top: 5px;">Foto</label>
                        <div class="form-input-container">
                            <div id="current-image-container" style="display: none;">
                                <div class="small text-muted mb-1">Foto Saat Ini:</div>
                                <div class="current-image-preview-box">
                                    <img id="current-image-preview" src="#" alt="Current">
                                </div>
                            </div>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*" onchange="previewEditImage()">
                            <div class="text-helper">*) Kosongkan jika tidak ingin mengubah foto.</div>
                            <div class="img-preview-box" id="edit-preview-container" style="display: none;">
                                <img id="edit-img-preview" src="#" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-custom-save">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span style="position:absolute; top:20px; right:30px; color:white; font-size:40px; cursor:pointer;">&times;</span>
    <img class="image-modal-content" id="modalImage">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Modal Logic
    var modalEditAgenda = document.getElementById('modalEditAgenda');
    modalEditAgenda.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        
        // Populate URL
        var id = button.getAttribute('data-id');
        document.getElementById('formEditAgenda').action = '<?= base_url('agenda') ?>/' + id;
        
        // Populate Inputs
        document.getElementById('edit_activity_name').value = button.getAttribute('data-name');
        document.getElementById('edit_location').value = button.getAttribute('data-location');
        document.getElementById('edit_description').value = button.getAttribute('data-description');
        document.getElementById('edit_start_date').value = button.getAttribute('data-start');
        document.getElementById('edit_end_date').value = button.getAttribute('data-end');

        // Image Preview Logic
        var image = button.getAttribute('data-image');
        var imgContainer = document.getElementById('current-image-container');
        var imgPreview = document.getElementById('current-image-preview');

        if (image && image !== "") {
            imgContainer.style.display = 'block';
            imgPreview.src = '<?= base_url('uploads/agenda') ?>/' + image; 
        } else {
            imgContainer.style.display = 'none';
        }

        // Reset Upload Input
        document.getElementById('edit_image').value = '';
        document.getElementById('edit-preview-container').style.display = 'none';
    });
});

// Preview Image Functions
function previewAddImage() {
    const image = document.querySelector('#add_image');
    const imgPreview = document.querySelector('#add-img-preview');
    const box = document.querySelector('#add-preview-box');
    if(image.files && image.files[0]){
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
            box.style.display = 'flex';
        }
    }
}

function previewEditImage() {
    const image = document.querySelector('#edit_image');
    const imgPreview = document.querySelector('#edit-img-preview');
    const previewContainer = document.querySelector('#edit-preview-container');
    if(image.files && image.files[0]){
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
            previewContainer.style.display = 'flex';
        }
    }
}

// Viewer Logic
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.add('show');
}
function closeImageModal() {
    document.getElementById('imageModal').classList.remove('show');
}

// AJAX Toggle Status
function toggleStatus(id) {
    fetch('<?= base_url('agenda/toggle-status') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>' 
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            // Optional: Show Toast
            console.log('Status updated');
        } else {
            alert('Gagal mengubah status: ' + data.message);
            location.reload(); // Revert toggle visual
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function setupDateValidation(startInput, endInput) {
    if (!startInput || !endInput) return;

    // Set min saat awal
    if (startInput.value) {
        endInput.min = startInput.value;
    }

    startInput.addEventListener('change', function () {
        endInput.min = startInput.value;

        if (endInput.value && endInput.value < startInput.value) {
            endInput.value = startInput.value;
        }
    });

    endInput.addEventListener('change', function () {
        if (startInput.value && endInput.value < startInput.value) {
            alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai!');
            endInput.value = startInput.value;
        }
    });

    // Validasi submit
    const form = startInput.closest('form');
    if (form) {
        form.addEventListener('submit', function (e) {
            if (startInput.value && endInput.value && endInput.value < startInput.value) {
                e.preventDefault();
                alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai!');
                endInput.value = startInput.value;
            }
        });
    }
}

// TAMBAH AGENDA
document.addEventListener('DOMContentLoaded', function () {
    setupDateValidation(
        document.querySelector('input[name="start_date"]'),
        document.querySelector('input[name="end_date"]')
    );
});

// EDIT AGENDA → PENTING
document.getElementById('modalEditAgenda').addEventListener('shown.bs.modal', function () {
    setupDateValidation(
        document.getElementById('edit_start_date'),
        document.getElementById('edit_end_date')
    );
});
</script>

<?= $this->endSection() ?>