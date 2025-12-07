<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Proses Permohonan #<?= $item['id_formulir'] ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/ppid_permohonan">PPID</a></li>
        <li class="breadcrumb-item active">Proses</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>

    <div class="row">
        <!-- Kolom Kiri: Detail Pemohon (Read Only) -->
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-user me-2"></i>Data Pemohon</h6>
                </div>
                <div class="card-body bg-light">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">NIK</label>
                            <input type="text" class="form-control" value="<?= esc($item['nik']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control" value="<?= esc($item['nama']) ?>" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Email</label>
                            <input type="text" class="form-control" value="<?= esc($item['email']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">No Telepon</label>
                            <input type="text" class="form-control" value="<?= esc($item['no_telepon']) ?>" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Alamat</label>
                        <textarea class="form-control" rows="2" readonly><?= esc($item['alamat']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Pekerjaan</label>
                        <input type="text" class="form-control" value="<?= esc($item['pekerjaan']) ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-file-alt me-2"></i>Rincian Permohonan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Rincian Informasi yang Dibutuhkan</label>
                        <div class="p-3 border rounded bg-light">
                            <?= nl2br(esc($item['rincian_informasi'])) ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Tujuan Penggunaan Informasi</label>
                        <div class="p-3 border rounded bg-light">
                            <?= nl2br(esc($item['tujuan_penggunaan'])) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Kategori Pemohon</label>
                            <input type="text" class="form-control form-control-sm" value="<?= esc($item['pemohon_informasi']) ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Cara Memperoleh</label>
                            <input type="text" class="form-control form-control-sm" value="<?= esc($item['cara_memperoleh_informasi']) ?>" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Cara Salinan</label>
                            <input type="text" class="form-control form-control-sm" value="<?= esc($item['cara_mendapatkan_salinan']) ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Update Status (Admin Only) -->
        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm border-0 border-top border-4 border-primary">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-cog me-2"></i>Tindak Lanjut</h6>
                </div>
                <div class="card-body">
                    <form action="/ppid_permohonan/<?= $item['id_formulir'] ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">Update Status Permohonan</label>
                            <select class="form-select form-select-lg" name="status" id="status">
                                <option value="pending" <?= $item['status'] == 'pending' ? 'selected' : '' ?>>⏳ Pending (Menunggu)</option>
                                <option value="diproses" <?= $item['status'] == 'diproses' ? 'selected' : '' ?>>⚙️ Diproses</option>
                                <option value="selesai" <?= $item['status'] == 'selesai' ? 'selected' : '' ?>>✅ Selesai / Diberikan</option>
                                <option value="ditolak" <?= $item['status'] == 'ditolak' ? 'selected' : '' ?>>❌ Ditolak</option>
                            </select>
                            <div class="form-text mt-2">
                                Mengubah status menjadi 'Diproses', 'Selesai', atau 'Ditolak' akan memperbarui tanggal proses secara otomatis.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                            <a href="/ppid_permohonan" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        Diajukan pada: <br>
                        <strong><?= date('d F Y, H:i', strtotime($item['created_at'])) ?></strong>
                    </small>
                    <?php if($item['tanggal_diproses']): ?>
                    <hr class="my-2">
                    <small class="text-muted">
                        Terakhir diproses: <br>
                        <strong><?= date('d F Y, H:i', strtotime($item['tanggal_diproses'])) ?></strong>
                    </small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>