<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin', 'guru', 'wali_kelas']);
}

$title = 'Riwayat Pelanggaran';

$db_pdo = null;
if (isset($pdo) && $pdo instanceof PDO) {
    $db_pdo = $pdo;
} elseif (isset($conn) && $conn instanceof PDO) {
    $db_pdo = $conn;
} elseif (isset($koneksi) && $koneksi instanceof PDO) {
    $db_pdo = $koneksi;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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

        <!-- KONTEN UTAMA RIWAYAT -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2>Riwayat Pelanggaran</h2>
                        <p class="text-muted mb-0">Daftar lengkap riwayat pencatatan pelanggaran dan sanksi siswa.</p>
                    </div>
                    <?php if (in_array(strtolower($_SESSION['role'] ?? ''), ['guru', 'wali_kelas'])): ?>
                        <a href="catat_pelanggaran.php" class="btn btn-primary btn-sm fw-semibold">+ Catat Pelanggaran</a>
                    <?php endif; ?>
                </div>
                <hr>

                <div class="table-responsive">
                    <table id="tableRiwayat" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Tindakan / Sanksi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($db_pdo) {
                                try {
                                    $sql = "SELECT ps.id, ps.tanggal, s.nama AS siswa, kp.nama AS pelanggaran, ps.tindakan, ps.keterangan 
                                            FROM t_pelanggaran_siswa ps 
                                            JOIN t_siswa s ON s.id = ps.siswa_id 
                                            JOIN t_pelanggaran_kategori kp ON kp.id = ps.pelanggaran_id 
                                            ORDER BY ps.tanggal DESC, ps.id DESC";
                                    $rows = $db_pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($rows) > 0) {
                                        foreach ($rows as $i => $r) {
                                            ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= htmlspecialchars($r['tanggal']) ?></td>
                                                <td><?= htmlspecialchars($r['siswa']) ?></td>
                                                <td><?= htmlspecialchars($r['pelanggaran']) ?></td>
                                                <td><span class="badge bg-danger"><?= htmlspecialchars($r['tindakan']) ?></span></td>
                                                <td><?= htmlspecialchars($r['keterangan'] ?: '-') ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data riwayat pelanggaran.</td></tr>';
                                    }
                                } catch (Exception $e) {
                                    echo '<tr><td colspan="6" class="text-center text-danger py-4">Error memuat data: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-danger py-4">Koneksi database gagal dimuat.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#tableRiwayat')) {
            $('#tableRiwayat').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json" }
            });
        }
    });
</script>
</body>
</html>