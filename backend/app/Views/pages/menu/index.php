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

        /* Soft Colors from second code */
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
        --success-light: #d1fae5;
        --warning: #f59e0b;
        --warning-light: #fef3c7;
        --danger: #ef4444;
        --danger-light: #fee2e2;
        --info: #06b6d4;
        --info-light: #cffafe;

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

    .cursor-pointer {
        cursor: pointer;
    }

    /* Gradient Title from second code */
    .text-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ===============================
   PAGE HEADER - Updated with second code style
================================ */

    .page-header {
        background: var(--card-bg);
        border: none;
        padding: 1.5rem 0;
        margin-bottom: 2rem;
        border-radius: 0;
    }

    .page-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .page-header h2 i {
        color: var(--primary);
    }

    .page-header p {
        color: var(--gray-500);
        font-size: 0.875rem;
        margin-bottom: 0;
        font-weight: 500;
    }

    /* Breadcrumb from second code */
    .breadcrumb {
        background-color: var(--card-bg);
        padding: 0.75rem 1.25rem;
        border-radius: 50px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }

    .breadcrumb-item a {
        text-decoration: none;
        font-weight: 600;
        color: var(--primary);
    }

    .breadcrumb-item.active {
        color: var(--gray-600);
    }

    /* ===============================
   CARD - Updated with second code style
================================ */

    .menu-card {
        background: var(--card-bg);
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .menu-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    /* ===============================
   BUTTONS - Updated with soft button style
================================ */

    .btn-primary-custom {
        background: var(--primary);
        border: none;
        padding: 0.625rem 1.5rem;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: var(--shadow-md);
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }

    /* Soft Buttons from second code */
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

    /* Add Submenu Button - NEW */
    .btn-add-submenu {
        background-color: var(--success-soft);
        color: var(--success-text);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 50%;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: var(--shadow-sm);
        width: 32px;
        height: 32px;
    }

    .btn-add-submenu:hover {
        background-color: var(--success);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: var(--primary-soft);
        color: var(--primary-text);
        transition: all 0.2s;
        font-size: 0.875rem;
        box-shadow: var(--shadow-sm);
    }

    .btn-action:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-action.btn-delete {
        background: var(--danger-soft);
        color: var(--danger-text);
    }

    .btn-action.btn-delete:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
    }

    /* ===============================
   TABLE - Updated with second code style
================================ */

    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead {
        background: linear-gradient(135deg, var(--primary-soft) 0%, var(--info-soft) 100%);
        border-bottom: 2px solid var(--gray-200);
    }

    .table thead th {
        border: none;
        padding: 1rem;
        font-weight: 700;
        font-size: 0.75rem;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--gray-200);
    }

    .table tbody td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
        background: var(--card-bg);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-hover tbody tr:hover {
        background-color: var(--gray-50);
    }

    /* ===============================
   PARENT ROW
================================ */

    .parent-row {
        transition: all 0.2s ease;
        background: var(--card-bg);
    }

    .parent-row:hover {
        background-color: var(--gray-50);
        transform: translateX(5px);
    }

    .parent-row.expanded {
        background-color: var(--gray-50);
    }

    /* ===============================
   CHILD ROW
================================ */

    .child-row {
        background: var(--gray-50);
        display: none;
        transition: all 0.3s ease;
    }

    .child-row:hover {
        background: var(--gray-100);
    }

    .child-row.show {
        display: table-row;
        animation: fadeInRow 0.3s ease;
    }

    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===============================
   TOGGLE ICON
================================ */

    .toggle-icon {
        transition: transform 0.3s ease;
        display: inline-block;
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .parent-row.expanded .toggle-icon {
        transform: rotate(90deg);
        color: var(--primary);
    }

    /* ===============================
   MENU ICON - Updated with second code style
================================ */

    .menu-icon-box {
        width: 48px;
        height: 48px;
        background: var(--primary-soft);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1.25rem;
        flex-shrink: 0;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }

    .parent-row:hover .menu-icon-box {
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .menu-icon-small {
        width: 36px;
        height: 36px;
        background: var(--gray-100);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        font-size: 0.875rem;
        box-shadow: var(--shadow-sm);
    }

    /* Icon wrapper from second code */
    .icon-wrapper {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 10px;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
    }

    /* ===============================
   TREE LINE
================================ */

    .tree-line {
        position: relative;
        padding-left: 28px;
        margin-left: 16px;
    }

    .tree-line::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 20px;
        height: 2px;
        background: var(--primary-light);
        border-radius: 2px;
    }

    .tree-line::after {
        content: "";
        position: absolute;
        left: 0;
        top: -100%;
        width: 2px;
        height: 200%;
        background: var(--primary-light);
        border-radius: 2px;
    }

    /* ===============================
   TOGGLE SWITCH - Updated style
================================ */

    .form-switch .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
        border: 2px solid var(--gray-300);
        background-color: white;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-switch .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .form-switch .form-check-input:focus {
        box-shadow: 0 0 0 3px var(--primary-soft);
        border-color: var(--primary);
    }

    .form-switch .form-check-input:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .status-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--gray-500);
        margin-left: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
    }

    .status-label.active {
        color: var(--primary);
    }

    /* ===============================
   BADGES - Updated with second code style
================================ */

    .badge-custom {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        box-shadow: var(--shadow-sm);
        transition: all 0.2s;
    }

    .badge-primary-custom {
        background: var(--primary-soft);
        color: var(--primary-text);
        border: 1px solid var(--primary-light);
    }

    .badge-secondary-custom {
        background: var(--gray-100);
        color: var(--gray-600);
        border: 1px solid var(--gray-200);
    }

    .badge-number {
        background: var(--primary-soft);
        color: var(--primary-text);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 700;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--primary-light);
    }

    .submenu-count {
        background: var(--info-soft);
        color: var(--info-text);
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        border: 1px solid var(--info-light);
    }

    /* ===============================
   CODE/URL DISPLAY - Updated style
================================ */

    code {
        background: var(--gray-50);
        color: var(--gray-900);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-family: 'Courier New', monospace;
        font-weight: 500;
        border: 1px solid var(--gray-200);
        display: inline-block;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* URL Link button from second code */
    .url-link {
        background: var(--gray-50);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        border: 1px solid var(--gray-200);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
        max-width: 250px;
    }

    .url-link:hover {
        background: var(--primary-soft);
        border-color: var(--primary);
        transform: translateY(-1px);
        text-decoration: none;
        color: var(--primary);
    }

    /* ===============================
   EMPTY STATE - Updated style
================================ */

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--gray-400);
        box-shadow: var(--shadow-sm);
    }

    .empty-state h5 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--gray-500);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }

    /* ===============================
   MENU NAME SECTION
================================ */

    .menu-name-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .menu-name-text {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .menu-name-title {
        font-weight: 700;
        color: var(--gray-900);
        font-size: 0.9375rem;
    }

    /* Date info from second code */
    .date-info {
        display: flex;
        align-items: center;
        color: var(--gray-500);
        font-size: 0.7rem;
        gap: 0.25rem;
    }

    /* ===============================
   MODAL STYLES - Updated with second code style
================================ */

    .modal-content {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 1.5rem 1.5rem 0 0;
        padding: 1.5rem 2rem;
        border: none;
    }

    .modal-header .modal-title {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 2rem;
        background: var(--gray-50);
    }

    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border);
        background: var(--gray-100);
        border-radius: 0 0 1.5rem 1.5rem;
    }

    /* Form Styles in Modal - Updated */
    .form-label-modal {
        font-weight: 700;
        color: var(--gray-800);
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-modal i {
        color: var(--primary);
    }

    .required {
        color: var(--danger);
        font-weight: 700;
    }

    .input-group-modal {
        position: relative;
    }

    .input-icon-modal {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-500);
        z-index: 10;
    }

    .form-control-modal,
    .form-select-modal {
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control-modal:focus,
    .form-select-modal:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-soft);
        transform: translateY(-1px);
    }

    .form-control-modal[readonly] {
        background-color: var(--gray-100);
        color: var(--gray-600);
        cursor: not-allowed;
        border-color: var(--gray-300);
    }

    .form-text-modal {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Modal Buttons - Updated */
    .btn-modal-cancel {
        background: var(--gray-200);
        border: none;
        color: var(--gray-700);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-modal-cancel:hover {
        background: var(--gray-300);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-modal-submit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .btn-modal-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
    }

    .btn-modal-delete {
        background: var(--danger);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-modal-delete:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ===============================
   ALERTS - Updated with second code style
================================ */

    .alert {
        border: none;
        border-radius: 12px;
        box-shadow: var(--shadow-md);
        border-left: 4px solid;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: var(--success-soft);
        border-left-color: var(--success);
    }

    .alert-danger {
        background: var(--danger-soft);
        border-left-color: var(--danger);
    }

    .alert .btn-close {
        box-shadow: none;
    }

    /* Alert icon from second code */
    .alert-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 50%;
        box-shadow: var(--shadow-sm);
    }

    /* ===============================
   CARD HEADER & FOOTER - From second code
================================ */

    .card-header {
        background: white;
        border-bottom: 2px solid var(--gray-200);
        padding: 1.5rem 1.5rem;
    }

    .card-footer {
        background: white;
        border-top: 2px solid var(--gray-200);
        padding: 1.25rem 1.5rem;
    }

    /* ===============================
   RESPONSIVE
================================ */

    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 0;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .table thead th,
        .table tbody td {
            padding: 1rem 0.75rem;
            font-size: 0.8125rem;
        }

        .btn-primary-custom {
            padding: 0.75rem 1.25rem;
            font-size: 0.8125rem;
        }

        .menu-icon-box {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .tree-line {
            padding-left: 20px;
            margin-left: 12px;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-header {
            padding: 1.25rem;
        }
    }

    /* ===============================
   CONTAINER
================================ */

    .container-fluid {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /* ===============================
   ADDITIONAL STYLES FROM SECOND CODE
================================ */

    /* Image Hover Effect from second code */
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .img-hover-zoom:hover {
        transform: scale(1.1);
        z-index: 10;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        cursor: zoom-in;
    }

    /* Form switch from second code */
    .form-switch .form-check-input {
        width: 2.75em;
        height: 1.5em;
    }

    /* Font monospace for numbers */
    .font-monospace {
        font-family: 'Courier New', monospace;
    }

    /* Rounded pill styles */
    .rounded-pill {
        border-radius: 50px !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layouts/alerts') ?>

<div class="container-fluid py-4">
    <!-- Page Header - Updated with second code structure -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between my-4 py-2">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bolder mb-1 text-gradient">
                <i class="bi bi-list-ul me-2"></i>
                <?= esc($title) ?>
            </h1>
            <p class="text-muted small mb-0">
                <i class="fas fa-th-large me-1 text-primary"></i>
                <?= count($menus) ?> total menu dalam sistem. Kelola struktur menu dan navigasi website.
            </p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white px-3 py-2 rounded-pill shadow-sm mb-0 border">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none fw-bold text-primary small"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active small" aria-current="page">Menu Management</li>
            </ol>
        </nav>
    </div>

    <!-- Menu Card - Updated structure -->
    <div class="menu-card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Daftar Menu</h5>
                    <span class="text-muted small">Struktur hierarki menu website & admin panel</span>
                </div>

                <?php if ($can_create): ?>
                    <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="openCreateModal()">
                        <i class="bi bi-plus-lg me-2"></i>
                        Tambah Menu
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center py-3 text-uppercase font-monospace" width="5%">#</th>
                            <th class="py-3 text-uppercase" width="30%">Nama Menu</th>
                            <th class="py-3 text-uppercase" width="20%">URL / Route</th>
                            <th class="py-3 text-uppercase" width="15%">Admin URL</th>
                            <th class="text-center py-3 text-uppercase" width="12%">Status</th>
                            <th class="text-center py-3 text-uppercase" width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $parents = array_filter($menus, fn($m) => $m['parent_id'] == 0 || empty($m['parent_id']));
                        $allChildren = array_filter($menus, fn($m) => !empty($m['parent_id']) && $m['parent_id'] != 0);

                        $groupedChildren = [];
                        foreach ($allChildren as $child) {
                            $groupedChildren[$child['parent_id']][] = $child;
                        }

                        $counter = 1;

                        if (empty($parents)): ?>
                            <tr>
                                <td colspan="6" class="p-0">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="bi bi-inbox"></i>
                                        </div>
                                        <h5>Belum Ada Menu</h5>
                                        <p>Mulai dengan menambahkan menu pertama untuk sistem Anda</p>
                                        <?php if ($can_create): ?>
                                            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#menuModal" onclick="openCreateModal()">
                                                <i class="bi bi-plus-lg"></i>
                                                Tambah Menu
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif;

                        foreach ($parents as $parent):
                            $hasChild = isset($groupedChildren[$parent['id_menu']]);
                        ?>
                            <tr class="parent-row <?= $hasChild ? 'cursor-pointer' : '' ?>"
                                <?= $hasChild ? 'onclick="toggleRows(' . $parent['id_menu'] . ', this)"' : '' ?>>

                                <td class="text-center">
                                    <span class="badge-number"><?= $counter++ ?></span>
                                </td>

                                <td>
                                    <div class="menu-name-section">
                                        <div style="width: 24px;">
                                            <?php if ($hasChild): ?>
                                                <i class="bi bi-chevron-right toggle-icon"></i>
                                            <?php endif; ?>
                                        </div>

                                        <div class="menu-name-text">
                                            <div class="menu-name-title"><?= esc($parent['menu_name']) ?></div>
                                            <?php if ($hasChild): ?>
                                                <span class="submenu-count">
                                                    <i class="bi bi-diagram-3" style="font-size: 0.65rem;"></i>
                                                    <?= count($groupedChildren[$parent['id_menu']]) ?> submenu
                                                </span>
                                            <?php endif; ?>
                                            <div class="date-info">
                                                <i class="bi bi-clock me-1"></i>
                                                Urutan: <?= $parent['order_number'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <?php if (!empty($parent['menu_url']) && $parent['menu_url'] != '#'): ?>
                                        <a href="<?= esc($parent['menu_url']) ?>" target="_blank" class="url-link">
                                            <i class="bi bi-link-45deg"></i>
                                            <span class="text-truncate"><?= esc($parent['menu_url']) ?></span>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">— Tidak ada URL —</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($parent['admin_url']) && $parent['admin_url'] != '#'): ?>
                                        <a href="<?= esc($parent['admin_url']) ?>" target="_blank" class="url-link">
                                            <i class="bi bi-shield-lock"></i>
                                            <span class="text-truncate"><?= esc($parent['admin_url']) ?></span>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">— Tidak ada Admin URL —</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center" onclick="event.stopPropagation()">
                                    <?php if ($can_update): ?>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                    data-id="<?= $parent['id_menu'] ?>"
                                                    data-url="<?= site_url('menu/toggleStatus/' . $parent['id_menu']) ?>"
                                                    id="toggle-<?= $parent['id_menu'] ?>"
                                                    <?= ($parent['status'] === 'active') ? 'checked' : '' ?>>
                                            </div>
                                            <label for="toggle-<?= $parent['id_menu'] ?>" class="status-label <?= ($parent['status'] === 'active') ? 'active' : '' ?>" style="cursor: pointer;">
                                                <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge-custom <?= ($parent['status'] === 'active') ? 'badge-primary-custom' : 'badge-secondary-custom' ?>">
                                            <?= ($parent['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <?php if ($can_create): ?>
                                            <button type="button" class="btn-add-submenu"
                                                data-bs-toggle="tooltip" title="Tambah Submenu"
                                                onclick="openCreateSubmenuModal(<?= $parent['id_menu'] ?>, '<?= esc($parent['menu_name']) ?>')">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if ($can_update): ?>
                                            <button type="button" class="btn-action"
                                                data-bs-toggle="tooltip" title="Edit Menu"
                                                onclick="openEditModal(<?= htmlspecialchars(json_encode($parent)) ?>)">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($can_delete): ?>
                                            <button type="button" class="btn-action btn-delete"
                                                data-bs-toggle="tooltip" title="Hapus Menu"
                                                onclick="deleteMenu(<?= $parent['id_menu'] ?>, '<?= esc($parent['menu_name']) ?>')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <?php if ($hasChild):
                                foreach ($groupedChildren[$parent['id_menu']] as $child):
                            ?>
                                    <tr class="child-row child-of-<?= $parent['id_menu'] ?>">
                                        <td></td>
                                        <td>
                                            <div class="d-flex align-items-center ps-4">
                                                <div class="tree-line">
                                                    <div>
                                                        <span style="color: var(--gray-800); font-weight: 600; font-size: 0.9rem;">
                                                            <?= esc($child['menu_name']) ?>
                                                        </span>
                                                        <div class="date-info mt-1">
                                                            <i class="bi bi-sort-numeric-down me-1"></i>
                                                            Urutan: <?= $child['order_number'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($child['menu_url']) && $child['menu_url'] != '#'): ?>
                                                <a href="<?= esc($child['menu_url']) ?>" target="_blank" class="url-link">
                                                    <i class="bi bi-link-45deg"></i>
                                                    <span class="text-truncate"><?= esc($child['menu_url']) ?></span>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small fst-italic">— Tidak ada URL —</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($child['admin_url']) && $child['admin_url'] != '#'): ?>
                                                <a href="<?= esc($child['admin_url']) ?>" target="_blank" class="url-link">
                                                    <i class="bi bi-shield-lock"></i>
                                                    <span class="text-truncate"><?= esc($child['admin_url']) ?></span>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small fst-italic">— Tidak ada Admin URL —</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <?php if ($can_update): ?>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="form-check form-switch mb-0">
                                                        <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                                            data-id="<?= $child['id_menu'] ?>"
                                                            data-url="<?= site_url('menu/toggleStatus/' . $child['id_menu']) ?>"
                                                            id="toggle-child-<?= $child['id_menu'] ?>"
                                                            <?= ($child['status'] === 'active') ? 'checked' : '' ?>>
                                                    </div>
                                                    <label for="toggle-child-<?= $child['id_menu'] ?>" class="status-label <?= ($child['status'] === 'active') ? 'active' : '' ?>" style="cursor: pointer;">
                                                        <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                                    </label>
                                                </div>
                                            <?php else: ?>
                                                <span class="badge-custom <?= ($child['status'] === 'active') ? 'badge-primary-custom' : 'badge-secondary-custom' ?>">
                                                    <?= ($child['status'] === 'active') ? 'Aktif' : 'Nonaktif' ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <?php if ($can_update): ?>
                                                    <button type="button" class="btn-action"
                                                        data-bs-toggle="tooltip" title="Edit Submenu"
                                                        onclick="openEditModal(<?= htmlspecialchars(json_encode($child)) ?>)">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if ($can_delete): ?>
                                                    <button type="button" class="btn-action btn-delete"
                                                        data-bs-toggle="tooltip" title="Hapus Submenu"
                                                        onclick="deleteMenu(<?= $child['id_menu'] ?>, '<?= esc($child['menu_name']) ?>')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                endforeach;
                            endif; ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center text-muted small">
                    <i class="bi bi-info-circle me-2 text-primary"></i>
                    <span>Total: <strong><?= count($menus) ?></strong> menu (<?= count($parents) ?> parent, <?= count($allChildren) ?> submenu)</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-diagram-3 me-1"></i>
                        Struktur Hierarki
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">
                    <i class="bi bi-plus-square"></i>
                    <span id="modalTitle">Tambah Menu Baru</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body dengan scrollable area -->
            <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">
                <form id="menuForm" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id_menu" id="id_menu" value="">

                    <!-- Informasi Dasar -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="bi bi-info-circle"></i> Informasi Dasar
                        </h6>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="menu_name" class="form-label-modal">
                                    <i class="bi bi-tag-fill"></i>
                                    Nama Menu <span class="required">*</span>
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-card-text input-icon-modal"></i>
                                    <input type="text" class="form-control form-control-modal"
                                        id="menu_name" name="menu_name"
                                        placeholder="Contoh: Dashboard, Berita, Produk" required>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="parent_id" class="form-label-modal">
                                    <i class="bi bi-folder-symlink-fill"></i>
                                    Parent Menu (Menu Induk)
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-diagram-3 input-icon-modal"></i>
                                    <select class="form-select form-select-modal" id="parent_id" name="parent_id">
                                        <option value="0">📌 Menu Utama (Tanpa Parent)</option>
                                        <?php foreach ($menus as $m): ?>
                                            <?php if ($m['parent_id'] == 0): ?>
                                                <option value="<?= $m['id_menu'] ?>"
                                                    data-is-infopublik="<?= (strtolower($m['menu_name']) === 'informasi publik') ? 'true' : 'false' ?>">
                                                    📁 <?= esc($m['menu_name']) ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-text-modal" id="urlHelperText">
                                    <i class="bi bi-lightbulb-fill text-warning"></i>
                                    <span>Pilih "Informasi Publik" untuk otomatis membuat kategori dokumen.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- URL & Routing -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="bi bi-link-45deg"></i> URL & Routing
                        </h6>

                        <!-- Toggle Auto Route (WAJIB MUNCUL untuk parent Informasi Publik) -->
                        <div class="row mb-3 d-none" id="autoRouteToggleContainer">
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: var(--primary-soft); border: 2px dashed var(--primary-light);">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="auto_route" name="auto_route" value="1">
                                        <label class="form-check-label fw-bold" for="auto_route">
                                            <i class="bi bi-magic text-primary"></i>
                                            <span class="text-primary">Gunakan Route Otomatis</span>
                                        </label>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle"></i>
                                            Jika aktif, URL akan otomatis dibuat: <code>/informasi-publik/[nama-menu-slug]</code>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="menu_url" class="form-label-modal">
                                    <i class="bi bi-link-45deg"></i>
                                    URL / Route
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-globe2 input-icon-modal"></i>
                                    <input type="text" class="form-control form-control-modal"
                                        id="menu_url" name="menu_url"
                                        placeholder="/api/dashboard atau https://example.com">
                                </div>
                                <div class="form-text-modal d-none" id="autoUrlInfo">
                                    <i class="bi bi-robot text-success"></i>
                                    <span class="text-success">URL akan digenerate otomatis berdasarkan nama menu</span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_url" class="form-label-modal">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    URL Admin
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-lock input-icon-modal"></i>
                                    <input type="text" class="form-control form-control-modal"
                                        id="admin_url" name="admin_url"
                                        placeholder="/dashboard">
                                </div>
                                <div class="form-text-modal d-none" id="autoAdminUrlInfo">
                                    <i class="bi bi-robot text-success"></i>
                                    <span class="text-success">Admin URL akan sama dengan URL publik</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Konfigurasi -->
                    <div class="mb-4">
                        <h6 class="text-primary fw-bold mb-3">
                            <i class="bi bi-gear-fill"></i> Konfigurasi
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order_number" class="form-label-modal">
                                    <i class="bi bi-sort-numeric-down"></i>
                                    Urutan Menu <span class="required">*</span>
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-list-ol input-icon-modal"></i>
                                    <input type="number" class="form-control form-control-modal"
                                        id="order_number" name="order_number"
                                        value="1" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label-modal">
                                    <i class="bi bi-toggle2-on"></i>
                                    Status Menu <span class="required">*</span>
                                </label>
                                <div class="input-group-modal">
                                    <i class="bi bi-toggle-on input-icon-modal"></i>
                                    <select class="form-select form-select-modal" id="status" name="status" required>
                                        <option value="active">✅ Aktif - Menu akan ditampilkan</option>
                                        <option value="inactive">⛔ Nonaktif - Menu disembunyikan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-modal-delete d-none" id="btnDeleteModal" onclick="deleteMenuFromModal()">
                    <i class="bi bi-trash me-2"></i>Hapus Menu
                </button>
                <button type="submit" form="menuForm" class="btn btn-modal-submit">
                    <i class="bi bi-check-circle me-2"></i>
                    <span id="submitBtnText">Simpan Menu</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Toggle Status
        const toggles = document.querySelectorAll('.toggle-status');

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const url = this.getAttribute('data-url');
                const label = this.parentElement.nextElementSibling;
                const isChecked = this.checked;

                this.disabled = true;
                label.style.opacity = '0.5';

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            setTimeout(() => {
                                if (isChecked) {
                                    label.textContent = 'Aktif';
                                    label.classList.add('active');
                                } else {
                                    label.textContent = 'Nonaktif';
                                    label.classList.remove('active');
                                }
                                label.style.opacity = '1';
                            }, 150);
                        } else {
                            this.checked = !isChecked;
                            label.style.opacity = '1';
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mengubah status menu',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                background: 'var(--danger-soft)',
                                color: 'var(--danger-text)'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.checked = !isChecked;
                        label.style.opacity = '1';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengubah status',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            background: 'var(--danger-soft)',
                            color: 'var(--danger-text)'
                        });
                    })
                    .finally(() => {
                        this.disabled = false;
                    });
            });
        });

        // Parent Select Handler
        const parentSelect = document.getElementById('parent_id');
        const urlInput = document.getElementById('menu_url');
        const adminUrlInput = document.getElementById('admin_url');
        const urlHelper = document.getElementById('urlHelperText');
        const autoRouteContainer = document.getElementById('autoRouteToggleContainer');
        const autoRouteToggle = document.getElementById('auto_route');
        const autoUrlInfo = document.getElementById('autoUrlInfo');
        const autoAdminUrlInfo = document.getElementById('autoAdminUrlInfo');

        function checkParentType() {
            const selectedOption = parentSelect.options[parentSelect.selectedIndex];
            const isInfoPublik = selectedOption.getAttribute('data-is-infopublik') === 'true';

            if (isInfoPublik) {
                // WAJIB MUNCUL untuk Informasi Publik
                autoRouteContainer.classList.remove('d-none');

                if (autoRouteToggle.checked) {
                    urlInput.value = "Akan digenerate otomatis";
                    urlInput.setAttribute('readonly', true);
                    urlInput.style.backgroundColor = "var(--success-soft)";
                    urlInput.style.color = "var(--success-text)";
                    autoUrlInfo.classList.remove('d-none');

                    adminUrlInput.value = "Akan digenerate otomatis";
                    adminUrlInput.setAttribute('readonly', true);
                    adminUrlInput.style.backgroundColor = "var(--success-soft)";
                    adminUrlInput.style.color = "var(--success-text)";
                    autoAdminUrlInfo.classList.remove('d-none');
                } else {
                    if (urlInput.value === "Akan digenerate otomatis") {
                        urlInput.value = "";
                    }
                    urlInput.removeAttribute('readonly');
                    urlInput.style.backgroundColor = "";
                    urlInput.style.color = "";
                    autoUrlInfo.classList.add('d-none');

                    if (adminUrlInput.value === "Akan digenerate otomatis") {
                        adminUrlInput.value = "";
                    }
                    adminUrlInput.removeAttribute('readonly');
                    adminUrlInput.style.backgroundColor = "";
                    adminUrlInput.style.color = "";
                    autoAdminUrlInfo.classList.add('d-none');
                }

                urlHelper.innerHTML = `
                    <i class="bi bi-lightbulb-fill text-primary"></i>
                    <span class="text-primary fw-bold">
                        Parent "Informasi Publik" terdeteksi. Aktifkan toggle untuk generate URL otomatis.
                    </span>
                `;
            } else {
                autoRouteContainer.classList.add('d-none');
                autoRouteToggle.checked = false;

                if (urlInput.value === "Akan digenerate otomatis") {
                    urlInput.value = "";
                }
                urlInput.removeAttribute('readonly');
                urlInput.style.backgroundColor = "";
                urlInput.style.color = "";
                autoUrlInfo.classList.add('d-none');

                if (adminUrlInput.value === "Akan digenerate otomatis") {
                    adminUrlInput.value = "";
                }
                adminUrlInput.removeAttribute('readonly');
                adminUrlInput.style.backgroundColor = "";
                adminUrlInput.style.color = "";
                autoAdminUrlInfo.classList.add('d-none');

                urlHelper.innerHTML = `
                    <i class="bi bi-lightbulb-fill text-warning"></i>
                    <span>Pilih "Informasi Publik" untuk otomatis membuat kategori dokumen.</span>
                `;
            }
        }

        autoRouteToggle.addEventListener('change', function() {
            checkParentType();

            if (this.checked) {
                const menuName = document.getElementById('menu_name').value;
                if (menuName) {
                    const slug = menuName.toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/--+/g, '-')
                        .trim();

                    urlInput.value = `/informasi-publik/${slug}`;
                    adminUrlInput.value = `/informasi-publik/${slug}`;
                }
            }
        });

        document.getElementById('menu_name').addEventListener('input', function() {
            if (autoRouteToggle.checked) {
                const slug = this.value.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-')
                    .trim();

                urlInput.value = `/informasi-publik/${slug}`;
                adminUrlInput.value = `/informasi-publik/${slug}`;
            }
        });

        parentSelect.addEventListener('change', checkParentType);

        // Form Submit Handler
        const menuForm = document.getElementById('menuForm');
        menuForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const method = document.getElementById('formMethod').value;
            const idMenu = document.getElementById('id_menu').value;

            if (autoRouteToggle && autoRouteToggle.checked && urlInput.hasAttribute('readonly')) {
                formData.set('menu_url', '');
                formData.set('admin_url', '');
            }

            let url = '<?= site_url('menu') ?>';
            if (method === 'PUT') {
                url = '<?= site_url('menu') ?>/' + idMenu;
            }

            const wasUrlReadonly = urlInput.hasAttribute('readonly');
            const wasAdminUrlReadonly = adminUrlInput.hasAttribute('readonly');

            urlInput.removeAttribute('readonly');
            adminUrlInput.removeAttribute('readonly');

            const submitBtn = document.querySelector('.btn-modal-submit');
            if (!submitBtn) {
                console.error('Submit button not found');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tombol submit tidak ditemukan',
                    confirmButtonColor: 'var(--primary)',
                    background: 'var(--danger-soft)',
                    color: 'var(--danger-text)'
                });
                return;
            }

            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Menu berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500,
                            background: 'var(--success-soft)',
                            color: 'var(--success-text)'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan',
                            confirmButtonColor: 'var(--primary)',
                            background: 'var(--danger-soft)',
                            color: 'var(--danger-text)'
                        });
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;

                        if (wasUrlReadonly) urlInput.setAttribute('readonly', true);
                        if (wasAdminUrlReadonly) adminUrlInput.setAttribute('readonly', true);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan data',
                        confirmButtonColor: 'var(--primary)',
                        background: 'var(--danger-soft)',
                        color: 'var(--danger-text)'
                    });
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;

                    if (wasUrlReadonly) urlInput.setAttribute('readonly', true);
                    if (wasAdminUrlReadonly) adminUrlInput.setAttribute('readonly', true);
                });
        });

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    // Toggle Accordion
    function toggleRows(parentId, element) {
        element.classList.toggle('expanded');
        const childRows = document.querySelectorAll(`.child-of-${parentId}`);

        childRows.forEach(row => {
            row.classList.toggle('show');
        });
    }

    // Open Create Modal
    function openCreateModal() {
        document.getElementById('menuModalLabel').innerHTML = '<i class="bi bi-plus-square"></i> <span>Tambah Menu Baru</span>';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('id_menu').value = '';
        document.getElementById('submitBtnText').textContent = 'Simpan Menu';
        document.getElementById('btnDeleteModal').classList.add('d-none');

        document.getElementById('menuForm').reset();
        document.getElementById('menu_name').value = '';
        document.getElementById('parent_id').value = '0';
        document.getElementById('menu_url').value = '';
        document.getElementById('admin_url').value = '';
        document.getElementById('order_number').value = '1';
        document.getElementById('status').value = 'active';
        document.getElementById('auto_route').checked = false;

        const autoRouteContainer = document.getElementById('autoRouteToggleContainer');
        const autoUrlInfo = document.getElementById('autoUrlInfo');
        const autoAdminUrlInfo = document.getElementById('autoAdminUrlInfo');
        const urlInput = document.getElementById('menu_url');
        const adminUrlInput = document.getElementById('admin_url');

        autoRouteContainer.classList.add('d-none');
        autoUrlInfo.classList.add('d-none');
        autoAdminUrlInfo.classList.add('d-none');

        urlInput.removeAttribute('readonly');
        urlInput.style.backgroundColor = '';
        urlInput.style.color = '';
        adminUrlInput.removeAttribute('readonly');
        adminUrlInput.style.backgroundColor = '';
        adminUrlInput.style.color = '';
    }

    // NEW: Open Create Submenu Modal
    function openCreateSubmenuModal(parentId, parentName) {
        document.getElementById('menuModalLabel').innerHTML = '<i class="bi bi-node-plus"></i> <span>Tambah Submenu untuk "' + parentName + '"</span>';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('id_menu').value = '';
        document.getElementById('submitBtnText').textContent = 'Simpan Submenu';
        document.getElementById('btnDeleteModal').classList.add('d-none');

        document.getElementById('menuForm').reset();
        document.getElementById('menu_name').value = '';
        document.getElementById('parent_id').value = parentId;
        document.getElementById('menu_url').value = '';
        document.getElementById('admin_url').value = '';
        document.getElementById('order_number').value = '1';
        document.getElementById('status').value = 'active';
        document.getElementById('auto_route').checked = false;

        // Trigger check untuk melihat apakah parent adalah Informasi Publik
        const selectedOption = document.querySelector(`#parent_id option[value="${parentId}"]`);
        const isInfoPublik = selectedOption && selectedOption.getAttribute('data-is-infopublik') === 'true';

        const autoRouteContainer = document.getElementById('autoRouteToggleContainer');
        const autoUrlInfo = document.getElementById('autoUrlInfo');
        const autoAdminUrlInfo = document.getElementById('autoAdminUrlInfo');
        const urlInput = document.getElementById('menu_url');
        const adminUrlInput = document.getElementById('admin_url');

        if (isInfoPublik) {
            autoRouteContainer.classList.remove('d-none');
            document.getElementById('urlHelperText').innerHTML = `
                <i class="bi bi-lightbulb-fill text-primary"></i>
                <span class="text-primary fw-bold">
                    Parent "Informasi Publik" terdeteksi. Aktifkan toggle untuk generate URL otomatis.
                </span>
            `;
        } else {
            autoRouteContainer.classList.add('d-none');
        }

        autoUrlInfo.classList.add('d-none');
        autoAdminUrlInfo.classList.add('d-none');

        urlInput.removeAttribute('readonly');
        urlInput.style.backgroundColor = '';
        urlInput.style.color = '';
        adminUrlInput.removeAttribute('readonly');
        adminUrlInput.style.backgroundColor = '';
        adminUrlInput.style.color = '';

        const modal = new bootstrap.Modal(document.getElementById('menuModal'));
        modal.show();
    }

    // Open Edit Modal
    function openEditModal(menuData) {
        document.getElementById('menuModalLabel').innerHTML = '<i class="bi bi-pencil-square"></i> <span>Edit Menu</span>';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('id_menu').value = menuData.id_menu;
        document.getElementById('submitBtnText').textContent = 'Simpan Perubahan';
        document.getElementById('btnDeleteModal').classList.remove('d-none');

        document.getElementById('menu_name').value = menuData.menu_name || '';
        document.getElementById('parent_id').value = menuData.parent_id || '0';
        document.getElementById('menu_url').value = menuData.menu_url || '';
        document.getElementById('admin_url').value = menuData.admin_url || '';
        document.getElementById('order_number').value = menuData.order_number || '1';
        document.getElementById('status').value = menuData.status || 'active';

        const parentInfoPublik = document.querySelector(`option[value="${menuData.parent_id}"]`);
        const isInfoPublik = parentInfoPublik && parentInfoPublik.getAttribute('data-is-infopublik') === 'true';

        const autoRouteContainer = document.getElementById('autoRouteToggleContainer');
        const urlInput = document.getElementById('menu_url');
        const adminUrlInput = document.getElementById('admin_url');
        const autoUrlInfo = document.getElementById('autoUrlInfo');
        const autoAdminUrlInfo = document.getElementById('autoAdminUrlInfo');

        if (isInfoPublik) {
            // WAJIB MUNCUL untuk Informasi Publik
            autoRouteContainer.classList.remove('d-none');

            const isAutoUrl = menuData.menu_url && menuData.menu_url.startsWith('/informasi-publik/');
            document.getElementById('auto_route').checked = isAutoUrl;

            if (isAutoUrl) {
                urlInput.setAttribute('readonly', true);
                urlInput.style.backgroundColor = "var(--success-soft)";
                autoUrlInfo.classList.remove('d-none');

                adminUrlInput.setAttribute('readonly', true);
                adminUrlInput.style.backgroundColor = "var(--success-soft)";
                autoAdminUrlInfo.classList.remove('d-none');
            } else {
                urlInput.removeAttribute('readonly');
                urlInput.style.backgroundColor = "";
                autoUrlInfo.classList.add('d-none');

                adminUrlInput.removeAttribute('readonly');
                adminUrlInput.style.backgroundColor = "";
                autoAdminUrlInfo.classList.add('d-none');
            }
        } else {
            autoRouteContainer.classList.add('d-none');
            urlInput.removeAttribute('readonly');
            urlInput.style.backgroundColor = "";
            adminUrlInput.removeAttribute('readonly');
            adminUrlInput.style.backgroundColor = "";
        }

        const modal = new bootstrap.Modal(document.getElementById('menuModal'));
        modal.show();
    }

    // Delete Menu
    function deleteMenu(id, name) {
        Swal.fire({
            title: 'Hapus Menu?',
            html: `Anda yakin ingin menghapus menu <strong>"${name}"</strong>?<br><small class="text-muted">Semua submenu akan ikut terhapus.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--danger)',
            cancelButtonColor: 'var(--gray-600)',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            background: 'var(--warning-soft)',
            color: 'var(--warning-text)'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= site_url('menu') ?>/' + id;

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '<?= csrf_token() ?>';
                csrfInput.value = '<?= csrf_hash() ?>';

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Delete from Modal
    function deleteMenuFromModal() {
        const idMenu = document.getElementById('id_menu').value;
        const menuName = document.getElementById('menu_name').value;

        const modal = bootstrap.Modal.getInstance(document.getElementById('menuModal'));
        modal.hide();

        setTimeout(() => {
            deleteMenu(idMenu, menuName);
        }, 300);
    }
</script>
<?= $this->endSection() ?>