<?php
// Lokasi folder upload
$targetDir = "uploads/";

// Buat folder jika belum ada
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Cek apakah file diupload
if (isset($_FILES['upload']) && $_FILES['upload']['error'] === 0) {
    $file = $_FILES['upload'];
    $filename = basename($file['name']);
    $targetFile = $targetDir . uniqid() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $funcNum = $_GET['CKEditorFuncNum'] ?? 0;
            $url = $targetFile;
            $message = 'Gambar berhasil diunggah!';
            echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
            exit;
        } else {
            $message = '❌ Gagal memindahkan file.';
        }
    } else {
        $message = '❌ Format file tidak didukung.';
    }
} else {
    $message = '❌ Tidak ada file yang diunggah atau terjadi kesalahan.';
}

// Jika gagal
$funcNum = $_GET['CKEditorFuncNum'] ?? 0;
echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '$message');</script>";
exit;
