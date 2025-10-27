<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: 1px solid #ddd;
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
            color: #666;
            cursor: pointer;
            padding: 5px;
        }
        .captcha-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }
        .captcha-text {
            font-size: 32px;
            font-weight: bold;
            color: white;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            user-select: none;
        }
        .captcha-refresh {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.3);
            border: none;
            color: white;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 18px;
        }
        .captcha-refresh:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Login</h2>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="POST" onsubmit="return validateCaptcha()">
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
                                    <span id="eyeIcon">👁️</span>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="captcha" class="form-label">Kode CAPTCHA</label>
                            <div class="captcha-box">
                                <button type="button" class="captcha-refresh" onclick="generateCaptcha()" title="Refresh CAPTCHA">🔄</button>
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
                            <small class="text-danger d-none" id="captchaError">CAPTCHA tidak sesuai!</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
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
            document.getElementById('captchaError').classList.add('d-none');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '👁️‍🗨️';
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

        // Generate captcha on page load
        window.onload = function() {
            generateCaptcha();
        };
    </script>
</body>
</html>