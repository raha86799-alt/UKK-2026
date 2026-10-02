<?php
require '../includes/auth.php';
require '../config.php';
requireRole(['admin']);

$title = 'Kelola Jenis Pelanggaran';
$section = 'admin';

include '../includes/header.php';
?>

<h1>Kelola Jenis Pelanggaran</h1>

<p>
    <a href="tambah_jenis_pelanggaran.php">+ Tambah Jenis Pelanggaran</a>
</p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Kode</th>
        <th>Nama Pelanggaran</th>
        <th>Poin</th>
        <th>Deskripsi</th>
        <th>Status</th>
    </tr>

<?php
$stmt = $pdo->query("
    SELECT
        p.id,
        p.kode,
        p.nama,
        p.poin,
        p.deksripsi,
        p.status_aktif,
        k.nama AS nama_kategori
    FROM t_pelanggaran p
    LEFT JOIN t_pelanggaran_kategori k
        ON p.pelanggaran_kategori_id = k.id
    ORDER BY p.id DESC
");

$rows = $stmt->fetchAll();

foreach ($rows as $i => $row):
?>

    <tr>
        <td><?= $i + 1 ?></td>

        <td>
            <?= htmlspecialchars($row['nama_kategori'] ?? '-') ?>
        </td>

        <td>
            <?= htmlspecialchars($row['kode']) ?>
        </td>

        <td>
            <?= htmlspecialchars($row['nama']) ?>
        </td>

        <td>
            <?= htmlspecialchars($row['poin']) ?>
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