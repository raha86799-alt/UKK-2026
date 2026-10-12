<?php
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Kelola Siswa'; 
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");
$query = "SELECT * FROM t_siswa";
$result = $db_connection ? @mysqli_query($db_connection, $query) : false;
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
        
        /* Tombol & Tabel */
        .btn { display: inline-block; padding: 6px 12px; background-color: #0d6efd; color: #fff; text-decoration: none; border-radius: 4px; font-size: 14px; margin-bottom: 15px; }
        .btn:hover { background-color: #0b5ed7; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; }
        th, td { border: 1px solid #dee2e6; padding: 10px; font-size: 14px; text-align: left; }
        th { background-color: #f1f3f5; color: #333; }
        tr:nth-child(even) { background-color: #fdfdfe; }
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
            <h1>Kelola Siswa</h1>
            <p style="color: #666; font-size: 13px;">Kelola data siswa terdaftar pada sistem.</p>
        </div>
        <div class="content-body">
            <a href="tambah_siswa.php" class="btn">+ Tambah Siswa</a>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nip'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['nisn'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['jenis_kelamin'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['tanggal_lahir'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                                <td>
                                    <a href="edit_siswa.php?id=<?= $row['id'] ?>" style="color: #0d6efd; text-decoration: none;">Ubah</a> | 
                                    <a href="hapus_siswa.php?id=<?= $row['id'] ?>" style="color: #dc3545; text-decoration: none;" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php 
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="8" align="center" style="padding: 20px; color: #777;">Belum ada data siswa di dalam tabel t_siswa.</td>
                        </tr>
                        <?php 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>