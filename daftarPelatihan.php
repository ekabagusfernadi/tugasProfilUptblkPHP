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

  // ambil tabel program_pelatihan
  $queryAmbilProgPel = "SELECT * FROM program_pelatihan";
  $objekAmbilProgPel = mysqli_query($conn, $queryAmbilProgPel);
  $progPels = [];
  while( $progPel = mysqli_fetch_assoc($objekAmbilProgPel) ) {
    $progPels[] = $progPel;
  }

  if ( isset($_POST["submit"]) ) { 

    // ambil data dari tiap elemen dalam form
    $programPelatihan = htmlspecialchars($_POST["programPelatihan"]);   
    $namaPeserta = htmlspecialchars($_POST["namaPeserta"]);   
    $alamatPeserta = htmlspecialchars($_POST["alamatPeserta"]);   
    $usiaPeserta = htmlspecialchars($_POST["usiaPeserta"]);   
    $pendidikanTerakhir = htmlspecialchars($_POST["pendidikanTerakhir"]);   
    $ktp = upload("ktp");   
    $ijasah = upload("ijasah");

    if ($ijasah === false || $ktp === false) {
      exit;
    }

    $ktpBaru = $ktp[1];
    $ijasahBaru = $ijasah[1];

    // query insert data
    $query =    "INSERT INTO pendaftaran_pelatihan(id_program_pelatihan, nama_peserta, alamat_peserta, usia_peserta, pendidikan_terakhir, ktp, ijasah, id_user)
                VALUES
                ('$programPelatihan', '$namaPeserta', '$alamatPeserta', '$usiaPeserta', '$pendidikanTerakhir', '$ktpBaru', '$ijasahBaru', '$id_user')
                "; // kalau pakai petik 2 ("") error hati2
    mysqli_query ($conn, $query);

      // cek apakah data berhasil ditambahkan atau tidak
    //var_dump(mysqli_affected_rows($conn)); // jika berhasil (data rows bertambah) return 1 jika error -1

    // cek apakah data berhasil ditambahkan atau tidak
    if (mysqli_affected_rows($conn) > 0) {
        move_uploaded_file($ktp[0], "img/dokumenUser/ktp/" . $ktp[1]); // copy file yang di pilih beserta namanya ke server tempat penyimpanan gambar
        move_uploaded_file($ijasah[0], "img/dokumenUser/ijasah/" . $ijasah[1]);

        echo    "
                    <script>
                        alert('Data Berhasil Ditambahkan');
                        document.location.href = 'index.php';
                    </script>
                ";
    } else {
        echo    "
                    <script>
                        alert('Data Gagal Ditambahkan');
                    </script>
                ";
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
  <body id="home">
    <!-- navbar -->
    <nav id="navbar">
      <div class="topnav">
        <div class="wadah-header"><img src="img/Logo-jatim.png" alt="logo-upt" />
        <span class="nama-logo">UPT BLK Surabaya</span></div>
        <div class="float-right">
          <a href="index.php">&#9750; HOME</a>
          <a href="#daftar-pelatihan">DAFTAR PELATIHAN</a>
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
          <h1>DAFTAR PELATIHAN</h1>
          <p>Berikut ini adalah halaman yang digunakan untuk daftar program pelatihan.</p>
        </div>
        <div class="pendaftaran-content">
          <div class="daftar-pelatihan-content">
            
            <form action="" method="post" enctype="multipart/form-data"> <!-- supaya form bisa mengelola type = "file", agar data string dikelola $_POST dan file dikelola $_FILES (gambar/files sudah tidak dikelola lagi oleh $_POST tapi diambil alih oleh $_FILES)-->
              <table>
                <tr>
                  <td><label for="programPelatihan">Program Pelatihan</label></td>
                  <td> : 
                    <select name="programPelatihan" id="programPelatihan" required>
                      <option value="" disabled selected>Pilih Program Pelatihan</option>
                      <?php foreach( $progPels as $prog ) : ?>
                        <option value="<?= $prog["id_program_pelatihan"]; ?>"><?= $prog["nama_pelatihan"]; ?></option>
                      <?php endforeach; ?>
                  
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="namaPeserta">Nama Peserta</label></td>
                  <td> : <input type="text" name="namaPeserta" id="namaPeserta" autocomplete="off" required value="<?= $_SESSION["nama"]; ?>"></td>
                </tr>
                <tr>
                  <td><label for="alamatPeserta">Alamat Peserta</label></td>
                  <td> : <input type="text" name="alamatPeserta" id="alamatPeserta" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="usiaPeserta">Usia Peserta</label></td>
                  <td> : <input type="text" name="usiaPeserta" id="usiaPeserta" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="pendidikanTerakhir">Pendidikan Terakhir</label></td>
                  <td> : <input type="text" name="pendidikanTerakhir" id="pendidikanTerakhir" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td><label for="ijasah">Ijasah</label></td>
                  <td> : <input type="file" name="ijasah" id="ijasah" autocomplete="off" required ></td>
                </tr>
                <tr>
                  <td><label for="ktp">KTP</label></td>
                  <td> : <input type="file" name="ktp" id="ktp" autocomplete="off" required></td>
                </tr>
                <tr>
                  <td colspan="2" style="padding-top: 20px;"><button button type="submit" name="submit" class="tombol-login2">Daftar Sekarang!</button></td>
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
