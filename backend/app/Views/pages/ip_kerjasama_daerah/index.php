<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">IP Kerjasama Daerah</h1>
            <p class="text-muted small mb-0">Informasi Publik terkait Kerjasama Daerah.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Kerjasama Daerah</li>
        </ol>
    </div>

    <!-- Alert Messages -->
    <?= $this->include('layouts/alerts') ?>

    <!-- Main Card -->
    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-handshake me-2"></i>Daftar Kerjasama</h6>
            <?php if ($can_create): ?>
                <a href="/ip_kerjasama_daerah/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Data
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="15%">Tanggal</th>
                            <th class="py-3" width="20%">Nomor</th>
                            <th class="py-3" width="20%">Tentang</th>
                            <th class="py-3" width="30%">Perihal</th>
                            <th class="text-center py-3" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kerjasama)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-file-contract fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan data kerjasama baru.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($kerjasama as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <span class="text-nowrap"><i class="far fa-calendar-alt me-1 text-primary"></i> <?= date('d M Y', strtotime($item['tanggal'])) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border"><?= esc($item['nomor']) ?></span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        <?= esc($item['tentang']) ?>
                                    </td>
                                    <td>
                                        <div class="small text-muted text-wrap">
                                            <?= nl2br(esc(substr($item['perihal'], 0, 100))) ?><?= strlen($item['perihal']) > 100 ? '...' : '' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/ip_kerjasama_daerah/<?= $item['id'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/ip_kerjasama_daerah/<?= $item['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?= $this->endSection() ?>