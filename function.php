<?php
    require "config.php";

    // validasi gambar, retrun tmp_name dan nama acak
    function upload($gambar) {
        $namaFile = $_FILES["$gambar"]["name"];
        $ukuranFile = $_FILES["$gambar"]["size"];
        $error = $_FILES["$gambar"]["error"];
        $tmpName = $_FILES["$gambar"]["tmp_name"];
    
        // cek apakah tidak ada gambar yang diupload
        if ($error === 4) { // 4 = tidak ada gambar yang diupload
            echo    "<script>
                        alert('Pilih gambar terlebih dahulu!');
                        document.location.href = '';
                    </script>";
            return false;
        }
    
        // cek apakah data yg diupload adalah gambar
        $ekstensiGambarValid = ["jpg", "jpeg", "png"];
        $ekstensiGambar = explode(".", $namaFile); // variable jadi array ["eka", "jpg"]
        $ekstensiGambar = strtolower(end($ekstensiGambar)); // ambil index terakhir array dan lakukan lowercase
    
        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) { // jika variabel tidak ada dalam array $ekstensiGambarValid
            echo    "<script>
                        alert('yang anda upload bukan gambar');
                        document.location.href = '';
                    </script>";
            return false;
        }
    
        // cek jika ukuran terlalu besar
        if ($ukuranFile > 1000000) { // ukuran dalam byte
            echo    "<script>
                        alert('ukuran gambar terlalu besar (max 1000kb)');
                        document.location.href = '';
                    </script>";
            return false;
        }
    
    
        // lolos pengecekan, gambar siap diupload
    
        // generate nama gambar baru
        $namaFileBaru = uniqid(); // akan membangkitkan string angka random
        $namaFileBaru .= ".";
        $namaFileBaru .= $ekstensiGambar;
        //var_dump($namaFileBaru); die;
    
        // move_uploaded_file($tmpName, "img/user/" . $namaFileBaru); // copy file yang di pilih beserta namanya ke server tempat penyimpanan gambar
        
        return $arr = [$tmpName, $namaFileBaru]; // return nama file supaya bisa tersimpan didatabase
    
        }
?>