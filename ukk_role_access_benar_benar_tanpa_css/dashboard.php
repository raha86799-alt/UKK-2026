<?php
$title = 'Dashboard';
$role = strtolower($_SESSION['role'] ?? '');

$labels = [
    'admin'      => ['title' => 'Dashboard Administrator', 'desc' => 'Kelola seluruh data sistem, pengguna, pelanggaran, laporan, dan export.'],
    'guru'       => ['title' => 'Dashboard Guru', 'desc' => 'Catat pelanggaran dan pantau perkembangan siswa.'],
    'wali_kelas' => ['title' => 'Dashboard Wali Kelas', 'desc' => 'Pantau laporan, riwayat, dan rekap poin siswa di kelas.']
];

$view =$labels[$role] ?? $labels['guru'];

// Menyesuaikan koneksi database PDO
$db_connection =$pdo ?? $conn ?? $koneksi ?? null;

$counts = ['Siswa' => 0, 'Guru' => 0, 'Kelas' => 0, 'Jenis Pelanggaran' => 0, 'Catatan' => 0];
if ($db_connection) {$tables = [
        't_siswa'             => 'Siswa',
        't_guru'              => 'Guru',
        't_kelas'             => 'Kelas',
        't_pelanggaran'       => 'Jenis Pelanggaran',
        't_pelanggaran_siswa' => 'Catatan'
    ];
    
    foreach ($tables as $t =>$label) {
        try {
            $counts[$label] = (int)$db_connection->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
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
                    <a href="dashboard.php" class="nav-link active">Dashboard</a>
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
                    <a href="laporan.php" class="nav-link">Laporan</a>
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
        <h2><?= htmlspecialchars($view['title']) ?></h2>
        <p class="text-muted"><?= htmlspecialchars($view['desc']) ?></p>
        <hr class="mb-4">

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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>