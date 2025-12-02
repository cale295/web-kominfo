<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<?php
// Daftar Icon FontAwesome Populer untuk opsi dropdown

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