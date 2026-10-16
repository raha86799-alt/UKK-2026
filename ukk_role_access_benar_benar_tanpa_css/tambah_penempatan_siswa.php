<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Penempatan Siswa';
$section = 'admin';

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

// Proses Simpan Data
if (isset($_POST['submit'])) {
    $siswa_id        = $_POST['siswa_id'];
    $kelas_id        = $_POST['kelas_id'];
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $status_aktif    = $_POST['status_aktif'] ?? 1;

    if ($db_pdo) {
        try {
            $stmt = $db_pdo->prepare("INSERT INTO t_kelas_siswa (siswa_id, kelas_id, tahun_ajaran_id, status_aktif, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $insert = $stmt->execute([$siswa_id, $kelas_id, $tahun_ajaran_id, $status_aktif]);

            if ($insert) {
                echo "<script>alert('Penempatan siswa berhasil ditambahkan!'); window.location='penempatan_siswa.php';</script>";
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
        .bg-custom-sidebar {
            background-color: #000000;
            min-height: 100vh;
        }
        body {
            background-color: #f2f2f2;
            overflow-x: hidden;
        }
        .nav-pills .nav-link {
            color: #cfd3d6;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            margin-bottom: 4px;
        }
        .nav-pills .nav-link:hover {
            background-color: #333333;
            color: #ffffff;
            transform: translateX(5px);
        }
        .nav-pills .nav-link.active {
            background-color: #00bcd4 !important;
            color: #ffffff !important;
            font-weight: bold;
            transform: translateX(5px);
        }
        .content-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 25px;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <!-- SIDEBAR LENGKAP -->
    <div class="col-md-3 col-lg-2 bg-custom-sidebar p-3 d-flex flex-column justify-content-between">
        <div>
            <h4 class="text-white mb-4 fw-bold pb-2 border-bottom border-secondary">
                My Website
            </h4>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_siswa.php" class="nav-link">Kelola Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_guru.php" class="nav-link">Kelola Guru</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_kelas.php" class="nav-link">Kelola Kelas</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_tahun_ajaran.php" class="nav-link">Kelola Tahun Ajaran</a>
                </li>
                <li class="nav-item">
                    <a href="penempatan_siswa.php" class="nav-link active">Penempatan Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_wali_kelas.php" class="nav-link">Kelola Wali Kelas</a>
                </li>
                <li class="nav-item">
                    <a href="kategori_pelanggaran.php" class="nav-link">Kategori Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="jenis_pelanggaran.php" class="nav-link">Jenis Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link">Cetak / Laporan</a>
                </li>
                
                <!-- PELANGGARAN -->
                <li class="text-muted small mt-3 mb-1 px-2 fw-bold text-uppercase">PELANGGARAN</li>
                <li class="nav-item">
                    <a href="catat_pelanggaran.php" class="nav-link">Catat Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="tindakan.php" class="nav-link">Tindakan</a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link">Laporan</a>
                </li>
                <li class="nav-item">
                    <a href="riwayat.php" class="nav-link">Riwayat</a>
                </li>
                <li class="nav-item">
                    <a href="rekap_poin.php" class="nav-link">Rekap Poin</a>
                </li>
            </ul>
        </div>
        <div>
            <hr class="text-secondary">
            <a href="logout.php" class="btn text-white w-100 text-start fw-bold" style="background-color: #a91d3a;">
                Logout
            </a>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow-1 p-4">
        <div class="content-card shadow-sm">
            <div class="mb-3">
                <h2>Tambah Penempatan Siswa</h2>
                <p class="text-muted mb-0">Formulir penempatan siswa ke dalam kelas dan tahun ajaran.</p>
            </div>
            <hr>

            <form action="" method="POST">
                <!-- Pilih Siswa -->
                <div class="mb-3">
                    <label for="siswa_id" class="form-label fw-bold">Siswa</label>
                    <select class="form-select" id="siswa_id" name="siswa_id" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php
                        if ($db_pdo) {
                            $siswaList = $db_pdo->query("SELECT id, nisn, nama FROM t_siswa ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($siswaList as $s) {
                                echo "<option value='{$s['id']}'>{$s['nisn']} - {$s['nama']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Pilih Kelas -->
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

                <!-- Pilih Tahun Ajaran -->
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

                <!-- Status Aktif -->
                <div class="mb-3">
                    <label for="status_aktif" class="form-label fw-bold">Status Aktif</label>
                    <select class="form-select" id="status_aktif" name="status_aktif" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
                    <a href="penempatan_siswa.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>