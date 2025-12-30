<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengumuman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengumuman</li>
    </ol>

    <?= $this->include('layouts/alerts') ?>
    

    <div class="card shadow border-0 rounded-3 mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-bullhorn me-2"></i>Daftar Pengumuman</h6>
            
            <?php if ($can_create): ?>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-scale" 
                        data-bs-toggle="modal" data-bs-target="#addPengumumanModal">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="text-center py-3" width="10%">Gambar</th>
                            <th class="py-3" width="30%">Judul & Konten</th>
                            <th class="text-center py-3" width="10%">Media</th>
                            <th class="py-3" width="15%">Tanggal</th>
                            <th class="text-center py-3" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengumuman)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="fas fa-newspaper fa-3x"></i>
                                    </div>
                                    <h6 class="fw-bold text-secondary">Belum ada pengumuman</h6>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($pengumuman as $index => $item) : ?>
                                <tr>
                                    <td class="text-center fw-bold text-secondary"><?= $index + 1 ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($item['featured_image']) && file_exists($item['featured_image'])): ?>
                                            <div class="p-1 border rounded bg-light d-inline-block">
                                                <img src="<?= base_url($item['featured_image']) ?>" alt="Img" style="height: 40px; width: 60px; object-fit: cover;">
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">No Img</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['judul']) ?></div>
                                        <div class="small text-muted text-truncate" style="max-width: 200px;">
                                            <?= strip_tags($item['content']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if($item['tipe_media'] == 'link'): ?>
                                            <span class="badge bg-info text-dark"><i class="fas fa-link me-1"></i> Link</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><i class="fas fa-file-alt me-1"></i> File</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-muted">
                                        <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <?= btn_toggle($item['id_pengumuman'], $item['status'], 'pengumuman/toggle-status') ?>
                                            
                                            <?php if ($can_update): ?>
                                                <a href="/pengumuman/<?= $item['id_pengumuman'] ?>/edit" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($can_delete): ?>
                                                <form action="/pengumuman/<?= $item['id_pengumuman'] ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
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

<div class="modal fade" id="addPengumumanModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addPengumumanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"> <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header bg-white pb-0 border-bottom-0">
                <div>
                    <h5 class="modal-title fw-bold text-primary" id="addPengumumanLabel"><i class="fas fa-bullhorn me-2"></i>Tambah Pengumuman</h5>
                    <p class="text-muted small mb-0">Isi formulir di bawah ini untuk membuat pengumuman baru.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light mt-3">
                <form action="/pengumuman" method="post" enctype="multipart/form-data" id="formPengumuman">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase">Judul Pengumuman <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="judul" value="<?= old('judul') ?>" placeholder="Masukkan judul..." required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-uppercase">Isi Pengumuman <span class="text-danger">*</span></label>
                                        <textarea class="form-control editor" name="content" rows="4" placeholder="Tulis isi pengumuman..."><?= old('content') ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-white fw-bold small text-uppercase py-2">Pengaturan Media</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipe_media" id="tipeLink" value="link" onchange="toggleMedia('link')" <?= old('tipe_media') == 'link' ? 'checked' : 'checked' ?>>
                                            <label class="form-check-label" for="tipeLink"><i class="fas fa-link me-1"></i> Link URL</label>
                                        </div>
                                        
                                    </div>

                                    <div id="inputLink" class="mb-2">
                                        <label class="form-label small text-muted">URL Tujuan</label>
                                        <input type="url" class="form-control" name="link_url" placeholder="https://contoh.com" value="<?= old('link_url') ?>">
                                    </div>

                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-white fw-bold small text-uppercase py-2">Gambar Cover <span class="text-danger">*</span></div>
                                <div class="card-body text-center">
                                    <div class="mb-3 position-relative bg-light rounded border d-flex align-items-center justify-content-center overflow-hidden" style="height: 200px; width: 100%;">
                                        <img id="thumb-preview" src="#" alt="Preview" class="d-none w-100 h-100 object-fit-cover">
                                        <div id="thumb-placeholder" class="text-muted">
                                            <i class="fas fa-image fa-3x mb-2 opacity-50"></i><br>
                                            <small>Preview Gambar</small>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-sm" type="file" name="featured_image" accept="image/*" onchange="previewImage(this)" required>
                                    <div class="form-text mt-2 small text-start">Format JPG/PNG. Wajib diisi.</div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" id="statusSwitch" name="status" value="1" <?= old('status', 1) == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-bold" for="statusSwitch">Status Aktif</label>
                                    </div>
                                    <small class="text-muted d-block mt-1">Jika tidak aktif, pengumuman tidak akan tampil di frontend.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            
            <div class="modal-footer border-top-0 bg-white">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" onclick="document.getElementById('formPengumuman').submit()" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-save me-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // --- TOOLTIPS ---
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Inisialisasi state media saat load (jika ada old data dari validasi error)
        const isFile = document.getElementById('tipeFile').checked;
        toggleMedia(isFile ? 'file' : 'link');
    });

    // --- LOGIC PREVIEW IMAGE ---
    function previewImage(input) {
        const preview = document.getElementById('thumb-preview');
        const placeholder = document.getElementById('thumb-placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // Reset jika cancel upload
            preview.src = '#';
            preview.classList.add('d-none');
            placeholder.classList.remove('d-none');
        }
    }

    // --- LOGIC TOGGLE MEDIA (LINK vs FILE) ---
    function toggleMedia(type) {
        const inputLink = document.getElementById('inputLink');
        const inputFile = document.getElementById('inputFile');
        
        if (type === 'link') {
            inputLink.classList.remove('d-none');
            inputFile.classList.add('d-none');
        } else {
            inputLink.classList.add('d-none');
            inputFile.classList.remove('d-none');
        }
    }

    // --- LOGIC RESET FORM SAAT MODAL DITUTUP ---
    const modalEl = document.getElementById('addPengumumanModal');
    if(modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            // Reset Form
            document.getElementById('formPengumuman').reset();
            
            // Reset Preview Image
            document.getElementById('thumb-preview').classList.add('d-none');
            document.getElementById('thumb-preview').src = '#';
            document.getElementById('thumb-placeholder').classList.remove('d-none');

            // Reset Media Toggle ke Default (Link)
            document.getElementById('tipeLink').checked = true;
            toggleMedia('link');
        });
    }
</script>
<?= $this->endSection() ?>