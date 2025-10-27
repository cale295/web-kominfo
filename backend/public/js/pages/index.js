// Initialize tooltips
document.addEventListener("DOMContentLoaded", function () {
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});

// Toggle Status with AJAX
document.querySelectorAll(".form-toggle-status").forEach((form) => {
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const url = this.action;
    const formData = new FormData(this);
    const btn = this.querySelector("button");
    const icon = btn.querySelector("i");
    const row = this.closest("tr");
    const badgeCell = row.querySelector("td:nth-child(4) .badge-gov");

    // Add loading state
    btn.classList.add("loading");
    btn.disabled = true;

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          // Update icon and badge
          if (data.newStatus === "active") {
            icon.classList.remove("bi-toggle-off");
            icon.classList.add("bi-toggle-on");
            btn.classList.add("btn-toggle-active");
            btn.setAttribute("data-bs-original-title", "Nonaktifkan Menu");

            badgeCell.className = "badge-gov badge-active";
            badgeCell.textContent = "Aktif";
          } else {
            icon.classList.remove("bi-toggle-on");
            icon.classList.add("bi-toggle-off");
            btn.classList.remove("btn-toggle-active");
            btn.setAttribute("data-bs-original-title", "Aktifkan Menu");

            badgeCell.className = "badge-gov badge-inactive";
            badgeCell.textContent = "Nonaktif";
          }

          // Show success animation
          row.style.animation = "none";
          setTimeout(() => {
            row.style.animation = "fadeInUp 0.3s ease-out";
          }, 10);
        } else {
          // Show error alert
          showAlert("danger", data.message || "Gagal memperbarui status");
        }
      })
      .catch((err) => {
        console.error(err);
        showAlert("danger", "Terjadi kesalahan saat memperbarui status");
      })
      .finally(() => {
        // Remove loading state
        btn.classList.remove("loading");
        btn.disabled = false;
      });
  });
});

// Show Alert Function
function showAlert(type, message) {
  const alertClass =
    type === "danger" ? "alert-danger-gov" : "alert-success-gov";
  const icon =
    type === "danger" ? "bi-exclamation-triangle-fill" : "bi-check-circle-fill";
  const title = type === "danger" ? "Error!" : "Berhasil!";

  const alertHTML = `
        <div class="alert ${alertClass} alert-gov alert-dismissible fade show" role="alert">
            <i class="bi ${icon} me-2"></i>
            <strong>${title}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

  const container = document.querySelector(".container-fluid");
  const firstCard = container.querySelector(".card-gov");
  firstCard.insertAdjacentHTML("beforebegin", alertHTML);

  // Auto dismiss after 5 seconds
  setTimeout(() => {
    const alert = container.querySelector(".alert-gov");
    if (alert) {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }
  }, 5000);
}
