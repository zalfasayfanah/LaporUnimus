<?php
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
$tampil = mysqli_query($koneksi, "SELECT konten FROM tentang ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_assoc($tampil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang LaporUnimus</title>
  <link rel="stylesheet" href="tentang.css">
</head>
<body>
  <header>
    <img src="Logo1.png" class="logo" alt="Logo LaporUnimus">
    <h1>LaporUnimus</h1>
    <p>Suara Mahasiswa, Aksi Nyata untuk Kampus Lebih Baik</p>
  </header>

  <nav>
    <a href="LamanAwal.php">Beranda</a>
    <a href="KirimLaporan.php">Kirim Laporan</a>
    <a href="CekStatus.php">Cek Status</a>
    <a href="ProfilPengguna.php">Profil</a>
    <a href="Bantuan.php">Bantuan</a>
    <a href="tentang.php">Tentang</a>
  </nav>

  <main class="container">
    <?php echo $data['konten']; ?>
  </main>

  <footer>
    &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
  </footer>
</body>
</html>
