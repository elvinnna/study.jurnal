<?php
session_start();
require 'db_config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil kata kunci dari form pencarian
$kata_kunci = isset($_GET['cari']) ? $_GET['cari'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Daftar Jurnal</title>
    <style>
        /* Dark Mode Toggle */
        .dark-mode-toggle {
            margin-bottom: 20px;
        }

        .btn-theme {
            padding: 10px 20px;
            background-color: #94a3b8;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-theme:hover {
            background-color: #64748b;
        }

        /* Search Box */
        .search-box {
            margin-bottom: 20px;
        }

        .search-box input[type="text"] {
            width: 100%;
            max-width: 400px;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .search-box input[type="submit"] {
            padding: 15px;
            background-color: #1e3a5f;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
            transition: background-color 0.3s ease;
        }

        .search-box input[type="submit"]:hover {
            background-color: #2c5282;
        }

        .action-box a {
            display: inline-block;
            padding: 10px;
            background-color: #1e3a5f; /* navy */
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        .action-box a:hover {
            background-color: #2c5282;
        }

        /* Tombol Hapus & Favorit */
        .entry-actions {
            margin-top: 10px;
        }

        .entry-actions a,
        .entry-actions button {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-hapus {
            color: red;
        }

        .btn-hapus:hover {
            text-decoration: underline;
        }

        .btn-favorit {
            background: none;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            margin-left: 10px;
            transition: transform 0.2s ease;
        }

        .btn-favorit:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Daftar Jurnal</h1>

    <!-- Tombol Dark Mode -->
    <div class="dark-mode-toggle">
        <button id="theme-toggle" class="btn-theme">🌙 Mode Gelap</button>
    </div>

    <!-- Form Pencarian -->
    <div class="search-box">
        <form method="GET" action="">
            <input type="text" name="cari" placeholder="Cari judul atau isi jurnal..." value="<?= htmlspecialchars($kata_kunci) ?>">
            <input type="submit" value="Cari">
        </form>
    </div>

    <!-- Kotak Tambah Jurnal -->
    <div class="action-box">
        <a href="tambah_jurnal.html">+ Tambah Jurnal Baru</a>
        <a href="view_favorit.php">⭐ Lihat Jurnal Favorit</a>
    </div>

    <?php
    try {
        // Query dasar
        $query = "SELECT * FROM entries";

        // Jika ada pencarian, tambahkan kondisi LIKE
        if (!empty($kata_kunci)) {
            $query .= " WHERE subjek LIKE :cari OR catatan LIKE :cari";
        }

        $query .= " ORDER BY tanggal DESC";
        $stmt = $conn->prepare($query);

        if (!empty($kata_kunci)) {
            $stmt->bindValue(':cari', '%' . $kata_kunci . '%', PDO::PARAM_STR);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='entry'>";
                echo "<h3>" . htmlspecialchars($row['subjek']) . "</h3>";
                echo "<p><strong>Tanggal:</strong> " . htmlspecialchars($row['tanggal']) . "</p>";
                echo "<p>" . nl2br(htmlspecialchars($row['catatan'])) . "</p>";

                // Tombol Hapus + Favorit
                echo "<div class='entry-actions'>";
                // Tombol Hapus
                echo "<a href='#' onclick=\"confirmDelete({$row['id']})\" class='btn-hapus'> Hapus</a>";

                // Tombol Favorit
                echo "<form method='POST' action='toggle_favorit.php' style='display:inline;'>";
                echo "<input type='hidden' name='id' value='{$row['id']}'>";
                echo "<button type='submit' class='btn-favorit' title='Toggle Favorit'>";
                echo $row['is_favorit'] ? '⭐' : '✩';
                echo "</button>";
                echo "</form>";

                echo "</div>"; // Tutup entry-actions
                echo "</div>"; // Tutup entry
            }
        } else {
            echo "<p style='text-align:center;'>Tidak ada jurnal ditemukan.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red; text-align:center;'>Error mengambil data: " . $e->getMessage() . "</p>";
    }
    ?>

    <div class="action-box">
        <a href="tambah_jurnal.html" class="btn-tambah">+ Tambah Jurnal Lagi</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<!-- Script Konfirmasi Hapus -->
<script>
    function confirmDelete(id) {
        if (confirm("Apakah Anda yakin ingin menghapus jurnal ini?")) {
            window.location.href = "hapus_jurnal.php?id=" + id;
        }
    }
</script>

<!-- Script Dark Mode -->
<script src="theme.js"></script>

</body>
</html>
