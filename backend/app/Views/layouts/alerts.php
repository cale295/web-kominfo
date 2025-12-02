<style>
    /* RESET & BASE */
    .neo-alert-wrapper {
        font-family: system-ui, -apple-system, sans-serif;
        box-sizing: border-box;
    }

    /* OVERLAY - Hapus backdrop-filter (penyebab lag utama) */
    .neo-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        animation: fadeIn 0.2s ease forwards;
    }

    /* ALERT BOX - Kurangi shadow complexity */
    .neo-alert-box {
        background: #fff;
        width: 420px;
        max-width: 90%;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: translateY(20px);
        animation: slideUp 0.25s ease forwards;
    }

    /* Top accent bar - Hapus animasi gradient */
    .neo-alert-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .neo-alert-box.error::before {
        background: #D32F2F;
    }

    .neo-alert-box.success::before {
        background: #00897B;
    }

    /* HEADER */
    .neo-alert-header {
        padding: 18px 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin-top: 4px;
    }

    .neo-alert-box.error .neo-alert-header {
        background: #FFF0F0;
        color: #D32F2F;
    }

    .neo-alert-box.success .neo-alert-header {
        background: #F0FFFE;
        color: #00897B;
    }

    /* Close icon - Hapus transform rotation */
    .neo-close-icon {
        cursor: pointer;
        padding: 4px 8px;
        font-size: 20px;
        line-height: 1;
        border-radius: 4px;
        transition: background 0.15s ease;
        opacity: 0.7;
    }
    
    .neo-close-icon:hover { 
        opacity: 1;
        background: rgba(0, 0, 0, 0.08);
    }

    /* CONTENT */
    .neo-alert-content {
        padding: 20px;
        color: #2C3E50;
        font-size: 14px;
        line-height: 1.6;
    }

    .neo-alert-content ul {
        margin: 10px 0 0 0;
        padding-left: 20px;
        list-style-type: none;
    }

    .neo-alert-content ul li {
        position: relative;
        padding-left: 16px;
        margin-bottom: 6px;
    }

    .neo-alert-content ul li::before {
        content: '▸';
        position: absolute;
        left: 0;
        color: #D32F2F;
    }

    /* FOOTER */
    .neo-alert-footer {
        padding: 0 20px 20px;
        text-align: right;
    }

    /* Button - Simplifikasi animasi */
    .neo-btn {
        background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
        color: #fff;
        border: none;
        padding: 11px 28px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        border-radius: 6px;
        box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3);
        transition: all 0.2s ease;
        will-change: transform; /* Optimasi GPU */
    }

    .neo-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(102, 126, 234, 0.4);
    }

    .neo-btn:active {
        transform: translateY(0);
    }

    /* ANIMATIONS - Minimal & efficient */
    @keyframes fadeIn {
        to { opacity: 1; }
    }

    @keyframes slideUp {
        to { 
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        to { opacity: 0; }
    }
</style>

<div class="neo-alert-wrapper">

    <?php if (session()->getFlashdata('error') || !empty($error) || session()->get('errors')): ?>
        <div class="neo-alert-overlay" id="alertError">
            <div class="neo-alert-box error">
                <div class="neo-alert-header">
                    <span>⚠️ SYSTEM_ERROR</span>
                    <span class="neo-close-icon" onclick="closeNeoAlert('alertError')">&times;</span>
                </div>
                
                <div class="neo-alert-content">
                    <?php if (session()->getFlashdata('error')): ?>
                        <p><?= session()->getFlashdata('error') ?></p>
                    <?php endif; ?>

                    <?php if (!empty($error)): ?>
                        <p><?= $error ?></p>
                    <?php endif; ?>

                    <?php if (session()->get('errors')): ?>
                        <span>List Kesalahan:</span>
                        <ul>
                            <?php foreach (session()->get('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="neo-alert-footer">
                    <button class="neo-btn" onclick="closeNeoAlert('alertError')">Tutup</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="neo-alert-overlay" id="alertSuccess">
            <div class="neo-alert-box success">
                <div class="neo-alert-header">
                    <span>✅ SUCCESS</span>
                    <span class="neo-close-icon" onclick="closeNeoAlert('alertSuccess')">&times;</span>
                </div>
                
                <div class="neo-alert-content">
                    <?= session()->getFlashdata('success') ?>
                </div>

                <div class="neo-alert-footer">
                    <button class="neo-btn" onclick="closeNeoAlert('alertSuccess')">Lanjut</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    // Store timer ID untuk bisa di-clear
    let autoCloseTimer = null;

    function closeNeoAlert(elementId) {
        const el = document.getElementById(elementId);
        if (el) {
            // Clear auto-close timer
            if (autoCloseTimer) {
                clearTimeout(autoCloseTimer);
            }
            
            // Fade out animation
            el.style.animation = 'fadeOut 0.2s ease';
            setTimeout(() => {
                el.remove();
            }, 200);
        }
    }

    // Auto close dengan proper cleanup
    document.addEventListener('DOMContentLoaded', () => {
        autoCloseTimer = setTimeout(() => {
            const overlays = document.querySelectorAll('.neo-alert-overlay');
            overlays.forEach(overlay => {
                overlay.style.animation = 'fadeOut 0.2s ease';
                setTimeout(() => overlay.remove(), 200);
            });
        }, 5000);
    });
</script>