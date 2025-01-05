<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug isi $_POST dan $_FILES
var_dump($_POST);
var_dump($_FILES);
?>


<?php
session_start();

include "koneksi.php"; // Pastikan file koneksi benar

// Periksa apakah form sudah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $foto = $_FILES['foto'] ?? null;

    // Validasi data
    if (empty($username) || empty($password) || empty($foto['name'])) {
        die("Semua field harus diisi!");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Upload foto
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto["name"]);
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Buat folder jika belum ada
    }
    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
        $foto_path = $target_file;
    } else {
        die("Gagal mengunggah foto.");
    }

    // Masukkan data ke database
    $sql = "INSERT INTO user (username, password, foto) VALUES ('$username', '$hashed_password', '$foto_path')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    die("Formulir belum dikirim.");
}
?>




    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Registrasi</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>
    <form action="./register.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrasi</button>
    </form>

    </body>
    </html>
