<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

// Mengizinkan Admin dan Guru mengakses halaman ini
if (function_exists('requireRole')) {
    requireRole(['admin', 'guru']);
}

$title = 'Kelola Siswa'; 
$section = 'admin';

// Koneksi database
$db_connection = $conn ?? $koneksi ?? @mysqli_connect("localhost", "root", "", "db_ukk_2026");

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
        .bg-custom-sidebar {
            background-color: #000000;
            min-height: 100vh;
        }
        body {
            background-color: #f2f2f2;
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
        .content-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 25px;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <!-- SIDEBAR LENGKAP -->
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
                    <a href="kelola_siswa.php" class="nav-link active">Kelola Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_guru.php" class="nav-link">Kelola Guru</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_kelas.php" class="nav-link">Kelola Kelas</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_tahun_ajaran.php" class="nav-link">Kelola Tahun Ajaran</a>
                </li>
                <li class="nav-item">
                    <a href="penempatan_siswa.php" class="nav-link">Penempatan Siswa</a>
                </li>
                <li class="nav-item">
                    <a href="kelola_wali_kelas.php" class="nav-link">Kelola Wali Kelas</a>
                </li>
                <li class="nav-item">
                    <a href="kategori_pelanggaran.php" class="nav-link">Kategori Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="jenis_pelanggaran.php" class="nav-link">Jenis Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link">Cetak / Laporan</a>
                </li>
                
                <!-- PELANGGARAN -->
                <li class="text-muted small mt-3 mb-1 px-2 fw-bold text-uppercase">PELANGGARAN</li>
                <li class="nav-item">
                    <a href="catat_pelanggaran.php" class="nav-link">Catat Pelanggaran</a>
                </li>
                <li class="nav-item">
                    <a href="tindakan.php" class="nav-link">Tindakan</a>
                </li>
                <li class="nav-item">
                    <a href="laporan.php" class="nav-link">Laporan</a>
                </li>
                <li class="nav-item">
                    <a href="riwayat.php" class="nav-link">Riwayat</a>
                </li>
                <li class="nav-item">
                    <a href="rekap_poin.php" class="nav-link">Rekap Poin</a>
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
    <main class="flex-grow-1 p-4">
        <div class="content-card shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2>Kelola Siswa</h2>
                    <p class="text-muted mb-0">Kelola data siswa terdaftar pada sistem.</p>
                </div>
                <!-- Tombol Tambah Siswa dimunculkan tanpa batasan role -->
                <a href="tambah_siswa.php" class="btn btn-primary btn-sm fw-semibold">+ Tambah Siswa</a>
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
                                        <!-- Tombol Ubah dan Hapus dimunculkan untuk semua role -->
                                        <a href="edit_siswa.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-dark px-2 fw-semibold">Ubah</a> 
                                        <a href="hapus_siswa.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm text-white px-2 fw-semibold" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>