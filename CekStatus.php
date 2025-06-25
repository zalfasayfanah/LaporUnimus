<?php
$koneksi = mysqli_connect("localhost:3307", "root", "", "lapor_unimus");

$hasil = null;
$kodeDicari = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kode'])) {
    $kodeDicari = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $query = "SELECT * FROM laporan WHERE kode_laporan = '$kodeDicari'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result) > 0) {
        $hasil = mysqli_fetch_assoc($result);
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
      text-align: center;
    }
    .logo {
      position: absolute;
      top: -1.4rem;
      left: 3rem;
      height: 230px;
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
      max-width: 600px;
      margin: 2rem auto;
      background-color: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h2 {
      color: #007e6a;
      text-align: center;
    }

    label {
      display: block;
      margin-top: 1rem;
      font-weight: bold;
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
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 12px rgba(0, 126, 106, 0.3);
    }


    .result {
      margin-top: 2rem;
      padding: 1rem;
      border-radius: 8px;
      background-color: #e6f7f4;
      border-left: 5px solid #007e6a;
    }

    .status {
      font-weight: bold;
      margin-top: 0.5rem;
    }

    .container + .container {
      margin-top: 3rem;
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

  <!-- Kotak 1: Form Cek Status -->
  <div class="container">
    <h2>Cek Status Laporan Anda</h2>
      <form id="statusForm" method="post">
  <label for="kode">Masukkan Kode Laporan:</label>
  <input type="text" id="kode" name="kode" value="<?= htmlspecialchars($kodeDicari) ?>" placeholder="Contoh: UNIMUS2025-001" required />
  <button type="submit">Cek Sekarang</button>
</form>
    <?php if ($hasil): ?>
  <div class="result">
    <p><strong>Nama:</strong> <?= htmlspecialchars($hasil['nama_lengkap']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($hasil['email']) ?></p>
    <p><strong>Jenis Laporan:</strong> <?= htmlspecialchars($hasil['kategori']) ?></p>
    <p><strong>Isi Laporan:</strong> <?= htmlspecialchars($hasil['deskripsi']) ?></p>
    <p><strong>Status:</strong> 
      <span class="status 
        <?= ($hasil['status'] == 'Selesai') ? 'done' : (($hasil['status'] == 'Sedang diproses') ? 'in-progress' : 'pending') ?>">
        <?= htmlspecialchars($hasil['status']) ?>
      </span>
    </p>
  </div>
<?php elseif (!empty($kodeDicari)): ?>
  <p style="color:red; margin-top: 1rem;">Kode laporan tidak ditemukan. Pastikan kode benar.</p>
<?php endif; ?>


    <div class="result" id="hasilStatus" style="display: none;">
      <p><strong>Jenis Laporan:</strong> <span id="jenisLaporan">Pengaduan</span></p>
      <p><strong>Isi Laporan:</strong> <span id="isiLaporan">AC di ruang D5-201 tidak menyala.</span></p>
      <p><strong>Status:</strong> <span id="status" class="status in-progress">Sedang diproses</span></p>
    </div>
  </div>

  <!-- Kotak 2: Riwayat Laporan -->
  <div class="container">
    <h2>Riwayat Laporan Anda</h2>
    <div id="riwayatLaporan">
      <!-- Diisi otomatis oleh JavaScript -->
    </div>
  </div>


  <footer>
    &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
  </footer>
</body>
</html>
