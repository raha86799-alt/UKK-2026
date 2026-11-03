<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'Rekap Poin Siswa';
$section = 'admin';

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
        body { background-color: #f4f4f4; overflow-x: hidden; margin: 0; }
        .content-card { background-color: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .nav-pills .nav-link.active { background-color: #00bcd4 !important; color: #ffffff !important; font-weight: bold; }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">

        <!-- Sidebar Terpusat -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Daftar tindakan penanganan pelanggaran siswa berdasarkan data pada tabel <code>t_pelanggaran_siswa</code>.</p>
                </div>
                <hr>

                <div class="table-responsive">
                    <!-- Tabel Tindakan -->
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
                                    echo '<tr><td colspan="6" class="text-center text-danger py-4">Error memuat data: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
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
                "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>