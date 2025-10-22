<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4"> <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Edit Hak Akses</h3>
            <p class="text-muted mb-0"> Modul: <strong><?= esc($access['module_name']) ?></strong> | Role: <strong><?= esc($access['role']) ?></strong> </p>
        </div> <a href="/access_rights" class="btn btn-outline-secondary"> <i class="bi bi-arrow-left"></i> Kembali </a>

    </div>
    <!-- Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-gear-fill me-2 fs-5"></i>
            <span class="fw-semibold">Pengaturan Hak Akses</span>
        </div>
        <div class="card-body">
            <form action="/access_rights/update/<?= $access['id_access'] ?>" method="post" class="mt-2">
                <input type="hidden" name="_method" value="PUT">

                <div class="row gy-3">
                    <?php
                    $permissions = [
                        'can_create'  => ['label' => 'Create',  'icon' => 'bi-plus-circle'],
                        'can_read'    => ['label' => 'Read',    'icon' => 'bi-eye'],
                        'can_update'  => ['label' => 'Update',  'icon' => 'bi-pencil-square'],
                        'can_delete'  => ['label' => 'Delete',  'icon' => 'bi-trash'],
                        'can_publish' => ['label' => 'Publish', 'icon' => 'bi-send']
                    ];
                    foreach ($permissions as $key => $perm): ?>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    name="<?= $key ?>"
                                    id="<?= $key ?>"
                                    <?= $access[$key] ? 'checked' : '' ?>>
                                <label class="form-check-label fw-semibold" for="<?= $key ?>">
                                    <i class="bi <?= $perm['icon'] ?> me-1 text-primary"></i> <?= $perm['label'] ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                    <a href="/access_rights" class="btn btn-secondary px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?= $this->endSection() ?>