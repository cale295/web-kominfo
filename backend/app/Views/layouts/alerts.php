<!-- app/Views/layouts/alerts.php -->

<style>
    /* Animations */
    @keyframes slideDown {
        from {
            transform: translateY(-100%) scale(0.9);
            opacity: 0;
        }
        to {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }

    @keyframes gentle-shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes scaleIn {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Alert Container */
    .custom-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(3px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    /* Alert Box */
    .custom-alert-box {
        background: white;
        border-radius: 16px;
        padding: 32px;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
    }

    .custom-alert-box.error {
        border-top: 4px solid #dc3545;
        animation: slideDown 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), 
                   gentle-shake 0.4s ease 0.3s;
    }

    .custom-alert-box.success {
        border-top: 4px solid #28a745;
    }

    /* Alert Content */
    .custom-alert-content {
        text-align: center;
    }

    .custom-alert-icon {
        font-size: 64px;
        margin-bottom: 16px;
        display: inline-block;
        animation: scaleIn 0.4s ease 0.2s both;
    }

    .custom-alert-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #2c3e50;
    }

    .custom-alert-box.error .custom-alert-title {
        color: #dc3545;
    }

    .custom-alert-box.success .custom-alert-title {
        color: #28a745;
    }

    .custom-alert-message {
        font-size: 16px;
        margin-bottom: 24px;
        line-height: 1.6;
        color: #495057;
    }

    /* Error List Styling */
    .custom-alert-message ul {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
    }

    .custom-alert-message ul li {
        padding: 8px 12px;
        margin-bottom: 8px;
        background: #fff5f5;
        border-left: 3px solid #dc3545;
        border-radius: 4px;
        font-size: 14px;
    }

    .custom-alert-message ul li:last-child {
        margin-bottom: 0;
    }

    /* Button */
    .custom-alert-close {
        background: #6c757d;
        border: none;
        color: white;
        padding: 12px 32px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-alert-close:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .custom-alert-close:active {
        transform: translateY(0);
    }

    .custom-alert-box.error .custom-alert-close {
        background: #dc3545;
    }

    .custom-alert-box.error .custom-alert-close:hover {
        background: #c82333;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .custom-alert-box.success .custom-alert-close {
        background: #28a745;
    }

    .custom-alert-box.success .custom-alert-close:hover {
        background: #218838;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .custom-alert-box {
            padding: 24px;
        }

        .custom-alert-icon {
            font-size: 48px;
        }

        .custom-alert-title {
            font-size: 20px;
        }

        .custom-alert-message {
            font-size: 14px;
        }
    }
</style>

<!-- Error Alert (Flash Data) -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="custom-alert-overlay" id="errorAlert">
        <div class="custom-alert-box error">
            <div class="custom-alert-content">
                <div class="custom-alert-icon">⛔</div>
                <div class="custom-alert-title">Terjadi Kesalahan!</div>
                <div class="custom-alert-message">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
                <button class="custom-alert-close" onclick="closeAlert('errorAlert')">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Success Alert (Flash Data) -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="custom-alert-overlay" id="successAlert">
        <div class="custom-alert-box success">
            <div class="custom-alert-content">
                <div class="custom-alert-icon">✅</div>
                <div class="custom-alert-title">Berhasil!</div>
                <div class="custom-alert-message">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
                <button class="custom-alert-close" onclick="closeAlert('successAlert')">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Direct Error Alert -->
<?php if (!empty($error)): ?>
    <div class="custom-alert-overlay" id="directError">
        <div class="custom-alert-box error">
            <div class="custom-alert-content">
                <div class="custom-alert-icon">⛔</div>
                <div class="custom-alert-title">Terjadi Kesalahan!</div>
                <div class="custom-alert-message">
                    <?= esc($error) ?>
                </div>
                <button class="custom-alert-close" onclick="closeAlert('directError')">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Validation Errors Alert -->
<?php if (session()->get('errors')): ?>
    <div class="custom-alert-overlay" id="validationErrors">
        <div class="custom-alert-box error">
            <div class="custom-alert-content">
                <div class="custom-alert-icon">⚠️</div>
                <div class="custom-alert-title">Validasi Gagal!</div>
                <div class="custom-alert-message">
                    <ul>
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button class="custom-alert-close" onclick="closeAlert('validationErrors')">Tutup</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    function closeAlert(alertId) {
        const alertElement = document.getElementById(alertId);
        if (alertElement) {
            alertElement.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                alertElement.remove();
            }, 300);
        }
    }

    // Auto close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.custom-alert-overlay');
        alerts.forEach(alert => {
            setTimeout(() => {
                closeAlert(alert.id);
            }, 5000);
        });
    });
</script>