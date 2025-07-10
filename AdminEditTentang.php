<?php
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $konten = mysqli_real_escape_string($koneksi, $_POST['konten']);
    mysqli_query($koneksi, "UPDATE tentang SET konten = '$konten' WHERE id = 1");
    $sukses = "🎉 Konten berhasil diperbarui!";
}

$result = mysqli_query($koneksi, "SELECT konten FROM tentang WHERE id = 1");
$data = mysqli_fetch_assoc($result);
$konten = $data['konten'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Halaman Tentang</title>
  <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f4f3;
      color: #333;
      padding: 2rem;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 2rem 2.5rem;
      border-radius: 16px;
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.06);
    }
    h1 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      color: #007e6a;
      text-align: center;
    }
    textarea {
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 1rem;
      font-size: 1rem;
    }
    button {
      background-color: #007e6a;
      color: white;
      padding: 0.7rem 1.5rem;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 500;
      margin-top: 1.5rem;
      transition: background 0.3s;
    }
    button:hover {
      background-color: #005f51;
    }
    .sukses {
      background-color: #e6f7f4;
      color: #007e6a;
      border-left: 6px solid #007e6a;
      padding: 1rem;
      margin-bottom: 1.5rem;
      border-radius: 8px;
    }
    .toolbar-note {
      font-size: 0.85rem;
      color: #666;
      margin-top: 0.5rem;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Edit Halaman Tentang</h1>

    <?php if (isset($sukses)) echo "<div class='sukses'>$sukses</div>"; ?>

    <form method="post">
      <textarea name="konten"><?= htmlspecialchars($konten) ?></textarea>
      <button type="submit">💾 Simpan Perubahan</button>
      <p class="toolbar-note">Gunakan toolbar CKEditor di atas untuk mengatur format teks, gambar, dan lainnya.</p>
    </form>
  </div>

  <script>
    CKEDITOR.replace('konten', {
      height: 350
    });
  </script>

</body>
</html>
