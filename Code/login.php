<?php
//memulai session atau melanjutkan session yang sudah ada
session_start();

//menyertakan code dari file koneksi
include "koneksi.php";

//check jika sudah ada user yang login arahkan ke halaman admin
if (isset($_SESSION['username'])) { 
	header("location:admin.php"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = md5($_POST['pass']); // menggunakan enkripsi md5

    // prepared statement
    $stmt = $conn->prepare("SELECT username FROM user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $hasil = $stmt->get_result();
    $row = $hasil->fetch_array(MYSQLI_ASSOC);

    if (!empty($row)) {
        // jika data ditemukan, simpan username ke session
        $_SESSION['username'] = $row['username'];
        header("location:admin.php");
    } else {
        // jika login gagal, redirect dengan parameter error
        header("location:login.php?error=true");
    }

    // menutup koneksi
    $stmt->close();
    $conn->close();
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./style/style.css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffe9a3;
        }
        .login-card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card login-card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <img src="./img/login.jpg" alt="Logo" class="img-fluid rounded-circle">
            <h1 class="h4 mt-2">Selamat Datang!</h1>
        </div>
        
        <!-- Pesan Error -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'true'): ?>
            <div class="alert alert-danger text-center" role="alert">
                Username atau Password salah!
            </div>
        <?php endif; ?>
        
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="user" class="form-label">Username</label>
                <input type="text" class="form-control" id="user" name="user" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg">Login</button>
        </form>
        <div class="text-center mt-3">
            <p class="mb-1">Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar</a></p>
            <p><a href="#" class="text-decoration-none text-muted">Lupa Password?</a></p>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
}
?>
