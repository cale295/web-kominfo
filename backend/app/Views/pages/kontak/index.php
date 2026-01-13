<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Kontak Instansi</h1>
            <p class="text-muted small mb-0">Kelola informasi alamat, telepon, dan peta lokasi.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kontak</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>
    <?= $this->include('components/kontak_tabs') ?>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-address-book me-2"></i>Daftar Kontak</h6>
            
            <?php 
            // MODIFIKASI LOGIC DISINI:
            // Cek apakah user boleh create
            ?>
            <?php if ($can_create): ?>
                <?php if (empty($kontak)): ?>
                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" data-bs-toggle="modal" data-bs-target="#modalTambahKontak">
                        <i class="fas fa-plus me-1"></i> Tambah Data
                    </button>
                <?php else: ?>
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                        <i class="fas fa-check-circle me-1 text-success"></i> Data Maksimal (1/1)
                    </span>
                <?php endif; ?>
            <?php endif; ?>
            
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="20%">Nama Instansi</th>
                            <th class="py-3" width="25%">Alamat</th>
                            <th class="py-3" width="20%">Telepon / Fax</th>
                            <th class="text-center py-3" width="10%">Peta</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kontak)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-map-marked-alt fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data kontak</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan informasi kontak baru.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($kontak as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['nama_instansi']) ?></div>
                                    </td>
                                    <td>
                                        <div class="small text-muted text-wrap" style="max-width: 300px;">
                                            <?= esc($item['alamat_lengkap']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1 small">
                                            <span><i class="fas fa-phone-alt me-2 text-primary w-15px"></i> <?= esc($item['telepon']) ?></span>
                                            <span><i class="fas fa-fax me-2 text-secondary w-15px"></i> <?= esc($item['fax']) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($item['map_link']): ?>
                                            <a href="<?= esc($item['map_link']) ?>" target="_blank" class="btn btn-outline-info btn-sm rounded-circle" data-bs-toggle="tooltip" title="Lihat di Google Maps">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <?= btn_toggle($item['id_kontak'], $item['status'], 'kontak/toggle-status') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <button type="button" 
                                                        class="btn btn-outline-primary btn-sm rounded-circle shadow-sm btn-edit"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEditKontak"
                                                        data-id="<?= $item['id_kontak'] ?>"
                                                        data-nama="<?= esc($item['nama_instansi']) ?>"
                                                        data-alamat="<?= esc($item['alamat_lengkap']) ?>"
                                                        data-telepon="<?= esc($item['telepon']) ?>"
                                                        data-fax="<?= esc($item['fax']) ?>"
                                                        data-map="<?= esc($item['map_link']) ?>"
                                                        data-status="<?= $item['status'] ?>"
                                                        title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/kontak/<?= $item['id_kontak'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Hapus">
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

<div class="modal fade" id="modalTambahKontak" tabindex="-1" aria-labelledby="modalTambahKontakLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahKontakLabel"><i class="fas fa-plus-circle me-2"></i>Tambah Kontak Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/kontak" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    
                    <?php if (session()->has('errors')) : ?>
                        <div class="alert alert-danger small py-2">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Nama Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_instansi" value="<?= old('nama_instansi') ?>" placeholder="Contoh: Dinas Pendidikan" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat_lengkap" rows="3" placeholder="Jl. Raya No. 123..."><?= old('alamat_lengkap') ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Telepon</label>
                            <input type="text" class="form-control" name="telepon" value="<?= old('telepon') ?>" placeholder="021-xxxxxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Fax</label>
                            <input type="text" class="form-control" name="fax" value="<?= old('fax') ?>" placeholder="021-xxxxxxx">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Link Google Maps</label>
                            <input type="text" class="form-control" name="map_link" value="<?= old('map_link') ?>" placeholder="https://maps.google.com/...">
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

<div class="modal fade" id="modalEditKontak" tabindex="-1" aria-labelledby="modalEditKontakLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="modalEditKontakLabel"><i class="fas fa-edit me-2"></i>Edit Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditKontak" action="" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Nama Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_instansi" name="nama_instansi" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_alamat_lengkap" name="alamat_lengkap" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_telepon" name="telepon" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Fax <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_fax" name="fax" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Link Google Maps <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="url" class="form-control" id="edit_map_link" name="map_link" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.05); }
    .w-15px { width: 15px; display: inline-block; text-align: center; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // 1. Logic Auto-Open Modal Tambah jika ada Error (dari create)
        // Tambahan: Hanya jalankan jika kontak kosong, untuk mencegah error logika
        <?php if (session()->has('errors') && empty($kontak)) : ?>
            var myModal = new bootstrap.Modal(document.getElementById('modalTambahKontak'));
            myModal.show();
        <?php endif; ?>

        // 2. Logic Populate Data ke Modal Edit
        var modalEdit = document.getElementById('modalEditKontak');
        modalEdit.addEventListener('show.bs.modal', function (event) {
            // Tombol yang diklik
            var button = event.relatedTarget;
            
            // Ambil data dari atribut data-*
            var id = button.getAttribute('data-id');
            var nama = button.getAttribute('data-nama');
            var alamat = button.getAttribute('data-alamat');
            var telepon = button.getAttribute('data-telepon');
            var fax = button.getAttribute('data-fax');
            var map = button.getAttribute('data-map');

            // Update Action Form URL (misal: /kontak/123)
            var form = document.getElementById('formEditKontak');
            form.action = '/kontak/' + id;

            // Isi Input Fields
            document.getElementById('edit_nama_instansi').value = nama;
            document.getElementById('edit_alamat_lengkap').value = alamat;
            document.getElementById('edit_telepon').value = telepon;
            document.getElementById('edit_fax').value = fax;
            document.getElementById('edit_map_link').value = map;


        });
    });
</script>
<?= $this->endSection() ?>