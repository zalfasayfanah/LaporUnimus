<?php
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");

if (isset($_GET['nim'])) {
  $nim = $_GET['nim'];
  $result = mysqli_query($koneksi, "SELECT * FROM laporan WHERE nim = '$nim'");
  
  $riwayat = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $riwayat[] = $row;
  }

  echo json_encode($riwayat);
}
?>
