<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Pejabat</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/pejabat">Pejabat</a></li>
        <li class="breadcrumb-item active">Tambah Baru</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-1"></i> Form Tambah Pejabat
        </div>
        <div class="card-body">
            <!-- Tampilkan Error Validasi Global -->
            <?php if (session()->has('errors')) : ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="<?= base_url('pejabat') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="<?= old('nip') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= old('jabatan') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="urutan" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', 1) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tempat_tanggal_lahir" class="form-label">Tempat, Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" value="<?= old('tempat_tanggal_lahir') ?>" placeholder="Contoh: Jakarta, 17 Agustus 1980">
                </div>

                <div class="mb-3">
                    <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
                    <textarea class="form-control" id="alamat_kantor" name="alamat_kantor" rows="3"><?= old('alamat_kantor') ?></textarea>
                </div>

                <!-- BAGIAN FOTO DENGAN PREVIEW -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto Pejabat</label>
                    
                    <div class="col-sm-2 mb-2">
                        <!-- Image Preview: Awalnya hidden (d-none) -->
                        <img src="" class="img-thumbnail img-preview d-none" style="max-height: 200px; width: auto; object-fit: cover;">
                    </div>

                    <!-- Input File dengan event onchange -->
                    <input class="form-control" type="file" id="foto" name="foto" accept="image/*" onchange="previewImg()">
                    <div class="form-text">Format: JPG, PNG, JPEG. Maksimal 2MB.</div>
                </div>
                <!-- AKHIR BAGIAN FOTO -->

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= old('is_active') ? 'checked' : 'checked' ?>>
                    <label class="form-check-label" for="is_active">Aktifkan Pejabat ini?</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('pejabat') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT JAVASCRIPT UNTUK PREVIEW -->
<script>
    function previewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        // Cek apakah user memilih file
        if (foto.files && foto.files[0]) {
            const fileFoto = new FileReader();
            
            // Ambil URL file yang diupload
            fileFoto.readAsDataURL(foto.files[0]);

            // Ketika file selesai di-load browser
            fileFoto.onload = function(e) {
                imgPreview.src = e.target.result; // Ganti src gambar
                imgPreview.classList.remove('d-none'); // Tampilkan gambar (hapus class hidden)
            }
        } else {
            // Jika user membatalkan pilihan (cancel), sembunyikan lagi gambar
            imgPreview.src = "";
            imgPreview.classList.add('d-none');
        }
    }
</script>
<?= $this->endSection() ?>