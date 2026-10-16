<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin', 'wali_kelas']);
}

$title = 'Catat Pelanggaran';$section = 'admin';

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

// Proses Simpan Data Pelanggaran Siswa
if (isset($_POST['simpan'])) {
    $siswa_id           =$_POST['siswa_id'] ?? null;
    $pelanggaran_id     =$_POST['pelanggaran_id'] ?? null;
    $tanggal            =$_POST['tanggal'] ?? date('Y-m-d');
    $keterangan_catatan = trim($_POST['keterangan'] ?? '');

    if ($db_pdo && $siswa_id &&$pelanggaran_id) {
        try {
            // Ambil data siswa (nama & kelas)
            $stmtSiswa =$db_pdo->prepare("
                SELECT s.nama AS nama_siswa, k.nama AS nama_kelas 
                FROM t_siswa s 
                LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
                LEFT JOIN t_kelas k ON ks.kelas_id = k.id
                WHERE s.id = ?
            ");
            $stmtSiswa->execute([$siswa_id]);
            $dataSiswa =$stmtSiswa->fetch(PDO::FETCH_ASSOC);

            // Ambil data jenis pelanggaran (nama & poin)
            $stmtPelanggaran =$db_pdo->prepare("SELECT nama, poin FROM t_pelanggaran WHERE id = ?");
            $stmtPelanggaran->execute([$pelanggaran_id]);
            $dataPelanggaran =$stmtPelanggaran->fetch(PDO::FETCH_ASSOC);

            // Ambil nama guru yang sedang login
            $nama_guru = $_SESSION['nama_user'] ?? $_SESSION['username'] ?? 'Admin';

            if ($dataSiswa &&$dataPelanggaran) {
                $nama_siswa       =$dataSiswa['nama_siswa'];
                $nama_kelas       =$dataSiswa['nama_kelas'] ?? '-';
                $nama_pelanggaran =$dataPelanggaran['nama'];
                $poin             =$dataPelanggaran['poin'];

                // Insert ke tabel t_pelanggaran_siswa sesuai struktur laporan
                $stmtInsert =$db_pdo->prepare("
                    INSERT INTO t_pelanggaran_siswa 
                    (tanggal, nama_siswa, nama_kelas, nama_pelanggaran, poin, nama_guru, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())
                ");
                $stmtInsert->execute([
                    $tanggal,$nama_siswa,
                    $nama_kelas,$nama_pelanggaran,
                    $poin,$nama_guru
                ]);

                echo "<script>alert('Pencatatan pelanggaran berhasil disimpan!'); window.location='laporan.php';</script>";
                exit;
            } else {
                echo "<script>alert('Data siswa atau jenis pelanggaran tidak valid!');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Gagal menyimpan data: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Mohon lengkapi seluruh pilihan form!');</script>";
    }
}

// Ambil daftar siswa untuk dropdown
$listSiswa = [];$listPelanggaran = [];
if ($db_pdo) {
    $stmtS =$db_pdo->query("SELECT id, nama FROM t_siswa ORDER BY nama ASC");
    $listSiswa =$stmtS->fetchAll(PDO::FETCH_ASSOC);

    $stmtP =$db_pdo->query("SELECT id, kode, nama, poin FROM t_pelanggaran WHERE status_aktif = 1 ORDER BY nama ASC");
    $listPelanggaran =$stmtP->fetchAll(PDO::FETCH_ASSOC);
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
                <li class="nav-item"><a href="jenis_pelanggaran.php" class="nav-link">Jenis Pelanggaran</a></li>
                <li class="nav-item"><a href="laporan.php" class="nav-link">Cetak / Laporan</a></li>
                <li class="text-muted small mt-3 mb-1 px-2 fw-bold text-uppercase">PELANGGARAN</li>
                <li class="nav-item"><a href="catat_pelanggaran.php" class="nav-link active">Catat Pelanggaran</a></li>
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Formulir pencatatan pelanggaran siswa yang tersimpan pada tabel <code>t_pelanggaran_siswa</code>.</p>
                </div>
                <div>
                    <a href="laporan.php" class="btn btn-info btn-sm text-white fw-semibold">Lihat Laporan</a>
                    <a href="tindakan.php" class="btn btn-secondary btn-sm fw-semibold">Kelola Tindakan</a>
                </div>
            </div>
            <hr>

            <form method="POST">
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal Kejadian</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-3">
                    <label for="siswa_id" class="form-label fw-bold">Pilih Siswa</label>
                    <select class="form-select" id="siswa_id" name="siswa_id" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php foreach ($listSiswa as$s): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pelanggaran_id" class="form-label fw-bold">Jenis Pelanggaran</label>
                    <select class="form-select" id="pelanggaran_id" name="pelanggaran_id" required>
                        <option value="">-- Pilih Jenis Pelanggaran --</option>
                        <?php foreach ($listPelanggaran as$p): ?>
                            <option value="<?= $p['id'] ?>">
                                [<?= htmlspecialchars($p['kode']) ?>] <?= htmlspecialchars($p['nama']) ?> (<?=$p['poin'] ?> Poin)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label fw-bold">Keterangan Tambahan (Opsional)</label>
                    <textarea class="form-control" id="k