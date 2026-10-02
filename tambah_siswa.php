<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nisn          = $_POST['nisn'];
    $nama          = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat        = $_POST['alamat'];
    $status        = $_POST['status'];

    $query = "INSERT INTO t_siswa 
              (nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status)
              VALUES 
              ('$nisn', '$nama', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$status')";

    $simpan = mysqli_query($koneksi, $query);

    if ($simpan) {
        echo "<script>
                alert('Data siswa berhasil ditambahkan');
                window.location='kelola_siswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Data siswa gagal ditambahkan');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>
</head>

<body>

<h1>Tambah Siswa</h1>

<p>
    <a href="kelola_siswa.php">Kembali ke Kelola Siswa</a>
</p>

<form method="POST">

    <table>

        <tr>
            <td>NISN</td>
            <td>:</td>
            <td>
                <input type="text" name="nisn" required>
            </td>
        </tr>

        <tr>
            <td>Nama Siswa</td>
            <td>:</td>
            <td>
                <input type="text" name="nama" required>
            </td>
        </tr>

        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>
                <input type="date" name="tanggal_lahir" required>
            </td>
        </tr>

        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>
                <textarea name="alamat" rows="4" cols="30" required></textarea>
            </td>
        </tr>

        <tr>
            <td>Status</td>
            <td>:</td>
            <td>
                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td>
                <button type="submit" name="simpan">Simpan</button>
                <a href="kelola_siswa.php">Batal</a>
            </td>
        </tr>

    </table>

</form>

</body>
</html>