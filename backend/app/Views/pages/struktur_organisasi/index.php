<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
// --- LOGIKA SORTING HIERARKI (TREE) ---
// Kita olah data flat dari controller menjadi urutan Parent -> Child di View ini.

$hierarchicalData = [];
if (!empty($struktur)) {
    $grouped = [];
    $roots   = [];

    // 1. Kelompokkan berdasarkan parent_id
    foreach ($struktur as $row) {
        $pid = $row['parent_id'];
        if (empty($pid)) {
            $roots[] = $row;
        } else {
            $grouped[$pid][] = $row;
        }
    }

    // 2. Fungsi Rekursif untuk menyusun urutan flat dengan level kedalaman
    function buildFlatTree($nodes, &$grouped, $depth = 0) {
        $result = [];
        foreach ($nodes as $node) {
            $node['depth'] = $depth; // Tambah properti kedalaman
            $result[] = $node;

            // Cek apakah punya anak
            if (isset($grouped[$node['id_struktur']])) {
                $children = buildFlatTree($grouped[$node['id_struktur']], $grouped, $depth + 1);
                $result = array_merge($result, $children);
            }
        }
        return $result;
    }

    // 3. Generate hasil akhir
    $hierarchicalData = buildFlatTree($roots, $grouped);
}
?>

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between my-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Struktur Organisasi</h1>
            <p class="text-muted small mb-0">Kelola unit kerja, bidang, dan jabatan dalam organisasi.</p>
        </div>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Struktur</li>
        </ol>
    </div>

    <!-- Alert Messages -->
    <?= $this->include('layouts/alerts') ?>

    <!-- Main Card -->
    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-sitemap me-2"></i>Daftar Unit</h6>
            <?php if ($can_create): ?>
                <a href="/struktur_organisasi/new" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale">
                    <i class="fas fa-plus me-1"></i> Tambah Unit
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Tambahkan class 'table-tree' untuk styling khusus jika perlu -->
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3" width="30%">Nama Unit (Hierarki)</th>
                            <th class="text-center py-3" width="10%">Status</th>
                            <th class="text-center py-3" width="10%">Urutan</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($hierarchicalData)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-sitemap fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada data</h6>
                                    <p class="small text-muted mb-0">Silakan tambahkan unit organisasi baru.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php 
                                // Loop menggunakan data yang sudah diurutkan hierarkis
                                foreach ($hierarchicalData as $index => $item) : 
                                    // Hitung padding berdasarkan depth (misal 30px per level)
                                    $paddingLeft = $item['depth'] * 30;
                            ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td>
                                        <div style="padding-left: <?= $paddingLeft ?>px;">
                                            <?php if ($item['depth'] > 0): ?>
                                                <i class="fas fa-level-up-alt fa-rotate-90 me-2 text-muted small"></i>
                                            <?php endif; ?>
                                            
                                            <span class="<?= $item['depth'] == 0 ? 'fw-bold text-dark' : 'text-secondary' ?>">
                                                <?= esc($item['nama']) ?>
                                            </span>
                                        </div>
                                        <?php if ($item['depth'] == 0): ?>
                                            <div class="small text-muted fst-italic mt-1">Slug: <?= esc($item['slug']) ?></div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($item['is_active'] == 1) : ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success px-2">Aktif</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary px-2">Non-Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border"><?= esc($item['sorting']) ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if ($can_update): ?>
                                                <a href="/struktur_organisasi/<?= $item['id_struktur'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/struktur_organisasi/<?= $item['id_struktur'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Tooltip Init
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?= $this->endSection() ?>