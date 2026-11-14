<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['user_id']) && empty($_SESSION['id_user']) && empty($_SESSION['id'])) { header('Location: index.php'); exit; }
if (!isset($_SESSION['user_id'])) $_SESSION['user_id']=(int)($_SESSION['id'] ?? $_SESSION['id_user'] ?? 0);
if (!isset($_SESSION['id'])) $_SESSION['id']=$_SESSION['user_id'];
if (!isset($_SESSION['login'])) $_SESSION['login']=true;
if (!function_exists('requireRole')) { function requireRole(array $roles): void { if (!in_array(strtolower($_SESSION['role'] ?? ''),$roles,true)) { header('Location: forbidden.php'); exit; } } }
