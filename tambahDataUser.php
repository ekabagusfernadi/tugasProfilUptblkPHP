<?php
  session_start();
  require "config.php";
  require "function.php";

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
        $_SESSION["nama"] = $row["nama_user"];
        $_SESSION["id_user"] = $id;
    }
  }

  if ( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
  } else {
    $id_user = $_SESSION["id_user"];
  }

  if( isset($_POST["register"]) ) {
    $nik = stripslashes($_POST["nik"]);    // stripslashes berfungsi agar karakter /\ tidak masuk ke database
    $noHp = stripslashes($_POST["no-hp"]);    // stripslashes berfungsi agar karakter /\ tidak masuk ke database
    $password = mysqli_real_escape_string($conn, $_POST["password"]); // agar karakter escape terhitung string '
    $namaUser = stripslashes($_POST["nama"]);

    $konfirmasiPassword = mysqli_real_escape_string($conn, $_POST["konfirmasiPassword"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT * FROM user WHERE nik = '$nik' OR no_hp = '$noHp'");

    if( mysqli_fetch_assoc($result) ) { // jika menghasilkan nilia true ($result bisa di fetch)
        echo    "
                    <script>
                        alert('username sudah terdaftar');
                        document.location.href = '';
                    </script>
                ";

        exit;
    }

    // cek foto profil
    $fotoProfil = upload("foto-profil");
    if ($fotoProfil === false) {
      exit;
    }
    $fotoProfilBaru = $fotoProfil[1];

    // cek konfirmasi password
    if( $password !== $konfirmasiPassword ) {
        echo    "
                    <script>
                        alert('Konfirmasi password tidak sesuai');
                        document.location.href = '';
                    </script>
                ";

        exit;
    }
  

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT); // default mengikuti metode terupdate
    //$password = md5($password);   // mudah di baca menggunakan google
    //var_dump($password);

    // tambahkan userbaru ke database
    $queryInputUser = "INSERT INTO user(nik, no_hp, `password`, nama_user, foto_user) VALUES('$nik', '$noHp', '$password', '$namaUser', '$fotoProfilBaru')";
    mysqli_query($conn, $queryInputUser);

    if( mysqli_affected_rows($conn) > 0 ) {
      move_uploaded_file($fotoProfil[0], "img/dokumenUser/foto/" . $fotoProfil[1]);
      echo    "
                    <script>
                        alert('User Baru Berhasil Ditambahkan');
                        document.location.href = 'halamanAdminDataUser.php';
                    </script>
                ";
      } else {
          echo mysqli_error($conn);
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Data User</title>
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
          <a href="halamanAdminDataUser.php">&#8592; KEMBALI</a>
          <a href="#daftar-pelatihan">TAMBAH DATA USER</a>
        </div>
      </div>
    </nav>
    <!-- akhir navbar -->

    <!-- jumbotron -->
    <section id="jumbotron" class="jumbotron jumbotron-fluid" style="height: 0px; filter: grayscale(80%);">
    </section>
    <hr color="#dedede">
    <!-- akhir jumbotron -->

    <!-- pendaftaran pelatihan -->
    <section id="pendaftaran-pelatihan">
      <div class="container">
        <div class="pendaftaran-judul" id="daftar-pelatihan">
          <h1>Tambah Data User</h1>
          <p>Berikut ini adalah halaman yang digunakan admin untuk membuatkan user akun baru.</p>
        </div>
        <div class="pendaftaran-content">
          <div class="daftar-pelatihan-content">
            
            <form action="" method="post" enctype="multipart/form-data"> <!-- supaya form bisa mengelola type = "file", agar data string dikelola $_POST dan file dikelola $_FILES (gambar/files sudah tidak dikelola lagi oleh $_POST tapi diambil alih oleh $_FILES)-->
              <table>
                <tr>
                  <td><label for="nama">Nama</label></td>
                  <td> : <input id="nama" type="text" name="nama" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="nik">NIK</label></td>
                  <td> : <input id="nik" type="text" name="nik" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="no-hp">No. HP</label></td>
                  <td> : <input id="no-hp" type="text" name="no-hp" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="foto-profil">Foto Profil</label></td>
                  <td> : <input style="padding-left: 0;" id="foto-profil" type="file" name="foto-profil" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="password">Password</label></td>
                  <td> : <input id="password" type="password" name="password" required></td>
                </tr>
                <tr>
                  <td><label for="konfirmasiPassword">Konfirmasi Password</label></td>
                  <td> : <input id="konfirmasiPassword" type="password" name="konfirmasiPassword" required></td>
                </tr>
                <tr>
                  <td colspan="2" style="padding-top: 20px;"><button button type="submit" name="register" class="tombol-login2">Daftar Sekarang!</button></td>
                </tr>
              </table>        
                
            </form>
            
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
