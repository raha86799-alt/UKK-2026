<?php
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Kelola Siswa'; 
$section = 'admin';

// Koneksi database
$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Ambil data dari tabel t_siswa
$query = "SELECT * FROM t_siswa";
$result = $db_connection ? @mysqli_query($db_connection, $query) : false;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= $title ?></title>
    <style>
        /* Warna latar sidebar hitam */
        .bg-custom-sidebar {
            background-color: #000000;
            min-height: 100vh;
        }
        /* Background halaman luar */
        body {
            background-color: #f2f2f2;
        }
        /* Efek transisi halus saat kursor mendekat atau dipencet */
        .nav-pills .nav-link {
            color: #ffffff;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            margin-bottom: 4px;
        }
        /* Efek saat kursor digeser di atas menu (Hover) */
        .nav-pills .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(5px);
        }
        /* Efek warna ketika menu aktif / dipencet (Active) dengan warna biru */
        .nav-pills .nav-link.active {
            background-color: #00bfff !important;
            color: #ffffff !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transform: translateX(5px);
        }
        /* Kotak konten dengan background putih bersih */
        .content-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 25px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-custom-sidebar p-3 text-white">
            <h4 class="mb-4 fw-bold text-white">
                My Website
            </h4>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola_siswa.php" class="nav-link active">
                        Data Siswa
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola_guru.php" class="nav-link">
                        Data Guru
                    </a>
                </li>
                <li class="nav-item">
                    <a href="kelola_kelas.php" class="nav-link">
                        Kelas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link">
                        Laporan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        About Me
                    </a>
                </li>
                <hr class="text-secondary my-3">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-white bg-danger bg-opacity-75">
                        Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2>Kelola Siswa</h2>
                        <p class="text-muted mb-0">Kelola data siswa terdaftar pada sistem.</p>
                    </div>
                    <a href="tambah_siswa.php" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>NIP</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nip'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['nisn'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['jenis_kelamin'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['tanggal_lahir'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['alamat'] ?? '-') ?></td>
                                        <td class="text-center">
                                            <a href="edit_siswa.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-dark px-3 fw-semibold">Ubah</a> 
                                            <a href="hapus_siswa.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm text-white px-3 fw-semibold" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php 
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada data siswa di dalam database.</td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>