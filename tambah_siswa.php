<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin', 'guru']);
}

$title = 'Tambah Siswa';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

if (isset($_POST['submit'])) {
    $nis_input     = trim($_POST['nis'] ?? '');
    $nisn          = trim($_POST['nisn'] ?? '');
    $nama          = trim($_POST['nama'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $alamat        = trim($_POST['alamat'] ?? '');

    // Validasi panjang karakter NIS dan NISN minimal 10 karakter
    if (strlen($nis_input) < 10 || strlen($nisn) < 10) {
        echo "<script>alert('Gagal: NIS dan NISN harus diisi minimal 10 karakter/angka!'); window.history.back();</script>";
        exit;
    }

    // Escape string untuk keamanan database
    $nis_esc           = mysqli_real_escape_string($db_connection, $nis_input);
    $nisn_esc          = mysqli_real_escape_string($db_connection, $nisn);
    $nama_esc          = mysqli_real_escape_string($db_connection, $nama);
    $jenis_kelamin_esc = mysqli_real_escape_string($db_connection, $jenis_kelamin);
    $tanggal_lahir_esc = mysqli_real_escape_string($db_connection, $tanggal_lahir);
    $alamat_esc        = mysqli_real_escape_string($db_connection, $alamat);

    // Cek apakah kolom di database menggunakan 'nis' atau 'nip'
    $check_column = mysqli_query($db_connection, "SHOW COLUMNS FROM t_siswa LIKE 'nis'");
    $kolom_nis = (mysqli_num_rows($check_column) > 0) ? 'nis' : 'nip';

    // Query insert dinamis berdasarkan nama kolom yang ada di database
    $query_insert = "INSERT INTO t_siswa ($kolom_nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif, created_at, updated_at) 
                     VALUES ('$nis_esc', '$nisn_esc', '$nama_esc', '$jenis_kelamin_esc', '$tanggal_lahir_esc', '$alamat_esc', 1, NOW(), NOW())";
    
    $insert = mysqli_query($db_connection, $query_insert);
    if ($insert) {
        echo "<script>alert('Data siswa berhasil ditambahkan!'); window.location='kelola_siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data ke database: " . mysqli_error($db_connection) . "'); window.history.back();</script>";
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
        body {
            background-color: #f4f4f4;
            overflow-x: hidden;
            margin: 0;
        }
        .content-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .nav-pills .nav-link.active {
            background-color: #00bcd4 !important;
            color: #ffffff !important;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">

        <!-- Memanggil Sidebar Terpusat -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN UTAMA FORM TAMBAH SISWA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Tambah Siswa</h2>
                    <p class="text-muted mb-0">Formulir penambahan data siswa baru.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nis" class="form-label fw-bold">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" placeholder="Minimal 10 karakter" minlength="10" autocomplete="off" required>
                        <div class="form-text">NIS harus diisi minimal 10 karakter.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nisn" class="form-label fw-bold">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Minimal 10 karakter" minlength="10" autocomplete="off" required>
                        <div class="form-text">NISN harus diisi minimal 10 karakter.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Alya Putri" autocomplete="off" required>
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
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Contoh: Jl. Pendidikan No. 1" required></textarea>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
                        <a href="kelola_siswa.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>