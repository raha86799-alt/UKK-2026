<?php
require '../includes/auth.php';
require '../config.php';
requireRole(['admin']);

$title = 'Tambah Tahun Ajaran';
$section = 'admin';

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_aktif = $_POST['status_aktif'];

    $stmt = $pdo->prepare("
        INSERT INTO t_tahun_ajaran
        (
            nama,
            tanggal_mulai,
            tanggal_selesai,
            status_aktif
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $nama,
        $tanggal_mulai,
        $tanggal_selesai,
        $status_aktif
    ]);

    header('Location: tahun_ajaran.php');
    exit;
}

include '../includes/header.php';
?>

<h1>Tambah Tahun Ajaran</h1>

<p>
    <a href="tahun_ajaran.php">Kembali ke Kelola Tahun Ajaran</a>
</p>

<form method="POST">

<table>

    <tr>
        <td>Nama Tahun Ajaran</td>
        <td>:</td>
        <td>
            <input
                type="text"
                name="nama"
                placeholder="Contoh: 2025/2026"
                required
            >
        </td>
    </tr>

    <tr>
        <td>Tanggal Mulai</td>
        <td>:</td>
        <td>
            <input
                type="date"
                name="tanggal_mulai"
                required
            >
        </td>
    </tr>

    <tr>
        <td>Tanggal Selesai</td>
        <td>:</td>
        <td>
            <input
                type="date"
                name="tanggal_selesai"
                required
            >
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
        <td></td>
        <td></td>
        <td>
            <button type="submit" name="simpan">Simpan</button>
            <a href="tahun_ajaran.php">Batal</a>
        </td>
    </tr>

</table>

</form>

<?php include '../includes/footer.php'; ?>