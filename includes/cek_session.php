<?php
if(session_status()===PHP_SESSION_NONE)session_start();
if(empty($_SESSION['user_id'])&&empty($_SESSION['id_user'])&&empty($_SESSION['id'])){header('Location: login.php');exit;}
if(!isset($_SESSION['id']))$_SESSION['id']=(int)($_SESSION['user_id']??$_SESSION['id_user']??0);
if(!isset($_SESSION['login']))$_SESSION['login']=true;
require_once __DIR__.'/cek_akses.php';
