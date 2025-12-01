<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Footer OPD</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/footer_opd">Footer OPD</a></li>
        <li class="breadcrumb-item active">Edit Data</li>
    </ol>


    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Form Edit Data
        </div>
        <div class="card-body">
            <form action="/footer_opd/<?= $footer_opd['id_opd_info'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="website_name" class="form-label">Nama Website <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="website_name" name="website_name" value="<?= old('website_name', $footer_opd['website_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="official_title" class="form-label">Judul Resmi (Official Title) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="official_title" name="official_title" value="<?= old('official_title', $footer_opd['official_title']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address', $footer_opd['address']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $footer_opd['email']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone', $footer_opd['phone']) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Logo Kominfo -->
                    <div class="col-md-6">
                        <label for="logo_cominfo" class="form-label">Logo Kominfo</label>
                        <div class="mb-2 p-2 border rounded bg-light d-inline-block">
                            <!-- Logic: Tampilkan gambar DB jika ada, atau placeholder default/hidden -->
                            <?php 
                                $logoSrc = (!empty($footer_opd['logo_cominfo']) && file_exists($footer_opd['logo_cominfo'])) 
                                    ? base_url($footer_opd['logo_cominfo']) 
                                    : '#';
                                $logoClass = ($logoSrc == '#') ? 'd-none' : '';
                            ?>
                            <img id="preview_logo" src="<?= $logoSrc ?>" alt="Preview Logo" class="img-fluid <?= $logoClass ?>" style="height: 80px; object-fit: contain;">
                            <?php if($logoSrc == '#'): ?>
                                <span id="logo_placeholder" class="text-muted small fst-italic">Belum ada logo</span>
                            <?php endif; ?>
                        </div>
                        <input class="form-control" type="file" id="logo_cominfo" name="logo_cominfo" accept="image/*" onchange="previewImage(this, 'preview_logo', 'logo_placeholder')">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah logo.</div>
                    </div>

                    <!-- Election Badge -->
                    <div class="col-md-6">
                        <label for="election_badge" class="form-label">Badge Pemilu / Lainnya</label>
                        <div class="mb-2 p-2 border rounded bg-light d-inline-block">
                            <?php 
                                $badgeSrc = (!empty($footer_opd['election_badge']) && file_exists($footer_opd['election_badge'])) 
                                    ? base_url($footer_opd['election_badge']) 
                                    : '#';
                                $badgeClass = ($badgeSrc == '#') ? 'd-none' : '';
                            ?>
                            <img id="preview_badge" src="<?= $badgeSrc ?>" alt="Preview Badge" class="img-fluid <?= $badgeClass ?>" style="height: 80px; object-fit: contain;">
                            <?php if($badgeSrc == '#'): ?>
                                <span id="badge_placeholder" class="text-muted small fst-italic">Belum ada badge</span>
                            <?php endif; ?>
                        </div>
                        <input class="form-control" type="file" id="election_badge" name="election_badge" accept="image/*" onchange="previewImage(this, 'preview_badge', 'badge_placeholder')">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah badge.</div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', $footer_opd['is_active']) == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">Status Aktif</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/footer_opd" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input, previewId, placeholderId = null) {
        const preview = document.getElementById(previewId);
        const placeholder = placeholderId ? document.getElementById(placeholderId) : null;

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if(placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>