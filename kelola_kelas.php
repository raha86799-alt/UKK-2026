<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Kelola Kelas';
$section = 'admin';

// Memastikan variabel koneksi PDO tersedia
$db_pdo = $pdo ?? null;
if (!$db_pdo && isset($conn) && $conn instanceof PDO) {
    $db_pdo = $conn;
}
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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2><?= htmlspecialchars($title) ?></h2>
                        <p class="text-muted mb-0">Kelola data kelas terdaftar pada sistem.</p>
                    </div>
                    <a href="tambah_kelas.php" class="btn btn-primary btn-sm fw-semibold">+ Tambah Kelas</a>
                </div>
                <hr>

                <div class="table-responsive">
                    <table id="tableKelas" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kelas</th>
                                <th>Tingkat</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($db_pdo) {
                                try {
                                    $rows = $db_pdo->query("
                                        SELECT id, nama, tingkat, jurusan, status_aktif 
                                        FROM t_kelas 
                                        ORDER BY id
                                    ")->fetchAll(PDO::FETCH_ASSOC);

                                    if (count($rows) > 0) {
                                        foreach ($rows as $i => $row) {
                                            ?>
                                            <tr>
                                                <td><?= $i + 1 ?></td>
                                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                                <td><?= htmlspecialchars($row['tingkat']) ?></td>
                                                <td><?= htmlspecialchars($row['jurusan']) ?></td>
                                                <td><?= $row['status_aktif'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                                                <td class="text-center">
                                                    <a href="edit_kelas.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-dark px-2 fw-semibold">Ubah</a>
                                                    <a href="hapus_kelas.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm text-white px-2 fw-semibold" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data kelas.</td></tr>';
                                    }
                                } catch (Exception $e) {
                                    echo '<tr><td colspan="6" class="text-center text-danger py-4">Error memuat data: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-danger py-4">Koneksi database ($pdo) belum terhubung dengan benar di config.php.</td></tr>';
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
        $('#tableKelas').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>