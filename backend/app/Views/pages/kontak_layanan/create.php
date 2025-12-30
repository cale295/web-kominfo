<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kontak Layanan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/kontak_layanan">Kontak Layanan</a></li>
                <li class="breadcrumb-item active">Tambah Baru</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm mb-4 border-0 border-top border-primary border-3">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle me-1"></i> Form Input Data</h6>
        </div>
        <div class="card-body">
            

            <form action="/kontak_layanan" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="judul" class="form-label fw-bold">Judul Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul') ?>" placeholder="Misal: Call Center" required maxlength="150">
                    </div>
                    <div class="col-md-6">
                        <label for="subjudul" class="form-label fw-bold">Sub Judul</label>
                        <input type="text" class="form-control" id="subjudul" name="subjudul" value="<?= old('subjudul') ?>" placeholder="Keterangan singkat..." maxlength="255">
                    </div>

                    <div class="col-12"><hr class="my-2"></div>

                    <div class="col-md-6">
                        <label for="icon_class" class="form-label fw-bold">Pilih Icon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-primary d-flex align-items-center justify-content-center" style="font-size: 2.5rem; width: 80px; height: 80px;">
                                <i id="iconPreview" class="fas fa-icons"></i>
                            </span>
                            
                            <select class="form-select" id="icon_class" name="icon_class" required style="height: 80px;">
                                <option value="" disabled selected>-- Pilih Icon --</option>
                                
                                <optgroup label="Media Sosial & Kontak">
                                    <option value="fab fa-whatsapp" <?= old('icon_class') == 'fab fa-whatsapp' ? 'selected' : '' ?>>WhatsApp Brand</option>
                                    <option value="fas fa-phone" <?= old('icon_class') == 'fas fa-phone' ? 'selected' : '' ?>>Telepon (Gagang)</option>
                                    <option value="fas fa-phone-alt" <?= old('icon_class') == 'fas fa-phone-alt' ? 'selected' : '' ?>>Telepon (Alternative)</option>
                                    <option value="fas fa-envelope" <?= old('icon_class') == 'fas fa-envelope' ? 'selected' : '' ?>>Email / Surat</option>
                                    <option value="fab fa-telegram" <?= old('icon_class') == 'fab fa-telegram' ? 'selected' : '' ?>>Telegram</option>
                                    <option value="fab fa-instagram" <?= old('icon_class') == 'fab fa-instagram' ? 'selected' : '' ?>>Instagram</option>
                                    <option value="fab fa-facebook" <?= old('icon_class') == 'fab fa-facebook' ? 'selected' : '' ?>>Facebook</option>
                                    <option value="fas fa-globe" <?= old('icon_class') == 'fas fa-globe' ? 'selected' : '' ?>>Website / Globe</option>
                                </optgroup>

                                <optgroup label="Dokumen & Download">
                                    <option value="fas fa-download" <?= old('icon_class') == 'fas fa-download' ? 'selected' : '' ?>>Download (Panah Bawah)</option>
                                    <option value="fas fa-file-pdf" <?= old('icon_class') == 'fas fa-file-pdf' ? 'selected' : '' ?>>File PDF</option>
                                    <option value="fas fa-file-alt" <?= old('icon_class') == 'fas fa-file-alt' ? 'selected' : '' ?>>Dokumen Teks</option>
                                    <option value="fas fa-folder-open" <?= old('icon_class') == 'fas fa-folder-open' ? 'selected' : '' ?>>Folder</option>
                                </optgroup>

                                <optgroup label="Layanan & Umum">
                                    <option value="fas fa-headset" <?= old('icon_class') == 'fas fa-headset' ? 'selected' : '' ?>>Customer Service</option>
                                    <option value="fas fa-info-circle" <?= old('icon_class') == 'fas fa-info-circle' ? 'selected' : '' ?>>Informasi</option>
                                    <option value="fas fa-exclamation-triangle" <?= old('icon_class') == 'fas fa-exclamation-triangle' ? 'selected' : '' ?>>Peringatan / Darurat</option>
                                    <option value="fas fa-ambulance" <?= old('icon_class') == 'fas fa-ambulance' ? 'selected' : '' ?>>Ambulans</option>
                                    <option value="fas fa-map-marker-alt" <?= old('icon_class') == 'fas fa-map-marker-alt' ? 'selected' : '' ?>>Lokasi / Peta</option>
                                    <option value="fas fa-bullhorn" <?= old('icon_class') == 'fas fa-bullhorn' ? 'selected' : '' ?>>Pengumuman</option>
                                    <option value="fas fa-user-tie" <?= old('icon_class') == 'fas fa-user-tie' ? 'selected' : '' ?>>Pejabat / Petugas</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-text">Icon akan tampil otomatis di kotak sebelah kiri saat dipilih.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="icon_bg_color" class="form-label fw-bold">Warna Background Icon</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="colorPicker" value="<?= old('icon_bg_color', '#ffc107') ?>" title="Pilih warna">
                            <input type="text" class="form-control" id="icon_bg_color" name="icon_bg_color" value="<?= old('icon_bg_color', '#ffc107') ?>" maxlength="20">
                        </div>
                    </div>

                    <div class="col-12"><hr class="my-2"></div>

                    <div class="col-md-4">
                        <label for="link_url" class="form-label fw-bold">Link URL</label>
                        <input type="url" class="form-control" id="link_url" name="link_url" value="<?= old('link_url') ?>" placeholder="https://...">
                    </div>

                    <div class="col-12"><hr class="my-2"></div>

                    <div class="col-md-6">
                        <label for="urutan" class="form-label fw-bold">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', 0) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="/kontak_layanan" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // 1. Sync Color Picker (Warna Background)
    const colorPicker = document.getElementById('colorPicker');
    const colorInput = document.getElementById('icon_bg_color');
    const iconPreviewBox = document.querySelector('.input-group-text.bg-light');

    colorPicker.addEventListener('input', function() {
        colorInput.value = this.value;
        // Update background color preview
        iconPreviewBox.style.backgroundColor = this.value;
        // Adjust text color for better visibility
        const brightness = getBrightness(this.value);
        iconPreviewBox.style.color = brightness > 128 ? '#000' : '#fff';
    });

    colorInput.addEventListener('input', function() {
        colorPicker.value = this.value;
        iconPreviewBox.style.backgroundColor = this.value;
        const brightness = getBrightness(this.value);
        iconPreviewBox.style.color = brightness > 128 ? '#000' : '#fff';
    });

    // Function to calculate brightness
    function getBrightness(hexColor) {
        const hex = hexColor.replace('#', '');
        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);
        return (r * 299 + g * 587 + b * 114) / 1000;
    }

    // 2. Logic Preview Icon (Otomatis ganti icon saat dropdown dipilih)
    const iconSelect = document.getElementById('icon_class');
    const iconPreview = document.getElementById('iconPreview');

    // Fungsi untuk update icon
    function updateIconPreview() {
        const selectedClass = iconSelect.value;
        if(selectedClass) {
            // Hapus semua class lama lalu tambahkan class baru
            iconPreview.className = selectedClass;
        } else {
            // Default jika belum pilih
            iconPreview.className = 'fas fa-icons';
        }
    }

    // Jalankan saat user memilih dropdown
    iconSelect.addEventListener('change', updateIconPreview);

    // Jalankan saat halaman diload (untuk handle old input saat error validasi)
    updateIconPreview();

    // Initialize color preview on load
    if(colorInput.value) {
        iconPreviewBox.style.backgroundColor = colorInput.value;
        const brightness = getBrightness(colorInput.value);
        iconPreviewBox.style.color = brightness > 128 ? '#000' : '#fff';
    }
</script>

<?= $this->endSection() ?>