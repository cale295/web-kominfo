<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">📜 Log Berita: <?= esc($berita['judul']) ?></h3>
        <a href="<?= site_url('berita') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <?php if (!empty($logs)): ?>
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Note Perbaikan</th>
                            <th>Note Revisi</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $index => $log): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($log['user_name']) ?></td>
                                <td><?= esc($log['keterangan']) ?></td>
                                <td><?= esc($log['status']) ?></td>
                                <td><?= esc($log['note_perbaikan']) ?></td>
                                <td><?= esc($log['note_revisi']) ?></td>
                                <td><?= date('d M Y H:i', strtotime($log['created_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center text-muted py-4">Belum ada log untuk berita ini.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
