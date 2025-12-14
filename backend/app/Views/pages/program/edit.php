<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-color: #2c3e50;
        --accent-color: #f6c23e; /* Warna Kuning/Emas */
        --accent-hover: #dfb137;
    }

    /* Header Styling */
    .page-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border-left: 5px solid var(--accent-color);
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Form Card */
    .form-card {
        background: white;
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 4px rgba(246, 194, 62, 0.2);
    }

    /* Input Group Text (Rp, dll) */
    .input-group-text {
        background-color: #fffcf0;
        border-color: #dee2e6;
        color: #856404;
        font-weight: 600;
    }

    /* Document Preview Area */
    .doc-preview-card {
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
    }

    .doc-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 0.5rem;
    }

    .doc-preview-card.has-file {
        background-color: #fff3cd; /* Kuning muda jika ada file */
        border-color: var(--accent-color);
        border-style: solid;
    }
    
    .doc-preview-card.has-file .doc-icon {
        color: #856404;
    }

    /* Toggle Switch Custom */
    .form-check-input:checked {
        background-color: #27ae60; /* Hijau saat aktif */
        border-color: #27ae60;
    }

    /* Buttons */
    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        background-color: #1a252f;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background-color: transparent;
        color: #7f8c8d;
        padding: 0.8rem 1.5rem;
        border: 1px solid transparent;
        font-weight: 500;
    }
    .btn-cancel:hover {
        color: var(--primary-color);
        background-color: #ecf0f1;
        border-radius: 8px;
    }
</style>

<div class="container-fluid px-4 py-4">

    <div class="page-header">
        <div>
            <h3 class="m-0 fw-bold" style="color: var(--primary-color);">
                <i class="bi bi-pencil-square me-2" style="color: var(--accent-color);"></i>Edit Program
            </h3>
            <p class="text-muted m-0 mt-1">Perbarui detail program, anggaran, atau lampiran.</p>
        </div>
        <a href="<?= base_url('program') ?>" class="btn btn-light border shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('program/' . $program['id_program']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card form-card h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-4 text-muted border-bottom pb-2">Informasi Program</h5>

                        <div class="mb-3">
                            <label for="nama_program" class="form-label">Nama Program <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control form-control-lg fs-6" 
                                   id="nama_program" 
                                   name="nama_program" 
                                   value="<?= old('nama_program', $program['nama_program']) ?>" 
                                   placeholder="Contoh: Program Peningkatan Sarana..."
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" 
                                      id="nama_kegiatan" 
                                      name="nama_kegiatan" 
                                      rows="3" 
                                      required><?= old('nama_kegiatan', $program['nama_kegiatan']) ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nilai_anggaran" class="form-label">Nilai Anggaran</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control" 
                                           id="nilai_anggaran" 
                                           name="nilai_anggaran" 
                                           value="<?= old('nilai_anggaran', $program['nilai_anggaran']) ?>"
                                           placeholder="0">
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" 
                                       class="form-control text-center" 
                                       id="tahun" 
                                       name="tahun" 
                                       value="<?= old('tahun', $program['tahun']) ?>" 
                                       min="2000" max="2099">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="sorting" class="form-label">Urutan</label>
                                <input type="number" 
                                       class="form-control text-center" 
                                       id="sorting" 
                                       name="sorting" 
                                       value="<?= old('sorting', $program['sorting']) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="card form-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3 text-muted border-bottom pb-2">Status Publikasi</h5>
                        
                        <div class="form-check form-switch d-flex align-items-center justify-content-between ps-0">
                            <label class="form-check-label fw-bold" for="is_active">Aktifkan Program?</label>
                            <input class="form-check-input ms-3" 
                                   type="checkbox" 
                                   style="width: 3em; height: 1.5em;"
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   <?= old('is_active', $program['is_active']) == 1 ? 'checked' : '' ?>>
                        </div>
                        <div class="form-text mt-2">Jika non-aktif, program tidak akan muncul di halaman publik.</div>
                    </div>
                </div>

               

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-submit shadow">
                        <i class="bi bi-save me-2"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('program') ?>" class="btn btn-cancel text-center">Batalkan</a>
                </div>

            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>