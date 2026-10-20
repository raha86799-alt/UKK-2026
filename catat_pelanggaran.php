<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'Catat Pelanggaran';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

if (isset($_POST['submit'])) {
    $siswa_id       = $_POST['siswa_id'] ?? '';
    $pelanggaran_id = $_POST['pelanggaran_id'] ?? '';
    $tindakan       = trim($_POST['tindakan'] ?? '');
    $tanggal        = $_POST['tanggal'] ?? date('Y-m-d');
    $keterangan     = trim($_POST['keterangan'] ?? '');
    $guru_id        = $_SESSION['user_id'] ?? 1; // Sesuaikan dengan session id guru yang login

    if ($db_pdo) {
        try {
            $stmt = $db_pdo->prepare("INSERT INTO t_pelanggaran_siswa (siswa_id, pelanggaran_id, tindakan, tanggal, keterangan, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $insert = $stmt->execute([$siswa_id, $pelanggaran_id, $tindakan, $tanggal, $keterangan]);
            
            if ($insert) {
                echo "<script>alert('Catatan pelanggaran berhasil disimpan!'); window.location='riwayat_pelanggaran.php';</script>";
            } else {
                echo "<script>alert('Gagal menyimpan catatan pelanggaran.');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}

// Ambil data siswa dan jenis pelanggaran untuk dropdown
$siswa_list = $db_pdo ? $db_pdo->query("SELECT id, nama FROM t_siswa WHERE status_aktif = 1 ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC) : [];
$jenis_pelanggaran = $db_pdo ? $db_pdo->query("SELECT id, nama, deksripsi FROM t_pelanggaran_kategori ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC) : [];
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
                    <h2>Catat Pelanggaran Siswa</h2>
                    <p class="text-muted mb-0">Formulir pencatatan pelanggaran dan tindakan disiplin siswa.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label fw-bold">Pilih Siswa</label>
                        <select class="form-select" id="siswa_id" name="siswa_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($siswa_list as $s): ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pelanggaran_id" class="form-label fw-bold">Jenis Pelanggaran</label>
                        <select class="form-select" id="pelanggaran_id" name="pelanggaran_id" required>
                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                            <?php foreach ($jenis_pelanggaran as $jp): ?>
                                <option value="<?= $jp['id'] ?>"><?= htmlspecialchars($jp['nama']) ?> (<?= htmlspecialchars($jp['deksripsi']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tindakan" class="form-label fw-bold">Tindakan / Sanksi</label>
                        <input type="text" class="form-control" id="tindakan" name="tindakan" placeholder="Contoh: Teguran lisan / Panggilan Orang Tua / Skorsing 3 Hari" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label fw-bold">Tanggal Kejadian</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-bold">Keterangan Tambahan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Catatan detail kronologi kejadian..."></textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan Catatan</button>
                        <a href="dashboard.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>