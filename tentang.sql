-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jul 2025 pada 07.10
-- Versi server: 8.0.40
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lapor_unimus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tentang`
--

CREATE TABLE `tentang` (
  `id` int NOT NULL,
  `konten` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tentang`
--

INSERT INTO `tentang` (`id`, `konten`) VALUES
(1, '<h1 style=\"text-align:center\">Selamat Datang di LaporUnimus</h1>\r\n\r\n<p style=\"text-align:center\"><strong>LaporUnimus</strong> merupakan sebuah inisiatif strategis dari Universitas Muhammadiyah Semarang (Unimus) yang dirancang untuk mewujudkan transparansi, akuntabilitas, dan pelayanan prima dalam lingkungan akademik. Layanan ini hadir sebagai bentuk nyata komitmen Unimus terhadap tata kelola yang baik (good governance) dan partisipasi aktif seluruh civitas akademika. Melalui platform ini, mahasiswa, dosen, tenaga kependidikan, hingga masyarakat umum diberikan ruang terbuka untuk menyampaikan masukan, keluhan, laporan pelanggaran, maupun aspirasi terkait berbagai aspek di kampus&mdash;mulai dari proses pembelajaran, kualitas fasilitas, pelayanan administrasi, hingga dinamika interaksi di lingkungan akademik. LaporUnimus menjadi kanal penting yang memudahkan komunikasi dua arah antara institusi dan publik, sekaligus mengokohkan nilai-nilai keterbukaan dan kepercayaan.</p>\r\n\r\n<p style=\"text-align:center\"><img alt=\"\" src=\"uploads/6870be8f59aac_unimus.jpg\" style=\"height:192px; width:256px\" /></p>\r\n\r\n<p style=\"text-align:center\">Setiap laporan yang masuk akan ditangani secara profesional oleh tim internal khusus yang berkomitmen pada prinsip kecepatan, kerahasiaan, dan ketuntasan. Sistem penanganan laporan ini memastikan adanya kejelasan status serta tindak lanjut konkret yang dapat dipantau hingga proses penyelesaian akhir. Tak hanya menjadi media pengaduan, LaporUnimus juga berperan sebagai instrumen kontrol internal yang mendorong perbaikan berkelanjutan di berbagai lini layanan kampus. Dengan demikian, platform ini tidak hanya memperkuat budaya keterbukaan di lingkungan Unimus, tetapi juga menjadi landasan penting dalam membangun kampus yang responsif, bertanggung jawab, dan semakin terpercaya di mata publik.</p>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tentang`
--
ALTER TABLE `tentang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tentang`
--
ALTER TABLE `tentang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
