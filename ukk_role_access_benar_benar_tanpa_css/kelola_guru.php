<?php
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Kelola Guru'; 
$section = 'admin';

// Koneksi database
$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Ambil data dari tabel t_guru
$query = "SELECT * FROM t_guru";
$result = $db_connection ? @mysqli_query($db_connection, $query) : false;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>

<!-- Layout utama menggunakan tabel agar menu di samping dan konten di kanan sejajar -->
<table width="100%" border="0" cellpadding="10" cellspacing="0">
    <tr>
        <td colspan="2" style="background-color: #f4f4f4; border-bottom: 1px solid #ccc;">
            <h2>Justice Admin</h2>
        </td>
    </tr>
    <tr valign="top">
        <!-- Menu Samping (Sidebar) -->
        <td width="20%" style="border-right: 1px solid #ccc;">
            <strong>⚙ ADMINISTRATOR</strong><hr>
            <p>Manajemen Sistem</p>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
            </ul>
            <strong>DATA MASTER</strong>
            <ul>
                <li><a href="kelola_siswa.php">Kelola Siswa</a></li>
                <li><a href="kelola_guru.php">Kelola Guru</a></li>
                <li><a href="kelola_kelas.php">Kelola Kelas</a></li>
                <li><a href="kelola_tahun_ajaran.php">Kelola Tahun Ajaran</a></li>
                <li><a href="penempatan_siswa.php">Penempatan Siswa</a></li>
                <li><a href="kelola_wali_kelas.php">Kelola Wali Kelas</a></li>
                <li><a href="kategori_pelanggaran.php">Kategori Pelanggaran</a></li>
                <li><a href="jenis_pelanggaran.php">Jenis Pelanggaran</a></li>
                <li><a href="cetak_export.php">Cetak / Export</a></li>
            </ul>
            <strong>PELANGGARAN</strong>
            <ul>
                <li><a href="catat_pelanggaran.php">Catat Pelanggaran</a></li>
                <li><a href="tindakan.php">Tindakan</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="riwayat.php">Riwayat</a></li>
                <li><a href="rekap_poin.php">Rekap Poin</a></li>
            </ul>
            <hr>
            <p><a href="logout.php">Logout</a></p>
        </td>

        <!-- Konten Utama di Sebelah Kanan -->
        <td width="80%">
            <p><strong>⚙ ADMINISTRATOR</strong><br>Login sebagai: <b>Admin</b></p>
            <hr>

            <h1>Kelola Guru</h1>
            <p><a href="tambah_guru.php">+ Tambah Guru</a></p>

            <table border="1" cellpadding="8" cellspacing="0" width="100%">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $no = 1;
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nip'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                            <td>
                                <a href="edit_guru.php?id=<?= $row['id'] ?>">Ubah</a> | 
                                <a href="hapus_guru.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" align="center">Belum ada data guru di dalam tabel t_guru.</td>
                    </tr>
                    <?php 
                }
                ?>
            </table>
        </td>
    </tr>
</table>

</body>
</html>