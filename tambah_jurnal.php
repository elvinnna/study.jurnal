<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $judul = htmlspecialchars($_POST['subjek']);
    $konten = htmlspecialchars($_POST['catatan']);

    if (!empty($tanggal) && !empty($judul) && !empty($konten)) {
        try {
            $stmt = $conn->prepare("INSERT INTO entries (tanggal, subjek, catatan) VALUES (?, ?, ?)");
            $stmt->execute([$tanggal, $judul, $konten]);

            // Redirect ke view_entries.php setelah sukses
            header("Location: view_entries.php");
            exit(); // Selalu gunakan exit() setelah header redirect
        } catch (PDOException $e) {
            echo "<p>Gagal menambahkan jurnal: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Semua kolom harus diisi!</p>";
    }
}
?>
