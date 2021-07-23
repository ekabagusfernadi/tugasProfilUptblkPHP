<?php
    require "../config.php";
    $kategori = $_GET["kategori"];
    $queryAmbilProgPel1 = "SELECT * FROM program_pelatihan
    JOIN kategori_pelatihan ON(program_pelatihan.id_kategori = kategori_pelatihan.id_kategori)
    WHERE nama_kategori = '$kategori'";
    $objekAmbilProgPel1 = mysqli_query($conn, $queryAmbilProgPel1);
    $progPels = [];
    while( $progPel = mysqli_fetch_assoc($objekAmbilProgPel1) ) {
        $progPels[] = $progPel;
    }
?>
<h3><?= $kategori; ?></h3>
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