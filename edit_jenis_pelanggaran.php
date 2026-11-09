<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Edit Jenis Pelanggaran';
$section = 'admin';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id || !$db_pdo) {
    echo "<script>alert('ID tidak valid!'); window.location='jenis_pelanggaran.php';</script>";
    exit;
}

// Ambil data berdasarkan ID untuk mendeteksi struktur kolom yang ada di database
$stmt = $db_pdo->prepare("SELECT * FROM t_pelanggaran WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "<script>alert('Data jenis pelanggaran tidak ditemukan!'); window.location='jenis_pelanggaran.php';</script>";
    exit;
}

// Proses update data secara dinamis berdasarkan kolom yang tersedia di tabel
if (isset($_POST['update'])) {
    $nama_input     = trim($_POST['nama'] ?? '');
    $kategori_input = trim($_POST['kategori'] ?? '');
    $poin_input     = (int)($_POST['poin'] ?? 0);

    $updates = [];
    $params  = [];

    // Cek kolom Poin
    if (array_key_exists('poin', $data)) {
        $updates[] = "poin = ?";
        $params[]  = $poin_input;
    }

    // Cek kolom Nama Pelanggaran (bisa 'nama' atau 'nama_pelanggaran')
    if (array_key_exists('nama', $data)) {
        $updates[] = "nama = ?";
        $params[]  = $nama_input;
    } elseif (array_key_exists('nama_pelanggaran', $data)) {
        $updates[] = "nama_pelanggaran = ?";
        $params[]  = $nama_input;
    }

    // Cek kolom Kategori (bisa 'kategori' atau 'kategori_id')
    if (array_key_exists('kategori', $data)) {
        $updates[] = "kategori = ?";
        $params[]  = $kategori_input;
    } elseif (array_key_exists('kategori_id', $data)) {
        $updates[] = "kategori_id = ?";
        $params[]  = $kategori_input;
    }

    // Cek kolom updated_at jika ada
    if (array_key_exists('updated_at', $data)) {
        $updates[] = "updated_at = NOW()";
    }

    if (!empty($updates)) {
        try {
            $sql = "UPDATE t_pelanggaran SET " . implode(", ", $updates) . " WHERE id = ?";
            $params[] = $id;

            $updateStmt = $db_pdo->prepare($sql);
            $update = $updateStmt->execute($params);

            if ($update) {
                echo "<script>alert('Jenis pelanggaran berhasil diperbarui!'); window.location='jenis_pelanggaran.php';</script>";
                exit;
            }
        } catch (Exception $e) {
            echo "<script>alert('Gagal memperbarui data: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Tidak ada kolom yang cocok untuk diperbarui.');</script>";
    }
}

// Menentukan nilai awal untuk form berdasarkan kolom yang tersedia
$val_nama = $data['nama'] ?? ($data['nama_pelanggaran'] ?? '');
$val_kat  = $data['kategori'] ?? ($data['kategori_id'] ?? '');
$val_poin = $data['poin'] ?? 0;
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
            <div class="content-card shadow-sm">
                <div class="mb-3">
                    <h2><?= htmlspecialchars($title) ?></h2>
                    <p class="text-muted mb-0">Formulir perubahan data jenis pelanggaran dan bobot poin.</p>
                </div>
                <hr>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Pelanggaran</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($val_nama) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-bold">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" value="<?= htmlspecialchars($val_kat) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="poin" class="form-label fw-bold">Jumlah Poin</label>
                        <input type="number" class="form-control" id="poin" name="poin" value="<?= (int)$val_poin ?>" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="update" class="btn btn-warning fw-semibold px-4 text-dark">Simpan Perubahan</button>
                        <a href="jenis_pelanggaran.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>