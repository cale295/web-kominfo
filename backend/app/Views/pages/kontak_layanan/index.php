<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Kontak Layanan</h1>
            <p class="text-muted small mb-0">Kelola daftar layanan, icon, dan tautan kontak terkait.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kontak Layanan</li>
        </ol>
    </div>
    
    <?= $this->include('components/kontak_tabs') ?>

    <?php if (session()->has('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>Perhatian:</strong>
                    <ul class="mb-0 ps-3">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-headset me-2"></i>Daftar Data Layanan
            </h6>
            <?php if ($can_create): ?>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modalCreate">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </button>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="25%">Judul Info</th>
                            <th class="text-center py-3" width="10%">Icon</th>
                            <th class="py-3" width="20%">Tautan / Link</th>
                            <th class="text-center py-3" width="10%">Urutan</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kontaklayanan)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-folder-open fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data layanan</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan data baru.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($kontaklayanan as $i => $row) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark mb-1"><?= esc($row['judul']) ?></div>
                                        <div class="small text-muted"><?= esc($row['subjudul']) ?></div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="d-flex justify-content-center align-items-center text-white shadow-sm rounded-circle mb-1" 
                                                 style="width: 40px; height: 40px; background-color: <?= esc($row['icon_bg_color']) ?>;">
                                                <i class="<?= esc($row['icon_class']) ?>"></i>
                                            </div>
                                            <span class="badge bg-light text-muted border" style="font-size: 0.6rem; font-family: monospace;">
                                                <?= esc($row['icon_class']) ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if ($row['link_url']) : ?>
                                            <a href="<?= esc($row['link_url']) ?>" target="_blank" class="btn btn-sm btn-light border text-primary w-100 text-truncate" title="<?= esc($row['link_url']) ?>">
                                                <i class="fas fa-external-link-alt me-1 small"></i> Buka Link
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border"><?= esc($row['urutan']) ?></span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <?= btn_toggle($row['id_kontak_layanan'], $row['status'], 'kontak_layanan/toggle-status') ?>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2 justify-content-center align-items-center h-100">
                                            <?php if ($can_update) : ?>
                                                <button type="button" 
                                                        class="btn btn-outline-warning btn-sm rounded-circle shadow-sm btn-edit" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEdit"
                                                        data-id="<?= $row['id_kontak_layanan'] ?>"
                                                        data-judul="<?= esc($row['judul']) ?>"
                                                        data-subjudul="<?= esc($row['subjudul']) ?>"
                                                        data-icon="<?= esc($row['icon_class']) ?>"
                                                        data-color="<?= esc($row['icon_bg_color']) ?>"
                                                        data-link="<?= esc($row['link_url']) ?>"
                                                        data-urutan="<?= esc($row['urutan']) ?>"
                                                        title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if ($can_delete) : ?>
                                                <form action="/kontak_layanan/<?= $row['id_kontak_layanan'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalCreateLabel"><i class="fas fa-plus-circle me-1"></i> Tambah Kontak Layanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/kontak_layanan" method="post">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="create_judul" class="form-label fw-bold">Judul Layanan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="create_judul" name="judul" value="<?= old('judul') ?>" placeholder="Misal: Call Center" required maxlength="150">
                        </div>
                        <div class="col-md-6">
                            <label for="create_subjudul" class="form-label fw-bold">Sub Judul</label>
                            <input type="text" class="form-control" id="create_subjudul" name="subjudul" value="<?= old('subjudul') ?>" placeholder="Keterangan singkat..." maxlength="255">
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-md-6">
                            <label for="create_icon_class" class="form-label fw-bold">Pilih Icon <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-primary d-flex align-items-center justify-content-center" style="font-size: 2.5rem; width: 80px; height: 80px;">
                                    <i id="create_iconPreview" class="fas fa-icons"></i>
                                </span>
                                <select class="form-select" id="create_icon_class" name="icon_class" required style="height: 80px;">
                                    <option value="" disabled selected>-- Pilih Icon --</option>
                                    <optgroup label="Media Sosial & Kontak">
                                        <option value="fab fa-whatsapp">WhatsApp Brand</option>
                                        <option value="fas fa-phone">Telepon (Gagang)</option>
                                        <option value="fas fa-phone-alt">Telepon (Alternative)</option>
                                        <option value="fas fa-envelope">Email / Surat</option>
                                        <option value="fab fa-telegram">Telegram</option>
                                        <option value="fab fa-instagram">Instagram</option>
                                        <option value="fab fa-facebook">Facebook</option>
                                        <option value="fas fa-globe">Website / Globe</option>
                                    </optgroup>
                                    <optgroup label="Dokumen & Download">
                                        <option value="fas fa-download">Download (Panah Bawah)</option>
                                        <option value="fas fa-file-pdf">File PDF</option>
                                        <option value="fas fa-file-alt">Dokumen Teks</option>
                                        <option value="fas fa-folder-open">Folder</option>
                                    </optgroup>
                                    <optgroup label="Layanan & Umum">
                                        <option value="fas fa-headset">Customer Service</option>
                                        <option value="fas fa-info-circle">Informasi</option>
                                        <option value="fas fa-exclamation-triangle">Peringatan / Darurat</option>
                                        <option value="fas fa-ambulance">Ambulans</option>
                                        <option value="fas fa-map-marker-alt">Lokasi / Peta</option>
                                        <option value="fas fa-bullhorn">Pengumuman</option>
                                        <option value="fas fa-user-tie">Pejabat / Petugas</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="create_icon_bg_color" class="form-label fw-bold">Warna Background Icon</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" id="create_colorPicker" value="<?= old('icon_bg_color', '#ffc107') ?>" title="Pilih warna">
                                <input type="text" class="form-control" id="create_icon_bg_color" name="icon_bg_color" value="<?= old('icon_bg_color', '#ffc107') ?>" maxlength="20">
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-md-8">
                            <label for="create_link_url" class="form-label fw-bold">Link URL</label>
                            <input type="url" class="form-control" id="create_link_url" name="link_url" value="<?= old('link_url') ?>" placeholder="https://...">
                        </div>

                        <div class="col-md-4">
                            <label for="create_urutan" class="form-label fw-bold">Urutan</label>
                            <input type="number" class="form-control" id="create_urutan" name="urutan" value="<?= old('urutan', 0) ?>">
                        </div>
                        
                        <div class="col-md-12">
                             <label for="create_status" class="form-label fw-bold">Status Awal</label>
                             <select class="form-select" id="create_status" name="status">
                                <option value="aktif" selected>Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark" id="modalEditLabel"><i class="fas fa-edit me-1"></i> Edit Kontak Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="post" id="formEdit">
                <div class="modal-body">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_judul" class="form-label fw-bold">Judul Layanan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_judul" name="judul" required maxlength="150">
                        </div>
                        <div class="col-md-6">
                            <label for="edit_subjudul" class="form-label fw-bold">Sub Judul</label>
                            <input type="text" class="form-control" id="edit_subjudul" name="subjudul" maxlength="255">
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-md-6">
                            <label for="edit_icon_class" class="form-label fw-bold">Pilih Icon <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-warning" style="font-size: 2.5rem; width: 80px; height: 80px; justify-content: center;">
                                    <i id="edit_iconPreview" class="fas fa-icons"></i>
                                </span>
                                <select class="form-select" id="edit_icon_class" name="icon_class" required style="height: 80px;">
                                    <option value="" disabled>-- Pilih Icon --</option>
                                    <optgroup label="Media Sosial & Kontak">
                                        <option value="fab fa-whatsapp">WhatsApp Brand</option>
                                        <option value="fas fa-phone">Telepon (Gagang)</option>
                                        <option value="fas fa-phone-alt">Telepon (Alternative)</option>
                                        <option value="fas fa-envelope">Email / Surat</option>
                                        <option value="fab fa-telegram">Telegram</option>
                                        <option value="fab fa-instagram">Instagram</option>
                                        <option value="fab fa-facebook">Facebook</option>
                                        <option value="fas fa-globe">Website / Globe</option>
                                    </optgroup>
                                    <optgroup label="Dokumen & Download">
                                        <option value="fas fa-download">Download (Panah Bawah)</option>
                                        <option value="fas fa-file-pdf">File PDF</option>
                                        <option value="fas fa-file-alt">Dokumen Teks</option>
                                        <option value="fas fa-folder-open">Folder</option>
                                    </optgroup>
                                    <optgroup label="Layanan & Umum">
                                        <option value="fas fa-headset">Customer Service</option>
                                        <option value="fas fa-info-circle">Informasi</option>
                                        <option value="fas fa-exclamation-triangle">Peringatan / Darurat</option>
                                        <option value="fas fa-ambulance">Ambulans</option>
                                        <option value="fas fa-map-marker-alt">Lokasi / Peta</option>
                                        <option value="fas fa-bullhorn">Pengumuman</option>
                                        <option value="fas fa-user-tie">Pejabat / Petugas</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_icon_bg_color" class="form-label fw-bold">Warna Background Icon</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" id="edit_colorPicker">
                                <input type="text" class="form-control" id="edit_icon_bg_color" name="icon_bg_color" maxlength="20">
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-md-8">
                            <label for="edit_link_url" class="form-label fw-bold">Link URL</label>
                            <input type="url" class="form-control" id="edit_link_url" name="link_url">
                        </div>

                        <div class="col-md-4">
                            <label for="edit_urutan" class="form-label fw-bold">Urutan</label>
                            <input type="number" class="form-control" id="edit_urutan" name="urutan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Global Init (Tooltip & AJAX Toggle) ---
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        const toggles = document.querySelectorAll('.form-check-input[type="checkbox"]');
        const base_url = "<?= base_url() ?>";

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const url = this.dataset.url;
                const isChecked = this.checked ? 1 : 0; 
                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = '<?= csrf_hash() ?>';

                let formData = new FormData();
                formData.append('id', id);
                formData.append('status', isChecked);
                formData.append(csrfName, csrfHash);

                fetch(base_url + '/' + url, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Update Berhasil');
                    } else {
                        alert('Gagal: ' + (data.message || 'Error'));
                        this.checked = !this.checked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal koneksi server');
                    this.checked = !this.checked;
                });
            });
        });

        // --- 2. Logic Modal Create ---
        const createColorPicker = document.getElementById('create_colorPicker');
        const createColorInput = document.getElementById('create_icon_bg_color');
        const createIconPreviewBox = document.querySelector('#modalCreate .input-group-text');
        const createIconSelect = document.getElementById('create_icon_class');
        const createIconPreview = document.getElementById('create_iconPreview');

        // Sync Color (Create)
        createColorPicker.addEventListener('input', function() {
            createColorInput.value = this.value;
            updateCreateColorPreview(this.value);
        });
        createColorInput.addEventListener('input', function() {
            createColorPicker.value = this.value;
            updateCreateColorPreview(this.value);
        });
        
        function updateCreateColorPreview(color) {
            createIconPreviewBox.style.backgroundColor = color;
            const brightness = getBrightness(color);
            createIconPreviewBox.style.color = brightness > 128 ? '#000' : '#fff';
        }

        // Preview Icon (Create)
        createIconSelect.addEventListener('change', function() {
            createIconPreview.className = this.value || 'fas fa-icons';
        });

        // --- 3. Logic Modal Edit ---
        const modalEdit = document.getElementById('modalEdit');
        const editColorPicker = document.getElementById('edit_colorPicker');
        const editColorInput = document.getElementById('edit_icon_bg_color');
        const editIconPreviewBox = document.querySelector('#modalEdit .input-group-text');
        const editIconSelect = document.getElementById('edit_icon_class');
        const editIconPreview = document.getElementById('edit_iconPreview');
        const formEdit = document.getElementById('formEdit');

        // Saat Modal Edit Dibuka
        modalEdit.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            // Ambil data dari tombol
            const id = button.getAttribute('data-id');
            const judul = button.getAttribute('data-judul');
            const subjudul = button.getAttribute('data-subjudul');
            const icon = button.getAttribute('data-icon');
            const color = button.getAttribute('data-color');
            const link = button.getAttribute('data-link');
            const urutan = button.getAttribute('data-urutan');

            // Isi form
            formEdit.action = '/kontak_layanan/' + id;
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_subjudul').value = subjudul;
            document.getElementById('edit_link_url').value = link;
            document.getElementById('edit_urutan').value = urutan;
            
            // Set Icon
            editIconSelect.value = icon;
            editIconPreview.className = icon;
            
            // Set Color
            editColorPicker.value = color;
            editColorInput.value = color;
            updateEditColorPreview(color);
        });

        // Sync Color (Edit)
        editColorPicker.addEventListener('input', function() {
            editColorInput.value = this.value;
            updateEditColorPreview(this.value);
        });
        editColorInput.addEventListener('input', function() {
            editColorPicker.value = this.value;
            updateEditColorPreview(this.value);
        });

        function updateEditColorPreview(color) {
            editIconPreviewBox.style.backgroundColor = color;
            const brightness = getBrightness(color);
            editIconPreviewBox.style.color = brightness > 128 ? '#000' : '#fff';
        }

        // Preview Icon (Edit)
        editIconSelect.addEventListener('change', function() {
            editIconPreview.className = this.value;
        });

        // --- Helper Function ---
        function getBrightness(hexColor) {
            if(!hexColor) return 255; 
            const hex = hexColor.replace('#', '');
            const r = parseInt(hex.substr(0, 2), 16);
            const g = parseInt(hex.substr(2, 2), 16);
            const b = parseInt(hex.substr(4, 2), 16);
            return (r * 299 + g * 587 + b * 114) / 1000;
        }
    });
</script>

<?= $this->endSection() ?>