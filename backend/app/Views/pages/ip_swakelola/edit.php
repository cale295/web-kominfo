<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit IP Swakelola</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/ip_swakelola">IP Swakelola</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit</h6>
        </div>
        <div class="card-body">
            <form action="/ip_swakelola/<?= $item['id'] ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">ID RUP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="id_rup" value="<?= old('id_rup', $item['id_rup']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jumlah Pagu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="jumlah_pagu" value="<?= old('jumlah_pagu', $item['jumlah_pagu']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Paket <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="nama_paket" rows="3" required><?= old('nama_paket', $item['nama_paket']) ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                    <a href="/ip_swakelola" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>