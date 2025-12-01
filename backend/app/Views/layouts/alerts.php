<style>
    /* 1. RESET & BASE STYLE */
    .neo-alert-wrapper {
        font-family: 'Courier New', Courier, monospace; /* Font teknis */
        box-sizing: border-box;
    }

    /* 2. OVERLAY (Latar Belakang) */
    .neo-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.1); /* Transparan */
        /* Pola titik-titik (Dotted Pattern) agar unik */
        background-image: radial-gradient(#000 1px, transparent 1px);
        background-size: 4px 4px;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        /* Animasi muncul kasar (tidak fade in halus) */
        animation: snapShow 0.1s steps(1); 
    }

    /* 3. ALERT BOX (Kotak Utama) */
    .neo-alert-box {
        background: #fff;
        width: 400px;
        max-width: 90%;
        border: 3px solid #000; /* Garis tebal */
        box-shadow: 8px 8px 0px #000; /* Bayangan keras tanpa blur */
        position: relative;
        display: flex;
        flex-direction: column;
    }

    /* 4. HEADER (Judul) */
    .neo-alert-header {
        border-bottom: 3px solid #000;
        padding: 10px 16px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
    }

    /* Warna Header Berdasarkan Tipe */
    .neo-alert-box.error .neo-alert-header {
        background-color: #FF6B6B; /* Merah Pastel */
        color: #000;
    }

    .neo-alert-box.success .neo-alert-header {
        background-color: #4ECDC4; /* Tosca Retro */
        color: #000;
    }

    /* Tombol X kecil di header */
    .neo-close-icon {
        cursor: pointer;
        padding: 0 5px;
        font-size: 20px;
        line-height: 1;
    }
    .neo-close-icon:hover { background: #000; color: #fff; }

    /* 5. CONTENT (Isi Pesan) */
    .neo-alert-content {
        padding: 24px;
        color: #000;
        font-size: 16px;
        line-height: 1.5;
        font-weight: 600;
    }

    /* List error jika banyak */
    .neo-alert-content ul {
        margin: 10px 0 0 0;
        padding-left: 20px;
        list-style-type: square;
    }

    /* 6. FOOTER (Tombol Bawah) */
    .neo-alert-footer {
        padding: 0 24px 24px 24px;
        text-align: right;
    }

    .neo-btn {
        background: #000;
        color: #fff;
        border: 2px solid #000;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        cursor: pointer;
        box-shadow: 4px 4px 0px #888; /* Bayangan tombol abu */
        transition: none; /* Matikan transisi halus */
    }

    /* Efek tekan tombol kasar */
    .neo-btn:hover {
        background: #fff;
        color: #000;
        transform: translate(2px, 2px);
        box-shadow: 2px 2px 0px #000;
    }
    .neo-btn:active {
        transform: translate(4px, 4px);
        box-shadow: none;
    }

    /* ANIMATIONS */
    @keyframes snapShow {
        0% { opacity: 0; }
        100% { opacity: 1; }
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
    function closeNeoAlert(elementId) {
        const el = document.getElementById(elementId);
        if (el) {
            // Langsung hapus tanpa animasi fade out (sesuai request: tidak smooth/lebay)
            el.style.display = 'none'; 
            el.remove();
        }
    }

    // Opsional: Auto close setelah 5 detik
    // Hapus bagian ini jika ingin user menutup manual
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const overlays = document.querySelectorAll('.neo-alert-overlay');
            overlays.forEach(overlay => overlay.remove());
        }, 5000);
    });
</script><style>
    /* 1. RESET & BASE STYLE */
    .neo-alert-wrapper {
        font-family: 'Courier New', Courier, monospace;
        box-sizing: border-box;
    }

    /* 2. OVERLAY (Latar Belakang) */
    .neo-alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: overlayFadeIn 0.3s ease-out;
    }

    /* 3. ALERT BOX (Kotak Utama) */
    .neo-alert-box {
        background: #fff;
        width: 420px;
        max-width: 90%;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: boxSlideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    /* Decorative gradient line */
    .neo-alert-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #FF6B6B, #4ECDC4, #FFD93D);
        animation: gradientShift 3s ease infinite;
    }

    /* 4. HEADER (Judul) */
    .neo-alert-header {
        padding: 20px 24px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        position: relative;
        margin-top: 4px;
    }

    /* Warna Header Berdasarkan Tipe */
    .neo-alert-box.error .neo-alert-header {
        background: linear-gradient(135deg, #FFE5E5 0%, #FFF0F0 100%);
        color: #D32F2F;
    }

    .neo-alert-box.success .neo-alert-header {
        background: linear-gradient(135deg, #E8F5F4 0%, #F0FFFE 100%);
        color: #00897B;
    }

    /* Tombol X kecil di header */
    .neo-close-icon {
        cursor: pointer;
        padding: 4px 8px;
        font-size: 22px;
        line-height: 1;
        border-radius: 50%;
        transition: all 0.2s ease;
        opacity: 0.6;
    }
    .neo-close-icon:hover { 
        opacity: 1;
        background: rgba(0, 0, 0, 0.1);
        transform: rotate(90deg);
    }

    /* 5. CONTENT (Isi Pesan) */
    .neo-alert-content {
        padding: 24px 24px 28px;
        color: #2C3E50;
        font-size: 15px;
        line-height: 1.6;
        font-weight: 500;
    }

    /* List error jika banyak */
    .neo-alert-content ul {
        margin: 12px 0 0 0;
        padding-left: 20px;
        list-style-type: none;
    }

    .neo-alert-content ul li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 8px;
    }

    .neo-alert-content ul li::before {
        content: '▸';
        position: absolute;
        left: 0;
        color: #FF6B6B;
        font-weight: bold;
    }

    /* 6. FOOTER (Tombol Bawah) */
    .neo-alert-footer {
        padding: 0 24px 24px 24px;
        text-align: right;
    }

    .neo-btn {
        background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
        color: #fff;
        border: none;
        padding: 12px 32px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .neo-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .neo-btn:hover::before {
        left: 100%;
    }

    /* Efek hover tombol */
    .neo-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .neo-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.4);
    }

    /* ANIMATIONS */
    @keyframes overlayFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes boxSlideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    @keyframes overlayFadeOut {
        from { opacity: 1; }
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
    function closeNeoAlert(elementId) {
        const el = document.getElementById(elementId);
        if (el) {
            // Animasi smooth fade out
            el.style.animation = 'overlayFadeOut 0.3s ease-out';
            setTimeout(() => {
                el.remove();
            }, 300);
        }
    }

    // Auto close setelah 6 detik dengan animasi
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const overlays = document.querySelectorAll('.neo-alert-overlay');
            overlays.forEach(overlay => {
                overlay.style.animation = 'overlayFadeOut 0.3s ease-out';
                setTimeout(() => overlay.remove(), 300);
            });
        }, 6000);
    });
</script>