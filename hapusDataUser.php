<?php
    require "config.php";
    $idUser = $_GET["id_user"];

    $queryAmbilIjasahKtp = "SELECT ijasah, ktp, foto_user FROM pendaftaran_pelatihan
    RIGHT JOIN user ON(pendaftaran_pelatihan.id_user = user.id_user)
    WHERE user.id_user = '$idUser'";
    $objekAmbilIjasahKtp = mysqli_query($conn, $queryAmbilIjasahKtp);
    $ijasahKtp = mysqli_fetch_assoc($objekAmbilIjasahKtp);
    $ijasah = $ijasahKtp['ijasah'];
    $ktp = $ijasahKtp['ktp'];
    $fotoUser = $ijasahKtp['foto_user'];

    // hapus gambar ijasah & ktp & foto user difolder direktori
    if( isset( $ijasah ) && isset( $ktp ) ) {
        $ijasahDls    =glob("img/dokumenUser/ijasah/$ijasah");
        foreach ($ijasahDls as $ijasahDl) {
            if (is_file($ijasahDl))
            unlink($ijasahDl); // hapus file
        }

        $ktpDls    =glob("img/dokumenUser/ktp/$ktp");
        foreach ($ktpDls as $ktpDl) {
            if (is_file($ktpDl))
            unlink($ktpDl); // hapus file
        }
    }

    $fotoUserDls    =glob("img/dokumenUser/foto/$fotoUser");
    foreach ($fotoUserDls as $fotoUserDl) {
        if (is_file($fotoUserDl))
        unlink($fotoUserDl); // hapus file
    }

    $query = "DELETE FROM user WHERE id_user = '$idUser'";
    mysqli_query($conn, $query);

    if( mysqli_affected_rows($conn) > 0 ) {
        echo    "<script>
                alert('Data Berhasil Dihapus');
                document.location.href = 'halamanAdminDataUser.php';
            </script>";
    } else {
        echo    "<script>
                alert('Data Gagal Dihapus');
                document.location.href = 'halamanAdminDataUser.php';
            </script>";
    }
    
?>