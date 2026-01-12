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
        /* --- GENERAL RESET --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            margin: 0; 
            padding: 0; 
            overflow-x: hidden; 
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }

        /* --- LAYOUT --- */
        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            width: calc(100% - 260px);
        }

        /* --- MOBILE HEADER (Toggle Button) --- */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            z-index: 1020;
            align-items: center;
            padding: 0 1rem;
            gap: 1rem;
        }

        .mobile-header .toggle-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6366f1;
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            border-radius: 6px;
        }

        .mobile-header .toggle-btn:hover {
            background: #f3f4f6;
        }

        .mobile-header .header-title {
            font-weight: 600;
            font-size: 1rem;
            color: #111827;
            flex: 1;
        }

        /* --- STATUS TOGGLE BUTTON --- */
        .status-btn { 
            background: 0 0; 
            border: none; 
            padding: 0; 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            cursor: pointer; 
            transition: all .3s; 
        }
        .status-btn:hover { transform: scale(1.05); }
        .status-btn:disabled { cursor: not-allowed; opacity: .6; filter: grayscale(100%); }
        
        .status-btn .switch {
            position: relative; 
            width: 44px; 
            height: 24px;
            background-color: #cbd5e1; 
            border-radius: 20px;
            transition: all .3s cubic-bezier(0.4, 0.0, 0.2, 1);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }
        
        .status-btn .switch::after {
            content: ''; 
            position: absolute; 
            width: 20px; 
            height: 20px;
            background-color: #fff; 
            border-radius: 50%;
            top: 2px; 
            left: 2px;
            transition: all .3s cubic-bezier(0.4, 0.0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .status-btn .switch.active { background-color: #059669; }
        .status-btn .switch.active::after { left: 22px; }
        
        .status-btn .switch-label {
            font-size: 0.8rem; 
            font-weight: 600; 
            color: #334155;
            min-width: 65px; 
            text-align: left; 
            transition: color 0.3s;
            white-space: nowrap;
        }

        /* --- TOAST NOTIFICATION --- */
        #custom-toast-container {
            position: fixed; 
            top: 80px; 
            right: 20px; 
            z-index: 9999;
            display: flex; 
            flex-direction: column; 
            gap: 10px;
            max-width: calc(100vw - 40px);
        }
        
        .custom-toast {
            background: white; 
            border-left: 4px solid #059669;
            padding: 12px 20px; 
            border-radius: 4px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            display: flex; 
            align-items: center; 
            gap: 10px;
            min-width: 250px;
            max-width: 100%;
            transform: translateX(120%);
            transition: transform 0.3s ease-out;
            font-size: 0.9rem; 
            font-weight: 500; 
            color: #333;
        }
        
        .custom-toast.show { transform: translateX(0); }
        .custom-toast.error { border-left-color: #dc2626; }
        .custom-toast i { 
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .custom-toast.success i { color: #059669; }
        .custom-toast.error i { color: #dc2626; }

        .custom-toast span {
            flex: 1;
            word-wrap: break-word;
        }

        /* --- RESPONSIVE BREAKPOINTS --- */
        
        /* Tablet dan Mobile */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                width: 100%;
                padding-top: 80px;
            }

            .mobile-header {
                display: flex;
            }

            #custom-toast-container {
                top: 70px;
                right: 10px;
                left: 10px;
            }

            .custom-toast {
                min-width: auto;
                width: 100%;
            }
        }

        /* Mobile Small */
        @media (max-width: 576px) {
            .main-content {
                padding: 1rem;
                padding-top: 70px;
            }

            .mobile-header {
                height: 56px;
            }

            .mobile-header .header-title {
                font-size: 0.9rem;
            }

            .status-btn .switch {
                width: 40px;
                height: 22px;
            }

            .status-btn .switch::after {
                width: 18px;
                height: 18px;
            }

            .status-btn .switch.active::after {
                left: 20px;
            }

            .status-btn .switch-label {
                font-size: 0.75rem;
                min-width: 60px;
            }

            #custom-toast-container {
                top: 66px;
            }

            .custom-toast {
                padding: 10px 15px;
                font-size: 0.85rem;
            }

            .custom-toast i {
                font-size: 1.1rem;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 400px) {
            .main-content {
                padding: 0.75rem;
            }

            .status-btn {
                gap: 6px;
            }

            .custom-toast {
                padding: 8px 12px;
                font-size: 0.8rem;
                min-width: auto;
            }
        }

        /* Tablet Landscape */
        @media (min-width: 768px) and (max-width: 992px) {
            .main-content {
                padding: 1.5rem;
            }
        }

        /* Print Styles */
        @media print {
            .mobile-header,
            .status-btn,
            #custom-toast-container {
                display: none !important;
            }

            .main-content {
                margin-left: 0;
                padding: 0;
            }
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    
    <div id="custom-toast-container"></div>

    <!-- Mobile Header with Toggle Button -->
    <div class="mobile-header">
        <button class="toggle-btn" onclick="openSidebar()" aria-label="Toggle Menu">
            <i class="bi bi-list"></i>
        </button>
        <div class="header-title">Admin Panel</div>
    </div>

    <div class="layout-wrapper">
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
                    btn.prop('disabled', false);
                    
                    if (res.status === 'success') {
                        // Update Tampilan Switch
                        if (res.newStatus == 1) {
                            switchEl.addClass('active'); 
                            labelEl.text('Aktif');
                            showToast('Status berhasil diaktifkan', 'success');
                        } else {
                            switchEl.removeClass('active'); 
                            labelEl.text('Non-Aktif');
                            showToast('Status dinonaktifkan', 'success');
                        }

                        // Update Token CSRF
                        $('input[name="'+csrfName+'"]').val(res.token);

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

        // Prevent body scroll when sidebar is open on mobile
        function updateBodyScroll() {
            if (window.innerWidth <= 992) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar && sidebar.classList.contains('mobile-open')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            } else {
                document.body.style.overflow = '';
            }
        }

        // Call on load and resize
        window.addEventListener('load', updateBodyScroll);
        window.addEventListener('resize', updateBodyScroll);
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>