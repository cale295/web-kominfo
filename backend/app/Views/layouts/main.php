<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #212529;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .main-content {
            margin-left: 265px;
            min-height: 100vh;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .toggle-sidebar {
                display: block !important;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 999;
                background-color: #212529;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
            }
        }
        
        .toggle-sidebar {
            display: none;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #2c3034;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #495057;
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #6c757d;
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="bi bi-list"></i>
    </button>
    
    <div class="d-flex">
        <?= view('components/sidebar') ?>
        
        <div class="main-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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