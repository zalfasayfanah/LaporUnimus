<?php
session_start(); // Aktifkan session untuk akses $_SESSION['nim']

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = mysqli_connect("localhost:3307", "root", "", "lapor_unimus");

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Ambil data form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    // Ambil NIM dari session login
    $nim = isset($_SESSION['nim']) ? $_SESSION['nim'] : null;

    if (!$nim) {
        echo "<script>alert('NIM tidak ditemukan. Silakan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
        exit;
    }

    // Buat kode laporan unik berdasarkan tahun + urutan
    $tahun = date("Y");
    $query = "SELECT COUNT(*) as total FROM laporan WHERE YEAR(tanggal_kirim) = '$tahun'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    $no_urut = $data['total'] + 1;
    $tanggal = date("Ymd");
    $random  = rand(100, 999);
    $kode_laporan = "UNIMUS-" . $tanggal . "-" . $random;


    // Proses upload gambar jika ada
    $gambar_nama = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $gambar_nama = $kode_laporan . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $gambar_nama;
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
    }

    // Query simpan laporan ke database
    $sql = "INSERT INTO laporan (nim, kode_laporan, nama_lengkap, email, kategori, deskripsi, gambar, tanggal_kirim, status)
            VALUES ('$nim', '$kode_laporan', '$nama', '$email', '$kategori', '$deskripsi', '$gambar_nama', NOW(), 'Belum diproses')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
                alert('Laporan berhasil dikirim! Kode laporan Anda: $kode_laporan');
                window.location.href = 'BerhasilDisimpan.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kirim Laporan - LaporUnimus</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #333;
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
            margin-top: 1rem;
        }
        nav a {
            margin: 0 1rem;
            color: #007e6a;
            text-decoration: none;
            font-weight: bold;
        }
        .form-container {
            max-width: 700px;
            margin: 5rem auto;
            background: #e6f4f1;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            color: #007e6a;
            margin-bottom: 2rem;
        }
        label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
        }
        input,
        textarea,
        select {
            width: 100%;
            padding: 0.8rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        button {
            margin-top: 2rem;
            background-color: #007e6a;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
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

<section class="form-container">
    <h2>Kirim Laporan</h2>
    <form action="kirimlaporan.php" method="post" enctype="multipart/form-data">
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" placeholder="Nama kamu..." required />

        <label for="email">Email Unimus</label>
        <input type="email" id="email" name="email" placeholder="email@unimus.ac.id" required />

        <label for="kategori">Kategori Laporan</label>
        <select id="kategori" name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="infrastruktur">Infrastruktur Kampus</option>
            <option value="layanan">Layanan Akademik</option>
            <option value="kebersihan">Kebersihan</option>
            <option value="aspirasi">Aspirasi</option>
            <option value="lainnya">Lainnya</option>
        </select>

        <label for="deskripsi">Deskripsi Laporan</label>
        <textarea id="deskripsi" name="deskripsi" placeholder="Ceritakan masalahnya di sini..." required></textarea>

        <label for="gambar">Upload Gambar (Opsional)</label>
        <input type="file" id="gambar" name="gambar" accept="image/*" />

        <button type="submit">Kirim Laporan</button>
    </form>
</section>

<footer>
    &copy; 2025 LaporUnimus. Dibuat oleh Tim Mahasiswa Unimus.
</footer>

</body>
</html>
