<?php
if(!defined('HAK_ADMIN'))define('HAK_ADMIN','admin');
if(!defined('HAK_WALI_KELAS'))define('HAK_WALI_KELAS','wali_kelas');
if(!defined('HAK_GURU'))define('HAK_GURU','guru');
if(!function_exists('hak_role_efektif')){function hak_role_efektif(){return strtolower($_SESSION['role']??'guru');}}
if(!function_exists('hak_label_role')){function hak_label_role($r){return ucwords(str_replace('_',' ',$r));}}
if(!function_exists('hak_cek_permintaan')){function hak_cek_permintaan(){return true;}}
if(!function_exists('hak_menu_role')){function hak_menu_role($r){return [];}}
