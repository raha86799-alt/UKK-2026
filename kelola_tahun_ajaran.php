<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

// Mengizinkan Admin dan Guru mengakses halaman ini
if (function_exists('requireRole')) {
    requireRole(['admin', 'guru']);
}

$title = 'Kelola Tahun Ajaran'; 
$section = 'admin';

// Koneksi database menggunakan MySQLi
$db_connection = $conn ?? $koneksi ?? @mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Ambil data dari tabel t_tahun_ajaran
$query = "SELECT * FROM t_tahun_ajaran ORDER BY id DESC";
$result = $db_connection ? @mysqli_query($db_connection, $query) : false;
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
        /* Styling tambahan untuk menyesuaikan warna tombol aktif sidebar jika diperlukan */
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

        <!-- Sidebar dipanggil secara terpusat -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2><?= htmlspecialchars($title) ?></h2>
                        <p class="text-muted mb-0">Kelola data tahun ajaran terdaftar pada sistem.</p>
                    </div>
                    <a href="tambah_tahun_ajaran.php" class="btn btn-primary btn-sm fw-semibold">+ Tambah Tahun Ajaran</a>
                </div>
                <hr>

                <div class="table-responsive">
                    <table id="tableTahunAjaran" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Tahun Ajaran</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $status_label = (!empty($row['status_aktif']) && $row['status_aktif'] == 1) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Tidak Aktif</span>';
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['tanggal_mulai'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['tanggal_selesai'] ?? '-') ?></td>
                                        <td><?= $status_label ?></td>
                                        <td class="text-center">
                                            <a href="edit_tahun_ajaran.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-dark px-2 fw-semibold">Ubah</a> 
                                            <a href="hapus_tahun_ajaran.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm text-white px-2 fw-semibold" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php 
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada data tahun ajaran di dalam database.</td>
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
        $('#tableTahunAjaran').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>