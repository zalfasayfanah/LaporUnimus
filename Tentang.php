<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
$tampil = mysqli_query($koneksi, "SELECT konten FROM tentang ORDER BY id DESC LIMIT 1");

if (!$tampil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($tampil);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tentang - LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f5f9f8;
      color: #333;
    }

    header.main-header {
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

    nav {
      text-align: center;
      margin: 1rem 0;
    }

    nav a {
      margin: 0 1rem;
      color: #007e6a;
      text-decoration: none;
      font-weight: bold;
    }

    main.container {
      max-width: 900px;
      margin: 2rem auto;
      padding: 2rem;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      font-size: 1.05rem;
      line-height: 1.8;
      text-align: justify;
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
    <img src="Logo1.png" alt="Logo LaporUnimus" class="logo" />
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

<nav>
  <a href="LamanAwal.php">Beranda</a>
  <a href="KirimLaporan.php">Kirim Laporan</a>
  <a href="CekStatus.php">Cek Status</a>
  <a href="ProfilPengguna.php">Profil</a>
  <a href="Bantuan.php">Bantuan</a>
  <a href="Tentang.php">Tentang</a>
</nav>

<main class="container">
  <?php echo $data['konten']; ?>
</main>

<footer>
  &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
</footer>

<script>
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
