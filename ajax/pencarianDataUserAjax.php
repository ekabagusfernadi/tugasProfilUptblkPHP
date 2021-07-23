<?php
    require "../config.php";
    $cari = $_GET["cari"];
    $cari;

    // ambil data list user
    $queryAmbilListPendaftaran = "SELECT * FROM user WHERE (
        nama_user LIKE '%$cari%'
        OR nik LIKE '%$cari%'
        OR no_hp LIKE '%$cari%'
    ) AND `status` = 0";

    $objekAmbilListPendaftaran = mysqli_query($conn, $queryAmbilListPendaftaran);
    $listPendaftarans = [];
    while( $listPendaftaran = mysqli_fetch_assoc($objekAmbilListPendaftaran) ) {
      $listPendaftarans[] = $listPendaftaran;
    }
?>

<table cellpadding="10" cellspacing="0" width="100%" style="margin-top: 20px;" id="konten-table-user">

<tr>
    <th>No.</th>
    <th>Aksi</th>
    <th>Foto</th>
    <th>Nama</th>
    <th>NIK</th>
    <th>NO HP</th>
</tr>
<?php $i = 1; ?>
<?php foreach( $listPendaftarans as $listPen ) : ?>
    <tr>
    <td><?= $i++; ?></td>
    <td><a href="editDataUser.php?id_user=<?= $listPen['id_user']; ?>" class="tombol-aksi">Edit</a><br><br><a href="hapusDataUser.php?id_user=<?= $listPen['id_user']; ?>" class="tombol-aksi" onclick="return confirm('Yakin Kawan?');">Hapus</a></td>
    <td><img src="img/dokumenUser/foto/<?= $listPen['foto_user']; ?>" width="70" height="90"></td>
    <td><?= $listPen['nama_user']; ?></td>
    <td><?= $listPen['nik']; ?></td>
    <td><?= $listPen['no_hp']; ?></td>
</tr>
<?php endforeach; ?>
</table>