<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

// Mengizinkan Admin mengakses halaman ini
if (function_exists('requireRole')) {
    requireRole(['admin', 'guru', 'wali_kelas']);
}

$title = 'Rekap Poin & Akumulasi Pelanggaran Siswa'; 
$section = 'admin';

// Koneksi database (PDO compatible)
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
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

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Ringkasan total frekuensi, kelas, dan akumulasi poin pelanggaran untuk setiap siswa.</p>
                </div>
                <hr>

                <div class="table-responsive">
                    <table id="tableRekap" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Total Pelanggaran</th>
                                <th>Total Poin</th>
                                <th>Status Poin / Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($db_pdo) {
                                try {
                                    // Query rekap poin per siswa menggunakan NIS yang ada di t_siswa
                                    $sql = "SELECT s.id, s.nis, s.nama AS nama_siswa, k.nama AS nama_kelas, 
                                                   COUNT(ps.id) AS total_pelanggaran, 
                                                   COALESCE(SUM(ps.poin), 0) AS total_poin 
                                            FROM t_siswa s
                                            LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id AND ks.status_aktif = 1
                                            LEFT JOIN t_kelas k ON ks.kelas_id = k.id
                                            LEFT JOIN t_pelanggaran_siswa ps ON s.id = ps.siswa_id
                                            GROUP BY s.id, s.nis, s.nama, k.nama
                                            ORDER BY total_poin DESC, s.nama ASC";
                                            
                                    $rows = $db_pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($rows) > 0) {
                                        foreach ($rows as $i => $r) {
                                            $poin = $r['total_poin'];
                                            // Menentukan status/tindakan berdasarkan jumlah poin
                                            if ($poin >= 100) {
                                                $status_badge = '<span class="badge bg-danger">Poin Tinggi (Panggilan Orang Tua)</span>';
                                            } else if ($poin >= 50) {
                                                $status_badge = '<span class="badge bg-warning text-dark">Peringatan (Pembinaan BK)</span>';
                                            } else if ($poin > 0) {
                                                $status_badge = '<span class="badge bg-info text-dark">Teguran Wali Kelas</span>';
                                            } else {
                                                $status_badge = '<span class="badge bg-success">Aman / Tidak Ada Pelanggaran</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= htmlspecialchars($r['nis']) ?></td>
                                                <td><?= htmlspecialchars($r['nama_siswa']) ?></td>
                                                <td><?= htmlspecialchars($r['nama_kelas'] ?? '-') ?></td>
                                                <td class="text-center"><span class="badge bg-secondary"><?= $r['total_pelanggaran'] ?> Kasus</span></td>
                                                <td class="text-center fw-bold text-danger"><?= $r['total_poin'] ?> Poin</td>
                                                <td><?= $status_badge ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="7" class="text-center text-muted py-4">Belum ada data siswa di dalam database.</td></tr>';
                                    }
                                } catch (Exception $e) {
                                    echo '<tr><td colspan="7" class="text-center text-danger py-4">Error memuat rekap: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center text-danger py-4">Koneksi database belum terhubung dengan benar.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>
</div>

<!-- jQuery (Diperlukan oleh DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- Inisialisasi DataTable -->
<script>
    $(document).ready(function() {
        $('#tableRekap').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>