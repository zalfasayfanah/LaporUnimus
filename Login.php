<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - LaporUnimus</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-yGcLZgoN70EKbP/gRbyrGcY9CJ9odvTwQYJ3uBzq9c1fYwhJxgHQKAFkgYbRfTOdRHiMbBo5D9OVTWuDPlTPBQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="login-container">
    <img src="UNIMUS.png" alt="Logo Unimus" class="logo" />
    <h2>Masuk ke LaporUnimus</h2>

    <form method="post">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="nama" placeholder="Nama Lengkap" required />
      </div>
      <div class="input-group">
        <i class="fas fa-id-card"></i>
        <input type="text" name="nim" placeholder="NIM (mis. C2C023000)" required />
      </div>
      <button type="submit" class="btn-login">Login</button>
    </form>

    <a href="bantuan.php" class="forgot-nim">Lupa NIM?</a>
    <div class="footer">&copy; 2025 LaporUnimus</div>
  </div>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nama = $_POST['nama'];
      $nim = strtoupper(trim($_POST['nim'])); // Pastikan huruf besar, untuk konsistensi

      // Simpan ke session
      $_SESSION['nama'] = $nama;
      $_SESSION['nim'] = $nim;

      // Jika NIM = admin123 (tanpa memandang huruf besar/kecil)
      if (strtolower($nim) === 'admin123') {
          echo "<script>window.location.href = 'admin.php';</script>";
      } else {
          echo "<script>window.location.href = 'LamanAwal.php';</script>";
      }
      exit;
  }
  ?>
</body>

<style>
  * { box-sizing: border-box; }

  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to bottom right, #007e6a, #e0f7f4);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
  }

  .login-container {
    background-color: #fff;
    padding: 3rem 2rem;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 420px;
    text-align: center;
    animation: fadeIn 0.6s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .logo {
    width: 80px;
    margin-bottom: 0.5rem;
  }

  h2 {
    color: #007e6a;
    margin-bottom: 1.5rem;
    font-size: 1.6rem;
  }

  .input-group {
    position: relative;
    margin-bottom: 1.2rem;
  }

  .input-group input {
    width: 100%;
    padding: 0.9rem 1rem 0.9rem 2.5rem;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    transition: border 0.2s;
  }

  .input-group input:focus {
    border-color: #007e6a;
    outline: none;
  }

  .input-group i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 1rem;
  }

  .btn-login {
    width: 100%;
    background-color: #007e6a;
    color: #fff;
    border: none;
    padding: 0.9rem;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 0.5rem;
  }

  .btn-login:hover {
    background-color: #005f52;
  }

  .forgot-nim {
    display: block;
    margin-top: 1rem;
    font-size: 0.9rem;
    color: #007e6a;
    text-decoration: none;
  }

  .forgot-nim:hover {
    text-decoration: underline;
  }

  .footer {
    margin-top: 2rem;
    font-size: 0.85rem;
    color: #666;
  }
</style>
</html>
