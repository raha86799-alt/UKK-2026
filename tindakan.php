<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'Rekap Poin Siswa';
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

                <li class="nav-item"><a href="catat_pelanggaran.php" class="nav-link">Catat Pelanggaran</a></li>
                <li class="nav-item"><a href="tindakan.php" class="nav-link active">Tindakan</a></li>
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
                <h2><?= htmlspecialchars($title) ?></h2>
                <p class="text-muted mb-0">Daftar tindakan penanganan pelanggaran siswa berdasarkan data pada tabel <code>t_pelanggaran_siswa</code>.</p>
            </div>
            <hr>

            <div class="table-responsive">
                <!-- Tambahkan id="tableTindakan" pada tag table -->
                <table id="tableTindakan" class="table table-bordered table-striped align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Siswa</th>
                            <th>Pelanggaran</th>
                            <th>Poin</th>
                            <th>Tindakan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($db_pdo) {
                            try {
                                $stmt = $db_pdo->query("
                                    SELECT nama_siswa, nama_pelanggaran, poin, tindakan, status 
                                    FROM t_pelanggaran_siswa 
                                    ORDER BY tanggal DESC, id DESC 
                                    LIMIT 100
                                ");
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($rows) > 0) {
                                    foreach ($rows as $i => $r) {
                                        ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <td><?= htmlspecialchars($r['nama_siswa'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($r['nama_pelanggaran'] ?? '-') ?></td>
                                            <td><span class="badge bg-danger"><?= (int)($r['poin'] ?? 0) ?> Poin</span></td>
                                            <td><?= htmlspecialchars($r['tindakan'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($r['status'] ?? '-') ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data tindakan pelanggaran.</td></tr>';
                                }
                            } catch (Exception $e) {
                                echo '<tr><td colspan="6" class="text-center text-danger py-4">Error memuat data: ' . $e->getMessage() . '</td></tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center text-danger py-4">Koneksi database belum terhubung dengan benar.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
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
        $('#tableTindakan').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json" // Mengubah teks DataTables menjadi Bahasa Indonesia
            }
        });
    });
</script>
</body>
</html>