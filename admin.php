<?php
$koneksi = mysqli_connect("localhost:3307", "root", "", "lapor_unimus");
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
  body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background-color: #f5f9f8;
  }

  /* ===== HEADER & LOGO ===== */
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

  /* ===== NAVIGASI (optional jika dipakai) ===== */
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

  /* ===== KONTEN UTAMA ===== */
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
  <img src="Logo1.png" alt="Logo Lapor Unimus" class="logo" />
  <div class="header-text">
    <h1>Panel Admin – LaporUnimus</h1>
    <p>Kelola Laporan yang Masuk</p>
  </div>
</header>



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
  <?php if ($row['gambar']): ?>
    <img src="uploads/<?= $row['gambar'] ?>" alt="Bukti" style="max-width: 120px; max-height: 80px; border-radius: 8px;" />
  <?php else: ?>
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

</body>
</html>
