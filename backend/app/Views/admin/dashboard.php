<!DOCTYPE html>
<html>
<head>
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2>Selamat Datang, <?= esc($username) ?> 👋</h2>
            <p>Role Anda: <strong><?= esc($role) ?></strong></p>

            <hr>

            <h4>Menu Dashboard</h4>
            <ul>
                <li><a href="<?= base_url('admin/barang') ?>">Kelola Barang</a></li>
                <li><a href="<?= base_url('admin/transaksi') ?>">Lihat Transaksi</a></li>
                <li><a href="<?= base_url('admin/laporan') ?>">Laporan</a></li>
            </ul>

            <a href="<?= base_url('logout') ?>" class="btn btn-danger mt-3">Logout</a>
        </div>
    </div>
</body>
</html>
