<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

$title = 'Catat Pelanggaran';
$section = 'admin';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

// Proses Simpan Pelanggaran Siswa
if (isset($_POST['submit'])) {
    $tanggal        = trim($_POST['tanggal'] ?? '');
    $siswa_id       = trim($_POST['siswa_id'] ?? '');
    $kelas_id       = trim($_POST['kelas_id'] ?? '');
    $pelanggaran_id = trim($_POST['pelanggaran_id'] ?? '');
    $status         = trim($_POST['status'] ?? 'Proses');
    
    $guru_id         = $_SESSION['guru_id'] ?? 1; 
    $tahun_ajaran_id = 1;

    if (empty($tanggal) || empty($siswa_id) || empty($kelas_id) || empty($pelanggaran_id)) {
        echo "<script>alert('Harap isi semua data wajib!'); window.history.back();</script>";
        exit;
    }

    // Ambil nama siswa
    $q_siswa = mysqli_query($db_connection, "SELECT nama FROM t_siswa WHERE id = '$siswa_id' LIMIT 1");
    $d_siswa = mysqli_fetch_assoc($q_siswa);
    $nama_siswa = mysqli_real_escape_string($db_connection, $d_siswa['nama'] ?? '');

    // Ambil nama kelas
    $q_kelas = mysqli_query($db_connection, "SELECT nama FROM t_kelas WHERE id = '$kelas_id' LIMIT 1");
    $d_kelas = mysqli_fetch_assoc($q_kelas);
    $nama_kelas = mysqli_real_escape_string($db_connection, $d_kelas['nama'] ?? '');

    // Ambil detail pelanggaran & deskripsi kategori untuk tindakan otomatis
    $q_pel = mysqli_query($db_connection, "
        SELECT p.nama, p.poin, p.pelanggaran_kategori_id, pk.deskripsi AS deskripsi_kategori 
        FROM t_pelanggaran p 
        LEFT JOIN t_pelanggaran_kategori pk ON p.pelanggaran_kategori_id = pk.id 
        WHERE p.id = '$pelanggaran_id' LIMIT 1
    ");
    $d_pel = mysqli_fetch_assoc($q_pel);
    $nama_pelanggaran = mysqli_real_escape_string($db_connection, $d_pel['nama'] ?? '');
    $poin = $d_pel['poin'] ?? 0;
    $pelanggaran_kategori_id = $d_pel['pelanggaran_kategori_id'] ?? 1;
    
    // Tindakan otomatis diambil dari deskripsi kategori pelanggaran
    $tindakan = mysqli_real_escape_string($db_connection, $d_pel['deskripsi_kategori'] ?? 'Pembinaan oleh guru.');

    // Ambil nama guru
    $q_guru = mysqli_query($db_connection, "SELECT nama FROM t_guru WHERE id = '$guru_id' LIMIT 1");
    $d_guru = mysqli_fetch_assoc($q_guru);
    $nama_guru = mysqli_real_escape_string($db_connection, $d_guru['nama'] ?? 'Admin');

    $query_insert = "INSERT INTO t_pelanggaran_siswa 
        (tahun_ajaran_id, siswa_id, nama_siswa, kelas_id, nama_kelas, pelanggaran_id, nama_pelanggaran, pelanggaran_kategori_id, guru_id, nama_guru, tanggal, poin, tindakan, status, created_at, updated_at) 
        VALUES ('$tahun_ajaran_id', '$siswa_id', '$nama_siswa', '$kelas_id', '$nama_kelas', '$pelanggaran_id', '$nama_pelanggaran', '$pelanggaran_kategori_id', '$guru_id', '$nama_guru', '$tanggal', '$poin', '$tindakan', '$status', NOW(), NOW())";
    
    $insert = mysqli_query($db_connection, $query_insert);
    if ($insert) {
        echo "<script>alert('Pelanggaran siswa berhasil dicatat!'); window.location='laporan.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($db_connection) . "'); window.history.back();</script>";
    }
}

// Ambil data Siswa beserta Kelas aktifnya menggunakan JOIN
$query_siswa = mysqli_query($db_connection, "
    SELECT s.id AS siswa_id, s.nama AS nama_siswa, k.id AS kelas_id, k.nama AS nama_kelas 
    FROM t_siswa s 
    LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id AND ks.status_aktif = 1 
    LEFT JOIN t_kelas k ON ks.kelas_id = k.id 
    ORDER BY s.nama ASC
");

// Ambil data Jenis Pelanggaran
$query_pelanggaran = mysqli_query($db_connection, "SELECT * FROM t_pelanggaran ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
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
    </style>
</head>
<body>

<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">

        <!-- Memanggil Sidebar Terpusat -->
        <?php include "layout/sidebar.php"; ?>

        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2>Catat Pelanggaran</h2>
                    <p class="text-muted mb-0">SISTEM INFORMASI PELANGGARAN SISWA</p>
                </div>
                <span class="badge bg-light text-dark border p-2">Tahun Ajaran Aktif: 2026/2027</span>
            </div>

            <div class="content-card shadow-sm">
                <h4 class="fw-bold mb-4">Form Input Pelanggaran Siswa</h4>

                <form action="" method="POST">
                    <div class="row mb-3">
                        <!-- Tanggal Kejadian -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Kejadian</label>
                            <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <!-- Pilih Siswa dengan Search -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Siswa</label>
                            <select class="form-select select2-siswa" name="siswa_id" id="siswa_select" required onchange="updateKelas(this)">
                                <option value="">-- Pilih atau Cari Siswa --</option>
                                <?php while ($s = mysqli_fetch_assoc($query_siswa)) { ?>
                                    <option value="<?= $s['siswa_id'] ?>" data-kelasid="<?= $s['kelas_id'] ?>" data-kelasnama="<?= htmlspecialchars($s['nama_kelas'] ?? '-') ?>">
                                        <?= htmlspecialchars($s['nama_siswa']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Jenis Pelanggaran -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Pelanggaran</label>
                            <select class="form-select select2-pelanggaran" name="pelanggaran_id" required>
                                <option value="">-- Pilih atau Cari Pelanggaran --</option>
                                <?php while ($p = mysqli_fetch_assoc($query_pelanggaran)) { ?>
                                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?> (<?= $p['poin'] ?> Poin)</option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Kelas (Otomatis Terisi) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kelas</label>
                            <input type="text" class="form-control bg-light" id="nama_kelas_display" placeholder="-- Pilih Siswa Terlebih Dahulu --" readonly>
                            <input type="hidden" name="kelas_id" id="kelas_id_input">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Status Pembinaan -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Status Pembinaan</label>
                            <select class="form-select" name="status" required>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" name="submit" class="btn btn-primary px-4 fw-semibold">Simpan Data</button>
                        <a href="laporan.php" class="btn btn-secondary px-4 fw-semibold ms-2">Batal</a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Inisialisasi Select2 & Script Auto Kelas -->
<script>
$(document).ready(function() {
    $('.select2-siswa').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih atau Cari Siswa --',
        allowClear: true
    });

    $('.select2-pelanggaran').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih atau Cari Pelanggaran --',
        allowClear: true
    });
});

function updateKelas(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const kelasNama = selectedOption ? selectedOption.getAttribute('data-kelasnama') || '' : '';
    const kelasId = selectedOption ? selectedOption.getAttribute('data-kelasid') || '' : '';

    document.getElementById('nama_kelas_display').value = kelasNama;
    document.getElementById('kelas_id_input').value = kelasId;
}

$('#siswa_select').on('change', function() {
    updateKelas(this);
});
</script>

</body>
</html>