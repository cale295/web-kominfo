document.addEventListener("DOMContentLoaded", function () {
  const selectAllCheckbox = document.getElementById("selectAll");
  const userCheckboxes = document.querySelectorAll(".user-checkbox");
  const deleteBtn = document.getElementById("deleteSelectedBtn");
  const selectedCountSpan = document.getElementById("selectedCount");
  const deleteForm = document.getElementById("deleteSelectedForm");

  // Fungsi untuk memperbarui status tombol "Hapus Terpilih"
  function updateDeleteButtonState() {
    const checkedBoxes = document.querySelectorAll(".user-checkbox:checked");
    const count = checkedBoxes.length;

    selectedCountSpan.textContent = count;

    if (count > 0) {
      deleteBtn.disabled = false;
    } else {
      deleteBtn.disabled = true;
    }

    // Sinkronisasi checkbox "Select All"
    selectAllCheckbox.checked = count > 0 && count === userCheckboxes.length;
  }

  // Event listener untuk checkbox "Select All"
  selectAllCheckbox.addEventListener("change", function (e) {
    userCheckboxes.forEach((cb) => (cb.checked = e.target.checked));
    updateDeleteButtonState();
  });

  // Event listener untuk setiap checkbox user
  userCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", updateDeleteButtonState);
  });

  // Event listener untuk tombol "Hapus Terpilih"
  deleteBtn.addEventListener("click", function () {
    const checkedBoxes = document.querySelectorAll(".user-checkbox:checked");
    const ids = Array.from(checkedBoxes).map((cb) => cb.dataset.id);

    if (ids.length > 0) {
      if (
        confirm(
          `Apakah Anda yakin ingin menghapus ${ids.length} pengguna terpilih?`
        )
      ) {
        // Hapus input tersembunyi yang mungkin ada sebelumnya
        deleteForm
          .querySelectorAll('input[name="user_ids[]"]')
          .forEach((input) => input.remove());

        // Tambahkan ID yang terpilih sebagai input tersembunyi ke dalam form
        ids.forEach((id) => {
          const input = document.createElement("input");
          input.type = "hidden";
          input.name = "user_ids[]"; // Nama sebagai array agar mudah dibaca di PHP
          input.value = id;
          deleteForm.appendChild(input);
        });

        // Kirim form
        deleteForm.submit();
      }
    }
  });

  // Panggil fungsi sekali saat halaman dimuat untuk memastikan status tombol benar
  updateDeleteButtonState();

  // --- Kode Filter Anda (sudah benar, tidak perlu diubah) ---
  // Search Filter
  document
    .getElementById("searchInput")
    .addEventListener("input", function (e) {
      const searchTerm = e.target.value.toLowerCase();
      const rows = document.querySelectorAll("#usersTable tbody tr");

      rows.forEach((row) => {
        if (row.querySelector("td").colSpan === 7) return; // Abaikan baris "empty state"
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? "" : "none";
      });
    });

  // Role Filter
  document
    .getElementById("roleFilter")
    .addEventListener("change", function (e) {
      const filterRole = e.target.value.toLowerCase();
      const rows = document.querySelectorAll("#usersTable tbody tr");

      rows.forEach((row) => {
        if (row.querySelector("td").colSpan === 7) return; // Abaikan baris "empty state"
        if (!filterRole) {
          row.style.display = "";
        } else {
          const roleCell = row.querySelector(".role-badge");
          const role = roleCell
            ? roleCell.textContent.trim().toLowerCase()
            : "";
          row.style.display = role.includes(filterRole) ? "" : "none";
        }
      });
    });
});
