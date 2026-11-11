<?php
session_start();
require_once 'auth.php';
require_once 'config.php';

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($db_connection, $_GET['id']);
    $status = mysqli_real_escape_string($db_connection, $_GET['status']);

    // Update status di database berdasarkan tombol yang diklik
    $query = "UPDATE t_pelanggaran_siswa SET status = '$status' WHERE id = '$id'";
    $result = mysqli_query($db_connection, $query);

    if ($result) {
        // Kembali ke halaman tindakan (jika status jadi Selesai, data otomatis hilang dari tabel ini dan masuk ke menu Riwayat)
        header("Location: tindakan.php");
        exit();
    } else {
        echo "Gagal memperbarui status: " . mysqli_error($db_connection);
    }
} else {
    header("Location: tindakan.php");
    exit();
}
?>