<?php
session_start();

// Cek login
if (!isset($_SESSION['nama']) || !isset($_SESSION['nim'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'Login.php';</script>";
    exit;
}

// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nama = $_SESSION['nama'];
$nim = $_SESSION['nim'];

// Ambil semua laporan user
$queryAll = "SELECT * FROM laporan WHERE nama_lengkap = '$nama' AND nim = '$nim' ORDER BY tanggal_kirim DESC";
$resultAll = mysqli_query($koneksi, $queryAll);

$daftarLaporan = [];
if ($resultAll && mysqli_num_rows($resultAll) > 0) {
    while ($row = mysqli_fetch_assoc($resultAll)) {
        $daftarLaporan[] = $row;
    }
}

// Jika cari berdasarkan kode
$hasil = null;
$kodeDicari = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kode'])) {
    $kodeDicari = trim(mysqli_real_escape_string($koneksi, $_POST['kode']));
    $queryKode = "SELECT * FROM laporan WHERE kode_laporan = '$kodeDicari'";
    $resultKode = mysqli_query($koneksi, $queryKode);
    if ($resultKode && mysqli_num_rows($resultKode) > 0) {
        $hasil = mysqli_fetch_assoc($resultKode);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cek Status | LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f9f8;
      margin: 0;
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
      text-decoration: none;
      color: #007e6a;
      font-weight: bold;
    }

    .container {
      max-width: 800px;
      margin: 2rem auto;
      background-color: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h2 {
      color: #007e6a;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 1rem;
    }

    input[type="text"] {
      width: 100%;
      padding: 0.8rem;
      margin-top: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    button {
      background-color: #007e6a;
      color: white;
      padding: 0.8rem 1.5rem;
      border: none;
      border-radius: 8px;
      margin-top: 1rem;
      cursor: pointer;
      display: block;
      width: 100%;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    button:hover {
      background-color: #005f52;
    }

    .result {
      margin-bottom: 2rem;
      padding: 1rem;
      border-radius: 8px;
      background-color: #e6f7f4;
      border-left: 5px solid #007e6a;
    }

    .status {
      font-weight: bold;
    }

    .done { color: green; }
    .in-progress { color: orange; }
    .pending { color: red; }

    footer {
      margin-top: 3rem;
      text-align: center;
      padding: 1rem;
      font-size: 0.9rem;
      color: #777;
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

<!-- Form Cek Kode -->
<div class="container">
  <h2>Cek Status Laporan via Kode</h2>
  <form method="post">
    <label for="kode">Masukkan Kode Laporan:</label>
    <input type="text" name="kode" id="kode" value="<?= htmlspecialchars($kodeDicari) ?>" placeholder="Contoh: UNIMUS2025-001" required />
    <button type="submit">🔍 Cek Laporan</button>
  </form>

  <?php if ($hasil): ?>
    <div class="result">
      <p><strong>Nama:</strong> <?= htmlspecialchars($hasil['nama_lengkap']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($hasil['email']) ?></p>
      <p><strong>Kategori:</strong> <?= htmlspecialchars($hasil['kategori']) ?></p>
      <p><strong>Deskripsi:</strong> <?= htmlspecialchars($hasil['deskripsi']) ?></p>
      <p><strong>Status:</strong> 
        <span class="status <?= ($hasil['status'] == 'Selesai') ? 'done' : (($hasil['status'] == 'Sedang diproses') ? 'in-progress' : 'pending') ?>">
          <?= htmlspecialchars($hasil['status']) ?>
        </span>
      </p>
    </div>
  <?php elseif (!empty($kodeDicari)): ?>
    <p style="color:red; text-align:center;">Kode laporan tidak ditemukan. Pastikan kode benar.</p>
  <?php endif; ?>
</div>

<!-- Riwayat Laporan -->
<div class="container">
  <h2>Riwayat Laporan Anda</h2>
  <?php if (count($daftarLaporan) > 0): ?>
    <?php foreach ($daftarLaporan as $laporan): ?>
      <div class="result">
        <p><strong>Kode:</strong> <?= htmlspecialchars($laporan['kode_laporan']) ?></p>
        <p><strong>Kategori:</strong> <?= htmlspecialchars($laporan['kategori']) ?></p>
        <p><strong>Deskripsi:</strong> <?= htmlspecialchars($laporan['deskripsi']) ?></p>
        <p><strong>Status:</strong> 
          <span class="status 
            <?= ($laporan['status'] == 'Selesai') ? 'done' : (($laporan['status'] == 'Sedang diproses') ? 'in-progress' : 'pending') ?>">
            <?= htmlspecialchars($laporan['status']) ?>
          </span>
        </p>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p style="text-align:center;">Belum ada laporan yang Anda kirim.</p>
  <?php endif; ?>
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
