function handleLogin(event) {
  event.preventDefault();
  const nama = document.getElementById('nama').value.trim();
  const nim = document.getElementById('nim').value.trim();

  // NIM format contoh: C2C023047 (kombinasi huruf dan angka, minimal 9 karakter)
  const nimValid = /^[A-Za-z0-9]{9,}$/.test(nim);

  if (!nama || !nim) {
    alert('Mohon lengkapi semua data.');
    return false;
  }

  if (!nimValid) {
    alert('Format NIM tidak valid. Gunakan kombinasi huruf dan angka seperti C2C023000.');
    return false;
  }

  // Simpan data ke localStorage
  localStorage.setItem('nama', nama);
  localStorage.setItem('nim', nim);

  // Arahkan ke halaman utama
  window.location.href = 'LamanAwal.html';
}
