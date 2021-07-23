-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2021 at 07:48 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `profil_blk_sby`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pelatihan`
--

CREATE TABLE `kategori_pelatihan` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_pelatihan`
--

INSERT INTO `kategori_pelatihan` (`id_kategori`, `nama_kategori`) VALUES
(1, 'OTOMOTIF'),
(2, 'LAS'),
(3, 'LISTRIK'),
(4, 'BISMAN'),
(5, 'MANUFAKTUR'),
(6, 'TIK'),
(7, 'ELEKTRONIKA'),
(8, 'PARIWISATA');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_pelatihan`
--

CREATE TABLE `pendaftaran_pelatihan` (
  `id_pendaftaran_pelatihan` int(10) UNSIGNED NOT NULL,
  `id_program_pelatihan` int(10) UNSIGNED NOT NULL,
  `nama_peserta` varchar(100) NOT NULL,
  `alamat_peserta` varchar(200) NOT NULL,
  `usia_peserta` int(10) UNSIGNED NOT NULL,
  `pendidikan_terakhir` varchar(100) NOT NULL,
  `ktp` varchar(100) NOT NULL,
  `ijasah` varchar(100) NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendaftaran_pelatihan`
--

INSERT INTO `pendaftaran_pelatihan` (`id_pendaftaran_pelatihan`, `id_program_pelatihan`, `nama_peserta`, `alamat_peserta`, `usia_peserta`, `pendidikan_terakhir`, `ktp`, `ijasah`, `id_user`) VALUES
(39, 9, 'Uzumaki Bayu', 'Bringin Bendo', 12, 'SD Sadang', '60cbb08d39c1d.jpg', '60cbb08d39c2c.jpg', 15),
(41, 13, 'Suatu Percubaan', 'Megare', 26, 'S2 Sastra Jepang', '60cbb12dc192f.jpg', '60cbb12dc1934.jpg', 16),
(42, 8, 'Arman Kucing', 'Waru', 29, 'S2 Fisika', '60cc13621e65b.jpg', '60cc13621e662.jpg', 18),
(43, 14, 'Eka Bagus Fernadi', 'Sadang, Taman, Sidoarjo', 20, 'SD Negeri Sadang', '60cd83204486c.jpg', '60cd832044874.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_pelatihan`
--

CREATE TABLE `program_pelatihan` (
  `id_program_pelatihan` int(10) UNSIGNED NOT NULL,
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `gambar_1` varchar(100) NOT NULL,
  `gambar_2` varchar(100) NOT NULL,
  `gambar_3` varchar(100) NOT NULL,
  `nama_pelatihan` varchar(200) NOT NULL,
  `total_jam` int(10) UNSIGNED NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `deskripsi_pelatihan` varchar(750) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `program_pelatihan`
--

INSERT INTO `program_pelatihan` (`id_program_pelatihan`, `id_kategori`, `gambar_1`, `gambar_2`, `gambar_3`, `nama_pelatihan`, `total_jam`, `deskripsi`, `deskripsi_pelatihan`) VALUES
(1, 1, 'r2-1.jpg', 'r2-2.jpg', 'r2-3.jpg', 'Teknik Sepeda Motor', 260, 'Pelatihan ini mempelajari Teknik Sepeda Motor.', 'Pelatihan ini mempelajari Teknik Sepeda Motor.Pelatihan ini mempelajari Teknik Sepeda Motor.Pelatihan ini mempelajari Teknik Sepeda Motor.Pelatihan ini mempelajari Teknik Sepeda Motor.Pelatihan ini mempelajari Teknik Sepeda Motor.Pelatihan ini mempelajari Teknik Sepeda Motor.Pelatihan ini mempelajari Teknik Sepeda Motor.'),
(2, 1, 'mobil-bensin-1.jpg', 'mobil-bensin-2.jpg', 'mobil-bensin-3.jpg', 'Mobil Bensin', 340, 'Pelatihan ini mempelajari Mobil Bensin.', 'Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.Pelatihan ini mempelajari Mobil Bensin.'),
(3, 2, 'teknik-las-1.jpg', 'teknik-las-2.jpg', 'teknik-las-3.jpg', 'Teknik Las SMAW', 260, 'Pelatihan ini mempelajari Teknik Las SMAW.', 'Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.Pelatihan ini mempelajari Teknik Las SMAW.'),
(4, 3, 'pemasangan-listrik-bangunan-sederhana-1.jpg', 'pemasangan-listrik-bangunan-sederhana-2.jpg', 'pemasangan-listrik-bangunan-sederhana-3.jpg', 'Pemasangan Listrik Bangunan Sederhana', 260, 'Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.', 'Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.Pelatihan ini mempelajari Pemasangan Listrik Bangunan Sederhana.'),
(5, 3, 'teknisi-lemari-pendingin-1.jpg', 'teknisi-lemari-pendingin-2.jpg', 'teknisi-lemari-pendingin-3.jpg', 'Teknisi Lemari Pendingin', 260, 'Pelatihan ini mempelajari Teknisi Lemari Pendingin.', 'Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.Pelatihan ini mempelajari Teknisi Lemari Pendingin.'),
(7, 3, 'plc-1.jpg', 'plc-2.jpg', 'plc-3.jpg', 'Pemasangan Instalasi Kontrol Industri Berbasis PLC', 200, 'Pelatihan ini mempelajari Pemasangan Instalasi Kontrol Industri Berbasis PLC.', 'Pelatihan ini mempelajari Pemasangan Instalasi Kontrol Industri Berbasis PLC.Pelatihan ini mempelajari Pemasangan Instalasi Kontrol Industri Berbasis PLC.Pelatihan ini mempelajari Pemasangan Instalasi Kontrol Industri Berbasis PLC.Pelatihan ini mempelajari Pemasangan Instalasi Kontrol Industri Berbasis PLC.Pelatihan ini mempelajari Pemasangan Instalasi Kontrol Industri Berbasis PLC.'),
(8, 4, 'administrasi-perkantoran-1.jpg', 'administrasi-perkantoran-2.jpg', 'administrasi-perkantoran-3.jpg', 'Pengelola Administrasi Perkantoran', 260, 'Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.', 'Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.Pelatihan ini mempelajari Pengelola Administrasi Perkantoran.'),
(9, 5, 'drafter-1.jpg', 'drafter-2.jpg', 'drafter-3.jpg', 'Drafter AutoCad Mechanical', 180, 'Pelatihan ini mempelajari Drafter AutoCad Mechanical.', 'Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.Pelatihan ini mempelajari Drafter AutoCad Mechanical.'),
(10, 6, 'multimedia-1.jpg', 'multimedia-2.jpg', 'multimedia-3.jpg', 'Multimedia', 240, 'Pelatihan ini mempelajari cara melakukan produksi video.', 'Pelatihan ini mempelajari cara melakukan produksi video. Selain mempelajari teknik-teknik pengambilan video, siswa juga mempelajari tekning editing video menggunakan aplikasi Adobe Premiere dan Adobe After Effect. Sebagai penunjang, siswa juga mempelajari aplikasi Adobe Photoshop dan CorelDraw.'),
(11, 6, 'desain-grafis-1.jpg', 'desain-grafis-2.jpg', 'desain-grafis-3.jpg', 'Desain Grafis', 260, 'Pelatihan ini mempelajari cara melakukan produksi media cetak.', 'Pelatihan ini mempelajari cara melakukan produksi media cetak, antara lain poster, brosur, banner, mug, kaos dan pin. Siswa akan mempelajari penggunaan aplikasi Adobe Photoshop, Adobe InDesign dan CorelDraw.'),
(12, 6, 'networking-1.jpg', 'networking-2.jpg', 'networking-3.jpg', 'Networking', 260, 'Pelatihan ini mempelajari cara membuat jaringan komputer.', 'Pelatihan ini mempelajari cara membuat jaringan komputer. Siswa mempelajari konsep jaringan komputer, cara membangun jaringan komputer lokal (LAN), membuat kabel jaringan, pengaturan jaringan nirkabel, pengaturan Virtual LAN dan pengaturan router.'),
(13, 6, 'office-tools-1.jpg', 'office-tools-2.jpg', 'office-tools-3.jpg', 'Office Tools', 260, 'Pelatihan ini mempelajari cara membuat dokumen perkantoran.', 'Pelatihan ini mempelajari cara membuat dokumen perkantoran. Siswa mempelajari penggunaan aplikasi perkantoran, seperti Microsoft Word, Microsoft Excel, Microsoft Power Point, dan lain-lain.'),
(14, 6, 'pemrograman-web-1.jpg', 'pemrograman-web-2.jpg', 'pemrograman-web-3.jpg', 'Pemrograman Web', 340, 'Pelatihan ini mempelajari cara membuat website dinamis.', 'Pelatihan ini mempelajari cara membuat website dinamis. Siswa akan mempelajari cara membuat desain web yang responsive, membangun database, dan mengaplikasikan halaman web dinamis. Aplikasi yang digunakan antara lain HTML, CSS, MySQL, dan PHP.'),
(15, 7, 'audio-video-1.jpg', 'audio-video-2.jpg', 'audio-video-3.jpg', 'Teknik Audio Video', 260, 'Pelatihan ini mempelajari Teknik Audio Video.', 'Pelatihan ini mempelajari Teknik Audio Video.Pelatihan ini mempelajari Teknik Audio Video.Pelatihan ini mempelajari Teknik Audio Video.Pelatihan ini mempelajari Teknik Audio Video.Pelatihan ini mempelajari Teknik Audio Video.Pelatihan ini mempelajari Teknik Audio Video.Pelatihan ini mempelajari Teknik Audio Video.Pelatihan ini mempelajari Teknik Audio Video.'),
(16, 8, 'perhotelan-1.jpg', 'perhotelan-2.jpg', 'perhotelan-3.jpg', 'Perhotelan', 260, 'Pelatihan ini mempelajari Perhotelan.', 'Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.Pelatihan ini mempelajari Perhotelan.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nik` varchar(50) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `foto_user` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nik`, `no_hp`, `password`, `nama_user`, `foto_user`, `status`) VALUES
(1, '3515130408970708', '081216556905', '$2y$10$f6Qpb93/p4zxWCJTOYHGYOIKsxLSN6tuI1hluRKfkQdCuO8tQavGa', 'Eka Bagus Fernadi', '60ceffzc8a80r.png', 0),
(13, 'admin', 'admin', '$2y$10$.AVQoB5Wd9sWGUbAGTC8yuFFkRR6M8yCWDdK13ss2uIM1krCGeytG', 'Admin', '60c6hf1c8a613.jpg', 1),
(15, '09876', '67890', '$2y$10$iyWj3TqdYBHITZDN6v0t0eETGD6f2LmzoVHIdEkK368LFiNYf26Xy', 'Uzumaki Bayu', '60ca62bb4e27b.jpg', 0),
(16, '55555', '4444', '$2y$10$Vv/EyrUjbtRW8/cpq7ztSuTFHp./a8AUDOoF8k5JeIsakliqfZZr2', 'Suatu Percubaan', '60cd7a37f3915.png', 0),
(18, '11111', '22222', '$2y$10$.vdzbL3ng2LB9u.jiBOa8e.vmCK47yfoC0jpfXjQ0p8Dxg9HzmOHC', 'Arman Kucing', '60cc126c8bfa9.jpg', 0),
(19, '22222', '11111', '$2y$10$P1UeylDHuveICgAwxcmGyORmO7X4rQUZnopBA3QDGXOJebiUjcq9K', 'Bocil Kematian', '60cc12d6cf2cf.jpg', 0),
(21, '33333', '3536591', '$2y$10$OPx/zL5udaH93qdOcsq5serfY97gb.M1Ec8xY997Jp5y5NMaYGREi', 'Muhajid', '60ccca3aa3846.jpg', 0),
(22, '44444', '849572345', '$2y$10$y1q9tu8N9az2N/34h8oVtuzJVb9/WIS7gVc9C2SfmLUohvCpsRdze', 'Juliana', '60ccca885f949.png', 0),
(24, '66666', '452348570', '$2y$10$czY9qifzHYQhZnbHH7aEGO5Yancu21SkfrQUUg.lwNkTAuKsmB65m', 'Uzumaki Saburo', '60cd2bd93f54b.jpg', 0),
(25, '77777', '398571', '$2y$10$Ta3oWFLs2HQWCjoBEnL4O.MPD3Th.5TI2uPm3LTmpqu9xtT6x1FO2', 'Usmane', '60cd83b735b09.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori_pelatihan`
--
ALTER TABLE `kategori_pelatihan`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pendaftaran_pelatihan`
--
ALTER TABLE `pendaftaran_pelatihan`
  ADD PRIMARY KEY (`id_pendaftaran_pelatihan`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD KEY `id_program_pelatihan` (`id_program_pelatihan`);

--
-- Indexes for table `program_pelatihan`
--
ALTER TABLE `program_pelatihan`
  ADD PRIMARY KEY (`id_program_pelatihan`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori_pelatihan`
--
ALTER TABLE `kategori_pelatihan`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pendaftaran_pelatihan`
--
ALTER TABLE `pendaftaran_pelatihan`
  MODIFY `id_pendaftaran_pelatihan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `program_pelatihan`
--
ALTER TABLE `program_pelatihan`
  MODIFY `id_program_pelatihan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendaftaran_pelatihan`
--
ALTER TABLE `pendaftaran_pelatihan`
  ADD CONSTRAINT `pendaftaran_pelatihan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftaran_pelatihan_ibfk_2` FOREIGN KEY (`id_program_pelatihan`) REFERENCES `program_pelatihan` (`id_program_pelatihan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_pelatihan`
--
ALTER TABLE `program_pelatihan`
  ADD CONSTRAINT `program_pelatihan_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_pelatihan` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
