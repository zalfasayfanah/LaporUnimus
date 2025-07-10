<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bantuan - LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="Bantuan.css" />
  <style>
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

    .main-header {
      background-color: #007e6a;
      color: white;
      padding: 3rem 2rem;
      position: relative;
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
  <h2>FAQ & Bantuan</h2>
  <div class="accordion">
    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        🔒 Lupa NIM?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Silakan hubungi admin fakultas atau gunakan tombol "Lupa NIM?" di halaman login.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        📝 Bagaimana cara membuat laporan?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Login terlebih dahulu, kemudian klik "Kirim Laporan" dan isi formulir yang tersedia.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        📊 Bagaimana mengetahui status laporan?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Masuk ke halaman "Cek Status" atau "Riwayat Laporan" setelah login.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        📧 Tidak menerima email konfirmasi?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Coba cek folder spam di email Anda. Jika masih belum ada, hubungi tim dukungan kami melalui kontak di halaman Tentang.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        🖼️ Bagaimana cara melampirkan bukti saat membuat laporan?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Saat mengisi formulir laporan, klik tombol "Upload Bukti" untuk menambahkan foto, dokumen, atau tangkapan layar sebagai lampiran.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        📅 Berapa lama waktu penanganan laporan?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Penanganan laporan umumnya membutuhkan waktu antara 1-7 hari kerja tergantung kompleksitas dan unit terkait.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        🆘 Saya mengalami kendala teknis, ke mana harus melapor?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Anda bisa menghubungi tim IT kampus melalui email resmi atau datang langsung ke pusat layanan informasi di lantai 1 Gedung Rektorat.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        ❓ Apakah laporan saya bersifat anonim?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Laporan tidak bersifat anonim, namun identitas Anda dijaga dan hanya dapat diakses oleh pihak berwenang yang menangani laporan tersebut.
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        🔄 Bisakah saya mengedit laporan setelah dikirim?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Setelah dikirim, laporan tidak bisa diedit. Namun Anda dapat mengirimkan laporan tambahan atau revisi melalui fitur "Tambahan Laporan".
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header" onclick="toggleAccordion(this)">
        📂 Di mana saya bisa melihat laporan-laporan saya sebelumnya?
        <span class="arrow">▶</span>
      </div>
      <div class="accordion-content">
        Masuk ke akun Anda dan buka halaman "Riwayat Laporan" untuk melihat daftar laporan yang pernah Anda buat.
      </div>
    </div>
  </div>
</div>

<footer>
  &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
</footer>

<script>
  function toggleAccordion(element) {
    const content = element.nextElementSibling;
    const arrow = element.querySelector(".arrow");
    content.classList.toggle("show");
    arrow.classList.toggle("rotate");
  }

  function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
  }

  document.addEventListener("click", function (e) {
    const dropdown = document.getElementById("dropdownMenu");
    const icon = document.querySelector(".profile-icon");
    if (!dropdown.contains(e.target) && !icon.contains(e.target)) {
      dropdown.style.display = "none";
    }
  });
</script>

</body>
</html>
