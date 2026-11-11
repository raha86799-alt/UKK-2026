<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'Data Tindakan';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Ambil data pelanggaran siswa yang statusnya MASIH PROSES saja
$query_tindakan = mysqli_query($db_connection, "
    SELECT ps.*, s.nama AS nama_siswa, k.nama AS nama_kelas, p.nama AS nama_pelanggaran, p.poin 
    FROM t_pelanggaran_siswa ps
    LEFT JOIN t_siswa s ON ps.siswa_id = s.id
    LEFT JOIN t_kelas k ON ps.kelas_id = k.id
    LEFT JOIN t_pelanggaran p ON ps.pelanggaran_id = p.id
    WHERE ps.status = 'Proses'
    ORDER BY ps.id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title><?= $title ?></title>
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
                <h2 class="mb-2">Tindakan Penanganan Pelanggaran</h2>
                <p class="text-muted mb-3">Daftar penanganan pelanggaran siswa. Klik tombol Selesai untuk memindahkan data ke riwayat.</p>
                <hr>

                <div class="table-responsive">
                    <table id="tableTindakan" class="table table-bordered table-striped align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Pelanggaran</th>
                                <th>Poin</th>
                                <th width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($query_tindakan && mysqli_num_rows($query_tindakan) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($query_tindakan)) {
                            ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama_siswa'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['nama_kelas'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['nama_pelanggaran'] ?? '-') ?></td>
                                        <td><span class="badge bg-danger"><?= $row['poin'] ?? 0 ?> Poin</span></td>
                                        <td>
                                            <!-- Dua Tombol Pilihan Status -->
                                            <div class="btn-group" role="group">
                                                <a href="update_status.php?id=<?= $row['id'] ?>&status=Proses" 
                                                   class="btn btn-sm btn-warning active text-dark" 
                                                   style="pointer-events: none;">Proses</a>
                                                
                                                <a href="update_status.php?id=<?= $row['id'] ?>&status=Selesai" 
                                                   class="btn btn-sm btn-outline-success"
                                                   onclick="return confirm('Ubah status menjadi Selesai dan pindahkan ke Riwayat?');">
                                                    Selesai
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php 
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data tindakan yang sedang diproses.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>
</div>

<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tableTindakan').DataTable();
    });
</script>
</body>
</html>