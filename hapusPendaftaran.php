<?php
    require "config.php";
    $idPendaftaran = $_GET["id_pendaftaran"];

    $queryAmbilIjasahKtp = "SELECT ijasah, ktp FROM pendaftaran_pelatihan WHERE id_pendaftaran_pelatihan = '$idPendaftaran'";
    $objekAmbilIjasahKtp = mysqli_query($conn, $queryAmbilIjasahKtp);
    $ijasahKtp = mysqli_fetch_assoc($objekAmbilIjasahKtp);
    $ijasah = $ijasahKtp['ijasah'];
    $ktp = $ijasahKtp['ktp'];

    // hapus gambar ijasah & ktp difolder direktori
    $ijasahs    =glob("img/dokumenUser/ijasah/$ijasah");
    foreach ($ijasahs as $ijasah) {
        if (is_file($ijasah))
        unlink($ijasah); // hapus file
    }

    $ktps    =glob("img/dokumenUser/ktp/$ktp");
    foreach ($ktps as $ktp) {
        if (is_file($ktp))
        unlink($ktp); // hapus file
    }

    $query = "DELETE FROM pendaftaran_pelatihan WHERE id_pendaftaran_pelatihan = '$idPendaftaran'";
    mysqli_query($conn, $query);

    if( mysqli_affected_rows($conn) > 0 ) {
        echo    "<script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'halamanAdmin.php';
            </script>";
    } else {
        echo    "<script>
                alert('Data Gagal Dihapus');
                document.location.href = 'halamanAdmin.php';
            </script>";
    }
    
    
?>