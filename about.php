<?php
session_start(); // Memulai session untuk membaca data pengguna
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'about';
$role = strtolower(trim($_SESSION['role'] ?? 'guru'));
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
        .profile-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #fafafa;
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
        <main class="col-md-9 col-lg-10 p-4 d-flex flex-column">
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
                                    <td>: SMK Muhammadiyah Tasikmalaya</td>
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
        </main>

    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>