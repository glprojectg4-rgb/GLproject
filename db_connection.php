<?php
$host = 'localhost';
$db = 'blood_management';
$user = 'root';
$pass = 'GL.Root.360';

$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>