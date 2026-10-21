<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Ubah Tahun Ajaran';
$section = 'admin';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

$id = $_GET['id'] ?? null;
if (!$id || !$db_pdo) {
    echo "<script>alert('ID tidak valid!'); window.location='kelola_tahun_ajaran.php';</script>";
    exit;
}

// Ambil data berdasarkan ID
$stmt = $db_pdo->prepare("SELECT * FROM t_tahun_ajaran WHERE id = ?");
$stmt->execute([$id]);
$tahun = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tahun) {
    echo "<script>alert('Data tahun ajaran tidak ditemukan!'); window.location='kelola_tahun_ajaran.php';</script>";
    exit;
}

// Proses Update Data
if (isset($_POST['update'])) {
    $nama            = $_POST['nama'];
    $tanggal_mulai   = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif    = $_POST['status_aktif'];

    try {
        $updateStmt = $db_pdo->prepare("UPDATE t_tahun_ajaran SET nama = ?, tanggal_mulai = ?, tanggal_selesai = ?, status_aktif = ? WHERE id = ?");
        $update = $updateStmt->execute([$nama, $tanggal_mulai, $tanggal_selesai, $status_aktif, $id]);

        if ($update) {
            echo "<script>alert('Data tahun ajaran berhasil diubah!'); window.location='kelola_tahun_ajaran.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Gagal mengubah data: " . $e->getMessage() . "');</script>";
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

        <!-- KONTEN UTAMA FORM UBAH TAHUN AJARAN -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Perbarui data tahun ajaran pada sistem.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Tahun Ajaran</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($tahun['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= htmlspecialchars($tahun['tanggal_mulai']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label fw-bold">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= htmlspecialchars($tahun['tanggal_selesai']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status_aktif" class="form-label fw-bold">Status Aktif</label>
                        <select class="form-select" id="status_aktif" name="status_aktif" required>
                            <option value="1" <?= ($tahun['status_aktif'] == 1) ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= ($tahun['status_aktif'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="update" class="btn btn-warning fw-semibold px-4 text-dark">Simpan Perubahan</button>
                        <a href="kelola_tahun_ajaran.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>