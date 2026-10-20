<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Edit Guru';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID guru tidak valid!'); window.location='kelola_guru.php';</script>";
    exit;
}

// Ambil data guru yang akan diedit
$query_get = "SELECT * FROM t_guru WHERE id = '$id'";
$result_get = mysqli_query($db_connection, $query_get);
$guru = mysqli_fetch_assoc($result_get);

if (!$guru) {
    echo "<script>alert('Data guru tidak ditemukan!'); window.location='kelola_guru.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['submit'])) {
    $nip   = mysqli_real_escape_string($db_connection, $_POST['nip']);
    $nama  = mysqli_real_escape_string($db_connection, $_POST['nama']);
    $email = mysqli_real_escape_string($db_connection, $_POST['email']);

    $query_update = "UPDATE t_guru SET 
                        nip = '$nip', 
                        nama = '$nama', 
                        email = '$email', 
                        updated_at = NOW() 
                     WHERE id = '$id'";
    
    $update = mysqli_query($db_connection, $query_update);
    if ($update) {
        echo "<script>alert('Data guru berhasil diperbarui!'); window.location='kelola_guru.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($db_connection) . "');</script>";
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

        <!-- KONTEN UTAMA FORM EDIT GURU -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Edit Guru</h2>
                    <p class="text-muted mb-0">Formulir perubahan data guru terdaftar.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nip" class="form-label fw-bold">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="<?= htmlspecialchars($guru['nip'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Guru</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($guru['nama'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($guru['email'] ?? '') ?>" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Perbarui</button>
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