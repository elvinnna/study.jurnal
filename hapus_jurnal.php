<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'db_config.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    try {
        $stmt = $conn->prepare("DELETE FROM entries WHERE id = ?");
        $stmt->execute([$id]);

        // Redirect kembali ke halaman daftar jurnal
        header("Location: view_entries.php");
        exit;
    } catch (PDOException $e) {
        die("Error menghapus jurnal: " . $e->getMessage());
    }
} else {
    die("ID tidak valid.");
}
?>
