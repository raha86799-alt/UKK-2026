<?php
require '../includes/auth.php';
require '../config.php';
requireRole(['admin']);

$title = 'Kelola Kategori Pelanggaran';
$section = 'admin';

include '../includes/header.php';
?>

<h1><?= htmlspecialchars($title) ?></h1>

<p>
    <a href="tambah_kategori_pelanggaran.php">+ Tambah Kategori</a>
</p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Deskripsi</th>
        <th>Status</th>
    </tr>

<?php
$stmt = $pdo->query("
    SELECT
        id,
        nama,
        deksripsi,
        status_aktif
    FROM t_pelanggaran_kategori
    ORDER BY id DESC
");

$rows = $stmt->fetchAll();

foreach ($rows as $i => $row):
?>

    <tr>
        <td><?= $i + 1 ?></td>

        <td>
            <?= htmlspecialchars($row['nama']) ?>
        </td>

        <td>
            <?= htmlspecialchars($row['deksripsi']) ?>
        </td>

        <td>
            <?= $row['status_aktif'] ? 'Aktif' : 'Tidak Aktif' ?>
        </td>
    </tr>

<?php endforeach; ?>

</table>

<?php include '../includes/footer.php'; ?>