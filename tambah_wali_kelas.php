<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Wali Kelas';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Proses Simpan Data Wali Kelas
if (isset($_POST['submit'])) {
    $tahun_ajaran_id = trim($_POST['tahun_ajaran_id'] ?? '');
    $kelas_id        = trim($_POST['kelas_id'] ?? '');
    $guru_id         = trim($_POST['guru_id'] ?? '');
    $tanggal_mulai   = trim($_POST['tanggal_mulai'] ?? '');
    $tanggal_selesai = trim($_POST['tanggal_selesai'] ?? '');
    $status_aktif    = trim($_POST['status_aktif'] ?? 1);

    if (empty($tahun_ajaran_id) || empty($kelas_id) || empty($guru_id) || empty($tanggal_mulai) || empty($tanggal_selesai)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    $query_insert = "INSERT INTO t_wali_kelas (tahun_ajaran_id, kelas_id, guru_id, tanggal_mulai, tanggal_selesai, status_aktif, created_at, updated_at) 
                     VALUES ('$tahun_ajaran_id', '$kelas_id', '$guru_id', '$tanggal_mulai', '$tanggal_selesai', '$status_aktif', NOW(), NOW())";
    
    $insert = mysqli_query($db_connection, $query_insert);
    if ($insert) {
        echo "<script>alert('Data wali kelas berhasil ditambahkan!'); window.location='kelola_wali_kelas.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambah data: " . mysqli_error($db_connection) . "'); window.history.back();</script>";
    }
}

// Ambil data untuk Dropdown Tahun Ajaran
$query_tahun = mysqli_query($db_connection, "SELECT * FROM t_tahun_ajaran ORDER BY nama DESC");

// Ambil data untuk Dropdown Kelas
$query_kelas = mysqli_query($db_connection, "SELECT * FROM t_kelas ORDER BY tingkat ASC, nama ASC");

// Ambil data untuk Dropdown Guru
$query_guru = mysqli_query($db_connection, "SELECT * FROM t_guru ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
            margin-bottom: 30px;
        }
        .form-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .form-table td {
            padding: 10px 6px;
            vertical-align: middle;
        }
        .form-table td.label-col {
            width: 18%;
            font-weight: 600;
        }
        .form-table td.colon-col {
            width: 2%;
            text-align: center;
            font-weight: bold;
        }
        .form-table td.input-col {
            width: 80%;
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
            <h3 class="mb-4 fw-bold">Kelola Wali Kelas</h3>

            <div class="content-card shadow-sm">
                <h5 class="fw-bold mb-3">Tambah Wali Kelas</h5>
                
                <form action="" method="POST">
                    <table class="form-table">
                        <!-- Tahun Ajaran -->
                        <tr>
                            <td class="label-col">Tahun Ajaran</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" name="tahun_ajaran_id" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <?php while ($t = mysqli_fetch_assoc($query_tahun)) { ?>
                                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nama']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>

                        <!-- Kelas -->
                        <tr>
                            <td class="label-col">Kelas</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" name="kelas_id" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php while ($k = mysqli_fetch_assoc($query_kelas)) { ?>
                                        <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>

                        <!-- Guru Wali Kelas -->
                        <tr>
                            <td class="label-col">Guru Wali Kelas</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" name="guru_id" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php while ($g = mysqli_fetch_assoc($query_guru)) { ?>
                                        <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['nama']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>

                        <!-- Tanggal Mulai -->
                        <tr>
                            <td class="label-col">Tanggal Mulai</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="date" class="form-control" name="tanggal_mulai" required>
                            </td>
                        </tr>

                        <!-- Tanggal Selesai -->
                        <tr>
                            <td class="label-col">Tanggal Selesai</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="date" class="form-control" name="tanggal_selesai" required>
                            </td>
                        </tr>

                        <!-- Status -->
                        <tr>
                            <td class="label-col">Status</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" name="status_aktif" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Simpan</button>
                        <a href="kelola_wali_kelas.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>