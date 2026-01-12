<div class="card mb-3">
    <div class="card-header p-2">
        <ul class="nav nav-pills"> <li class="nav-item">
                <a class="nav-link <?= ($active_tab == 'footer_opd') ? 'active' : '' ?>" 
                   href="<?= base_url('footer_opd') ?>">
                   <i class="fas fa-building"></i> Identitas OPD
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($active_tab == 'footer_social') ? 'active' : '' ?>" 
                   href="<?= base_url('footer_social') ?>">
                   <i class="fas fa-share-alt"></i> Sosial Media
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($active_tab == 'footer_statistics') ? 'active' : '' ?>" 
                   href="<?= base_url('footer_statistics') ?>">
                   <i class="fas fa-chart-bar"></i> Statistik
                </a>
            </li>

        </ul>
    </div>
</div>