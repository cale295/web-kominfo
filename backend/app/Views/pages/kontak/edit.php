<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Kontak</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/kontak">Kontak</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit</h6>
        </div>
        <div class="card-body">
            <form action="/kontak/<?= $item['id_kontak'] ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_instansi" value="<?= old('nama_instansi', $item['nama_instansi']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat_lengkap" rows="4" required><?= old('alamat_lengkap', $item['alamat_lengkap']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link Google Maps <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt text-danger"></i></span>
                                <input type="url" class="form-control" name="map_link" value="<?= old('map_link', $item['map_link']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-5">
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-3">Kontak Hubung</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="telepon" value="<?= old('telepon', $item['telepon']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Nomor Fax <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="fax" value="<?= old('fax', $item['fax']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 pt-2">
                            <label class="form-label fw-bold">Status Publikasi</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="status" value="nonaktif">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="aktif" <?= old('status', $item['status']) == 'aktif' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="status">Tampilkan Kontak (Aktif)</label>
                            </div>
                        </div>
                        
                        <div class="text-muted small mt-3">
                            Terakhir diupdate: <br>
                            <strong><?= date('d M Y, H:i', strtotime($item['updated_at'])) ?></strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/kontak" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>