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
        // Hapus relasi terkait jika ada di tabel anak (contoh: t_kelas_siswa)
        $stmtRelasi = $db_pdo->prepare("DELETE FROM t_kelas_siswa WHERE kelas_id = ?");
        @$stmtRelasi->execute([$id]);

        // Hapus data utama kelas
        $stmt = $db_pdo->prepare("DELETE FROM t_kelas WHERE id = ?");
        $hapus = $stmt->execute([$id]);

        if ($hapus) {
            echo "<script>alert('Data kelas berhasil dihapus!'); window.location='kelola_kelas.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Gagal menghapus data (terikat relasi): " . $e->getMessage() . "'); window.location='kelola_kelas.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID atau koneksi tidak valid!'); window.location='kelola_kelas.php';</script>";
    exit;
}
?>