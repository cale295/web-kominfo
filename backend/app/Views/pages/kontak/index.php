<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Data Kontak</h1>
            <p class="text-muted small mb-0">Kelola informasi kontak, alamat, dan peta lokasi instansi.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kontak</li>
        </ol>
    </div>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-address-book me-2"></i>Daftar Kontak Instansi
            </h6>
            <a href="/kontak/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                <i class="fas fa-plus me-1"></i> Tambah Kontak
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="20%">Nama Instansi</th>
                            <th class="py-3" width="25%">Alamat</th>
                            <th class="py-3" width="20%">Peta</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <?php if ($can_update || $can_delete): ?>
                                <th class="text-center py-3" width="10%">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kontak)): ?>
                            <tr>
                                <td colspan="<?= ($can_update || $can_delete) ? 6 : 5 ?>" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-map-marked-alt fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data kontak</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan data baru.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kontak as $index => $row): ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($row['nama_instansi']) ?></div>
                                    </td>
                                    
                                    <td>
                                        <div class="small text-muted"><?= esc($row['alamat_lengkap']) ?></div>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['map_link'])): ?>
                                            <div class="ratio ratio-16x9 shadow-sm border rounded bg-light" style="width: 180px; height: 100px;">
                                                <iframe 
                                                    src="<?= esc($row['map_link']) ?>" 
                                                    style="border:0;" 
                                                    allowfullscreen="" 
                                                    loading="lazy" 
                                                    referrerpolicy="no-referrer-when-downgrade">
                                                </iframe>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">
                                                <i class="fas fa-map-slash me-1"></i> Tidak ada peta
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <?= btn_toggle($row['id_kontak'], $row['status'], 'kontak/toggle-status') ?>
                                        </div>
                                    </td>

                                    <?php if ($can_update || $can_delete): ?>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center align-items-center h-100">
                                                <?php if ($can_update): ?>
                                                    <a href="kontak/<?= $row['id_kontak'].'/edit' ?>" 
                                                       class="btn btn-outline-warning btn-sm rounded-circle shadow-sm" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <form action="/kontak/<?= $row['id_kontak'] ?>" method="POST" onsubmit="return confirm('Hapus data ini?')">
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
                                    <?php endif; ?>
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
                // Jika database pakai enum('aktif','nonaktif'), gunakan baris pertama.
                // Jika database pakai int(1/0), gunakan baris kedua.
                
                const statusValue = this.checked ? 'aktif' : 'nonaktif'; 
                // const statusValue = this.checked ? 1 : 0; 

                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = '<?= csrf_hash() ?>';

                let formData = new FormData();
                formData.append('id', id);
                formData.append('status', statusValue); 
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