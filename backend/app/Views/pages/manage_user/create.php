<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah User Baru</h4>
                </div>
                <div class="card-body">

                    <!-- Tampilkan pesan error jika ada -->
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('manage_user') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="full_name" id="full_name" class="form-control" value="<?= old('full_name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="superadmin" <?= old('role') == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="editor" <?= old('role') == 'editor' ? 'selected' : '' ?>>Editor</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('manage_user') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
