<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Profil Saya</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card p-4">
        <p><strong>Nama Lengkap:</strong> <?= esc($user['full_name']) ?></p>
        <p><strong>Username:</strong> <?= esc($user['username']) ?></p>
        <p><strong>Email:</strong> <?= esc($user['email']) ?></p>

<a href="<?= base_url('profile/' . $user['id_user'] . '/edit') ?>" class="btn btn-primary">Edit Profil</a>
        <a href="<?= base_url('profile/delete') ?>" onclick="return confirm('Yakin ingin menghapus akun ini?')" class="btn btn-danger">Hapus Akun</a>
    </div>
</div>

<?= $this->endSection() ?>
