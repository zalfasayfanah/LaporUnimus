<?php
session_start();

if (!isset($_SESSION['nama']) || !isset($_SESSION['nim'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'Login.php';</script>";
    exit;
}

require 'koneksi.php';

$totalLaporan = '0';
$laporanSelesai = '0';
$laporanProses = '0';

if ($conn && !$conn->connect_error) {
    $queryTotal = $conn->query("SELECT COUNT(*) AS total FROM laporan");
    if ($queryTotal) $totalLaporan = $queryTotal->fetch_assoc()['total'];

    $querySelesai = $conn->query("SELECT COUNT(*) AS selesai FROM laporan WHERE status = 'Selesai'");
    if ($querySelesai) $laporanSelesai = $querySelesai->fetch_assoc()['selesai'];

    $queryProses = $conn->query("SELECT COUNT(*) AS proses FROM laporan WHERE status = 'Sedang diproses'");
    if ($queryProses) $laporanProses = $queryProses->fetch_assoc()['proses'];

    // Ambil 6 laporan bergambar terbaru
    $galeriLaporan = [];
    $queryGaleri = $conn->query("SELECT deskripsi, gambar FROM laporan WHERE gambar IS NOT NULL AND gambar != '' ORDER BY tanggal_kirim DESC LIMIT 6");
    if ($queryGaleri && $queryGaleri->num_rows > 0) {
        while ($row = $queryGaleri->fetch_assoc()) {
            $galeriLaporan[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f9f8;
      color: #333;
    }

    header {
      background-color: #007e6a;
      color: white;
      padding: 3rem 2rem;
      position: relative;
    }

    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    .logo {
      position: absolute;
      top: -4.2rem;
      left: 3rem;
      height: 230px;
    }

    .header-text {
      text-align: center;
      flex-grow: 1;
    }

    .header-text h1 {
      margin: 0;
      font-size: 2.5rem;
    }

    .header-text p {
      margin: 0;
      font-size: 1rem;
    }

    .profile-menu {
      position: relative;
      z-index: 1000;
    }

    .profile-icon {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      border: 2px solid white;
      cursor: pointer;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 70px;
      right: 0;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
      z-index: 999;
      min-width: 100px;
      text-align: center;
    }

    .logout-btn {
      background: none;
      border: none;
      color: #007e6a;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      padding: 10px;
      text-align: center;
      font-family: 'Poppins', sans-serif;
    }

    .logout-btn:hover {
      background-color: #f0f0f0;
    }

    nav {
      text-align: center;
      margin-top: 1rem;
    }

    nav a {
      margin: 0 1rem;
      color: #007e6a;
      text-decoration: none;
      font-weight: bold;
    }

    main {
      padding: 2rem;
    }

    .hero {
      display: flex;
      flex-direction: column;
      align-items: center;
      background: linear-gradient(to bottom right, #e5f6f3, #ffffff);
      padding: 2rem;
      border-radius: 10px;
    }

    .hero h1 {
      font-size: 2.5rem;
      color: #007e6a;
      margin-bottom: 1rem;
    }

    .hero p {
      max-width: 600px;
      text-align: center;
      font-size: 1.1rem;
    }

    .btn-lapor {
      margin-top: 2rem;
      background-color: #007e6a;
      color: white;
      padding: 0.8rem 2rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-lapor:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .statistik {
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin-top: 2rem;
      flex-wrap: wrap;
      text-align: center;
    }

    .statistik .box {
      background-color: #ffffff;
      border: 1px solid #cdeae3;
      border-radius: 10px;
      padding: 1rem 2rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      min-width: 150px;
    }

    .pengumuman, .kontak, .panduan, .alur-lapor, .testimoni, .progress, .partisipasi, .galeri-laporan {
      margin-top: 2rem;
      text-align: center;
    }

    .langkah {
      display: flex;
      justify-content: space-around;
      margin-top: 1rem;
    }

    .langkah div {
      text-align: center;
    }

    .progress-bar {
      width: 100%;
      background-color: #ddd;
      border-radius: 20px;
      overflow: hidden;
    }

    .progress-fill {
      width: 75%;
      background-color: #007e6a;
      color: white;
      text-align: center;
      padding: 0.5rem;
    }

    .galeri-laporan {
      margin-top: 3rem;
      text-align: center;
    }

    .galeri-laporan h3 {
      margin-bottom: 1rem;
      color: #007e6a;
    }

    .galeri-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      justify-content: center;
    }

    .galeri-item {
      background-color: #fff;
      border: 2px solid #e0f2ef; /* FRAME */
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 126, 106, 0.1);
      overflow: hidden;
      padding: 1rem;
      width: 100%;
      max-width: 300px;
      transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
      position: relative;
    }
    .galeri-item:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 12px 24px rgba(0, 126, 106, 0.2);
      border-color: #00b798;
    }
    .galeri-item img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 0.5rem;
    }

    .galeri-item p {
      font-size: 0.95rem;
      color: #555;
    }

    .no-galeri {
      grid-column: 1 / -1;
      color: #777;
      font-style: italic;
    }


    footer {
      margin-top: 3rem;
      padding: 1rem;
      text-align: center;
      font-size: 0.9rem;
      color: #777;
    }
  </style>
</head>
<body>

<header class="main-header">
  <div class="header-container">
    <img src="Logo1.png" alt="Logo Lapor Unimus" class="logo" />
    <div class="header-text">
      <h1>LaporUnimus</h1>
      <p>Suara Mahasiswa, Aksi Nyata untuk Kampus Lebih Baik</p>
    </div>
    <div class="profile-menu">
      <img src="profil.png" alt="Profil" class="profile-icon" id="profileIcon" />
      <div class="dropdown" id="dropdownMenu">
        <form action="Logout.php" method="post" style="margin: 0;">
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      </div>
    </div>
  </div>
</header>

<nav class="main-nav">
  <a href="LamanAwal.php">Beranda</a>
  <a href="KirimLaporan.php">Kirim Laporan</a>
  <a href="CekStatus.php">Cek Status</a>
  <a href="ProfilPengguna.php">Profil</a>
  <a href="Bantuan.php">Bantuan</a>
  <a href="Tentang.php">Tentang</a>
</nav>

<main>
<section class="hero">
  <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>!</h1>
  <p>LaporUnimus adalah platform pengaduan infrastruktur dan pelayanan publik di Universitas Muhammadiyah Semarang. Laporkan keluhanmu dengan mudah, aman, dan transparan – demi kenyamanan bersama!</p>
  <a href="KirimLaporan.php" class="btn-lapor">Kirim Laporan</a>

  <div class="statistik">
    <div class="box"><h2><?= $totalLaporan ?></h2><p>Total Laporan</p></div>
    <div class="box"><h2><?= $laporanSelesai ?></h2><p>Selesai Diproses</p></div>
    <div class="box"><h2><?= $laporanProses ?></h2><p>Menunggu Tindak Lanjut</p></div>
  </div>

  <div class="pengumuman">
    <h3>📢 Pengumuman Terbaru</h3>
    <p>Sistem LaporUnimus akan mengalami pemeliharaan pada tanggal 20 Mei 2025 pukul 21.00 – 23.00 WIB.</p>
  </div>

  <div class="kontak">
    <h3>📞 Kontak Dukungan</h3>
    <p>Hubungi via WhatsApp: <a href="https://wa.me/6281234567890">+62 812-3456-7890</a></p>
  </div>

  <div class="panduan">
    <h3>📘 Panduan Penggunaan</h3>
    <p>Lihat panduan lengkap <a href="https://drive.google.com/file/d/1FS2kDK5z3saRqiDAudhyNJ3gcF5cUTRe/view?usp=sharing" target="_blank">di sini</a>.</p>
  </div>

  <div class="alur-lapor">
    <h3>Bagaimana Cara Melapor?</h3>
    <div class="langkah">
      <div>📝<br>Kirim Laporan</div>
      <div>🔄<br>Diproses</div>
      <div>✅<br>Selesai</div>
    </div>
  </div>

  <div class="testimoni">
    <p><strong>"LaporUnimus sangat membantu. Keluhan saya langsung ditindak!"</strong><br>- Dina, Mahasiswa Unimus</p>
  </div>

  <div class="progress">
    <h3>📊 Progress Penyelesaian Laporan Anda</h3>
    <div class="progress-bar">
      <div class="progress-fill">75%</div>
    </div>
    <p><i>Status laporan terbaru: "Dalam tahap verifikasi oleh unit terkait"</i></p>
  </div>

  <div class="partisipasi">
    <h3>💪 Ayo Jadi Bagian dari Perubahan Positif!</h3>
    <p>Mahasiswa aktif = kampus berkembang! Yuk, sampaikan aspirasimu lewat LaporUnimus dan bantu ciptakan lingkungan kampus yang lebih baik!</p>
    <a href="KirimLaporan.php" class="btn-lapor" style="background-color: #fff; color: #007e6a;">Laporkan Sekarang</a>
  </div>

  <!-- GALERI -->
  <div class="galeri-laporan">
    <h3>🖼️ Galeri Laporan Terbaru</h3>
    <div class="galeri-grid">
      <?php foreach ($galeriLaporan as $laporan): ?>
        <div class="galeri-item">
          <img src="uploads/<?= htmlspecialchars($laporan['gambar']) ?>" alt="Laporan" />
          <p><?= htmlspecialchars($laporan['deskripsi']) ?></p>
        </div>
      <?php endforeach; ?>
      <?php if (empty($galeriLaporan)): ?>
        <p style="text-align:center; color:gray;">Belum ada laporan bergambar.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
</main>

<footer>
  &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
</footer>

<script>
  const profileIcon = document.getElementById('profileIcon');
  const dropdownMenu = document.getElementById('dropdownMenu');

  profileIcon.addEventListener('click', () => {
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', (event) => {
    if (!profileIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.style.display = 'none';
    }
  });
</script>

</body>
</html>
