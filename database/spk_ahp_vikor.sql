-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 27, 2022 at 08:13 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_ahp_vikor`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id` varchar(12) NOT NULL,
  `nama_alternatif` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id`, `nama_alternatif`) VALUES
('ALTERNATIF01', 'DOSEN 01'),
('ALTERNATIF02', 'DOSEN 02'),
('ALTERNATIF03', 'DOSEN 03'),
('ALTERNATIF04', 'DOSEN 04'),
('ALTERNATIF05', 'DOSEN 05');

-- --------------------------------------------------------

--
-- Table structure for table `banding_dosen`
--

CREATE TABLE `banding_dosen` (
  `id` int(5) NOT NULL,
  `data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banding_dosen`
--

INSERT INTO `banding_dosen` (`id`, `data`) VALUES
(19, '{\"C01\":[{\"id\":\"DOSEN0001-DOSEN0002\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0002\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0001-DOSEN0003\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0001-DOSEN0004\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0001-DOSEN0005\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0001\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0003\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0002-DOSEN0004\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0005\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0003-DOSEN0004\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0003-DOSEN0005\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0004-DOSEN0005\",\"kriteria_1\":\"DOSEN0004\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":2}],\"C02\":[{\"id\":\"DOSEN0001-DOSEN0002\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0002\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0001-DOSEN0003\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0001-DOSEN0004\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0001-DOSEN0005\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0003\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0004\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0005\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0003-DOSEN0004\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0003-DOSEN0005\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0004-DOSEN0005\",\"kriteria_1\":\"DOSEN0004\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":3}],\"C03\":[{\"id\":\"DOSEN0001-DOSEN0002\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0002\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0001-DOSEN0003\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0001-DOSEN0004\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0001-DOSEN0005\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0001\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0003\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0002-DOSEN0004\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0005\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0003-DOSEN0004\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0003-DOSEN0005\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0004-DOSEN0005\",\"kriteria_1\":\"DOSEN0004\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":3}],\"C04\":[{\"id\":\"DOSEN0001-DOSEN0002\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0002\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0001-DOSEN0003\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0001-DOSEN0004\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0001-DOSEN0005\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0002-DOSEN0003\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0002-DOSEN0004\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0005\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0003-DOSEN0004\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0003-DOSEN0005\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0004-DOSEN0005\",\"kriteria_1\":\"DOSEN0004\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":4}],\"C05\":[{\"id\":\"DOSEN0001-DOSEN0002\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0002\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0001-DOSEN0003\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0001-DOSEN0004\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0001-DOSEN0005\",\"kriteria_1\":\"DOSEN0001\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0002-DOSEN0003\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0003\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":2},{\"id\":\"DOSEN0002-DOSEN0004\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0002\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0002-DOSEN0005\",\"kriteria_1\":\"DOSEN0002\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0005\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0003-DOSEN0004\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0004\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":3},{\"id\":\"DOSEN0003-DOSEN0005\",\"kriteria_1\":\"DOSEN0003\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0003\",\"nilai_perbandingan\":4},{\"id\":\"DOSEN0004-DOSEN0005\",\"kriteria_1\":\"DOSEN0004\",\"kriteria_2\":\"DOSEN0005\",\"kriteria_utama\":\"DOSEN0004\",\"nilai_perbandingan\":4}]}');

-- --------------------------------------------------------

--
-- Table structure for table `banding_kriteria`
--

CREATE TABLE `banding_kriteria` (
  `id` varchar(7) NOT NULL,
  `kriteria_1` varchar(5) DEFAULT NULL,
  `kriteria_2` varchar(5) DEFAULT NULL,
  `kriteria_utama` varchar(5) DEFAULT NULL,
  `nilai_perbandingan` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banding_kriteria`
--

INSERT INTO `banding_kriteria` (`id`, `kriteria_1`, `kriteria_2`, `kriteria_utama`, `nilai_perbandingan`) VALUES
('C01-C02', 'C01', 'C02', 'C02', 2),
('C01-C03', 'C01', 'C03', 'C03', 3),
('C01-C04', 'C01', 'C04', 'C04', 5),
('C01-C05', 'C01', 'C05', 'C05', 2),
('C02-C03', 'C02', 'C03', 'C03', 3),
('C02-C04', 'C02', 'C04', 'C04', 2),
('C02-C05', 'C02', 'C05', 'C05', 5),
('C03-C04', 'C03', 'C04', 'C04', 4),
('C03-C05', 'C03', 'C05', 'C05', 3),
('C04-C05', 'C04', 'C05', 'C05', 5);

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` varchar(9) NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nama`) VALUES
('DOSEN0001', 'Dosen 1'),
('DOSEN0002', 'Dosen 2'),
('DOSEN0003', 'Dosen 3'),
('DOSEN0004', 'Dosen 4'),
('DOSEN0005', 'Dosen 5');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` varchar(5) NOT NULL,
  `nama_kriteria` text DEFAULT NULL,
  `bobot` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama_kriteria`, `bobot`) VALUES
('C01', 'Pengajaran', 1),
('C02', 'Penelitian dan Pengembangan', 1),
('C03', 'Pengabdian Kepada Masyarakat', 1),
('C04', 'Penunjang Tridarma', 1),
('C05', 'EDOM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Administrator', 'admin', 'VGIvbGt5NUtOUC9TZVhBNkw3N1VHQT09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banding_dosen`
--
ALTER TABLE `banding_dosen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banding_kriteria`
--
ALTER TABLE `banding_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banding_dosen`
--
ALTER TABLE `banding_dosen`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
