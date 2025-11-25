<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Program</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/program">Program</a></li>
        <li class="breadcrumb-item active">Edit Data</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Form Edit Program
        </div>
        <div class="card-body">
            
            <?php if (session()->has('errors')) : ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <!-- Action URL ke ID Program spesifik -->
            <form action="<?= base_url('program/' . $program['id_program']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <!-- Method Spoofing PUT -->
                <input type="hidden" name="_method" value="PUT">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_program" class="form-label">Nama Program</label>
                        <input type="text" class="form-control" id="nama_program" name="nama_program" value="<?= old('nama_program', $program['nama_program']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?= old('nama_kegiatan', $program['nama_kegiatan']) ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nilai_anggaran" class="form-label">Nilai Anggaran (Rp)</label>
                        <input type="number" class="form-control" id="nilai_anggaran" name="nilai_anggaran" value="<?= old('nilai_anggaran', $program['nilai_anggaran']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="tahun" class="form-label">Tahun Anggaran</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" value="<?= old('tahun', $program['tahun']) ?>" min="2000" max="2099">
                    </div>
                    <div class="col-md-4">
                        <label for="sorting" class="form-label">Urutan Tampil</label>
                        <input type="number" class="form-control" id="sorting" name="sorting" value="<?= old('sorting', $program['sorting']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file_lampiran" class="form-label">Ganti File Lampiran (Opsional)</label>
                    <input class="form-control" type="file" id="file_lampiran" name="file_lampiran">
                    
                    <div class="mt-2">
                        <span class="text-muted small">File saat ini:</span>
                        <?php if (!empty($program['file_lampiran'])) : ?>
                            <a href="<?= base_url($program['file_lampiran']) ?>" target="_blank" class="text-decoration-none">
                                <i class="fas fa-file-alt"></i> Lihat File
                            </a>
                        <?php else : ?>
                            <span class="text-muted small">- Tidak ada file -</span>
                        <?php endif; ?>
                    </div>
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah file lampiran.</div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?= old('is_active', $program['is_active']) == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_active">Status Aktif</label>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('program') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>