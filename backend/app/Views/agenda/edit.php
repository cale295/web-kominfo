<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Edit Agenda</h3>
            <p class="text-muted mb-0">Perbarui data kegiatan.</p>
        </div>
        <a href="<?= site_url('agenda') ?>" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="<?= site_url('agenda/' . $agenda['id_agenda']) ?>" method="post">
                <?= csrf_field() ?>
                <!-- Tambahkan baris ini agar request dikenali sebagai PUT -->
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="activity_name" class="form-label">Nama Kegiatan</label>
                    <input type="text" name="activity_name" id="activity_name"
                           class="form-control"
                           value="<?= esc($agenda['activity_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              class="form-control"><?= esc($agenda['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="datetime-local" name="start_date" id="start_date"
                           value="<?= date('Y-m-d\TH:i', strtotime($agenda['start_date'])) ?>"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="datetime-local" name="end_date" id="end_date"
                           value="<?= date('Y-m-d\TH:i', strtotime($agenda['end_date'])) ?>"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" name="location" id="location"
                           class="form-control"
                           value="<?= esc($agenda['location']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="active" <?= $agenda['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $agenda['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Perbarui
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
