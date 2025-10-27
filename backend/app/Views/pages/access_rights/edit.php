<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/access_rights/edit.css') ?>">
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="page-header-gov">
        <div>
            <h3>
                <i class="bi bi-pencil-square"></i>
                Edit Hak Akses
            </h3>
            <p>
                Modul: <strong><?= esc($access['module_name']) ?></strong> | 
                Role: <strong><?= esc($access['role']) ?></strong>
            </p>
        </div>
        <a href="/access_rights" class="btn btn-back-gov">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card form-card-gov">
        <div class="form-card-header">
            <i class="bi bi-gear-fill"></i>
            <span>Pengaturan Permission</span>
        </div>
        <div class="card-body p-4">
            <form action="/access_rights/update/<?= $access['id_access'] ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row gy-3">
                    <?php
                    $permissions = [
                        'can_create'  => ['label' => 'Create Access',  'icon' => 'bi-plus-circle-dotted'],
                        'can_read'    => ['label' => 'Read Access',    'icon' => 'bi-eye'],
                        'can_update'  => ['label' => 'Update Access',  'icon' => 'bi-pencil-fill'],
                        'can_delete'  => ['label' => 'Delete Access',  'icon' => 'bi-trash2-fill'],
                        'can_publish' => ['label' => 'Publish Access', 'icon' => 'bi-send-check-fill']
                    ];
                    foreach ($permissions as $key => $perm): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-check form-switch p-3">
                                <input class="form-check-input ms-0 me-3" 
                                       type="checkbox" 
                                       role="switch" 
                                       name="<?= $key ?>" 
                                       id="<?= $key ?>" 
                                       <?= $access[$key] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="<?= $key ?>">
                                    <i class="bi <?= $perm['icon'] ?> me-2"></i> <?= $perm['label'] ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 pt-4 border-top d-flex justify-content-end gap-2">
                    <a href="/access_rights" class="btn btn-cancel-gov">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-save-gov">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>