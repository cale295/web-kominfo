<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>📜 Daftar Berita</h3>
        <div>
            <?php if (!empty($can_create)): ?>
                <a href="<?= site_url('berita/new') ?>" class="btn btn-primary">+ Tambah Berita</a>
            <?php endif; ?>
            <a href="<?= site_url('berita/trash') ?>" class="btn btn-secondary">🗑️ Sampah</a>
            
        </div>
    </div>
<?= $this->include('layouts/alerts') ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
<thead class="table-dark text-center">
<tr>
    <th>#</th>
    <th>Cover</th>
    <th>Foto Tambahan</th>
    <th>Judul</th>
    <th>Topik</th>
    <th>Konten</th>
    <th>Konten 2</th>
    <th>Kategori</th>
    <th>Status Tayang</th>
    <th>Status Berita</th>
    <th>Dibuat Oleh</th>
    <th>Waktu Dibuat</th>
    <th>Diupdate Oleh</th>
    <th>Update Terakhir</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach ($berita as $i => $row): ?>
<tr>
    <td class="text-center"><?= $i + 1 ?></td>

    <!-- Cover -->
    <td class="text-center">
        <?php if (!empty($row['feat_image'])): ?>
            <img src="<?= base_url($row['feat_image']) ?>" 
                 alt="Cover" class="img-thumbnail mb-1" 
                 style="width:80px;height:60px;object-fit:cover;">
        <?php else: ?>
            <span class="text-muted">Tidak ada</span>
        <?php endif; ?>
    </td>

    <!-- Additional Images -->
    <td class="text-center">
        <?php 
        $additional = !empty($row['additional_images']) ? json_decode($row['additional_images'], true) : [];
        if (!empty($additional)):
            foreach ($additional as $img): ?>
                <img src="<?= base_url($img) ?>" 
                     alt="Foto Tambahan" class="img-thumbnail mb-1" 
                     style="width:50px;height:40px;object-fit:cover;">
            <?php endforeach; 
        else: ?>
            <span class="text-muted">Tidak ada</span>
        <?php endif; ?>
    </td>

    <!-- Judul -->
    <td><?= esc($row['judul']) ?></td>

    <!-- Topik -->
    <td><?= esc($row['topik'] ?? '-') ?></td>

    <!-- Konten -->
    <td><?= ($row['content']) ?></td>

    <!-- Konten 2 -->
    <td><?= ($row['content2'] ?? '-') ?></td>

    <!-- Kategori -->
    <td>
        <?php
        if (!empty($row['kategori'])) {
            foreach ($row['kategori'] as $katName) {
                echo '<span class="badge bg-secondary me-1">'.esc($katName).'</span>';
            }
        } else {
            echo '-';
        }
        ?>
    </td>

    <!-- Status Tayang -->
    <td class="text-center">
        <?php if ($row['status'] == '1'): ?>
            <span class="badge bg-success">Tayang</span>
        <?php elseif ($row['status'] == '5'): ?>
            <span class="badge bg-secondary">Tidak Tayang</span>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Draft</span>
        <?php endif; ?>
    </td>

    <!-- Status Berita -->
    <td class="text-center">
        <?php
        $statusBerita = [
            '0' => ['bg-secondary', 'Draft'],
            '2' => ['bg-info text-dark', 'Menunggu Verifikasi'],
            '3' => ['bg-success', 'Perbaikan'],
            '4' => ['bg-warning text-dark', 'Layak Tayanag'],
            '6' => ['bg-danger', 'Revisi']
        ];
        [$class, $text] = $statusBerita[$row['status_berita']] ?? ['bg-light text-dark','-'];
        ?>
        <span class="badge <?= $class ?>"><?= $text ?></span>
    </td>

    <!-- Dibuat Oleh -->
    <td class="text-center"><?= esc($row['created_by_name'] ?? '-') ?></td>

    <!-- Waktu Dibuat -->
    <td class="text-center"><?= !empty($row['created_at']) ? date('d M Y H:i', strtotime($row['created_at'])) : '-' ?></td>

    <!-- Diupdate Oleh -->
    <td class="text-center"><?= esc($row['updated_by_name'] ?? '-') ?></td>

    <!-- Update Terakhir -->
    <td class="text-center"><?= !empty($row['updated_at']) ? date('d M Y H:i', strtotime($row['updated_at'])) : '-' ?></td>

    <!-- Aksi -->
<td class="text-center">
    <!-- Tombol Edit -->
    <?php if (!empty($can_update)): ?>
        <a href="<?= site_url('berita/'.$row['id_berita'].'/edit') ?>" class="btn btn-sm btn-warning mb-1">
            ✏️ Edit
        </a>
    <?php endif; ?>

    <!-- Tombol Trash / Soft Delete -->
    <?php if (!empty($can_delete)): ?>
        <form action="<?= site_url('berita/'.$row['id_berita'].'/delete') ?>" method="post" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Yakin membuang berita ini ke sampah?')">
                🗑️ Trash
            </button>
        </form>
    <?php endif; ?>
    <a href="<?= site_url('berita/' . $row['id_berita'] . '/log') ?>" 
   class="btn btn-info btn-sm">
    <i class="bi bi-journal-text"></i> Log
</a>


    <!-- Tombol Show / Detail -->
    <?php if (!empty($can_read)): ?>
        <a href="<?= site_url('berita/show/'.$row['id_berita']) ?>" class="btn btn-sm btn-info mb-1">
            🔍 Lihat
        </a>
    <?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>

        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tooltip bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?= $this->endSection() ?>
