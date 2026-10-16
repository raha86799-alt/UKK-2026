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
        // Hapus relasi terkait terlebih dahulu di tabel anak untuk mencegah error Foreign Key Constraint
        $stmtRelasi = $db_pdo->prepare("DELETE FROM t_kelas_siswa WHERE tahun_ajaran_id = ?");
        @$stmtRelasi->execute([$id]);

        $stmtWali = $db_pdo->prepare("DELETE FROM t_wali_kelas WHERE tahun_ajaran_id = ?");
        @$stmtWali->execute([$id]);

        // Hapus data utama tahun ajaran
        $stmt = $db_pdo->prepare("DELETE FROM t_tahun_ajaran WHERE id = ?");
        $hapus = $stmt->execute([$id]);

        if ($hapus) {
            echo "<script>alert('Data tahun ajaran berhasil dihapus!'); window.location='kelola_tahun_ajaran.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "'); window.location='kelola_tahun_ajaran.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location='kelola_tahun_ajaran.php';</script>";
    exit;
}
?>