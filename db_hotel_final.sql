-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Oct 18, 2026 at 02:44 AM
-- Server version: 11.8.9-MariaDB-ubu2404-log
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hotel`
--
CREATE DATABASE IF NOT EXISTS `db_hotel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
USE `db_hotel`;

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

DROP TABLE IF EXISTS `kamar`;
CREATE TABLE `kamar` (
  `id_kamar` int(11) NOT NULL,
  `fasilitas` varchar(16) NOT NULL,
  `tempat_tidur` varchar(16) NOT NULL,
  `status` varchar(16) NOT NULL,
  `id_tamu` int(11) DEFAULT NULL,
  `harga_per_malam` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `fasilitas`, `tempat_tidur`, `status`, `id_tamu`, `harga_per_malam`) VALUES
(101, 'Standard', 'Single', 'Kosong', NULL, 250000),
(102, 'Standard', 'Single', 'Kosong', NULL, 250000),
(103, 'Standard', 'Single', 'Kosong', NULL, 250000),
(104, 'Standard', 'Single', 'Kosong', NULL, 250000),
(105, 'Standard', 'Queen', 'Kosong', NULL, 300000),
(106, 'Standard', 'Queen', 'Kosong', NULL, 300000),
(107, 'Standard', 'Queen', 'Kosong', NULL, 300000),
(108, 'Standard', 'Queen', 'Kosong', NULL, 300000),
(109, 'Deluxe', 'Twin Bed', 'Kosong', NULL, 350000),
(110, 'Deluxe', 'Twin Bed', 'Kosong', NULL, 350000);

--
-- Triggers `kamar`
--
DROP TRIGGER IF EXISTS `tgr_ubah_status`;
DELIMITER $$
CREATE TRIGGER `tgr_ubah_status` BEFORE UPDATE ON `kamar` FOR EACH ROW IF NEW.id_tamu IS NULL THEN
	SET NEW.status = 'Kosong';
ELSE
	SET NEW.status = 'Terisi';
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tamu` int(11) DEFAULT NULL,
  `id_petugas` int(11) DEFAULT NULL,
  `petugas_bayar` varchar(64) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(32) DEFAULT NULL,
  `status_pembayaran` enum('Lunas','Belum Lunas') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `nama_petugas` varchar(64) NOT NULL,
  `level` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `level`) VALUES
(1, 'admin', '$2y$10$Km9PnuNkWrTO93IZEK0TguGqyMG1eVcL4P2Yws8dAyt7stqyw8Fh.', 'admin', 'admin'),
(2, 'anto', '$2y$10$RXngxtVA85H15h5ynbs6OeN1J9U9ot0pFn2URUj18wFZ2vkkUp2Fy', 'AntoIsMantap', 'petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

DROP TABLE IF EXISTS `tamu`;
CREATE TABLE `tamu` (
  `id_tamu` int(11) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `no_telepon` varchar(16) NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `waktu_check_in` datetime NOT NULL,
  `waktu_check_out` datetime DEFAULT NULL,
  `durasi_inap` varchar(8) NOT NULL,
  `id_pembayaran` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Triggers `tamu`
--
DROP TRIGGER IF EXISTS `trg_setelah_hapus_tamu`;
DELIMITER $$
CREATE TRIGGER `trg_setelah_hapus_tamu` AFTER DELETE ON `tamu` FOR EACH ROW UPDATE kamar
SET status = 'Kosong'
WHERE id_tamu IS NULL
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_update_id_tamu_tabel_kamar`;
DELIMITER $$
CREATE TRIGGER `trg_update_id_tamu_tabel_kamar` AFTER INSERT ON `tamu` FOR EACH ROW UPDATE kamar
SET id_tamu = NEW.id_tamu
WHERE id_kamar = NEW.id_kamar
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tamu_baru`
--

DROP TABLE IF EXISTS `tamu_baru`;
CREATE TABLE `tamu_baru` (
  `id_tamu_baru` int(11) NOT NULL,
  `nama` varchar(125) NOT NULL,
  `no_telepon` varchar(16) NOT NULL,
  `durasi_inap` int(11) NOT NULL,
  `fasilitas` enum('Standard','Deluxe','Executive') NOT NULL,
  `tempat_tidur` enum('Single','Twin Bed','Queen','King') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`),
  ADD KEY `FK_kamar_tamu` (`id_tamu`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `fk_petugas_pembayaran` (`id_petugas`),
  ADD KEY `fk_tamu_pembayaran` (`id_tamu`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id_tamu`),
  ADD KEY `fk_pembayaran_tamu` (`id_pembayaran`);

--
-- Indexes for table `tamu_baru`
--
ALTER TABLE `tamu_baru`
  ADD PRIMARY KEY (`id_tamu_baru`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id_tamu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tamu_baru`
--
ALTER TABLE `tamu_baru`
  MODIFY `id_tamu_baru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kamar`
--
ALTER TABLE `kamar`
  ADD CONSTRAINT `FK_kamar_tamu` FOREIGN KEY (`id_tamu`) REFERENCES `tamu` (`id_tamu`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_petugas_pembayaran` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `fk_tamu_pembayaran` FOREIGN KEY (`id_tamu`) REFERENCES `tamu` (`id_tamu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tamu`
--
ALTER TABLE `tamu`
  ADD CONSTRAINT `fk_pembayaran_tamu` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id_pembayaran`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
