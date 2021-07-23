<?php
    require "config.php";

    $idUser = $_GET["id_user"];
    $queryAmbilCetak = "SELECT id_pendaftaran_pelatihan, pendaftaran_pelatihan.id_program_pelatihan, pendaftaran_pelatihan.nama_peserta, alamat_peserta, usia_peserta, pendidikan_terakhir, pendaftaran_pelatihan. id_user, foto_user, nama_pelatihan
    FROM pendaftaran_pelatihan
    JOIN user ON(pendaftaran_pelatihan.id_user = user.id_user)
    JOIN program_pelatihan ON(pendaftaran_pelatihan.id_program_pelatihan = program_pelatihan.id_program_pelatihan)
    WHERE pendaftaran_pelatihan.id_user = '$idUser'";
    $objekAmbilCetak = mysqli_query($conn, $queryAmbilCetak);
    $dataCetak = mysqli_fetch_assoc($objekAmbilCetak);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Bukti Pendaftaran</title>
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="favicon.png">
    <style>
        body {
            opacity: 0;
        }
        @media print {
            body {
                opacity: 1;
                /* display: block; */
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif !important;
                color: #9a9a9a !important;
            }
            .wadah-header {
                /* width: 100px !important; */
                float: none !important;
                width: fit-content !important;
                padding: 0 !important;
                margin-left: 140px !important;
                margin-bottom: 70px !important;
                
                
            }
            #bukti-pendaftaran {
                margin-top: 40px !important;
            }
            #bukti-pendaftaran h2,
            #bukti-pendaftaran p {
                text-align: center !important;
            }
            #bukti-pendaftaran h2 {
                font-weight: 500 !important;
                margin-bottom: 10px !important;
            }
            .pendaftaran-content img {
                margin-top: 20px !important;
                margin-bottom: 20px;
                width: 130px !important;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5) !important;
            }
            table tr td {
                border: 1px solid #9a9a9a;
                padding: 10px;
            }
            table {
                margin-bottom: 50px;
            }
        }
    </style>
</head>
<body>
    <!-- navbar -->
    <nav id="navbar">
      <div class="topnav">
        <div class="wadah-header">
            <img src="img/Logo-jatim.png" alt="logo-upt" />
            <span class="nama-logo">UPT BLK Surabaya</span>
        </div>
      </div>
    </nav>
    <hr color="silver">
    <!-- akhir navbar -->

    <!-- konten -->
    <section id="bukti-pendaftaran">
      <div class="container">
        <div id="judul-bukti-pendaftaran">
          <h2>BUKTI PENDAFTARAN PELATIHAN</h2>
          <p>Berikut ini adalah bukti dan informasi secara sah dari pendaftaran pelatihan.</p>
        </div>
        <div class="pendaftaran-content">
            <center>
                <img src="img/dokumenUser/foto/<?= $dataCetak['foto_user']; ?>">
            
            <table>
                <tr>
                    <td>Nama Peserta</td>
                    <td> <?= $dataCetak['nama_peserta']; ?></td>
                </tr>
                <tr>
                    <td>Alamat Peserta</td>
                    <td> <?= $dataCetak['alamat_peserta']; ?></td>
                </tr>
                <tr>
                    <td>Usia Peserta</td>
                    <td> <?= $dataCetak['usia_peserta']; ?></td>
                </tr>
                <tr>
                    <td>Pendidikan Terakhir</td>
                    <td> <?= $dataCetak['pendidikan_terakhir']; ?></td>
                </tr>
                <tr>
                    <td>Program Pelatihan</td>
                    <td> <?= $dataCetak['nama_pelatihan']; ?></td>
                </tr>
            </table>
            
            <h2>KELENGKAPAN BERKAS</h2>
            </center>
            <ul>Berikut ini adalah berkas-berkas yang wajib dibawa saat melakukan tes interview di Unit Pelatihan Kerja Surabaya.</ul>
            <br>
            <ul type="circle">
                <li>1. Fotokopi Ijazah Terakhir atau Surat Keterangan Lulus (SKL).<sub> (1 lembar)</sub>.</li>
                <li>2. Fotokopi Kartu Tanda Penduduk (KTP) atau Kartu Susunan Keluarga (KSK).<sub> (1 lembar)</sub></li>
                <li>3. Foto Berwarna ukuran 3 x 4 cm.<sub> (2 lembar)</sub></li>
            </ul>
   
        </div>
      </div>
    </section>    
    <!-- akhir konten -->
    <script>
        window.print();
    </script>
</body>
</html>