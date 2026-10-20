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
        // Cek apakah kolom updated_at ada di tabel, jika tidak gunakan query tanpa updated_at
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
        .bg-custom-sidebar { background-color: #000000; min-height: 100vh; }
        body { background-color: #f2f2f2; overflow-x: hidden; }
        .nav-pills .nav-link { color: #cfd3d6; border-radius: 6px; transition: all 0.2s ease-in-out; margin-bottom: 4px; }
        .nav-pills .nav-link:hover { background-color: #333333; color: #ffffff; transform: translateX(5px); }
        .nav-pills .nav-link.active { background-color: #00bcd4 !important; color: #ffffff !important; font-weight: bold; transform: translateX(5px); }
        .content-card { background-color: #ffffff; border: 1px solid #ddd; border-radius: 6px; padding: 25px; }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <!-- SIDEBAR LENGKAP -->
    <div class="col-md-3 col-lg-2 bg-custom-sidebar p-3 d-flex flex-column justify-content-between">
        <div>
            <h4 class="text-white mb-4 fw-bold pb-2 border-bottom border-secondary">My Website</h4>
                   <li class="nav-item">
                    <a href="dashboard.php" class="nav-link active">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_siswa.php" class="nav-link">Data Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_guru.php" class="nav-link">Data Guru</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_kelas.php" class="nav-link">Kelas</a>
                </li>
                  <li class="nav-item">
                    <a href="penempatan_siswa.php" class="nav-link">Penempatan Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kategori_pelanggaran.php" class="nav-link">Kategori pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="About.php" class="nav-link">About</a>
                </li>
        </div>
        <div>
            <hr class="text-secondary">
            <a href="logout.php" class="btn text-white w-100 text-start fw-bold" style="background-color: #a91d3a;">Logout</a>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow-1 p-4">
        <div class="content-card shadow-sm">
            <div class="mb-3">
                <h2>Ubah Tahun Ajaran</h2>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>