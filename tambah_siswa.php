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

// Proses Tambah Siswa
if (isset($_POST['submit'])) {
    $nis_input     = trim($_POST['nis'] ?? '');
    $nisn          = trim($_POST['nisn'] ?? '');
    $nama          = trim($_POST['nama'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $status_aktif  = trim($_POST['status_aktif'] ?? 1);
    $alamat        = trim($_POST['alamat'] ?? '');

    // Validasi ketat: Kudu angka wungkul sarta panjangna kudu pas 10 karakter (teu kurang, teu leuwih)
    if (!preg_match('/^[0-9]{10}$/', $nis_input) || !preg_match('/^[0-9]{10}$/', $nisn)) {
        echo "<script>alert('Gagal: NIS dan NISN harus berupa angka dan panjangnya harus tepat 10 digit!'); window.history.back();</script>";
        exit;
    }

    // Escape string untuk keamanan database
    $nis_esc           = mysqli_real_escape_string($db_connection, $nis_input);
    $nisn_esc          = mysqli_real_escape_string($db_connection, $nisn);
    $nama_esc          = mysqli_real_escape_string($db_connection, $nama);
    $jenis_kelamin_esc = mysqli_real_escape_string($db_connection, $jenis_kelamin);
    $tanggal_lahir_esc = mysqli_real_escape_string($db_connection, $tanggal_lahir);
    $status_aktif_esc  = mysqli_real_escape_string($db_connection, $status_aktif);
    $alamat_esc        = mysqli_real_escape_string($db_connection, $alamat);

    // Cek apakah kolom di database menggunakan 'nis' atau 'nip'
    $check_column = mysqli_query($db_connection, "SHOW COLUMNS FROM t_siswa LIKE 'nis'");
    $kolom_nis = (mysqli_num_rows($check_column) > 0) ? 'nis' : 'nip';

    $query_insert = "INSERT INTO t_siswa ($kolom_nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif, created_at, updated_at) 
                     VALUES ('$nis_esc', '$nisn_esc', '$nama_esc', '$jenis_kelamin_esc', '$tanggal_lahir_esc', '$alamat_esc', '$status_aktif_esc', NOW(), NOW())";
    
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
            padding: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">

        <!-- Memanggil Sidebar Terpusat -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN UTAMA TAMBAH SISWA -->
        <main class="col-md-9 col-lg-10 p-4">
            <h3 class="mb-4 fw-bold">Kelola Siswa</h3>

            <!-- Form Tambah Data Siswa -->
            <div class="content-card shadow-sm">
                <h5 class="fw-bold mb-3">Tambah Data Siswa</h5>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <!-- Input dibatasi angka doang, max 10 karakter, sarta oninput pikeun nyegah leuwih ti 10 digit -->
                            <input type="text" class="form-control" id="nis" name="nis" placeholder="Contoh: 0000000001" 
                                   maxlength="10" pattern="[0-9]{10}" inputmode="numeric" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                                   autocomplete="off" required>
                            <div class="form-text">Wajib 10 digit angka.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Contoh: 0000000001" 
                                   maxlength="10" pattern="[0-9]{10}" inputmode="numeric" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                                   autocomplete="off" required>
                            <div class="form-text">Wajib 10 digit angka.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="" autocomplete="off" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_aktif" class="form-label">Status Aktif</label>
                            <select class="form-select" id="status_aktif" name="status_aktif" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                    </div>

                    <div class="mt-3">
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