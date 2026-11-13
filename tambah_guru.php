<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Kelola Guru';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Cek apakah kolom di tabel t_guru menggunakan 'nis' atau 'nip' di database
$check_column = mysqli_query($db_connection, "SHOW COLUMNS FROM t_guru LIKE 'nis'");
$kolom_nis = (mysqli_num_rows($check_column) > 0) ? 'nis' : 'nip';
$label_nis = 'NIS'; // Label form tetap NIS

// Proses Tambah Guru
if (isset($_POST['submit'])) {
    $nis_input    = trim($_POST['nis'] ?? '');
    $nama         = trim($_POST['nama'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '123456';
    $status_aktif = trim($_POST['status_aktif'] ?? 1);
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Validasi ketat: Kudu angka wungkul sarta panjangna kudu pas 10 digit
    if (!preg_match('/^[0-9]{10}$/', $nis_input)) {
        echo "<script>alert('Gagal: {$label_nis} harus berupa angka dan panjangnya harus tepat 10 digit!'); window.history.back();</script>";
        exit;
    }

    $nis_esc   = mysqli_real_escape_string($db_connection, $nis_input);
    $nama_esc  = mysqli_real_escape_string($db_connection, $nama);
    $email_esc = mysqli_real_escape_string($db_connection, $email);

    // 1. Masukkan data ke t_users
    $query_user = "INSERT INTO t_users (email, password, role) VALUES ('$email_esc', '$password_hash', 'guru')";
    
    if (mysqli_query($db_connection, $query_user)) {
        $user_id = mysqli_insert_id($db_connection);

        // 2. Simpan data ke tabel t_guru menggunakan nama kolom yang sesuai di database (nis / nip)
        $query_insert = "INSERT INTO t_guru (user_id, $kolom_nis, nama, email, status_aktif, created_at, updated_at) 
                         VALUES ('$user_id', '$nis_esc', '$nama_esc', '$email_esc', '$status_aktif', NOW(), NOW())";
        
        $insert = mysqli_query($db_connection, $query_insert);
        if ($insert) {
            echo "<script>alert('Data guru berhasil ditambahkan!'); window.location='kelola_guru.php';</script>";
            exit;
        } else {
            mysqli_query($db_connection, "DELETE FROM t_users WHERE id = '$user_id'");
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
            padding: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .form-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .form-table td {
            padding: 8px 6px;
            vertical-align: middle;
        }
        .form-table td.label-col {
            width: 15%;
            font-weight: bold;
        }
        .form-table td.colon-col {
            width: 2%;
            text-align: center;
            font-weight: bold;
        }
        .form-table td.input-col {
            width: 83%;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">

        <!-- Memanggil Sidebar Terpusat -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN UTAMA TAMBAH GURU -->
        <main class="col-md-9 col-lg-10 p-4">
            <h3 class="mb-4 fw-bold">Kelola Guru</h3>

            <!-- Form Tambah Data Guru Saja Tanpa Tabel di Bawah -->
            <div class="content-card shadow-sm">
                <h5 class="fw-bold mb-3">Tambah Data Guru</h5>
                <form action="" method="POST">
                    <table class="form-table">
                        <tr>
                            <td class="label-col"><?= $label_nis ?></td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <!-- Input dibatasi angka doang, maksimal 10 digit, otomatis mupus huruf -->
                                <input type="text" class="form-control" name="nis" placeholder="" 
                                       maxlength="10" pattern="[0-9]{10}" inputmode="numeric" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                                       autocomplete="off" required>
                                <div class="form-text">Wajib 10 digit angka.</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Nama Guru</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="text" class="form-control" name="nama" placeholder="" autocomplete="off" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Email</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="email" class="form-control" name="email" placeholder="" autocomplete="off" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Password</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="password" class="form-control" name="password" placeholder="Minimal 6 karakter." autocomplete="off">
                                <div class="form-text text-muted">Kosongkan atau gunakan default (123456) jika tidak diisi.</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Status Aktif</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" name="status_aktif" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
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