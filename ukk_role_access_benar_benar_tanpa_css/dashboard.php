
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Dashboard</title>
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-3">
            <h4 class="text-white mb-4">
                My Website
            </h4>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link active">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_siswa.php" class="nav-link text-white">
                        Data Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_guru.php" class="nav-link text-white">
                        Data Guru
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_kelas.php" class="nav-link text-white">
                        Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white">
                        Laporan
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white">
                        About Me
                    </a>
                </li>
                <hr class="text-secondary">
                <li class="nav-item">
                    <a href="tentang_saya.php" class="nav-link text-danger">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <!-- KONTEN -->
        <main class="col-md-9 col-lg-10 p-4">
            <h2>Dashboard</h2>
            <p>
                Selamat datang di halaman dashboard.
            </p>
            <div class="row">
                <!-- CARD DATA SISWA -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                Data Siswa
                            </h5>
                            <h2>
                                120
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- CARD DATA GURU -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                Data Guru
                            </h5>
                            <h2>
                                25
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- CARD KELAS -->
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                Kelas
                            </h5>
                            <h2>
                             12
                          </h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
    <h2>Dashboard</h2>
    <p>
        Selamat datang,
        
    </p>
    <p>
        Anda berhasil login.
    </p>
    <a href="logout.php">Logout</a>
</body>
</html>
<?php
require 'includes/auth.php'; require 'config.php';
$title = 'Dashboard';
$role = strtolower($_SESSION['role'] ?? '');
$labels = [
 'admin'=>['title'=>'Dashboard Administrator','desc'=>'Kelola seluruh data sistem, pengguna, pelanggaran, laporan, dan export.'],
 'guru'=>['title'=>'Dashboard Guru','desc'=>'Catat pelanggaran dan pantau perkembangan siswa.'],
 'wali_kelas'=>['title'=>'Dashboard Wali Kelas','desc'=>'Pantau laporan, riwayat, dan rekap poin siswa di kelas.']
];
$view = $labels[$role] ?? $labels['guru'];
$tables = ['t_siswa'=>'Siswa','t_guru'=>'Guru','t_kelas'=>'Kelas','t_pelanggaran'=>'Jenis Pelanggaran','t_pelanggaran_siswa'=>'Catatan Pelanggaran'];
$counts=[]; foreach($tables as $t=>$label){ try{$counts[$label]=(int)$pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();}catch(Throwable $e){$counts[$label]=0;} }
include 'includes/header.php';
?>
<h1><?= $view['title'] ?></h1>
<p><?= $view['desc'] ?></p>
<h2>Ringkasan Data</h2>
<table>
<tr>
<td><h2><?= $counts['Siswa'] ?></h2><strong>Siswa</strong></td>
<td><h2><?= $counts['Guru'] ?></h2><strong>Guru</strong></td>
<td><h2><?= $counts['Kelas'] ?></h2><strong>Kelas</strong></td>
<td><h2><?= $counts['Jenis Pelanggaran'] ?></h2><strong>Jenis Pelanggaran</strong></td>
<td><h2><?= $counts['Catatan Pelanggaran'] ?></h2><strong>Catatan</strong></td>
</tr></table>
<?php if ($role === 'admin'): ?>
<h2>Menu Administrator</h2><p>Semua menu pengelolaan tersedia pada panel kiri.</p>
<?php elseif ($role === 'guru'): ?>
<h2>Menu Guru</h2><p>Gunakan menu pelanggaran untuk mencatat dan memantau siswa.</p>
<?php elseif ($role === 'wali_kelas'): ?>
<h2>Menu Wali Kelas</h2><p>Gunakan menu monitoring untuk melihat laporan kelas.</p>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
