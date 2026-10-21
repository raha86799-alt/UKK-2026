<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

// Mengizinkan Admin mengakses halaman ini
if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Kelola Jenis Pelanggaran'; 
$section = 'admin';

// Koneksi database menggunakan PDO
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

// Ambil data dari tabel jenis pelanggaran
$rows = [];
if ($db_pdo) {
    try {
        $stmt = $db_pdo->query("SELECT * FROM t_jenis_pelanggaran ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Handle error query jika tabel belum dibuat
    }
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
                        <p class="text-muted mb-0">Kelola data jenis pelanggaran dan bobot poin pada sistem.</p>
                    </div>
                    <a href="tambah_jenis_pelanggaran.php" class="btn btn-primary btn-sm fw-semibold">+ Tambah Jenis Pelanggaran</a>
                </div>
                <hr>

                <div class="table-responsive">
                    <table id="tableJenisPelanggaran" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Pelanggaran</th>
                                <th>Kategori</th>
                                <th>Poin</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if ($db_pdo) {
                                if (count($rows) > 0) {
                                    foreach ($rows as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['nama_pelanggaran'] ?? $row['nama'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['kategori'] ?? '-') ?></td>
                                            <td><span class="badge bg-danger"><?= (int)($row['poin'] ?? 0) ?> Poin</span></td>
                                            <td class="text-center">
                                                <a href="edit_jenis_pelanggaran.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-dark px-2 fw-semibold">Ubah</a> 
                                                <a href="hapus_jenis_pelanggaran.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm text-white px-2 fw-semibold" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php 
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data jenis pelanggaran di dalam database.</td>
                                    </tr>
                                    <?php 
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center text-danger py-4">Koneksi database belum terhubung dengan benar.</td>
                                </tr>
                                <?php
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
        $('#tableJenisPelanggaran').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>