<?php
require '../includes/auth.php';
require '../config.php';
requireRole(['admin']);

$title = 'Tambah Kategori Pelanggaran';
$section = 'admin';

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);
    $deksripsi = trim($_POST['deksripsi']);
    $status_aktif = $_POST['status_aktif'];

    $stmt = $pdo->prepare("
        INSERT INTO t_pelanggaran_kategori
        (
            nama,
            deksripsi,
            status_aktif
        )
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $nama,
        $deksripsi,
        $status_aktif
    ]);

    header('Location: kategori_pelanggaran.php');
    exit;
}

include '../includes/header.php';
?>

<h1>Tambah Kategori Pelanggaran</h1>

<p>
    <a href="kategori_pelanggaran.php">
        Kembali ke Kelola Kategori
    </a>
</p>

<form method="POST">

<table>

    <tr>
        <td>Nama Kategori</td>
        <td>:</td>
        <td>
            <input
                type="text"
                name="nama"
                required
            >
        </td>
    </tr>

    <tr>
        <td>Deskripsi</td>
        <td>:</td>
        <td>
            <textarea
                name="deksripsi"
                rows="4"
                cols="40"
                required
            ></textarea>
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
            <button type="submit" name="simpan">
                Simpan
            </button>

            <a href="kategori_pelanggaran.php">
                Batal
            </a>
        </td>
    </tr>

</table>

</form>

<?php include '../includes/footer.php'; ?>