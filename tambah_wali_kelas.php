<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$title = 'Tambah Wali Kelas';
$section = 'admin';
$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);

if (isset($_POST['submit'])) {
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'];
    $kelas_id        = $_POST['kelas_id'];
    $guru_id         = $_POST['guru_id'];
    $tanggal_mulai   = $_POST['tanggal_mulai'] ?? null;
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? null;
    $status_aktif    = $_POST['status_aktif'] ?? 1;

    if ($db_pdo) {
        try {
            // Menyesuaikan kolom dengan struktur tabel jika ada tanggal_mulai/selesai, 
            // jika kolom di database belum ada, sesuaikan kembali dengan tabel t_wali_kelas Anda.
            $stmt = $db_pdo->prepare("INSERT INTO t_wali_kelas (guru_id, kelas_id, tahun_ajaran_id, status_aktif, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            $insert = $stmt->execute([$guru_id, $kelas_id, $tahun_ajaran_id, $status_aktif]);

            if ($insert) {
                echo "<script>alert('Data wali kelas berhasil ditambahkan!'); window.location='kelola_wali_kelas.php';</script>";
                exit;
            }
        } catch (Exception $e) {
            echo "<script>alert('Gagal menyimpan data: " . $e->getMessage() . "');</script>";
        }
    }
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
            border-radius: 4px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .form-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .form-table td {
            padding: 10px 8px;
            vertical-align: middle;
        }
        .form-table td.label-col {
            width: 18lerde%;
            font-weight: normal;
        }
        .form-table td.colon-col {
            width: 2%;
            text-align: center;
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

        <!-- KONTEN UTAMA FORM TAMBAH WALI KELAS -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="content-card">
                <h4 class="mb-4"><?= htmlspecialchars($title) ?></h4>

                <form action="" method="POST">
                    <table class="form-table">
                        <tr>
                            <td class="label-col">Tahun Ajaran</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    <?php
                                    if ($db_pdo) {
                                        $tahunList = $db_pdo->query("SELECT id, nama FROM t_tahun_ajaran ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($tahunList as $ta) {
                                            echo "<option value='{$ta['id']}'>{$ta['nama']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Kelas</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" id="kelas_id" name="kelas_id" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php
                                    if ($db_pdo) {
                                        $kelasList = $db_pdo->query("SELECT id, nama FROM t_kelas ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($kelasList as $k) {
                                            echo "<option value='{$k['id']}'>{$k['nama']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Guru Wali Kelas</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" id="guru_id" name="guru_id" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php
                                    if ($db_pdo) {
                                        $guruList = $db_pdo->query("SELECT id, nis, nama FROM t_guru ORDER BY nama ASC")->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($guruList as $g) {
                                            echo "<option value='{$g['id']}'>{$g['nama']} ({$g['nis']})</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Tanggal Mulai</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="date" class="form-control" name="tanggal_mulai">
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Tanggal Selesai</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <input type="date" class="form-control" name="tanggal_selesai">
                            </td>
                        </tr>
                        <tr>
                            <td class="label-col">Status</td>
                            <td class="colon-col">:</td>
                            <td class="input-col">
                                <select class="form-select" id="status_aktif" name="status_aktif" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <button type="submit" name="submit" class="btn btn-primary px-3 py-1">Simpan</button>
                        <a href="kelola_wali_kelas.php" class="text-decoration-none ms-2 text-primary">Batal</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>