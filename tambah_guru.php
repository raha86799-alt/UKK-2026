<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Guru';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

if (isset($_POST['submit'])) {
    $nis_input = trim($_POST['nis'] ?? '');
    $nama      = trim($_POST['nama'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = password_hash('123456', PASSWORD_DEFAULT); // Password default: 123456

    // Validasi panjang karakter NIS minimal 10 karakter
    if (strlen($nis_input) < 10) {
        echo "<script>alert('Gagal: NIS harus diisi minimal 10 karakter/angka!'); window.history.back();</script>";
        exit;
    }

    $nis_esc   = mysqli_real_escape_string($db_connection, $nis_input);
    $nama_esc  = mysqli_real_escape_string($db_connection, $nama);
    $email_esc = mysqli_real_escape_string($db_connection, $email);

    // 1. Masukkan data ke t_user menggunakan kolom email & password
    $query_user = "INSERT INTO t_user (email, password, role) VALUES ('$email_esc', '$password', 'guru')";
    
    if (mysqli_query($db_connection, $query_user)) {
        // Ambil ID user yang baru saja dibuat
        $user_id = mysqli_insert_id($db_connection);

        // Cek apakah kolom di tabel t_guru menggunakan 'nis' atau 'nip'
        $check_column = mysqli_query($db_connection, "SHOW COLUMNS FROM t_guru LIKE 'nis'");
        $kolom_nis = (mysqli_num_rows($check_column) > 0) ? 'nis' : 'nip';

        // 2. Simpan data ke tabel t_guru dengan menyertakan user_id dan kolom nis/nip yang sesuai
        $query_insert = "INSERT INTO t_guru (user_id, $kolom_nis, nama, email, created_at, updated_at) 
                         VALUES ('$user_id', '$nis_esc', '$nama_esc', '$email_esc', NOW(), NOW())";
        
        $insert = mysqli_query($db_connection, $query_insert);
        if ($insert) {
            echo "<script>alert('Data guru berhasil ditambahkan! (Password default: 123456)'); window.location='kelola_guru.php';</script>";
            exit;
        } else {
            // Jika gagal di tabel guru, hapus user yang terlanjur dibuat agar bersih
            mysqli_query($db_connection, "DELETE FROM t_user WHERE id = '$user_id'");
            echo "<script>alert('Gagal menyimpan data guru: " . mysqli_error($db_connection) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal membuat akun user: " . mysqli_error($db_connection) . "'); window.history.back();</script>";
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

        <!-- KONTEN UTAMA FORM TAMBAH GURU -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Tambah Guru</h2>
                    <p class="text-muted mb-0">Formulir penambahan data guru baru.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nis" class="form-label fw-bold">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" placeholder="Minimal 10 karakter" minlength="10" autocomplete="off" required>
                        <div class="form-text">NIS harus diisi minimal 10 karakter.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Guru</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Budi Santoso, S.Pd." autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: budi@school.com" autocomplete="off" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
                        <a href="kelola_guru.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>