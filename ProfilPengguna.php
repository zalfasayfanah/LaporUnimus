<?php
session_start();
if (!isset($_SESSION['nama']) || !isset($_SESSION['nim'])) {
  echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'Login.php';</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Pengguna - LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="Bantuan.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f9f8;
    }

    .main-header {
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

    .header-text {
      text-align: center;
      flex-grow: 1;
    }

    .logo {
      position: absolute;
      top: -4.2rem;
      left: 3rem;
      height: 230px;
    }

    .profile-menu {
      position: relative;
      z-index: 1000;
    }

    .profile-icon {
      width: 85px;
      height: 85px;
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

    .dropdown a {
      display: block;
      padding: 10px;
      color: #007e6a;
      text-decoration: none;
      font-weight: bold;
    }

    .dropdown a:hover {
      background-color: #f0f0f0;
    }

    nav.main-nav {
      text-align: center;
      background-color: transparent; /* Strip hijau muda dihilangkan */
      padding: 0.0rem 0;
    }

    nav.main-nav a {
      margin: 0 1rem;
      color: #007e6a;
      text-decoration: none;
      font-weight: bold;
    }

    .container {
      background: white;
      max-width: 800px;
      margin: 2rem auto;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    h2 {
      text-align: center;
      color: #007e6a;
    }

    .profile-pic {
      display: block;
      margin: 1rem auto;
      width: 130px;
      height: 130px;
      border-radius: 50%;
      border: 4px solid #007e6a;
      object-fit: cover;
    }

    .profile-info {
      text-align: center;
      font-size: 1.1rem;
      color: #333;
      margin-bottom: 2rem;
    }

    .recent-activity {
      margin-top: 2rem;
    }

    .recent-activity h3 {
      color: #007e6a;
      text-align: center;
      margin-bottom: 1rem;
    }

    .activity-list {
      list-style: none;
      padding: 0;
      margin: 0 auto;
      max-width: 600px;
    }

    .activity-list li {
      background-color: #e6f7f4;
      border: 1px solid #b3e0d3;
      margin-bottom: 1rem;
      padding: 1rem;
      border-radius: 10px;
      font-size: 1rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .activity-list li span {
      font-size: 1.2rem;
      margin-right: 0.5rem;
    }

    .activity-list li small {
      display: block;
      color: #555;
      font-size: 0.85rem;
      margin-top: 0.3rem;
      text-align: right;
    }

    footer {
      text-align: center;
      margin: 2rem 0;
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
      <img src="profil.png" alt="Profil" class="profile-icon" onclick="toggleDropdown()" />
      <div class="dropdown" id="dropdownMenu">
        <a href="Logout.php">Logout</a>
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

<div class="container">
  <h2>Profil Pengguna</h2>
  <img src="profil.png" alt="Foto Profil" class="profile-pic" id="fotoProfil" />

  <div class="profile-info">
    <p><strong>Nama:</strong> <?= htmlspecialchars($_SESSION['nama']) ?></p>
    <p><strong>NIM:</strong> <?= htmlspecialchars($_SESSION['nim']) ?></p>
  </div>

  <div class="recent-activity">
    <h3>📌 Aktivitas Terakhir</h3>
    <ul class="activity-list">
      <li>
        <span>📝</span> Laporan tentang kebersihan toilet
        <small>12 April 2025</small>
      </li>
      <li>
        <span>📸</span> Unggah foto kerusakan AC di ruang kuliah A3
        <small>5 April 2025</small>
      </li>
      <li>
        <span>✅</span> Laporan "Kursi Rusak" telah diselesaikan
        <small>30 Maret 2025</small>
      </li>
    </ul>
  </div>
</div>

<footer>
  &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
</footer>

<script>
  function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
  }

  document.addEventListener("click", function(e) {
    const dropdown = document.getElementById("dropdownMenu");
    const icon = document.querySelector(".profile-icon");
    if (!dropdown.contains(e.target) && !icon.contains(e.target)) {
      dropdown.style.display = "none";
    }
  });
</script>

</body>
</html>
