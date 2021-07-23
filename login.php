<?php
    session_start();    // harus paling atas
    require "config.php";

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
      <?php
        if( isset($_POST["login"]) ) {
          
          $username = $_POST["username"];
          $password = $_POST["password"];

          $result = mysqli_query($conn, "SELECT * FROM user WHERE nik = '$username' OR no_hp = '$username'");
          
          // cek username
          if( mysqli_num_rows($result) === 1 ) {  // menghitung ada berapa baris yang dikembalikan dari fungsi select kalau ada = 1 kalau tidak ada = 0
              
              // cek password
              $row = mysqli_fetch_assoc($result);
              if( password_verify($password ,$row["password"])) {   // cek apakah string sama dengan password hashnya jika berhasil verify return = true

                  // set session
                  $_SESSION["login"] = true;
                  $_SESSION["nama"] = $row["nama_user"];
                  $_SESSION["id_user"] = $row["id_user"];
                  $_SESSION["status"] = $row["status"];

                  // cek remember me
                  if( isset($_POST["remember"]) ) {
                      // buat cookie

                      setcookie("id", $row["id_user"], time()+600);
                      setcookie("key", hash("sha256", $row["nik"]), time()+600);
                  }

                  echo      "<script>
                                alert('Berhasil Login!');
                                document.location.href = 'index.php';
                            </script>";
                //   header("Location: index.php");
                  exit;
              }
          }

          $error = true;

        }
      ?>
      <div class="container">
        
        <div class="kotak-login">
          <p class="tulisan-login">login</p>
          <?php if( isset($error) ) : ?>
            <center><p style="color: red; font-style: italic;" class="link">Username / Password Salah!</p></center>
          <?php endif ?>
       
          <form action="" method="post">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" class="form-login" autocomplete="off" placeholder="NIK atau No. HP .." required>
       
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-login" placeholder="Password .." required>

            <br>
            <input type="checkbox" name="remember" id="remember" style="display: inline;">
            <label for="remember" style="display: inline;">Remember me</label>

            <a class="link" href="daftar.php" style="display: block;">Belum punya akun?</a>

            <input type="submit" name="login" class="tombol-login2" value="LOGIN">
       
            <center>
              <a class="link" href="index.php">Kembali</a>
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
