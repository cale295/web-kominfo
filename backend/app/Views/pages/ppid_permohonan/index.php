<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Permohonan Informasi (PPID)</h1>
            <p class="text-muted small mb-0">Daftar permohonan informasi publik yang masuk via website/API.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">PPID</li>
        </ol>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-inbox me-2"></i>Kotak Masuk</h6>
            <!-- Tombol Tambah DIHILANGKAN sesuai request -->
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">ID</th>
                            <th class="py-3">Pemohon</th>
                            <th class="py-3">Informasi Diminta</th>
                            <th class="py-3">Tanggal</th>
                            <th class="text-center py-3">Status</th>
                            <th class="text-center py-3" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($permohonan)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <h6 class="fw-bold text-secondary">Belum ada permohonan masuk</h6>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($permohonan as $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-primary">#<?= esc($item['id_formulir']) ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['nama']) ?></div>
                                        <div class="small text-muted"><i class="fas fa-id-card me-1"></i> <?= esc($item['nik']) ?></div>
                                        <div class="small text-muted"><i class="fas fa-phone me-1"></i> <?= esc($item['no_telepon']) ?></div>
                                    </td>
                                    <td>
                                        <div class="text-wrap small" style="max-width: 300px;">
                                            <?= esc(substr($item['rincian_informasi'], 0, 100)) ?>...
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small"><?= date('d M Y H:i', strtotime($item['created_at'])) ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            $statusClass = 'bg-secondary';
                                            $statusText = ucfirst($item['status']);
                                            if($item['status'] == 'pending') $statusClass = 'bg-warning text-dark';
                                            if($item['status'] == 'diproses') $statusClass = 'bg-info text-dark';
                                            if($item['status'] == 'selesai') $statusClass = 'bg-success';
                                            if($item['status'] == 'ditolak') $statusClass = 'bg-danger';
                                        ?>
                                        <span class="badge rounded-pill <?= $statusClass ?> px-3">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/ppid_permohonan/<?= $item['id_formulir'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Proses / Detail">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/ppid_permohonan/<?= $item['id_formulir'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
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
<?= $this->endSection() ?>