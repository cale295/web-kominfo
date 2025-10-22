<!DOCTYPE html>
<html>
<head>
    <title>Detail User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Detail User</h4>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td><?= esc($user['id_user'] ?? '-') ?></td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td><?= esc($user['nama_lengkap']) ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= esc($user['username']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= esc($user['email']) ?></td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td><?= esc($user['role']) ?></td>
                </tr>
            </table>

            <a href="/manage_user" class="btn btn-secondary">Kembali</a>
            <a href="/manage_user/<?= esc($user['id_user']) ?>/edit" class="btn btn-warning">Edit</a>
            <form action="/manage_user/<?= esc($user['id_user']) ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
