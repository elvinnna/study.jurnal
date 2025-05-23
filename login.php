<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - Jurnal Belajar</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat :wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('buku.jpg'); /* Ganti dengan path gambar kamu */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2);
            z-index: -1;
        }
        
        .login-container {
            background-color: rgba(255, 255, 255, 0.7); /* Putih transparan */
            padding: 20px 10px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            border: 1px solid #ddd;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            font-size: 1.8rem;
            color: #1e3a5f; /* Biru tua sesuai index */
            margin-bottom: 10px;
            font-weight: 600;
        }

        .login-container h2 {
            color: #1e3a5f; /* Sesuaikan warna judul */
            font-weight: 600;
            margin-bottom: 25px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 70%;
            padding: 10px 18px;
            margin: 12px 0;
            border: none;
            border-radius: 30px;
            outline: none;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.7); 
            border: 1px solid #ccc;
        }

        .login-container input::placeholder {
            color: #aaa;
        }

        .login-container button {
            background-color: #3b82f6; /* Biru cerah */
            color: white;
            border: none;
            padding: 10px 18px;
            width: 70%;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #2563eb; /* Biru lebih gelap saat hover */
        }

        .error {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 14px;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }

        .loader {
            border: 4px solid #e0e0e0;
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-left: 10px;
            vertical-align: middle;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo"></div>
    <h2>Masuk ke Akun Belajar Anda</h2>

    <?php if (!empty($_SESSION['login_error'])): ?>
        <p class="error"><?= $_SESSION['login_error'] ?></p>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <form action="authenticate.php" method="POST" id="loginForm">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <button type="submit" id="loginBtn">
            Masuk
        </button>
        <div class="loader" id="loader"></div>
    </form>

    <div class="footer-text">© 2025 study.jurnal</div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('loginBtn');
        const loader = document.getElementById('loader');

        btn.style.opacity = '0.7';
        btn.style.cursor = 'not-allowed';
        btn.innerHTML = 'Memuat... ';
        loader.style.display = 'inline-block';

        // Nonaktifkan klik ulang
        btn.disabled = true;
    });
</script>

</body>
</html>
