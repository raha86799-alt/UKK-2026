<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin', 'guru']);
}

$title = 'Edit Siswa';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;
if (!$id) {
    echo "<script>alert('ID Siswa tidak valid!'); window.location='kelola_siswa.php';</script>";
    exit;
}

// Cek nama kolom primary key dan kolom nis/nip di database
$check_nis = mysqli_query($db_connection, "SHOW COLUMNS FROM t_siswa LIKE 'nis'");
$kolom_nis = (mysqli_num_rows($check_nis) > 0) ? 'nis' : 'nip';

// Proses Update Data
if (isset($_POST['submit'])) {
    $nis_input     = trim($_POST['nis'] ?? '');
    $nisn          = trim($_POST['nisn'] ?? '');
    $nama          = trim($_POST['nama'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $alamat        = trim($_POST['alamat'] ?? '');

    // Validasi ketat: Kudu angka wungkul sarta panjangna kudu pas 10 digit (teu kurang, teu leuwih)
    if (!preg_match('/^[0-9]{10}$/', $nis_input) || !preg_match('/^[0-9]{10}$/', $nisn)) {
        echo "<script>alert('Gagal: NIS dan NISN harus berupa angka dan panjangnya harus tepat 10 digit!'); window.history.back();</script>";
        exit;
    }

    $nis_esc           = mysqli_real_escape_string($db_connection, $nis_input);
    $nisn_esc          = mysqli_real_escape_string($db_connection, $nisn);
    $nama_esc          = mysqli_real_escape_string($db_connection, $nama);
    $jenis_kelamin_esc = mysqli_real_escape_string($db_connection, $jenis_kelamin);
    $tanggal_lahir_esc = mysqli_real_escape_string($db_connection, $tanggal_lahir);
    $alamat_esc        = mysqli_real_escape_string($db_connection, $alamat);

    $query_update = "UPDATE t_siswa SET 
                        $kolom_nis = '$nis_esc', 
                        nisn = '$nisn_esc', 
                        nama = '$nama_esc', 
                        jenis_kelamin = '$jenis_kelamin_esc', 
                        tanggal_lahir = '$tanggal_lahir_esc', 
                        alamat = '$alamat_esc', 
                        updated_at = NOW() 
                     WHERE id = '$id'";
    
    $update = mysqli_query($db_connection, $query_update);
    if ($update) {
        echo "<script>alert('Data siswa berhasil diperbarui!'); window.location='kelola_siswa.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($db_connection) . "');</script>";
    }
}

// Ambil data siswa yang akan diedit
$query_get = "SELECT *, $kolom_nis AS nis_val FROM t_siswa WHERE id = '$id' LIMIT 1";
$result_get = mysqli_query($db_connection, $query_get);
$siswa = mysqli_fetch_assoc($result_get);

if (!$siswa) {
    echo "<script>alert('Data siswa tidak ditemukan!'); window.location='kelola_siswa.php';</script>";
    exit;
}
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

        <!-- KONTEN UTAMA FORM EDIT SISWA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2>Edit Siswa</h2>
                    <p class="text-muted mb-0">Formulir perubahan data siswa terdaftar.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nis" class="form-label fw-bold">NIS</label>
                        <!-- Input dibatasi angka doang, maksimal 10 digit, otomatis mupus huruf -->
                        <input type="text" class="form-control" id="nis" name="nis" 
                               value="<?= htmlspecialchars($siswa['nis_val'] ?? '') ?>" 
                               maxlength="10" pattern="[0-9]{10}" inputmode="numeric" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                               autocomplete="off" required>
                        <div class="form-text">Wajib 10 digit angka.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nisn" class="form-label fw-bold">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" 
                               value="<?= htmlspecialchars($siswa['nisn'] ?? '') ?>" 
                               maxlength="10" pattern="[0-9]{10}" inputmode="numeric" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                               autocomplete="off" required>
                        <div class="form-text">Wajib 10 digit angka.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($siswa['nama'] ?? '') ?>" placeholder="Contoh: Alya Putri" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" <?= (($siswa['jenis_kelamin'] ?? '') == 'L') ? 'selected' : '' ?>>Laki-laki (L)</option>
                            <option value="P" <?= (($siswa['jenis_kelamin'] ?? '') == 'P') ? 'selected' : '' ?>>Perempuan (P)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($siswa['tanggal_lahir'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Contoh: Jl. Pendidikan No. 1" required><?= htmlspecialchars($siswa['alamat'] ?? '') ?></textarea>
                    </div>
                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Perbarui</button>
                        <a href="kelola_siswa.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>