<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    :root {
        --primary-blue: #1e40af;
        --secondary-blue: #1e3a8a;
        --accent-gold: #fbbf24;
        --light-gold: #fcd34d;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 8px 24px rgba(30, 64, 175, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
    }

    .page-header h3 {
        color: white;
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h3 i {
        color: var(--accent-gold);
        font-size: 2rem;
    }

    .page-header p {
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
        font-size: 0.95rem;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 12px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateX(-4px);
    }

    .btn-back i {
        font-size: 1.1rem;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: none;
        border-left: 4px solid #dc2626;
        border-radius: 12px;
        padding: 16px 20px;
        color: #991b1b;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.1);
        animation: slideInDown 0.4s ease-out;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-danger li {
        margin-bottom: 4px;
    }

    .alert-danger li:last-child {
        margin-bottom: 0;
    }

    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-body {
        padding: 40px;
    }

    .form-label {
        color: var(--primary-blue);
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label i {
        color: var(--accent-gold);
        font-size: 1.1rem;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 4px;
    }

    .form-control,
    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.1);
        background: white;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .form-text-helper {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-text-helper i {
        color: var(--accent-gold);
        font-size: 0.9rem;
    }

    /* Image Upload Styles */
    .image-preview-container {
        margin-bottom: 16px;
        padding: 16px;
        background: linear-gradient(135deg, rgba(30, 64, 175, 0.05) 0%, rgba(251, 191, 36, 0.05) 100%);
        border-radius: 12px;
        border: 2px dashed rgba(251, 191, 36, 0.3);
    }

    .current-image {
        position: relative;
        display: inline-block;
    }

    .current-image img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 3px solid var(--accent-gold);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    .image-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%);
        color: var(--primary-blue);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.4);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .no-image-placeholder {
        width: 200px;
        height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
        color: #94a3b8;
    }

    .no-image-placeholder i {
        font-size: 3rem;
        margin-bottom: 8px;
    }

    .no-image-placeholder span {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-input-custom {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input-custom input[type="file"] {
        position: absolute;
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        color: white;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(30, 64, 175, 0.3);
    }

    .file-input-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
    }

    .file-input-label i {
        font-size: 1.2rem;
    }

    .file-name-display {
        margin-top: 10px;
        padding: 10px 14px;
        background: rgba(30, 64, 175, 0.08);
        border-radius: 8px;
        color: var(--primary-blue);
        font-size: 0.9rem;
        display: none;
    }

    .file-name-display.show {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .file-name-display i {
        color: var(--accent-gold);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 14px 32px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(30, 64, 175, 0.3);
        transition: all 0.3s ease;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(251, 191, 36, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        color: white;
    }

    .btn-primary-custom:hover::before {
        left: 100%;
    }

    .btn-primary-custom i {
        font-size: 1.1rem;
    }

    .btn-secondary-custom {
        background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 14px 32px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(100, 116, 139, 0.3);
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-secondary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(100, 116, 139, 0.4);
        color: white;
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid #f1f5f9;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 24px;
        }

        .page-header h3 {
            font-size: 1.4rem;
        }

        .card-body {
            padding: 24px;
        }

        .current-image img,
        .no-image-placeholder {
            width: 150px;
            height: 150px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary-custom,
        .btn-secondary-custom {
            width: 100%;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="page-header-content">
                <h3>
                    <i class="bi bi-pencil-square"></i>
                    Edit Agenda Kegiatan
                </h3>
                <p>Perbarui informasi agenda kegiatan yang sudah ada</p>
            </div>
            <a href="<?= site_url('agenda') ?>" class="btn btn-back">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('agenda/' . $agenda['id_agenda']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <!-- Foto Agenda -->
                <div class="mb-4">
                    <label for="image" class="form-label">
                        <i class="bi bi-image"></i>
                        Foto Agenda
                    </label>
                    
                    <div class="image-preview-container">
                        <?php if (!empty($agenda['image'])): ?>
                            <div class="current-image">
                                <img src="<?= base_url('uploads/agenda/' . $agenda['image']) ?>" alt="Foto Agenda">
                                <div class="image-badge">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Foto Saat Ini
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                <i class="bi bi-image"></i>
                                <span>Belum ada foto</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="file-input-wrapper">
                        <div class="file-input-custom">
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/jpeg,image/png,image/jpg"
                                onchange="displayFileName(this)">
                            <label for="image" class="file-input-label">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Pilih Foto Baru (Opsional)</span>
                            </label>
                        </div>
                        <div class="file-name-display" id="fileNameDisplay">
                            <i class="bi bi-file-earmark-image"></i>
                            <span id="fileName"></span>
                        </div>
                    </div>

                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Format: JPG, JPEG, PNG | Max: 2MB | Kosongkan jika tidak ingin mengubah foto
                    </div>
                </div>

                <!-- Nama Kegiatan -->
                <div class="mb-4">
                    <label for="activity_name" class="form-label">
                        <i class="bi bi-calendar-event"></i>
                        Nama Kegiatan
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="activity_name" 
                        id="activity_name"
                        class="form-control"
                        value="<?= esc($agenda['activity_name']) ?>" 
                        placeholder="Contoh: Rapat Koordinasi Bulanan"
                        required>
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Masukkan nama kegiatan yang jelas dan deskriptif
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label for="description" class="form-label">
                        <i class="bi bi-text-paragraph"></i>
                        Deskripsi Kegiatan
                    </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="4"
                        class="form-control"
                        placeholder="Jelaskan detail kegiatan, tujuan, dan informasi penting lainnya..."><?= esc($agenda['description']) ?></textarea>
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Opsional - Tambahkan detail untuk informasi lebih lengkap
                    </div>
                </div>

                <!-- Row untuk Tanggal -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="start_date" class="form-label">
                                <i class="bi bi-calendar-check"></i>
                                Tanggal & Waktu Mulai
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="datetime-local" 
                                name="start_date" 
                                id="start_date"
                                value="<?= date('Y-m-d\TH:i', strtotime($agenda['start_date'])) ?>"
                                class="form-control" 
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="end_date" class="form-label">
                                <i class="bi bi-calendar-x"></i>
                                Tanggal & Waktu Selesai
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="datetime-local" 
                                name="end_date" 
                                id="end_date"
                                value="<?= date('Y-m-d\TH:i', strtotime($agenda['end_date'])) ?>"
                                class="form-control" 
                                required>
                        </div>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="mb-4">
                    <label for="location" class="form-label">
                        <i class="bi bi-geo-alt-fill"></i>
                        Lokasi Kegiatan
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="location" 
                        id="location"
                        class="form-control"
                        value="<?= esc($agenda['location']) ?>" 
                        placeholder="Contoh: Aula Kantor Pemerintahan"
                        required>
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Sebutkan tempat atau alamat lengkap lokasi kegiatan
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="form-label">
                        <i class="bi bi-toggle-on"></i>
                        Status Kegiatan
                        <span class="required">*</span>
                    </label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="active" <?= $agenda['status'] === 'active' ? 'selected' : '' ?>>
                            ✓ Active - Kegiatan Aktif
                        </option>
                        <option value="inactive" <?= $agenda['status'] === 'inactive' ? 'selected' : '' ?>>
                            ✗ Inactive - Kegiatan Tidak Aktif
                        </option>
                    </select>
                    <div class="form-text-helper">
                        <i class="bi bi-info-circle"></i>
                        Status "Active" akan menampilkan kegiatan di halaman publik
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                    </button>
                    <a href="<?= site_url('agenda') ?>" class="btn btn-secondary-custom">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function displayFileName(input) {
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileName = document.getElementById('fileName');
    
    if (input.files && input.files[0]) {
        fileName.textContent = input.files[0].name;
        fileNameDisplay.classList.add('show');
    } else {
        fileNameDisplay.classList.remove('show');
    }
}

// Validasi tanggal selesai harus lebih besar dari tanggal mulai
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    
    if (startDate && endDate) {
        startDate.addEventListener('change', function() {
            endDate.min = this.value;
        });
        
        endDate.addEventListener('change', function() {
            if (this.value && startDate.value && this.value < startDate.value) {
                alert('Tanggal selesai harus lebih besar dari tanggal mulai!');
                this.value = '';
            }
        });
    }
});
</script>

<?= $this->endSection() ?>