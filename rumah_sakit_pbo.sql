-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2026 at 12:07 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rumah_sakit_pbo`
--

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `usia` int NOT NULL,
  `lama_rawat` int NOT NULL,
  `biaya_kamar_per_hari` decimal(12,2) NOT NULL,
  `jenis_pasien` enum('BPJS','ASURANSI','UMUM') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama`, `usia`, `lama_rawat`, `biaya_kamar_per_hari`, `jenis_pasien`) VALUES
('P001', 'Budi Santoso', 45, 5, 300000.00, 'BPJS'),
('P002', 'Siti Aminah', 38, 3, 250000.00, 'BPJS'),
('P003', 'Rizky Maulana', 52, 7, 350000.00, 'BPJS'),
('P004', 'Nur Aisyah', 27, 2, 275000.00, 'BPJS'),
('P005', 'Hendra Wijaya', 60, 6, 400000.00, 'BPJS'),
('P006', 'Fitri Handayani', 34, 4, 300000.00, 'BPJS'),
('P007', 'Andi Pratama', 29, 4, 500000.00, 'ASURANSI'),
('P008', 'Dewi Lestari', 33, 6, 450000.00, 'ASURANSI'),
('P009', 'Rudi Hartono', 41, 5, 600000.00, 'ASURANSI'),
('P010', 'Maya Sari', 36, 3, 550000.00, 'ASURANSI'),
('P011', 'Fajar Nugroho', 48, 8, 500000.00, 'ASURANSI'),
('P012', 'Anisa Putri', 25, 2, 400000.00, 'ASURANSI'),
('P013', 'Rina Marlina', 41, 2, 350000.00, 'UMUM'),
('P014', 'Agus Saputra', 50, 7, 400000.00, 'UMUM'),
('P015', 'Linda Permata', 31, 3, 300000.00, 'UMUM'),
('P016', 'Teguh Prakoso', 55, 5, 450000.00, 'UMUM'),
('P017', 'Dian Kusuma', 22, 1, 250000.00, 'UMUM'),
('P018', 'Arman Hakim', 46, 4, 500000.00, 'UMUM'),
('P019', 'Yuni Kartika', 39, 6, 350000.00, 'UMUM'),
('P020', 'Bayu Ramadhan', 28, 3, 375000.00, 'UMUM');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_asuransi_swasta`
--

CREATE TABLE `pasien_asuransi_swasta` (
  `id_pasien` varchar(10) NOT NULL,
  `nama_provider` varchar(100) NOT NULL,
  `nomor_polis` varchar(30) NOT NULL,
  `limit_cover` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_asuransi_swasta`
--

INSERT INTO `pasien_asuransi_swasta` (`id_pasien`, `nama_provider`, `nomor_polis`, `limit_cover`) VALUES
('P007', 'Prudential', 'POLIS77881', 1500000.00),
('P008', 'Allianz', 'POLIS88291', 3000000.00),
('P009', 'AXA Mandiri', 'POLIS66372', 2500000.00),
('P010', 'Manulife', 'POLIS55218', 2000000.00),
('P011', 'Sinarmas MSIG', 'POLIS44192', 3500000.00),
('P012', 'AIA Financial', 'POLIS33718', 1000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pasien_bpjs`
--

CREATE TABLE `pasien_bpjs` (
  `id_pasien` varchar(10) NOT NULL,
  `nomor_pbi` varchar(30) NOT NULL,
  `faskes_asal` varchar(100) NOT NULL,
  `kelas_kamar` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_bpjs`
--

INSERT INTO `pasien_bpjs` (`id_pasien`, `nomor_pbi`, `faskes_asal`, `kelas_kamar`) VALUES
('P001', 'PBI0019283', 'Puskesmas Cempaka', 'Kelas 2'),
('P002', 'PBI0027361', 'Klinik Sehat Jaya', 'Kelas 3'),
('P003', 'PBI0031928', 'Puskesmas Melati', 'Kelas 1'),
('P004', 'PBI0048273', 'Klinik Harapan Sehat', 'Kelas 3'),
('P005', 'PBI0056382', 'Puskesmas Sukamaju', 'Kelas 2'),
('P006', 'PBI0062917', 'Puskesmas Bina Sehat', 'Kelas 1');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_umum`
--

CREATE TABLE `pasien_umum` (
  `id_pasien` varchar(10) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pasien_umum`
--

INSERT INTO `pasien_umum` (`id_pasien`, `nik`, `metode_pembayaran`) VALUES
('P013', '3174091203810001', 'Tunai'),
('P014', '3275081502760002', 'Transfer Bank'),
('P015', '3173052105920003', 'Kartu Debit'),
('P016', '3276010911680004', 'Tunai'),
('P017', '3174021507010005', 'QRIS'),
('P018', '3275032204780006', 'Transfer Bank'),
('P019', '3173081106840007', 'Kartu Kredit'),
('P020', '3275070309960008', 'Tunai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_asuransi_swasta`
--
ALTER TABLE `pasien_asuransi_swasta`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_bpjs`
--
ALTER TABLE `pasien_bpjs`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pasien_umum`
--
ALTER TABLE `pasien_umum`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pasien_asuransi_swasta`
--
ALTER TABLE `pasien_asuransi_swasta`
  ADD CONSTRAINT `pasien_asuransi_swasta_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pasien_bpjs`
--
ALTER TABLE `pasien_bpjs`
  ADD CONSTRAINT `pasien_bpjs_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pasien_umum`
--
ALTER TABLE `pasien_umum`
  ADD CONSTRAINT `pasien_umum_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
