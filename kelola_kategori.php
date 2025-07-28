<?php
$koneksi = mysqli_connect("localhost", "root", "", "lapor_unimus");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$laporan = [];

if ($kategori) {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM laporan WHERE kategori = ? ORDER BY tanggal_kirim DESC");
    mysqli_stmt_bind_param($stmt, "s", $kategori);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $laporan[] = $row;
    }
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $id = $_POST['id_laporan'];
    $status_baru = $_POST['status'];
    $query = "UPDATE laporan SET status = '$status_baru' WHERE id_laporan = $id";
    mysqli_query($koneksi, $query);
    // Redirect to prevent form resubmission
    header("Location: kelola_kategori.php?kategori=" . urlencode($kategori));
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Kategori: <?= htmlspecialchars($kategori) ?> - LaporUnimus</title>
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
      box-shadow: 0 4px 20px rgba(0, 126, 106, 0.3);
      position: relative;
      overflow: hidden;
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
      align-items: center;
      gap: 2rem;
      position: relative;
      z-index: 1;
    }

    .back-button {
      background: rgba(255, 255, 255, 0.2);
      border: 2px solid rgba(255, 255, 255, 0.3);
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .back-button:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .header-text {
      flex-grow: 1;
      text-align: center;
    }

    .header-text h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .header-text .subtitle {
      font-size: 1.1rem;
      opacity: 0.9;
      font-weight: 300;
    }

    .kategori-badge {
      background: rgba(255, 255, 255, 0.2);
      padding: 0.5rem 1.5rem;
      border-radius: 25px;
      font-weight: 600;
      border: 2px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(10px);
    }

    .container {
      max-width: 95%;
      margin: 3rem auto;
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

    .stats-card {
      background: linear-gradient(135deg, #007e6a 0%, #00a085 100%);
      color: white;
      padding: 1.5rem;
      border-radius: 15px;
      margin-bottom: 2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      box-shadow: 0 8px 25px rgba(0, 126, 106, 0.3);
    }

    .stats-icon {
      font-size: 2.5rem;
      opacity: 0.8;
    }

    .stats-info h3 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 0.3rem;
    }

    .stats-info p {
      opacity: 0.9;
      font-weight: 300;
    }

    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      color: #666;
    }

    .empty-state .icon {
      font-size: 4rem;
      color: #007e6a;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    .empty-state h3 {
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
      color: #333;
    }

    .table-container {
      overflow-x: auto;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    th {
      background: linear-gradient(135deg, #007e6a 0%, #005f52 100%);
      color: white;
      padding: 1rem;
      text-align: left;
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    th:first-child {
      border-top-left-radius: 15px;
    }

    th:last-child {
      border-top-right-radius: 15px;
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

    tr:last-child td:first-child {
      border-bottom-left-radius: 15px;
    }

    tr:last-child td:last-child {
      border-bottom-right-radius: 15px;
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
      background: #fff3cd;
      color: #856404;
      border: 1px solid #ffeaa7;
    }

    .status-sedang {
      background: #d1ecf1;
      color: #0c5460;
      border: 1px solid #74c0fc;
    }

    .status-selesai {
      background: #d4edda;
      color: #155724;
      border: 1px solid #81c784;
    }

    .kode-laporan {
      font-family: 'Courier New', monospace;
      background: #f8f9fa;
      padding: 0.3rem 0.6rem;
      border-radius: 6px;
      font-weight: bold;
      color: #007e6a;
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
    }

    .image-preview {
      max-width: 80px;
      max-height: 60px;
      border-radius: 8px;
      object-fit: cover;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .image-preview:hover {
      transform: scale(1.1);
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
      padding: 0.5rem;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.85rem;
      background: white;
      transition: border-color 0.3s ease;
    }

    .status-select:focus {
      outline: none;
      border-color: #007e6a;
    }

    .update-btn {
      background: linear-gradient(135deg, #007e6a 0%, #00a085 100%);
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      cursor: pointer;
      font-size: 0.9rem;
      font-weight: 600;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 0.3rem;
    }

    .update-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 126, 106, 0.4);
    }

    .date-cell {
      font-size: 0.85rem;
      color: #666;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .header-container {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
      }

      .header-text h1 {
        font-size: 2rem;
      }

      .container {
        margin: 2rem 1rem;
        padding: 1.5rem;
      }

      .stats-card {
        flex-direction: column;
        text-align: center;
      }

      th, td {
        padding: 0.5rem;
      }

      .deskripsi-cell {
        max-width: 200px;
      }
    }

    /* Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .container {
      animation: fadeInUp 0.6s ease;
    }

    .table-container {
      animation: fadeInUp 0.8s ease;
    }
  </style>
</head>
<body>

<header>
  <div class="header-container">
    <a href="admin.php" class="back-button">
      <i class="fas fa-arrow-left"></i>
      Kembali
    </a>
    <div class="header-text">
      <h1>Kelola Laporan</h1>
      <p class="subtitle">Mengelola laporan dalam kategori tertentu</p>
    </div>
    <div class="kategori-badge">
      <i class="fas fa-tag"></i>
      <?= htmlspecialchars($kategori) ?>
    </div>
  </div>
</header>

<div class="container">
  <div class="stats-card">
    <div class="stats-icon">
      <i class="fas fa-clipboard-list"></i>
    </div>
    <div class="stats-info">
      <h3><?= count($laporan) ?></h3>
      <p>Total laporan dalam kategori "<?= htmlspecialchars($kategori) ?>"</p>
    </div>
  </div>

  <?php if (empty($laporan)): ?>
    <div class="empty-state">
      <div class="icon">
        <i class="fas fa-inbox"></i>
      </div>
      <h3>Tidak Ada Laporan</h3>
      <p>Belum ada laporan yang masuk dalam kategori ini.</p>
    </div>
  <?php else: ?>
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
            <th><i class="fas fa-edit"></i> Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($laporan as $row): ?>
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
                <form method="post" class="status-form">
                  <input type="hidden" name="id_laporan" value="<?= $row['id_laporan'] ?>">
                  <select name="status" class="status-select">
                    <option value="Belum diproses" <?= $status == "Belum diproses" ? 'selected' : '' ?>>
                      Belum diproses
                    </option>
                    <option value="Sedang diproses" <?= $status == "Sedang diproses" ? 'selected' : '' ?>>
                      Sedang diproses
                    </option>
                    <option value="Selesai" <?= $status == "Selesai" ? 'selected' : '' ?>>
                      Selesai
                    </option>
                  </select>
                  <button type="submit" name="update_status" class="update-btn">
                    <i class="fas fa-check"></i>
                    Update
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<script>
// Add smooth scrolling and enhanced interactions
document.addEventListener('DOMContentLoaded', function() {
  // Smooth scroll for back button
  document.querySelector('.back-button').addEventListener('click', function(e) {
    e.preventDefault();
    window.history.back();
  });

  // Enhanced table row interactions
  const tableRows = document.querySelectorAll('tbody tr');
  tableRows.forEach(row => {
    row.addEventListener('mouseenter', function() {
      this.style.transform = 'translateX(5px)';
    });
    
    row.addEventListener('mouseleave', function() {
      this.style.transform = 'translateX(0)';
    });
  });

  // Auto-refresh notification
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

</body>
</html>