<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1e40af;
            --secondary-blue: #1e3a8a;
            --accent-gold: #fbbf24;
            --light-gold: #fcd34d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            min-height: 100vh;
            position: relative;
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(251, 191, 36, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(251, 191, 36, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-wrapper {
            width: 100%;
            max-width: 460px;
        }

        /* Logo/Header Section */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeInDown 0.6s ease-out;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-gold) 0%, var(--light-gold) 100%);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(251, 191, 36, 0.3);
        }

        .login-logo i {
            font-size: 2.5rem;
            color: var(--primary-blue);
        }

        .login-header h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin: 0;
        }

        /* Card */
        .card {
            background: white;
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }

        .card-body {
            padding: 40px;
        }

        .card-title {
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 8px;
            text-align: center;
        }

        .card-subtitle {
            color: #64748b;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Alert Messages */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 14px 18px;
            margin-bottom: 24px;
            animation: slideInDown 0.4s ease-out;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #16a34a;
            border-left: 4px solid #16a34a;
        }

        /* Form Elements */
        .form-label {
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            color: var(--accent-gold);
            font-size: 1rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.1);
            background: white;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        /* Password Toggle */
        .password-toggle {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .password-toggle-btn:hover {
            background: rgba(251, 191, 36, 0.1);
            color: var(--accent-gold);
        }

        .password-toggle-btn i {
            font-size: 1.2rem;
        }

        /* CAPTCHA */
        .captcha-box {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            margin-bottom: 12px;
            position: relative;
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
            border: 2px solid rgba(251, 191, 36, 0.3);
        }

        .captcha-text {
            font-size: 36px;
            font-weight: bold;
            color: white;
            letter-spacing: 12px;
            font-family: 'Courier New', monospace;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
            user-select: none;
            padding: 8px 0;
        }

        .captcha-refresh {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(251, 191, 36, 0.2);
            border: 2px solid rgba(251, 191, 36, 0.4);
            color: var(--accent-gold);
            border-radius: 10px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .captcha-refresh:hover {
            background: rgba(251, 191, 36, 0.3);
            border-color: var(--accent-gold);
            transform: rotate(180deg);
        }

        .captcha-refresh i {
            display: block;
        }

        /* Submit Button */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(30, 64, 175, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(251, 191, 36, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.4);
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary i {
            margin-right: 8px;
        }

        /* Error Message */
        .text-danger {
            font-size: 0.85rem;
            margin-top: 6px;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .card-body {
                padding: 30px 24px;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }

            .captcha-text {
                font-size: 28px;
                letter-spacing: 8px;
            }
        }

        /* Loading State */
        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h1>Admin Panel</h1>
                <p>Sistem Informasi Pemerintah</p>
            </div>

            <!-- Card Login -->
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title">Selamat Datang</h2>
                    <p class="card-subtitle">Silakan masuk ke akun Anda</p>

                    <!-- Alert Success -->
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Alert Error -->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="POST">
                        <?= csrf_field() ?>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="bi bi-person-fill"></i>
                                Username
                            </label>
                            <input 
                                type="text" 
                                name="username" 
                                id="username" 
                                class="form-control" 
                                placeholder="Masukkan username Anda"
                                value="<?= old('username') ?>"
                                required>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill"></i>
                                Password
                            </label>
                            <div class="password-toggle">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    class="form-control" 
                                    placeholder="Masukkan password Anda"
                                    required>
                                <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- CAPTCHA -->
                        <div class="mb-4">
                            <label for="captcha" class="form-label">
                                <i class="bi bi-shield-lock-fill"></i>
                                Kode Keamanan
                            </label>
                            <div class="captcha-box">
                                <button type="button" class="captcha-refresh" onclick="generateCaptcha()" title="Refresh CAPTCHA">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                                <div class="captcha-text" id="captchaDisplay"></div>
                            </div>
                            <input 
                                type="text" 
                                name="captcha" 
                                id="captchaInput" 
                                class="form-control" 
                                placeholder="Masukkan kode di atas"
                                autocomplete="off"
                                required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Masuk ke Sistem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script>
        let captchaCode = '';

        function generateCaptcha() {
            // Generate random 6 digit number
            captchaCode = Math.floor(100000 + Math.random() * 900000).toString();
            document.getElementById('captchaDisplay').textContent = captchaCode;
            document.getElementById('captchaInput').value = '';
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'bi bi-eye';
            }
        }

        // Generate captcha on page load
        window.onload = function() {
            generateCaptcha();
        };
    </script>
</body>
</html>