<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Social Media</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/footer_social">Social Media</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>


    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-edit me-1"></i> Form Edit Akun</h6>
        </div>
        <div class="card-body">
            <form action="/footer_social/<?= $social['id_footer_social'] ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Platform <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="platform_name" value="<?= old('platform_name', $social['platform_name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Icon <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i id="icon-preview" class="fab fa-instagram fs-5"></i></span>
                                <select class="form-select" name="platform_icon" id="platform_icon" required onchange="updateIconPreview()">
                                    <?php 
                                    $icons = ['instagram', 'facebook', 'twitter', 'youtube', 'tiktok', 'linkedin', 'whatsapp', 'telegram', 'globe'];
                                    foreach($icons as $icon): 
                                        $selected = old('platform_icon', $social['platform_icon']) == $icon ? 'selected' : '';
                                        $label = ucfirst($icon);
                                        if($icon == 'globe') $label = 'Website (Globe)';
                                    ?>
                                        <option value="<?= $icon ?>" <?= $selected ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Akun <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" name="account_name" value="<?= old('account_name', $social['account_name']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Link URL <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" name="account_url" value="<?= old('account_url', $social['account_url']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Urutan (Sorting)</label>
                            <input type="number" class="form-control" name="sorting" value="<?= old('sorting', $social['sorting']) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 pt-4">
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= old('is_active', $social['is_active']) == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold" for="is_active">Status Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="/footer_social" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateIconPreview() {
        const select = document.getElementById('platform_icon');
        const preview = document.getElementById('icon-preview');
        const iconClass = select.value;
        
        preview.className = '';
        
        if(iconClass === 'globe') {
            preview.className = `fas fa-${iconClass} fs-5`;
        } else {
            preview.className = `fab fa-${iconClass} fs-5`;
        }
    }
    
    // Run on load
    document.addEventListener('DOMContentLoaded', updateIconPreview);
</script>
<?= $this->endSection() ?>