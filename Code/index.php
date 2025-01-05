<?php
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Daily Journal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="./style/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm p-3 fixed-top bg-white">
      <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#">My <span class="text-danger">Daily Journal</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-dark fs-5" href="#home">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fs-5 ms-3" href="#article">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark fs-5 ms-3" href="#gallery">Gallery</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section id="home" class="bg-light">
      <div class="container">
        <div class="d-flex flex-column justify-content-center vh-100 align-items-center">
          <h1 class="fw-bold text-center">My Daily <br>Journal</h1>
          <button type="button" class="btn btn-warning fs-6 fw-bold mt-2" onclick="location.href='login.php'">Login Here !</button>
        </div>
      </div>
    </section>

    <!-- Article Section -->
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <?php
          $sql = "SELECT * FROM article ORDER BY tanggal DESC";
          $hasil = $conn->query($sql);
          while ($row = $hasil->fetch_assoc()) {
          ?>
          <div class="col">
            <div class="card h-100">
              <img src="img/<?= $row["gambar"] ?>" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title"><?= $row["judul"] ?></h5>
                <p class="card-text"><?= $row["isi"] ?></p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary"><?= $row["tanggal"] ?></small>
              </div>
            </div>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="text-center p-5">
      <div class="container">
        <div class="title text-center mb-4 mt-5">
          <h1 class="fw-bold">Gallery</h1>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <?php
          $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
          $hasil = $conn->query($sql);
          while ($row = $hasil->fetch_assoc()) {
          ?>
          <div class="col">
            <div class="card h-100">
              <img src="img/<?= $row["gambar"] ?>" class="card-img-top" alt="..." />
              <div class="card-body">
                <h5 class="card-title"><?= $row["judul"] ?></h5>
                <p class="card-text"><?= $row["deskripsi"] ?></p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary"><?= $row["tanggal"] ?></small>
              </div>
            </div>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
    </section>

    <footer class="p-4 bg-light text-center mt-5">Copyright &copy; 2024 Naban Journal Gallery. All Rights Reserved</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
