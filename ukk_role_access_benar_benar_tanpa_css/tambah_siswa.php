<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
   if (function_exists('requireRole')) {
    requireRole(['admin', 'guru']);
}
}

$title = 'Tambah Siswa';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

if (isset($_POST['submit'])) {
    $nip            = mysqli_real_escape_string($db_connection, $_POST['nip']);
    $nisn           = mysqli_real_escape_string($db_connection, $_POST['nisn']);
    $nama           = mysqli_real_escape_string($db_connection, $_POST['nama']);
    $jenis_kelamin  = mysqli_real_escape_string($db_connection, $_POST['jenis_kelamin']);
    $tanggal_lahir  = mysqli_real_escape_string($db_connection, $_POST['tanggal_lahir']);
    $alamat         = mysqli_real_escape_string($db_connection, $_POST['alamat']);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $title ?></title>
    <style>
        .bg-custom-sidebar {
            background-color: #000000;
            min-height: 100vh;
        }
        body {
            background-color: #f2f2f2;
            overflow-x: hidden;
        }
        .nav-pills .nav-link {
            color: #cfd3d6;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            margin-bottom: 4px;
        }
        .nav-pills .nav-link:hover {
            background-color: #333333;
            color: #ffffff;
            transform: translateX(5px);
        }
        .nav-pills .nav-link.active {
            background-color: #00bcd4 !important;
            color: #ffffff !important;
            font-weight: bold;
            transform: translateX(5px);
        }
        .content-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 25px;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <!-- SIDEBAR LENGKAP -->
    <div class="col-md-3 col-lg-2 bg-custom-sidebar p-3 d-flex flex-column justify-content-between">
        <div>
            <h4 class="text-white mb-4 fw-bold pb-2 border-bottom border-secondary">
                My Website
            </h4>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_siswa.php" class="nav-link active">Kelola Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_guru.php" class="nav-link">Kelola Guru</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_kelas.php" class="nav-link">Kelola Kelas</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_tahun_ajaran.php" class="nav-link">Kelola Tahun Ajaran</a>
                </li>
                <li class="nav-item">
                    <a href="penempatan_siswa.php" class="nav-link">Penempatan Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_wali_kelas.php" class="nav-link">Kelola Wali Kelas</a>
                </li>
                <li class="nav-item">
                    <a href="kategori_pelanggaran.php" class="nav-link">Kategori Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="jenis_pelanggaran.php" class="nav-link">Jenis Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link">Cetak / Laporan</a>
                </li>
                
                <!-- PELANGGARAN -->
                <li class="text-muted small mt-3 mb-1 px-2 fw-bold text-uppercase">PELANGGARAN</li>
                <li class="nav-item">
                    <a href="catat_pelanggaran.php" class="nav-link">Catat Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="tindakan.php" class="nav-link">Tindakan</a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link">Laporan</a>
                </li>
                <li class="nav-item">
                    <a href="riwayat.php" class="nav-link">Riwayat</a>
                </li>
                <li class="nav-item">
                    <a href="rekap_poin.php" class="nav-link">Rekap Poin</a>
                </li>
            </ul>
        </div>
        <div>
            <hr class="text-secondary">
            <a href="logout.php" class="btn text-white w-100 text-start fw-bold" style="background-color: #a91d3a;">
                Logout
            </a>
        </div>
    </div>

    <!-- KONTEN UTAMA FORM TAMBAH SISWA -->
    <main class="flex-grow-1 p-4">
        <div class="content-card shadow-sm">
            <div class="mb-3">
                <h2>Tambah Siswa</h2>
                <p class="text-muted mb-0">Formulir penambahan data siswa baru.</p>
            </div>
            <hr>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nip" class="form-label fw-bold">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" required>
                </div>
                <div class="mb-3">
                    <label for="nisn" class="form-label fw-bold">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Siswa</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label fw-bold">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                </div>
                <div class="mt-4">
                    <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
                    <a href="kelola_siswa.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>