<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

<style>
    /* ============= FIX WARNA KOLUMN NO & STATUS ============= */

    /* Kolom No (kolom ke-1) */
    table.table > tbody > tr > td:nth-child(1),
    table.table > thead > tr > th:nth-child(1) {
        color: #000 !important;
        font-weight: 600;
    }

    /* Menghindari overwrite dari dark mode / card theme */
    table.table td,
    table.table th {
        background-color: transparent !important;
        vertical-align: middle; /* Agar konten di tengah secara vertikal */
    }
</style>

    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Data Kontak</h3>

        <a href="/kontak/new" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kontak
        </a>
    </div>

<?= $this->include('layouts/alerts') ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if (empty($kontak)): ?>
                <div class="alert alert-info text-center">Belum ada data kontak.</div>
            <?php else: ?>

                <div class="table-responsive">
<table class="table table-bordered table-striped align-middle">
    <thead class="table-primary">
        <tr>
            <th style="width: 50px;">No</th>
            <th>Nama Instansi</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Website</th>
            <th style="width: 220px;">Peta</th> <!-- Lebar kolom peta diset agar rapi -->
            <th>Status</th>
            <?php if ($can_update || $can_delete): ?>
                <th style="width: 140px;">Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($kontak as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($row['nama_instansi']) ?></td>
                <td><?= esc($row['alamat_lengkap']) ?></td>
                <td><?= esc($row['telepon']) ?></td>
                <td><?= esc($row['email']) ?></td>
                <td><?= esc($row['website']) ?></td>

                <!-- MAP COLUMN (IFRAME ONLY) -->
                <td>
                    <?php if (!empty($row['map_link'])): ?>
                        <!-- Container untuk Iframe agar ukurannya pas -->
                        <div class="ratio ratio-16x9 shadow-sm" style="width: 200px; height: 120px; border-radius: 6px; overflow: hidden;">
                            <iframe 
                                src="<?= esc($row['map_link']) ?>" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <!-- Tombol "Buka Full" dihapus karena link embed tidak mendukung dibuka di tab baru -->
                    <?php else: ?>
                        <span class="text-muted small fst-italic">Tidak ada peta</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($row['status'] == 'aktif'): ?>
                        <span class="badge bg-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Nonaktif</span>
                    <?php endif; ?>
                </td>

                <?php if ($can_update || $can_delete): ?>
                    <td>
                        <div class="d-flex gap-2">
                            <?php if ($can_update): ?>
                                <a href="kontak/<?= $row['id_kontak'].'/edit' ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            <?php endif; ?>

                            <?php if ($can_delete): ?>
                                <form action="/kontak/<?= $row['id_kontak'] ?>" method="POST"
                                      onsubmit="return confirm('Hapus data ini?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

                </div>

            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>