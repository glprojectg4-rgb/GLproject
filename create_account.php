<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // تشفير كلمة المرور
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // إعداد الاستعلام
    $stmt = $conn->prepare("INSERT INTO users 
        (username, password, email, phone, full_name, role, status, email_verified, created_by, updated_by) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1, 1)");

    $stmt->bind_param(
        "sssssss",
        $username,
        $hashedPassword,
        $email,
        $phone,
        $full_name,
        $role,
        $status
    );

    if ($stmt->execute()) {
        echo "<script>alert('✅ تم إنشاء الحساب بنجاح'); window.location.href='create_account.html';</script>";
    } else {
        echo "<script>alert('❌ حدث خطأ أثناء إنشاء الحساب: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: create_account.html");
    exit;
}
?>