<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Reset & Variables */
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --bg-hover: #f8fafc;
        --border: #e2e8f0;
        --radius: 8px;
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    .page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 3rem 1.5rem;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    /* Header Section */
    .top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .top h3 {
        font-size: 1.85rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }

    /* General Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: var(--radius);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        color: white;
    }

    /* Alerts */
    .msg {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 1rem;
        border-radius: var(--radius);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.95rem;
    }

    /* Folder Card (Accordion) */
    .folder-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 1rem;
        overflow: hidden;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .folder-card:hover {
        border-color: #cbd5e1;
        box-shadow: var(--shadow);
    }

    .folder-header {
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        background: white;
        transition: background 0.2s;
    }

    .folder-header:hover {
        background: var(--bg-hover);
    }

    .folder-icon {
        color: var(--primary);
        display: flex;
        align-items: center;
    }

    .folder-info {
        flex: 1;
    }

    .folder-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-main);
        margin: 0;
        display: block;
    }

    .folder-meta {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    /* Chevron Animation */
    .chevron {
        transition: transform 0.3s ease;
        color: #94a3b8;
    }
    
    .folder-card.active .chevron {
        transform: rotate(180deg);
        color: var(--primary);
    }

    .folder-body {
        display: none;
        border-top: 1px solid var(--border);
        background: #fdfdfd;
        padding: 1.5rem;
    }

    .folder-card.active .folder-body {
        display: block;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: white;
    }

    .tbl {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .tbl thead {
        background: #f1f5f9;
    }

    .tbl th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }

    .tbl td {
        padding: 0.875rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        color: var(--text-main);
    }

    .tbl tbody tr:last-child td {
        border-bottom: none;
    }

    .tbl tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Action Buttons Group */
    .action-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid transparent;
        transition: all 0.2s;
        color: white;
    }

    .btn-icon:hover {
        transform: scale(1.05);
    }

    .btn-view { background: #3b82f6; } /* Blue */
    .btn-view:hover { background: #2563eb; }

    .btn-edit { background: #f59e0b; } /* Amber */
    .btn-edit:hover { background: #d97706; }

    .btn-del { background: #ef4444; } /* Red */
    .btn-del:hover { background: #dc2626; }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-muted);
        border: 2px dashed var(--border);
        border-radius: var(--radius);
        background: #fafafa;
    }

    .empty-folder {
        text-align: center;
        padding: 2rem;
        color: var(--text-muted);
        font-style: italic;
        font-size: 0.9rem;
    }

    /* Utilities */
    .mb-3 { margin-bottom: 1rem; }
    
    @media (max-width: 768px) {
        .top {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .folder-header {
            padding: 1rem;
        }
    }
</style>

<div class="page">

    <div class="top">
        <h3>📂 Manajemen Dokumen</h3>
        <a href="<?= site_url("informasi-publik/$slug/folder/create") ?>" class="btn">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Folder
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="msg">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <?php if ($folders) : ?>
        <?php foreach ($folders as $i => $folder) : ?>
            <?php
                $folderId = 'folder-' . $i;
                $namaFolder = esc($folder['nama_folder']);
                $jumlah = count($folder['dokumen'] ?? []);
            ?>

            <div class="folder-card" id="<?= $folderId ?>">
                <div class="folder-header" onclick="toggleFolder('<?= $folderId ?>')">
                    <div class="folder-icon">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    </div>
                    <div class="folder-info">
                        <h5 class="folder-title"><?= $namaFolder ?></h5>
                        <div class="folder-meta"><?= $jumlah ?> Dokumen tersimpan</div>
                    </div>
                    <div class="chevron">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div class="folder-body">
                    <div class="mb-3">
                        <a href="<?= site_url("informasi-publik/$slug/dokumen/create/" . urlencode($namaFolder)) ?>" class="btn" style="padding: 0.5rem 1rem; font-size: 0.85rem; background: #475569;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Upload Dokumen
                        </a>
                    </div>

                    <?php if (!empty($folder['dokumen'])) : ?>
                        <div class="table-responsive">
                            <table class="tbl">
                                <thead>
                                    <tr>
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th>Nama Dokumen</th>
                                        <th style="width: 10%">Tahun</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($folder['dokumen'] as $d) : ?>
                                        <tr>
                                            <td style="text-align: center; color: #94a3b8;"><?= $no++ ?></td>
                                            <td style="font-weight: 500;"><?= esc($d['nama_dokumen']) ?></td>
                                            <td>
                                                <span style="background: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                                                    <?= esc($d['tahun']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-group">
                                                    <a href="<?= base_url('uploads/dokumen/' . $d['file_path']) ?>" target="_blank" class="btn-icon btn-view" title="Lihat File">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                    <a href="<?= site_url("informasi-publik/$slug/edit/" . $d['id_document']) ?>" class="btn-icon btn-edit" title="Edit Data">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    <a href="<?= site_url("informasi-publik/$slug/delete/" . $d['id_document']) ?>" class="btn-icon btn-del" onclick="return confirm('Yakin hapus dokumen ini?')" title="Hapus">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="empty-folder">
                            <svg width="40" height="40" style="color: #cbd5e1; margin-bottom: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p>Belum ada dokumen di folder ini</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>
    <?php else : ?>
        <div class="empty-state">
            <svg width="60" height="60" style="color: #cbd5e1; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
            <p>Belum ada folder dokumen tersedia.</p>
            <p style="font-size: 0.85rem; margin-top: 0.5rem;">Silakan buat folder baru untuk memulai.</p>
        </div>
    <?php endif; ?>

</div>

<script>
function toggleFolder(id) {
    const el = document.getElementById(id);
    
    el.classList.toggle('active');
}
</script>

<?= $this->endSection() ?>