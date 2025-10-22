<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3><?= esc($title) ?></h3>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<table class="table table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th>Role</th>
            <th>Module</th>
            <th>Create</th>
            <th>Read</th>
            <th>Update</th>
            <th>Delete</th>
            <th>Publish</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accessList as $a): ?>
        <tr>
            <td><?= esc($a['role']) ?></td>
            <td><?= esc($a['module_name']) ?></td>
            <td><?= $a['can_create'] ? '✅' : '❌' ?></td>
            <td><?= $a['can_read'] ? '✅' : '❌' ?></td>
            <td><?= $a['can_update'] ? '✅' : '❌' ?></td>
            <td><?= $a['can_delete'] ? '✅' : '❌' ?></td>
            <td><?= $a['can_publish'] ? '✅' : '❌' ?></td>
            <td><a href="/access_rights/edit/<?= $a['id_access'] ?>" class="btn btn-sm btn-primary">Edit</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>