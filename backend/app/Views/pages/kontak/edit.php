<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Kontak</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Kontak</h6>
        </div>
        <div class="card-body">
            
            <?php if (session()->has('errors')) : ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <!-- Perhatikan action URL dan method spoofing -->
            <form action="/kontak/<?= $kontak['id_kontak'] ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT"> 

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama Instansi</label>
                        <input type="text" class="form-control" name="nama_instansi" value="<?= old('nama_instansi', $kontak['nama_instansi']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea class="form-control" name="alamat_lengkap" rows="3"><?= old('alamat_lengkap', $kontak['alamat_lengkap']) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Telepon</label>
                        <input type="text" class="form-control" name="telepon" value="<?= old('telepon', $kontak['telepon']) ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Fax</label>
                        <input type="text" class="form-control" name="fax" value="<?= old('fax', $kontak['fax']) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Link Google Maps</label>
                        <input type="text" class="form-control" name="map_link" value="<?= old('map_link', $kontak['map_link']) ?>">
                    </div>
                </div>

<div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="aktif" <?= old('status', $kontak['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
        
        <option value="nonaktif" <?= old('status', $kontak['status']) == 'nonaktif' ? 'selected' : '' ?>>Tidak Aktif</option>
    </select>
</div>
                <hr>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/kontak" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>