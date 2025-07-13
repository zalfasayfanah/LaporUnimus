<?php
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $konten = mysqli_real_escape_string($koneksi, $_POST['konten']);
    mysqli_query($koneksi, "UPDATE tentang SET konten = '$konten' WHERE id = 1");
}

$result = mysqli_query($koneksi, "SELECT konten FROM tentang WHERE id = 1");

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}


$data = mysqli_fetch_assoc($result);
$konten = $data['konten'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Halaman Tentang</title>
  <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
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
      text-align: center;
      position: relative;
    }

    .logo {
      position: absolute;
      top: -1.4rem;
      left: 3rem;
      height: 230px;
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
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    h2 {
      color: #007e6a;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    textarea {
      width: 100%;
      border-radius: 8px;
      min-height: 300px;
    }

    button {
      background-color: #007e6a;
      color: white;
      padding: 0.8rem 1.6rem;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 600;
      margin-top: 1.5rem;
      transition: 0.3s;
    }

    button:hover {
      background-color: #005f52;
    }

    .info {
      font-size: 0.9rem;
      margin-top: 1rem;
      color: #555;
      background: #f7fbfa;
      padding: 0.8rem 1rem;
      border-left: 4px solid #007e6a;
      border-radius: 8px;
    }

    .info ul {
      margin: 0.5rem 0 0 1rem;
      padding: 0;
    }

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
    <p>Kelola Halaman Tentang</p>
  </div>
</header>

<nav>
  <a href="AdminEditTentang.php">Edit Tentang</a>
  <a href="admin.php">Kelola Laporan</a>
</nav>

<div class="container">
  <h2>Edit Konten Halaman Tentang</h2>

  <form method="post">
    <textarea name="konten"><?= htmlspecialchars($konten) ?></textarea>
    <button type="submit">💾 Simpan Perubahan</button>
  </form>

  <div class="info">
    <strong>Tips Penggunaan Editor:</strong>
    <ul>
      <li>Gunakan tombol <strong>gambar</strong> 🖼️ untuk unggah foto dari komputer.</li>
      <li>Gunakan alat <strong>rata kiri / kanan / tengah</strong> untuk atur posisi teks & gambar.</li>
      <li>Gunakan <strong>heading</strong> (judul besar) agar konten lebih rapi.</li>
    </ul>
  </div>
</div>

<footer>
  &copy; 2025 LaporUnimus. Panel Admin.
</footer>

<script>
  CKEDITOR.replace('konten', {
    height: 400,
    filebrowserUploadUrl: 'upload.php',
    filebrowserUploadMethod: 'form',
    removePlugins: 'elementspath',
    resize_enabled: false,
    toolbar: [
      { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
      { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight' ] },
      { name: 'styles', items: [ 'Format' ] },
      { name: 'insert', items: [ 'Image', 'Table' ] },
      { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
      { name: 'tools', items: [ 'Maximize' ] }
    ]
  });
</script>

</body>
</html>
