// Icon Preview Live Update
document.getElementById("menu_icon").addEventListener("input", function (e) {
  const iconClass = e.target.value;
  const previewIcon = document.getElementById("iconPreview");

  // Remove all bi- classes
  previewIcon.className = "";

  // Add new icon class
  if (iconClass) {
    previewIcon.className = iconClass;
  } else {
    previewIcon.className = "bi bi-question-circle";
  }
});

// Form Validation Enhancement
document.getElementById("menuForm").addEventListener("submit", function (e) {
  const menuName = document.getElementById("menu_name").value.trim();

  if (menuName === "") {
    e.preventDefault();
    alert("Nama Menu harus diisi!");
    document.getElementById("menu_name").focus();
    return false;
  }
});

// Auto-format URL input
document.getElementById("menu_url").addEventListener("blur", function (e) {
  let url = e.target.value.trim();

  if (url && !url.startsWith("/") && !url.startsWith("http")) {
    e.target.value = "/" + url;
  }
});

// Parent selection info
document.getElementById("parent_id").addEventListener("change", function (e) {
  const parentId = e.target.value;
  const urlInput = document.getElementById("menu_url");

  if (parentId !== "0") {
    // Submenu biasanya tidak perlu URL jika parent punya URL
    console.log("Submenu selected - URL optional");
  }
});
