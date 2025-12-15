<?php
require_once 'db_connection.php';


$username = 'admin2';
$password = 'admin1235';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$email = 'admin2@example.com';
$phone = '0555323456';
$full_name = 'Med Admin';
$profile_picture = 'uploads/profile/admin2.jpg';
$role = 'admin';
$status = 'active';
$created_by = 1;
$updated_by = 1;


$stmt = $conn->prepare("INSERT INTO users 
    (username, password, email, phone, full_name, profile_picture, role, status, email_verified, created_by, updated_by) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$email_verified = true;

$stmt->bind_param(
    "ssssssssiii",
    $username,
    $hashedPassword,
    $email,
    $phone,
    $full_name,
    $profile_picture,
    $role,
    $status,
    $email_verified,
    $created_by,
    $updated_by
);

if ($stmt->execute()) {
    echo "✅ تم إدخال المستخدم بنجاح!";
} else {
    echo "❌ خطأ أثناء الإدخال: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>