-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2026 at 04:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ukk_2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(17) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '1980010001', 'Aanisah Putri Nur Aini, S.Pd', 'aanisahputrinuraini@gmail.com', 1, 1, '2026-01-01 01:00:00', '2026-11-11 06:15:59'),
(2, '1980020002', 'Ai Nuryaidah, S.Pd', 'ainuryaidah@gmail.com', 1, 2, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(3, '1980030003', 'Ai Wahidah, S.Ag', 'aiwahidah@gmail.com', 1, 3, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(4, '1980040004', 'Ansor Muhajir, S.T', 'ansormuhajir@gmail.com', 1, 4, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(5, '1980050005', 'Ari Sandriana, S.Kom', 'arisandriana@gmail.com', 1, 5, '2026-01-01 01:00:00', '2026-11-11 07:00:56'),
(6, '1980060006', 'Arif Kusmawan, S.Pd', 'arifkusmawan@gmail.com', 1, 6, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(7, '1980070007', 'Asep Bastaman', 'asepbastaman@gmail.com', 1, 7, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(8, '1980080008', 'Asep Taufiq Hidayat, S.Kom', 'aseptaufiqhidayat@gmail.com', 1, 8, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(9, '1980090009', 'Chandra Aditya Yusup, S.Pd', 'chandraadityayusup@gmail.com', 1, 9, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(10, '1980100010', 'Dedi Kardiman, S.Pd', 'dedikardiman@gmail.com', 1, 10, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(11, '1980110011', 'Dody Jaenudin, S.Pd', 'dodyjaenudin@gmail.com', 1, 11, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(12, '1980120012', 'Drs. Ahmad Nur Mukhlis', 'ahmadnurmukhlis@gmail.com', 1, 12, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(13, '1980130013', 'Drs. Heri', 'heri@gmail.com', 1, 13, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(14, '1980140014', 'Drs. Muhamad Ali', 'muhamadali@gmail.com', 1, 14, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(15, '1980150015', 'Eli Rosliah, S.Pd', 'elirosliah@gmail.com', 1, 15, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(16, '1980160016', 'Erna Suryani, S.Pd', 'ernasuryani@gmail.com', 1, 16, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(17, '1980170017', 'Feri Rahmawan, S.Pd', 'ferirahmawan@gmail.com', 1, 17, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(18, '1980180018', 'H. Encep Maemun, S.T., M.Pd', 'encepmaemun@gmail.com', 1, 18, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(19, '1980190019', 'Helmi Ali Akbar, S.Pd.I', 'helmialihakbar@gmail.com', 1, 19, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(20, '1980200020', 'Ida Farida, S.Pd', 'idafarida@gmail.com', 1, 20, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(21, '1980210021', 'Idah Mahmudah, S.Pd', 'idahmahmudah@gmail.com', 1, 21, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(22, '1980220022', 'Isni Nur Fitriani, S.Pd', 'isninurfitriani@gmail.com', 1, 22, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(23, '1980230023', 'Lilis Rustandy Mawardi, S.Pd', 'lilisrustandymawardi@gmail.com', 1, 23, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(24, '1980240024', 'Maya Permata Endah, S.Pd', 'mayapermataendah@gmail.com', 1, 24, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(25, '1980250025', 'Mira Dwi Rahmawati, S.Ag', 'miradwirahmawati@gmail.com', 1, 25, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(26, '1980260026', 'Ogi Gaosun Gais, S.Pd.I', 'ogigaosungais@gmail.com', 1, 26, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(27, '1980270027', 'Opik', 'opik@gmail.com', 1, 27, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(28, '1980280028', 'Rendy Ichsan Kusumah, S.T', 'rendyichsankusumah@gmail.com', 1, 28, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(29, '1980290029', 'Sandi Mulyana, S.Pd', 'sandimulyana@gmail.com', 1, 29, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(30, '1980300030', 'Syeni Suswarini, S.Pd', 'syenisuswarini@gmail.com', 1, 30, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(31, '1980310031', 'Uca Musa Yusenda, S.Pd', 'ucmusayusenda@gmail.com', 1, 31, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(32, '1980320032', 'Ucu Muhammad Khoer N, S.Pd', 'ucumuhammadkhoern@gmail.com', 1, 32, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(33, '1980330033', 'Wawan Kurniawan, S.Pd.I', 'wawankurniawan@gmail.com', 1, 33, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(34, '1980340034', 'Wiwid Yulianti, S.Pd', 'wiwidyulianti@gmail.com', 1, 34, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(35, '1980350035', 'Yaneu Nurdian, S.Pd, M.Pd', 'yaneunurdian@gmail.com', 1, 35, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(36, '1980360036', 'Yusrin Noer Sabrina, S.Pd', 'yusrinnoersabrina@gmail.com', 1, 36, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(37, '1980370037', 'Yusi Luthfiani, S.Sos.I', 'yusiluthfiani@gmail.com', 1, 37, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(38, '1980380038', 'Nana Sujana', 'guru38@sekolah.sch.id', 1, 38, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(39, '1980390039', 'Oki Firmansyah', 'guru39@sekolah.sch.id', 1, 39, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(40, '1980400040', 'Prita Lestari', 'guru40@sekolah.sch.id', 1, 40, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(41, '1980410041', 'Rudi Hartono', 'guru41@sekolah.sch.id', 1, 41, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(42, '1980420042', 'Sari Ningsih', 'guru42@sekolah.sch.id', 1, 42, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(43, '1980430043', 'Tedi Setiawan', 'guru43@sekolah.sch.id', 1, 43, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(44, '1980440044', 'Umi Rahma', 'guru44@sekolah.sch.id', 1, 44, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(45, '1980450045', 'Vicky Pratama', 'guru45@sekolah.sch.id', 1, 45, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(46, '1980460046', 'Widi Astuti', 'guru46@sekolah.sch.id', 1, 46, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(47, '1980470047', 'Yani Mulyani', 'guru47@sekolah.sch.id', 1, 47, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(48, '1980480048', 'Yudi Kurniawan', 'guru48@sekolah.sch.id', 1, 48, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(49, '1980490049', 'Zulfa Aulia', 'guru49@sekolah.sch.id', 1, 49, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(50, '1980500050', 'Rina Marlina', 'guru50@sekolah.sch.id', 1, 50, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(53, '1980510051', 'Aldi Maulana', 'aldimaulana@sekolah.sch.id', 1, 51, '2026-11-11 06:34:12', '2026-11-11 06:34:12'),
(54, '0950690605', 'asep', 'asep@gmail.com', 1, 1, '2026-11-13 02:17:19', '2026-11-13 02:17:19');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'XII RPL 1', 'XII', 'Rekayasa Perangkat Lunak', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(2, 'XII RPL 2', 'XII', 'Rekayasa Perangkat Lunak', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(128, 1, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(129, 2, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(130, 3, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(131, 4, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(132, 5, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(133, 6, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(134, 7, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(135, 8, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(136, 9, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(137, 10, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(138, 11, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(139, 12, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(140, 13, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(141, 14, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(142, 15, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(143, 16, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(144, 17, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(145, 18, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(146, 19, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(147, 20, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(148, 21, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(149, 22, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(150, 23, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(151, 24, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(152, 25, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(153, 26, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(154, 27, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(155, 28, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(156, 29, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(157, 30, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(158, 31, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(159, 32, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(160, 33, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(161, 34, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(162, 35, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(163, 36, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(164, 37, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(165, 38, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(166, 39, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(167, 40, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(168, 41, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(169, 42, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(170, 43, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(171, 44, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(172, 45, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(173, 46, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(174, 47, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(175, 48, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(176, 49, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(177, 50, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(178, 51, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(179, 52, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(180, 53, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(181, 54, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(182, 55, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(183, 56, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(184, 57, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(185, 58, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(186, 59, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(187, 60, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(188, 61, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(189, 62, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(190, 63, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(191, 64, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(192, 65, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(193, 66, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(194, 67, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(195, 68, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(196, 69, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(197, 70, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(198, 71, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(199, 72, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(200, 73, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(201, 74, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(202, 75, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(203, 76, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(204, 77, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(205, 78, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(206, 79, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(207, 80, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(208, 81, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(209, 82, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(210, 83, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(211, 84, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(212, 85, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(213, 86, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(214, 87, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(215, 88, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(216, 89, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(217, 90, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(218, 91, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(219, 92, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(220, 93, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(221, 94, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(222, 95, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(223, 96, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(224, 97, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(225, 98, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(226, 99, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(227, 100, 1, 2, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(228, 101, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(229, 102, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 07:16:16'),
(230, 103, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(231, 104, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 07:16:06'),
(232, 105, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(233, 106, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 07:15:55'),
(234, 107, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(235, 108, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 07:15:45'),
(236, 109, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(237, 110, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 07:15:33'),
(238, 111, 1, 1, '2026-07-01', '2027-06-30', 1, '2026-11-11 05:58:14', '2026-11-11 05:58:14'),
(255, 113, 55, 1, '0000-00-00', '0000-00-00', 1, '2026-11-13 01:54:11', '2026-11-13 01:54:28'),
(256, 114, 55, 2, '0000-00-00', '0000-00-00', 1, '2026-11-13 02:44:14', '2026-11-13 02:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'P001', 'Terlambat Masuk Sekolah', 7, 'Deskripsi pelanggaran nomor 1', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(2, 2, 'P002', 'Tidak Mengikuti Apel Pagi', 9, 'Deskripsi pelanggaran nomor 2', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(3, 3, 'P003', 'Tidak Mengikuti Upacara Bendera', 11, 'Deskripsi pelanggaran nomor 3', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(4, 4, 'P004', 'Meninggalkan Kelas Tanpa Izin', 13, 'Deskripsi pelanggaran nomor 4', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(5, 5, 'P005', 'Membolos Pelajaran', 15, 'Deskripsi pelanggaran nomor 5', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(6, 6, 'P006', 'Tidak Hadir Tanpa Keterangan', 17, 'Deskripsi pelanggaran nomor 6', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(7, 7, 'P007', 'Terlambat Kembali Setelah Istirahat', 19, 'Deskripsi pelanggaran nomor 7', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(8, 8, 'P008', 'Tidak Membawa Surat Izin', 21, 'Deskripsi pelanggaran nomor 8', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(9, 9, 'P009', 'Pulang Sebelum Waktunya Tanpa Izin', 23, 'Deskripsi pelanggaran nomor 9', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(10, 10, 'P010', 'Tidak Mengikuti Kegiatan Sekolah', 25, 'Deskripsi pelanggaran nomor 10', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(11, 11, 'P011', 'Memakai Seragam Tidak Sesuai Ketentuan', 27, 'Deskripsi pelanggaran nomor 11', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(12, 12, 'P012', 'Tidak Memakai Atribut Lengkap', 29, 'Deskripsi pelanggaran nomor 12', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(13, 13, 'P013', 'Rambut Tidak Sesuai Ketentuan', 31, 'Deskripsi pelanggaran nomor 13', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(14, 14, 'P014', 'Memakai Sepatu Tidak Sesuai Aturan', 33, 'Deskripsi pelanggaran nomor 14', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(15, 15, 'P015', 'Tidak Memakai Ikat Pinggang', 35, 'Deskripsi pelanggaran nomor 15', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(16, 16, 'P016', 'Memakai Aksesori Berlebihan', 37, 'Deskripsi pelanggaran nomor 16', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(17, 17, 'P017', 'Tidak Memakai Kaos Kaki', 39, 'Deskripsi pelanggaran nomor 17', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(18, 18, 'P018', 'Seragam Tidak Rapi', 41, 'Deskripsi pelanggaran nomor 18', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(19, 19, 'P019', 'Memakai Jaket Saat Pembelajaran Tanpa Izin', 43, 'Deskripsi pelanggaran nomor 19', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(20, 20, 'P020', 'Tidak Memakai Seragam Praktik', 45, 'Deskripsi pelanggaran nomor 20', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(21, 21, 'P021', 'Berbicara Tidak Sopan kepada Guru', 47, 'Deskripsi pelanggaran nomor 21', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(22, 22, 'P022', 'Mengganggu Teman Saat Pembelajaran', 49, 'Deskripsi pelanggaran nomor 22', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(23, 23, 'P023', 'Membuat Keributan di Kelas', 51, 'Deskripsi pelanggaran nomor 23', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(24, 24, 'P024', 'Berkata Kasar kepada Teman', 53, 'Deskripsi pelanggaran nomor 24', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(25, 25, 'P025', 'Tidak Menghormati Warga Sekolah', 55, 'Deskripsi pelanggaran nomor 25', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(26, 26, 'P026', 'Bertengkar dengan Teman', 57, 'Deskripsi pelanggaran nomor 26', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(27, 27, 'P027', 'Melakukan Perundungan', 59, 'Deskripsi pelanggaran nomor 27', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(28, 28, 'P028', 'Tidak Mengikuti Arahan Guru', 61, 'Deskripsi pelanggaran nomor 28', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(29, 29, 'P029', 'Menghina Teman', 63, 'Deskripsi pelanggaran nomor 29', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(30, 30, 'P030', 'Bermain Saat Pembelajaran', 65, 'Deskripsi pelanggaran nomor 30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(31, 31, 'P031', 'Tidak Mengerjakan Tugas', 67, 'Deskripsi pelanggaran nomor 31', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(32, 32, 'P032', 'Tidak Membawa Perlengkapan Belajar', 69, 'Deskripsi pelanggaran nomor 32', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(33, 33, 'P033', 'Menyontek Saat Ujian', 71, 'Deskripsi pelanggaran nomor 33', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(34, 34, 'P034', 'Mengumpulkan Tugas Terlambat', 73, 'Deskripsi pelanggaran nomor 34', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(35, 35, 'P035', 'Tidak Mengikuti Ulangan Tanpa Izin', 75, 'Deskripsi pelanggaran nomor 35', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(36, 36, 'P036', 'Mengganggu Kegiatan Praktikum', 77, 'Deskripsi pelanggaran nomor 36', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(37, 37, 'P037', 'Melanggar Tata Tertib Laboratorium', 79, 'Deskripsi pelanggaran nomor 37', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(38, 38, 'P038', 'Tidak Membawa Buku Pelajaran', 81, 'Deskripsi pelanggaran nomor 38', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(39, 39, 'P039', 'Tidur Saat Pembelajaran', 83, 'Deskripsi pelanggaran nomor 39', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(40, 40, 'P040', 'Tidak Memperhatikan Penjelasan Guru', 85, 'Deskripsi pelanggaran nomor 40', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(41, 41, 'P041', 'Membuang Sampah Sembarangan', 87, 'Deskripsi pelanggaran nomor 41', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(42, 42, 'P042', 'Merusak Fasilitas Sekolah', 89, 'Deskripsi pelanggaran nomor 42', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(43, 43, 'P043', 'Mencoret Meja atau Dinding', 91, 'Deskripsi pelanggaran nomor 43', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(44, 44, 'P044', 'Tidak Melaksanakan Piket Kelas', 93, 'Deskripsi pelanggaran nomor 44', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(45, 45, 'P045', 'Mengotori Ruang Kelas', 95, 'Deskripsi pelanggaran nomor 45', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(46, 46, 'P046', 'Membawa Rokok ke Sekolah', 97, 'Deskripsi pelanggaran nomor 46', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(47, 47, 'P047', 'Merokok di Lingkungan Sekolah', 99, 'Deskripsi pelanggaran nomor 47', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(48, 48, 'P048', 'Menggunakan HP Tanpa Izin Saat Pelajaran', 101, 'Deskripsi pelanggaran nomor 48', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(49, 49, 'P049', 'Membawa Barang Terlarang', 103, 'Deskripsi pelanggaran nomor 49', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(50, 50, 'P050', 'Keluar Sekolah Tanpa Izin', 105, 'Deskripsi pelanggaran nomor 50', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(51, 1, 'P999', 'hhhh', 45454, '', 1, '2026-11-13 02:53:57', '2026-11-13 02:53:57'),
(52, 1, 'P999', 'hhhh', 4, '', 1, '2026-11-13 03:04:00', '2026-11-13 03:04:00'),
(53, 6, 'P999', 'yryr', 334, '', 1, '2026-11-13 03:07:25', '2026-11-13 03:07:25'),
(54, 7, 'P999', 'dd', 11, '', 1, '2026-11-13 03:09:08', '2026-11-13 03:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Keterlambatan', 'Diberikan teguran dan pembinaan oleh wali kelas.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(2, 'Ketidakhadiran', 'Diberikan teguran dan pembinaan oleh wali kelas.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(3, 'Membolos', 'Diberikan teguran dan pembinaan oleh wali kelas.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(4, 'Tidak Mengikuti Upacara', 'Diberikan teguran dan pembinaan oleh wali kelas.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(5, 'Keluar Tanpa Izin', 'Diberikan teguran dan pembinaan oleh wali kelas.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(6, 'Atribut Seragam', 'Diberikan teguran dan diminta melengkapi ketentuan sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(7, 'Kerapian Rambut', 'Diberikan teguran dan diminta melengkapi ketentuan sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(8, 'Kelengkapan Seragam', 'Diberikan teguran dan diminta melengkapi ketentuan sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(9, 'Pelanggaran Alas Kaki', 'Diberikan teguran dan diminta melengkapi ketentuan sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(10, 'Penggunaan Aksesori', 'Diberikan teguran dan diminta melengkapi ketentuan sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(11, 'Ketidaksopanan', 'Diberikan pembinaan oleh guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(12, 'Perkataan Tidak Pantas', 'Diberikan pembinaan oleh guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(13, 'Mengganggu Pembelajaran', 'Diberikan pembinaan oleh guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(14, 'Perkelahian', 'Diberikan pembinaan oleh guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(15, 'Perundungan', 'Diberikan pembinaan oleh guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(16, 'Pelanggaran Tata Tertib', 'Diberikan surat peringatan dan pembinaan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(17, 'Merokok', 'Diberikan surat peringatan dan pembinaan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(18, 'Membawa Barang Terlarang', 'Diberikan surat peringatan dan pembinaan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(19, 'Penggunaan HP', 'Diberikan surat peringatan dan pembinaan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(20, 'Penyalahgunaan Fasilitas', 'Diberikan surat peringatan dan pembinaan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(21, 'Tidak Mengerjakan Tugas', 'Diberikan tugas pembinaan oleh guru mata pelajaran.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(22, 'Menyontek', 'Diberikan tugas pembinaan oleh guru mata pelajaran.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(23, 'Tidak Membawa Buku', 'Diberikan tugas pembinaan oleh guru mata pelajaran.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(24, 'Tidak Mengikuti Ulangan', 'Diberikan tugas pembinaan oleh guru mata pelajaran.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(25, 'Mengganggu Praktikum', 'Diberikan tugas pembinaan oleh guru mata pelajaran.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(26, 'Pelanggaran Laboratorium', 'Diberikan teguran dan tanggung jawab memperbaiki kerusakan atau kebersihan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(27, 'Tidak Melaksanakan Piket', 'Diberikan teguran dan tanggung jawab memperbaiki kerusakan atau kebersihan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(28, 'Membuang Sampah', 'Diberikan teguran dan tanggung jawab memperbaiki kerusakan atau kebersihan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(29, 'Merusak Fasilitas', 'Diberikan teguran dan tanggung jawab memperbaiki kerusakan atau kebersihan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(30, 'Mencoret Properti Sekolah', 'Diberikan teguran dan tanggung jawab memperbaiki kerusakan atau kebersihan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(31, 'Meninggalkan Kelas', 'Diberikan teguran tertulis dan pembinaan kedisiplinan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(32, 'Tidur Saat Pelajaran', 'Diberikan teguran tertulis dan pembinaan kedisiplinan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(33, 'Bermain Saat Pelajaran', 'Diberikan teguran tertulis dan pembinaan kedisiplinan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(34, 'Tidak Memperhatikan Guru', 'Diberikan teguran tertulis dan pembinaan kedisiplinan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(35, 'Membuat Keributan', 'Diberikan teguran tertulis dan pembinaan kedisiplinan.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(36, 'Pulang Sebelum Waktunya', 'Dilakukan pembinaan oleh wali kelas dan guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(37, 'Tidak Mengikuti Kegiatan Sekolah', 'Dilakukan pembinaan oleh wali kelas dan guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(38, 'Memakai Jaket Tanpa Izin', 'Dilakukan pembinaan oleh wali kelas dan guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(39, 'Tidak Memakai Seragam Praktik', 'Dilakukan pembinaan oleh wali kelas dan guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(40, 'Tidak Membawa Perlengkapan Praktik', 'Dilakukan pembinaan oleh wali kelas dan guru BK.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(41, 'Pelanggaran Keamanan', 'Pemanggilan orang tua dan pembinaan khusus.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(42, 'Mengambil Barang Orang Lain', 'Pemanggilan orang tua dan pembinaan khusus.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(43, 'Pemalsuan Surat Izin', 'Pemanggilan orang tua dan pembinaan khusus.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(44, 'Berbohong kepada Guru', 'Pemanggilan orang tua dan pembinaan khusus.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(45, 'Menghina Warga Sekolah', 'Pemanggilan orang tua dan pembinaan khusus.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(46, 'Berkeliaran Saat Pelajaran', 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(47, 'Menggunakan Kendaraan Tidak Tertib', 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(48, 'Parkir Tidak Sesuai Aturan', 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(49, 'Membawa Kendaraan Tanpa Izin', 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(50, 'Pelanggaran Berat', 'uiruitirui', 1, '2026-01-01 01:00:00', '2026-11-13 02:41:34'),
(51, 'Pelanggaran Berat', '', 0, '2026-11-13 02:43:09', '2026-11-13 02:43:09'),
(52, 'ururur', 'urtuirtitri', 0, '2026-11-13 02:43:21', '2026-11-13 02:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `nama_siswa` varchar(150) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `pelanggaran_id` int(11) NOT NULL,
  `nama_pelanggaran` varchar(150) NOT NULL,
  `pelanggaran_kategori_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL,
  `poin` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran_siswa`
--

INSERT INTO `t_pelanggaran_siswa` (`id`, `tahun_ajaran_id`, `siswa_id`, `nama_siswa`, `kelas_id`, `nama_kelas`, `pelanggaran_id`, `nama_pelanggaran`, `pelanggaran_kategori_id`, `guru_id`, `nama_guru`, `tanggal`, `keterangan`, `poin`, `tindakan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Adittia Nur Lantip', 1, '10 RPL 1', 1, 'Terlambat Masuk Sekolah', 1, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-01', 'Terlambat datang ke gerbang sekolah', 7, 'Diberikan teguran dan pembinaan oleh wali kelas.', 'Selesai', '2026-11-10 16:46:42', '2026-11-10 16:46:42'),
(2, 1, 2, 'Agnia Rosya Noerillah', 4, '10 BDPM 1', 2, 'Tidak Mengikuti Apel Pagi', 2, 2, 'Ai Nuryaidah, S.Pd', '2026-11-02', 'Tidak ikut baris saat apel', 9, 'Diberikan teguran dan pembinaan oleh wali kelas.', 'Selesai', '2026-11-10 16:46:42', '2026-11-10 16:46:42'),
(3, 1, 3, 'Anisa Amirulla', 11, '11 RPL 3', 3, 'Tidak Mengikuti Upacara Bendera', 3, 4, 'Ansor Muhajir, S.T', '2026-11-03', 'Membolos saat upacara', 11, 'Diberikan pembinaan oleh guru BK.', 'Selesai', '2026-11-10 16:46:42', '2026-11-10 16:46:42'),
(4, 1, 4, 'Aradea Kandi', 16, '10 RPL 4', 4, 'Meninggalkan Kelas Tanpa Izin', 4, 5, 'Ari Sandriana, S.Kom', '2026-11-04', 'Keluar kelas ketika jam pelajaran berlangsung', 13, 'Diberikan teguran tertulis.', 'Selesai', '2026-11-10 16:46:42', '2026-11-10 16:46:42'),
(5, 1, 5, 'Arfa Diesa Okmaleliza', 19, '10 BDPM 4', 5, 'Membolos Pelajaran', 5, 6, 'Arif Kusmawan, S.Pd', '2026-11-05', 'Tidak masuk di jam pelajaran terakhir', 15, 'Pemanggilan orang tua.', 'Selesai', '2026-11-10 16:46:42', '2026-11-10 16:46:42'),
(8, 1, 1, 'Adittia Nur Lantip', 1, 'XII RPL 1', 11, 'Memakai Seragam Tidak Sesuai Ketentuan', 11, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', 'iiiii', 27, 'iiiiiiiiii', 'Selesai', '2026-11-11 08:22:31', '2026-11-11 08:22:31'),
(9, 1, 88, 'Alfin Rahadian', 2, 'XII RPL 2', 30, 'Bermain Saat Pembelajaran', 30, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', 'iiiii', 65, 'Diberikan teguran dan tanggung jawab memperbaiki kerusakan atau kebersihan.', 'Selesai', '2026-11-11 08:28:10', '2026-11-11 08:28:10'),
(10, 1, 106, 'Nucky Andreas Febrian', 1, 'XII RPL 1', 50, 'Keluar Sekolah Tanpa Izin', 50, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', 'iwww', 105, 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 'Selesai', '2026-11-11 08:28:53', '2026-11-11 08:28:53'),
(11, 1, 106, 'Nucky Andreas Febrian', 1, 'XII RPL 1', 50, 'Keluar Sekolah Tanpa Izin', 50, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', 'iiiiii', 105, 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 'Selesai', '2026-11-11 08:32:33', '2026-11-11 08:32:33'),
(12, 1, 106, 'Nucky Andreas Febrian', 1, 'XII RPL 1', 50, 'Keluar Sekolah Tanpa Izin', 50, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', 'aiii', 105, 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 'Selesai', '2026-11-11 08:34:50', '2026-11-11 08:34:50'),
(13, 1, 88, 'Alfin Rahadian', 2, 'XII RPL 2', 37, 'Melanggar Tata Tertib Laboratorium', 37, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', '', 79, 'Dilakukan pembinaan oleh wali kelas dan guru BK.', 'Selesai', '2026-11-11 08:46:34', '2026-11-11 08:46:34'),
(14, 1, 67, 'Fadli Muhammad Ramdhan', 1, 'XII RPL 1', 50, 'Keluar Sekolah Tanpa Izin', 50, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', '', 105, 'Diberikan sanksi sesuai tingkat pelanggaran dan tata tertib sekolah.', 'Selesai', '2026-11-11 08:59:47', '2026-11-11 08:59:47'),
(15, 1, 2, 'Agnia Rosya Noerillah', 2, 'XII RPL 2', 24, 'Berkata Kasar kepada Teman', 24, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-11', '', 53, 'Diberikan tugas pembinaan oleh guru mata pelajaran.', 'Selesai', '2026-11-11 09:59:26', '2026-11-11 09:59:26'),
(16, 1, 93, 'Azril Akbar Fawji Sedillah', 1, 'XII RPL 1', 21, 'Berbicara Tidak Sopan kepada Guru', 21, 1, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-13', '', 47, 'Diberikan tugas pembinaan oleh guru mata pelajaran.', 'Selesai', '2026-11-13 03:20:57', '2026-11-13 03:20:57');

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `nisn` varchar(15) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `kelas_id`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '1024105447', '8457485488', 'Adittia Nur Lantip', 1, 'L', '2010-01-15', 'Jl. Pendidikan No. 1, Tasikmalaya', 1, '2025-12-31 18:00:00', '2026-11-13 03:09:44'),
(2, '1024105450', '9889808990', 'Agnia Rosya Noerillah', 1, 'P', '2010-02-20', 'Jl. Pendidikan No. 2, Tasikmalaya', 1, '2026-02-01 18:00:00', '2026-11-13 03:14:08'),
(3, '102410546', '0102410546', 'Anisa Amirulla', 1, 'P', '2010-03-12', 'Jl. Pendidikan No. 3, Tasikmalaya', 1, '2026-03-02 18:00:00', '2026-03-02 18:00:00'),
(4, '102410547', '0102410547', 'Aradea Kandi', 1, 'L', '2010-04-25', 'Jl. Pendidikan No. 4, Tasikmalaya', 1, '2026-04-03 18:00:00', '2026-04-03 18:00:00'),
(5, '102410548', '0102410548', 'Arfa Diesa Okmaleliza', 1, 'P', '2010-05-18', 'Jl. Pendidikan No. 5, Tasikmalaya', 1, '2026-05-04 18:00:00', '2026-05-04 18:00:00'),
(6, '102410549', '0102410549', 'Fitri Nur Syami', 1, 'P', '2010-06-07', 'Jl. Pendidikan No. 6, Tasikmalaya', 1, '2026-06-05 18:00:00', '2026-06-05 18:00:00'),
(7, '102410550', '0102410550', 'Junita Putri Nur Rahman', 1, 'P', '2010-07-22', 'Jl. Pendidikan No. 7, Tasikmalaya', 1, '2026-07-06 18:00:00', '2026-07-06 18:00:00'),
(8, '102410551', '0102410551', 'Mohammad Atalarik Ali Syahbana', 1, 'L', '2010-08-14', 'Jl. Pendidikan No. 8, Tasikmalaya', 1, '2026-08-07 18:00:00', '2026-08-07 18:00:00'),
(9, '102410552', '0102410552', 'Muhammad Fahril Fahrurozi', 1, 'L', '2010-09-30', 'Jl. Pendidikan No. 9, Tasikmalaya', 1, '2026-09-08 18:00:00', '2026-09-08 18:00:00'),
(10, '102410750', '0102410750', 'Muhammad Adnan Syaeful Islami', 1, 'L', '2010-10-11', 'Jl. Pendidikan No. 10, Tasikmalaya', 1, '2026-10-09 18:00:00', '2026-10-09 18:00:00'),
(11, '102410553', '0102410553', 'Muhammad Zahru Aqila Fikri', 1, 'L', '2010-11-05', 'Jl. Pendidikan No. 11, Tasikmalaya', 1, '2026-11-10 18:00:00', '2026-11-10 18:00:00'),
(12, '102410554', '0102410554', 'Nadia Zulfa Soraya', 1, 'P', '2010-12-19', 'Jl. Pendidikan No. 12, Tasikmalaya', 1, '2026-12-11 18:00:00', '2026-12-11 18:00:00'),
(13, '102410555', '0102410555', 'Nazril Ilham', 1, 'L', '2011-01-08', 'Jl. Pendidikan No. 13, Tasikmalaya', 1, '2026-01-12 18:00:00', '2026-01-12 18:00:00'),
(14, '102410556', '0102410556', 'Puspita Dewi', 1, 'P', '2011-02-17', 'Jl. Pendidikan No. 14, Tasikmalaya', 1, '2026-02-13 18:00:00', '2026-02-13 18:00:00'),
(15, '102410558', '0102410558', 'Rakha Muhammad Naykal', 1, 'L', '2011-03-29', 'Jl. Pendidikan No. 15, Tasikmalaya', 1, '2026-03-14 18:00:00', '2026-03-14 18:00:00'),
(16, '102410559', '0102410559', 'Rani Melani', 1, 'P', '2011-04-13', 'Jl. Pendidikan No. 16, Tasikmalaya', 1, '2026-04-15 18:00:00', '2026-04-15 18:00:00'),
(17, '102410560', '0102410560', 'Reihan Muzaki', 1, 'L', '2011-05-21', 'Jl. Pendidikan No. 17, Tasikmalaya', 1, '2026-05-16 18:00:00', '2026-05-16 18:00:00'),
(18, '102410561', '0102410561', 'Resa Juliansah', 1, 'L', '2011-06-09', 'Jl. Pendidikan No. 18, Tasikmalaya', 1, '2026-06-17 18:00:00', '2026-06-17 18:00:00'),
(19, '102410562', '0102410562', 'Rizki Permata Sugianto', 1, 'L', '2011-07-27', 'Jl. Pendidikan No. 19, Tasikmalaya', 1, '2026-07-18 18:00:00', '2026-07-18 18:00:00'),
(20, '102410563', '0102410563', 'Sahira Firaj', 1, 'P', '2011-08-16', 'Jl. Pendidikan No. 20, Tasikmalaya', 1, '2026-08-19 18:00:00', '2026-08-19 18:00:00'),
(21, '102410564', '0102410564', 'Sendi Mardian', 1, 'L', '2011-09-04', 'Jl. Pendidikan No. 21, Tasikmalaya', 1, '2026-09-20 18:00:00', '2026-11-09 18:00:00'),
(22, '102410755', '0102410755', 'Shahaidan Nizzar', 1, 'L', '2011-10-23', 'Jl. Pendidikan No. 22, Tasikmalaya', 1, '2026-10-21 18:00:00', '2026-10-21 18:00:00'),
(23, '102410565', '0102410565', 'Sherly Satriani', 1, 'P', '2011-11-14', 'Jl. Pendidikan No. 23, Tasikmalaya', 1, '2026-11-22 18:00:00', '2026-11-22 18:00:00'),
(24, '102410566', '0102410566', 'Sofinurjanah', 1, 'P', '2011-12-02', 'Jl. Pendidikan No. 24, Tasikmalaya', 1, '2026-12-23 18:00:00', '2026-12-23 18:00:00'),
(25, '102410567', '0102410567', 'Suraiya Salsabila Azzahira', 1, 'P', '2010-01-28', 'Jl. Pendidikan No. 25, Tasikmalaya', 1, '2026-01-24 18:00:00', '2026-01-24 18:00:00'),
(26, '102410568', '0102410568', 'Toni Antonio', 1, 'L', '2010-02-11', 'Jl. Pendidikan No. 26, Tasikmalaya', 1, '2026-02-25 18:00:00', '2026-02-25 18:00:00'),
(27, '102611149', '0102611149', 'Abdul Malik Fajar', 1, 'L', '2009-01-12', 'Jl. Contoh Melati No. 1, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(28, '102611150', '0102611150', 'Agin Ginanjar Saputra', 1, 'L', '2009-03-21', 'Jl. Contoh Mawar No. 2, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(29, '102611151', '0102611151', 'Algi Athari', 1, 'L', '2009-05-14', 'Jl. Contoh Anggrek No. 3, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(30, '102611152', '0102611152', 'Arystya Apriliandi Franki', 1, 'L', '2009-07-09', 'Jl. Contoh Kenanga No. 4, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(31, '102611153', '0102611153', 'Billah Abdillah', 1, 'L', '2009-02-18', 'Jl. Contoh Dahlia No. 5, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(32, '102611154', '0102611154', 'Dhimas Dwi Ramadhan', 1, 'L', '2009-04-25', 'Jl. Contoh Teratai No. 6, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(33, '102611155', '0102611155', 'Fadil Ramdhani', 1, 'L', '2009-06-11', 'Jl. Contoh Flamboyan No. 7, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(34, '102611478', '0102611478', 'Faraz Fachri Muharram', 1, 'L', '2009-08-17', 'Jl. Contoh Cempaka No. 8, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(35, '102611157', '0102611157', 'Haikal Ilham Suhanda', 1, 'L', '2009-09-23', 'Jl. Contoh Kamboja No. 9, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(36, '102611158', '0102611158', 'Laodra Roba Ahfiana', 1, 'L', '2009-10-05', 'Jl. Contoh Cemara No. 10, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(37, '102611159', '0102611159', 'Lintang Febrian Maulana', 1, 'L', '2009-11-19', 'Jl. Contoh Pinus No. 11, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(38, '102611160', '0102611160', 'Lisan Dzakir Ramadhan', 1, 'L', '2009-12-08', 'Jl. Contoh Merpati No. 12, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(39, '102611161', '0102611161', 'Muhamad Abylah Azam', 1, 'L', '2010-01-16', 'Jl. Contoh Rajawali No. 13, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(40, '102611162', '0102611162', 'Muhamad Algiansyah', 1, 'L', '2010-02-22', 'Jl. Contoh Garuda No. 14, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(41, '102611163', '0102611163', 'Muhamad Azril Yasin', 1, 'L', '2010-03-13', 'Jl. Contoh Merak No. 15, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(42, '102611164', '0102611164', 'Muhamad Itshar', 1, 'L', '2010-04-27', 'Jl. Contoh Elang No. 16, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(43, '102611165', '0102611165', 'Muhamad Nasabandy', 1, 'L', '2010-05-09', 'Jl. Contoh Rajin No. 17, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(44, '102611166', '0102611166', 'Muhammad Adam Efathurrohman', 1, 'L', '2010-06-15', 'Jl. Contoh Sukamaju No. 18, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(45, '102611167', '0102611167', 'Muhammad Dzikri Abdul Jalil', 1, 'L', '2010-07-20', 'Jl. Contoh Sukaraja No. 19, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(46, '102611476', '0102611476', 'Muhammad Rafa Firmansyah', 1, 'L', '2010-08-11', 'Jl. Contoh Sukasari No. 20, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(47, '102611169', '0102611169', 'Muhammad Rizky Hidayatullah', 1, 'L', '2010-09-24', 'Jl. Contoh Cibereum No. 21, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(48, '102611170', '0102611170', 'Nasta Pratama Supriatna', 1, 'L', '2010-10-06', 'Jl. Contoh Cihideung No. 22, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(49, '102611171', '0102611171', 'Raditia Purnama', 1, 'L', '2010-11-18', 'Jl. Contoh Indihiang No. 23, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(50, '102611172', '0102611172', 'Rahmat Suparman', 1, 'L', '2010-12-12', 'Jl. Contoh Kawalu No. 24, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(51, '102611173', '0102611173', 'Rama Manramsyah Gustian Pratama', 1, 'L', '2009-02-05', 'Jl. Contoh Mangkubumi No. 25, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(52, '102611174', '0102611174', 'Rehan Nadi Saputra', 1, 'L', '2009-04-19', 'Jl. Contoh Tamansari No. 26, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(53, '102611175', '0102611175', 'Rof Rof Al Arof Subul Amin', 1, 'L', '2009-06-23', 'Jl. Contoh Singaparna No. 27, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(54, '102611176', '0102611176', 'Sandi Permana', 1, 'L', '2009-08-08', 'Jl. Contoh Manonjaya No. 28, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(55, '102611177', '0102611177', 'Tubagus Rizqi', 1, 'L', '2009-10-14', 'Jl. Contoh Rajapolah No. 29, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(56, '102611178', '0102611178', 'Wildan Nurjaman', 1, 'L', '2009-12-20', 'Jl. Contoh Cisayong No. 30, Tasikmalaya', 1, '2026-11-06 01:18:37', '2026-11-06 01:18:37'),
(57, '102410341', '0102410341', 'Adi Bayu Maulana Putra', 1, 'L', '2008-01-12', 'Jl. Melati, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(58, '102410343', '0102410343', 'Agan Basyri Sa\'ady', 1, 'L', '2008-02-15', 'Jl. Mawar, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(59, '102410344', '0102410344', 'Ali Rahmat Mutaqin', 1, 'L', '2008-03-21', 'Jl. Anggrek, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(60, '102410345', '0102410345', 'Alzi Kusnendi', 1, 'L', '2008-04-09', 'Jl. Kenanga, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(61, '102410346', '0102410346', 'Andika Nugraha', 1, 'L', '2008-05-17', 'Jl. Dahlia, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(62, '102410347', '0102410347', 'Andri Mabrur', 1, 'L', '2008-06-11', 'Jl. Teratai, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(63, '102410349', '0102410349', 'Dafa Ezar Ramadan', 1, 'L', '2008-07-23', 'Jl. Cempaka, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(64, '102410350', '0102410350', 'Defri Muhamad Ramadhan', 1, 'L', '2008-08-14', 'Jl. Cemara, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(65, '102410351', '0102410351', 'Deva Al Fauzan', 1, 'L', '2008-09-05', 'Jl. Merpati, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(66, '102410352', '0102410352', 'Dika Ardiansyah Putra', 1, 'L', '2008-10-19', 'Jl. Rajawali, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(67, '102410353', '0102410353', 'Fadli Muhammad Ramdhan', 1, 'L', '2008-11-08', 'Jl. Garuda, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(68, '102410354', '0102410354', 'Febi Danil Gunawan', 1, 'L', '2008-12-16', 'Jl. Merak, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(69, '102410355', '0102410355', 'Gabriel Alhazmi Adiyasa', 1, 'L', '2008-01-25', 'Jl. Elang, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(70, '102410356', '0102410356', 'Gisna Sufi Ginanjar', 1, 'L', '2008-02-27', 'Jl. Pinus, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(71, '102410358', '0102410358', 'Lutfi Indriawan', 1, 'L', '2008-03-13', 'Jl. Flamboyan, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(72, '102410359', '0102410359', 'Moch Alif Sayyandra Abipraya', 1, 'L', '2008-04-22', 'Jl. Sukamaju, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(73, '102410360', '0102410360', 'Muhamad Al Mu\'min Akbar', 1, 'L', '2008-05-06', 'Jl. Sukaraja, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(74, '102410361', '0102410361', 'Muhamad Rafi Ramdani', 1, 'L', '2008-06-18', 'Jl. Sukasari, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(75, '102410362', '0102410362', 'Muhamad Zulpi Zulkipli', 1, 'L', '2008-07-29', 'Jl. Cibeureum, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(76, '102410364', '0102410364', 'Muhammad Faisal Arrizal', 1, 'L', '2008-08-12', 'Jl. Cihideung, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(77, '102410366', '0102410366', 'Muhammad Rafliyatu Rizqi Nur Rohman', 1, 'L', '2008-09-24', 'Jl. Indihiang, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(78, '102410367', '0102410367', 'Muhammad Ridho Qushoiri', 1, 'L', '2008-10-07', 'Jl. Kawalu, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(79, '102410368', '0102410368', 'Raditia Nugraha', 1, 'L', '2008-11-15', 'Jl. Tamansari, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(80, '102410369', '0102410369', 'Raeval Legya Rachman', 1, 'L', '2008-12-03', 'Jl. Mangkubumi, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(81, '102410370', '0102410370', 'Rafa Azkia', 1, 'L', '2008-01-19', 'Jl. Singaparna, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(82, '102410371', '0102410371', 'Refan Sultansah', 1, 'L', '2008-02-08', 'Jl. Rajapolah, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(83, '102410372', '0102410372', 'Reihan Al Azhar', 1, 'L', '2008-03-26', 'Jl. Cisayong, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(84, '112510757', '0112510757', 'Sani Achmad Fikri', 1, 'L', '2008-04-16', 'Jl. Leuwisari, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(85, '102410373', '0102410373', 'Sendy Ramdhani', 1, 'L', '2008-05-28', 'Jl. Manonjaya, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(86, '102410374', '0102410374', 'Surahman Wahdan Andika', 1, 'L', '2008-06-09', 'Jl. Salawu, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(87, '102410375', '0102410375', 'Tahmid Hidayatulloh', 1, 'L', '2008-07-17', 'Jl. Sukaratu, Tasikmalaya', 1, '2026-11-06 01:30:14', '2026-11-06 01:30:14'),
(88, '102410520', '0102410520', 'Alfin Rahadian', 1, 'L', '2008-01-12', 'Jl. Pendidikan No. 1', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(89, '102410521', '0102410521', 'Alisa Ramadhani', 1, 'P', '2008-02-15', 'Jl. Pendidikan No. 2', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(90, '102410522', '0102410522', 'Alma Aura Livia', 1, 'P', '2008-03-20', 'Jl. Pendidikan No. 3', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(91, '102410523', '0102410523', 'Anis Khoerunnisa Nur Ramadani', 1, 'P', '2008-04-18', 'Jl. Pendidikan No. 4', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(92, '102410524', '0102410524', 'Azmil Amira', 1, 'P', '2008-05-22', 'Jl. Pendidikan No. 5', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(93, '102410525', '0102410525', 'Azril Akbar Fawji Sedillah', 1, 'L', '2008-06-10', 'Jl. Pendidikan No. 6', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(94, '102410527', '0102410527', 'Erlangga Saputra Hidayat', 1, 'L', '2008-07-14', 'Jl. Pendidikan No. 7', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(95, '102410528', '0102410528', 'Hilma Humma Tunnajah', 1, 'P', '2008-08-19', 'Jl. Pendidikan No. 8', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(96, '102410529', '0102410529', 'Ilma Najya', 1, 'P', '2008-09-12', 'Jl. Pendidikan No. 9', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(97, '102410531', '0102410531', 'Julianda Dharma Pangestu', 1, 'L', '2008-10-16', 'Jl. Pendidikan No. 10', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(98, '102410532', '0102410532', 'Kayla Nur Fadilah', 1, 'P', '2008-11-21', 'Jl. Pendidikan No. 11', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(99, '102410533', '0102410533', 'Moza Dina Nabillah', 1, 'P', '2008-12-09', 'Jl. Pendidikan No. 12', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(100, '102410534', '0102410534', 'Muhamad Alfarizi', 1, 'L', '2008-01-25', 'Jl. Pendidikan No. 13', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(101, '102410535', '0102410535', 'Muhamad Fahrin Adam', 1, 'L', '2008-02-27', 'Jl. Pendidikan No. 14', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(102, '102410536', '0102410536', 'Muhamad Zidane Maulidan', 1, 'L', '2008-03-16', 'Jl. Pendidikan No. 15', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(103, '102410537', '0102410537', 'Muhamad Zulfan Nuralfansyah', 1, 'L', '2008-04-24', 'Jl. Pendidikan No. 16', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(104, '102410538', '0102410538', 'Natiya Nur Azkiya', 1, 'P', '2008-05-13', 'Jl. Pendidikan No. 17', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(105, '102410539', '0102410539', 'Novita Puspitasari', 1, 'P', '2008-06-29', 'Jl. Pendidikan No. 18', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(106, '102410540', '0102410540', 'Nucky Andreas Febrian', 1, 'L', '2008-07-08', 'Jl. Pendidikan No. 19', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(107, '102410543', '0102410543', 'Raditya Jeti Prasetya', 1, 'L', '2008-08-26', 'Jl. Pendidikan No. 20', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(108, '102410741', '0102410741', 'Rangga Ramadiyanto Nurhakim', 1, 'L', '2008-09-17', 'Jl. Pendidikan No. 21', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(109, '102410541', '0102410541', 'Risqi Muhamad Ihwani', 1, 'L', '2008-10-23', 'Jl. Pendidikan No. 22', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(110, '102410542', '0102410542', 'Salwa Sabilatul Barakah', 1, 'P', '2008-11-11', 'Jl. Pendidikan No. 23', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(111, '102410753', '0102410753', 'Tazkia Zahra', 1, 'P', '2008-12-20', 'Jl. Pendidikan No. 24', 1, '2026-11-06 01:57:08', '2026-11-06 01:57:08'),
(112, '8898989898', '0909090909', 'nono', 1, 'L', '0888-09-09', 'purbaratu', 1, '2026-11-13 01:35:23', '2026-11-13 01:35:23'),
(113, '0000000000', '0909009090', 'ijal', 2, 'L', '0777-03-09', 'kaala', 1, '2026-11-13 01:38:34', '2026-11-13 01:38:34'),
(114, '8887778988', '9898989899', 'mssrjuki', 1, 'L', '2922-03-20', 'iiiiwiwie', 1, '2026-11-13 01:55:35', '2026-11-13 01:58:06');

-- --------------------------------------------------------

--
-- Table structure for table `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2026/2027', '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(2, '2027/2028', '2027-07-01', '2028-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(3, '2028/2029', '2028-07-01', '2029-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(4, '2029/2030', '2029-07-01', '2030-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(5, '2030/2031', '2030-07-01', '2031-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(6, '2031/2032', '2031-07-01', '2032-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(7, '2032/2033', '2032-07-01', '2033-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(8, '2033/2034', '2033-07-01', '2034-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(9, '2034/2035', '2034-07-01', '2035-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(10, '2035/2036', '2035-07-01', '2036-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(11, '2036/2037', '2036-07-01', '2037-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(12, '2037/2038', '2037-07-01', '2038-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(13, '2038/2039', '2038-07-01', '2039-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(14, '2039/2040', '2039-07-01', '2040-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(15, '2040/2041', '2040-07-01', '2041-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(16, '2041/2042', '2041-07-01', '2042-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(17, '2042/2043', '2042-07-01', '2043-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(18, '2043/2044', '2043-07-01', '2044-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(19, '2044/2045', '2044-07-01', '2045-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(20, '2045/2046', '2045-07-01', '2046-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(21, '2046/2047', '2046-07-01', '2047-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(22, '2047/2048', '2047-07-01', '2048-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(23, '2048/2049', '2048-07-01', '2049-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(24, '2049/2050', '2049-07-01', '2050-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(25, '2050/2051', '2050-07-01', '2051-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(26, '2051/2052', '2051-07-01', '2052-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(27, '2052/2053', '2052-07-01', '2053-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(28, '2053/2054', '2053-07-01', '2054-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(29, '2054/2055', '2054-07-01', '2055-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(30, '2055/2056', '2055-07-01', '2056-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(31, '2056/2057', '2056-07-01', '2057-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(32, '2057/2058', '2057-07-01', '2058-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(33, '2058/2059', '2058-07-01', '2059-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(34, '2059/2060', '2059-07-01', '2060-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(35, '2060/2061', '2060-07-01', '2061-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(36, '2061/2062', '2061-07-01', '2062-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(37, '2062/2063', '2062-07-01', '2063-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(38, '2063/2064', '2063-07-01', '2064-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(39, '2064/2065', '2064-07-01', '2065-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(40, '2065/2066', '2065-07-01', '2066-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(41, '2066/2067', '2066-07-01', '2067-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(42, '2067/2068', '2067-07-01', '2068-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(43, '2068/2069', '2068-07-01', '2069-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(44, '2069/2070', '2069-07-01', '2070-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(45, '2070/2071', '2070-07-01', '2071-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(46, '2071/2072', '2071-07-01', '2072-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(47, '2072/2073', '2072-07-01', '2073-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(48, '2073/2074', '2073-07-01', '2074-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(49, '2074/2075', '2074-07-01', '2075-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(50, '2075/2076', '2075-07-01', '2076-06-30', 0, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(51, '2021/2022', '2021-07-01', '2022-06-30', 1, '2026-11-10 05:22:59', '2026-11-10 05:22:59'),
(52, '2022/2023', '2022-07-01', '2023-06-30', 1, '2026-11-10 05:22:59', '2026-11-10 05:22:59'),
(53, '2023/2024', '2023-07-01', '2024-06-30', 1, '2026-11-10 05:22:59', '2026-11-10 05:22:59'),
(54, '2024/2025', '2024-07-01', '2025-06-30', 1, '2026-11-10 05:22:59', '2026-11-10 05:22:59'),
(55, '2025/2026', '2025-07-01', '2026-06-30', 1, '2026-11-10 05:22:59', '2026-11-10 05:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `t_tindak_lanjut`
--

CREATE TABLE `t_tindak_lanjut` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL DEFAULT 0,
  `tahun_ajaran_id` int(11) NOT NULL DEFAULT 0,
  `tanggal_tindak_lanjut` date NOT NULL,
  `status` varchar(40) NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT current_timestamp(),
  `password` varchar(225) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, '', 'asep@gmail.com', '2026-11-13 02:17:19', 'asep12345', '', 'wali kelas', '2026-11-13 02:17:19', '2026-11-13 02:17:19'),
(2, 'Administrator', 'admin@gmail.com', '2026-11-13 02:21:13', 'admin12345', '', 'admin', '2026-11-13 02:21:13', '2026-11-13 02:21:13'),
(3, 'guru', 'guru@gmail.com', '2026-11-13 02:23:22', 'guru12345', '', 'guru', '2026-11-13 02:23:22', '2026-11-13 02:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(2, 2, 2, 0, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(3, 3, 3, 3, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(4, 4, 4, 4, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(6, 6, 6, 6, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(7, 7, 7, 7, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(8, 8, 8, 8, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(9, 9, 9, 9, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(10, 10, 10, 10, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(11, 11, 11, 11, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(12, 12, 12, 12, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(13, 13, 13, 13, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(14, 14, 14, 14, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(15, 15, 15, 15, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(16, 16, 16, 16, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(17, 17, 17, 17, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(18, 18, 18, 18, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(19, 19, 19, 19, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(20, 20, 20, 20, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(21, 21, 21, 21, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(22, 22, 22, 22, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(23, 23, 23, 23, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(24, 24, 24, 24, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(25, 25, 25, 25, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(26, 26, 26, 26, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(27, 27, 27, 27, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(28, 28, 28, 28, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(29, 29, 29, 29, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(30, 30, 30, 30, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(31, 31, 31, 31, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(32, 32, 32, 32, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(33, 33, 33, 33, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(34, 34, 34, 34, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(35, 35, 35, 35, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(36, 36, 36, 36, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(37, 37, 37, 37, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(38, 38, 38, 38, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(39, 39, 39, 39, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(40, 40, 40, 40, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(41, 41, 41, 41, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(42, 42, 42, 42, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(43, 43, 43, 43, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(44, 44, 44, 44, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(45, 45, 45, 45, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(46, 46, 46, 46, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(47, 47, 47, 47, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(48, 48, 48, 48, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(49, 49, 49, 49, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(50, 50, 50, 50, '2026-07-01', '2027-06-30', 1, '2026-01-01 01:00:00', '2026-09-23 01:00:00'),
(51, 1, 2, 53, '2026-07-01', '2027-06-30', 1, '2026-11-11 06:36:51', '2026-11-11 06:36:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indexes for table `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`),
  ADD KEY `kelas_id_2` (`kelas_id`),
  ADD KEY `pelanggaran_id_2` (`pelanggaran_id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_tindak_lanjut`
--
ALTER TABLE `t_tindak_lanjut`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tindak_lanjut_siswa` (`siswa_id`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `t_tindak_lanjut`
--
ALTER TABLE `t_tindak_lanjut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
