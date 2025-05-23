<?php
// Tampilkan semua error untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Pastikan request dari form login
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

include 'db_config.php';

// Debug koneksi
if (!$conn) {
    die("Koneksi database gagal");
}

$username = $_POST['username'];
$password = md5($_POST['password']); // Lebih baik gunakan password_hash() & password_verify()

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if (!$stmt) {
        die("Query gagal: " . json_encode($conn->errorInfo()));
    }

    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Username atau password salah!";
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
