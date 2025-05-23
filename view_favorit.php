<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

require 'db_config.php';

try {
    // Ambil semua jurnal dengan status is_favorit = 1
    $stmt = $conn->query("SELECT * FROM entries WHERE is_favorit = 1 ORDER BY tanggal DESC");

    // Simpan hasil query ke dalam array
    $favorit_jurnals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error mengambil data jurnal favorit: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jurnal Favorit</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styling tambahan untuk halaman favorit */
        .container {
            max-width: 900px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 40px 30px;
        }

        h1 {
            text-align: center;
            color: #1e3a5f;
            margin-bottom: 30px;
        }

        .entry {
            background-color: #f9fafb;
            padding: 20px;
            border-left: 6px solid gold;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .entry h3 {
            margin-top: 0;
            color: #1e3a5f;
        }

        .entry p {
            color: #333;
        }

        .action-box {
            text-align: center;
            margin-top: 30px;
        }

        .btn-kembali {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1e3a5f;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-kembali:hover {
            background-color: #2c5282;
        }
    </style>
</head>
<body>

<div class="container">
    <h1> Jurnal Favorit</h1>

    <?php if (count($favorit_jurnals) > 0): ?>
        <?php foreach ($favorit_jurnals as $jurnal): ?>
            <div class="entry">
                <h3><?= htmlspecialchars($jurnal['subjek']) ?></h3>
                <p><strong>Tanggal:</strong> <?= htmlspecialchars($jurnal['tanggal']) ?></p>
                <p><?= nl2br(htmlspecialchars($jurnal['catatan'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center;">Belum ada jurnal ditandai sebagai favorit.</p>
    <?php endif; ?>

    <div class="action-box">
        <a href="view_entries.php" class="btn-kembali">← Kembali ke Semua Jurnal</a>
    </div>
</div>

</body>
</html>
