<?php

if (function_exists('requireRole')) {
    requireRole(['wali_kelas']);
}

$title = 'Laporan';$section = 'wali_kelas';

// Menyesuaikan koneksi database PDO
$db_connection =$pdo ?? $conn ?? $koneksi ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-custom-sidebar {
            background-color: #000000;
            min-height: 100vh;
        }
        body {
            background-color: #f4f4f4;
            overflow-x: hidden;
        }
        .nav-pills .nav-link {
            color: #cfd3d6;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            margin-bottom: 4px;
        }
        .nav-pills .nav-link:hover {
            background-color: #333333;
            color: #ffffff;
            transform: translateX(5px);
        }
        .nav-pills .nav-link.active {
            background-color: #00bcd4 !important;
            color: #ffffff !important;
            font-weight: bold;
            transform: translateX(5px);
        }
        .main-content {
            background-color: #ffffff;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 30px;
            flex-grow: 1;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <!-- SIDEBAR -->
    <div class="col-md-3 col-lg-2 bg-custom-sidebar p-3 d-flex flex-column justify-content-between">
        <div>
            <h4 class="text-white mb-4 fw-bold pb-2 border-bottom border-secondary">
                My Website
            </h4>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_siswa.php" class="nav-link">Data Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_guru.php" class="nav-link">Data Guru</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_kelas.php" class="nav-link">Kelas</a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link active">Laporan</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link">About Me</a>
                </li>
            </ul>
        </div>
        <div>
            <hr class="text-secondary">
            <a href="logout.php" class="btn text-white w-100 text-start fw-bold" style="background-color: #a91d3a;">
                Logout
            </a>
        </div>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="main-content">
        <h2><?= htmlspecialchars($title) ?></h2>
        <p class="text-muted">Daftar laporan pelanggaran siswa terdaftar pada sistem.</p>
        <hr class="mb-4">

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Pelanggaran</th>
                        <th>Poin</th>
                        <th>Guru</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($db_connection) {
                        try {
                            $rows =$db_connection->query("
                                SELECT tanggal, nama_siswa, nama_kelas, nama_pelanggaran, poin, nama_guru 
                                FROM t_pelanggaran_siswa 
                                ORDER BY tanggal DESC, id DESC 
                                LIMIT 100
                            ")->fetchAll(PDO::FETCH_ASSOC);

                            if (count($rows) > 0) {
                                foreach ($rows as $i =>$r) {
                                    ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= htmlspecialchars($r['tanggal']) ?></td>
                                        <td><?= htmlspecialchars($r['nama_siswa']) ?></td>
                                        <td><?= htmlspecialchars($r['nama_kelas']) ?></td>
                                        <td><?= htmlspecialchars($r['nama_pelanggaran']) ?></td>
                                        <td><?= (int)$r['poin'] ?></td>
                                        <td><?= htmlspecialchars($r['nama_guru']) ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center text-muted">Belum ada data laporan pelanggaran.</td></tr>';
                            }
                        } catch (Exception $e) {
                            echo '<tr><td colspan="7" class="text-danger">Error memuat data: ' . $e->getMessage() . '</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7" class="text-danger">Koneksi database belum terhubung dengan benar.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="