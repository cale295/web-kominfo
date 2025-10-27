// Password Toggle for Password
document
  .getElementById("togglePassword")
  .addEventListener("click", function () {
    const passwordInput = document.getElementById("password");
    const type =
      passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);

    this.classList.toggle("bi-eye");
    this.classList.toggle("bi-eye-slash");
  });

// Password Toggle for Confirm Password
document
  .getElementById("togglePasswordConfirm")
  .addEventListener("click", function () {
    const passwordInput = document.getElementById("password_confirm");
    const type =
      passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);

    this.classList.toggle("bi-eye");
    this.classList.toggle("bi-eye-slash");
  });

// Role Preview
document.getElementById("role").addEventListener("change", function (e) {
  const role = e.target.value;
  const preview = document.getElementById("rolePreview");

  preview.className = "role-preview";
  preview.style.display = "none";

  if (!role) return;

  preview.style.display = "block";
  preview.classList.add(role);

  const roleInfo = {
    superadmin: {
      title: "🔴 Super Administrator",
      desc: "Akses penuh ke seluruh sistem, termasuk manajemen pengguna dan pengaturan",
    },
    admin: {
      title: "🔵 Administrator",
      desc: "Dapat mengelola konten, pengguna, dan konfigurasi sistem",
    },
    editor: {
      title: "🟢 Editor",
      desc: "Dapat membuat dan mengedit konten seperti berita, artikel, dan galeri",
    },
  };

  if (roleInfo[role]) {
    preview.innerHTML = `
            <div><strong>${roleInfo[role].title}</strong></div>
            <div style="font-size: 0.85rem; margin-top: 4px; opacity: 0.9;">${roleInfo[role].desc}</div>
        `;
  }
});

// Username Auto-format
document.getElementById("username").addEventListener("input", function (e) {
  this.value = this.value.toLowerCase().replace(/\s/g, "_");
});

// Form Validation
document
  .getElementById("updateUserForm")
  .addEventListener("submit", function (e) {
    const pass = document.getElementById("password").value;
    const confirm = document.getElementById("password_confirm").value;

    // Jika password diisi
    if (pass !== "" || confirm !== "") {
      if (pass !== confirm) {
        e.preventDefault();
        alert("Password dan konfirmasi password tidak cocok!");
        document.getElementById("password_confirm").focus();
        return false;
      }
      if (pass.length < 6) {
        e.preventDefault();
        alert("Password minimal 6 karakter!");
        document.getElementById("password").focus();
        return false;
      }
    }

    const role = document.getElementById("role").value;
    if (!role) {
      e.preventDefault();
      alert("Silakan pilih role pengguna!");
      document.getElementById("role").focus();
      return false;
    }
  });

// Show role preview on load if role is selected
window.addEventListener("DOMContentLoaded", function () {
  const roleSelect = document.getElementById("role");
  if (roleSelect.value) {
    roleSelect.dispatchEvent(new Event("change"));
  }
});
