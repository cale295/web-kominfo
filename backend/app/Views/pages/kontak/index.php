<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold"><?= esc($title) ?></h1>
            <p class="text-muted small mb-0">Kelola data, alamat, social media, dan layanan instansi.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kontak</li>
        </ol>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link <?= $activeTab == 'instansi' ? 'active shadow-sm' : '' ?>" href="?tab=instansi">
                        <i class="bi bi-building me-1"></i> Instansi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activeTab == 'social' ? 'active shadow-sm' : '' ?>" href="?tab=social">
                        <i class="bi bi-share me-1"></i> Social Media
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $activeTab == 'layanan' ? 'active shadow-sm' : '' ?>" href="?tab=layanan">
                        <i class="bi bi-headset me-1"></i> Layanan
                    </a>
                </li>
            </ul>

            <?php if ($access['can_create']): ?>
                <?php 
                    $btnUrl = '#'; $showBtn = true;
                    if ($activeTab == 'instansi') {
                        $btnUrl = '/kontak/create/instansi';
                        if ($count_data >= 1) $showBtn = false;
                    } elseif ($activeTab == 'social') {
                        $btnUrl = '/kontak/create/social';
                    } elseif ($activeTab == 'layanan') {
                        $btnUrl = '/kontak/create/layanan';
                    }
                ?>
                <?php if ($showBtn): ?>
                    <a href="<?= $btnUrl ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Data
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            
            <?php if ($activeTab == 'instansi'): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4 py-3">Nama Instansi</th>
                            <th class="py-3">Alamat</th>
                            <th class="py-3">Kontak</th>
                            <th class="py-3">Peta</th>
                            <th class="text-center py-3">Status</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_list)): ?>
                             <?= $this->include('pages/kontak/_empty_state') ?>
                        <?php else: ?>
                            <?php foreach ($data_list as $row): ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= esc($row['nama_instansi']) ?></td>
                                <td class="small text-muted"><?= esc($row['alamat_lengkap']) ?></td>
                                <td class="small">
                                    <div><i class="bi bi-telephone me-1"></i><?= esc($row['telepon']) ?></div>
                                    <div><i class="bi bi-printer me-1"></i><?= esc($row['fax']) ?></div>
                                </td>
                                <td>
                                    <?php if (!empty($row['map_link'])): ?>
                                        <a href="<?= esc($row['map_link']) ?>" target="_blank" class="badge bg-light text-primary border text-decoration-none">Lihat Peta</a>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted border">No Map</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                            data-id="<?= $row['id_kontak'] ?>"
                                            data-type="instansi"
                                            data-url="kontak/status"
                                            <?= $row['status'] == 1 ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <?php if ($access['can_update']): ?>
                                            <a href="/kontak/edit/instansi/<?= $row['id_kontak'] ?>" class="btn btn-outline-warning btn-sm rounded-circle"><i class="bi bi-pencil"></i></a>
                                        <?php endif; ?>
                                        <?php if ($access['can_delete']): ?>
                                            <form action="/kontak/delete/instansi/<?= $row['id_kontak'] ?>" method="POST" onsubmit="return confirm('Hapus?')">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"><i class="bi bi-trash"></i></button>
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

            <?php elseif ($activeTab == 'social'): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3">No</th>
                            <th class="py-3">Platform</th>
                            <th class="text-center py-3">Icon</th>
                            <th class="py-3">Link URL</th>
                            <th class="text-center py-3">Status</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_list)): ?>
                             <?= $this->include('pages/kontak/_empty_state') ?>
                        <?php else: ?>
                            <?php foreach ($data_list as $i => $row): ?>
                            <tr>
                                <td class="text-center"><?= $i + 1 ?></td>
                                <td class="fw-bold"><?= esc($row['platform']) ?></td>
                                <td class="text-center"><i class="<?= esc($row['icon_class']) ?> fs-5 text-primary"></i></td>
                                <td><a href="<?= esc($row['link_url']) ?>" target="_blank" class="small text-truncate d-block" style="max-width: 200px;"><?= esc($row['link_url']) ?></a></td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                            data-id="<?= $row['id_kontak_social'] ?>"
                                            data-type="social"
                                            data-url="kontak/status"
                                            <?= $row['status'] == 1 ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="/kontak/edit/social/<?= $row['id_kontak_social'] ?>" class="btn btn-outline-warning btn-sm rounded-circle"><i class="bi bi-pencil"></i></a>
                                        <form action="/kontak/delete/social/<?= $row['id_kontak_social'] ?>" method="POST" onsubmit="return confirm('Hapus?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php elseif ($activeTab == 'layanan'): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3">Urut</th>
                            <th class="py-3">Layanan</th>
                            <th class="py-3">Link</th>
                            <th class="text-center py-3">Status</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_list)): ?>
                             <?= $this->include('pages/kontak/_empty_state') ?>
                        <?php else: ?>
                            <?php foreach ($data_list as $row): ?>
                            <tr>
                                <td class="text-center"><span class="badge bg-light text-dark border"><?= esc($row['urutan']) ?></span></td>
                                <td>
                                    <div class="fw-bold"><?= esc($row['judul']) ?></div>
                                    <div class="small text-muted"><?= esc($row['subjudul']) ?></div>
                                </td>
                                <td><a href="<?= esc($row['link_url']) ?>" target="_blank" class="btn btn-sm btn-light border">Buka Link</a></td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                            data-id="<?= $row['id_kontak_layanan'] ?>"
                                            data-type="layanan"
                                            data-url="kontak/status"
                                            <?= $row['status'] == 1 ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="/kontak/edit/layanan/<?= $row['id_kontak_layanan'] ?>" class="btn btn-outline-warning btn-sm rounded-circle"><i class="bi bi-pencil"></i></a>
                                        <form action="/kontak/delete/layanan/<?= $row['id_kontak_layanan'] ?>" method="POST" onsubmit="return confirm('Hapus?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Init Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Init Toggle
        const toggles = document.querySelectorAll('.toggle-status');
        const base_url = "<?= base_url() ?>"; 

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                
                // 1. Ambil data langsung dari atribut HTML (seperti request Anda)
                const id = this.getAttribute('data-id');
                const type = this.getAttribute('data-type');
                const urlPath = this.getAttribute('data-url'); // Mengambil 'kontak/status'
                
                // Kirim 1 untuk aktif, 0 untuk nonaktif
                const statusValue = this.checked ? 1 : 0; 
                
                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = '<?= csrf_hash() ?>';

                // 2. Gunakan FormData (seperti request Anda)
                let formData = new FormData();
                formData.append('id', id);
                formData.append('type', type);
                formData.append('status', statusValue);
                formData.append(csrfName, csrfHash);

                // 3. Fetch menggunakan URL dari atribut
                fetch(base_url + '/' + urlPath, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Update Berhasil');
                    } else {
                        alert('Gagal update status');
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
    });
</script>

<?= $this->endSection() ?>