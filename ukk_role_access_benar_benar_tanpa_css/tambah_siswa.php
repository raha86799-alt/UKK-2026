<?php
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Siswa';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

if (isset($_POST['submit'])) {
    $nip           = mysqli_real_escape_string($db_connection, $_POST['nip']);
    $nisn          = mysqli_real_escape_string($db_connection, $_POST['nisn']);
    $nama          = mysqli_real_escape_string($db_connection, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($db_connection, $_POST['jenis_kelamin']);
    $tanggal_lahir = mysqli_real_escape_string($db_connection, $_POST['tanggal_lahir']);
    $alamat        = mysqli_real_escape_string($db_connection, $_POST['alamat']);

    $query_insert = "INSERT INTO t_siswa (nip, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif, created_at, updated_at) 
                     VALUES ('$nip', '$nisn', '$nama', '$jenis_kelamin', '$tanggal_lahir', '$alamat', 1, NOW(), NOW())";
    
    $insert = mysqli_query($db_connection, $query_insert);
    if ($insert) {
        echo "<script>alert('Data siswa berhasil ditambahkan!'); window.location='kelola_siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($db_connection) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { display: flex; height: 100vh; background-color: #f8f9fa; }
        
        /* Sidebar Kiri */
        .sidebar { width: 250px; background-color: #1a1d20; color: #fff; display: flex; flex-direction: column; padding: 20px 0; }
        .sidebar h2 { font-size: 18px; padding: 0 20px 15px 20px; border-bottom: 1px solid #2d3238; margin-bottom: 15px; }
        .sidebar a { color: #cfd3d6; text-decoration: none; padding: 10px 20px; display: block; font-size: 14px; transition: 0.2s; }
        .sidebar a:hover, .sidebar a.active { background-color: #0d6efd; color: #fff; }
        .sidebar .logout { color: #ff6b6b; margin-top: auto; }
        
        /* Konten Utama Kanan */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; background-color: #ffffff; }
        .header-top { padding: 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff; }
        .header-top h1 { font-size: 24px; color: #333; margin-bottom: 5px; }
        .content-body { padding: 20px; }
        
        /* Form Styling */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 14px; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; max-width: 500px; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; }
        .btn-submit { background-color: #0d6efd; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-submit:hover { background-color: #0b5ed7; }
        .btn-back { background-color: #6c757d; color: white; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px; display: inline-block; margin-left: 5px; }
        .btn-back:hover { background-color: #5c636a; }
    </style>
</head>
<body>

    <!-- Sidebar Kiri -->
    <div class="sidebar">
        <h2>My Website</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="kelola_siswa.php" class="active">Data Siswa</a>
        <a href="kelola_guru.php">Data Guru</a>
        <a href="kelola_kelas.php">Kelas</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Area Kanan -->
    <div class="main-content">
        <div class="header-top">
            <h1>Tambah Siswa</h1>
            <p style="color: #666; font-size: 13px;">Formulir penambahan data siswa baru.</p>
        </div>
        <div class="content-body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" required>
                </div>
                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" id="nisn" name="nisn" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Siswa</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" required></textarea>
                </div>
                <div style="margin-top: 20px;">
                    <button type="submit" name="submit" class="btn-submit">Simpan</button>
                    <a href="kelola_siswa.php" class="btn-back">Kembali</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>