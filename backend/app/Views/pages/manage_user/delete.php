
<?php
// ========================================
// FILE: delete.php (Optional - untuk direct delete via URL)
// ========================================
?>
<?php
// File ini optional karena delete sudah ada di index.php dan show.php
// Tapi bisa digunakan jika ingin delete via direct URL

$userId = isset($_GET['id_user']) ? $_GET['id_user'] : null;

if (!$userId) {
    header('Location: index.php?error=invalid_id');
    exit;
}

// Redirect to index with delete confirmation
header("Location: index.php?delete=" . $userId);
exit;
?>

