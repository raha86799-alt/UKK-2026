<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Edit Guru';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;
if (!$id) {
    echo "<script>alert('ID Guru tidak valid!'); window.location='kelola_guru.php';</script>";
    exit;
}

// Cek apakah kolom di tabel t_guru menggunakan 'nis' atau 'nip'
$check_column = mysqli_query($db_connection, "SHOW COLUMNS FROM t_guru LIKE 'nis'");
$kolom_nis = (mysqli_num_rows($check_column) > 0) ? 'nis' : 'nip';
$label_nis = strtoupper($kolom_nis); // NIS atau NIP

// Proses Update Guru
if (isset($_POST['submit'])) {
    $nis_input    = trim($_POST['nis'] ?? '');
    $nama         = trim($_POST['nama'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $status_aktif = trim($_POST['status_aktif'] ?? 1);
    
    // Validasi ketat: Kudu angka wungkul sarta panjangna kudu pas 10 digit (teu kurang, teu leuwih)
    if (!preg_match('/^[0-9]{10}$/', $nis_input)) {
        echo "<script>alert('Gagal: {$label_nis} harus berupa angka dan panjangnya harus tepat 10 digit!'); window.history.back();</script>";
        exit;
    }

    $nis_esc   = mysqli_real_escape_string($db_connection, $nis_input);
    $nama_esc  = mysqli_real_escape_string($db_connection, $nama);
    $email_esc = mysqli_real_escape_string($db_connection, $email);

    // Ambil user_id guru ini terlebih dahulu untuk update tabel t_user juga jika email/password berubah
    $query_get_guru = mysqli_query($db_connection, "SELECT user_id FROM t_guru WHERE id = '$id' LIMIT 1");
    $data_guru = mysqli_fetch_assoc($query_get_guru);
    $user_id = $data_guru['user_id'] ?? null;

    // Update tabel t_guru
    $query_update = "UPDATE t_guru SET 
                        $kolom_nis = '$nis_esc', 
                        nama = '$nama_esc', 
                        email = '$email_esc', 
                        status_aktif = '$status_aktif', 
                        updated_at = NOW() 
                     WHERE id = '$id'";
    
    $update = mysqli_query($db_connection, $query_update);
    if ($update) {
        // Jika relasi t_user ada, update juga email di t_user
        if ($user_id) {
            mysqli_query($db_connection, "UPDATE t_user SET email = '$email_esc', updated_at = NOW() WHERE id = '$user_id'");
        }

        echo "<script>alert('Data guru berhasil diperbarui!'); window.location='kelola_guru.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data guru: " . mysqli_error($db_connection) . "'); window.history.back();</script>";
    }
}

// Ambil data guru yang akan diedit
$query_get = "SELECT *, $kolom_nis AS nis_val FROM t_guru WHERE id = '$id' LIMIT 1";
$result_get = mysqli_query($db_connection, $query_get);
$guru = mysqli_fetch_assoc($result_get);

if (!$guru) {
    echo "<script>alert('Data guru tidak ditemukan!'); window.location='kelola_guru.php';</script>";
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
            padding: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .form-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .form-table td {
            padding: 8px 6px;
            vertical-align: middle;
        }
        .form-table td.label-col {
            width: 15%;
            font-weight: bold;
        }
        .form-table td.colon-col {
            width: 2%;
            text-align: center;
            font-weight: bold;
        }
        .form-table td.input-col {
            width: 83%;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">

        <!-- Memanggil Sidebar Terpusat -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN UTAMA EDIT GURU -->
        <main class="col-md-9 col-lg-10 p-4">
            <h3 class="mb-4 fw-bold">Kelola Guru</h3>

            <div class="content-card shadow-sm">
                <h5 class="fw-bold mb-3">Edit Data Guru</h5>
                <form action="" method="POST">
                    <table class="form-table">
                        <tr>
                            <td class="label-col"><?= $label_nis ?></td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <!-- Input dibatasi angka doang, maksimal 10 digit, otomatis mupus huruf -->
                                <input type="text" class="form-control" name="nis" 
                                       value="<?= htmlspecialchars($guru['nis_val'] ?? '') ?>" 
                                       maxlength="10" pattern="[0-9]{10}" inputmode="numeric" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" 
                                       autocomplete="off" required>
                                <div class="form-text">Wajib 10 digit angka.</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Nama Guru</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="text" class="form-control" name="nama" 
                                       value="<?= htmlspecialchars($guru['nama'] ?? '') ?>" 
                                       autocomplete="off" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Email</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="email" class="form-control" name="email" 
                                       value="<?= htmlspecialchars($guru['email'] ?? '') ?>" 
                                       autocomplete="off" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Status Aktif</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" name="status_aktif" required>
                                    <option value="1" <?= (($guru['status_aktif'] ?? 1) == 1) ? 'selected' : '' ?>>Aktif</option>
                                    <option value="0" <?= (($guru['status_aktif'] ?? 1) == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <button type="submit" name="submit" class="btn btn-warning fw-semibold px-4 text-dark">Perbarui</button>
                        <a href="kelola_guru.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>