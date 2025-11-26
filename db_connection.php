<?php
$host = 'localhost';
$db = 'blood_management';      // اسم قاعدة البيانات التي أنشأتها في phpMyAdmin
$user = 'root';            // اسم المستخدم الافتراضي في MAMP
$pass = 'GL.Root.360';            // كلمة المرور الافتراضية في MAMP

// إذا كنت على macOS، أضف رقم المنفذ (عادة 8889)
$port = 3306; // أو 3306 في Windows

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>