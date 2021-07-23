<?php
  session_start();
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
        $_SESSION["nama"] = $row["nama_user"];
        $_SESSION["id_user"] = $row["id_user"];
    }
}
  
  // ambil tabel kategori_pelatihan
  $queryAmbilKatPel = "SELECT * FROM kategori_pelatihan";
  $objekAmbilKatPel = mysqli_query($conn, $queryAmbilKatPel);
  $katPels = [];
  while( $katPel = mysqli_fetch_assoc($objekAmbilKatPel) ) {
    $katPels[] = $katPel;
  }

  // ambil tabel program_pelatihan
  $queryAmbilProgPel1 = "SELECT * FROM program_pelatihan WHERE id_kategori = 1";
  $objekAmbilProgPel1 = mysqli_query($conn, $queryAmbilProgPel1);
  $progPels = [];
  while( $progPel = mysqli_fetch_assoc($objekAmbilProgPel1) ) {
    $progPels[] = $progPel;
  }

  if( isset($_SESSION["login"]) ) {
    // ambil pendaftaran_pelatihan
    $idUser = $_SESSION["id_user"];
    $queryAmbilPendaftaran = "SELECT * FROM pendaftaran_pelatihan WHERE id_user = '$idUser'";
    $objekAmbilPendaftaran = mysqli_query($conn, $queryAmbilPendaftaran);
    if( mysqli_num_rows($objekAmbilPendaftaran) > 0 ) {
      $_SESSION["pendaftaranPelatihan"] = true;
    } else {
      $_SESSION["pendaftaranPelatihan"] = false;
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
          <a href="#profil">PROFIL</a>
          <a href="#visi-misi">VISI MISI</a>
          <a href="#program-pelatihan">PROGRAM PELATIHAN</a>
          <a href="#pendaftaran-pelatihan">PENDAFTARAN</a>
          <a href="#hubungi-kami">HUBUNGI KAMI</a>
          <?php if( isset($_SESSION["status"]) ) : ?>
            <?php if( $_SESSION["status"] == 1 ) : ?>
              <a href="halamanAdmin.php" style="color: salmon;">HALAMAN ADMIN</a>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ( !isset($_SESSION["login"]) ) : ?>
            <a href="login.php" id="tombol-login" class="tombol-login">LOGIN</a>
          <?php else : ?>
            <a href="logout.php" id="tombol-login" class="tombol-login">LOGOUT</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
    <!-- akhir navbar -->

    <!-- jumbotron -->
    <section id="jumbotron" class="jumbotron jumbotron-fluid">
      <div class="container">
        <p class="jumbotron-p1">Menjadi <span>Tenaga Kerja</span> yang <span>Kompeten</span> dan <span>Profesional</span></p>
        <p class="jumbotron-p2">Melalui <span>Pelatihan</span> Berbasis Kompetensi <span>( PBK )</span></p>
        <?php if( isset($_SESSION["nama"]) ) : ?>
          <p class="jumbotron-p1" style="margin-top: 30px;">Selamat Datang <span><?= strtoupper($_SESSION["nama"]); ?></span></p>
        <?php endif; ?>
        <?php if( isset($_SESSION["pendaftaranPelatihan"]) ) : ?>
          <?php if( $_SESSION["pendaftaranPelatihan"] === true ) : ?>
            <div class="wadah-tombol-pendaftaran"><a href="cetakBuktiPendaftaran.php?id_user=<?= $idUser; ?>" target="_blank"><button class="tombol">BUKTI PENDAFTARAN</button></a></div>
          <?php endif; ?>
        <?php endif; ?>
        <div class="wadah-tombol-pendaftaran"><a href="#pendaftaran-pelatihan"><button class="tombol">PENDAFTARAN PELATIHAN</button></a></div>
      </div>
    </section>
    <!-- akhir jumbotron -->

    <!-- program pelatihan -->
    <section id="program-pelatihan">
      <div class="container">
        <h3>Program Pelatihan</h3>
        <p>Guna menunjang kebutuhan tenaga kerja sesuai dengan kebutuhan pasar/dunia industri, BLK Surabaya menyelenggarakan program/paket pendidikan dan pelatihan meliputi :</p>
        <div class="nama-pelatihan">
          <div class="nama-pelatihan-wadahkiri">
            <?php for( $i = 0; $i < 4; $i++ ) : ?>
              <a href="<?= $katPels[$i]["nama_kategori"]; ?>"><?= $katPels[$i]["nama_kategori"]; ?></a>
            <?php endfor; ?>
          </div>
          <div class="nama-pelatihan-wadahkanan">
            <?php for( $i = 4; $i < 8; $i++ ) : ?>
              <a href="<?= $katPels[$i]["nama_kategori"]; ?>"><?= $katPels[$i]["nama_kategori"]; ?></a>
            <?php endfor; ?>
          </div>
        </div>
  
        <hr color="#dedede" />

        <div id="konten-pelatihan">
            <h3>OTOMOTIF</h3>
            <?php foreach( $progPels as $prog ) : ?>
              <div class="cart-pelatihan">
              <div class="wadah-gambar-propel">
                <img src="img/programPelatihan/<?= $prog["gambar_1"]; ?>"/>
              </div>
              <h4><?= $prog["nama_pelatihan"]; ?></h4>
              <p>&#9716; <?= $prog["total_jam"]; ?> Jam Pelatihan</p>
              <p><?= $prog["deskripsi"]; ?></p>
              <a href="detailPelatihan.php?id_pelatihan=<?= $prog['id_program_pelatihan']; ?>" class="tombol-program-pelatihan">Baca Lebih Detil</a>
              </div>
            <?php endforeach; ?>
            
            <div class="clear"></div>
        </div>

        </div>
      </div>
    </section>
    <!-- akhir program pelatihan -->

    <!-- profil -->
    <section id="profil">
        <div class="container">
            <div class="judul-profil">
              <h1>Profil UPT BLK Surabaya</h1>
            </div>
            <div class="content-profil">
            <div class="profil-kiri">
              <div id="slider-profil">
                <figure>
                  <img src="img/foto blk sby/FOTO PELATIHAN/IMG_0381.JPG" alt="gambar-slide-1" />
                  <img src="img/foto blk sby/FOTO PELATIHAN/file202.jpg" alt="gambar-slide-2" />
                  <img src="img/foto blk sby/FOTO PELATIHAN/IMG_1386.JPG" alt="gambar-slide-3" />
                  <img src="img/foto blk sby/FOTO PELATIHAN/IMG_7567.JPG" alt="gambar-slide-4" />
                  <img src="img/foto blk sby/FOTO PELATIHAN/IMG_7244.JPG" alt="gambar-slide-5" />
                </figure>
              </div>
            </div>
            <div class="profil-kanan">
                <p>
                    Balai Latihan Kerja (BLK) Surabaya dibangun pada tahun 1979 dengan dana bantuan dari Bank Dunia (World Bank) dan diresmikan oleh Menteri Tenaga Kerja Republik Indonesia (Dr. Harun Zein) pada 19 Maret 1980 dengan dengan luas area keseluruhan 48.470 m2.
                </p>
                <p>
                    Melalui berbagai pelatihan berbasis kompetensi yang telah diselenggarakan selama lebih dari 30 tahun, BLK Surabaya telah mencetak ribuan tenaga kerja terampil dan ahli yang bekerja di perusahaan-perusahaan nasional maupun multinasional.
                </p>
                <p>
                    Pada masa sekarang dan mendatang, kualitas sumber daya manusia menjadi sangat penting mengingat persaingan tenaga kerja secara global yang semakin ketat. Kontribusi BLK Surabaya sebagai lembaga pelatihan milik pemerintah dalam menghadapi tantangan saat ini adalah dengan meningkatkan daya saing tenaga kerja Indonesia melalui pelatihan berbasis kompetensi, uji kompetensi serta sertifikasi keahlian. Untuk menyelenggarakan uji kompetensi, BLK Surabaya bekerja sama dengan Lembaga Sertifikasi Profesi (LSP), Badan Nasional Sertifikasi Profesi (BNSP).
                </p>
                <p>
                    Untuk membantu penyerapan lulusan oleh dunia kerja, BLK Surabaya menyediakan layanan Kios 3in1, yaitu bentuk pelayanan untuk mengakses lowongan pekerjaan secara online dan Bursa Kerja Khusus (BKK) yang dapat dimanfaatkan oleh lulusan maupun perusahaan yang membutuhkan tenaga kerja. Pada tanggal 24 Desember 2010 lembaga pelatihan ini berhasil mendapatkan sertifikasi ISO 9001 : 2008 yang merupakan bukti pengakuan keberhasilan di bidang Manajemen Mutu.
                </p>
                
            </div>
          </div>
        </div>
    </section>
    <!-- akhir profil -->

    <!-- visi misi -->
    <section id="visi-misi">
      <div class="bg-visi-misi">
        <img src="img/bg6.png" alt="bg-nich">
      </div>
      <div class="container">
        <div class="visi">
          <div class="visi-img">
            <img src="img/icon/visi.png" alt="visi-nich">
          </div>
          <h1>
            VISI
          </h1>
          <p>
            Mewujudkan UPT Pelatihan Kerja Surabaya sebagai Lembaga Pelatihan bertaraf Internasional yang Unggul dan Profesional.
          </p>
        </div>
        <div class="misi">
          <div class="misi-img">
            <img src="img/icon/misi.png" alt="misi-nich">
          </div>
          <h1>
            MISI
          </h1>
          <ol>
            <li>Pelatihan Tenaga Kerja dan Pencari Kerja</li>
            <li>Menyelenggarakan Pengembangan Sumber Daya Pelatihan</li>
            <li>Menyelenggarakan Pelayanan Jasa Produksi dan Konsultasi</li>
            <li>Melaksanakan Pelayanan Prima pada Masyarakat</li>
            <li>Melaksanakan Uji Kompetensi (UJK) dan Sertifikasi</li>
          </ol>
        </div>
        <div class="strategi">
          <div class="strategi-img">
            <img src="img/icon/strategi.png" alt="strategi-nich">
          </div>
          <h1>
            STRATEGI
          </h1>
          <ol>
            <li>Meningkatkan Kualitas dan Kuantitas Sumber Daya Instruktur</li>
            <li>Menyiapkan sarana dan prasarana Pelatihan</li>
            <li>Menjalin Kerjasama dengan Instansi Pemerintah dan Swasta</li>
            <li>Meningkatkan promosi Pelatihan Jasa Produksi dan Konsultasi</li>
            <li>Mengembangkan Methodologi dan Kurikulum Pelatihan Berbasis Kompetensi (CBT)</li>
            <li>Mengoptimalkan Program 3 in 1 (Pelatihan, Sertifikasi dan Penempatan) Tenaga Kerja</li>
            <li>Melayani Program Pelatihan sesuai dengan kebutuhan Pasar Kerja (Training Need Analysis)</li>
          </ol>
        </div>
        <div class="clear"></div>
      </div>
    </section>
    <!-- akhir visi misi -->

    <!-- pendaftaran pelatihan -->
    <section id="pendaftaran-pelatihan">
      <div class="container">
        <div class="pendaftaran-judul">
          <h1>PENDAFTARAN PELATIHAN</h1>
          <p>Berikut ini persyaratan peserta, berkas pendaftaran yang harus Anda lengkapi dan alur untuk melakukan pendaftaran pelatihan.</p>
        </div>
        <div class="pendaftaran-content">
          <div class="pendaftaran-content-kiri">
            <div class="persyaratan-peserta">
              <h3>Persyaratan Peserta</h3>
              <p>Berikut ini persyaratan untuk mendaftar sebagai peserta pelatihan.</p>
              <ul type="circle">
                <li>Usia minimal 17 tahun</li>
                <li>Usia maksimal 35 tahun</li>
              </ul>
            </div>

            <div class="berkas-pendaftaran">
              <h3>Berkas Pendaftaran</h3>
              <p>Berikut ini berkas pendaftaran yang harus Anda siapkan untuk mendaftar sebagai peserta pelatihan.</p>
              <ul type="circle">
                <li>Fotokopi Ijazah Terakhir atau Surat Keterangan Lulus (SKL).<sub> (1 lembar)</sub>.</li>
                <li>Fotokopi Kartu Tanda Penduduk (KTP) atau Kartu Susunan Keluarga (KSK).<sub> (1 lembar)</sub></li>
                <li>Foto Berwarna ukuran 3 x 4 cm.<sub> (2 lembar)</sub></li>
              </ul>
            </div>
          </div>
          <div class="pendaftaran-content-kanan">
            <div class="alur-pendaftaran-offline">
              <h3>Alur Pendaftaran Offline</h3>
              <ol>
                <li>Semua berkas pendaftaran tersebut dimasukkan kedalam stopmap.</li>
                <li>Berkas pendaftaran diantarkan sendiri ke <span>Kantor UPT Balai Latihan Kerja Surabaya, Jl. Dukuh Menanggal III/29, Surabaya</span> di ruang pendaftaran (Kios 3in1, hari Senin - Jumat jam 07.30 - 15.00.</li>
              </ol>
            </div>
            <div class="alur-pendaftaran-online">
              <h3>Alur Pendaftaran Online</h3>
              <ol>
                <li>Berkas pendaftaran discan dalam bentuk <span>jpg</span> atau <span>png</span> dengan ukuran :
                  <ul type="circle">
                    <li>File ijazah/SKL dan KTP/KSK masing-masing tidak lebih dari <span>400 kb</span>.</li>
                    <li>File foto tidak lebih dari <span>200 kb</span>.</li>
                  </ul>
                </li>
                <li>Mengisi formulir pendaftaran online dengan mengklik tombol di bawah ini.</li>
              </ol>
              <a href="daftarPelatihan.php" class="tombol-pendaftaran-online">FORMULIR PENDAFTARAN ONLINE</a>
            </div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </section>
    <!-- akhir pendaftaran pelatihan -->

    <!-- hubungi kami -->
    <section id="hubungi-kami">
      <div class="bg-hubungi-kami">
        <img src="img/bg1.png" alt="bg-nich">
      </div>
      <div class="container">
        <div class="hubungi-kami-judul">
          <h1>HUBUNGI KAMI</h1>
          <h3>UPT Balai Latihan Kerja Surabaya</h3>
          <h4>Jl. Dukuh Menanggal III / 29 Gayungan Surabaya</h4>
        </div>
        <div class="hubungi-kami-content">
          <div class="hubungi-kami-content-kiri">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4705.813543920622!2d112.72267024818022!3d-7.342470966684353!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbc5331fa9fd366bd!2sUPT.%20Pelatihan%20Kerja%20Surabaya!5e0!3m2!1sen!2sid!4v1619943369846!5m2!1sen!2sid" width="100%" height="100%" allowfullscreen="" loading="lazy"></iframe>
          </div>
          <div class="hubungi-kami-content-kanan">
            <div class="alamat">
              <img src="img/icon/adress.png" alt="alamat-nich">
              <h3>Alamat</h3>
              <p>Jl. Dukuh Menanggal III/29<br>Gayungan Surabaya</p>
            </div>
            <div class="no-tlp">
              <img src="img/icon/call.png" alt="no-tlp-nich">
              <h3>Telepon</h3>
              <p>031 - 8290071 ext. 103<br>Senin - Jumat jam 07.30 - 15.00.</p>
            </div>
            <div class="email">
              <img src="img/icon/email.png" alt="email-nich">
              <h3>Email</h3>
              <p>uptpelatihankerjasurabaya<br>@yahoo.co.id</p>
            </div>
            <div class="facebook">
              <img src="img/icon/facebook.png" alt="facebook-nich">
              <h3>Facebook</h3>
              <p>UPT Pelatihan Kerja /<br>BLK Surabaya</p>
            </div>
            <div class="instagram">
              <img src="img/icon/instagram.png" alt="instagram-nich">
              <h3>Instagram</h3>
              <p>@uptblksurabaya</p>
            </div>
            <div class="clear"></div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </section>
    <!-- akhir hubungi kami -->

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
