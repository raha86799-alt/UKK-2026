<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Jenis Pelanggaran';
$section = 'admin';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

if (isset($_POST['submit'])) {
    $nama_pelanggaran = trim($_POST['nama_pelanggaran'] ?? '');
    $kategori         = trim($_POST['kategori'] ?? '');
    $poin             = (int)($_POST['poin'] ?? 0);

    if ($db_pdo && !empty($nama_pelanggaran)) {
        try {
            $stmt = $db_pdo->prepare("INSERT INTO t_jenis_pelanggaran (nama_pelanggaran, kategori, poin, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $insert = $stmt->execute([$nama_pelanggaran, $kategori, $poin]);

            if ($insert) {
                echo "<script>alert('Jenis pelanggaran berhasil ditambahkan!'); window.location='jenis_pelanggaran.php';</script>";
                exit;
            }
        } catch (Exception $e) {
            echo "<script>alert('Gagal menyimpan data: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; overflow-x: hidden; margin: 0; }
        .content-card { background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .nav-pills .nav-link.active { background-color: #00bcd4 !important; color: #ffffff !important; font-weight: bold; }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">
        <?php include "layout/sidebar.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Formulir penambahan jenis pelanggaran dan bobot poin baru.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama_pelanggaran" class="form-label fw-bold">Nama Pelanggaran</label>
                        <input type="text" class="form-control" id="nama_pelanggaran" name="nama_pelanggaran" placeholder="Contoh: Terlambat hadir" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-bold">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Contoh: Kedisiplinan" required>
                    </div>

                    <div class="mb-3">
                        <label for="poin" class="form-label fw-bold">Jumlah Poin</label>
                        <input type="number" class="form-control" id="poin" name="poin" placeholder="Contoh: 10" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
                        <a href="jenis_pelanggaran.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>