<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Edit Kategori Pelanggaran';
$section = 'admin';

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID kategori pelanggaran tidak valid!'); window.location='kategori_pelanggaran.php';</script>";
    exit;
}

// Ambil data kategori pelanggaran yang akan diedit
$kategori = null;
if ($db_pdo) {
    try {
        $stmt = $db_pdo->prepare("SELECT * FROM t_pelanggaran_kategori WHERE id = ?");
        $stmt->execute([$id]);
        $kategori = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Error handling
    }
}

if (!$kategori) {
    echo "<script>alert('Data kategori pelanggaran tidak ditemukan!'); window.location='kategori_pelanggaran.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['submit'])) {
    $nama      = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? ''); // Diperbaiki dari deksripsi ke deskripsi

    if ($db_pdo) {
        try {
            $stmt = $db_pdo->prepare("UPDATE t_pelanggaran_kategori SET nama = ?, deskripsi = ?, updated_at = NOW() WHERE id = ?");
            $update = $stmt->execute([$nama, $deskripsi, $id]);
            
            if ($update) {
                echo "<script>alert('Data kategori pelanggaran berhasil diperbarui!'); window.location='kategori_pelanggaran.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data kategori pelanggaran.');</script>";
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

        <!-- KONTEN UTAMA FORM EDIT KATEGORI PELANGGARAN -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Edit Kategori Pelanggaran</h2>
                    <p class="text-muted mb-0">Formulir perubahan data kategori pelanggaran terdaftar.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($kategori['nama'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Keterangan / Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= htmlspecialchars($kategori['deskripsi'] ?? '') ?></textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Perbarui</button>
                        <a href="kategori_pelanggaran.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>