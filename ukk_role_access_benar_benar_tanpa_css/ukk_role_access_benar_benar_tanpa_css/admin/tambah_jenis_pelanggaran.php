<?php
require '../includes/auth.php';
require '../config.php';
requireRole(['admin']);

$title = 'Tambah Jenis Pelanggaran';
$section = 'admin';

if (isset($_POST['simpan'])) {

    $pelanggaran_kategori_id = $_POST['pelanggaran_kategori_id'];
    $kode = trim($_POST['kode']);
    $nama = trim($_POST['nama']);
    $poin = $_POST['poin'];
    $deksripsi = trim($_POST['deksripsi']);
    $status_aktif = $_POST['status_aktif'];

    $stmt = $pdo->prepare("
        INSERT INTO t_pelanggaran
        (
            pelanggaran_kategori_id,
            kode,
            nama,
            poin,
            deksripsi,
            status_aktif
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $pelanggaran_kategori_id,
        $kode,
        $nama,
        $poin,
        $deksripsi,
        $status_aktif
    ]);

    header('Location: jenis_pelanggaran.php');
    exit;
}

$stmtKategori = $pdo->query("
    SELECT
        id,
        nama
    FROM t_pelanggaran_kategori
    WHERE status_aktif = 1
    ORDER BY nama ASC
");

$kategori = $stmtKategori->fetchAll();

include '../includes/header.php';
?>

<h1>Tambah Jenis Pelanggaran</h1>

<p>
    <a href="jenis_pelanggaran.php">
        Kembali ke Kelola Jenis Pelanggaran
    </a>
</p>

<form method="POST">

<table>

    <tr>
        <td>Kategori Pelanggaran</td>
        <td>:</td>
        <td>
            <select name="pelanggaran_kategori_id" required>
                <option value="">-- Pilih Kategori --</option>

                <?php foreach ($kategori as $row): ?>

                    <option value="<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['nama']) ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </td>
    </tr>

    <tr>
        <td>Kode</td>
        <td>:</td>
        <td>
            <input
                type="text"
                name="kode"
                placeholder="Contoh: P001"
                required
            >
        </td>
    </tr>

    <tr>
        <td>Nama Pelanggaran</td>
        <td>:</td>
        <td>
            <input
                type="text"
                name="nama"
                placeholder="Contoh: Terlambat masuk sekolah"
                required
            >
        </td>
    </tr>

    <tr>
        <td>Poin</td>
        <td>:</td>
        <td>
            <input
                type="number"
                name="poin"
                min="0"
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

            <a href="jenis_pelanggaran.php">
                Batal
            </a>
        </td>
    </tr>

</table>

</form>

<?php include '../includes/footer.php'; ?>