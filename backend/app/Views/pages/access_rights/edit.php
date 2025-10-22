<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Hak Akses: <?= esc($access['module_name']) ?> (<?= esc($access['role']) ?>)</h3>

<form action="/access_rights/update/<?= $access['id_access'] ?>" method="post" class="mt-3">
    <input type="hidden" name="_method" value="PUT">
    
    <?php 
    $permissions = ['can_create'=>'Create','can_read'=>'Read','can_update'=>'Update','can_delete'=>'Delete','can_publish'=>'Publish'];
    foreach ($permissions as $key => $label): ?>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="<?= $key ?>" <?= $access[$key] ? 'checked' : '' ?>>
        <label class="form-check-label"><?= $label ?></label>
    </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-success mt-3">Simpan</button>
    <a href="/access_rights" class="btn btn-secondary mt-3">Kembali</a>
</form>
<?= $this->endSection() ?>