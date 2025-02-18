-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 12:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `system_pengajuan`
--

-- --------------------------------------------------------

--
-- Table structure for table `catatan`
--

CREATE TABLE `catatan` (
  `id_catatan` varchar(5) NOT NULL,
  `catatan` text NOT NULL,
  `update_catatan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `catatan`
--

INSERT INTO `catatan` (`id_catatan`, `catatan`, `update_catatan`) VALUES
('C1', 'Tanggal 14 Mei besok sampai 16 Mei besok pengajuan mungkin tidak akan di lihat oleh pihat manajemen ', '2025-01-10');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengajuan`
--

CREATE TABLE `jenis_pengajuan` (
  `id_jenis_pengajuan` int(11) NOT NULL,
  `jenis_pengajuan` varchar(25) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jenis_pengajuan`
--

INSERT INTO `jenis_pengajuan` (`id_jenis_pengajuan`, `jenis_pengajuan`, `deskripsi`) VALUES
(1, 'Barang', 'Jenis Pengajuan, berupa jenis barang yang akan di ajukan');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `event` varchar(225) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jenis_pengajuan` bigint(11) NOT NULL,
  `jenis_pengajuan` varchar(255) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `biaya` int(225) NOT NULL,
  `alasan` text NOT NULL,
  `keterangan` text NOT NULL,
  `jadwal_pelaksanaan` date NOT NULL,
  `catatan` text NOT NULL,
  `status` enum('menunggu','proses','selesai') NOT NULL,
  `update_pengajuan` date NOT NULL,
  `estimasi_waktu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `event`, `id_user`, `id_jenis_pengajuan`, `jenis_pengajuan`, `tanggal_pengajuan`, `biaya`, `alasan`, `keterangan`, `jadwal_pelaksanaan`, `catatan`, `status`, `update_pengajuan`, `estimasi_waktu`) VALUES
(16, 'hari guru', 15, 20369191570, 'mc', '2025-01-10', 1000, ' kita membutuhkan mc ', '-', '2025-01-10', 'terimakasih', 'selesai', '2025-01-10', '5'),
(17, 'karnaval', 15, 94074952084, 'barang', '2025-01-12', 1000000, '', 'lampu,panggung', '2025-01-12', '-', 'selesai', '2025-01-12', '7'),
(18, 'nari', 15, 54530102586, 'barang', '2025-01-13', 500000, '-', '-', '2025-01-14', 'baik', 'selesai', '2025-01-14', '10'),
(19, 'tels expo', 15, 84679215973, 'mc', '2025-01-15', 1000000, '-', '-', '0000-00-00', 'over', 'selesai', '2025-01-24', '1'),
(20, 'run', 15, 73522251819, 'mc', '2025-01-24', 5000000, '-', '-', '2025-01-25', '-', 'selesai', '2025-01-24', '7'),
(21, 'hari guru', 15, 52975025608, 'mc', '2025-01-25', 6000000, 'butuh mc', '-', '2025-01-25', '-', 'selesai', '2025-01-25', '5'),
(22, '17an', 15, 51520874874, 'mc', '2025-02-05', 80000, '', 'untuk acara', '2025-02-13', 'oke', 'selesai', '2025-02-05', '7'),
(23, 'berkuda', 15, 34064505131, 'mc', '2025-02-06', 100000, '-', '-', '0000-00-00', '', 'menunggu', '2025-02-06', '5'),
(24, 'ayayjfrhfjr', 15, 84326919302, 'j4djh4', '2025-02-09', 4545555, 'djd', 'kdjdjndnd', '0000-00-00', '', 'menunggu', '2025-02-09', '5'),
(25, '3sd3', 17, 75043704710, 'd3rr', '2025-02-09', 3434, 'xf4', 'x3r3', '0000-00-00', '', 'menunggu', '2025-02-09', '10');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id_riwayat` int(11) NOT NULL,
  `kegiatan` varchar(225) NOT NULL,
  `kegiatan2` varchar(225) NOT NULL,
  `kegiatan3` varchar(225) NOT NULL,
  `catatan` text NOT NULL,
  `jenis_riwayat` varchar(225) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `notifikasi` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`id_riwayat`, `kegiatan`, `kegiatan2`, `kegiatan3`, `catatan`, `jenis_riwayat`, `id_pengajuan`, `tanggal_kegiatan`, `notifikasi`) VALUES
(26, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'keren', 'Penerimaan', 14, '2025-01-06', '0'),
(27, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'iya', 'Penerimaan', 15, '2025-01-06', '0'),
(28, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'terimakasih', 'Penerimaan', 16, '2025-01-10', '0'),
(29, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 16, '2025-01-10', '0'),
(30, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', '-', 'Penerimaan', 17, '2025-01-12', '0'),
(31, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 17, '2025-01-12', '0'),
(32, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'baik', 'Penerimaan', 18, '2025-01-14', '0'),
(33, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 18, '2025-01-14', '0'),
(34, 'Telah Melakukan Penolakan Pengajuan', 'Pengajuan Ditolak', 'Pengajuan Anda Telah DiTolak Oleh Pihak Manajemen', 'over', 'Penolakan', 19, '2025-01-24', '0'),
(35, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', '-', 'Penerimaan', 20, '2025-01-24', '0'),
(36, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 20, '2025-01-24', '1'),
(37, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', '-', 'Penerimaan', 21, '2025-01-25', '1'),
(38, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 21, '2025-01-25', '1'),
(39, 'Telah Melakukan Menerima Pengajuan', 'Pengajuan diterima', 'Pengajuan Anda Telah DiTerima Oleh Pihak Manajemen', 'oke', 'Penerimaan', 22, '2025-02-05', '1'),
(40, 'Telah Melakukan Menyelesaian Pengajuan', 'Pengajuan Diselesaikan', 'Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', '', 'Penyelesaian', 22, '2025-02-05', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `nama_depan` varchar(225) NOT NULL,
  `nama_belakang` varchar(225) NOT NULL,
  `jk` enum('laki-laki','perempuan') NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('manajemen','tim') NOT NULL,
  `pembuatan_akun` date NOT NULL,
  `update_akun` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `email`, `password`, `nama_depan`, `nama_belakang`, `jk`, `no_hp`, `alamat`, `role`, `pembuatan_akun`, `update_akun`) VALUES
(13, 'admin', 'admin@gmail.com', '4cdf49528e686ca0acd2a359fb834168', 'admin', 'manajemen', 'laki-laki', '45809767', 'Rumah admin', 'manajemen', '2017-04-27', '2025-01-09'),
(14, 'user57', 'user@gmail.com', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'tim', 'laki-laki', '346572931', 'rumah tim', 'tim', '2017-04-27', '2017-05-16'),
(15, 'bagus', 'bagus@gmail.com', '9b1ebb2d5b0fb8520690a6e0e6d18b01', 'bagus', 'andhika', 'laki-laki', '63743829', 'Perumahan bumi asri j-15', 'tim', '2017-05-09', '2025-01-09'),
(16, 'andhika', 'andhikab57@yahoo.com', '6ef95621c960af17372d1145d69af6c8', 'andhika', 'andhika', 'laki-laki', '12398039810293123', 'andhika', 'manajemen', '2017-05-14', '2017-05-14'),
(17, 'galze', 'galze@gmail.com', '09eb9bec48837f77651aefc0e8e01aed', 'Galang ', 'Ramadhan', 'laki-laki', '123345555', 'griya asri', 'tim', '2025-01-13', '2025-02-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catatan`
--
ALTER TABLE `catatan`
  ADD PRIMARY KEY (`id_catatan`);

--
-- Indexes for table `jenis_pengajuan`
--
ALTER TABLE `jenis_pengajuan`
  ADD PRIMARY KEY (`id_jenis_pengajuan`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id_riwayat`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_pengajuan`
--
ALTER TABLE `jenis_pengajuan`
  MODIFY `id_jenis_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
