<?php
  session_start();
  require "config.php";
  require "function.php";

  $idUser = $_GET["id_user"];

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

  $queryAmbilDataUser = "SELECT * FROM user WHERE id_user = '$idUser'";
  $objekAmbilDataUser = mysqli_query($conn, $queryAmbilDataUser);
  $dataUser = mysqli_fetch_assoc($objekAmbilDataUser);


  if( isset($_POST["register"]) ) {
    $nama = htmlspecialchars($_POST["nama"]);    
    $nik = htmlspecialchars($_POST["nik"]);
    $noHp = htmlspecialchars($_POST["no-hp"]);
    $fotoProfilLama = htmlspecialchars($_POST["foto-profil-lama"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT * FROM user WHERE (nik = '$nik' OR no_hp = '$noHp') AND id_user != '$idUser'");

    if( mysqli_fetch_assoc($result) ) { // jika menghasilkan nilia true ($result bisa di fetch)
        echo    "
                    <script>
                        alert('username sudah terdaftar');
                        document.location.href = '';
                    </script>
                ";

        exit;
    }

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES["foto-profil"]["error"] === 4) { // tidak upload gambar
        $fotoProfilBaru = $fotoProfilLama;
        $upload = false;
    } else {
        // cek foto profil
        $fotoProfil = upload("foto-profil");
        if ($fotoProfil === false) {
        exit;
        }
        $fotoProfilBaru = $fotoProfil[1];
    }

    // update user ke database
    $queryUpdateUser = "UPDATE user SET
        nama_user = '$nama',
        nik = '$nik',
        no_hp = '$noHp',
        foto_user = '$fotoProfilBaru'
    WHERE id_user = '$idUser'";
    mysqli_query($conn, $queryUpdateUser);

    if( mysqli_affected_rows($conn) > 0 ) {
        if( !isset($upload) ) {
            // hapus foto profil difolder direktori
                // $fotoProfilAnyar = $PendaftaranPel['foto-profil'];
                $fotoProfilss    =glob("img/dokumenUser/foto/$fotoProfilLama");
                foreach ($fotoProfilss as $fotoProfils) {
                    if (is_file($fotoProfils))
                    unlink($fotoProfils); // hapus file
                }
            move_uploaded_file($fotoProfil[0], "img/dokumenUser/foto/" . $fotoProfil[1]);
            
            } else {
                echo mysqli_error($conn);
            }
        }

        echo    "
                            <script>
                                alert('Data User Berhasil di Edit');
                                document.location.href = 'halamanAdminDataUser.php';
                            </script>
                        ";
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EDIT Data User</title>
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
          <a href="#daftar-pelatihan">EDIT DATA USER</a>
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
          <h1>Edit Data User</h1>
          <p>Berikut ini adalah halaman yang digunakan admin untuk mengubah informasi pada akun user.</p>
        </div>
        <div class="pendaftaran-content">
          <div class="daftar-pelatihan-content">
            
            <form action="" method="post" enctype="multipart/form-data"> <!-- supaya form bisa mengelola type = "file", agar data string dikelola $_POST dan file dikelola $_FILES (gambar/files sudah tidak dikelola lagi oleh $_POST tapi diambil alih oleh $_FILES)-->
              <table>
                <tr>
                  <td><label for="nama">Nama</label></td>
                  <td> : <input id="nama" type="text" name="nama" value="<?= $dataUser["nama_user"]; ?>" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="nik">NIK</label></td>
                  <td> : <input id="nik" type="text" name="nik" value="<?= $dataUser["nik"]; ?>" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="no-hp">No. HP</label></td>
                  <td> : <input id="no-hp" type="text" name="no-hp" value="<?= $dataUser["no_hp"]; ?>" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="foto-profil">Foto Profil</label></td>
                  <input type="hidden" name="foto-profil-lama" value="<?= $dataUser["foto_user"]; ?>">
                  <td> : <img src="img/dokumenUser/foto/<?= $dataUser["foto_user"]; ?>" class="gambar-dokumen"> <br> <input id="foto-profil" type="file" name="foto-profil" autocomplete="off"></td>
                </tr>
                  <td colspan="2" style="padding-top: 20px;"><button button type="submit" name="register" class="tombol-login2">Ubah Data!</button></td>
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
