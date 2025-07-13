<?php
session_start();

if (!isset($_SESSION['nama']) || !isset($_SESSION['nim'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location.href = 'Login.php';</script>";
    exit;
}

$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Proses update status jika ada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $id = $_POST['id_laporan'];
    $status_baru = $_POST['status'];
    $query = "UPDATE laporan SET status = '$status_baru' WHERE id_laporan = $id";
    mysqli_query($koneksi, $query);
}

// Ambil semua laporan
$laporan = mysqli_query($koneksi, "SELECT * FROM laporan ORDER BY tanggal_kirim DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f9f8;
      color: #333;
    }
    header {
      background-color: #007e6a;
      color: white;
      padding: 1.5rem 2rem;
      position: relative;
      overflow: visible; 
    }
    .header-container {
      display: flex;
      align-items: center; 
      justify-content: space-between;
      padding: 1rem 2rem;
      background-color: #007e6a;
    }
    .logo {
      height: 140px;
      width: auto;
      transform: scale(2.2); 
      transform-origin: center left;
      margin-right: 2rem;
    }
    .header-text {
      flex-grow: 1;
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
      display: flex;
      justify-content: center;
      gap: 2rem;
      margin: 2rem 0;
    }

    nav a {
      text-decoration: none;
      color: #007e6a;
      font-weight: 600;
      font-size: 1.1rem;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .container {
      max-width: 95%;
      margin: 2rem auto;
      background: white;
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    h2 {
      color: #007e6a;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 0.75rem;
      text-align: left;
      font-size: 0.95rem;
    }

    th {
      background-color: #007e6a;
      color: white;
    }

    img {
      max-width: 100px;
    }

    select, button {
      padding: 0.5rem;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-family: 'Poppins', sans-serif;
    }

    button {
      background-color: #007e6a;
      color: white;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #005f52;
    }

    .done { color: green; }
    .in-progress { color: orange; }
    .pending { color: red; }

    footer {
      text-align: center;
      margin-top: 3rem;
      padding: 1rem;
      color: #777;
    }
  </style>
</head>
<body>

<header>
  <div class="header-container">
    <img src="Logo1.png" alt="Logo Lapor Unimus" class="logo" />
    <div class="header-text">
      <h1>Panel Admin – LaporUnimus</h1>
      <p>Kelola Laporan yang Masuk</p>
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

<nav>
  <a href="AdminEditTentang.php">Edit Tentang</a>
  <a href="admin.php">Kelola Laporan</a>
</nav>

<div class="container">
  <h2>Daftar Laporan Masuk</h2>
  <table>
    <thead>
      <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Kategori</th>
        <th>Deskripsi</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Gambar</th>
        <th>Ubah Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($laporan)) : ?>
        <tr>
          <td><?= $row['kode_laporan'] ?></td>
          <td><?= $row['nama_lengkap'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['kategori'] ?></td>
          <td><?= $row['deskripsi'] ?></td>
          <td><?= $row['status'] ?? 'Belum diproses' ?></td>
          <td><?= date('d-m-Y H:i', strtotime($row['tanggal_kirim'])) ?></td>
          <td>
            <?php if ($row['gambar']) : ?>
              <img src="uploads/<?= $row['gambar'] ?>" alt="Bukti" style="max-width: 120px; max-height: 80px; border-radius: 8px;" />
            <?php else : ?>
              <span style="color: #888;">(tidak ada)</span>
            <?php endif; ?>
          </td>
          <td>
            <form method="post" style="display:flex; gap: 0.5rem;">
              <input type="hidden" name="id_laporan" value="<?= $row['id_laporan'] ?>">
              <select name="status">
                <option value="Belum diproses" <?= $row['status'] == "Belum diproses" ? 'selected' : '' ?>>Belum diproses</option>
                <option value="Sedang diproses" <?= $row['status'] == "Sedang diproses" ? 'selected' : '' ?>>Sedang diproses</option>
                <option value="Selesai" <?= $row['status'] == "Selesai" ? 'selected' : '' ?>>Selesai</option>
              </select>
              <button type="submit" name="update_status">✔</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<footer>
  &copy; 2025 LaporUnimus. Panel Admin.
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
