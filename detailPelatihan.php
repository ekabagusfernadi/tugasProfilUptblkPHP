<?php
  require "config.php";

    $id_program_pelatihan = $_GET["id_pelatihan"];
  // ambil tabel program_pelatihan
  $queryAmbilProgPelDetail = "SELECT * FROM program_pelatihan JOIN kategori_pelatihan ON(program_pelatihan.id_kategori = kategori_pelatihan.id_kategori) WHERE id_program_pelatihan = '$id_program_pelatihan'";
  $objekAmbilProgPelDetail = mysqli_query($conn, $queryAmbilProgPelDetail);
  $progPel = mysqli_fetch_assoc($objekAmbilProgPelDetail);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UPT BLK Surabaya</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="favicon.png">
  </head>
  <body id="home">
    <!-- navbar -->
    <nav id="navbar">
      <div class="topnav">
        <div class="wadah-header"><img src="img/Logo-jatim.png" alt="logo-upt" />
        <span class="nama-logo">UPT BLK Surabaya</span></div>
        <div class="float-right">
          <a href="index.php">&#9750; HOME</a>
          <a href="#nama-pelatihan">NAMA PELATIHAN</a>
          <a href="#deskripsi">DESKRIPSI & KURIKULUM PELATIHAN</a>
        </div>
      </div>
    </nav>
    <!-- akhir navbar -->

    <!-- jumbotron -->
    <section id="jumbotron" class="jumbotron jumbotron-fluid" style="height: 200px; filter: grayscale(80%);">
      <div class="container" style="top: -140px;">
        <p class="jumbotron-p1">Kejuruan <span><?= $progPel["nama_kategori"]; ?></span></p>
        <p class="jumbotron-p2"><span><?= strtoupper($progPel["nama_pelatihan"]); ?></span></p>
        <p class="jumbotron-p1" style="margin-top: 30px;">&#9716; <?= $progPel["total_jam"]; ?> Jam Pelatihan</p>
      </div>
    </section>
    <!-- akhir jumbotron -->

    <!-- pendaftaran pelatihan -->
    <section id="pendaftaran-pelatihan">
      <div class="container">
        <div class="pendaftaran-judul" id="nama-pelatihan">
          <h1>DETAIL <?= strtoupper($progPel["nama_pelatihan"]); ?></h1>
          <p>Berikut ini adalah informasi secara detail dari program pelatihan <?= $progPel["nama_pelatihan"]; ?>.</p>
        </div>
        <div class="pendaftaran-content">
          <div class="pendaftaran-content-kiri">
            
            <h3 style="margin-bottom: 18px;">Foto Program Pelatihan</h3>
            <div id="slider-profil" style="border-radius: 10px;">
            <figure>
                <img src="img/programPelatihan/<?= $progPel["gambar_1"]; ?>"/>
                <img src="img/programPelatihan/<?= $progPel["gambar_2"]; ?>"/>
                <img src="img/programPelatihan/<?= $progPel["gambar_3"]; ?>"/>
                <img src="img/programPelatihan/<?= $progPel["gambar_1"]; ?>"/>
                <img src="img/programPelatihan/<?= $progPel["gambar_2"]; ?>"/>
                
            </figure>
            </div>
            
          </div>
          <div class="pendaftaran-content-kanan" id="deskripsi">
            <div class="alur-pendaftaran-offline">
              <h3>Deskripsi Pelatihan</h3>
              <p><?= $progPel["deskripsi_pelatihan"]; ?></p>
            </div>
            <div class="alur-pendaftaran-online">
              <h3>Kurukulum Pelatihan</h3>
              <p style="margin-bottom: 20px;">Untuk saat ini belum ada kurikulum pelatihan.</p>
            </div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </section>
    <!-- akhir pendaftaran pelatihan -->

    <!-- back to top -->
    <section id="back-to-top">
      <a href="#home">
        <img src="img/icon/back to top.png"   alt="back-to-top-nich">
      </a>
    </section>
    <!-- akhir back to top -->

    <!-- footer -->
    <footer id="footer">
      <div class="container">
        <div class="made-with">
          <p>
            Made With <span>&hearts;</span> by kijangcitys.
          </p>
        </div>
        <p>
          <span>Copyright &copy; 2021</span> | UPT Balai Latihan Kerja Surabaya.
        </p>
      </div>
    </footer>
    <!-- akhir footer -->
    <script src="script.js"></script>
  </body>
</html>
