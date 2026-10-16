<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$db_connection = $conn ?? $koneksi ?? mysqli_connect("localhost", "root", "", "db_ukk_2026");

$id = $_GET['id'] ?? null;

if ($id) {
    // 1. Hapus dulu data terkait di tabel relasi (misal: t_kelas_siswa & t_pelanggaran_siswa jika ada)
    @mysqli_query($db_connection, "DELETE FROM t_kelas_siswa WHERE siswa_id = '$id'");
    @mysqli_query($db_connection, "DELETE FROM t_pelanggaran_siswa WHERE siswa_id = '$id'"); // Sesuaikan nama kolom jika ada

    // 2. Setelah data di tabel anak terhapus, baru hapus data utamanya di t_siswa
    $query = "DELETE FROM t_siswa WHERE id = '$id'";
    $hapus = mysqli_query($db_connection, $query);

    if ($hapus) {
        echo "<script>alert('Data siswa berhasil dihapus!'); window.location='kelola_siswa.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($db_connection) . "'); window.location='kelola_siswa.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location='kelola_siswa.php';</script>";
}
?>