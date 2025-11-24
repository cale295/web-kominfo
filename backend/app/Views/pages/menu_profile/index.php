<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Data Profile</h4>

        <a href="<?= base_url('menu_profile/new') ?>" class="btn btn-primary">
            + Tambah Profile
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th width="50">#</th>
                        <th>Judul</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Sorting</th>
                        <th>Created At</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

<tbody>
    <?php $no=1; foreach($menu_profiles as $p): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= esc($p['title']) ?></td>

        <td>
            <?php if ($p['image']): ?>
                <img src="<?= base_url('uploads/menu_profile/'.$p['image']) ?>" height="50">
            <?php else: ?>
                <span class="text-muted">Tidak ada</span>
            <?php endif ?>
        </td>

        <td>
            <?php if ($p['is_active']): ?>
                <span class="badge bg-success">Aktif</span>
            <?php else: ?>
                <span class="badge bg-danger">Tidak Aktif</span>
            <?php endif ?>
        </td>

        <td>
            <?=  esc($p['type']) ?>
        </td>

        <td><?= esc($p['sorting']) ?></td>

        <td><?= esc($p['created_at']) ?></td>

        <td>
            <?php if ($can_update): ?>
                <a href="<?= base_url('menu_profile/'.$p['id_profil'].'/edit') ?>" 
                   class="btn btn-sm btn-warning">Edit</a>
            <?php endif ?>

            <form action="<?= site_url('menu_profile/'.$p['id_profil']) ?>" 
                  method="post" class="d-inline">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" 
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                    Hapus
                </button>
            </form>
        </td>

    </tr>
    <?php endforeach ?>
</tbody>


            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
