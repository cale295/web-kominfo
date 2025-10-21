<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i>Detail User</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="text-center mb-3">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" 
                                         style="width: 120px; height: 120px;">
                                        <i class="bi bi-person-fill" style="font-size: 4rem; color: #6c757d;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="35%" class="fw-bold text-muted">ID User</td>
                                        <td width="5%">:</td>
                                        <td><?= esc($user['id']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Nama Lengkap</td>
                                        <td>:</td>
                                        <td class="fs-5 fw-bold"><?= esc($user['nama_lengkap']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Username</td>
                                        <td>:</td>
                                        <td><?= esc($user['username']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Email</td>
                                        <td>:</td>
                                        <td>
                                            <i class="bi bi-envelope me-1"></i>
                                            <a href="mailto:<?= esc($user['email']) ?>"><?= esc($user['email']) ?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Role</td>
                                        <td>:</td>
                                        <td>
                                            <?php if ($user['role'] == 'admin'): ?>
                                                <span class="badge bg-danger fs-6">
                                                    <i class="bi bi-shield-fill-check me-1"></i>Admin
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-info fs-6">
                                                    <i class="bi bi-person-fill me-1"></i>User
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php if (isset($user['created_at'])): ?>
                                    <tr>
                                        <td class="fw-bold text-muted">Dibuat Pada</td>
                                        <td>:</td>
                                        <td>
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <?= date('d M Y H:i', strtotime($user['created_at'])) ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if (isset($user['updated_at'])): ?>
                                    <tr>
                                        <td class="fw-bold text-muted">Diupdate Pada</td>
                                        <td>:</td>
                                        <td>
                                            <i class="bi bi-calendar-check me-1"></i>
                                            <?= date('d M Y H:i', strtotime($user['updated_at'])) ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('user') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                            <div>
                                <a href="<?= base_url('user/' . $user['id'] . '/edit') ?>" class="btn btn-warning me-2">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <button type="button" 
                                        class="btn btn-danger" 
                                        onclick="confirmDelete(<?= $user['id'] ?>)">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Delete (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="DELETE">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmDelete(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini?\n\nNama: <?= esc($user['nama_lengkap']) ?>\nUsername: <?= esc($user['username']) ?>')) {
            const form = document.getElementById('deleteForm');
            form.action = '<?= base_url('user') ?>/' + userId;
            form.submit();
        }
    }
    </script>
</body>
</html>