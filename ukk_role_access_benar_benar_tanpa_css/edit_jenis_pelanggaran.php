<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Ubah Jenis Pelanggaran';
$section = 'admin';

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

$id = $_GET['id'] ?? null;
if (!$id || !$db_pdo) {
    echo "<script>alert('ID tidak valid!'); window.location='jenis_pelanggaran.php';</script>";
    exit;
}

// Ambil data jenis pelanggaran berdasarkan ID
$stmt = $db_pdo->prepare("SELECT * FROM t_pelanggaran WHERE id = ?");
$stmt->execute([$id]);
$pelanggaran = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelanggaran) {
    echo "<script>alert('Data jenis pelanggaran tidak ditemukan!'); window.location='jenis_pelanggaran.php';</script>";
    exit;
}

// Proses Update Data
if (isset($_POST['update'])) {
    $pelanggaran_kategori_id = $_POST['pelanggaran_kategori_id'];
    $kode = trim($_POST['kode']);
    $nama = trim($_POST['nama']);
    $poin = $_POST['poin'];
    $deksripsi = trim($_POST['deksripsi']);
    $status_aktif = $_POST['status_aktif'];

    try {
        $updateStmt = $db_pdo->prepare("
            UPDATE t_pelanggaran 
            SET pelanggaran_kategori_id = ?, kode = ?, nama = ?, poin = ?, deksripsi = ?, status_aktif = ?, updated_at = NOW() 
            WHERE id = ?
        ");
        $update = $updateStmt->execute([$pelanggaran_kategori_id, $kode, $nama, $poin, $deksripsi, $status_aktif, $id]);

        if ($update) {
            echo "<script>alert('Data jenis pelanggaran berhasil diubah!'); window.location='jenis_pelanggaran.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Gagal mengubah data: " . $e->getMessage() . "');</script>";
    }
}

// Ambil daftar kategori aktif untuk dropdown
$kategori = [];
if ($db_pdo) {
    $stmtKategori = $db_pdo->query("
        SELECT id, nama
        FROM t_pelanggaran_kategori
        WHERE status_aktif = 1
        ORDER BY nama ASC
    ");
    $kategori = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);
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
            <ul class="nav nav-pills flex-column">
                <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="kelola_siswa.php" class="nav-link">Kelola Siswa</a></li>
                <li class="nav-item"><a href="kelola_guru.php" class="nav-link">Kelola Guru</a></li>
                <li class="nav-item"><a href="kelola_kelas.php" class="nav-link">Kelola Kelas</a></li>
                <li class="nav-item"><a href="kelola_tahun_ajaran.php" class="nav-link">Kelola Tahun Ajaran</a></li>
                <li class="nav-item"><a href="penempatan_siswa.php" class="nav-link">Penempatan Siswa</a></li>
                <li class="nav-item"><a href="kelola_wali_kelas.php" class="nav-link">Kelola Wali Kelas</a></li>
                <li class="nav-item"><a href="kategori_pelanggaran.php" class="nav-link">Kategori Pelanggaran</a></li>
                <li class="nav-item"><a href="jenis_pelanggaran.php" class="nav-link active">Jenis Pelanggaran</a></li>
                <li class="nav-item"><a href="laporan.php" class="nav-link">Cetak / Laporan</a></li>
                <li class="text-muted small mt-3 mb-1 px-2 fw-bold text-uppercase">PELANGGARAN</li>
                <li class="nav-item"><a href="catat_pelanggaran.php" class="nav-link">Catat Pelanggaran</a></li>
                <li class="nav-item"><a href="tindakan.php" class="nav-link">Tindakan</a></li>
                <li class="nav-item"><a href="laporan.php" class="nav-link">Laporan</a></li>
                <li class="nav-item"><a href="riwayat.php" class="nav-link">Riwayat</a></li>
                <li class="nav-item"><a href="rekap_poin.php" class="nav-link">Rekap Poin</a></li>
            </ul>
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
                <h2>Ubah Jenis Pelanggaran</h2>
                <p class="text-muted mb-0">Perbarui informasi data jenis pelanggaran dan bobot poin.</p>
            </div>
            <hr>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="pelanggaran_kategori_id" class="form-label fw-bold">Kategori Pelanggaran</label>
                    <select class="form-select" id="pelanggaran_kategori_id" name="pelanggaran_kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($row['id'] == $pelanggaran['pelanggaran_kategori_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kode" class="form-label fw-bold">Kode Pelanggaran</label>
                    <input type="text" class="form-control" id="kode" name="kode" value="<?= htmlspecialchars($pelanggaran['kode']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Pelanggaran</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($pelanggaran['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="poin" class="form-label fw-bold">Poin Pelanggaran</label>
                    <input type="number" class="form-control" id="poin" name="poin" min="0" value="<?= htmlspecialchars($pelanggaran['poin']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="deksripsi" class="form-label fw-bold">Deskripsi</label>
                    <textarea class="form-control" id="deksripsi" name="deksripsi" rows="4" required><?= htmlspecialchars($pelanggaran['deksripsi']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="status_aktif" class="form-label fw-bold">Status Aktif</label>
                    <select class="form-select" id="status_aktif" name="status_aktif" required>
                        <option value="1" <?= ($pelanggaran['status_aktif'] == 1) ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= ($pelanggaran['status_aktif'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" name="update" class="btn btn-warning fw-semibold px-4 text-dark">Simpan Perubahan</button>
                    <a href="jenis_pelanggaran.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>