<?php
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP veya WAMP kullanıyorsan genelde boştur
$database = "englishdiary";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}
?>
