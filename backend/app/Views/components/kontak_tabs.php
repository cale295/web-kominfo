<div class="card mb-3">
    <div class="card-header p-2">
        <ul class="nav nav-pills"> <li class="nav-item">
                <a class="nav-link <?= ($active_tab == 'kontak') ? 'active' : '' ?>" 
                   href="<?= base_url('kontak') ?>">
                   <i class="fas fa-building"></i>  Kontak
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($active_tab == 'kontak_social') ? 'active' : '' ?>" 
                   href="<?= base_url('kontak_social') ?>">
                   <i class="fas fa-share-alt"></i> Kontak Sosial
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($active_tab == 'kontak_layanan') ? 'active' : '' ?>" 
                   href="<?= base_url('kontak_layanan') ?>">
                   <i class="fas fa-chart-bar"></i> Kontak Layanan
                </a>
            </li>

        </ul>
    </div>
</div>