<?php
if (!isset($koneksi) || !($koneksi instanceof mysqli)) {
 $koneksi=mysqli_connect('127.0.0.1','root','','db_ukk_2026');
 if (!$koneksi) die('Koneksi database gagal: '.mysqli_connect_error());
 mysqli_set_charset($koneksi,'utf8mb4');
}
