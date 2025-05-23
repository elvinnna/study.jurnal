<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'db_config.php';

// Ambil ID dari form POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
    try {
        // Ambil status saat ini
        $stmt = $conn->prepare("SELECT is_favorit FROM entries WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Toggle status favorit
            $new_status = $row['is_favorit'] ? 0 : 1;

            // Update ke database
            $update = $conn->prepare("UPDATE entries SET is_favorit = ? WHERE id = ?");
            $update->execute([$new_status, $id]);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Redirect kembali ke halaman daftar jurnal
header("Location: view_entries.php");
exit;
?>
