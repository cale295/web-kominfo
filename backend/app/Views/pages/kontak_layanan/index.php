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

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-headset me-2"></i>Daftar Data Layanan
            </h6>
            <?php if ($can_create): ?>
                <a href="/kontak_layanan/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Baru
                </a>
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
                                                <a href="/kontak_layanan/<?= $row['id_kontak_layanan'] ?>/edit" 
                                                   class="btn btn-outline-warning btn-sm rounded-circle shadow-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
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

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Tooltip Init
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // 2. Logic Toggle Switch AJAX
        const toggles = document.querySelectorAll('.form-check-input[type="checkbox"]');
        const base_url = "<?= base_url() ?>"; // Base URL

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const url = this.dataset.url;
                
                // PENTING: Sesuaikan nilai status yang dikirim ke controller
                // Jika database pakai enum('1','0') atau int(1), gunakan baris ini:
                const isChecked = this.checked ? 1 : 0; 
                
                // Jika database pakai enum('aktif','nonaktif'), gunakan ini:
                // const isChecked = this.checked ? 'aktif' : 'nonaktif'; 

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
                        this.checked = !this.checked; // Kembalikan posisi jika gagal
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