<?php
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Kelola Kelas';
$section = 'admin';

// Memastikan variabel koneksi PDO tersedia (pastikan config.php mendefinisikan $pdo)
// Jika di config.php menggunakan $conn/$koneksi, sesuaikan di bawah ini
$db_pdo = $pdo ?? null;
if (!$db_pdo && isset($conn)) {
    // Fallback jika menggunakan koneksi lain, atau pastikan $pdo terhubung
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        
        /* Latar belakang utama halaman abu-abu terang */
        body { display: flex; height: 100vh; background-color: #f4f4f4; overflow: hidden; }
        
        /* Sidebar Kiri Hitam Sesuai Gambar */
        .sidebar { width: 250px; background-color: #000000; color: #fff; display: flex; flex-direction: column; padding: 20px 0; justify-content: space-between; }
        .sidebar-top h2 { font-size: 18px; padding: 0 20px 15px 20px; border-bottom: 1px solid #333; margin-bottom: 15px; color: #fff; }
        .sidebar a { color: #cfd3d6; text-decoration: none; padding: 10px 20px; display: block; font-size: 14px; transition: 0.2s; }
        .sidebar a:hover { background-color: #333; color: #fff; }
        
        /* Menu aktif warna cyan */
        .sidebar a.active { background-color: #00bcd4; color: #fff; font-weight: bold; }
        
        /* Tombol Logout Merah di Bawah Sidebar */
        .sidebar .logout { color: #ffffff; background-color: #a91d3a; margin: 0 20px; text-align: left; border-radius: 4px; font-weight: bold; }
        .sidebar .logout:hover { background-color: #88152c; }
        
        /* Konten Utama Kanan */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; background-color: #ffffff; margin: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; }
        
        .header-top { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #dee2e6; padding-bottom: 15px; margin-bottom: 20px; }
        .header-top h1 { font-size: 24px; color: #333; }
        
        /* Tombol Tambah Kelas */
        .btn-tambah { background-color: #0d6efd; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; font-weight: bold; }
        .btn-tambah:hover { background-color: #0b5ed7; }

        /* Tabel Data */
        .data-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .data-table th, .data-table td { text-align: left; padding: 12px; border-bottom: 1px solid #ddd; }
        .data-table th { background-color: #f8f9fa; font-weight: bold; color: #333; }
        .data-table tbody tr:nth-child(even) { background-color: #fafafa; }

        /* Tombol Aksi */
        .btn-action { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; text-decoration: none; color: white; margin-right: 3px; display: inline-block; }
        .btn-edit { background-color: #ffc107; color: #000; }
        .btn-edit:hover { background-color: #e0a800; }
        .btn-delete { background-color: #dc3545; }
        .btn-delete:hover { background-color: #bb2d3b; }
    </style>
</head>
<body>

    <!-- Sidebar Kiri -->
    <div class="sidebar">
        <div class="sidebar-top">
            <h2>My Website</h2>
            <a href="dashboard.php">Dashboard</a>
            <a href="kelola_siswa.php">Data Siswa</a>
            <a href="kelola_guru.php">Data Guru</a>
            <!-- Menu Kelas Aktif -->
            <a href="kelola_kelas.php" class="active">Kelas</a>
            <a href="laporan.php">Laporan</a>
            <a href="about.php">About Me</a>
        </div>
        <div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <!-- Area Kanan -->
    <div class="main-content">
        <div class="header-top">
            <div>
                <h1><?= htmlspecialchars($title) ?></h1>
                <p style="color: #666; font-size: 13px; margin-top: 5px;">Kelola data kelas terdaftar pada sistem.</p>
            </div>
            <a href="tambah_kelas.php" class="btn-tambah">+ Tambah Kelas</a>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($db_pdo) {
                    try {
                        $rows = $db_pdo->query("
                            SELECT id, nama, tingkat, jurusan, status_aktif 
                            FROM t_kelas 
                            ORDER BY id
                        ")->fetchAll(PDO::FETCH_ASSOC);

                        if (count($rows) > 0) {
                            foreach ($rows as $i => $row) {
                                ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['tingkat']) ?></td>
                                    <td><?= htmlspecialchars($row['jurusan']) ?></td>
                                    <td><?= $row['status_aktif'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                                    <td>
                                        <a href="edit_kelas.php?id=<?= $row['id'] ?>" class="btn-action btn-edit">Ubah</a>
                                        <a href="hapus_kelas.php?id=<?= $row['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" style="text-align: center; color: #777;">Belum ada data kelas.</td></tr>';
                        }
                    } catch (Exception $e) {
                        echo '<tr><td colspan="6" style="color: red;">Error memuat data: ' . $e->getMessage() . '</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" style="color: red;">Koneksi database ($pdo) belum terhubung dengan benar di config.php.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>