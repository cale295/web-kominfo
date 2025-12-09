<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<style>
    :root {
        --primary-soft: #eef2ff;
        --primary-text: #4f46e5;
        --success-soft: #ecfdf5;
        --success-text: #059669;
        --danger-soft: #fef2f2;
        --danger-text: #dc2626;
        --warning-soft: #fffbeb;
        --warning-text: #d97706;
        --info-soft: #eff6ff;
        --info-text: #3b82f6;
    }

    /* Gradient Title */
    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Modern Card */
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
        overflow: hidden;
    }

    /* Soft Badges & Buttons */
    .btn-soft-primary { background-color: var(--primary-soft); color: var(--primary-text); border: none; }
    .btn-soft-primary:hover { background-color: #4f46e5; color: white; }
    
    .btn-soft-danger { background-color: var(--danger-soft); color: var(--danger-text); border: none; }
    .btn-soft-danger:hover { background-color: #dc2626; color: white; }

    /* Image Hover Effect */
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        display: block;
        border-radius: 0.5rem;
        overflow: hidden;
        position: relative;
    }
    .img-hover-zoom:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        z-index: 10;
    }
    .img-hover-zoom img {
        transition: transform 0.3s ease;
    }

    /* Table Styling */
    .table thead th {
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 2px solid #f3f4f6;
        background-color: #f9fafb;
        text-transform: uppercase;
    }
    .table tbody tr td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
        font-size: 0.9rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Date Box Styling */
    .date-box {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    .date-box .date { font-weight: 600; color: #1f2937; }
    .date-box .time { font-size: 0.75rem; color: #6b7280; display: flex; align-items: center; margin-top: 4px; }
    
    /* Icon Box */
    .icon-box-sm {
        width: 24px; height: 24px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 6px; margin-right: 6px; font-size: 0.75rem;
    }

    /* Modal Styles */
    .image-modal {
        display: none; position: fixed; z-index: 9999;
        left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(5px);
        animation: fadeIn 0.3s ease;
    }
    .image-modal.show { display: flex; align-items: center; justify-content: center; }
    .image-modal-content {
        max-width: 90%; max-height: 85%;
        object-fit: contain; border-radius: 8px;
        box-shadow: 0 0 30px rgba(0,0,0,0.5);
        animation: zoomIn 0.3s ease;
    }
    .image-modal-close {
        position: absolute; top: 25px; right: 25px;
        color: white; font-size: 24px; cursor: pointer;
        background: rgba(255,255,255,0.2);
        width: 45px; height: 45px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .image-modal-close:hover { background: rgba(255,255,255,0.4); transform: rotate(90deg); }
    .image-modal-close::before { content: "\F62A"; font-family: "bootstrap-icons"; } /* X icon */
    
    .image-modal-title {
        position: absolute; bottom: 30px;
        background: rgba(0,0,0,0.7); color: white;
        padding: 8px 20px; border-radius: 20px;
        font-size: 0.9rem; letter-spacing: 0.5px;
    }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes zoomIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">Agenda Kegiatan</h1>
            <p class="text-muted small mb-0">
                <i class="bi bi-calendar-event me-1 text-primary"></i> 
                Kelola jadwal kegiatan, lokasi, dan dokumentasi agenda pemerintah.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="bi bi-house-door"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Agenda</li>
            </ol>
        </nav>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm border-start border-4 border-success rounded-3 fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-white text-success me-3 shadow-sm rounded-circle" style="width: 32px; height: 32px;">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="fw-medium">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    <?= $this->include('layouts/alerts') ?>

    <div class="card card-modern">
        <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-0">Jadwal Agenda</h5>
                <span class="text-muted small">Daftar kegiatan yang akan datang dan terlaksana</span>
            </div>
            
            <a href="<?= site_url('agenda/new') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold mt-3 mt-md-0 hover-scale">
                <i class="bi bi-plus-circle me-2"></i>Tambah Agenda
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="text-center py-3" width="10%">Dokumentasi</th>
                            <th class="py-3" width="20%">Nama Kegiatan</th>
                            <th class="py-3" width="20%">Lokasi & Deskripsi</th>
                            <th class="py-3" width="15%">Mulai</th>
                            <th class="py-3" width="15%">Selesai</th>
                            <th class="text-center py-3" width="5%">Status</th>
                            <th class="text-center py-3" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($agendas)): ?>
                            <?php foreach ($agendas as $i => $agenda): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= $i + 1 ?></td>
                                    
                                    <td class="text-center">
                                        <?php if (!empty($agenda['image'])): ?>
                                            <div class="img-hover-zoom shadow-sm border mx-auto" style="width: 70px; height: 70px;">
                                                <img src="<?= base_url('uploads/agenda/' . $agenda['image']) ?>" 
                                                     alt="Foto Agenda" 
                                                     style="width: 100%; height: 100%; object-fit: cover;"
                                                     onclick="openImageModal(this.src, '<?= esc($agenda['activity_name']) ?>')">
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light border rounded d-flex flex-column align-items-center justify-content-center text-muted small mx-auto" style="width: 70px; height: 70px;">
                                                <i class="bi bi-image mb-1 opacity-50" style="font-size: 1.2rem;"></i>
                                                <span style="font-size: 0.6rem">No Img</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark mb-1 text-wrap" style="min-width: 150px;">
                                            <?= esc($agenda['activity_name']) ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="icon-box-sm bg-light text-danger border shadow-sm">
                                                <i class="bi bi-geo-alt-fill"></i>
                                            </span>
                                            <span class="small fw-semibold text-dark"><?= esc($agenda['location']) ?></span>
                                        </div>
                                        <div class="small text-muted text-truncate" style="max-width: 200px;" title="<?= esc($agenda['description']) ?>">
                                            <?= esc($agenda['description']) ?>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="date-box">
                                            <span class="date text-primary">
                                                <?= date('d M Y', strtotime($agenda['start_date'])) ?>
                                            </span>
                                            <span class="time">
                                                <i class="bi bi-clock me-1"></i>
                                                <?= date('H:i', strtotime($agenda['start_date'])) ?> WIB
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="date-box">
                                            <span class="date text-dark">
                                                <?= date('d M Y', strtotime($agenda['end_date'])) ?>
                                            </span>
                                            <span class="time">
                                                <i class="bi bi-clock-history me-1"></i>
                                                <?= date('H:i', strtotime($agenda['end_date'])) ?> WIB
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center" data-bs-toggle="tooltip" title="Klik untuk mengubah status">
                                            <?= btn_toggle($agenda['id_agenda'], $agenda['status'], 'agenda/toggle-status') ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="<?= site_url('agenda/' . $agenda['id_agenda'].'/edit') ?>" 
                                               class="btn btn-soft-primary btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" 
                                               style="width: 32px; height: 32px;"
                                               data-bs-toggle="tooltip" title="Edit Agenda">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="<?= site_url('agenda/'.$agenda['id_agenda']) ?>" method="post" class="d-inline">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" 
                                                        class="btn btn-soft-danger btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center btn-delete" 
                                                        style="width: 32px; height: 32px;"
                                                        data-bs-toggle="tooltip" title="Hapus"
                                                        data-name="<?= esc($agenda['activity_name']) ?>">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3 opacity-25">
                                            <i class="bi bi-calendar-x fa-4x text-secondary" style="font-size: 3rem;"></i>
                                        </div>
                                        <h6 class="fw-bold text-secondary">Belum ada agenda</h6>
                                        <p class="small text-muted mb-0">Silakan tambahkan agenda kegiatan baru.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                <span>Klik pada foto untuk memperbesar gambar dokumentasi agenda.</span>
            </div>
        </div>
    </div>

    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <div class="image-modal-close" onclick="closeImageModal()"></div>
        <img class="image-modal-content" id="modalImage">
        <div class="image-modal-title" id="modalTitle"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Image Modal Functions
    function openImageModal(imageSrc, title) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        
        modal.classList.add('show');
        modalImg.src = imageSrc;
        modalTitle.textContent = title;
        document.body.style.overflow = 'hidden'; // Disable scroll
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.remove('show');
        document.body.style.overflow = 'auto'; // Enable scroll
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeImageModal();
    });

    // Prevent closing when clicking the image itself
    document.getElementById('modalImage').addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Tooltip Initialization
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Delete Confirmation
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const agendaName = this.getAttribute('data-name');
            if (confirm(`Apakah Anda yakin ingin menghapus agenda "${agendaName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
                this.closest('form').submit();
            }
        });
    });
</script>
<?= $this->endSection() ?>