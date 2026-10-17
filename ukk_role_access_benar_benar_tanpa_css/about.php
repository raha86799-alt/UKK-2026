<?php
session_start(); // Memulai session untuk membaca data pengguna

$title = 'About Me';
$role = strtolower(trim($_SESSION['role'] ?? 'guru'));
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
        .profile-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #fafafa;
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
                    <a href="laporan.php" class="nav-link">Laporan</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link active">About Me</a>
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
        <h2>About Me</h2>
        <p class="text-muted">Profil pengembang aplikasi dan informasi sistem.</p>
        <hr class="mb-4">

        <div class="row">
            <!-- Kolom Kiri: Foto & Info Singkat -->
            <div class="col-lg-4 mb-4">
                <div class="profile-card shadow-sm text-center">
                    <img src="https://via.placeholder.com/150" alt="Foto Profil" class="rounded-circle img-thumbnail mb-3" style="width: 140px; height: 140px; object-fit: cover;">
                    <h5 class="fw-bold mb-1">Alfin Rahadian</h5>
                    <p class="text-muted mb-2">Web Developer</p>
                    <span class="badge bg-info text-dark text-uppercase"><?= htmlspecialchars($role) ?></span>
                </div>
            </div>

            <!-- Kolom Kanan: Biodata & Tentang Aplikasi -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-3 mb-4 bg-light">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Biodata Pengembang</h5>
                    <table class="table table-borderless mb-0 bg-transparent">
                        <tr>
                            <td class="fw-bold text-muted" style="width: 35%;">Nama Lengkap</td>
                            <td>: Alfin Rahadian</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">NISN / ID</td>
                            <td>: 123456789</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Kelas / Jurusan</td>
                            <td>: XII Rekayasa Perangkat Lunak</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Sekolah</td>
                            <td>: Smk Muhammadiyah Tasikmalaya</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Kontak</td>
                            <td>: email@domain.com</td>
                        </tr>
                    </table>
                </div>

                <div class="card border-0 shadow-sm p-3 bg-light">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Tentang Aplikasi</h5>
                    <p class="text-muted small">
                        Aplikasi sistem pencatatan pelanggaran siswa ini dibangun untuk memenuhi Uji Kompetensi Keahlian (UKK) tahun 2026. Membantu pihak sekolah dalam memantau kedisiplinan dan rekap data secara komputerisasi.
                    </p>
                    <div>
                        <span class="badge bg-dark me-1">PHP Native</span>
                        <span class="badge bg-primary me-1">Bootstrap 5</span>
                        <span class="badge bg-success me-1">MySQL</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>