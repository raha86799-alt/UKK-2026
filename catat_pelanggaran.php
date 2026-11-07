<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'Catat Pelanggaran';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

if ($db_pdo) {
    $db_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// 1. Ambil atau buat otomatis tahun ajaran aktif
$tahun_ajaran_id = 1;
if ($db_pdo) {
    try {
        $q_ta = "SELECT id FROM t_tahun_ajaran ORDER BY id DESC LIMIT 1";
        $stmt_ta = $db_pdo->query($q_ta);
        $ta_row = $stmt_ta->fetch(PDO::FETCH_ASSOC);
        if ($ta_row) {
            $tahun_ajaran_id = $ta_row['id'];
        } else {
            $db_pdo->exec("INSERT INTO t_tahun_ajaran (nama) VALUES ('2025/2026')");
            $tahun_ajaran_id = $db_pdo->lastInsertId();
        }
    } catch (Exception $e) {
        $tahun_ajaran_id = 1;
    }
}

// Ambil data guru yang sedang login
$guru_id = $_SESSION['user_id'] ?? $_SESSION['id'] ?? 1;
$nama_guru = $_SESSION['name'] ?? $_SESSION['nama'] ?? 'Guru Piket';
if ($db_pdo) {
    try {
        $stmt_g = $db_pdo->prepare("SELECT id, nama FROM t_guru WHERE user_id = ? OR id = ? LIMIT 1");
        $stmt_g->execute([$guru_id, $guru_id]);
        $g_row = $stmt_g->fetch(PDO::FETCH_ASSOC);
        if ($g_row) {
            $guru_id = $g_row['id'];
            $nama_guru = $g_row['nama'];
        }
    } catch (Exception $e) {}
}

$error_debug = '';

// 2. Proses Simpan Data Ketika Tombol Diklik
if (isset($_POST['submit'])) {
    $siswa_id       = $_POST['siswa_id'] ?? '';
    $pelanggaran_id = $_POST['pelanggaran_id'] ?? '';
    $tindakan       = trim($_POST['tindakan'] ?? '');
    $tanggal        = $_POST['tanggal'] ?? date('Y-m-d');
    $keterangan     = trim($_POST['keterangan'] ?? '');

    if ($db_pdo && !empty($siswa_id) && !empty($pelanggaran_id)) {
        try {
            // Ambil data siswa & kelas
            $nama_siswa = '';
            $kelas_id = 1;
            $nama_kelas = '-';

            $stmt_s = $db_pdo->prepare("SELECT s.nama, k.id as kelas_id, k.nama as nama_kelas FROM t_siswa s LEFT JOIN t_kelas_siswa ks ON ks.siswa_id = s.id AND ks.status_aktif = 1 LEFT JOIN t_kelas k ON k.id = ks.kelas_id WHERE s.id = ? LIMIT 1");
            $stmt_s->execute([$siswa_id]);
            $s_row = $stmt_s->fetch(PDO::FETCH_ASSOC);
            if ($s_row) {
                $nama_siswa = $s_row['nama'] ?? '';
                if (!empty($s_row['kelas_id'])) {
                    $kelas_id = $s_row['kelas_id'];
                    $nama_kelas = $s_row['nama_kelas'] ?? '-';
                }
            }

            // Ambil data pelanggaran, poin, dan kategori
            $nama_pelanggaran = '';
            $poin = 0;
            $pelanggaran_kategori_id = null;

            $stmt_p = $db_pdo->prepare("SELECT * FROM t_pelanggaran WHERE id = ? LIMIT 1");
            $stmt_p->execute([$pelanggaran_id]);
            $p_row = $stmt_p->fetch(PDO::FETCH_ASSOC);
            if ($p_row) {
                $nama_pelanggaran = $p_row['nama'] ?? $p_row['nama_pelanggaran'] ?? '';
                $poin = $p_row['poin'] ?? 0;
                $pelanggaran_kategori_id = $p_row['pelanggaran_kategori_id'] ?? $p_row['id'] ?? null;
            }

            // Simpan ke t_pelanggaran_siswa dengan melengkapi seluruh kolom
            $stmt = $db_pdo->prepare("INSERT INTO t_pelanggaran_siswa 
                (tahun_ajaran_id, siswa_id, nama_siswa, kelas_id, nama_kelas, pelanggaran_id, nama_pelanggaran, pelanggaran_kategori_id, guru_id, nama_guru, tanggal, keterangan, poin, tindakan, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Diproses', NOW(), NOW())");
            
            $insert = $stmt->execute([
                $tahun_ajaran_id, 
                $siswa_id, 
                $nama_siswa, 
                $kelas_id, 
                $nama_kelas, 
                $pelanggaran_id, 
                $nama_pelanggaran, 
                $pelanggaran_kategori_id, 
                $guru_id, 
                $nama_guru, 
                $tanggal, 
                $keterangan, 
                $poin, 
                $tindakan
            ]);
            
            if ($insert) {
                echo "<script>alert('Catatan pelanggaran berhasil disimpan!'); window.location='catat_pelanggaran.php';</script>";
                exit;
            }
        } catch (Exception $e) {
            $error_debug = $e->getMessage();
        }
    } else {
        $error_debug = "Silakan pilih siswa dan jenis pelanggaran terlebih dahulu!";
    }
}

// 3. Ambil data siswa & jenis pelanggaran untuk dropdown
$siswa_list = [];
$jenis_pelanggaran = [];

if ($db_pdo) {
    try {
        $siswa_list = $db_pdo->query("SELECT s.id, s.nis, s.nama, k.nama as nama_kelas FROM t_siswa s LEFT JOIN t_kelas_siswa ks ON ks.siswa_id = s.id AND ks.status_aktif = 1 LEFT JOIN t_kelas k ON k.id = ks.kelas_id WHERE s.status_aktif = 1 ORDER BY s.nama ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        try {
            $siswa_list = $db_pdo->query("SELECT id, nama FROM t_siswa ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {}
    }

    try {
        $jenis_pelanggaran = $db_pdo->query("SELECT id, nama, poin FROM t_pelanggaran ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        try {
            $jenis_pelanggaran = $db_pdo->query("SELECT id, nama_pelanggaran as nama, poin FROM t_pelanggaran ORDER BY nama_pelanggaran ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {}
    }
}
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

                <?php if (!empty($error_debug)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Detail Error Database:</strong> <br>
                        <?= htmlspecialchars($error_debug) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="siswa_id" class="form-label fw-bold">Pilih Siswa</label>
                        <select class="form-select" id="siswa_id" name="siswa_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php foreach ($siswa_list as $s): ?>
                                <?php 
                                    // Membuat format teks dropdown secara dinamis
                                    $label_siswa = $s['nama'] ?? '';
                                    if (!empty($s['nis'])) {
                                        $label_siswa = $s['nis'] . ' - ' . $label_siswa;
                                    }
                                    if (!empty($s['nama_kelas'])) {
                                        $label_siswa .= ' (' . $s['nama_kelas'] . ')';
                                    }
                                ?>
                                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($label_siswa) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pelanggaran_id" class="form-label fw-bold">Jenis Pelanggaran</label>
                        <select class="form-select" id="pelanggaran_id" name="pelanggaran_id" required>
                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                            <?php foreach ($jenis_pelanggaran as $jp): ?>
                                <option value="<?= $jp['id'] ?>">
                                    <?= htmlspecialchars($jp['nama'] ?? 'Pelanggaran') ?> 
                                    <?= isset($jp['poin']) ? '(Poin: ' . $jp['poin'] . ')' : '' ?>
                                </option>
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