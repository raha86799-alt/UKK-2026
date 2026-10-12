<?php
require '../includes/auth.php';
require '../config.php';
requireRole(['admin']);

$title = 'Kelola Tahun Ajaran';
$section = 'admin';

include '../includes/header.php';
?>

<h1>Kelola Tahun Ajaran</h1>

<p>
    <a href="tambah_tahun_ajaran.php">+ Tambah Tahun Ajaran</a>
</p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Nama Tahun Ajaran</th>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Status</th>
    </tr>

<?php
$stmt = $pdo->query("
    SELECT
        id,
        nama,
        tanggal_mulai,
        tanggal_selesai,
        status_aktif
    FROM t_tahun_ajaran
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
            <?= htmlspecialchars($row['tanggal_mulai']) ?>
        </td>

        <td>
            <?= htmlspecialchars($row['tanggal_selesai']) ?>
        </td>

        <td>
            <?= $row['status_aktif'] ? 'Aktif' : 'Tidak Aktif' ?>
        </td>
    </tr>

<?php endforeach; ?>

</table>

<?php include '../includes/footer.php'; ?>