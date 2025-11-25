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
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-900: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--gray-50);
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-logo {
            width: 56px;
            height: 56px;
            background-color: var(--primary);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .login-logo i {
            font-size: 1.75rem;
            color: white;
        }

        .login-header h1 {
            color: var(--gray-900);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .login-header p {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin: 0;
        }

        .card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 32px;
        }

        .alert {
            border-radius: 8px;
            border: 1px solid;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 0.875rem;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .alert i {
            margin-right: 6px;
        }

        .form-label {
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9375rem;
            transition: all 0.2s;
            background: white;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray-600);
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .password-toggle-btn:hover {
            background-color: var(--gray-100);
            color: var(--gray-900);
        }

        .password-toggle-btn i {
            font-size: 1.125rem;
        }

        .captcha-box {
            background-color: var(--gray-100);
            padding: 16px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 12px;
            position: relative;
            border: 1px solid var(--gray-200);
        }

        .captcha-text {
            font-size: 32px;
            font-weight: 600;
            color: var(--gray-900);
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            user-select: none;
            padding: 8px 0;
        }

        .captcha-refresh {
            position: absolute;
            top: 12px;
            right: 12px;
            background: white;
            border: 1px solid var(--gray-300);
            color: var(--gray-600);
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .captcha-refresh:hover {
            background-color: var(--gray-50);
            border-color: var(--gray-400);
            color: var(--gray-900);
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 500;
            font-size: 0.9375rem;
            transition: all 0.2s;
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-primary i {
            margin-right: 6px;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 24px;
            }

            .login-header h1 {
                font-size: 1.375rem;
            }

            .captcha-text {
                font-size: 28px;
                letter-spacing: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-header">
                <div class="login-logo">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h1>Admin Panel</h1>
                <p>Sistem Informasi Pemerintah</p>
            </div>

            <div class="card">
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input
                                type="text"
                                name="username"
                                id="username"
                                class="form-control"
                                placeholder="Masukkan username"
                                value="<?= old('username') ?>"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-toggle">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Masukkan password"
                                    required>
                                <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                                    <i class="bi bi-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="captcha" class="form-label">Kode Keamanan</label>
                            <div class="captcha-box">
                                <button type="button" class="captcha-refresh" onclick="generateCaptcha()" title="Refresh">
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

                        <button type="button" class="btn btn-primary w-100" onclick="validateForm()">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Masuk
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        let captchaCode = '';

        function validateForm() {
            const input = document.getElementById('captchaInput').value;

            if (input !== captchaCode) {
                alert("Kode keamanan salah!");
                return false;
            }

            // submit form kalau benar
            document.querySelector('form').submit();
        }

        function generateCaptcha() {
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

        window.onload = function() {
            generateCaptcha();
        };
    </script>
</body>

</html>