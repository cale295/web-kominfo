<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Edit Profil</h3>

<form action="<?= base_url('profile/' . $user['id_user']) ?>" method="post">
    <input type="hidden" name="_method" value="PUT">
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="full_name" class="form-control" value="<?= esc($user['full_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak ingin ubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?= base_url('profile') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
