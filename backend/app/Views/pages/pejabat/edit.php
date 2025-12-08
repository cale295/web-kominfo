<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Pejabat</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/pejabat">Pejabat</a></li>
        <li class="breadcrumb-item active">Edit Data</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-edit me-1"></i> Form Edit Pejabat
        </div>
        <div class="card-body">
            


            <!-- Perhatikan action URL mengarah ke ID spesifik -->
            <form action="<?= base_url('pejabat/' . $pejabat['id_pejabat']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <!-- Method Spoofing untuk PUT Request -->
                <input type="hidden" name="_method" value="PUT">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $pejabat['nama']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="<?= old('nip', $pejabat['nip']) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= old('jabatan', $pejabat['jabatan']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="urutan" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', $pejabat['urutan']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tempat_tanggal_lahir" class="form-label">Tempat, Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" value="<?= old('tempat_tanggal_lahir', $pejabat['tempat_tanggal_lahir']) ?>">
                </div>

                <div class="mb-3">
                    <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
                    <textarea class="form-control" id="alamat_kantor" name="alamat_kantor" rows="3"><?= old('alamat_kantor', $pejabat['alamat_kantor']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="form-label">Foto Saat Ini</label>
                        <div class="border p-2 text-center rounded">
                            <?php if ($pejabat['foto']) : ?>
                                <img src="<?= base_url('uploads/pejabat/' . $pejabat['foto']) ?>" class="img-fluid" style="max-height: 100px;">
                            <?php else : ?>
                                <span class="text-muted small">Tidak ada foto</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <label for="foto" class="form-label">Ganti Foto (Opsional)</label>
                        <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengganti foto.</div>
                    </div>
                </div>

        

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('pejabat') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>