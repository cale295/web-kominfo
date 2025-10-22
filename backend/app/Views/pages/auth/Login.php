<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --border-color: #dce1e6;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .login-header {
            background: white;
            padding: 40px 30px 30px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .login-header h1 {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .login-header p {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0;
        }

        .login-body {
            padding: 35px 30px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 13px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.2s ease;
            background-color: #fafbfc;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            outline: none;
            background-color: white;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 8px;
            font-size: 18px;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: var(--text-primary);
        }

        .captcha-container {
            background: #fafbfc;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 12px;
        }

        .captcha-display {
            background: white;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            position: relative;
            border: 2px solid var(--border-color);
        }

        .captcha-text {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: 10px;
            font-family: 'Courier New', monospace;
            user-select: none;
            padding: 5px 0;
        }

        .captcha-refresh {
            position: absolute;
            top: 8px;
            right: 8px;
            background: white;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            border-radius: 4px;
            padding: 4px 10px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .captcha-refresh:hover {
            background: #f5f7fa;
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        .captcha-label {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 10px;
            text-align: center;
        }

        .btn-login {
            background: var(--primary-color);
            border: none;
            border-radius: 6px;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: #34495e;
            box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        .alert {
            border: none;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fef1f1;
            color: #d63031;
            border-left: 3px solid #d63031;
        }

        .alert-success {
            background: #f0f9f4;
            color: #27ae60;
            border-left: 3px solid #27ae60;
        }

        .text-danger {
            color: #d63031;
            font-size: 13px;
            margin-top: 6px;
        }

        .d-none {
            display: none;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        @media (max-width: 576px) {
            .login-header h1 {
                font-size: 22px;
            }
            
            .login-body {
                padding: 30px 20px;
            }

            .captcha-text {
                font-size: 26px;
                letter-spacing: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1>Login</h1>
                <p>Silakan masuk dengan kredensial Anda</p>
            </div>

            <div class="login-body">
                <div id="alertContainer"></div>

                <form onsubmit="return handleSubmit(event)">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input 
                            type="text" 
                            name="username" 
                            id="username" 
                            class="form-control" 
                            placeholder="Masukkan username Anda"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control" 
                                placeholder="Masukkan password Anda"
                                required>
                            <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                                <span id="eyeIcon">👁️</span>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Verifikasi CAPTCHA</label>
                        <div class="captcha-container">
                            <div class="captcha-display">
                                <button type="button" class="captcha-refresh" onclick="generateCaptcha()" title="Muat ulang CAPTCHA">🔄</button>
                                <div class="captcha-text" id="captchaDisplay"></div>
                            </div>
                            <div class="captcha-label">Masukkan kode di atas</div>
                        </div>
                        <input 
                            type="text" 
                            name="captcha" 
                            id="captchaInput" 
                            class="form-control" 
                            placeholder="Masukkan kode CAPTCHA"
                            autocomplete="off"
                            required>
                        <small class="text-danger d-none" id="captchaError">Kode CAPTCHA tidak sesuai. Silakan coba lagi.</small>
                    </div>

                    <button type="submit" class="btn-login">Masuk</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script>
        let captchaCode = '';

        function generateCaptcha() {
            captchaCode = Math.floor(100000 + Math.random() * 900000).toString();
            document.getElementById('captchaDisplay').textContent = captchaCode;
            document.getElementById('captchaInput').value = '';
            document.getElementById('captchaError').classList.add('d-none');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '🔓';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = '👁️';
            }
        }

        function validateCaptcha() {
            const userInput = document.getElementById('captchaInput').value;
            const errorMsg = document.getElementById('captchaError');
            
            if (userInput !== captchaCode) {
                errorMsg.classList.remove('d-none');
                generateCaptcha();
                return false;
            }
            return true;
        }

        function handleSubmit(event) {
            event.preventDefault();
            
            if (!validateCaptcha()) {
                return false;
            }

            const alertContainer = document.getElementById('alertContainer');
            alertContainer.innerHTML = '<div class="alert alert-success">Login berhasil! Mengalihkan...</div>';
            
            return false;
        }

        window.onload = function() {
            generateCaptcha();
        };
    </script>
</body>
</html>