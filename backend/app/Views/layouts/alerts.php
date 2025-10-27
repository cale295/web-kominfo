<!-- app/Views/layouts/alerts.php -->

<style>
    @keyframes slideDown {
        from {
            transform: translateY(-100%) scale(0.8);
            opacity: 0;
        }
        to {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
        20%, 40%, 60%, 80% { transform: translateX(10px); }
    }

    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        50% { box-shadow: 0 0 0 15px rgba(220, 53, 69, 0); }
    }

    .custom-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .custom-alert-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        animation: slideDown 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
        overflow: hidden;
    }

    .custom-alert-box.error {
        background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
        animation: slideDown 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55), shake 0.5s ease 0.5s;
    }

    .custom-alert-box.success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .custom-alert-box::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 10s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .custom-alert-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }

    .custom-alert-icon {
        font-size: 80px;
        margin-bottom: 20px;
        display: inline-block;
        animation: scaleIn 0.5s ease 0.3s both;
    }

    @keyframes scaleIn {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }

    .custom-alert-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .custom-alert-message {
        font-size: 18px;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .custom-alert-close {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        padding: 12px 40px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .custom-alert-close:hover {
        background: white;
        color: #333;
        transform: scale(1.05);
    }

    .alert-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: float 3s infinite ease-in-out;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-20px) translateX(10px); }
    }
</style>

<?php if (session()->getFlashdata('error')): ?>
    <div class="custom-alert-overlay" id="errorAlert">
        <div class="custom-alert-box error">
            <div class="alert-particles">
                <div class="particle" style="width: 10px; height: 10px; top: 20%; left: 10%; animation-delay: 0s;"></div>
                <div class="particle" style="width: 8px; height: 8px; top: 60%; left: 80%; animation-delay: 1s;"></div>
                <div class="particle" style="width: 12px; height: 12px; top: 80%; left: 30%; animation-delay: 2s;"></div>
            </div>
            <div class="custom-alert-content">
                <div class="custom-alert-icon">⛔</div>
                <div class="custom-alert-title">TERLARANG!</div>
                <div class="custom-alert-message">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
                <button class="custom-alert-close" onclick="closeAlert('errorAlert')">TUTUP</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="custom-alert-overlay" id="successAlert">
        <div class="custom-alert-box success">
            <div class="alert-particles">
                <div class="particle" style="width: 10px; height: 10px; top: 20%; left: 10%; animation-delay: 0s;"></div>
                <div class="particle" style="width: 8px; height: 8px; top: 60%; left: 80%; animation-delay: 1s;"></div>
                <div class="particle" style="width: 12px; height: 12px; top: 80%; left: 30%; animation-delay: 2s;"></div>
            </div>
            <div class="custom-alert-content">
                <div class="custom-alert-icon">✅</div>
                <div class="custom-alert-title">BERHASIL!</div>
                <div class="custom-alert-message">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
                <button class="custom-alert-close" onclick="closeAlert('successAlert')">TUTUP</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="custom-alert-overlay" id="directError">
        <div class="custom-alert-box error">
            <div class="alert-particles">
                <div class="particle" style="width: 10px; height: 10px; top: 20%; left: 10%; animation-delay: 0s;"></div>
                <div class="particle" style="width: 8px; height: 8px; top: 60%; left: 80%; animation-delay: 1s;"></div>
                <div class="particle" style="width: 12px; height: 12px; top: 80%; left: 30%; animation-delay: 2s;"></div>
            </div>
            <div class="custom-alert-content">
                <div class="custom-alert-icon">⛔</div>
                <div class="custom-alert-title">TERLARANG!</div>
                <div class="custom-alert-message">
                    <?= esc($error) ?>
                </div>
                <button class="custom-alert-close" onclick="closeAlert('directError')">TUTUP</button>
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

    // Auto close after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.custom-alert-overlay');
        alerts.forEach(alert => {
            setTimeout(() => {
                closeAlert(alert.id);
            }, 5000);
        });
    });

    // Add fadeOut animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);
</script>