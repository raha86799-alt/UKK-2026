<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Wali Kelas';
$section = 'admin';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

if (isset($_POST['submit'])) {
    $guru_id         = $_POST['guru_id'];
    $kelas_id        = $_POST['kelas_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $status_aktif    = $_POST['status_aktif'] ?? 1;

    if ($db_pdo) {
        try {
            $stmt = $db_pdo->prepare("INSERT INTO t_wali_kelas (guru_id, kelas_id, tahun_ajaran_id, status_aktif, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $insert = $stmt->execute([$guru_id, $kelas_id, $tahun_ajaran_id, $status_aktif]);

            if ($insert) {
                echo "<script>alert('Data wali kelas berhasil ditambahkan!'); window.location='kelola_wali_kelas.php';</script>";
                exit;
            }
        } catch (Exception $e) {
            echo "<script>alert('Gagal menyimpan data: " . $e->getMessage() . "');</script>";
        }
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

        <!-- KONTEN UTAMA FORM TAMBAH WALI KELAS -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Formulir penugasan guru sebagai wali kelas.</p>
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
                                    echo "<option value='{$g['id']}'>{$g['nip']} - {$g['nama']}</option>";
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
                                    echo "<option value='{$k['id']}'>{$k['nama']}</option>";
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
                                    echo "<option value='{$ta['id']}'>{$ta['nama']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_aktif" class="form-label fw-bold">Status Aktif</label>
                        <select class="form-select" id="status_aktif" name="status_aktif" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
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