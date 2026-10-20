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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <?php include "layout/sidebar.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Rekap Poin & Akumulasi Pelanggaran Siswa</h2>
                    <p class="text-muted mb-0">Ringkasan total frekuensi pelanggaran untuk setiap siswa.</p>
                </div>
                <hr>

                <div class="table-responsive">
                    <table id="tableRekap" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Total Pelanggaran</th>
                                <th class="text-center">Status Poin / Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($db_pdo) {
                                try {
                                    $sql = "SELECT s.id, s.nisn, s.nama, COUNT(ps.id) AS total_pelanggaran 
                                            FROM t_siswa s 
                                            LEFT JOIN t_pelanggaran_siswa ps ON ps.siswa_id = s.id 
                                            WHERE s.status_aktif = 1 
                                            GROUP BY s.id, s.nisn, s.nama 
                                            ORDER BY total_pelanggaran DESC";
                                    $rows = $db_pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($rows) > 0) {
                                        foreach ($rows as $i => $r) {
                                            $total = (int)$r['total_pelanggaran'];
                                            // Menentukan status berdasarkan jumlah pelanggaran
                                            if ($total == 0) {
                                                $badge = '<span class="badge bg-success">Aman / Disiplin</span>';
                                            } elseif ($total <= 2) {
                                                $badge = '<span class="badge bg-warning text-dark">Peringatan Ringan</span>';
                                            } else {
                                                $badge = '<span class="badge bg-danger">Perlu Perhatian Khusus</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= htmlspecialchars($r['nisn'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($r['nama']) ?></td>
                                                <td class="text-center fw-bold fs-5"><?= $total ?></td>
                                                <td class="text-center"><?= $badge ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="5" class="text-center text-muted py-4">Belum ada data siswa.</td></tr>';
                                    }
                                } catch (Exception $e) {
                                    echo '<tr><td colspan="5" class="text-center text-danger py-4">Error memuat rekap: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                                }
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
        $('#tableRekap').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json" }
        });
    });
</script>
</body>
</html>