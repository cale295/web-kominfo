<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* --- STYLE TOGGLE (DIPERBAGUS) --- */
        .status-btn { background: 0 0; border: none; padding: 0; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all .3s; }
        .status-btn:hover { transform: scale(1.05); } /* Efek zoom dikit saat hover */
        .status-btn:disabled { cursor: not-allowed; opacity: .6; filter: grayscale(100%); }
        
        .status-btn .switch {
            position: relative; width: 44px; height: 24px;
            background-color: #cbd5e1; border-radius: 20px;
            transition: all .3s cubic-bezier(0.4, 0.0, 0.2, 1);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .status-btn .switch::after {
            content: ''; position: absolute; width: 20px; height: 20px;
            background-color: #fff; border-radius: 50%;
            top: 2px; left: 2px;
            transition: all .3s cubic-bezier(0.4, 0.0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .status-btn .switch.active { background-color: #059669; }
        .status-btn .switch.active::after { left: 22px; }
        
        .status-btn .switch-label {
            font-size: 0.8rem; font-weight: 600; color: #334155;
            min-width: 65px; text-align: left; transition: color 0.3s;
        }

        /* --- TOAST NOTIFICATION (PEMBERITAHUAN MELAYANG) --- */
        #custom-toast-container {
            position: fixed; top: 20px; right: 20px; z-index: 9999;
            display: flex; flex-direction: column; gap: 10px;
        }
        
        .custom-toast {
            background: white; border-left: 4px solid #059669;
            padding: 12px 20px; border-radius: 4px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            display: flex; align-items: center; gap: 10px;
            min-width: 250px; transform: translateX(120%);
            transition: transform 0.3s ease-out;
            font-size: 0.9rem; font-weight: 500; color: #333;
        }
        
        .custom-toast.show { transform: translateX(0); }
        .custom-toast.error { border-left-color: #dc2626; }
        .custom-toast i { font-size: 1.2rem; }
        .custom-toast.success i { color: #059669; }
        .custom-toast.error i { color: #dc2626; }

        /* --- LAYOUT UTAMA --- */
        body { margin: 0; padding: 0; overflow-x: hidden; background-color: #f8fafc; }
        
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 250px;
            background-color: #212529; overflow-y: auto; z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .main-content {
            margin-left: 265px; min-height: 100vh; padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; width: 100%; }
            .toggle-sidebar {
                display: block !important; position: fixed; top: 15px; left: 15px; z-index: 999;
                background-color: #212529; color: white; border: none;
                padding: 10px 15px; border-radius: 5px; cursor: pointer;
            }
        }
        .toggle-sidebar { display: none; }
        
        /* Scrollbar Cantik */
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: #2c3034; }
        .sidebar::-webkit-scrollbar-thumb { background: #495057; border-radius: 3px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: #6c757d; }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    
    <div id="custom-toast-container"></div>

    <div class="d-flex">
        <?= view('components/sidebar') ?>
        
        <div class="main-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Fungsi Membuat Notifikasi (Toast)
        function showToast(message, type = 'success') {
            const container = $('#custom-toast-container');
            const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
            
            const toastHtml = `
                <div class="custom-toast ${type}">
                    <i class="bi ${icon}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            const $toast = $(toastHtml);
            container.append($toast);
            
            // Animasi Masuk
            setTimeout(() => $toast.addClass('show'), 10);
            
            // Hilang otomatis setelah 3 detik
            setTimeout(() => {
                $toast.removeClass('show');
                setTimeout(() => $toast.remove(), 300);
            }, 3000);
        }

        // Logic Toggle Status
        $(document).on('click', '.status-btn', function () {
            let btn = $(this);
            let switchEl = btn.find('.switch');
            let labelEl = btn.find('.switch-label');
            let csrfName = '<?= csrf_token() ?>'; 
            let csrfHash = $('input[name="'+csrfName+'"]').val(); 

            // Efek Loading (Disable tombol)
            btn.prop('disabled', true);

            $.ajax({
                url: btn.data('url'),
                type: "POST",
                data: { id: btn.data('id'), [csrfName]: csrfHash },
                dataType: "json",
                success: function(res) {
                    btn.prop('disabled', false); // Aktifkan lagi
                    
                    if (res.status === 'success') {
                        // Update Tampilan Switch
                        if (res.newStatus == 1) {
                            switchEl.addClass('active'); 
                            labelEl.text('Aktif');
                            showToast('Status berhasil diaktifkan', 'success');
                        } else {
                            switchEl.removeClass('active'); 
                            labelEl.text('Non-Aktif');
                            showToast('Status dinonaktifkan', 'success'); // Toast Abu/Success
                        }

                        // Update Token CSRF
                        $('input[name="'+csrfName+'"]').val(res.token);

                        // OPSI: Jika ANDA TETAP INGIN SCROLL KE ATAS (Hapus tanda // di bawah ini)
                        // window.scrollTo({ top: 0, behavior: 'smooth' });

                    } else {
                        showToast(res.message, 'error');
                        if(res.token) $('input[name="'+csrfName+'"]').val(res.token);
                    }
                },
                error: function() {
                    btn.prop('disabled', false);
                    showToast('Gagal terhubung ke server', 'error');
                }
            });
        });
    </script>

    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.sidebar');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>