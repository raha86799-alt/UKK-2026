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
        // Langsung hapus data dari tabel t_pelanggaran_kategori berdasarkan ID
        $stmt = $db_pdo->prepare("DELETE FROM t_pelanggaran_kategori WHERE id = ?");
        $hapus = $stmt->execute([$id]);

        if ($hapus) {
            echo "<script>
                    alert('Data kategori pelanggaran berhasil dihapus!'); 
                    window.location.href = 'kategori_pelanggaran.php';
                  </script>";
            exit;
        }
    } catch (Exception $e) {
        $errorMsg = addslashes($e->getMessage());
        echo "<script>
                alert('Gagal menghapus data: {$errorMsg}'); 
                window.location.href = 'kategori_pelanggaran.php';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('ID tidak valid!'); 
            window.location.href = 'kategori_pelanggaran.php';
          </script>";
    exit;
}
?>