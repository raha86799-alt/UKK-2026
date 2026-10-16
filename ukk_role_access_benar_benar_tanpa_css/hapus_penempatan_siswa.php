<?php
session_start();
require_once 'auth.php'; 
require_once 'config.php'; 

if (function_exists('requireRole')) {
    requireRole(['admin']);
}

$db_pdo = $pdo ?? ($conn instanceof PDO ? $conn : null);
$id = $_GET['id'] ?? null;

if ($id && $db_pdo) {
    try {
        $stmt = $db_pdo->prepare("DELETE FROM t_kelas_siswa WHERE id = ?");
        $hapus = $stmt->execute([$id]);

        if ($hapus) {
            echo "<script>alert('Data penempatan siswa berhasil dihapus!'); window.location='penempatan_siswa.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "'); window.location='penempatan_siswa.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='penempatan_siswa.php';</script>";
    exit;
}
?>