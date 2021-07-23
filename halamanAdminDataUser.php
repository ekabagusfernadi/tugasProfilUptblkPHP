<?php
    session_start();    // harus paling atas
    require "config.php";

    // cek cookie
    if( isset($_COOKIE["id"]) && isset($_COOKIE["key"]) ) {
        $id = $_COOKIE["id"];
        $key = $_COOKIE["key"];

        // ambil username berdasarkan id
        $result = mysqli_query($conn, "SELECT * FROM user WHERE id_user = $id");
        $row = mysqli_fetch_assoc($result);

        // cek cookie dan username
        if( $key === hash("sha256", $row["nik"]) ) {
            $_SESSION["login"] = true;
        }
    }

    if ( !isset($_SESSION["login"]) ) {
        header("Location: index.php");
        exit;
    }

    // ambil data list user
    $queryAmbilListPendaftaran = "SELECT * FROM user WHERE `status` = 0";

    $objekAmbilListPendaftaran = mysqli_query($conn, $queryAmbilListPendaftaran);
    $listPendaftarans = [];
    while( $listPendaftaran = mysqli_fetch_assoc($objekAmbilListPendaftaran) ) {
      $listPendaftarans[] = $listPendaftaran;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>List User</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="favicon.png">
  </head>
  <body id="home" style="background-color: rgba(0,0,0,0.03);">
    <!-- navbar -->
    <nav id="navbar">
      <div class="topnav">
        <div class="wadah-header"><img src="img/Logo-jatim.png" alt="logo-upt" />
        <span class="nama-logo">UPT BLK Surabaya</span></div>
        <div class="float-right">
          <a href="index.php">&#9750; HOME</a>
          <a href="halamanAdmin.php">DATA PENDAFTARAN PELATIHAN</a>
          <a href="#daftar-pelatihan">LIST DATA USER</a>
        </div>
      </div>
    </nav>
    <!-- akhir navbar -->

    <!-- jumbotron -->
    <section id="jumbotron" class="jumbotron jumbotron-fluid" style="height: 0px; filter: grayscale(100%);">
       
    </section>
    <hr color="#dedede">
    <!-- akhir jumbotron -->

    <!-- tampil data -->
    <section id="tampil-data">

      <div class="container">
        
        <div class="wadah-list-pendaftaran">
        <div class="pendaftaran-judul" id="daftar-pelatihan">
          <h1>LIST DATA USER</h1>
          <p>Berikut ini adalah halaman list data diri dari user yang telah membuat akun di website ini.</p>

        </div>

        <center><a href="tambahDataUser.php" class="tombol-tambah">Tambah User</a></center>
        
        <div class="pencarian">
          <input type="text" name="cariUser" id="cari-user" autocomplete="off" placeholder="Cari...">
        </div>

          <table cellpadding="10" cellspacing="0" width="100%" style="margin-top: 20px;" id="konten-table-user">

            <tr>
              <th>No.</th>
              <th>Aksi</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>NIK</th>
              <th>NO HP</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach( $listPendaftarans as $listPen ) : ?>
              <tr>
              <td><?= $i++; ?></td>
              <td><a href="editDataUser.php?id_user=<?= $listPen['id_user']; ?>" class="tombol-aksi">Edit</a><br><br><a href="hapusDataUser.php?id_user=<?= $listPen['id_user']; ?>" class="tombol-aksi" onclick="return confirm('Yakin Kawan?');">Hapus</a></td>
              <td><img src="img/dokumenUser/foto/<?= $listPen['foto_user']; ?>" width="70" height="90"></td>
              <td><?= $listPen['nama_user']; ?></td>
              <td><?= $listPen['nik']; ?></td>
              <td><?= $listPen['no_hp']; ?></td>
            </tr>
            <?php endforeach; ?>
          </table>

        </div>

      </div>
    </section>
    <!-- akhir tampil data -->

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
