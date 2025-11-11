<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📊 Log Aktivitas Berita</h3>
        <div>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                🏠 Dashboard
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filter & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" action="<?= base_url('log_activity') ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Cari Judul Berita</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Ketik judul berita..." 
                               value="<?= esc($search ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="0" <?= isset($status) && $status == '0' ? 'selected' : '' ?>>Draft</option>
                            <option value="1" <?= isset($status) && $status == '1' ? 'selected' : '' ?>>Tayang</option>
                            <option value="2" <?= isset($status) && $status == '2' ? 'selected' : '' ?>>Revisi</option>
                            <option value="3" <?= isset($status) && $status == '3' ? 'selected' : '' ?>>Perbaikan</option>
                            <option value="4" <?= isset($status) && $status == '4' ? 'selected' : '' ?>>Publish</option>
                            <option value="5" <?= isset($status) && $status == '5' ? 'selected' : '' ?>>Tidak Tayang</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">User</label>
                        <input type="text" name="user" class="form-control" 
                               placeholder="Nama user..." 
                               value="<?= esc($user ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tanggal Dari</label>
                        <input type="date" name="date_from" class="form-control" 
                               value="<?= esc($date_from ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tanggal Sampai</label>
                        <input type="date" name="date_to" class="form-control" 
                               value="<?= esc($date_to ?? '') ?>">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            🔍 Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total Aktivitas</h6>
                    <h3><?= number_format($totalLogs ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Berita Aktif</h6>
                    <h3><?= number_format($activeNews ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h6>Perlu Revisi</h6>
                    <h3><?= number_format($needRevision ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Total User Aktif</h6>
                    <h3><?= number_format($activeUsers ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Log -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">📝 Daftar Log Aktivitas</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($logs)): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 3%;">No</th>
                                <th style="width: 5%;">ID Log</th>
                                <th style="width: 12%;">Tanggal & Waktu</th>
                                <th style="width: 25%;">Judul Berita</th>
                                <th style="width: 10%;">User</th>
                                <th style="width: 20%;">Keterangan</th>
                                <th style="width: 8%;">Status</th>
                                <th style="width: 17%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1 + (($currentPage - 1) * $perPage);
                            foreach($logs as $log): 
                                // Decode JSON untuk ambil judul
                                $logData = json_decode($log['log'], true);
                                $judulBerita = $logData['judul'] ?? 'Berita tidak ditemukan';
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center">
                                    <code><?= $log['id'] ?></code>
                                </td>
                                <td>
                                    <small>
                                        <?= date('d/m/Y', strtotime($log['created_date'])) ?><br>
                                        <strong><?= date('H:i:s', strtotime($log['created_date'])) ?></strong>
                                    </small>
                                </td>
                                <td>
                                    <strong><?= esc($judulBerita) ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        ID Berita: <code><?= $log['id_berita'] ?></code>
                                    </small>
                                </td>
                                <td>
                                    <strong><?= esc($log['fullname'] ?? '-') ?></strong>
                                    <?php if (!empty($log['id_user'])): ?>
                                        <br><small class="text-muted">ID: <?= $log['id_user'] ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span><?= esc($log['keterangan']) ?></span>
                                    
                                    <?php if (!empty($log['note_revisi'])): ?>
                                        <br><small class="text-warning">
                                            <i class="fas fa-sticky-note"></i> <?= esc(substr($log['note_revisi'], 0, 50)) ?><?= strlen($log['note_revisi']) > 50 ? '...' : '' ?>
                                        </small>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($log['note_perbaikan'])): ?>
                                        <br><small class="text-info">
                                            <i class="fas fa-wrench"></i> <?= esc(substr($log['note_perbaikan'], 0, 50)) ?><?= strlen($log['note_perbaikan']) > 50 ? '...' : '' ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $statusBadges = [
                                        '0' => '<span class="badge bg-secondary">Draft</span>',
                                        '1' => '<span class="badge bg-success">Tayang</span>',
                                        '2' => '<span class="badge bg-warning text-dark">Revisi</span>',
                                        '3' => '<span class="badge bg-info text-dark">Perbaikan</span>',
                                        '4' => '<span class="badge bg-primary">Publish</span>',
                                        '5' => '<span class="badge bg-danger">Tidak Tayang</span>',
                                    ];
                                    echo $statusBadges[$log['status']] ?? '<span class="badge bg-secondary">-</span>';
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetail<?= $log['id'] ?>"
                                                title="Lihat Detail">
                                            👁️
                                        </button>
                                        <a href="<?= base_url('berita/'.$log['id_berita'].'/edit') ?>" 
                                           class="btn btn-warning"
                                           title="Edit Berita">
                                            ✏️
                                        </a>
                                        <a href="<?= base_url('berita/log/'.$log['id_berita']) ?>" 
                                           class="btn btn-primary"
                                           title="Log Berita">
                                            📋
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pager): ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Menampilkan <?= (($currentPage - 1) * $perPage) + 1 ?> 
                        sampai <?= min($currentPage * $perPage, $totalLogs) ?> 
                        dari <?= $totalLogs ?> log
                    </div>
                    <div>
                        <?= $pager->links('default', 'bootstrap_pagination') ?>
                    </div>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Tidak ada log aktivitas ditemukan.
                    <?php if (!empty($search) || !empty($status) || !empty($user)): ?>
                        <br><a href="<?= base_url('log_activity') ?>" class="btn btn-sm btn-primary mt-2">Reset Filter</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Detail untuk setiap log -->
<?php if (!empty($logs)): ?>
    <?php foreach($logs as $log): 
        $logData = json_decode($log['log'], true);
    ?>
    <div class="modal fade" id="modalDetail<?= $log['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">📄 Detail Log #<?= $log['id'] ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th style="width: 40%;">ID Log</th>
                                    <td><code><?= $log['id'] ?></code></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td><?= date('d F Y H:i:s', strtotime($log['created_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td><?= esc($log['fullname'] ?? '-') ?> (ID: <?= $log['id_user'] ?>)</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td><?= esc($log['keterangan']) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th style="width: 40%;">ID Berita</th>
                                    <td><code><?= $log['id_berita'] ?></code></td>
                                </tr>
                                <tr>
                                    <th>Hash</th>
                                    <td><code><?= esc($log['id_hash']) ?></code></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php
                                        $statusBadges = [
                                            '0' => '<span class="badge bg-secondary">Draft</span>',
                                            '1' => '<span class="badge bg-success">Tayang</span>',
                                            '2' => '<span class="badge bg-warning text-dark">Revisi</span>',
                                            '3' => '<span class="badge bg-info text-dark">Perbaikan</span>',
                                            '4' => '<span class="badge bg-primary">Publish</span>',
                                            '5' => '<span class="badge bg-danger">Tidak Tayang</span>',
                                        ];
                                        echo $statusBadges[$log['status']] ?? '<span class="badge bg-secondary">-</span>';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Aksi</th>
                                    <td>
                                        <a href="<?= base_url('berita/'.$log['id_berita'].'/edit') ?>" class="btn btn-sm btn-warning">Edit Berita</a>
                                        <a href="<?= base_url('berita/log/'.$log['id_berita']) ?>" class="btn btn-sm btn-primary">Log Berita</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if (!empty($log['note_revisi']) || !empty($log['note_perbaikan'])): ?>
                    <div class="alert alert-warning">
                        <?php if (!empty($log['note_revisi'])): ?>
                            <p><strong>📝 Note Revisi:</strong><br><?= nl2br(esc($log['note_revisi'])) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($log['note_perbaikan'])): ?>
                            <p class="mb-0"><strong>🔧 Note Perbaikan:</strong><br><?= nl2br(esc($log['note_perbaikan'])) ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($logData && is_array($logData)): ?>
                    <hr>
                    <h6>📊 Data Berita</h6>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th style="width: 20%;">Field</th>
                            <th>Value</th>
                        </tr>
                        <?php if (!empty($logData['judul'])): ?>
                        <tr>
                            <td><strong>Judul</strong></td>
                            <td><?= esc($logData['judul']) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($logData['slug'])): ?>
                        <tr>
                            <td><strong>Slug</strong></td>
                            <td><?= esc($logData['slug']) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($logData['topik'])): ?>
                        <tr>
                            <td><strong>Topik</strong></td>
                            <td><?= esc($logData['topik']) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($logData['intro'])): ?>
                        <tr>
                            <td><strong>Intro</strong></td>
                            <td><?= esc(substr($logData['intro'], 0, 200)) ?><?= strlen($logData['intro']) > 200 ? '...' : '' ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($logData['kategori_berita'])): ?>
                        <tr>
                            <td><strong>Kategori</strong></td>
                            <td>
                                <?php
                                $kategoriNames = array_column($logData['kategori_berita'], 'kategori');
                                echo esc(implode(', ', $kategoriNames));
                                ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($logData['sumber'])): ?>
                        <tr>
                            <td><strong>Sumber</strong></td>
                            <td><?= esc($logData['sumber']) ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                    <?php endif; ?>

                    <hr>
                    <h6>📦 Raw JSON Data</h6>
                    <div class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                        <pre class="mb-0"><code><?= esc($log['log']) ?></code></pre>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="copyToClipboard('<?= htmlspecialchars($log['log'], ENT_QUOTES) ?>')">
                        📋 Copy JSON
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
function copyToClipboard(jsonString) {
    const tempInput = document.createElement('textarea');
    tempInput.value = jsonString;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    alert('✅ JSON berhasil dicopy ke clipboard!');
}
</script>

<?= $this->endSection() ?>