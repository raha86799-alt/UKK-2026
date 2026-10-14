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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        /* Reset Dasar & Layout Utama */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #f4f4f4; /* Latar belakang area konten (seperti gambar kanan) */
            overflow: hidden;
        }

        /* Sidebar Hitam Sesuai Gambar Kanan */
        .sidebar {
            width: 260px;
            background-color: #000000;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 25px;
            color: #ffffff;
        }

        .sidebar strong {
            display: block;
            font-size: 12px;
            color: #bbbbbb;
            margin-top: 15px;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .sidebar p {
            font-size: 13px;
            color: #dddddd;
            margin-bottom: 5px;
        }

        .sidebar ul {
            list-style: none;
            margin-bottom: 10px;
        }

        .sidebar ul li {
            margin-bottom: 4px;
        }

        .sidebar ul li a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.2s;
        }

        .sidebar ul li a:hover {
            background-color: #333333;
        }

        /* Gaya untuk Menu Aktif (Kelola Guru / Halaman Ini) */
        .sidebar ul li a.active {
            background-color: #00bcd4; /* Warna cyan/biru terang seperti di gambar kanan */
            color: #ffffff;
            font-weight: bold;
        }

        .sidebar hr {
            border: 0;
            border-top: 1px solid #333333;
            margin: 15px 0;
        }

        /* Tombol Logout di Bawah Sidebar */
        .logout-btn {
            background-color: #a91d3a; /* Warna merah ala tombol logout di gambar */
            color: white;
            text-align: left;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            display: block;
        }

        .logout-btn:hover {
            background-color: #88152c;
        }

        /* Area Konten Utama */
        .main-content {
            flex-grow: 1;
            background-color: #ffffff;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 30px;
            overflow-y: auto;
        }

        .header-info {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px;
            color: #111;
            margin-bottom: 15px;
        }

        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin-bottom: 20px;
        }

        /* Form Styling */
        table.form-table td {
            padding: 8px 5px;
            font-size: 14px;
        }

        input[type="text"], input[type="email"] {
            width: 300px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #ffc107; /* Warna tombol simpan */
            color: #000;
            border: none;
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        button[type="submit"]:hover {
            background-color: #e0a800;
        }

        .btn-kembali {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            display: inline-block;
        }

        .btn-kembali:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <!-- Sidebar Samping Kiri (Warna Hitam) -->
    <div class="sidebar">
        <div>
            <h2>Justice Admin</h2>
            
            <strong>⚙ ADMINISTRATOR</strong>
            <p>Manajemen Sistem</p>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
            </ul>

            <strong>DATA MASTER</strong>
            <ul>
                <li><a href="kelola_siswa.php">Kelola Siswa</a></li>
                <!-- Menu aktif diberi class="active" agar background-nya menjadi cyan -->
                <li><a href="kelola_guru.php" class="active">Kelola Guru</a></li>
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
        </div>

        <div>
            <hr>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Konten Utama di Sebelah Kanan -->
    <div class="main-content">
        <div class="header-info">
            <strong>⚙ ADMINISTRATOR</strong><br>
            Login sebagai: <b>Admin</b>
        </div>
        <hr>

        <h1><?= $title ?></h1>
        <hr>

        <form action="" method="POST">
            <table class="form-table" cellspacing="0">
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
                    <td colspan="2" style="padding-top: 15px;">
                        <button type="submit" name="submit">Simpan</button>
                        <a href="kelola_guru.php" class="btn-kembali">Kembali</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>
</html>