<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Agenda Pelatihan</h1>
            <p class="text-muted small mb-0">Jadwal kegiatan dan pelatihan.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Agenda</li>
        </ol>
    </div>

    <!-- Alert Messages -->
    <?= $this->include('layouts/alerts') ?>

    <!-- Main Card -->
    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar-alt me-2"></i>Daftar Agenda</h6>
            <?php if ($can_create): ?>
                <a href="/agenda_pelatihan/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Agenda
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="text-center py-3" width="10%">Thumb</th>
                            <th class="py-3" width="25%">Judul Agenda</th>
                            <th class="py-3" width="15%">Waktu</th>
                            <th class="py-3" width="20%">Tempat</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($agenda)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="far fa-calendar-times fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada agenda</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan jadwal baru.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($agenda as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($item['thumbnail']) && file_exists($item['thumbnail'])): ?>
                                            <div class="p-1 border rounded bg-light d-inline-block">
                                                <img src="<?= base_url($item['thumbnail']) ?>" alt="Img" style="height: 40px; width: 60px; object-fit: cover;">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">No Img</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['judul']) ?></div>
                                    </td>
                                    <td>
                                        <div class="small fw-bold text-primary">
                                            <?= date('d M Y', strtotime($item['tanggal_agenda'])) ?>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="far fa-clock me-1"></i> <?= esc($item['waktu']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small text-muted">
                                            <i class="fas fa-map-marker-alt me-1 text-danger"></i> <?= esc($item['tempat']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            $badgeClass = 'bg-secondary';
                                            if($item['status'] == 'published') $badgeClass = 'bg-success';
                                            if($item['status'] == 'draft') $badgeClass = 'bg-warning text-dark';
                                        ?>
                                        <span class="badge rounded-pill <?= $badgeClass ?> px-3">
                                            <?= ucfirst($item['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/agenda_pelatihan/<?= $item['id'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/agenda_pelatihan/<?= $item['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus agenda ini?');">
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