<?php
  session_start();
  require "config.php";
  require "function.php";

  $idPendaftaran = $_GET["id_pendaftaran"];
  $idProgram = $_GET["id_program"];

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
  $queryAmbilProgPel = "SELECT * FROM program_pelatihan WHERE id_program_pelatihan != '$idProgram'";
  $objekAmbilProgPel = mysqli_query($conn, $queryAmbilProgPel);
  $progPels = [];
  while( $progPel = mysqli_fetch_assoc($objekAmbilProgPel) ) {
    $progPels[] = $progPel;
  }

  // ambil tabel user
  $queryAmbilUser = "SELECT id_user, nama_user FROM user WHERE id_user NOT IN (SELECT id_user FROM pendaftaran_pelatihan) AND status = 0";
  $objekAmbilUser = mysqli_query($conn, $queryAmbilUser);
  $users = [];
  while( $user = mysqli_fetch_assoc($objekAmbilUser) ) {
    $users[] = $user;
  }

  // ambil tabel pendaftaran pelatihan
  $queryAmbilPendaftaranPel = "SELECT id_pendaftaran_pelatihan, pendaftaran_pelatihan.id_program_pelatihan, nama_peserta, alamat_peserta, usia_peserta, pendidikan_terakhir, ktp, ijasah, id_user, nama_pelatihan
  FROM pendaftaran_pelatihan
  JOIN program_pelatihan ON(pendaftaran_pelatihan.id_program_pelatihan = program_pelatihan.id_program_pelatihan)
  WHERE id_pendaftaran_pelatihan = '$idPendaftaran'";
  $objekAmbilPendaftaranPel = mysqli_query($conn, $queryAmbilPendaftaranPel);
  
    $PendaftaranPel = mysqli_fetch_assoc($objekAmbilPendaftaranPel);

  if ( isset($_POST["submit"]) ) { 

    // ambil data dari tiap elemen dalam form
    $programPelatihan = htmlspecialchars($_POST["programPelatihan"]);   
    // $namaPeserta = htmlspecialchars($_POST["namaPeserta"]);   
    $alamatPeserta = htmlspecialchars($_POST["alamatPeserta"]);   
    $usiaPeserta = htmlspecialchars($_POST["usiaPeserta"]);   
    $pendidikanTerakhir = htmlspecialchars($_POST["pendidikanTerakhir"]);
    $id_user = htmlspecialchars($_POST["id-user"]);
    $ijasahLama = htmlspecialchars($_POST["ijasah-lama"]);
    $ktpLama = htmlspecialchars($_POST["ktp-lama"]);
    
    $queryAmbilNamaUser = "SELECT nama_user FROM user WHERE id_user = $id_user";
    $objekAmbilNamaUser = mysqli_query($conn, $queryAmbilNamaUser);
    $namaPeserta = mysqli_fetch_assoc($objekAmbilNamaUser)['nama_user'];
    
    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES["ijasah"]["error"] === 4) { // tidak upload gambar
        $ijasahBaru = $ijasahLama;
        $upload = false;
    } else {
        $ijasah = upload("ijasah");
        if ($ijasah == true){
            $ijasahBaru = $ijasah[1];
        } else {
            exit;
        }
    }

    if ($_FILES["ktp"]["error"] === 4) { // tidak upload gambar
        $ktpBaru = $ktpLama;
        $upload = false;
    } else {
        $ktp = upload("ktp");
        if ($ktp == true){
            $ktpBaru = $ktp[1];
        } else {
            exit;
        }
    }

    // query update data
    $queryUpdatePendaftaran =    "UPDATE pendaftaran_pelatihan SET
                    id_program_pelatihan = '$programPelatihan',
                    nama_peserta = '$namaPeserta',
                    alamat_peserta = '$alamatPeserta',
                    usia_peserta = '$usiaPeserta',
                    pendidikan_terakhir = '$pendidikanTerakhir',
                    ktp = '$ktpBaru',
                    ijasah = '$ijasahBaru',
                    id_user = '$id_user'
                WHERE id_pendaftaran_pelatihan = '$idPendaftaran'
                "; // kalau pakai petik 2 ("") error hati2
    mysqli_query ($conn, $queryUpdatePendaftaran);

      // cek apakah data berhasil ditambahkan atau tidak
    //var_dump(mysqli_affected_rows($conn)); // jika berhasil (data rows bertambah) return 1 jika error -1

    // cek apakah data berhasil ditambahkan atau tidak
    if (mysqli_affected_rows($conn) > 0) {
        if( !isset($upload) ) {

            // hapus gambar ijasah & ktp difolder direktori
            $ijasahAnyar = $PendaftaranPel['ijasah'];
            $ktpAnyar = $PendaftaranPel['ktp'];
            $ijasahss    =glob("img/dokumenUser/ijasah/$ijasahAnyar");
            foreach ($ijasahss as $ijasahs) {
                if (is_file($ijasahs))
                unlink($ijasahs); // hapus file
            }

            $ktpss    =glob("img/dokumenUser/ktp/$ktpAnyar");
            foreach ($ktpss as $ktps) {
                if (is_file($ktps))
                unlink($ktps); // hapus file
            }

            move_uploaded_file($ktp[0], "img/dokumenUser/ktp/" . $ktp[1]); // copy file yang di pilih beserta namanya ke server tempat penyimpanan gambar
            move_uploaded_file($ijasah[0], "img/dokumenUser/ijasah/" . $ijasah[1]);
        }

        echo    "
                    <script>
                        alert('Data Berhasil Diedit');
                        document.location.href = 'halamanAdmin.php';
                    </script>
                ";
    } else {
        echo    "
                    <script>
                        alert('Data Gagal Diedit');
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
    <title>Edit Pendaftaran</title>
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
          <a href="halamanAdmin.php">&#8592; KEMBALI</a>
          <a href="#daftar-pelatihan">EDIT PENDAFTARAN</a>
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
          <h1>Edit Pendaftaran</h1>
          <p>Berikut ini adalah halaman yang digunakan admin untuk melakukan perubahan pada data peserta pelatihan.</p>
        </div>
        <div class="pendaftaran-content">
          <div class="daftar-pelatihan-content">
            
            <form action="" method="post" enctype="multipart/form-data"> <!-- supaya form bisa mengelola type = "file", agar data string dikelola $_POST dan file dikelola $_FILES (gambar/files sudah tidak dikelola lagi oleh $_POST tapi diambil alih oleh $_FILES)-->
              <table>
                <tr>
                  <td><label for="programPelatihan">Program Pelatihan</label></td>
                  <td> : 
                    <select name="programPelatihan" id="programPelatihan" required>
                      <option value="<?= $PendaftaranPel['id_program_pelatihan']; ?>" selected><?= $PendaftaranPel['nama_pelatihan']; ?></option>
                      <?php foreach( $progPels as $prog ) : ?>
                        <option value="<?= $prog["id_program_pelatihan"]; ?>"><?= $prog["nama_pelatihan"]; ?></option>
                      <?php endforeach; ?>
                  
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="id-user">Peserta Pelatihan</label></td>
                  <td> : 
                    <select name="id-user" id="id-user" required>
                      <option value="<?= $PendaftaranPel['id_user']; ?>" selected><?= $PendaftaranPel['id_user']; ?> - <?= $PendaftaranPel['nama_peserta']; ?></option>
                      <?php foreach( $users as $us ) : ?>
                        <option value="<?= $us["id_user"]; ?>"><?= $us["id_user"]; ?> - <?= $us["nama_user"]; ?></option>
                      <?php endforeach; ?>
                  
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="alamatPeserta">Alamat Peserta</label></td>
                  <td> : <input type="text" name="alamatPeserta" id="alamatPeserta" autocomplete="off" value="<?= $PendaftaranPel['alamat_peserta']; ?>" required></td>
                </tr>
                <tr>
                  <td><label for="usiaPeserta">Usia Peserta</label></td>
                  <td> : <input type="text" name="usiaPeserta" id="usiaPeserta" autocomplete="off" value="<?= $PendaftaranPel['usia_peserta']; ?>" required></td>
                </tr>
                <tr>
                  <td><label for="pendidikanTerakhir">Pendidikan Terakhir</label></td>
                  <td> : <input type="text" name="pendidikanTerakhir" id="pendidikanTerakhir" autocomplete="off" value="<?= $PendaftaranPel['pendidikan_terakhir']; ?>" required></td>
                </tr>
                <tr>
                  <td><label for="ijasah">Ijasah</label></td>
                  <input type="hidden" name="ijasah-lama" value="<?= $PendaftaranPel["ijasah"]; ?>">
                  <td> : <img src="img/dokumenUser/ijasah/<?= $PendaftaranPel["ijasah"]; ?>" class="gambar-dokumen"> <br> <input type="file" name="ijasah" id="ijasah" autocomplete="off"></td>
                </tr>
                <tr>
                  <td><label for="ktp">KTP</label></td>
                  <input type="hidden" name="ktp-lama" value="<?= $PendaftaranPel["ktp"]; ?>">
                  <td> : <img src="img/dokumenUser/ktp/<?= $PendaftaranPel["ktp"]; ?>" class="gambar-dokumen"> <br> <input type="file" name="ktp" id="ktp" autocomplete="off"></td>
                </tr>
                <tr>
                  <td colspan="2" style="padding-top: 20px;"><button button type="submit" name="submit" class="tombol-login2">Edit Data!</button></td>
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
