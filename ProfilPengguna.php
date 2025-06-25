<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil Pengguna - LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="profil.css" />
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

  <div class="container">
    <h2>Profil Pengguna</h2>
    <img src="profil.png" alt="Foto Profil" class="profile-pic" id="fotoProfil" />
    
    <div class="profile-info">
      <p><strong>Nama:</strong> <span id="nama"></span></p>
      <p><strong>NIM:</strong> <span id="nim"></span></p>
    </div>

    <div class="recent-activity">
      <h3>📌 Aktivitas Terakhir</h3>
      <ul>
        <li>📝 Laporan tentang kebersihan toilet (12 April 2025)</li>
        <li>📸 Unggah foto kerusakan AC di ruang kuliah A3 (5 April 2025)</li>
        <li>✅ Laporan "Kursi Rusak" telah diselesaikan (30 Maret 2025)</li>
      </ul>
    </div>
  </div>

  <footer>
    &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
  </footer>

  <script>
    // Ambil data dari localStorage
    document.getElementById('nama').textContent = localStorage.getItem('nama') || 'Nama tidak ditemukan';
    document.getElementById('nim').textContent = localStorage.getItem('nim') || 'NIM tidak ditemukan';

    const foto = localStorage.getItem('fotoProfil');
    if (foto) {
      document.getElementById('fotoProfil').src = foto;
    }
  </script>

</body>
</html>
