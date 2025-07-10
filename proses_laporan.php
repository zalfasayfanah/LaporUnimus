<?php
// 1. Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");

// 2. Ambil data dari form
$nama       = $_POST['nama'];
$email      = $_POST['email'];
$kategori   = $_POST['kategori'];
$deskripsi  = $_POST['deskripsi'];


// 4. Proses upload gambar (jika ada)
$nama_file = "";
if ($_FILES['gambar']['name'] != "") {
    $folder = "uploads/";
    $nama_file = uniqid() . "-" . basename($_FILES["gambar"]["name"]);
    $target_file = $folder . $nama_file;

    // Buat folder uploads jika belum ada
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
}

// 5. Simpan ke database
$query = "INSERT INTO laporan 
    (kode_laporan, nama_lengkap, email, kategori, deskripsi, gambar, status, tanggal_kirim)
    VALUES 
    ('$kode_laporan', '$nama', '$email', '$kategori', '$deskripsi', '$nama_file', 'Belum diproses', NOW())";

if (mysqli_query($koneksi, $query)) {
    // 6. Redirect ke halaman sukses
    header("Location: BerhasilDisimpan.php");
} else {
    echo "Gagal menyimpan laporan: " . mysqli_error($koneksi);
}
?>
