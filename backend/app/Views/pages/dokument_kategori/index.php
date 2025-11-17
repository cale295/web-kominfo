<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    :root {
        --primary: #1e40af;
        --primary-dark: #1e3a8a;
        --primary-light: #3b82f6;
        --success: #059669;
        --warning: #d97706;
        --info: #0284c7;
        --danger: #dc2626;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    body {
        background-color: var(--gray-50);
    }

    /* Header Styles */
    .gov-header {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
        border: 1px solid var(--gray-200);
        border-left: 4px solid var(--primary);
    }

    .gov-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--gray-900);
    }

    .gov-header h1 i {
        color: var(--primary);
        margin-right: 10px;
    }

    .action-buttons .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .action-buttons .btn-primary {
        background: var(--primary);
        border: none;
    }

    .action-buttons .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
    }

    /* Table Card */
    .table-card {
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
    }

    /* Custom Table */
    .gov-table {
        margin: 0;
    }

    .gov-table thead {
        background: var(--gray-100);
    }

    .gov-table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
    }

    .gov-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
    }

    .gov-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .gov-table tbody tr:hover {
        background-color: var(--gray-50);
    }

    /* Category Name */
    .category-name {
        font-weight: 500;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .category-name i {
        color: var(--primary);
    }

    /* Description */
    .category-desc {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    /* Action Buttons in Table */
    .gov-table .btn {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
        border: none;
    }

    .gov-table .btn-warning {
        background: var(--warning);
        color: white;
    }

    .gov-table .btn-warning:hover {
        background: #b45309;
        transform: translateY(-1px);
    }

    .gov-table .btn-danger {
        background: var(--danger);
        color: white;
    }

    .gov-table .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-1px);
    }

    /* Empty State */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-500);
    }

    .no-data i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 16px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .gov-header {
            padding: 20px;
        }
        
        .gov-header h1 {
            font-size: 1.375rem;
        }

        .gov-table thead th,
        .gov-table tbody td {
            padding: 10px 12px;
            font-size: 0.8125rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 8px;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="gov-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1>
                <i class="bi bi-folder"></i>
                Manajemen Kategori Dokumen
            </h1>
        </div>
        <div class="action-buttons d-flex gap-2">
            <a href="<?= base_url('dokument_kategori/new') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kategori
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/alerts') ?>

<!-- Table Card -->
<div class="card table-card">
    <div class="card-body p-0">
        <?php if (empty($dokumentKategori)): ?>
            <div class="no-data">
                <i class="bi bi-inbox"></i>
                <p class="mb-0">Belum ada data kategori dokumen</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table gov-table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">No</th>
                            <th style="min-width: 200px;">Nama Kategori</th>
                            <th style="min-width: 250px;">Keterangan</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($dokumentKategori as $row): ?>
                            <tr>
                                <td class="text-center">
                                    <strong><?= $no++ ?></strong>
                                </td>
                                <td>
                                    <div class="category-name">
                                        <i class="bi bi-folder-fill"></i>
                                        <?= esc($row['category_name']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="category-desc">
                                        <?= esc($row['category_description']) ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-1">
                                        <?php if ($can_update): ?>
                                            <a href="<?= base_url('dokument_kategori/' . $row['id_document_category'].'/edit') ?>" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($can_delete): ?>
                                            <form action="<?= base_url('dokument_kategori/' . $row['id_document_category']) ?>" 
                                                  method="post"
                                                  onsubmit="return confirm('Hapus kategori ini?')">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>