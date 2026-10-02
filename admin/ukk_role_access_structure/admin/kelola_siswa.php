<?php
require '../includes/auth.php';
require '../config.php';
requireRole(['admin']);

$title = 'Kelola Siswa';
$section = 'admin';

include '../includes/header.php';
?>

<h1><?= htmlspecialchars($title) ?></h1>

<p><a href="tambah_siswa.php">+ Tambah Siswa</a></p>

<table>
    <tr>
        <th>No</th>
        <th>NISN</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Status</th>
    </tr>

<?php
$rows = $pdo->query("SELECT id, nisn, nama, jenis_kelamin, status_aktif FROM t_siswa");
?>

<?php include '../includes/footer.php'; ?>