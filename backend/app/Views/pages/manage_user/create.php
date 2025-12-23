<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/pages/manage_user/create.css') ?>">
<style>
    /* =========================================
       1. CUSTOM STYLES
       ========================================= */

    /* Transisi halus untuk field yang muncul/hilang */
    .conditional-field {
        transition: all 0.3s ease-in-out;
        opacity: 1;
        max-height: 1000px;
        overflow: hidden;
    }
    
    .conditional-field.hidden {
        opacity: 0;
        max-height: 0;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    /* Styling Radio Button Custom */
    .user-type-selector {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }
    
    .form-check-input:checked {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
    
    /* Indikator kekuatan password */
    .password-strength {
        height: 5px;
        margin-top: 5px;
        background-color: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        display: none; 
    }
    
    .password-strength.show { display: block; }

    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease, background-color 0.3s ease;
    }

    .password-strength-text {
        font-size: 0.75rem;
        margin-top: 5px;
        font-weight: 600;
    }
    
    /* Role Preview */
    .role-preview {
        margin-top: 10px;
        padding: 10px;
        border-radius: 6px;
        background-color: #f8f9fa;
        border-left: 4px solid #ccc;
        font-size: 0.9rem;
        display: none;
    }
    .role-preview.show { display: block; }
    .role-preview.superadmin { border-left-color: #dc3545; background-color: #fff5f5; }
    .role-preview.admin { border-left-color: #0d6efd; background-color: #f0f7ff; }
    .role-preview.editor { border-left-color: #198754; background-color: #f0fff4; }

    /* =========================================
       2. NEW: SEARCH BUTTON STYLES
       ========================================= */
    .search-container {
        display: flex;
        gap: 10px;
        align-items: flex-start; /* Agar tombol sejajar atas jika error message muncul */
    }

    /* Memastikan input group mengambil sisa ruang */
    .search-container .input-group-gov {
        flex-grow: 1; 
    }

    .btn-search-gov {
        background-color: var(--bs-primary); /* Sesuaikan dengan warna tema utama */
        color: white;
        border: none;
        border-radius: 0.375rem; /* Sesuaikan radius border bootstrap */
        padding: 10px 20px; /* Padding agar tinggi mirip input */
        height: 48px; /* Sesuaikan tinggi dengan input-group-gov Anda */
        font-weight: 600;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-search-gov:hover {
        filter: brightness(90%);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        color: white;
    }

    .btn-search-gov:disabled {
        background-color: #adb5bd;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>
<div class="container-fluid py-4">
    <div class="page-header-gov">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3>
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Tambah Pengguna Baru
                </h3>
                <p>Buat akun pengguna baru untuk sistem informasi</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?= base_url('manage_user') ?>" class="btn btn-back-gov">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card form-card-gov">
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger-gov alert-dismissible fade show" role="alert">
                    <strong>Terdapat kesalahan pada form:</strong>
                    <ul class="mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('manage_user') ?>" method="post" id="userForm" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-section-title">
                    <i class="bi bi-grid-fill"></i>
                    Tipe Pengguna
                </div>
                
                <div class="user-type-selector">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_user" id="type_non_pegawai" value="non_pegawai" checked>
                                <label class="form-check-label fw-bold" for="type_non_pegawai">
                                    <i class="bi bi-person me-1"></i> Masyarakat Umum / Non-Pegawai
                                </label>
                                <div class="text-muted small ms-4">Memerlukan NIK, Email, dan data lengkap lainnya.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_user" id="type_pegawai" value="pegawai">
                                <label class="form-check-label fw-bold" for="type_pegawai">
                                    <i class="bi bi-building me-1"></i> Pegawai Internal
                                </label>
                                <div class="text-muted small ms-4">Hanya memerlukan NIP, Nama, dan Role.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">
                    <i class="bi bi-person-badge"></i>
                    Informasi Utama
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="id_user" class="form-label form-label-gov" id="identity_label">
                            <i class="bi bi-card-heading"></i>
                            NIK (Nomor Induk Kependudukan)
                            <span class="required">*</span>
                        </label>
                        
                        <div class="search-container">
                            <div class="input-group-gov">
                                <i class="bi bi-card-text input-icon"></i>
                                <input type="text" 
                                       name="id_user" 
                                       id="id_user" 
                                       class="form-control form-control-gov" 
                                       value="<?= old('id_user') ?>" 
                                       placeholder="Masukkan 16 digit NIK"
                                       required>
                            </div>

                            <button type="button" id="btn_check_data" class="btn btn-search-gov" title="Cari data otomatis">
                                <i class="bi bi-search" id="icon_search"></i>
                                <span class="spinner-border spinner-border-sm d-none" id="icon_loading" role="status" aria-hidden="true"></span>
                                <span class="d-none d-md-inline">Cari</span>
                            </button>
                        </div>
                        <div class="form-text text-muted small mt-1">Klik cari untuk mengisi data otomatis.</div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="full_name" class="form-label form-label-gov">
                            <i class="bi bi-person"></i>
                            Nama Lengkap
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input type="text" 
                                   name="full_name" 
                                   id="full_name" 
                                   class="form-control form-control-gov" 
                                   value="<?= old('full_name') ?>" 
                                   placeholder="Masukkan nama lengkap"
                                   required>
                        </div>
                    </div>
                </div>

                <div id="non_pegawai_fields" class="conditional-field">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="username" class="form-label form-label-gov">
                                <i class="bi bi-at"></i>
                                Username
                                <span class="required">*</span>
                            </label>
                            <div class="input-group-gov">
                                <i class="bi bi-person-circle input-icon"></i>
                                <input type="text" 
                                       name="username" 
                                       id="username" 
                                       class="form-control form-control-gov" 
                                       value="<?= old('username') ?>" 
                                       placeholder="username123">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label form-label-gov">
                                <i class="bi bi-envelope"></i>
                                Email
                                <span class="required">*</span>
                            </label>
                            <div class="input-group-gov">
                                <i class="bi bi-envelope-fill input-icon"></i>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control form-control-gov" 
                                       value="<?= old('email') ?>" 
                                       placeholder="email@example.com">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="no_telp" class="form-label form-label-gov">
                                <i class="bi bi-whatsapp"></i>
                                No. Telp / WA
                            </label>
                            <div class="input-group-gov">
                                <i class="bi bi-telephone-fill input-icon"></i>
                                <input type="text" 
                                       name="no_telp" 
                                       id="no_telp" 
                                       class="form-control form-control-gov" 
                                       value="<?= old('no_telp') ?>" 
                                       placeholder="0812xxxx">
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="foto" class="form-label form-label-gov">
                                <i class="bi bi-image"></i>
                                Foto Avatar
                            </label>
                            <div class="input-group-gov">
                                <input type="file" 
                                       name="foto" 
                                       id="foto" 
                                       class="form-control form-control-gov" 
                                       accept="image/*">
                            </div>
                            <div class="form-text-gov small">Format: JPG, PNG. Maks 2MB.</div>
                        </div>
                    </div>
                </div>

                <div class="form-section-title mt-2">
                    <i class="bi bi-shield-lock"></i>
                    Keamanan
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label form-label-gov">
                            <i class="bi bi-key"></i>
                            Password
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control form-control-gov" 
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <i class="bi bi-eye password-toggle" id="togglePassword" style="cursor: pointer; margin-left: 10px;"></i>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                        <div class="password-strength-text" id="strengthText"></div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="password_confirm" class="form-label form-label-gov">
                            <i class="bi bi-check-all"></i>
                            Konfirmasi Password
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" 
                                   name="password_confirm" 
                                   id="password_confirm" 
                                   class="form-control form-control-gov" 
                                   placeholder="Ulangi password"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-section-title">
                    <i class="bi bi-shield-check"></i>
                    Hak Akses & Role
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="role" class="form-label form-label-gov">
                            <i class="bi bi-award"></i>
                            Role Pengguna
                            <span class="required">*</span>
                        </label>
                        <div class="input-group-gov">
                            <i class="bi bi-diagram-3 input-icon"></i>
                            <select name="role" id="role" class="form-select form-select-gov" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="superadmin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                        <div id="rolePreview" class="role-preview"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top form-actions">
                    <a href="<?= base_url('manage_user') ?>" class="btn btn-cancel-gov me-2">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-submit-gov">
                        <i class="bi bi-check-circle"></i>
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    /**
     * ==========================================
     * 1. CONFIGURATION
     * ==========================================
     */
    const USER_ROLES = {
        SUPERADMIN: {
            value: 'superadmin',
            title: '🔴 Super Administrator',
            desc: 'Akses penuh ke seluruh sistem, manajemen pengguna, konfigurasi, dan maintenance.'
        },
        ADMIN: {
            value: 'admin',
            title: '🔵 Administrator',
            desc: 'Dapat mengelola konten, data pengguna (terbatas), dan laporan operasional.'
        },
        EDITOR: {
            value: 'editor',
            title: '🟢 Editor',
            desc: 'Fokus pada manajemen konten: membuat berita, artikel, dan mengelola galeri.'
        }
    };

    const USER_TYPES = {
        NON_PEGAWAI: 'non_pegawai',
        PEGAWAI: 'pegawai'
    };

    /**
     * ==========================================
     * 2. MAIN LOGIC (DOM READY)
     * ==========================================
     */
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- VARIABLES ---
        const radioButtons = document.querySelectorAll('input[name="tipe_user"]');
        const nonPegawaiFields = document.getElementById('non_pegawai_fields');
        const identityLabel = document.getElementById('identity_label');
        const identityInput = document.getElementById('id_user');
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');

        // --- A. Handle User Type Toggle ---
        function toggleUserType(type) {
            if (type === USER_TYPES.PEGAWAI) {
                // Pegawai Mode
                identityLabel.innerHTML = '<i class="bi bi-person-badge"></i> NIP (Nomor Induk Pegawai) <span class="required">*</span>';
                identityInput.placeholder = 'Masukkan NIP Pegawai';
                nonPegawaiFields.classList.add('hidden');
                
                // Matikan required untuk field hidden
                usernameInput.removeAttribute('required');
                emailInput.removeAttribute('required');

            } else {
                // Non-Pegawai Mode
                identityLabel.innerHTML = '<i class="bi bi-card-heading"></i> NIK (Nomor Induk Kependudukan) <span class="required">*</span>';
                identityInput.placeholder = 'Masukkan 16 digit NIK';
                nonPegawaiFields.classList.remove('hidden');
                
                // Nyalakan required
                usernameInput.setAttribute('required', 'required');
                emailInput.setAttribute('required', 'required');
            }
        }

        radioButtons.forEach(radio => {
            radio.addEventListener('change', (e) => toggleUserType(e.target.value));
        });

        // Init toggle
        const checkedRadio = document.querySelector('input[name="tipe_user"]:checked');
        if(checkedRadio) toggleUserType(checkedRadio.value);


        // --- B. Handle Search Button (Simulasi Service) ---
        const btnCheck = document.getElementById('btn_check_data');
        const iconSearch = document.getElementById('icon_search');
        const iconLoading = document.getElementById('icon_loading');
        
        btnCheck.addEventListener('click', async function() {
            const idValue = identityInput.value.trim();
            const userType = document.querySelector('input[name="tipe_user"]:checked').value;

            // 1. Validasi Input Kosong
            if (!idValue) {
                alert('Mohon isi NIK/NIP terlebih dahulu sebelum mencari.');
                identityInput.focus();
                return;
            }

            // 2. Loading UI
            btnCheck.disabled = true;
            iconSearch.classList.add('d-none');
            iconLoading.classList.remove('d-none');
            // btnCheck.lastElementChild.textContent = ' Mencari...';

            try {
                // --- SIMULASI PEMANGGILAN API (Delay 1.5 detik) ---
                // Nanti ganti dengan fetch() ke controller sungguhan
                await new Promise(r => setTimeout(r, 1500));

                // Contoh Data Dummy
                const mockData = {
                    success: true,
                    data: {
                        full_name: "Budi Santoso (Data Otomatis)",
                        email: "budi.santoso@example.com",
                        no_telp: "081233334444",
                        username: "budi_s_auto"
                    }
                };

                if (mockData.success) {
                    const d = mockData.data;
                    
                    // Isi Field
                    document.getElementById('full_name').value = d.full_name;
                    document.getElementById('no_telp').value = d.no_telp;
                    
                    // Isi email/username jika mode Non-Pegawai
                    if(userType === USER_TYPES.NON_PEGAWAI) {
                        emailInput.value = d.email;
                        usernameInput.value = d.username;
                    } else {
                        // Jika pegawai, mungkin email diisi juga walau hidden (untuk backend)
                        emailInput.value = d.email;
                    }

                    // Feedback Visual
                    identityInput.classList.add('is-valid');
                    setTimeout(() => identityInput.classList.remove('is-valid'), 3000);
                    
                    // Pindah fokus ke Password agar user lanjut input
                    document.getElementById('password').focus();
                }

            } catch (error) {
                console.error("Error:", error);
                alert("Gagal mengambil data dari server.");
            } finally {
                // 3. Reset UI
                btnCheck.disabled = false;
                iconSearch.classList.remove('d-none');
                iconLoading.classList.add('d-none');
                // btnCheck.lastElementChild.textContent = 'Cari';
            }
        });


        // --- C. Role Preview Logic ---
        const roleSelect = document.getElementById('role');
        const rolePreview = document.getElementById('rolePreview');

        roleSelect.addEventListener('change', function(e) {
            const selectedVal = e.target.value;
            rolePreview.className = 'role-preview'; 
            
            if (!selectedVal) {
                rolePreview.classList.remove('show');
                return;
            }

            let roleData = null;
            for (const key in USER_ROLES) {
                if (USER_ROLES[key].value === selectedVal) {
                    roleData = USER_ROLES[key];
                    break;
                }
            }

            if (roleData) {
                rolePreview.classList.add('show', selectedVal);
                rolePreview.innerHTML = `
                    <div><strong>${roleData.title}</strong></div>
                    <div style="font-size: 0.85rem; margin-top: 4px; opacity: 0.9;">${roleData.desc}</div>
                `;
            }
        });


        // --- D. Form Submit Validation ---
        document.getElementById('userForm').addEventListener('submit', function(e) {
            const type = document.querySelector('input[name="tipe_user"]:checked').value;
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirm').value;
            
            // Auto-fill dummy username/email for Pegawai (prevent DB errors)
            if (type === USER_TYPES.PEGAWAI) {
                const nipVal = identityInput.value.trim();
                if(!usernameInput.value.trim()) usernameInput.value = nipVal; 
                if(!emailInput.value.trim()) emailInput.value = nipVal + '@internal.gov'; 
            }
            
            if (pass !== confirm) {
                e.preventDefault();
                alert('Konfirmasi password tidak cocok!');
                document.getElementById('password_confirm').focus();
                return false;
            }
            
            if (pass.length < 8) {
                e.preventDefault();
                alert('Password harus minimal 8 karakter!');
                document.getElementById('password').focus();
                return false;
            }
        });


        // --- E. Password & Username Utilities ---
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        usernameInput.addEventListener('input', function(e) {
            this.value = this.value.toLowerCase().replace(/\s+/g, '_');
        });
        
        // Password Strength Meter
        document.getElementById('password').addEventListener('input', function(e) {
             const password = e.target.value;
             const bar = document.getElementById('strengthBar');
             const text = document.getElementById('strengthText');
             const container = document.getElementById('passwordStrength');
             
             if(password.length === 0) {
                 container.classList.remove('show');
                 text.innerText = '';
                 return;
             }
             container.classList.add('show');
             
             let strength = 0;
             if(password.length > 7) strength += 40;
             if(/[A-Z]/.test(password)) strength += 20;
             if(/[0-9]/.test(password)) strength += 20;
             if(/[^A-Za-z0-9]/.test(password)) strength += 20;
             
             bar.style.width = strength + '%';
             if(strength < 50) { 
                bar.style.background = '#dc3545'; text.innerText = 'Lemah'; text.style.color = '#dc3545';
             } else if(strength < 80) { 
                bar.style.background = '#ffc107'; text.innerText = 'Sedang'; text.style.color = '#ffc107';
             } else { 
                bar.style.background = '#198754'; text.innerText = 'Kuat'; text.style.color = '#198754';
             }
        });
    });
</script>
<?= $this->endSection() ?>