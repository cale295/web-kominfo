<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3><?= esc($title) ?></h3>

<!-- Alert -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Card Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="bi bi-shield-lock-fill me-2 fs-5"></i>
        <span class="fw-semibold">Daftar Hak Akses</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle table-striped table-hover mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th scope="col">Role</th>
                        <th scope="col">Module</th>
                        <th scope="col">Create</th>
                        <th scope="col">Read</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Publish</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php if (empty($accessList)): ?>
                        <tr>
                            <td colspan="8" class="text-muted py-4">
                                <i class="bi bi-inbox me-2 fs-5"></i> Belum ada data akses.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($accessList as $a): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($a['role']) ?></td>
                                <td><?= esc($a['module_name']) ?></td>
                                <td><?= $a['can_create'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                                <td><?= $a['can_read'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                                <td><?= $a['can_update'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                                <td><?= $a['can_delete'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                                <td><?= $a['can_publish'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                                <td>
                                    <a href="/access_rights/edit/<?= $a['id_access'] ?>" class="btn btn-outline-primary btn-sm rounded-pill">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>