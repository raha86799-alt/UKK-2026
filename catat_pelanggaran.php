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
$tahun_ajaran_nama = '2026/2027';
if ($db_pdo) {
    try {
        $q_ta = "SELECT id, nama FROM t_tahun_ajaran ORDER BY id DESC LIMIT 1";
        $stmt_ta = $db_pdo->query($q_ta);
        $ta_row = $stmt_ta->fetch(PDO::FETCH_ASSOC);
        if ($ta_row) {
            $tahun_ajaran_id = $ta_row['id'];
            $tahun_ajaran_nama = $ta_row['nama'];
        } else {
            $db_pdo->exec("INSERT INTO t_tahun_ajaran (nama) VALUES ('2026/2027')");
            $tahun_ajaran_id = $db_pdo->lastInsertId();
        }
    } catch (Exception $e) {
        $tahun_ajaran_id = 1;
    }
}

// Ambil data guru yang sedang login
$guru_id = $_SESSION['user_id'] ?? $_SESSION['id'] ?? 1;
$nama_guru = $_SESSION['name'] ?? $_SESSION['nama'] ?? 'Guru';
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
    $kelas_id       = $_POST['kelas_id'] ?? 1;
    $pelanggaran_id = $_POST['pelanggaran_id'] ?? '';
    $tindakan       = trim($_POST['tindakan'] ?? '');
    $tanggal        = $_POST['tanggal'] ?? date('Y-m-d');
    $status         = $_POST['status'] ?? 'Proses';
    $keterangan     = trim($_POST['keterangan'] ?? '');

    if ($db_pdo && !empty($siswa_id) && !empty($pelanggaran_id)) {
        try {
            $nama_siswa = '';
            $nama_kelas = '-';

            // Ambil nama siswa
            $stmt_s = $db_pdo->prepare("SELECT nama FROM t_siswa WHERE id = ? LIMIT 1");
            $stmt_s->execute([$siswa_id]);
            $s_row = $stmt_s->fetch(PDO::FETCH_ASSOC);
            if ($s_row) {
                $nama_siswa = $s_row['nama'] ?? '';
            }

            // Ambil nama kelas berdasarkan kelas_id yang dipilih/diinput
            $stmt_k = $db_pdo->prepare("SELECT nama FROM t_kelas WHERE id = ? LIMIT 1");
            $stmt_k->execute([$kelas_id]);
            $k_row = $stmt_k->fetch(PDO::FETCH_ASSOC);
            if ($k_row) {
                $nama_kelas = $k_row['nama'] ?? '-';
            }

            // Ambil data pelanggaran & poin
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

            // Simpan ke t_pelanggaran_siswa
            $stmt = $db_pdo->prepare("INSERT INTO t_pelanggaran_siswa 
                (tahun_ajaran_id, siswa_id, nama_siswa, kelas_id, nama_kelas, pelanggaran_id, nama_pelanggaran, pelanggaran_kategori_id, guru_id, nama_guru, tanggal, keterangan, poin, tindakan, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            
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
                $tindakan,
                $status
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
$kelas_list = [];

if ($db_pdo) {
    try {
        $siswa_list = $db_pdo->query("SELECT s.id, 
                                             COALESCE(s.nis, s.nisn, '-') as nis, 
                                             s.nama, 
                                             k.id as kelas_id, 
                                             k.nama as nama_kelas 
                                      FROM t_siswa s 
                                      LEFT JOIN t_kelas_siswa ks ON ks.siswa_id = s.id AND ks.status_aktif = 1 
                                      LEFT JOIN t_kelas k ON k.id = ks.kelas_id 
                                      WHERE s.status_aktif = 1 
                                      ORDER BY s.nama ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        try {
            $siswa_list = $db_pdo->query("SELECT id, '-' as nis, nama, NULL as kelas_id, NULL as nama_kelas FROM t_siswa WHERE status_aktif = 1 ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {}
    }

    try {
        $jenis_pelanggaran = $db_pdo->query("SELECT id, nama, poin FROM t_pelanggaran ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        try {
            $jenis_pelanggaran = $db_pdo->query("SELECT id, nama_pelanggaran as nama, poin FROM t_pelanggaran ORDER BY nama_pelanggaran ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {}
    }

    try {
        $kelas_list = $db_pdo->query("SELECT id, nama FROM t_kelas ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
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
        body { background-color: #f4f6f9; overflow-x: hidden; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .content-card { background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #333; }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">
        <?php include "layout/sidebar.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Catat Pelanggaran</h3>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">SISTEM INFORMASI PELANGGARAN SISWA</p>
                </div>
                <div>
                    <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">
                        📅 Tahun Ajaran Aktif: <?= htmlspecialchars($tahun_ajaran_nama) ?>
                    </span>
                </div>
            </div>

            <div class="content-card shadow-sm">
                <h4 class="fw-bold mb-4" style="color: #2c3e50;">Form Input Pelanggaran Siswa</h4>

                <?php if (!empty($error_debug)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Detail Error:</strong> <?= htmlspecialchars($error_debug) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="row g-3 mb-3">
                        <!-- Tanggal Kejadian -->
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Tanggal Kejadian</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <!-- Siswa -->
                        <div class="col-md-4">
                            <label for="siswa_id" class="form-label">Siswa</label>
                            <select class="form-select" id="siswa_id" name="siswa_id" required>
                                <option value="">-- Pilih Siswa --</option>
                                <?php foreach ($siswa_list as $s): ?>
                                    <option value="<?= $s['id'] ?>" data-kelas="<?= $s['kelas_id'] ?? '' ?>">
                                        <?= htmlspecialchars($s['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Kelas (Sekarang Aktif dan Dapat Diakses/Diubah) -->
                        <div class="col-md-4">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($kelas_list as $k): ?>
                                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Jenis Pelanggaran -->
                        <div class="col-md-12">
                            <label for="pelanggaran_id" class="form-label">Jenis Pelanggaran</label>
                            <select class="form-select" id="pelanggaran_id" name="pelanggaran_id" required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                <?php foreach ($jenis_pelanggaran as $jp): ?>
                                    <option value="<?= $jp['id'] ?>">
                                        <?= htmlspecialchars($jp['nama'] ?? 'Pelanggaran') ?> 
                                        <?= isset($jp['poin']) ? '(Poin: ' . $jp['poin'] . ')' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Tindakan Pembinaan -->
                        <div class="col-md-12">
                            <label for="tindakan" class="form-label">Tindakan Pembinaan</label>
                            <input type="text" class="form-control" id="tindakan" name="tindakan" placeholder="Contoh: Teguran lisan / Panggilan Orang Tua / Skorsing" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Status Pembinaan -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status Pembinaan</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dalam Pengawasan">Dalam Pengawasan</option>
                            </select>
                        </div>

                        <!-- Keterangan Tambahan -->
                        <div class="col-md-6">
                            <label for="keterangan" class="form-label">Keterangan Tambahan (Opsional)</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Catatan atau kronologi singkat...">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-primary fw-semibold px-4 text-white">Simpan Data</button>
                        <a href="dashboard.php" class="btn btn-secondary fw-semibold px-4 ms-2">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Skrip otomatis mengisi kelas saat siswa dipilih, namun tetap bisa diubah manual
    $(document).ready(function() {
        $('#siswa_id').on('change', function() {
            let kelasId = $(this).find(':selected').data('kelas');
            if (kelasId) {
                $('#kelas_id').val(kelasId);
            } else {
                $('#kelas_id').val('');
            }
        });
    });
</script>
</body>
</html>