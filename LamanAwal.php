<?php
session_start();

// Redirect jika belum login
if (!isset($_SESSION['nama']) || !isset($_SESSION['nim'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'Login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <style>
    /* ... (style tetap sama persis dengan punyamu) ... */
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
      text-align: center;
    }

    .logo {
      position: absolute;
      top: -1.4rem;
      left: 3rem;
      height: 230px;
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

    .header-container {
      text-align: center;
    }

    .header-text h1 {
      margin: 0;
      font-size: 2.5rem;
    }

    .header-text p {
      margin: 0;
      font-size: 1rem;
    }
    
    .hero {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 3rem 2rem;
      background: linear-gradient(to bottom right, #e5f6f3, #ffffff);
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
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-top: 2rem;
      background-color: #007e6a;
      color: white;
      padding: 0.8rem 2rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-lapor:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }

    .statistik {
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin-top: 2rem;
      text-align: center;
      flex-wrap: wrap;
    }

    .statistik .box {
      background-color: #ffffff;
      border: 1px solid #cdeae3;
      border-radius: 10px;
      padding: 1rem 2rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      min-width: 150px;
    }

    .pengumuman, .kontak, .panduan, .partisipasi {
      margin-top: 2rem;
      text-align: center;
      max-width: 700px;
    }

    .alur-lapor {
      text-align: center;
      margin-top: 3rem;
    }

    .alur-lapor h3 {
      color: #007e6a;
    }

    .langkah {
      display: flex;
      justify-content: center;
      gap: 3rem;
      font-size: 1.2rem;
      margin-top: 1rem;
      flex-wrap: wrap;
    }

    .testimoni {
      margin-top: 3rem;
      padding: 1rem 2rem;
      background-color: #e5f6f3;
      border-left: 5px solid #007e6a;
      font-style: italic;
      max-width: 600px;
      text-align: center;
    }

    .galeri {
      margin-top: 3rem;
      text-align: center;
    }

    .galeri img {
      width: 250px;
      margin: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .progress {
      margin-top: 3rem;
      text-align: center;
    }

    .progress-bar {
      width: 80%;
      background-color: #ddd;
      border-radius: 20px;
      margin: auto;
      overflow: hidden;
      margin-top: 1rem;
    }

    .progress-fill {
      height: 20px;
      width: 75%;
      background-color: #007e6a;
      color: white;
      text-align: center;
      line-height: 20px;
      border-radius: 20px;
    }

    .partisipasi {
      background-color: #007e6a;
      color: white;
      padding: 2rem;
      border-radius: 10px;
      margin-top: 3rem;
    }

    .partisipasi h3 {
      margin-top: 0;
    }

    footer {
      margin-top: 3rem;
      padding: 1rem;
      text-align: center;
      font-size: 0.9rem;
      color: #777;
    }

    .statistik .box:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      cursor: pointer;
    }

    .galeri img:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      cursor: pointer;
    }

  </style>
</head>
<body>

<header>
  <div class="header-container">
    <img src="Logo1.png" alt="Logo Lapor Unimus" class="logo" />
    <div class="header-text">
      <h1>LaporUnimus</h1>
      <p>Suara Mahasiswa, Aksi Nyata untuk Kampus Lebih Baik</p>
    </div>
  </div>
</header>

<nav>
  <a href="LamanAwal.php">Beranda</a>
  <a href="KirimLaporan.php">Kirim Laporan</a>
  <a href="CekStatus.php">Cek Status</a>
  <a href="ProfilPengguna.php">Profil</a>
  <a href="Bantuan.php">Bantuan</a>
  <a href="Tentang.php">Tentang</a>
</nav>

<section class="hero">
  <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h1>
  <p>LaporUnimus adalah platform pengaduan infrastruktur dan pelayanan publik di Universitas Muhammadiyah Semarang. Laporkan keluhanmu dengan mudah, aman, dan transparan – demi kenyamanan bersama!</p>
  <a href="KirimLaporan.php" class="btn-lapor">Kirim Laporan</a>

  <div class="statistik">
    <div class="box"><h2>124</h2><p>Total Laporan</p></div>
    <div class="box"><h2>90</h2><p>Selesai Diproses</p></div>
    <div class="box"><h2>34</h2><p>Menunggu Tindak Lanjut</p></div>
  </div>

  <div class="pengumuman">
    <h3>📢 Pengumuman Terbaru</h3>
    <p>Sistem LaporUnimus akan mengalami pemeliharaan pada tanggal 20 Mei 2025 pukul 21.00 – 23.00 WIB.</p>
  </div>

  <div class="kontak">
    <h3>📞 Kontak Dukungan</h3>
    <p>Butuh bantuan? Hubungi kami via WhatsApp: <a href="https://wa.me/6281234567890">+62 812-3456-7890</a></p>
  </div>

  <div class="panduan">
    <h3>📘 Panduan Penggunaan</h3>
    <p>Lihat panduan lengkap cara menggunakan LaporUnimus <a href="Panduan.html">di sini</a>.</p>
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

  <div class="galeri">
    <h3>🖼️ Galeri Foto Penanganan Laporan</h3>
    <img src="Foto 1 AC.jpeg" alt="Penanganan AC">
    <img src="Foto 2 KM.jpeg" alt="Penanganan Kamar mandi">
    <img src="Foto 3 Aspal.jpeg" alt="Penanganan Parkiran">
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
    <p>Mahasiswa aktif = kampus berkembang! Yuk, sampaikan aspirasimu lewat LaporUnimus dan bantu ciptakan lingkungan kampus yang lebih baik, bersih, dan nyaman untuk kita semua!</p>
    <a href="KirimLaporan.php" class="btn-lapor" style="background-color: #fff; color: #007e6a;">Laporkan Sekarang</a>
  </div>
</section>

<footer>
  &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
</footer>

</body>
</html>
