<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Daftar Agenda</h3>
        <a href="<?= site_url('agenda/new') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Tambah Agenda
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Kegiatan</th>
                        <th>Lokasi</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Aksi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($agendas)): ?>
                        <?php foreach ($agendas as $i => $agenda): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td>
                                    <?php if (!empty($agenda['image'])): ?>
                                        <img src="<?= base_url('uploads/agenda/' . $agenda['image']) ?>" width="60" class="rounded">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($agenda['activity_name']) ?></td>
                                <td><?= esc($agenda['location']) ?></td>
                                <td><?= date('d M Y H:i', strtotime($agenda['start_date'])) ?></td>
                                <td><?= date('d M Y H:i', strtotime($agenda['end_date'])) ?></td>
                                <td>
                                    <a href="<?= site_url('agenda/' . $agenda['id_agenda'].'/edit') ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('agenda/delete/' . $agenda['id_agenda']) ?>" class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus agenda ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                                <td>
                                    <?php if ($agenda['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">Belum ada agenda.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
