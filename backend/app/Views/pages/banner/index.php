<?= $this->extend('layouts/main') ?>
<?= $this->section('styles') ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    /* ===============================
   DESIGN SYSTEM (Selaras dengan Sidebar & Dashboard)
================================ */

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        /* Primary Colors */
        --primary: #6366f1;
        --primary-light: #eef2ff;
        --primary-dark: #4f46e5;

        /* Soft Colors */
        --primary-soft: #eef2ff;
        --primary-text: #4f46e5;
        --success-soft: #ecfdf5;
        --success-text: #059669;
        --danger-soft: #fef2f2;
        --danger-text: #dc2626;
        --warning-soft: #fffbeb;
        --warning-text: #d97706;
        --info-soft: #eff6ff;
        --info-text: #3b82f6;

        /* Neutral Colors */
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;

        /* Semantic Colors */
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;

        /* Surface */
        --bg-body: #f9fafb;
        --card-bg: #ffffff;
        --border: #e5e7eb;

        /* Shadows */
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--bg-body);
        color: var(--gray-900);
        font-size: 14px;
        line-height: 1.5;
    }

    .container-fluid {
        max-width: 100%;
        padding: 0 2rem;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 0 1rem;
        }
    }

    /* ===============================
   PAGE HEADER - Updated Style
================================ */

    .gov-header {
        background: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-bottom: 2px solid var(--gray-200);
    }

    .gov-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .gov-header h1 i {
        color: var(--primary);
    }

    /* Gradient Title */
    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Breadcrumb from system */
    .breadcrumb {
        background-color: var(--card-bg);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        margin-top: 1rem;
    }

    .breadcrumb-item a {
        text-decoration: none;
        font-weight: 600;
        color: var(--primary);
        font-size: 0.875rem;
    }

    .breadcrumb-item.active {
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    /* ===============================
   FILTER NAV - Updated Style
================================ */

    .filter-nav {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
        flex-wrap: wrap;
    }

    .filter-btn {
        background: var(--gray-50);
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
        padding: 0.625rem 1.25rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: var(--shadow-sm);
    }

    .filter-btn:hover {
        background: var(--gray-100);
        border-color: var(--gray-400);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }
    
    .filter-count {
        background: rgba(255, 255, 255, 0.25);
        padding: 0.125rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .filter-btn:not(.active) .filter-count {
        background: var(--gray-200);
        color: var(--gray-700);
    }

    /* ===============================
   ACTION BUTTONS - Updated Style
================================ */

    .action-buttons .btn {
        border-radius: 50px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        transition: all 0.2s;
        border: none;
        box-shadow: var(--shadow-sm);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-buttons .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .action-buttons .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .action-buttons .btn-primary:disabled {
        background: var(--gray-300);
        cursor: not-allowed;
        transform: none;
        box-shadow: var(--shadow-sm);
        opacity: 0.7;
    }

    /* Soft button styles */
    .btn-soft-primary { 
        background-color: var(--primary-soft); 
        color: var(--primary-text); 
        border: none; 
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-soft-primary:hover { 
        background-color: var(--primary); 
        color: white; 
        transform: translateY(-1px);
    }
    
    .btn-soft-danger { 
        background-color: var(--danger-soft); 
        color: var(--danger-text); 
        border: none; 
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-soft-danger:hover { 
        background-color: var(--danger); 
        color: white; 
        transform: translateY(-1px);
    }

    /* ===============================
   CARD - Updated Style
================================ */

    .table-card {
        border: none;
        background: var(--card-bg);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .table-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    /* ===============================
   TABLE - Updated Style
================================ */

    .gov-table {
        margin: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .gov-table thead {
        background: linear-gradient(135deg, var(--primary-soft) 0%, var(--info-soft) 100%);
        border-bottom: 2px solid var(--gray-200);
    }

    .gov-table thead th {
        color: var(--gray-700);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
        padding: 1rem;
        border-bottom: 2px solid var(--gray-200);
        white-space: nowrap;
        border: none;
    }

    .gov-table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
        background: var(--card-bg);
    }

    .gov-table tbody tr:hover {
        background-color: var(--gray-50);
        transform: translateX(5px);
        transition: transform 0.2s ease;
    }

    /* ===============================
   BANNER IMAGE - Updated Style
================================ */

    .banner-image {
        width: 120px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .banner-image:hover {
        border-color: var(--primary);
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    /* Image Hover Effect */
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .img-hover-zoom:hover {
        transform: scale(1.1);
        z-index: 10;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        cursor: zoom-in;
    }

    /* ===============================
   BADGES - Updated Style
================================ */

    .badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 50px;
        font-size: 0.75rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid;
    }

    .badge-blue { 
        background-color: var(--primary-soft); 
        color: var(--primary-text); 
        border-color: var(--primary-light);
    }
    
    .badge-yellow { 
        background-color: var(--warning-soft); 
        color: var(--warning-text); 
        border-color: #fde68a;
    }
    
    .badge-green { 
        background-color: var(--success-soft); 
        color: var(--success-text); 
        border-color: #a7f3d0;
    }

    .banner-title {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.9375rem;
    }

    /* Date info style */
    .date-info {
        display: flex;
        align-items: center;
        color: var(--gray-500);
        font-size: 0.7rem;
        gap: 0.25rem;
        margin-top: 0.25rem;
    }

    /* ===============================
   TABLE BUTTONS - Updated Style
================================ */

    .gov-table .btn {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.2s;
        border: none;
        box-shadow: var(--shadow-sm);
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        width: 100%;
        justify-content: center;
    }

    .gov-table .btn-warning {
        background: var(--warning);
        color: white;
    }

    .gov-table .btn-warning:hover {
        background: #d97706;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .gov-table .btn-danger {
        background: var(--danger);
        color: white;
    }

    .gov-table .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* ===============================
   IMAGE MODAL - Updated Style
================================ */

    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        backdrop-filter: blur(10px);
    }

    .image-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .image-modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        animation: zoomIn 0.3s ease;
    }

    .image-modal-content img {
        width: 100%;
        height: auto;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .modal-close {
        position: absolute;
        top: -50px;
        right: 0;
        color: white;
        font-size: 2rem;
        font-weight: bold;
        cursor: pointer;
        background: var(--danger);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        border: 2px solid white;
        box-shadow: var(--shadow-md);
    }

    .modal-close:hover {
        background: #b91c1c;
        transform: rotate(90deg) scale(1.1);
        box-shadow: var(--shadow-lg);
    }

    /* ===============================
   EMPTY STATE - Updated Style
================================ */

    .no-data {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-500);
    }

    .no-data i {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: 1rem;
        background: var(--gray-100);
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-sm);
    }

    .no-data h5 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .no-data p {
        color: var(--gray-500);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    /* ===============================
   STATUS BUTTON - Updated Style
================================ */

    .status-btn {
        background: none;
        border: none;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 0.375rem;
    }

    .status-btn:hover {
        background: var(--gray-100);
        transform: translateY(-1px);
    }

    .status-btn .switch {
        position: relative;
        width: 48px;
        height: 24px;
        background-color: var(--gray-300);
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    .status-btn .switch::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .status-btn .switch.active {
        background-color: var(--success);
    }

    .status-btn .switch.active::after {
        left: 26px;
    }

    .status-btn .switch-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--gray-700);
        min-width: 65px;
        text-align: left;
        transition: color 0.3s;
    }

    .status-btn .switch.active + .switch-label {
        color: var(--success-text);
    }

    /* ===============================
   CREATE/EDIT MODAL - Updated Style
================================ */

    .create-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        overflow-y: auto;
        animation: fadeIn 0.3s ease;
    }

    .create-modal.show {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 20px;
    }

    .modal-content-form {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 800px;
        width: 100%;
        position: relative;
        animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        margin: auto;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header-custom {
        padding: 1.5rem 2rem;
        border-bottom: 2px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 1.5rem 1.5rem 0 0;
    }

    .modal-header-custom h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modal-close-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.5rem;
        line-height: 1;
        box-shadow: var(--shadow-sm);
    }

    .modal-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg) scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .modal-body-custom {
        padding: 2rem;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
        background: var(--gray-50);
    }

    /* ===============================
   FORM STYLES - Updated
================================ */

    .form-group-modal {
        margin-bottom: 1.5rem;
    }

    .form-label-modal {
        font-weight: 600;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-modal i {
        color: var(--primary);
        opacity: 0.8;
    }

    .form-control-modal, .form-select-modal {
        background-color: var(--gray-50);
        border: 2px solid var(--gray-200);
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        transition: all 0.25s ease;
        color: var(--gray-900);
        width: 100%;
        font-family: 'Inter', sans-serif;
    }

    .form-control-modal:focus, .form-select-modal:focus {
        background-color: #fff;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        outline: none;
        transform: translateY(-1px);
    }

    .upload-area-modal {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-area-modal:hover {
        border-color: var(--primary);
        background: var(--primary-soft);
        transform: translateY(-2px);
    }

    .upload-icon-circle {
        width: 50px;
        height: 50px;
        background: var(--primary-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        color: var(--primary);
        transition: 0.3s;
        box-shadow: var(--shadow-sm);
    }

    .upload-area-modal:hover .upload-icon-circle {
        background: var(--primary);
        color: white;
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .current-img-preview {
        max-height: 100px;
        max-width: 200px;
        object-fit: contain;
        border-radius: 0.75rem;
        border: 2px solid var(--gray-200);
        padding: 0.5rem;
        background: white;
        box-shadow: var(--shadow-sm);
    }

    .media-input-group {
        display: none;
        animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-submit-modal {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-submit-modal:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .text-required {
        color: var(--danger);
        margin-left: 3px;
        font-weight: bold;
    }

    .form-text-modal {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* ===============================
   LIMIT INFO - Updated Style
================================ */

    .limit-info {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--warning-soft);
        border: 1px solid var(--warning);
        border-radius: 50px;
        font-size: 0.75rem;
        color: var(--warning-text);
        font-weight: 600;
        margin-top: 0.5rem;
        box-shadow: var(--shadow-sm);
    }

    .limit-info i {
        color: var(--warning-text);
    }

    /* ===============================
   ANIMATIONS
================================ */

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from {
            transform: scale(0.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* ===============================
   RESPONSIVE
================================ */

    @media (max-width: 768px) {
        .gov-header { 
            padding: 1.5rem 0; 
        }
        
        .gov-header h1 { 
            font-size: 1.375rem; 
        }
        
        .filter-nav { 
            gap: 0.5rem; 
            overflow-x: auto; 
            padding-bottom: 0.5rem; 
            flex-wrap: nowrap; 
            margin-top: 1rem;
            padding-top: 1rem;
        }
        
        .filter-btn { 
            white-space: nowrap; 
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
        }
        
        .gov-table thead th, 
        .gov-table tbody td { 
            padding: 0.875rem 0.75rem; 
            font-size: 0.8125rem; 
        }
        
        .action-buttons { 
            flex-direction: column; 
            gap: 0.5rem; 
        }
        
        .action-buttons .btn { 
            width: 100%; 
        }
        
        .banner-image { 
            width: 80px; 
            height: 50px; 
        }
        
        .modal-content-form { 
            margin: 1.25rem; 
        }
        
        .modal-body-custom { 
            padding: 1.5rem; 
        }
        
        .modal-header-custom {
            padding: 1.25rem;
        }
        
        .container-fluid {
            padding: 0 1rem;
        }
    }

    /* ===============================
   ADDITIONAL UTILITIES
================================ */

    .font-monospace {
        font-family: 'Courier New', monospace;
    }

    .rounded-pill {
        border-radius: 50px !important;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Page Header - Updated with system style -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">
                <i class="bi bi-card-image me-2"></i>
                Manajemen Banner
            </h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-th-large me-1 text-primary"></i> 
                Kelola banner untuk berbagai posisi di website.
            </p>
            <div class="mt-2">
                <span class="limit-info">
                    <i class="bi bi-info-circle me-1"></i>
                    Maksimal 1 banner per kategori
                </span>
            </div>
        </div>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Banner Management</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Navigation -->
    <div class="filter-nav">
        <button class="filter-btn active" onclick="filterTable('all', this)">
            <i class="bi bi-grid"></i> Semua
            <span class="filter-count" id="count-all">0</span>
        </button>
        <button class="filter-btn" onclick="filterTable('1', this)">
            <i class="bi bi-house"></i> Banner Utama
            <span class="filter-count" id="count-1">0</span>
        </button>
        <button class="filter-btn" onclick="filterTable('2', this)">
            <i class="bi bi-window"></i> Banner Popup
            <span class="filter-count" id="count-2">0</span>
        </button>
        <button class="filter-btn" onclick="filterTable('3', this)">
            <i class="bi bi-newspaper"></i> Banner Berita
            <span class="filter-count" id="count-3">0</span>
        </button>
        <button class="filter-btn" onclick="filterTable('4', this)">
            <i class="bi bi-file-text"></i> Banner Hal Berita
            <span class="filter-count" id="count-4">0</span>
        </button>
    </div>

    <?= $this->include('layouts/alerts') ?>

    <?php 
    // Hitung jumlah banner per kategori
    $categoryCounts = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0
    ];
    
    if (!empty($banners) && is_array($banners)) {
        foreach ($banners as $b) {
            if (isset($categoryCounts[$b['category_banner']])) {
                $categoryCounts[$b['category_banner']]++;
            }
        }
    }
    ?>

    <?php if (!empty($banners) && is_array($banners)): ?>
        <div class="card table-card mt-4">
            <div class="card-header bg-white py-4 border-0 d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Daftar Banner</h5>
                    <span class="text-muted small">Kelola banner untuk berbagai posisi di website</span>
                </div>
                
                <div class="action-buttons d-flex gap-2 mt-3 mt-md-0">
                    <button onclick="openCreateModal()" class="btn btn-primary" id="btnTambahBanner">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Banner
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table gov-table align-middle mb-0" id="bannerTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center py-3 text-uppercase font-monospace" width="60">#</th>
                                <th class="py-3 text-uppercase" width="300">Judul Banner</th>
                                <th class="text-center py-3 text-uppercase" width="150">Kategori</th>
                                <th class="text-center py-3 text-uppercase" width="100">Tipe Media</th>
                                <th class="text-center py-3 text-uppercase" width="180">Preview</th>
                                <th class="text-center py-3 text-uppercase" width="150">Status</th>
                                <th class="text-center py-3 text-uppercase" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($banners as $b): ?>
                                <tr class="banner-row" data-category="<?= $b['category_banner'] ?>">
                                    <td class="text-center">
                                        <span class="badge-number" style="background: var(--primary-soft); color: var(--primary-text); padding: 0.5rem 0.75rem; border-radius: 8px; font-weight: 700; font-size: 0.875rem;">
                                            <?= $no++ ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="banner-title"><?= esc($b['title']) ?></div>
                                        <div class="date-info">
                                            <i class="bi bi-sort-numeric-down me-1"></i>
                                            Urutan: <?= $b['sorting'] ?? '1' ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $kategori = [
                                                1 => ['nama' => 'Banner Utama', 'class' => 'badge-blue'],
                                                2 => ['nama' => 'Banner Popup', 'class' => 'badge-yellow'],
                                                3 => ['nama' => 'Banner Berita', 'class' => 'badge-green'],
                                                4 => ['nama' => 'Banner Hal Berita', 'class' => 'badge-blue'] 
                                            ];
                                            $kat = $kategori[$b['category_banner']] ?? ['nama' => '-', 'class' => 'badge-blue'];
                                        ?>
                                        <span class="badge <?= $kat['class'] ?>"><?= $kat['nama'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($b['media_type'])): ?>
                                            <span class="badge <?= $b['media_type'] == 'image' ? 'badge-blue' : 'badge-yellow' ?>">
                                                <?= $b['media_type'] == 'image' ? 'Gambar' : 'Video' ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($b['image'])): ?>
                                            <img 
                                                src="<?= base_url('uploads/banner/' . $b['image']) ?>" 
                                                alt="Banner" 
                                                class="banner-image img-hover-zoom"
                                                onclick="openImageModal(this.src, '<?= esc(addslashes($b['title'])) ?>')"
                                                title="Klik untuk memperbesar">
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">Tidak ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="status-btn" 
                                                data-id="<?= $b['id_banner'] ?>">
                                            <div class="switch <?= ($b['status'] == '1' ? 'active' : '') ?>"></div>
                                            <span class="switch-label">
                                                <?= ($b['status'] == '1' ? 'Aktif' : 'Nonaktif') ?>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column gap-2">
                                            <button onclick="openEditModal(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8') ?>)" 
                                               class="btn btn-warning btn-sm" 
                                               title="Edit Banner">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </button>
                                            <form action="<?= site_url('banner/'.$b['id_banner']) ?>" method="post" class="mb-0">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <?= csrf_field() ?>
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm w-100" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus banner ini?')"
                                                        title="Hapus Banner">
                                                    <i class="bi bi-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr id="noRowsMessage" style="display: none;">
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="bi bi-filter-circle"></i>
                                        </div>
                                        <h5>Tidak ada banner</h5>
                                        <p>Tidak ditemukan banner di kategori yang dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top-0 py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center text-muted small">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        <span>Total: <strong><?= count($banners) ?></strong> banner</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php 
                        $totalCategoriesFilled = 0;
                        foreach ($categoryCounts as $count) {
                            if ($count >= 1) $totalCategoriesFilled++;
                        }
                        ?>
                        <span class="badge <?= ($totalCategoriesFilled >= 4) ? 'bg-danger' : 'bg-primary' ?> px-3 py-2 rounded-pill">
                            <i class="bi bi-card-image me-1"></i>
                            <?= $totalCategoriesFilled ?>/4 Kategori Terisi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card table-card mt-4">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-card-image"></i>
                    </div>
                    <h5>Belum Ada Banner</h5>
                    <p>Mulai dengan menambahkan banner pertama untuk website Anda</p>
                    <button onclick="openCreateModal()" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Banner Pertama
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <div class="image-modal-content" onclick="event.stopPropagation()">
            <span class="modal-close" onclick="closeImageModal()" title="Tutup">&times;</span>
            <img id="modalImage" src="" alt="Preview">
        </div>
    </div>

    <!-- Create Banner Modal -->
    <div id="createBannerModal" class="create-modal">
        <div class="modal-content-form">
            <div class="modal-header-custom">
                <h2><i class="bi bi-plus-circle me-2"></i>Tambah Banner Baru</h2>
                <button type="button" class="modal-close-btn" onclick="closeCreateModal()">×</button>
            </div>
            <div class="modal-body-custom">
                <form action="<?= site_url('banner') ?>" method="post" enctype="multipart/form-data" id="createBannerForm">
                    <?= csrf_field() ?>

                    <div class="form-group-modal">
                        <label for="title" class="form-label-modal">
                            <i class="bi bi-type-h1"></i> Judul Banner <span class="text-required">*</span>
                        </label>
                        <input type="text" name="title" id="title" class="form-control-modal" 
                               placeholder="Contoh: Promo Diskon Akhir Tahun" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group-modal">
                                <label for="category_banner" class="form-label-modal">
                                    <i class="bi bi-layers"></i> Posisi Penempatan <span class="text-required">*</span>
                                </label>
                                <select name="category_banner" id="category_banner" class="form-select-modal" required>
                                    <option value="">-- Pilih Posisi --</option>
                                    <option value="1">Banner Utama (Header)</option>
                                    <option value="2">Banner Popup</option>
                                    <option value="3">Banner Berita</option>
                                    <option value="4">Banner Hal Berita</option> 
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group-modal">
                                <label for="sorting" class="form-label-modal">
                                    <i class="bi bi-sort-numeric-down"></i> Urutan
                                </label>
                                <input type="number" name="sorting" id="sorting" class="form-control-modal" 
                                       min="1" placeholder="1">
                                <div class="form-text-modal">
                                    <i class="bi bi-info-circle"></i>
                                    Urutan prioritas (1 = Pertama)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modal">
                        <label for="media_type" class="form-label-modal">
                            <i class="bi bi-collection-play"></i> Tipe Konten <span class="text-required">*</span>
                        </label>
                        <select name="media_type" id="media_type" class="form-select-modal" required onchange="handleMediaTypeModal('create')">
                            <option value="">-- Pilih Jenis Media --</option>
                            <option value="image">Gambar / Foto</option>
                            <option value="video">Video Youtube</option>
                        </select>
                    </div>

                    <div id="group_image_modal" class="form-group-modal media-input-group">
                        <label class="form-label-modal mb-2">Upload File Gambar <span class="text-required">*</span></label>
                        <div class="upload-area-modal" onclick="document.getElementById('image_modal').click()">
                            <input type="file" name="image" id="image_modal" accept="image/*" style="display:none" onchange="previewFileNameModal('create')">
                            
                            <div class="upload-icon-circle">
                                <i class="bi bi-cloud-arrow-up fs-4"></i>
                            </div>
                            
                            <span id="file-label-modal" class="fw-bold" style="color: var(--primary);">Klik area ini untuk memilih gambar</span>
                            <div class="form-text-modal text-center">
                                <i class="bi bi-image"></i>
                                Format: JPG, PNG (Max 2MB)
                            </div>
                        </div>
                    </div>

                    <div id="group_video_modal" class="form-group-modal media-input-group">
                        <div class="p-3 bg-white border border-danger border-opacity-25 rounded-3" style="background: var(--danger-soft) !important;">
                            <label for="url_yt" class="form-label-modal text-danger mb-2">
                                <i class="bi bi-youtube"></i> Link Video Youtube <span class="text-required">*</span>
                            </label>
                            <input type="url" name="url_yt" id="url_yt" class="form-control-modal border-danger border-opacity-25" 
                                   placeholder="https://youtube.com/watch?v=..." style="background: white;">
                            <div class="form-text-modal text-danger opacity-75">
                                <i class="bi bi-info-circle me-1"></i> Pastikan video berstatus Publik atau Tidak Terdaftar (Unlisted).
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modal">
                        <label for="url" class="form-label-modal">
                            <i class="bi bi-link-45deg"></i> Link Redirect (Opsional)
                        </label>
                        <input type="url" name="url" id="url" class="form-control-modal" 
                               placeholder="https://tujuannya.com">
                        <div class="form-text-modal">
                            <i class="bi bi-link"></i>
                            Pengunjung akan diarahkan ke link ini jika mengklik banner.
                        </div>
                    </div>

                    <div class="form-group-modal">
                        <label for="keterangan" class="form-label-modal">
                            <i class="bi bi-text-paragraph"></i> Keterangan (Opsional)
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control-modal" 
                                  placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-submit-modal">
                            <i class="bi bi-check-circle me-2"></i>Simpan Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Banner Modal -->
    <div id="editBannerModal" class="create-modal">
        <div class="modal-content-form">
            <div class="modal-header-custom">
                <h2><i class="bi bi-pencil me-2"></i>Edit Banner</h2>
                <button type="button" class="modal-close-btn" onclick="closeEditModal()">×</button>
            </div>
            <div class="modal-body-custom">
                <form action="" method="post" enctype="multipart/form-data" id="editBannerForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id_banner" id="edit_id_banner">

                    <div class="form-group-modal">
                        <label for="edit_title" class="form-label-modal">
                            <i class="bi bi-type-h1"></i> Judul Banner <span class="text-required">*</span>
                        </label>
                        <input type="text" name="title" id="edit_title" class="form-control-modal" 
                               placeholder="Contoh: Promo Diskon Akhir Tahun" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group-modal">
                                <label for="edit_category_banner" class="form-label-modal">
                                    <i class="bi bi-layers"></i> Posisi Penempatan <span class="text-required">*</span>
                                </label>
                                <select name="category_banner" id="edit_category_banner" class="form-select-modal" required>
                                    <option value="">-- Pilih Posisi --</option>
                                    <option value="1">Banner Utama (Header)</option>
                                    <option value="2">Banner Popup</option>
                                    <option value="3">Banner Berita</option>
                                    <option value="4">Banner Hal Berita</option> 
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group-modal">
                                <label for="edit_sorting" class="form-label-modal">
                                    <i class="bi bi-sort-numeric-down"></i> Urutan
                                </label>
                                <input type="number" name="sorting" id="edit_sorting" class="form-control-modal" 
                                       min="1" placeholder="1">
                                <div class="form-text-modal">
                                    <i class="bi bi-info-circle"></i>
                                    Urutan prioritas (1 = Pertama)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modal">
                        <label for="edit_media_type" class="form-label-modal">
                            <i class="bi bi-collection-play"></i> Tipe Konten <span class="text-required">*</span>
                        </label>
                        <select name="media_type" id="edit_media_type" class="form-select-modal" required onchange="handleMediaTypeModal('edit')">
                            <option value="">-- Pilih Jenis Media --</option>
                            <option value="image">Gambar / Foto</option>
                            <option value="video">Video Youtube</option>
                        </select>
                    </div>

                    <div id="edit_group_image_modal" class="form-group-modal media-input-group">
                        <label class="form-label-modal mb-2">Upload File Gambar Baru</label>
             
                        <div id="current_image_container" class="mb-3" style="display:none;">
                            <p class="text-muted small mb-2">Gambar Saat Ini:</p>
                            <img id="current_image_preview" src="" alt="Current" class="current-img-preview">
                        </div>

                        <div class="upload-area-modal" onclick="document.getElementById('edit_image_modal').click()">
                            <input type="file" name="image" id="edit_image_modal" accept="image/*" style="display:none" onchange="previewFileNameModal('edit')">
                            
                            <div class="upload-icon-circle">
                                <i class="bi bi-cloud-arrow-up fs-4"></i>
                            </div>
                            
                            <span id="edit_file-label-modal" class="fw-bold" style="color: var(--primary);">Klik area ini untuk memilih gambar baru</span>
                            <div class="form-text-modal text-center">
                                <i class="bi bi-info-circle"></i>
                                Format: JPG, PNG (Max 2MB) • Kosongkan jika tidak ingin mengubah
                            </div>
                        </div>
                    </div>

                    <div id="edit_group_video_modal" class="form-group-modal media-input-group">
                        <div class="p-3 bg-white border border-danger border-opacity-25 rounded-3" style="background: var(--danger-soft) !important;">
                            <label for="edit_url_yt" class="form-label-modal text-danger mb-2">
                                <i class="bi bi-youtube"></i> Link Video Youtube <span class="text-required">*</span>
                            </label>
                            <input type="url" name="url_yt" id="edit_url_yt" class="form-control-modal border-danger border-opacity-25" 
                                   placeholder="https://youtube.com/watch?v=..." style="background: white;">
                            <div class="form-text-modal text-danger opacity-75">
                                <i class="bi bi-info-circle me-1"></i> Pastikan video berstatus Publik atau Tidak Terdaftar (Unlisted).
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modal">
                        <label for="edit_url" class="form-label-modal">
                            <i class="bi bi-link-45deg"></i> Link Redirect (Opsional)
                        </label>
                        <input type="url" name="url" id="edit_url" class="form-control-modal" 
                               placeholder="https://tujuannya.com">
                        <div class="form-text-modal">
                            <i class="bi bi-link"></i>
                            Pengunjung akan diarahkan ke link ini jika mengklik banner.
                        </div>
                    </div>

                    <div class="form-group-modal">
                        <label for="edit_keterangan" class="form-label-modal">
                            <i class="bi bi-text-paragraph"></i> Keterangan (Opsional)
                        </label>
                        <textarea name="keterangan" id="edit_keterangan" rows="3" class="form-control-modal" 
                                  placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn-submit-modal">
                            <i class="bi bi-check-circle me-2"></i>Update Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Category count from PHP - PERBAIKAN DI SINI
const categoryCount = {
    '1': <?= $categoryCounts[1] ?? 0 ?>,
    '2': <?= $categoryCounts[2] ?? 0 ?>,
    '3': <?= $categoryCounts[3] ?? 0 ?>,
    '4': <?= $categoryCounts[4] ?? 0 ?>
};

function updateButtonStates() {
    const total = Object.values(categoryCount).reduce((a,b) => a+b, 0);
    document.getElementById('count-all').textContent = total;
    document.getElementById('count-1').textContent = categoryCount['1'];
    document.getElementById('count-2').textContent = categoryCount['2'];
    document.getElementById('count-3').textContent = categoryCount['3'];
    document.getElementById('count-4').textContent = categoryCount['4']; 

    const allFull = categoryCount['1'] >= 1 && categoryCount['2'] >= 1 && categoryCount['3'] >= 1 && categoryCount['4'] >= 1; 
    const btnTambah = document.getElementById('btnTambahBanner');
    
    if (allFull) {
        btnTambah.disabled = true;
        btnTambah.title = 'Semua kategori sudah terisi (maksimal 1 banner per kategori)';
        btnTambah.innerHTML = '<i class="bi bi-lock me-2"></i>Batas Banner Tercapai';
    } else {
        btnTambah.disabled = false;
        btnTambah.title = 'Tambah Banner Baru';
        btnTambah.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Tambah Banner';
    }
}

function filterTable(category, btnElement) {
    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    btnElement.classList.add('active');

    const rows = document.querySelectorAll('.banner-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const rowCat = row.getAttribute('data-category');
        if (category === 'all' || rowCat === category) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const noMsg = document.getElementById('noRowsMessage');
    if (visibleCount === 0) {
        noMsg.style.display = '';
    } else {
        noMsg.style.display = 'none';
    }
}

function openImageModal(imageSrc, imageName) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    
    modal.classList.add('show');
    modalImg.src = imageSrc;
    modalImg.alt = imageName;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

function openCreateModal() {
    const modal = document.getElementById('createBannerModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    document.getElementById('createBannerForm').reset();
    handleMediaTypeModal('create');
    
    const selectKategori = document.getElementById('category_banner');
    Array.from(selectKategori.options).forEach(option => {
        if (option.value && categoryCount[option.value] >= 1) {
            option.disabled = true;
            option.text = option.text + ' (Penuh)';
        } else {
            option.disabled = false;
            option.text = option.text.replace(' (Penuh)', '');
        }
    });
}

function closeCreateModal() {
    const modal = document.getElementById('createBannerModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

function openEditModal(banner) {
    const modal = document.getElementById('editBannerModal');
    const form = document.getElementById('editBannerForm');
    
    form.action = '<?= site_url('banner/') ?>' + banner.id_banner;
    
    document.getElementById('edit_id_banner').value = banner.id_banner;
    document.getElementById('edit_title').value = banner.title;
    document.getElementById('edit_category_banner').value = banner.category_banner;
    document.getElementById('edit_sorting').value = banner.sorting || '';
    document.getElementById('edit_media_type').value = banner.media_type;
    document.getElementById('edit_url').value = banner.url || '';
    document.getElementById('edit_url_yt').value = banner.url_yt || '';
    document.getElementById('edit_keterangan').value = banner.keterangan || '';
    
    if (banner.media_type === 'image' && banner.image) {
        const imgContainer = document.getElementById('current_image_container');
        const imgPreview = document.getElementById('current_image_preview');
        imgContainer.style.display = 'block';
        imgPreview.src = '<?= base_url('uploads/banner/') ?>' + banner.image;
    } else {
        document.getElementById('current_image_container').style.display = 'none';
    }
    
    handleMediaTypeModal('edit');
    
    const selectKategori = document.getElementById('edit_category_banner');
    Array.from(selectKategori.options).forEach(option => {
        if (option.value && option.value != banner.category_banner && categoryCount[option.value] >= 1) {
            option.disabled = true;
            option.text = option.text.replace(' (Penuh)', '') + ' (Penuh)';
        } else {
            option.disabled = false;
            option.text = option.text.replace(' (Penuh)', '');
        }
    });
    
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    const modal = document.getElementById('editBannerModal');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

function handleMediaTypeModal(mode) {
    const prefix = mode === 'edit' ? 'edit_' : '';
    const type = document.getElementById(prefix + 'media_type').value;
    const groupImage = document.getElementById(prefix + 'group_image_modal');
    const inputImage = document.getElementById(prefix + 'image_modal');
    const groupVideo = document.getElementById(prefix + 'group_video_modal');
    const inputVideo = document.getElementById(prefix + 'url_yt');

    groupImage.style.display = 'none';
    groupVideo.style.display = 'none';
    inputImage.required = false;
    inputVideo.required = false;

    if (type === 'image') {
        groupImage.style.display = 'block';
        if (mode === 'create') {
            inputImage.required = true;
        }
        inputVideo.value = '';
    } else if (type === 'video') {
        groupVideo.style.display = 'block';
        inputVideo.required = true;
        inputImage.value = '';
    }
}

function previewFileNameModal(mode) {
    const prefix = mode === 'edit' ? 'edit_' : '';
    const input = document.getElementById(prefix + 'image_modal');
    const label = document.getElementById(prefix + 'file-label-modal');
    
    if(input.files && input.files[0]) {
        label.innerText = "File Terpilih: " + input.files[0].name;
        label.style.color = "var(--success-text)";
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
        closeCreateModal();
        closeEditModal();
    }
});

// Close modals when clicking outside
document.getElementById('createBannerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateModal();
    }
});

document.getElementById('editBannerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Status toggle with AJAX
$(document).on('click', '.status-btn', function () {
    let btn = $(this);
    let id = btn.data('id');
    let switchEl = btn.find('.switch');
    let labelEl = btn.find('.switch-label');
    
    let csrfName = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    btn.css('opacity', '0.6').prop('disabled', true);

    $.ajax({
        url: "<?= site_url('banner/toggle-status') ?>",
        type: "POST",
        data: { 
            id: id,
            [csrfName]: csrfHash 
        },
        dataType: "json",
        success: function(res) {
            btn.css('opacity', '1').prop('disabled', false);

            if (res.status === 'success') {
                if (res.token) {
                    csrfHash = res.token;
                    $('input[name="' + csrfName + '"]').val(csrfHash);
                }

                if (res.newStatus == 1) {
                    switchEl.addClass('active');
                    labelEl.text('Aktif');
                    labelEl.css('color', 'var(--success-text)');
                    
                    // Show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Banner telah diaktifkan',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        background: 'var(--success-soft)',
                        color: 'var(--success-text)'
                    });
                } else {
                    switchEl.removeClass('active');
                    labelEl.text('Nonaktif');
                    labelEl.css('color', 'var(--gray-700)');
                    
                    // Show info notification
                    Swal.fire({
                        icon: 'info',
                        title: 'Diupdate',
                        text: 'Banner telah dinonaktifkan',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        background: 'var(--info-soft)',
                        color: 'var(--info-text)'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: res.message || 'Terjadi kesalahan',
                    confirmButtonColor: 'var(--primary)',
                    background: 'var(--danger-soft)',
                    color: 'var(--danger-text)'
                });
            }
        },
        error: function(xhr, status, error) {
            btn.css('opacity', '1').prop('disabled', false);
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal menghubungi server',
                confirmButtonColor: 'var(--primary)',
                background: 'var(--danger-soft)',
                color: 'var(--danger-text)'
            });
        }
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateButtonStates();
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
    
    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});
</script>

<?= $this->endSection() ?>