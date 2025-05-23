<?php
// Tampilkan semua error untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Jika tidak ada session username, redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Jurnal Belajar</title>
</head>
<body>

<div class="container">
    <h1>Selamat Datang di Jurnal Belajar 👋, <?= htmlspecialchars($_SESSION['username']) ?> </h1>
    <div class="navbar">
        <a href="tambah_jurnal.html" class="btn">Tambah Jurnal</a>
        <a href="view_entries.php" class="btn">Lihat Jurnal</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <!-- Dark Mode Toggle -->
    <button id="theme-toggle" class="btn-theme">🌙 Mode Gelap</button>

    <div class="card">
        <p>Ayo mulai jurnalmu hari ini dan lacak perkembangan belajarmu!</p>
    </div>
</div>

<script src="theme.js"></script>

</body>
</html>
