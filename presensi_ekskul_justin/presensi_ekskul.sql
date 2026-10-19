-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Okt 2026 pada 06.18
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi_ekskul_justin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi_ekskul`
--

CREATE TABLE `presensi_ekskul` (
  `id_presensi` int(11) NOT NULL,
  `nama_peserta` varchar(50) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `ekstrakurikuler` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit','Alpha') NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi_ekskul`
--

INSERT INTO `presensi_ekskul` (`id_presensi`, `nama_peserta`, `kelas`, `ekstrakurikuler`, `tanggal`, `status`, `keterangan`) VALUES
(2, 'Justin', 'XI RPL', 'Futsal', '2026-10-23', 'Hadir', ''),
(4, 'jojo', 'XI RPL', 'Futsal', '2026-10-19', 'Izin', ''),
(5, 'Chalvind', 'XI RPL', 'Musik', '2026-11-06', 'Hadir', ''),
(6, 'Adam', 'XI RPL', 'English', '2026-10-21', 'Hadir', ''),
(7, 'Wilson', 'XI RPL', 'Musik', '2026-10-19', 'Izin', 'Ujian'),
(8, 'Alex', 'XI RPL', 'English', '2026-10-21', 'Alpha', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `presensi_ekskul`
--
ALTER TABLE `presensi_ekskul`
  ADD PRIMARY KEY (`id_presensi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `presensi_ekskul`
--
ALTER TABLE `presensi_ekskul`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
