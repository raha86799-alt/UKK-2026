<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Edit Data Guru';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? @mysqli_connect("localhost", "root", "", "db_ukk_2026");
if (!$db_connection) {
    die("Koneksi database gagal.");
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: kelola_guru.php");
    exit;
}

$error = '';

// Deteksi apakah kolom menggunakan 'nis' atau 'nip'
$check_nis = @mysqli_query($db_connection, "SHOW COLUMNS FROM t_guru LIKE 'nis'");
$kolom_id = ($check_nis && mysqli_num_rows($check_nis) > 0) ? 'nis' : 'nip';

// Ambil data guru berdasarkan ID
$stmt = mysqli_prepare($db_connection, "SELECT *, $kolom_id AS nis_val FROM t_guru WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: kelola_guru.php");
    exit;
}

// Proses Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis_nip = trim($_POST['nis_nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!preg_match('/^[0-9]{10,17}$/', $nis_nip)) {
        $error = 'NIP harus berupa angka minimal 10 dan maksimal 17 digit.';
    } elseif ($nama === '' || $email === '') {
        $error = "Nama dan email wajib diisi!";
    } elseif ($password !== '' && strlen($password) < 6) {
        $error = 'Password baru minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.';
    } else {
        mysqli_begin_transaction($db_connection);
        try {
            $update_stmt = mysqli_prepare($db_connection, "UPDATE t_guru SET $kolom_id = ?, nama = ?, email = ? WHERE id = ?");
            if (!$update_stmt) { throw new Exception('Gagal menyiapkan perubahan data guru.'); }
            mysqli_stmt_bind_param($update_stmt, "sssi", $nis_nip, $nama, $email, $id);
            if (!mysqli_stmt_execute($update_stmt)) { throw new Exception('Gagal memperbarui data guru.'); }

            // Akun login guru berada di t_users dan terhubung melalui user_id.
            $user_id = (int)($data['user_id'] ?? 0);
            if ($user_id > 0) {
                if ($password !== '') {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $user_stmt = mysqli_prepare($db_connection, "UPDATE t_users SET password = ?, email = ? WHERE id = ?");
                    if (!$user_stmt) { throw new Exception('Gagal menyiapkan perubahan password akun guru.'); }
                    mysqli_stmt_bind_param($user_stmt, "ssi", $password_hash, $email, $user_id);
                    if (!mysqli_stmt_execute($user_stmt)) { throw new Exception('Gagal memperbarui password akun guru.'); }
                } else {
                    // Sinkronkan email login meskipun password tidak diubah.
                    $email_stmt = mysqli_prepare($db_connection, "UPDATE t_users SET email = ? WHERE id = ?");
                    if (!$email_stmt) { throw new Exception('Gagal menyiapkan perubahan email akun guru.'); }
                    mysqli_stmt_bind_param($email_stmt, "si", $email, $user_id);
                    if (!mysqli_stmt_execute($email_stmt)) { throw new Exception('Gagal memperbarui email akun guru.'); }
                }
            } elseif ($password !== '') {
                throw new Exception('Akun login guru belum terhubung. Buat akun guru terlebih dahulu sebelum mengubah password.');
            }

            mysqli_commit($db_connection);
            header("Location: kelola_guru.php?berhasil=2");
            exit;
        } catch (Throwable $e) {
            mysqli_rollback($db_connection);
            $error = $e->getMessage();
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

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card shadow-sm" style="max-width: 700px;">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Ubah informasi data guru pada sistem.</p>
                </div>
                <hr>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold"><?= strtoupper($kolom_id) ?></label>
                        <input type="text" name="nis_nip" class="form-control" inputmode="numeric" minlength="10" maxlength="17" pattern="[0-9]{10,17}" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,17)" value="<?= htmlspecialchars($data['nis_val']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Nama Guru</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password_guru" class="form-control" minlength="6" autocomplete="new-password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordGuru()">Lihat</button>
                        </div>
                        <div class="form-text">Isi minimal 6 karakter untuk mengganti password login guru. Kosongkan jika password tidak ingin diubah.</div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="kelola_guru.php" class="btn btn-secondary btn-sm fw-semibold px-3">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm fw-semibold px-3">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script>
function togglePasswordGuru() {
    const input = document.getElementById('password_guru');
    const button = input.nextElementSibling;
    if (input.type === 'password') { input.type = 'text'; button.textContent = 'Sembunyikan'; }
    else { input.type = 'password'; button.textContent = 'Lihat'; }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>