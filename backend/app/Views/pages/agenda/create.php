<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    :root {
        --primary-gov: #1e40af;
        --secondary-gov: #0c4a6e;
        --success-gov: #047857;
        --danger-gov: #be123c;
        --accent-gov: #fbbf24;
    }

    /* Page Header */
    .page-header-gov {
        background: linear-gradient(135deg, var(--success-gov) 0%, #065f46 100%);
        color: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(4, 120, 87, 0.15);
        margin-bottom: 30px;
        border-left: 6px solid var(--accent-gov);
    }

    .page-header-gov h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 8px 0;
        letter-spacing: -0.5px;
    }

    .page-header-gov h3 i {
        color: var(--accent-gov);
    }

    .page-header-gov p {
        margin: 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .btn-back-gov {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-back-gov:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateX(-4px);
        text-decoration: none;
    }

    /* Alert Danger */
    .alert-danger-gov {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: none;
        border-left: 5px solid var(--danger-gov);
        border-radius: 12px;
        padding: 20px 24px;
        box-shadow: 0 2px 12px rgba(190, 18, 60, 0.15);
        margin-bottom: 24px;
    }

    .alert-danger-gov ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-danger-gov li {
        color: #991b1b;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .alert-danger-gov li:last-child {
        margin-bottom: 0;
    }

    .alert-danger-gov::before {
        content: '\F33A';
        font-family: 'bootstrap-icons';
        font-size: 1.5rem;
        color: var(--danger-gov);
        float: left;
        margin-right: 12px;
    }

    /* Form Card */
    .form-card-gov {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: white;
        max-width: 1000px;
        margin: 0 auto;
    }

    .form-card-gov .card-body {
        padding: 40px;
    }

    /* Form Elements */
    .form-label-gov {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 10px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }

    .form-label-gov i {
        color: var(--success-gov);
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .form-label-gov .required {
        color: var(--danger-gov);
        margin-left: 4px;
    }

    .form-control-gov,
    .form-select-gov,
    .form-textarea-gov {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .form-control-gov:focus,
    .form-select-gov:focus,
    .form-textarea-gov:focus {
        border-color: var(--success-gov);
        box-shadow: 0 0 0 4px rgba(4, 120, 87, 0.1);
        background-color: white;
        outline: none;
    }

    .form-textarea-gov {
        min-height: 120px;
        resize: vertical;
    }

    .form-control-gov::placeholder,
    .form-textarea-gov::placeholder {
        color: #94a3b8;
    }

    /* Input Group with Icon */
    .input-group-gov {
        position: relative;
    }

    .input-group-gov .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 1.1rem;
        z-index: 5;
    }

    .input-group-gov .form-control-gov,
    .input-group-gov .form-select-gov {
        padding-left: 45px;
    }

    /* Form Text Helper */
    .form-text-gov {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
    }

    .form-text-gov i {
        margin-right: 6px;
        color: var(--success-gov);
    }

    /* Form Section */
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 30px 0 20px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #e2e8f0;
    }

    .form-section-title i {
        color: var(--success-gov);
        margin-right: 10px;
    }

    /* File Upload Custom */
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-wrapper:hover {
        border-color: var(--success-gov);
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    }

    .file-upload-wrapper.has-file {
        border-color: var(--success-gov);
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    }

    .file-upload-icon {
        font-size: 3rem;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .file-upload-wrapper:hover .file-upload-icon,
    .file-upload-wrapper.has-file .file-upload-icon {
        color: var(--success-gov);
    }

    .file-upload-text {
        color: #64748b;
        font-weight: 500;
    }

    .file-upload-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .file-preview {
        display: none;
        margin-top: 15px;
        text-align: center;
    }

    .file-preview.show {
        display: block;
    }

    .file-preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 10px;
    }

    .file-preview-name {
        color: var(--success-gov);
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Status Preview */
    .status-preview {
        margin-top: 12px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .status-preview.active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border: 2px solid #6ee7b7;
    }

    .status-preview.inactive {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #64748b;
        border: 2px solid #cbd5e1;
    }

    /* Buttons */
    .btn-submit-gov {
        background: linear-gradient(135deg, var(--success-gov) 0%, #065f46 100%);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(4, 120, 87, 0.25);
    }

    .btn-submit-gov:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(4, 120, 87, 0.35);
        background: linear-gradient(135deg, #065f46 0%, #064e3b 100%);
    }

    .btn-submit-gov i {
        margin-right: 8px;
    }

    .btn-cancel-gov {
        background: white;
        color: #64748b;
        border: 2px solid #e2e8f0;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-cancel-gov:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        color: #475569;
        text-decoration: none;
    }

    .btn-cancel-gov i {
        margin-right: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header-gov {
            padding: 20px;
        }

        .form-card-gov .card-body {
            padding: 24px;
        }

        .btn-submit-gov,
        .btn-cancel-gov {
            width: 100%;
            margin-top: 10px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-card-gov {
        animation: fadeInUp 0.5s ease-out;
    }

    .alert-danger-gov {
        animation: fadeInUp 0.4s ease-out;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header-gov">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="bi bi-calendar-plus me-2"></i>
                    Tambah Agenda Baru
                </h3>
                <p>Buat agenda kegiatan baru untuk sistem informasi</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= base_url('agenda') ?>" class="btn btn-back-gov">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Error Alert -->


    <!-- Form Card -->
    <div class="card form-card-gov">
        <div class="card-body">
            <form action="<?= base_url('agenda') ?>" method="post" enctype="multipart/form-data" id="agendaForm">
                
                <?= csrf_field() ?>

                <!-- Basic Information -->
                <div class="form-section-title">
                    <i class="bi bi-info-circle"></i>
                    Informasi Kegiatan
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="activity_name" class="form-label form-label-gov">
                            <i class="bi bi-calendar-event"></i>
                            Nama Kegiatan
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-card-text input-icon"></i>
                            <input type="text" 
                                   name="activity_name" 
                                   id="activity_name" 
                                   class="form-control form-control-gov" 
                                   placeholder="Contoh: Rapat Koordinasi Bulanan"
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Nama kegiatan yang akan dilaksanakan
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="description" class="form-label form-label-gov">
                            <i class="bi bi-file-text"></i>
                            Deskripsi Kegiatan
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control form-textarea-gov"
                                  placeholder="Jelaskan detail kegiatan, tujuan, dan agenda yang akan dibahas..."></textarea>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Berikan deskripsi lengkap tentang kegiatan
                        </div>
                    </div>
                </div>

                <!-- Date & Time -->
                <div class="form-section-title">
                    <i class="bi bi-clock-history"></i>
                    Waktu Pelaksanaan
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="start_date" class="form-label form-label-gov">
                            <i class="bi bi-calendar-check"></i>
                            Tanggal & Waktu Mulai
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-clock input-icon"></i>
                            <input type="datetime-local" 
                                   name="start_date" 
                                   id="start_date" 
                                   class="form-control form-control-gov" 
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Waktu dimulainya kegiatan
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="end_date" class="form-label form-label-gov">
                            <i class="bi bi-calendar-x"></i>
                            Tanggal & Waktu Selesai
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-clock input-icon"></i>
                            <input type="datetime-local" 
                                   name="end_date" 
                                   id="end_date" 
                                   class="form-control form-control-gov" 
                                   required>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Waktu berakhirnya kegiatan
                        </div>
                    </div>
                </div>

                <!-- Location & Status -->
                <div class="form-section-title">
                    <i class="bi bi-geo-alt"></i>
                    Lokasi & Status
                </div>

                <div class="row">
                    <div class="col-md-8 mb-4">
                        <label for="location" class="form-label form-label-gov">
                            <i class="bi bi-pin-map"></i>
                            Lokasi Kegiatan
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-geo-alt-fill input-icon"></i>
                            <input type="text" 
                                   name="location" 
                                   id="location" 
                                   class="form-control form-control-gov"
                                   placeholder="Contoh: Ruang Rapat Lt.3 Gedung A">
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Tempat pelaksanaan kegiatan
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="status" class="form-label form-label-gov">
                            <i class="bi bi-toggle-on"></i>
                            Status Agenda
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-circle input-icon"></i>
                            <select name="status" 
                                    id="status" 
                                    class="form-select form-select-gov">
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                            </select>
                        </div>
                        <div id="statusPreview" class="status-preview active">
                            ● Active - Agenda ditampilkan di sistem
                        </div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-section-title">
                    <i class="bi bi-image"></i>
                    Foto Agenda
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="form-label form-label-gov">
                            <i class="bi bi-card-image"></i>
                            Upload Foto Kegiatan
                        </label>
                        <div class="file-upload-wrapper" id="fileUploadWrapper">
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   class="file-upload-input" 
                                   accept="image/*">
                            <div class="file-upload-icon">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                            <div class="file-upload-text">
                                <strong>Click untuk upload</strong> atau drag & drop<br>
                                <small>Format: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                            <div class="file-preview" id="filePreview">
                                <img id="previewImage" class="file-preview-image" alt="Preview">
                                <div class="file-preview-name" id="fileName"></div>
                            </div>
                        </div>
                        <div class="form-text-gov">
                            <i class="bi bi-lightbulb"></i>
                            Foto akan ditampilkan sebagai thumbnail agenda
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-4 pt-3 border-top form-actions">
                    <a href="<?= base_url('agenda') ?>" class="btn btn-cancel-gov me-2">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-submit-gov">
                        <i class="bi bi-check-circle"></i>
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// File Upload Preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const wrapper = document.getElementById('fileUploadWrapper');
    const preview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    
    if (file) {
        // Check file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB');
            this.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            fileName.textContent = file.name;
            preview.classList.add('show');
            wrapper.classList.add('has-file');
        };
        reader.readAsDataURL(file);
    }
});

// Status Preview Toggle
document.getElementById('status').addEventListener('change', function(e) {
    const statusPreview = document.getElementById('statusPreview');
    const value = e.target.value;
    
    statusPreview.className = 'status-preview ' + value;
    
    if (value === 'active') {
        statusPreview.innerHTML = '● Active - Agenda ditampilkan di sistem';
    } else {
        statusPreview.innerHTML = '○ Inactive - Agenda disembunyikan dari sistem';
    }
});

// Date Validation
document.getElementById('agendaForm').addEventListener('submit', function(e) {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);
    
    if (endDate <= startDate) {
        e.preventDefault();
        alert('Tanggal selesai harus lebih besar dari tanggal mulai!');
        document.getElementById('end_date').focus();
        return false;
    }
});

// Auto-fill end date (1 hour after start date)
document.getElementById('start_date').addEventListener('change', function(e) {
    const startDate = new Date(e.target.value);
    if (startDate) {
        const endDate = new Date(startDate.getTime() + 60 * 60 * 1000); // +1 hour
        const endDateString = endDate.toISOString().slice(0, 16);
        document.getElementById('end_date').value = endDateString;
    }
});
</script>
<?= $this->endSection() ?>