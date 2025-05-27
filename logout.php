<?php
session_start();

// Tüm oturum değişkenlerini temizle
$_SESSION = array();

// Oturumu tamamen yok et
session_destroy();

// Anasayfaya yönlendir
header("Location: index.php");
exit;
