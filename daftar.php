<?php
    session_start();
    require "config.php";
    require "function.php";

    // cek cookie
    if( isset($_COOKIE["id"]) && isset($_COOKIE["key"]) ) {
      $id = $_COOKIE["id"];
      $key = $_COOKIE["key"];

      // ambil username berdasarkan id
      $result = mysqli_query($conn, "SELECT nik FROM user WHERE id_user = $id");
      $row = mysqli_fetch_assoc($result);

      // cek cookie dan username
      if( $key === hash("sha256", $row["nik"]) ) {
          $_SESSION["login"] = true;
      }
    }

    if ( isset($_SESSION["login"]) ) {
        header("Location: index.php");
        exit;
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
                          document.location.href = 'daftar.php';
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
                          document.location.href = 'daftar.php';
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
                          document.location.href = 'login.php';
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
    <title>UPT BLK Surabaya</title>
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
            <a href="login.php" id="tombol-login" class="tombol-login">LOGIN</a>
        </div>
      </div>
    </nav>
    <!-- akhir navbar -->

    <!-- jumbotron -->
    <section id="jumbotron" class="jumbotron jumbotron-fluid" style="height: 0px; filter: grayscale(100%);">
       
    </section>
    <hr color="#dedede">
    <!-- akhir jumbotron -->

    <!-- login -->
    <section id="login" class="overlay">

      <div class="container">
        
        <div class="kotak-login">
          <p class="tulisan-login">Daftar</p>
          <?php if( isset($error) ) : ?>
            <p style="color: red; font-style: italic;">username / password salah</p>
          <?php endif ?>
       
          <form action="" method="post" enctype="multipart/form-data">
            <label for="nama">Nama</label>
            <input id="nama" type="text" name="nama" class="form-login" autocomplete="off" placeholder="Nama .." required>
            
            <label for="nik">NIK</label>
            <input id="nik" type="text" name="nik" class="form-login" autocomplete="off" placeholder="NIK .." required>

            <label for="no-hp">No. HP</label>
            <input id="no-hp" type="text" name="no-hp" class="form-login" autocomplete="off" placeholder="No. HP .." required>
            
            <label for="foto-profil">Foto Profil</label>
            <input style="padding-left: 0;" id="foto-profil" type="file" name="foto-profil" autocomplete="off" required>
       
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-login" placeholder="Password .." required>

            <label for="konfirmasiPassword">Konfirmasi Password</label>
            <input id="konfirmasiPassword" type="password" name="konfirmasiPassword" class="form-login" placeholder="Konfirmasi Password .." required>

            <a class="link" href="login.php" style="display: block;">Sudah punya akun?</a>

            <input type="submit" name="register" class="tombol-login2" value="DAFTAR">
       
            <center>
              <a class="link" href="login.php">Kembali</a>
            </center>
          </form>
          
        </div>

      </div>
    </section>
    <!-- akhir login -->

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
