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
        $stmt = $db_pdo->prepare("DELETE FROM t_wali_kelas WHERE id = ?");
        $hapus = $stmt->execute([$id]);

        if ($hapus) {
            echo "<script>alert('Data wali kelas berhasil dihapus!'); window.location='kelola_wali_kelas.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "'); window.location='kelola_wali_kelas.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='kelola_wali_kelas.php';</script>";
    exit;
}
?>