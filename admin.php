<?php
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $id = $_POST['id_laporan'];
    $status_baru = $_POST['status'];
    $query = "UPDATE laporan SET status = '$status_baru' WHERE id_laporan = $id";
    mysqli_query($koneksi, $query);
}

$kategori_result = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM laporan ORDER BY kategori ASC");
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
      padding-bottom: 2rem;
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
      top: -3.5rem;
      left: 1.5rem;
      height: 220px;
      width: 220px;
      object-fit: contain;
      aspect-ratio: 1 / 1;
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
      object-fit: cover;
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

    footer {
      text-align: center;
      margin-top: 3rem;
      padding: 1rem;
      color: #777;
    }
  </style>
  <script>
    function toggleDropdown() {
      const menu = document.getElementById("dropdownMenu");
      menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
      if (!event.target.matches('.profile-icon')) {
        const dropdown = document.getElementById("dropdownMenu");
        if (dropdown && dropdown.style.display === "block") {
          dropdown.style.display = "none";
        }
      }
    }
  </script>
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
      <img src="profil.png" alt="Profil" class="profile-icon" onclick="toggleDropdown()" />
      <div class="dropdown" id="dropdownMenu">
        <a href="Logout.php">Logout</a>
      </div>
    </div>
  </div>
</header>

<nav>
  <a href="AdminEditTentang.php">Edit Tentang</a>
  <a href="admin.php">Kelola Laporan</a>
</nav>

<?php while ($kategori = mysqli_fetch_assoc($kategori_result)) :
    $nama_kategori = $kategori['kategori'];
    $laporan_per_kategori = mysqli_query($koneksi, "SELECT * FROM laporan WHERE kategori = '$nama_kategori' ORDER BY tanggal_kirim DESC");
?>
<div class="container">
  <h2>Kategori: <?= htmlspecialchars($nama_kategori) ?></h2>
  <table>
    <thead>
      <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Deskripsi</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Gambar</th>
        <th>Ubah Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($laporan_per_kategori)) : ?>
        <tr>
          <td><?= $row['kode_laporan'] ?></td>
          <td><?= $row['nama_lengkap'] ?></td>
          <td><?= $row['email'] ?></td>
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
<?php endwhile; ?>

<footer>
  &copy; 2025 LaporUnimus. Panel Admin.
</footer>

</body>
</html>
