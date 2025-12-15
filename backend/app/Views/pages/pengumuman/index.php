<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengumuman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengumuman</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bullhorn me-2"></i>Daftar Pengumuman</h6>
            <?php if ($can_create): ?>
                <a href="/pengumuman/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="text-center py-3" width="10%">Gambar</th>
                            <th class="py-3" width="30%">Judul & Konten</th>
                            <th class="text-center py-3" width="10%">Media</th>
                            <th class="py-3" width="15%">Tanggal</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengumuman)) : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-newspaper fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada pengumuman</h6>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($pengumuman as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($item['featured_image']) && file_exists($item['featured_image'])): ?>
                                            <div class="p-1 border rounded bg-light d-inline-block">
                                                <img src="<?= base_url($item['featured_image']) ?>" alt="Img" style="height: 40px; width: 60px; object-fit: cover;">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">No Img</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['judul']) ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 200px;">
                                            <?= strip_tags($item['content']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($item['tipe_media'] == 'link'): ?>
                                            <span class="badge bg-info text-dark"><i class="fas fa-link me-1"></i> Link</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><i class="fas fa-file-alt me-1"></i> File</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="small text-muted">
                                        <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <?= btn_toggle($item['id_pengumuman'], $item['status'], 'pengumuman/toggle-status') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/pengumuman/<?= $item['id_pengumuman'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/pengumuman/<?= $item['id_pengumuman'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
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