-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: lapor_unimus
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `laporan`
--

DROP TABLE IF EXISTS `laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_laporan` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kategori` enum('infrastruktur','layanan','kebersihan','aspirasi','lainnya') NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('Belum diproses','Sedang diproses','Selesai') DEFAULT 'Belum diproses',
  `tanggal_kirim` timestamp NOT NULL DEFAULT current_timestamp(),
  `nim` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_laporan`),
  UNIQUE KEY `kode_laporan` (`kode_laporan`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laporan`
--

LOCK TABLES `laporan` WRITE;
/*!40000 ALTER TABLE `laporan` DISABLE KEYS */;
INSERT INTO `laporan` VALUES (3,'LPR-20250625-826','Zalfaa','zalfaa@gmail.com','kebersihan','Sabunnya di KM Wanita lantai 5 sering habis','685bf5145710b-Sabun habis.jpg','Sedang diproses','2025-06-25 13:09:40','C2C023074'),(6,'UNIMUS2025-004','Nesya Meilita','nesya@gmail.com','infrastruktur','Bangku taman GKB 2 rusak','UNIMUS2025-004_bangkutaman.jpg','Belum diproses','2025-06-29 09:56:11','C2C023054'),(10,'UNIMUS2025-008','Nesya Meilita','nesya@gmail.com','layanan','Server siamus sering error','UNIMUS2025-008_servererror.png','Belum diproses','2025-06-29 10:06:05','C2C023054'),(11,'LPR-20250629-925','Nesya Meilita','nesya@gmail.com','lainnya','Kucing nyasar','LPR-20250629-925_Kucing.jpg','Belum diproses','2025-06-29 10:11:41','C2C023054'),(12,'UNIMUS-20250630-805','Nesya Meilita','nesya@gmail.com','aspirasi','wifi NYA Kencengin donk','UNIMUS-20250630-805_wifi.png','Sedang diproses','2025-06-30 06:53:40','C2C023074');
/*!40000 ALTER TABLE `laporan` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-02 11:59:49
