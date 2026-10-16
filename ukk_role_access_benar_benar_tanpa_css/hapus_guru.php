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
    // Hapus terlebih dahulu data terkait di tabel relasi anak
    @mysqli_query($db_connection, "DELETE FROM t_pelanggaran_siswa WHERE guru_id = '$id'");
    @mysqli_query($db_connection, "DELETE FROM t_wali_kelas WHERE guru_id = '$id'");

    // Setelah relasi dibersihkan, hapus data utama guru
    $query = "DELETE FROM t_guru WHERE id = '$id'";
    $hapus = mysqli_query($db_connection, $query);

    if ($hapus) {
        echo "<script>alert('Data guru berhasil dihapus!'); window.location='kelola_guru.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($db_connection) . "'); window.location='kelola_guru.php';</script>";
    }
} else {
    echo "<script>alert('ID Guru tidak ditemukan!'); window.location='kelola_guru.php';</script>";
}
?>