<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<?php
// Daftar Icon FontAwesome Populer untuk opsi dropdown
$icons = [
    'fas fa-users' => 'Users / Orang',
    'fas fa-project-diagram' => 'Project / Diagram',
    'fas fa-award' => 'Award / Penghargaan',
    'fas fa-smile' => 'Smile / Klien Puas',
    'fas fa-coffee' => 'Coffee / Projek Selesai',
    'fas fa-check-circle' => 'Check Circle',
    'fas fa-chart-line' => 'Chart / Grafik',
    'fas fa-building' => 'Building / Gedung',
    'fas fa-briefcase' => 'Briefcase / Pekerjaan',
    'fas fa-code' => 'Code / Coding',
];
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Statistik</h1>
        <a href="<?= base_url('footer_statistics') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            
            <!-- Tampilkan Error Validasi -->
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('footer_statistics') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Stat Label -->
                    <div class="col-md-6 mb-3">
                        <label for="stat_label" class="form-label">Label Statistik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="stat_label" name="stat_label" value="<?= old('stat_label') ?>" placeholder="Contoh: Klien Puas" required>
                    </div>

                    <!-- Stat Value -->
                    <div class="col-md-6 mb-3">
                        <label for="stat_value" class="form-label">Nilai (Value) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="stat_value" name="stat_value" value="<?= old('stat_value') ?>" placeholder="Contoh: 150+" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Stat Type -->
                    <div class="col-md-6 mb-3">
                        <label for="stat_type" class="form-label">Tipe Statistik</label>
                        <select class="form-select form-control" id="stat_type" name="stat_type">
                            <option value="today_visitors" <?= old('stat_type') == 'today_visitors' ? 'selected' : '' ?>>Visitor (Hari Ini)</option>
                            <option value="online_visitors" <?= old('stat_type') == 'online_visitors' ? 'selected' : '' ?>>Online Visitor</option>
                            <option value="total_visitors" <?= old('stat_type') == 'total_visitors' ? 'selected' : '' ?>>Total Visitor</option>
                        </select>
                    </div>

                    <!-- Stat Icon (Dropdown) -->
                    <div class="col-md-6 mb-3">
                        <label for="stat_icon" class="form-label">Icon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-icons"></i></span>
                            <select class="form-select form-control" id="stat_icon" name="stat_icon" required>
                                <option value="" disabled selected>-- Pilih Icon --</option>
                                <?php foreach ($icons as $class => $name): ?>
                                    <option value="<?= $class ?>" <?= old('stat_icon') == $class ? 'selected' : '' ?>>
                                        <?= $name ?> (<?= $class ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <small class="text-muted">Pilih icon yang sesuai untuk ditampilkan di footer.</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Sorting -->
                    <div class="col-md-4 mb-3">
                        <label for="sorting" class="form-label">Urutan (Sorting)</label>
                        <input type="number" class="form-control" id="sorting" name="sorting" value="<?= old('sorting', 0) ?>">
                    </div>

                    <!-- Checkboxes -->
                    <div class="col-md-8 mb-3 d-flex align-items-center">
                        <div class="form-check me-4">
                            <input class="form-check-input" type="checkbox" id="auto_update" name="auto_update" value="1" <?= old('auto_update') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="auto_update">
                                Auto Update Count
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Aktifkan Data
                            </label>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>