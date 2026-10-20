<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Kelas';
$section = 'admin';

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

if (isset($_POST['submit'])) {
    $nama         = trim($_POST['nama'] ?? '');
    $tingkat      = trim($_POST['tingkat'] ?? '');
    $jurusan      = trim($_POST['jurusan'] ?? '');
    $status_aktif = isset($_POST['status_aktif']) ? 1 : 0;

    if ($db_pdo) {
        try {
            $stmt = $db_pdo->prepare("INSERT INTO t_kelas (nama, tingkat, jurusan, status_aktif, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $insert = $stmt->execute([$nama, $tingkat, $jurusan, $status_aktif]);
            
            if ($insert) {
                echo "<script>alert('Data kelas berhasil ditambahkan!'); window.location='kelola_kelas.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan data kelas.');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Koneksi database PDO belum terhubung.');</script>";
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

        <!-- KONTEN UTAMA FORM TAMBAH KELAS -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Tambah Kelas</h2>
                    <p class="text-muted mb-0">Formulir penambahan data kelas baru.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: XII RPL 1" required>
                    </div>
                    <div class="mb-3">
                        <label for="tingkat" class="form-label fw-bold">Tingkat</label>
                        <input type="text" class="form-control" id="tingkat" name="tingkat" placeholder="Contoh: X / XI / XII" required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label fw-bold">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status_aktif" name="status_aktif" value="1" checked>
                        <label class="form-check-label fw-bold" for="status_aktif">Status Aktif</label>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
                        <a href="kelola_kelas.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>