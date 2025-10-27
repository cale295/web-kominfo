// Password Toggle
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Toggle icon
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
});

// Password Strength Checker
document.getElementById('password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const strengthContainer = document.getElementById('passwordStrength');
    
    if (password.length === 0) {
        strengthContainer.classList.remove('show');
        strengthText.textContent = '';
        return;
    }
    
    strengthContainer.classList.add('show');
    
    let strength = 0;
    let feedback = '';
    
    // Length check
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 25;
    
    // Character variety checks
    if (/[a-z]/.test(password)) strength += 15;
    if (/[A-Z]/.test(password)) strength += 15;
    if (/[0-9]/.test(password)) strength += 10;
    if (/[^a-zA-Z0-9]/.test(password)) strength += 10;
    
    // Set color and feedback based on strength
    if (strength < 40) {
        strengthBar.style.width = strength + '%';
        strengthBar.style.background = '#dc3545';
        feedback = '❌ Lemah - Tingkatkan keamanan password';
    } else if (strength < 70) {
        strengthBar.style.width = strength + '%';
        strengthBar.style.background = '#ffc107';
        feedback = '⚠️ Sedang - Password cukup aman';
    } else {
        strengthBar.style.width = strength + '%';
        strengthBar.style.background = '#198754';
        feedback = '✅ Kuat - Password sangat aman';
    }
    
    strengthText.textContent = feedback;
    strengthText.style.color = strengthBar.style.background;
});

// Role Preview
document.getElementById('role').addEventListener('change', function(e) {
    const role = e.target.value;
    const preview = document.getElementById('rolePreview');
    
    preview.className = 'role-preview';
    
    if (!role) {
        preview.classList.remove('show');
        return;
    }
    
    preview.classList.add('show', role);
    
    const roleInfo = {
        'superadmin': {
            title: '🔴 Super Administrator',
            desc: 'Akses penuh ke seluruh sistem, termasuk manajemen pengguna dan pengaturan'
        },
        'admin': {
            title: '🔵 Administrator',
            desc: 'Dapat mengelola konten, pengguna, dan konfigurasi sistem'
        },
        'editor': {
            title: '🟢 Editor',
            desc: 'Dapat membuat dan mengedit konten seperti berita, artikel, dan galeri'
        }
    };
    
    if (roleInfo[role]) {
        preview.innerHTML = `
            <div><strong>${roleInfo[role].title}</strong></div>
            <div style="font-size: 0.85rem; margin-top: 4px; opacity: 0.9;">${roleInfo[role].desc}</div>
        `;
    }
});

// Username Auto-format (lowercase and remove spaces)
document.getElementById('username').addEventListener('input', function(e) {
    this.value = this.value.toLowerCase().replace(/\s/g, '_');
});

// Form Validation
document.getElementById('userForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password harus minimal 8 karakter!');
        document.getElementById('password').focus();
        return false;
    }
    
    const role = document.getElementById('role').value;
    if (!role) {
        e.preventDefault();
        alert('Silakan pilih role pengguna!');
        document.getElementById('role').focus();
        return false;
    }
});