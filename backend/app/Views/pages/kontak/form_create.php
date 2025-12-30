<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
        <a href="/kontak?tab=<?= $type ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-body">
            <form action="/kontak/store/<?= $type ?>" method="POST">
                <?= csrf_field() ?>

                <?php if ($type == 'instansi'): ?>
                    <div class="mb-3">
                        <label class="form-label">Nama Instansi</label>
                        <input type="text" name="nama_instansi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fax</label>
                            <input type="text" name="fax" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Map (Embed)</label>
                        <input type="text" name="map_link" class="form-control">
                    </div>

                <?php elseif ($type == 'social'): ?>
                    <?php 
                        // DEFINISI LIST ICON SOCIAL DISINI
                        $socialIcons = [
                            'fab fa-facebook'       => 'Facebook',
                            'fab fa-instagram'      => 'Instagram',
                            'fab fa-twitter'        => 'Twitter / X',
                            'fab fa-youtube'        => 'Youtube',
                            'fab fa-tiktok'         => 'Tiktok',
                            'fab fa-whatsapp'       => 'Whatsapp',
                            'fab fa-telegram'       => 'Telegram',
                            'fab fa-linkedin'       => 'LinkedIn',
                            'fas fa-globe'          => 'Website',
                            'fas fa-envelope'       => 'Email',
                        ];
                    ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Platform</label>
                        <select name="platform" class="form-select">
                            <option value="Facebook">Facebook</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Twitter">Twitter / X</option>
                            <option value="Youtube">Youtube</option>
                            <option value="Tiktok">Tiktok</option>
                            <option value="Website">Website</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="url" name="link_url" class="form-control" required placeholder="https://...">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pilih Logo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light d-flex align-items-center justify-content-center" style="width: 60px;">
                                    <i id="icon-preview" class="fas fa-hashtag" style="font-size: 1.5rem;"></i>
                                </span>
                                <select name="icon_class" class="form-select" id="icon-select" required onchange="updateIconPreview()">
                                    <option value="" selected disabled>-- Pilih Logo --</option>
                                    <?php foreach($socialIcons as $class => $label): ?>
                                        <option value="<?= $class ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="1">
                        </div>
                    </div>

                <?php elseif ($type == 'layanan'): ?>
                    <?php 
                        // DEFINISI LIST ICON LAYANAN DISINI
                        $layananIcons = [
                            'fas fa-laptop'             => 'Laptop / Digital',
                            'fas fa-desktop'            => 'Komputer / Monitor',
                            'fas fa-mobile-alt'         => 'Handphone / Aplikasi',
                            'fas fa-user'               => 'User / Kepegawaian',
                            'fas fa-users'              => 'Publik / Masyarakat',
                            'fas fa-id-card'            => 'Kartu Identitas',
                            'fas fa-file-alt'           => 'Dokumen / Berkas',
                            'fas fa-folder-open'        => 'Arsip / Data',
                            'fas fa-envelope-open'      => 'Persuratan',
                            'fas fa-bullhorn'           => 'Pengumuman',
                            'fas fa-calendar-alt'       => 'Jadwal / Agenda',
                            'fas fa-map-marker-alt'     => 'Peta / Lokasi',
                            'fas fa-globe'              => 'Internet / Web',
                            'fas fa-cog'                => 'Pengaturan',
                            'fas fa-building'           => 'Gedung / Kantor',
                            'fas fa-headset'            => 'Call Center',
                        ];
                    ?>

                    <div class="mb-3">
                        <label class="form-label">Judul Layanan</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjudul</label>
                        <input type="text" name="subjudul" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Tujuan</label>
                        <input type="url" name="link_url" class="form-control" required placeholder="https://...">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pilih Icon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light d-flex align-items-center justify-content-center" style="width: 60px;">
                                    <i id="icon-preview" class="fas fa-th" style="font-size: 1.5rem;"></i>
                                </span>
                                <select name="icon_class" class="form-select" id="icon-select" required onchange="updateIconPreview()">
                                    <option value="" selected disabled>-- Pilih Icon --</option>
                                    <?php foreach($layananIcons as $class => $label): ?>
                                        <option value="<?= $class ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Warna Icon</label>
                            <input type="color" name="icon_bg_color" class="form-control form-control-color w-100" value="#0d6efd">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="1">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateIconPreview() {
        var iconClass = document.getElementById('icon-select').value;
        var iconPreview = document.getElementById('icon-preview');
        iconPreview.className = iconClass;
        iconPreview.style.fontSize = '1.5rem';
    }
</script>
<?= $this->endSection() ?>