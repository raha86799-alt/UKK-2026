<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Edit Penempatan Siswa';
$section = 'admin';

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID penempatan siswa tidak valid!'); window.location='penempatan_siswa.php';</script>";
    exit;
}

// Ambil data penempatan yang akan diedit
$penempatan = null;
if ($db_pdo) {
    try {
        $stmt = $db_pdo->prepare("SELECT * FROM t_kelas_siswa WHERE id = ?");
        $stmt->execute([$id]);
        $penempatan = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Error handling
    }
}

if (!$penempatan) {
    echo "<script>alert('Data penempatan siswa tidak ditemukan!'); window.location='penempatan_siswa.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['submit'])) {
    $siswa_id         = trim($_POST['siswa_id'] ?? '');
    $kelas_id         = trim($_POST['kelas_id'] ?? '');
    $tahun_ajaran_id = trim($_POST['tahun_ajaran_id'] ?? '');
    $status_aktif     = isset($_POST['status_aktif']) ? 1 : 0;

    if ($db_pdo) {
        try {
            $stmt = $db_pdo->prepare("UPDATE t_kelas_siswa SET siswa_id = ?, kelas_id = ?, tahun_ajaran_id = ?, status_aktif = ?, updated_at = NOW() WHERE id = ?");
            $update = $stmt->execute([$siswa_id, $kelas_id, $tahun_ajaran_id, $status_aktif, $id]);
            
            if ($update) {
                echo "<script>alert('Data penempatan siswa berhasil diperbarui!'); window.location='penempatan_siswa.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui data penempatan siswa.');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Koneksi database PDO belum terhubung.');</script>";
    }
}

// Ambil data untuk dropdown (Siswa, Kelas, Tahun Ajaran)
$siswa_list = [];
$kelas_list = [];
$tahun_list = [];

if ($db_pdo) {
    try {
        $siswa_list = $db_pdo->query("SELECT id, nama FROM t_siswa WHERE status_aktif = 1 ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
        $kelas_list = $db_pdo->query("SELECT id, nama FROM t_kelas WHERE status_aktif = 1 ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
        $tahun_list = $db_pdo->query("SELECT id, nama FROM t_tahun_ajaran ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Abaikan jika tabel belum ada / error query dropdown
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

        <!-- KONTEN UTAMA FORM EDIT PENEMPATAN SISWA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Edit Penempatan Siswa</h2>
                    <p class="text-muted mb-0">Formulir perubahan data penempatan siswa ke dalam kelas.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label fw-bold">Pilih Siswa</label>
                        <select class="form-select" id="siswa_id" name="siswa_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($siswa_list as $s): ?>
                                <option value="<?= $s['id'] ?>" <?= (($penempatan['siswa_id'] ?? '') == $s['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kelas_id" class="form-label fw-bold">Pilih Kelas</label>
                        <select class="form-select" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelas_list as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= (($penempatan['kelas_id'] ?? '') == $k['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_ajaran_id" class="form-label fw-bold">Pilih Tahun Ajaran</label>
                        <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php foreach ($tahun_list as $ta): ?>
                                <option value="<?= $ta['id'] ?>" <?= (($penempatan['tahun_ajaran_id'] ?? '') == $ta['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ta['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status_aktif" name="status_aktif" value="1" <?= (($penempatan['status_aktif'] ?? 0) == 1) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="status_aktif">Status Aktif</label>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Perbarui</button>
                        <a href="penempatan_siswa.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>