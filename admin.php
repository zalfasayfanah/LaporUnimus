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
    // Redirect to prevent form resubmission
    header("Location: admin.php");
    exit;
}

$kategori_result = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM laporan ORDER BY kategori ASC");

// Get statistics
$total_laporan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM laporan"))['total'];
$belum_diproses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM laporan WHERE status = 'Belum diproses' OR status IS NULL"))['total'];
$sedang_diproses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM laporan WHERE status = 'Sedang diproses'"))['total'];
$selesai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM laporan WHERE status = 'Selesai'"))['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - LaporUnimus</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f4f9f8 0%, #e7f7f5 100%);
      color: #333;
      min-height: 100vh;
      padding-bottom: 2rem;
    }

    header {
      background: linear-gradient(135deg, #007e6a 0%, #005f52 100%);
      color: white;
      padding: 2rem;
      position: relative;
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0, 126, 106, 0.3);
    }

    header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
      opacity: 0.1;
    }

    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    .logo {
      height: 120px;
      width: 120px;
      object-fit: contain;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      padding: 1rem;
      backdrop-filter: blur(10px);
    }

    .header-text {
      text-align: center;
      flex-grow: 1;
    }

    .header-text h1 {
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      background: linear-gradient(45deg, #fff, #e0f2f1);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .header-text p {
      font-size: 1.2rem;
      opacity: 0.9;
      font-weight: 300;
    }

    .profile-menu {
      position: relative;
      z-index: 1000;
    }

    .profile-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      border: 3px solid rgba(255, 255, 255, 0.3);
      cursor: pointer;
      object-fit: cover;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
    }

    .profile-icon:hover {
      transform: scale(1.1);
      border-color: rgba(255, 255, 255, 0.6);
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 80px;
      right: 0;
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      z-index: 999;
      min-width: 150px;
      overflow: hidden;
    }

    .dropdown a {
      display: block;
      padding: 1rem 1.5rem;
      color: #007e6a;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .dropdown a:hover {
      background: linear-gradient(135deg, #007e6a, #00a085);
      color: white;
      transform: translateX(5px);
    }

    .nav-container {
      background: white;
      margin: 2rem auto;
      max-width: 95%;
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    nav {
      display: flex;
      justify-content: center;
      background: linear-gradient(135deg, #f8fdfc, #e7f7f5);
    }

    nav a {
      text-decoration: none;
      color: #007e6a;
      font-weight: 600;
      font-size: 1.1rem;
      padding: 1.5rem 2rem;
      transition: all 0.3s ease;
      position: relative;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    nav a:hover {
      background: linear-gradient(135deg, #007e6a, #00a085);
      color: white;
      transform: translateY(-2px);
    }

    nav a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 3px;
      background: linear-gradient(90deg, #007e6a, #00a085);
      transition: width 0.3s ease;
    }

    nav a:hover::after {
      width: 100%;
    }

    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      max-width: 95%;
      margin: 3rem auto;
    }

    .stat-card {
      background: white;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      gap: 1.5rem;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      transition: width 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .stat-card:hover::before {
      width: 8px;
    }

    .stat-card.total::before {
      background: linear-gradient(135deg, #007e6a, #00a085);
    }

    .stat-card.pending::before {
      background: linear-gradient(135deg, #ffc107, #ff8f00);
    }

    .stat-card.progress::before {
      background: linear-gradient(135deg, #17a2b8, #007bff);
    }

    .stat-card.completed::before {
      background: linear-gradient(135deg, #28a745, #20c997);
    }

    .stat-icon {
      font-size: 3rem;
      padding: 1rem;
      border-radius: 15px;
      color: white;
    }

    .stat-card.total .stat-icon {
      background: linear-gradient(135deg, #007e6a, #00a085);
    }

    .stat-card.pending .stat-icon {
      background: linear-gradient(135deg, #ffc107, #ff8f00);
    }

    .stat-card.progress .stat-icon {
      background: linear-gradient(135deg, #17a2b8, #007bff);
    }

    .stat-card.completed .stat-icon {
      background: linear-gradient(135deg, #28a745, #20c997);
    }

    .stat-info h3 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #333;
    }

    .stat-info p {
      color: #666;
      font-weight: 500;
    }

    .kategori-buttons {
      text-align: center;
      margin: 3rem auto;
      max-width: 95%;
    }

    .kategori-buttons h2 {
      font-size: 2rem;
      color: #007e6a;
      margin-bottom: 2rem;
      font-weight: 600;
    }

    .button-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1rem;
    }

    .kategori-btn {
      background: linear-gradient(135deg, #007e6a, #00a085);
      color: white;
      border: none;
      padding: 1rem 2rem;
      border-radius: 25px;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 4px 15px rgba(0, 126, 106, 0.3);
    }

    .kategori-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0, 126, 106, 0.4);
      background: linear-gradient(135deg, #005f52, #007e6a);
    }

    .container {
      max-width: 95%;
      margin: 0 auto;
      background: white;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
    }

    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #007e6a, #00a085, #007e6a);
    }

    .kategori-section {
      margin: 3rem auto;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .kategori-section:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .kategori-header {
      background: linear-gradient(135deg, #007e6a, #00a085);
      color: white;
      padding: 2rem;
      position: relative;
    }

    .kategori-header h2 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .kelola-link {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1.5rem;
      background: rgba(255, 255, 255, 0.2);
      color: white;
      text-decoration: none;
      border-radius: 25px;
      font-weight: 600;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .kelola-link:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
    }

    .table-container {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      background: linear-gradient(135deg, #005f52, #007e6a);
      color: white;
      padding: 1.2rem 1rem;
      text-align: left;
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    td {
      padding: 1rem;
      border-bottom: 1px solid #f0f0f0;
      font-size: 0.95rem;
      vertical-align: middle;
    }

    tr:hover {
      background-color: #f8fdfc;
      transform: scale(1.001);
      transition: all 0.2s ease;
    }

    .status-badge {
      padding: 0.4rem 1rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      text-align: center;
      display: inline-block;
      min-width: 120px;
    }

    .status-belum {
      background: linear-gradient(135deg, #fff3cd, #ffeaa7);
      color: #856404;
      border: 1px solid #ffeaa7;
    }

    .status-sedang {
      background: linear-gradient(135deg, #d1ecf1, #74c0fc);
      color: #0c5460;
      border: 1px solid #74c0fc;
    }

    .status-selesai {
      background: linear-gradient(135deg, #d4edda, #81c784);
      color: #155724;
      border: 1px solid #81c784;
    }

    .kode-laporan {
      font-family: 'Courier New', monospace;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      padding: 0.4rem 0.8rem;
      border-radius: 8px;
      font-weight: bold;
      color: #007e6a;
      border: 1px solid #dee2e6;
    }

    .deskripsi-cell {
      max-width: 300px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .deskripsi-cell:hover {
      white-space: normal;
      overflow: visible;
      background: #f8fdfc;
      cursor: pointer;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .image-preview {
      max-width: 100px;
      max-height: 80px;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.3s ease;
    }

    .image-preview:hover {
      transform: scale(1.2);
    }

    .no-image {
      color: #999;
      font-style: italic;
      text-align: center;
    }

    .status-form {
      display: flex;
      gap: 0.5rem;
      align-items: center;
    }

    .status-select {
      padding: 0.6rem;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.9rem;
      background: white;
      transition: all 0.3s ease;
      min-width: 140px;
    }

    .status-select:focus {
      outline: none;
      border-color: #007e6a;
      box-shadow: 0 0 0 3px rgba(0, 126, 106, 0.1);
    }

    .update-btn {
      background: linear-gradient(135deg, #007e6a, #00a085);
      color: white;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 10px;
      cursor: pointer;
      font-size: 0.9rem;
      font-weight: 600;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .update-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 126, 106, 0.4);
    }

    .date-cell {
      font-size: 0.85rem;
      color: #666;
    }

    footer {
      text-align: center;
      margin-top: 4rem;
      padding: 2rem;
      color: #777;
      background: white;
      border-radius: 15px;
      margin-left: 2.5%;
      margin-right: 2.5%;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .header-container {
        flex-direction: column;
        gap: 1rem;
      }

      .header-text h1 {
        font-size: 2rem;
      }

      .stats-container {
        grid-template-columns: 1fr;
        margin: 2rem 1rem;
      }

      .kategori-section {
        margin: 2rem 1rem;
      }

      .button-grid {
        flex-direction: column;
        align-items: center;
      }

      .kategori-btn {
        width: 100%;
        max-width: 300px;
      }

      th, td {
        padding: 0.5rem;
        font-size: 0.8rem;
      }

      .deskripsi-cell {
        max-width: 150px;
      }
    }

    /* Loading Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .kategori-section {
      animation: fadeInUp 0.6s ease forwards;
    }

    .stat-card {
      animation: fadeInUp 0.6s ease forwards;
    }

    /* Smooth scroll behavior */
    html {
      scroll-behavior: smooth;
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

    // Add smooth scrolling and enhanced interactions
    document.addEventListener('DOMContentLoaded', function() {
      // Enhanced table row interactions
      const tableRows = document.querySelectorAll('tbody tr');
      tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
        
        row.addEventListener('mouseenter', function() {
          this.style.transform = 'translateX(5px) scale(1.001)';
        });
        
        row.addEventListener('mouseleave', function() {
          this.style.transform = 'translateX(0) scale(1)';
        });
      });

      // Add loading animation to cards
      const cards = document.querySelectorAll('.stat-card, .kategori-section');
      cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.2}s`;
      });

      // Success notification
      if (window.location.search.includes('updated=1')) {
        const notification = document.createElement('div');
        notification.innerHTML = '<i class="fas fa-check-circle"></i> Status berhasil diperbarui!';
        notification.style.cssText = `
          position: fixed;
          top: 20px;
          right: 20px;
          background: linear-gradient(135deg, #28a745, #20c997);
          color: white;
          padding: 1rem 1.5rem;
          border-radius: 10px;
          box-shadow: 0 4px 20px rgba(40, 167, 69, 0.3);
          z-index: 1000;
          animation: slideInRight 0.5s ease;
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
          notification.remove();
        }, 3000);
      }
    });
  </script>
</head>
<body>

<header>
  <div class="header-container">
    <img src="Logo1.png" alt="Logo Lapor Unimus" class="logo" />
    <div class="header-text">
      <h1>Panel Admin – LaporUnimus</h1>
      <p>Kelola Laporan yang Masuk dengan Efisien</p>
    </div>
    <div class="profile-menu">
      <img src="profil.png" alt="Profil" class="profile-icon" onclick="toggleDropdown()" />
      <div class="dropdown" id="dropdownMenu">
        <a href="Logout.php">
          <i class="fas fa-sign-out-alt"></i>
          Logout
        </a>
      </div>
    </div>
  </div>
</header>

<div class="nav-container">
  <nav>
    <a href="AdminEditTentang.php">
      <i class="fas fa-edit"></i>
      Edit Tentang
    </a>
    <a href="admin.php">
      <i class="fas fa-clipboard-list"></i>
      Kelola Laporan
    </a>
  </nav>
</div>

<!-- Statistics Cards -->
<div class="stats-container">
  <div class="stat-card total">
    <div class="stat-icon">
      <i class="fas fa-clipboard-list"></i>
    </div>
    <div class="stat-info">
      <h3><?= $total_laporan ?></h3>
      <p>Total Laporan</p>
    </div>
  </div>
  
  <div class="stat-card pending">
    <div class="stat-icon">
      <i class="fas fa-clock"></i>
    </div>
    <div class="stat-info">
      <h3><?= $belum_diproses ?></h3>
      <p>Belum Diproses</p>
    </div>
  </div>
  
  <div class="stat-card progress">
    <div class="stat-icon">
      <i class="fas fa-spinner"></i>
    </div>
    <div class="stat-info">
      <h3><?= $sedang_diproses ?></h3>
      <p>Sedang Diproses</p>
    </div>
  </div>
  
  <div class="stat-card completed">
    <div class="stat-icon">
      <i class="fas fa-check-circle"></i>
    </div>
    <div class="stat-info">
      <h3><?= $selesai ?></h3>
      <p>Selesai</p>
    </div>
  </div>
</div>

<!-- Quick Navigation -->
<div class="kategori-buttons">
  <h2><i class="fas fa-tags"></i> Navigasi Cepat Kategori</h2>
  <div class="button-grid">
    <?php
    mysqli_data_seek($kategori_result, 0);
    while ($btn_kategori = mysqli_fetch_assoc($kategori_result)) :
      $kategori_id = htmlspecialchars($btn_kategori['kategori']);
    ?>
      <a href="#kategori-<?= urlencode($kategori_id) ?>" class="kategori-btn">
        <i class="fas fa-folder"></i>
        <?= $kategori_id ?>
      </a>
    <?php endwhile; ?>
  </div>
</div>

<!-- Categories Sections -->
<?php
mysqli_data_seek($kategori_result, 0);
while ($kategori = mysqli_fetch_assoc($kategori_result)) :
    $nama_kategori = $kategori['kategori'];
    $laporan_per_kategori = mysqli_query($koneksi, "SELECT * FROM laporan WHERE kategori = '$nama_kategori' ORDER BY tanggal_kirim DESC");
    $jumlah_laporan = mysqli_num_rows($laporan_per_kategori);
?>
<section class="kategori-section" id="kategori-<?= urlencode($nama_kategori) ?>">
  <div class="kategori-header">
    <h2>
      <i class="fas fa-folder-open"></i>
      Kategori: <?= htmlspecialchars($nama_kategori) ?>
      <span style="font-size: 1rem; opacity: 0.8;">(<?= $jumlah_laporan ?> laporan)</span>
    </h2>
    <a class="kelola-link" href="kelola_kategori.php?kategori=<?= urlencode($nama_kategori) ?>">
      <i class="fas fa-cog"></i>
      Kelola Kategori Ini
    </a>
  </div>
  
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th><i class="fas fa-hashtag"></i> Kode</th>
          <th><i class="fas fa-user"></i> Nama</th>
          <th><i class="fas fa-envelope"></i> Email</th>
          <th><i class="fas fa-file-text"></i> Deskripsi</th>
          <th><i class="fas fa-info-circle"></i> Status</th>
          <th><i class="fas fa-calendar"></i> Tanggal</th>
          <th><i class="fas fa-image"></i> Gambar</th>
          <th><i class="fas fa-edit"></i> Ubah Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($laporan_per_kategori)) : ?>
          <tr>
            <td>
              <span class="kode-laporan"><?= htmlspecialchars($row['kode_laporan']) ?></span>
            </td>
            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td class="deskripsi-cell" title="<?= htmlspecialchars($row['deskripsi']) ?>">
              <?= htmlspecialchars($row['deskripsi']) ?>
            </td>
            <td>
              <?php 
              $status = $row['status'] ?? 'Belum diproses';
              $statusClass = '';
              switch($status) {
                case 'Belum diproses': $statusClass = 'status-belum'; break;
                case 'Sedang diproses': $statusClass = 'status-sedang'; break;
                case 'Selesai': $statusClass = 'status-selesai'; break;
              }
              ?>
              <span class="status-badge <?= $statusClass ?>">
                <?= htmlspecialchars($status) ?>
              </span>
            </td>
            <td class="date-cell">
              <?= date('d M Y', strtotime($row['tanggal_kirim'])) ?><br>
              <small><?= date('H:i', strtotime($row['tanggal_kirim'])) ?></small>
            </td>
            <td>
                <?php if ($row['gambar']): ?>
                  <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" 
                       alt="Bukti" 
                       class="image-preview"
                       onclick="window.open(this.src, '_blank')" />
                <?php else: ?>
                  <span class="no-image">Tidak ada gambar</span>
                <?php endif; ?>
              </td>

            <td>
              <form method="POST" class="status-form">
                <input type="hidden" name="id_laporan" value="<?= $row['id_laporan'] ?>">
                <select name="status" class="status-select">
                  <option <?= $status === 'Belum diproses' ? 'selected' : '' ?>>Belum diproses</option>
                  <option <?= $status === 'Sedang diproses' ? 'selected' : '' ?>>Sedang diproses</option>
                  <option <?= $status === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
                <button type="submit" name="update_status" class="update-btn">
                  <i class="fas fa-save"></i> Simpan
                </button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>
<?php endwhile; ?>

<!-- Footer -->
<footer>
  &copy; <?= date('Y') ?> LaporUnimus. Semua Hak Dilindungi.
</footer>

</body>
</html>