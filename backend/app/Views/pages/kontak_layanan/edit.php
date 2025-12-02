<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="mt-4 mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kontak Layanan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/kontak_layanan">Kontak Layanan</a></li>
                <li class="breadcrumb-item active">Edit Data</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm mb-4 border-0 border-top border-warning border-3">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-edit me-1"></i> Form Edit Data</h6>
        </div>
        <div class="card-body">
            
            <?php if (session()->has('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Gagal Update:</strong>
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

            <form action="/kontak_layanan/<?= $kontak['id_kontak_layanan'] ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="judul" class="form-label fw-bold">Judul Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul', $kontak['judul']) ?>" required maxlength="150">
                    </div>
                    <div class="col-md-6">
                        <label for="subjudul" class="form-label fw-bold">Sub Judul</label>
                        <input type="text" class="form-control" id="subjudul" name="subjudul" value="<?= old('subjudul', $kontak['subjudul']) ?>" maxlength="255">
                    </div>

                    <div class="col-12"><hr class="my-2"></div>

                    <div class="col-md-6">
                        <label for="icon_class" class="form-label fw-bold">Pilih Icon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-warning" style="font-size: 1.2rem; width: 50px; justify-content: center;">
                                <i id="iconPreview" class="<?= esc($kontak['icon_class']) ?>"></i>
                            </span>
                            
                            <select class="form-select" id="icon_class" name="icon_class" required>
                                <option value="" disabled>-- Pilih Icon --</option>
                                
                                <optgroup label="Media Sosial & Kontak">
                                    <option value="fab fa-whatsapp" <?= old('icon_class', $kontak['icon_class']) == 'fab fa-whatsapp' ? 'selected' : '' ?>>WhatsApp Brand</option>
                                    <option value="fas fa-phone" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-phone' ? 'selected' : '' ?>>Telepon (Gagang)</option>
                                    <option value="fas fa-phone-alt" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-phone-alt' ? 'selected' : '' ?>>Telepon (Alternative)</option>
                                    <option value="fas fa-envelope" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-envelope' ? 'selected' : '' ?>>Email / Surat</option>
                                    <option value="fab fa-telegram" <?= old('icon_class', $kontak['icon_class']) == 'fab fa-telegram' ? 'selected' : '' ?>>Telegram</option>
                                    <option value="fab fa-instagram" <?= old('icon_class', $kontak['icon_class']) == 'fab fa-instagram' ? 'selected' : '' ?>>Instagram</option>
                                    <option value="fab fa-facebook" <?= old('icon_class', $kontak['icon_class']) == 'fab fa-facebook' ? 'selected' : '' ?>>Facebook</option>
                                    <option value="fas fa-globe" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-globe' ? 'selected' : '' ?>>Website / Globe</option>
                                </optgroup>

                                <optgroup label="Dokumen & Download">
                                    <option value="fas fa-download" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-download' ? 'selected' : '' ?>>Download (Panah Bawah)</option>
                                    <option value="fas fa-file-pdf" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-file-pdf' ? 'selected' : '' ?>>File PDF</option>
                                    <option value="fas fa-file-alt" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-file-alt' ? 'selected' : '' ?>>Dokumen Teks</option>
                                    <option value="fas fa-folder-open" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-folder-open' ? 'selected' : '' ?>>Folder</option>
                                </optgroup>

                                <optgroup label="Layanan & Umum">
                                    <option value="fas fa-headset" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-headset' ? 'selected' : '' ?>>Customer Service</option>
                                    <option value="fas fa-info-circle" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-info-circle' ? 'selected' : '' ?>>Informasi</option>
                                    <option value="fas fa-exclamation-triangle" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-exclamation-triangle' ? 'selected' : '' ?>>Peringatan / Darurat</option>
                                    <option value="fas fa-ambulance" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-ambulance' ? 'selected' : '' ?>>Ambulans</option>
                                    <option value="fas fa-map-marker-alt" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-map-marker-alt' ? 'selected' : '' ?>>Lokasi / Peta</option>
                                    <option value="fas fa-bullhorn" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-bullhorn' ? 'selected' : '' ?>>Pengumuman</option>
                                    <option value="fas fa-user-tie" <?= old('icon_class', $kontak['icon_class']) == 'fas fa-user-tie' ? 'selected' : '' ?>>Pejabat / Petugas</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-text">Ubah pilihan dropdown untuk mengganti icon.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="icon_bg_color" class="form-label fw-bold">Warna Background Icon</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" id="colorPicker" value="<?= old('icon_bg_color', $kontak['icon_bg_color']) ?>">
                            <input type="text" class="form-control" id="icon_bg_color" name="icon_bg_color" value="<?= old('icon_bg_color', $kontak['icon_bg_color']) ?>" maxlength="20">
                        </div>
                    </div>

                    <div class="col-12"><hr class="my-2"></div>
                    <div class="col-md-4">
                        <label for="link_url" class="form-label fw-bold">Link URL</label>
                        <input type="url" class="form-control" id="link_url" name="link_url" value="<?= old('link_url', $kontak['link_url']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="nomor_telepon" class="form-label fw-bold">Nomor Telepon</label>
                        <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?= old('nomor_telepon', $kontak['nomor_telepon']) ?>">
                    </div>

                    <div class="col-12"><hr class="my-2"></div>

                    <div class="col-md-6">
                        <label for="urutan" class="form-label fw-bold">Urutan Tampil</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', $kontak['urutan']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="aktif" <?= old('status', $kontak['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status', $kontak['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="/kontak_layanan" class="btn btn-secondary"><i class="fas fa-times me-1"></i> Batal</a>
                    <button type="submit" class="btn btn-warning text-white"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. Sync Color Picker
    const colorPicker = document.getElementById('colorPicker');
    const colorText = document.getElementById('icon_bg_color');

    colorPicker.addEventListener('input', () => colorText.value = colorPicker.value);
    colorText.addEventListener('input', () => colorPicker.value = colorText.value);

    // 2. Logic Preview Icon (Otomatis ganti icon saat dropdown dipilih)
    const iconSelect = document.getElementById('icon_class');
    const iconPreview = document.getElementById('iconPreview');

    function updateIconPreview() {
        const selectedClass = iconSelect.value;
        if(selectedClass) {
            iconPreview.className = selectedClass;
        }
    }

    iconSelect.addEventListener('change', updateIconPreview);

    // PENTING: Jalankan fungsi ini saat halaman dimuat 
    // agar icon yang tersimpan di database langsung tampil di preview
    updateIconPreview();
</script>

<?= $this->endSection() ?>