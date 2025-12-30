<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
        <a href="/kontak?tab=<?= $type ?>" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-body">
            
            <?php 
                $id = '';
                if($type == 'instansi') $id = $row['id_kontak'];
                if($type == 'social')   $id = $row['id_kontak_social'];
                if($type == 'layanan')  $id = $row['id_kontak_layanan'];
            ?>

            <form action="/kontak/update/<?= $type ?>/<?= $id ?>" method="POST">
                <?= csrf_field() ?>
                
                <?php if ($type == 'instansi'): ?>
                   <div class="mb-3">
                        <label class="form-label">Nama Instansi</label>
                        <input type="text" name="nama_instansi" class="form-control" value="<?= esc($row['nama_instansi']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" rows="3"><?= esc($row['alamat_lengkap']) ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="<?= esc($row['telepon']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fax</label>
                            <input type="text" name="fax" class="form-control" value="<?= esc($row['fax']) ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Google Maps (Embed/Share)</label>
                        <input type="text" name="map_link" class="form-control" value="<?= esc($row['map_link']) ?>" placeholder="https://maps.app.goo.gl/...">
                    </div>

                <?php elseif ($type == 'social'): ?>
                    <?php 
                        $socialIcons = [
                            'bi bi-facebook'    => 'Facebook',
                            'bi bi-instagram'   => 'Instagram',
                            'bi bi-twitter-x'   => 'Twitter / X',
                            'bi bi-youtube'     => 'Youtube',
                            'bi bi-tiktok'      => 'Tiktok',
                            'bi bi-whatsapp'    => 'Whatsapp',
                            'bi bi-telegram'    => 'Telegram',
                            'bi bi-linkedin'    => 'LinkedIn',
                            'bi bi-globe'       => 'Website',
                            'bi bi-envelope'    => 'Email',
                        ];
                    ?>

                    <div class="mb-3">
                        <label class="form-label">Platform</label>
                        <select name="platform" class="form-select">
                            <?php $plat = $row['platform']; ?>
                            <option value="Facebook" <?= $plat=='Facebook'?'selected':'' ?>>Facebook</option>
                            <option value="Instagram" <?= $plat=='Instagram'?'selected':'' ?>>Instagram</option>
                            <option value="Twitter" <?= $plat=='Twitter'?'selected':'' ?>>Twitter / X</option>
                            <option value="Youtube" <?= $plat=='Youtube'?'selected':'' ?>>Youtube</option>
                            <option value="Tiktok" <?= $plat=='Tiktok'?'selected':'' ?>>Tiktok</option>
                            <option value="Website" <?= $plat=='Website'?'selected':'' ?>>Website</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="url" name="link_url" class="form-control" value="<?= esc($row['link_url']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i id="icon-preview" class="<?= esc($row['icon_class']) ?> fs-5"></i></span>
                                
                                <select name="icon_class" class="form-select" id="icon-select" required onchange="updateIconPreview()">
                                    <?php foreach($socialIcons as $class => $label): ?>
                                        <?php $selected = ($row['icon_class'] == $class) ? 'selected' : ''; ?>
                                        <option value="<?= $class ?>" <?= $selected ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?= esc($row['urutan']) ?>">
                        </div>
                    </div>

                <?php elseif ($type == 'layanan'): ?>
                    <?php 
                        $layananIcons = [
                            'bi bi-laptop'          => 'Laptop / Digital',
                            'bi bi-pc-display'      => 'Komputer / Monitor',
                            'bi bi-phone'           => 'Handphone / Aplikasi',
                            'bi bi-person-fill'     => 'User / Kepegawaian',
                            'bi bi-people-fill'     => 'Publik / Masyarakat',
                            'bi bi-person-vcard'    => 'Kartu Identitas',
                            'bi bi-file-earmark-text'=> 'Dokumen / Berkas',
                            'bi bi-folder2-open'    => 'Arsip / Data',
                            'bi bi-envelope-open'   => 'Persuratan',
                            'bi bi-megaphone'       => 'Pengumuman',
                            'bi bi-calendar-event'  => 'Jadwal / Agenda',
                            'bi bi-geo-alt-fill'    => 'Peta / Lokasi',
                            'bi bi-globe2'          => 'Internet / Web',
                            'bi bi-gear-fill'       => 'Pengaturan',
                            'bi bi-building'        => 'Gedung / Kantor',
                            'bi bi-headset'         => 'Call Center',
                        ];
                    ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" value="<?= esc($row['judul']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjudul</label>
                        <input type="text" name="subjudul" class="form-control" value="<?= esc($row['subjudul']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="url" name="link_url" class="form-control" value="<?= esc($row['link_url']) ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Icon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i id="icon-preview" class="<?= esc($row['icon_class']) ?> fs-5"></i></span>
                                
                                <select name="icon_class" class="form-select" id="icon-select" required onchange="updateIconPreview()">
                                    <?php foreach($layananIcons as $class => $label): ?>
                                        <?php $selected = ($row['icon_class'] == $class) ? 'selected' : ''; ?>
                                        <option value="<?= $class ?>" <?= $selected ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Warna</label>
                            <input type="color" name="icon_bg_color" class="form-control form-control-color w-100" value="<?= esc($row['icon_bg_color']) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?= esc($row['urutan']) ?>">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateIconPreview() {
        // Cek dulu apakah elemen ada (karena di tab Instansi elemen ini tidak ada)
        var selectElement = document.getElementById('icon-select');
        var previewElement = document.getElementById('icon-preview');
        
        if (selectElement && previewElement) {
            var iconClass = selectElement.value;
            previewElement.className = iconClass + " fs-5";
        }
    }
</script>
<?= $this->endSection() ?>