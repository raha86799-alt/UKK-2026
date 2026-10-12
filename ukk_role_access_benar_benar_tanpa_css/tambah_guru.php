<?php
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Guru';
$section = 'admin';

// Koneksi database
$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Proses simpan data ke tabel t_guru
if (isset($_POST['submit'])) {
    $nip   = mysqli_real_escape_string($db_connection, $_POST['nip']);
    $nama  = mysqli_real_escape_string($db_connection, $_POST['nama']);
    $email = mysqli_real_escape_string($db_connection, $_POST['email']);

    $query_insert = "INSERT INTO t_guru (nip, nama, email, status_aktif, user_id, created_at, updated_at) 
                     VALUES ('$nip', '$nama', '$email', 1, 1, NOW(), NOW())";
    
    $insert = mysqli_query($db_connection, $query_insert);
    if ($insert) {
        echo "<script>alert('Data guru berhasil ditambahkan!'); window.location='kelola_guru.php';</script>";
    } else {
        echo "<div style='color: red;'>Gagal menyimpan data: " . mysqli_error($db_connection) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>

<!-- Layout utama menggunakan tabel agar menu di samping dan form di kanan sejajar -->
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

            <h1>Tambah Guru</h1>
            <hr>

            <form action="" method="POST">
                <table cellpadding="5" cellspacing="0">
                    <tr>
                        <td><label for="nip">NIP</label></td>
                        <td>: <input type="text" id="nip" name="nip" required></td>
                    </tr>
                    <tr>
                        <td><label for="nama">Nama Guru</label></td>
                        <td>: <input type="text" id="nama" name="nama" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email</label></td>
                        <td>: <input type="email" id="email" name="email" required></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="submit">Simpan</button>
                            <a href="kelola_guru.php">Kembali</a>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>

</body>
</html>