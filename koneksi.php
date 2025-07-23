<?php
$host = "localhost:3307";
$user = "root";
$pass = "";
$db   = "lapor_unimus";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
