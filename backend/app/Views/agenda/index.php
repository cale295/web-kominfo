<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary-gov: #1e40af;
        --secondary-gov: #0c4a6e;
        --success-gov: #047857;
        --warning-gov: #b45309;
        --danger-gov: #be123c;
        --info-gov: #0369a1;
        --accent-gov: #fbbf24;
    }

    /* Page Header */
    .page-header-gov {
        background: linear-gradient(135deg, var(--primary-gov) 0%, var(--secondary-gov) 100%);
        color: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(30, 64, 175, 0.15);
        margin-bottom: 30px;
        border-left: 6px solid var(--accent-gov);
    }

    .page-header-gov h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .page-header-gov h3 i {
        color: var(--accent-gov);
        margin-right: 12px;
    }

    .btn-add-agenda {
        background: white;
        color: var(--primary-gov);
        border: none;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-add-agenda:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: var(--primary-gov);
    }

    /* Alert Success */
    .alert-success-gov {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: none;
        border-left: 5px solid var(--success-gov);
        border-radius: 12px;
        padding: 18px 24px;
        box-shadow: 0 2px 12px rgba(4, 120, 87, 0.15);
        margin-bottom: 24px;
        color: #065f46;
        font-weight: 500;
    }

    .alert-success-gov::before {
        content: '\F26B';
        font-family: 'bootstrap-icons';
        font-size: 1.3rem;
        color: var(--success-gov);
        margin-right: 10px;
    }

    /* Table Card */
    .table-card-gov {
        border-radius: 16px;
        border: none;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: white;
    }

    /* Table Styles */
    .table-gov {
        margin: 0;
        width: 100%;
    }

    .table-gov thead {
        background: linear-gradient(135deg, var(--primary-gov) 0%, var(--secondary-gov) 100%);
    }

    .table-gov thead th {
        color: black;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 18px 16px;
        border: none;
        white-space: nowrap;
    }

    .table-gov tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
    }

    .table-gov tbody tr {
        transition: all 0.2s ease;
    }

    .table-gov tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Image Thumbnail */
    .agenda-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .agenda-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-gov);
    }

    .no-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 2rem;
    }

    /* Activity Name Cell */
    .activity-name {
        font-weight: 600;
        color: #1e293b;
    }

    /* Description Cell */
    .description-cell {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #64748b;
    }

    /* Location & Date Cells */
    .location-cell {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
    }

    .location-cell i {
        color: var(--danger-gov);
        font-size: 1.1rem;
    }

    .date-cell {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .date-value {
        font-weight: 600;
        color: #1e293b;
    }

    .date-time {
        font-size: 0.8rem;
        color: #64748b;
    }

    /* Status Badge */
    .status-badge {
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .status-active::before {
        content: '●';
        font-size: 1rem;
        animation: pulse 2s ease-in-out infinite;
    }

    .status-inactive {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #64748b;
        border: 1px solid #cbd5e1;
    }

    .status-inactive::before {
        content: '○';
        font-size: 1rem;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Image Modal */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease;
    }

    .image-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-modal-content {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        animation: zoomIn 0.3s ease;
    }

    .image-modal-close {
    position: absolute;
    top: 30px;
    right: 40px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.1);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    line-height: 1;
}

/* hover */
.image-modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* trik khusus buat ngebenerin posisi X */
.image-modal-close::before {
    content: "X";
    display: block;
    transform: translateY(-2px);
}


    .image-modal-title {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        background: rgba(0, 0, 0, 0.7);
        padding: 12px 24px;
        border-radius: 8px;
        backdrop-filter: blur(10px);
        font-weight: 600;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.8);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Action Buttons */
    .btn-action-group {
        display: flex;
        gap: 6px;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 2px solid;
        background: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        padding: 0;
    }

    .btn-edit {
        border-color: var(--warning-gov);
        color: var(--warning-gov);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        border-color: var(--warning-gov);
        color: var(--warning-gov);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(180, 83, 9, 0.25);
    }

    .btn-delete {
        border-color: var(--danger-gov);
        color: var(--danger-gov);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-color: var(--danger-gov);
        color: var(--danger-gov);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(190, 18, 60, 0.25);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #64748b;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #94a3b8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header-gov {
            padding: 20px;
        }

        .page-header-gov h3 {
            font-size: 1.5rem;
        }

        .table-gov {
            font-size: 0.85rem;
        }

        .table-gov thead th,
        .table-gov tbody td {
            padding: 12px 8px;
        }

        .agenda-image,
        .no-image {
            width: 60px;
            height: 60px;
        }

        .description-cell {
            max-width: 150px;
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

    .table-card-gov {
        animation: fadeInUp 0.5s ease-out;
    }

    .alert-success-gov {
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
                    <i class="bi bi-calendar-event"></i>
                    Daftar Agenda Kegiatan
                </h3>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= site_url('agenda/new') ?>" class="btn btn-add-agenda">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Agenda Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Success -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success-gov alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Agenda Table Card -->
    <div class="card table-card-gov">
        <div class="table-responsive">
            <table class="table table-gov table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 100px;">Foto</th>
                        <th style="width: 20%;">Nama Kegiatan</th>
                        <th style="width: 25%;">Deskripsi</th>
                        <th style="width: 15%;">Lokasi</th>
                        <th style="width: 12%;">Mulai</th>
                        <th style="width: 12%;">Selesai</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($agendas)): ?>
                        <?php foreach ($agendas as $i => $agenda): ?>
                            <tr>
                                <td><strong><?= $i + 1 ?></strong></td>
                                <td>
                                    <?php if (!empty($agenda['image'])): ?>
                                        <img src="<?= base_url('uploads/agenda/' . $agenda['image']) ?>" 
                                             class="agenda-image" 
                                             alt="<?= esc($agenda['activity_name']) ?>"
                                             onclick="openImageModal(this.src, '<?= esc($agenda['activity_name']) ?>')">
                                    <?php else: ?>
                                        <div class="no-image">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="activity-name">
                                        <?= esc($agenda['activity_name']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="description-cell" title="<?= esc($agenda['description']) ?>">
                                        <?= esc($agenda['description']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="location-cell">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span><?= esc($agenda['location']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-cell">
                                        <div class="date-value">
                                            <?= date('d M Y', strtotime($agenda['start_date'])) ?>
                                        </div>
                                        <div class="date-time">
                                            <i class="bi bi-clock"></i>
                                            <?= date('H:i', strtotime($agenda['start_date'])) ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-cell">
                                        <div class="date-value">
                                            <?= date('d M Y', strtotime($agenda['end_date'])) ?>
                                        </div>
                                        <div class="date-time">
                                            <i class="bi bi-clock"></i>
                                            <?= date('H:i', strtotime($agenda['end_date'])) ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge <?= $agenda['status'] === 'active' ? 'status-active' : 'status-inactive' ?>">
                                        <?= $agenda['status'] === 'active' ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-action-group">
                                        <a href="<?= site_url('agenda/' . $agenda['id_agenda'].'/edit') ?>" 
                                           class="btn-action btn-edit"
                                           title="Edit Agenda">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= site_url('agenda/delete/' . $agenda['id_agenda']) ?>" 
                                           class="btn-action btn-delete"
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')"
                                           title="Hapus Agenda">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="bi bi-calendar-x"></i>
                                    <h5>Belum Ada Agenda</h5>
                                    <p>Silakan tambahkan agenda kegiatan untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <span class="image-modal-close"></span>
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
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});

// Prevent closing when clicking on image
document.getElementById('modalImage').addEventListener('click', function(e) {
    e.stopPropagation();
});

// Tooltip initialization for action buttons
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Confirm delete with better message
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const agendaName = this.closest('tr').querySelector('.activity-name').textContent.trim();
        
        if (confirm(`Apakah Anda yakin ingin menghapus agenda "${agendaName}"?\n\nTindakan ini tidak dapat dibatalkan.`)) {
            window.location.href = this.getAttribute('href');
        }
    });
});
</script>
<?= $this->endSection() ?>