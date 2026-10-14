<?php


$title = 'Tambah Kelas';
$section = 'admin';

// Menyesuaikan variabel koneksi database yang tersedia
$db_connection = $pdo ?? $conn ?? $koneksi ?? null;

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $tingkat = $_POST['tingkat'];
    $jurusan = $_POST['jurusan'];
    $status_aktif = $_POST['status_aktif'];

    if ($db_connection) {
        $stmt = $db_connection->prepare("
            INSERT INTO t_kelas
            (nama, tingkat, jurusan, status_aktif)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $nama,
            $tingkat,
            $jurusan,
            $status_aktif
        ]);

        header('Location: kelola_kelas.php');
        exit;
    } else {
        $error_message = "Koneksi database tidak ditemukan. Periksa kembali file config.php Anda.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        
        /* Latar belakang utama halaman abu-abu terang */
        body { display: flex; height: 100vh; background-color: #f4f4f4; overflow: hidden; }
        
        /* Sidebar Kiri Hitam Sesuai Gambar */
        .sidebar { width: 250px; background-color: #000000; color: #fff; display: flex; flex-direction: column; padding: 20px 0; justify-content: space-between; }
        .sidebar-top h2 { font-size: 18px; padding: 0 20px 15px 20px; border-bottom: 1px solid #333; margin-bottom: 15px; color: #fff; }
        .sidebar a { color: #cfd3d6; text-decoration: none; padding: 10px 20px; display: block; font-size: 14px; transition: 0.2s; }
        .sidebar a:hover { background-color: #333; color: #fff; }
        
        /* Menu aktif warna cyan */
        .sidebar a.active { background-color: #00bcd4; color: #fff; font-weight: bold; }
        
        /* Tombol Logout Merah di Bawah Sidebar */
        .sidebar .logout { color: #ffffff; background-color: #a91d3a; margin: 0 20px; text-align: left; border-radius: 4px; font-weight: bold; }
        .sidebar .logout:hover { background-color: #88152c; }
        
        /* Konten Utama Kanan (Kotak Putih) */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; background-color: #ffffff; margin: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header-top { padding: 20px; border-bottom: 1px solid #dee2e6; background-color: #ffffff; border-top-left-radius: 8px; border-top-right-radius: 8px; }
        .header-top h1 { font-size: 24px; color: #333; margin-bottom: 5px; }
        .content-body { padding: 20px; }
        
        /* Form Styling */
        table.form-table { width: 100%; max-width: 600px; border-collapse: collapse; }
        table.form-table td { padding: 10px 5px; font-size: 14px; color: #333; vertical-align: middle; }
        input[type="text"], select { width: 100%; max-width: 400px; padding: 8px 12px; border: 1px solid #ced4da; border-radius: 4px; font-size: 14px; }
        
        .btn-submit { background-color: #ffc107; color: #000; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold; }
        .btn-submit:hover { background-color: #e0a800; }
        
        .btn-back { background-color: #6c757d; color: white; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 14px; display: inline-block; margin-left: 5px; }
        .btn-back:hover { background-color: #5c636a; }
    </style>
</head>
<body>

    <!-- Sidebar Kiri -->
    <div class="sidebar">
        <div class="sidebar-top">
            <h2>My Website</h2>
            <a href="dashboard.php">Dashboard</a>
            <a href="kelola_siswa.php">Data Siswa</a>
            <a href="kelola_guru.php">Data Guru</a>
            <!-- Menu Kelas Aktif -->
            <a href="kelola_kelas.php" class="active">Kelas</a>
            <a href="laporan.php">Laporan</a>
            <a href="about.php">About Me</a>
        </div>
        <div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <!-- Area Kanan -->
    <div class="main-content">
        <div class="header-top">
            <h1>Tambah Kelas</h1>
            <p style="color: #666; font-size: 13px;">Formulir penambahan data kelas baru.</p>
        </div>
        
        <div class="content-body">
            <?php if (isset($error_message)): ?>
                <div style="color: red; margin-bottom: 15px; font-size: 14px;"><?= $error_message ?></div>
            <?php endif; ?>

            <form method="POST">
                <table class="form-table">
                    <tr>
                        <td width="150">Nama Kelas</td>
                        <td width="10">:</td>
                        <td>
                            <input type="text" name="nama" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Tingkat</td>
                        <td>:</td>
                        <td>
                            <select name="tingkat" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Jurusan</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="jurusan" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td>
                            <select name="status_aktif" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding-top: 20px;">
                            <button type="submit" name="simpan" class="btn-submit">Simpan</button>
                            <a href="kelola_kelas.php" class="btn-back">Batal</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</body>
</html>