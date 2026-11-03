<?php
session_start();

// Panggil file konfigurasi dan auth jika ada
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'Dashboard';

// Ambil role dari session, ubah ke lowercase, jika kosong beri nilai default 'guru'
$role = strtolower(trim($_SESSION['role'] ?? 'guru'));

$labels = [
    'admin'      => ['title' => 'Dashboard Administrator', 'desc' => 'Kelola seluruh data sistem, pengguna, pelanggaran, laporan, dan export.'],
    'guru'       => ['title' => 'Dashboard Guru', 'desc' => 'Catat pelanggaran dan pantau perkembangan siswa.'],
    'wali_kelas' => ['title' => 'Dashboard Wali Kelas', 'desc' => 'Pantau laporan, riwayat, dan rekap poin siswa di kelas.']
];

$view = $labels[$role] ?? $labels['guru'];

// Menyesuaikan koneksi database PDO / MySQLi agar fleksibel membaca variabel dari config.php
$db_connection = $pdo ?? $conn ?? $koneksi ?? null;

// Jika menggunakan koneksi mysqli standar tapi belum berupa objek, buat koneksi fallback
if (!$db_connection && function_exists('mysqli_connect')) {
    $db_connection = @mysqli_connect("localhost", "root", "", "db_ukk_2026");
}

$counts = ['Siswa' => 0, 'Guru' => 0, 'Kelas' => 0, 'Jenis Pelanggaran' => 0, 'Catatan' => 0];

if ($db_connection) {
    $tables = [
        't_siswa'            => 'Siswa',
        't_guru'             => 'Guru',
        't_kelas'            => 'Kelas',
        't_pelanggaran'      => 'Jenis Pelanggaran',
        't_pelanggaran_siswa' => 'Catatan'
    ];
    
    foreach ($tables as $t => $label) {
        try {
            if ($db_connection instanceof PDO) {
                $counts[$label] = (int)$db_connection->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
            } else {
                $result = mysqli_query($db_connection, "SELECT COUNT(*) as total FROM `$t`");
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $counts[$label] = (int)($row['total'] ?? 0); 
                } 
            } 
        } catch (Throwable $e) {
            $counts[$label] = 0;
        }
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
    <style>
        body {
            background-color: #f4f4f4;
            overflow-x: hidden;
            margin: 0;
        }
        .main-content {
            background-color: #ffffff;
            margin: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 30px;
            flex-grow: 1;
        }
        /* Menyesuaikan warna menu aktif sidebar menjadi cyan/toska (#00bcd4) */
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
        <main class="col-md-9 col-lg-10 p-4 d-flex flex-column">
            <div class="main-content">
                <h2><?= htmlspecialchars($view['title']) ?></h2>
                <p class="text-muted"><?= htmlspecialchars($view['desc']) ?></p>
                <hr class="mb-4">

                <!-- Status Role -->
                <div class="alert alert-info py-2 mb-3" style="font-size: 0.9rem;">
                    Status Login Role Anda saat ini: <strong><?= htmlspecialchars($role) ?></strong>
                </div>

                <h4 class="mb-3">Ringkasan Data</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted fs-6">Siswa</h5>
                                <h2 class="fw-bold"><?= $counts['Siswa'] ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted fs-6">Guru</h5>
                                <h2 class="fw-bold"><?= $counts['Guru'] ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted fs-6">Kelas</h5>
                                <h2 class="fw-bold"><?= $counts['Kelas'] ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted fs-6">Jenis Pelanggaran</h5>
                                <h2 class="fw-bold"><?= $counts['Jenis Pelanggaran'] ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-muted fs-6">Catatan Pelanggaran</h5>
                                <h2 class="fw-bold"><?= $counts['Catatan'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <?php if ($role === 'admin'): ?>
                        <h5>Menu Administrator</h5>
                        <p class="text-muted">Semua menu pengelolaan tersedia pada panel kiri.</p>
                    <?php elseif ($role === 'guru'): ?>
                        <h5>Menu Guru</h5>
                        <p class="text-muted">Gunakan menu pelanggaran untuk mencatat dan memantau siswa.</p>
                    <?php elseif ($role === 'wali_kelas'): ?>
                        <h5>Menu Wali Kelas</h5>
                        <p class="text-muted">Gunakan menu monitoring untuk melihat laporan kelas.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>

    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>