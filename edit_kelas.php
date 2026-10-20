<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Edit Kelas';
$section = 'admin';

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID kelas tidak valid!'); window.location='kelola_kelas.php';</script>";
    exit;
}

// Ambil data kelas yang akan diedit
$kelas = null;
if ($db_pdo) {
    try {
        $stmt = $db_pdo->prepare("SELECT * FROM t_kelas WHERE id = ?");
        $stmt->execute([$id]);
        $kelas = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Error handling
    }
}

if (!$kelas) {
    echo "<script>alert('Data kelas tidak ditemukan!'); window.location='kelola_kelas.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['submit'])) {
    $nama         = trim($_POST['nama'] ?? '');
    $tingkat      = trim($_POST['tingkat'] ?? '');
    $jurusan      = trim($_POST['jurusan'] ?? '');
    $status_aktif = isset($_POST['status_aktif']) ? 1 : 0;

    if ($db_pdo) {
        try {
            $stmt = $db_pdo->prepare("UPDATE t_kelas SET nama = ?, tingkat = ?, jurusan = ?, status_aktif = ?, updated_at = NOW() WHERE id = ?");
            $update = $stmt->execute([$nama, $tingkat, $jurusan, $status_aktif, $id]);
            
            if ($update) {
                echo "<script>alert('Data kelas berhasil diperbarui!'); window.location='kelola_kelas.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data kelas.');</script>";
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

        <!-- KONTEN UTAMA FORM EDIT KELAS -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Edit Kelas</h2>
                    <p class="text-muted mb-0">Formulir perubahan data kelas terdaftar.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($kelas['nama'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tingkat" class="form-label fw-bold">Tingkat</label>
                        <input type="text" class="form-control" id="tingkat" name="tingkat" value="<?= htmlspecialchars($kelas['tingkat'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label fw-bold">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= htmlspecialchars($kelas['jurusan'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status_aktif" name="status_aktif" value="1" <?= (($kelas['status_aktif'] ?? 0) == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="status_aktif">Status Aktif</label>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Perbarui</button>
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