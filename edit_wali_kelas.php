<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Ubah Wali Kelas';
$section = 'admin';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

$id = $_GET['id'] ?? null;
if (!$id || !$db_pdo) {
    echo "<script>alert('ID tidak valid!'); window.location='kelola_wali_kelas.php';</script>";
    exit;
}

// Ambil data wali kelas berdasarkan ID
$stmt = $db_pdo->prepare("SELECT * FROM t_wali_kelas WHERE id = ?");
$stmt->execute([$id]);
$wali = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$wali) {
    echo "<script>alert('Data wali kelas tidak ditemukan!'); window.location='kelola_wali_kelas.php';</script>";
    exit;
}

// Proses Update Data
if (isset($_POST['update'])) {
    $guru_id         = $_POST['guru_id'];
    $kelas_id        = $_POST['kelas_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $status_aktif    = $_POST['status_aktif'];

    try {
        $updateStmt = $db_pdo->prepare("UPDATE t_wali_kelas SET guru_id = ?, kelas_id = ?, tahun_ajaran_id = ?, status_aktif = ?, updated_at = NOW() WHERE id = ?");
        $update = $updateStmt->execute([$guru_id, $kelas_id, $tahun_ajaran_id, $status_aktif, $id]);

        if ($update) {
            echo "<script>alert('Data wali kelas berhasil diubah!'); window.location='kelola_wali_kelas.php';</script>";
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

        <!-- KONTEN UTAMA FORM UBAH WALI KELAS -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Perbarui data penugasan guru sebagai wali kelas.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="guru_id" class="form-label fw-bold">Guru</label>
                        <select class="form-select" id="guru_id" name="guru_id" required>
                            <option value="">-- Pilih Guru --</option>
                            <?php
                            if ($db_pdo) {
                                $guruList = $db_pdo->query("SELECT id, nip, nama FROM t_guru ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($guruList as $g) {
                                    $selected = ($g['id'] == $wali['guru_id']) ? 'selected' : '';
                                    echo "<option value='{$g['id']}' {$selected}>{$g['nip']} - {$g['nama']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kelas_id" class="form-label fw-bold">Kelas</label>
                        <select class="form-select" id="kelas_id" name="kelas_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php
                            if ($db_pdo) {
                                $kelasList = $db_pdo->query("SELECT id, nama FROM t_kelas ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($kelasList as $k) {
                                    $selected = ($k['id'] == $wali['kelas_id']) ? 'selected' : '';
                                    echo "<option value='{$k['id']}' {$selected}>{$k['nama']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tahun_ajaran_id" class="form-label fw-bold">Tahun Ajaran</label>
                        <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php
                            if ($db_pdo) {
                                $tahunList = $db_pdo->query("SELECT id, nama FROM t_tahun_ajaran ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($tahunList as $ta) {
                                    $selected = ($ta['id'] == $wali['tahun_ajaran_id']) ? 'selected' : '';
                                    echo "<option value='{$ta['id']}' {$selected}>{$ta['nama']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_aktif" class="form-label fw-bold">Status Aktif</label>
                        <select class="form-select" id="status_aktif" name="status_aktif" required>
                            <option value="1" <?= ($wali['status_aktif'] == 1) ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= ($wali['status_aktif'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="update" class="btn btn-warning fw-semibold px-4 text-dark">Simpan Perubahan</button>
                        <a href="kelola_wali_kelas.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>