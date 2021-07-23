<?php
    require "../config.php";
    $cari = $_GET["cari"];
    
    $queryAmbilListPendaftaran = "SELECT id_pendaftaran_pelatihan, nama_peserta, alamat_peserta, usia_peserta, pendidikan_terakhir, nik, no_hp, foto_user, nama_pelatihan, pendaftaran_pelatihan.id_user, pendaftaran_pelatihan.id_program_pelatihan
    FROM pendaftaran_pelatihan
    JOIN user ON(pendaftaran_pelatihan.id_user = user.id_user)
    JOIN program_pelatihan ON(pendaftaran_pelatihan.id_program_pelatihan = program_pelatihan.id_program_pelatihan)
    WHERE pendaftaran_pelatihan.nama_peserta LIKE '%$cari%'
    OR user.nik LIKE '%$cari%'
    OR user.no_hp LIKE '%$cari%'
    OR pendaftaran_pelatihan.usia_peserta LIKE '%$cari%'
    OR pendaftaran_pelatihan.alamat_peserta LIKE '%$cari%'
    OR pendaftaran_pelatihan.pendidikan_terakhir LIKE '%$cari%'
    OR program_pelatihan.nama_pelatihan LIKE '%$cari%'
    ";

    $objekAmbilListPendaftaran = mysqli_query($conn, $queryAmbilListPendaftaran);
    $listPendaftarans = [];
    while( $listPendaftaran = mysqli_fetch_assoc($objekAmbilListPendaftaran) ) {
      $listPendaftarans[] = $listPendaftaran;
    }
?>

<table cellpadding="10" cellspacing="0" width="100%" style="margin-top: 20px;" id="konten-table">

<tr>
    <th>No.</th>
    <th>Aksi</th>
    <th>Foto</th>
    <th>Nama</th>
    <th>NIK</th>
    <th>NO HP</th>
    <th>Usia</th>
    <th>Alamat</th>
    <th>Pendidikan Terakhir</th>
    <th>Program Pelatihan</th>
</tr>
<?php $i = 1; ?>
<?php foreach( $listPendaftarans as $listPen ) : ?>
    <tr>
    <td><?= $i++; ?></td>
    <td><a href="editPendaftaran.php?id_pendaftaran=<?= $listPen['id_pendaftaran_pelatihan']; ?>&id_program=<?= $listPen['id_program_pelatihan']; ?>" class="tombol-aksi">Edit</a><br><br><a href="hapusPendaftaran.php?id_pendaftaran=<?= $listPen['id_pendaftaran_pelatihan']; ?>" class="tombol-aksi" onclick="return confirm('Yakin Kawan?');">Hapus</a><br><br><a href="cetakBuktiPendaftaran.php?id_user=<?= $listPen['id_user']; ?>" class="tombol-aksi" target="_blank">Cetak</a></td>
    <td><img src="img/dokumenUser/foto/<?= $listPen['foto_user']; ?>" width="70" height="90"></td>
    <td><?= $listPen['nama_peserta']; ?></td>
    <td><?= $listPen['nik']; ?></td>
    <td><?= $listPen['no_hp']; ?></td>
    <td><?= $listPen['usia_peserta']; ?></td>
    <td><?= $listPen['alamat_peserta']; ?></td>
    <td><?= $listPen['pendidikan_terakhir']; ?></td>
    <td><?= $listPen['nama_pelatihan']; ?></td>
</tr>
<?php endforeach; ?>
</table>