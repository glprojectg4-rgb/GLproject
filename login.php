<?php
session_start();
$_SESSION['agent_logged_in'] = true;
require_once 'db_connection.php'; // ملف الاتصال بقاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $accountType = $_POST['account_type'];

    // استعلام للتحقق من المستخدم
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ? AND status = 'active' AND is_deleted = 0");
    $stmt->bind_param("ss", $username, $accountType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // التحقق من كلمة المرور
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_users'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // تحديث آخر تسجيل دخول
            $update = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id_users = ?");
            $update->bind_param("i", $user['id_users']);
            $update->execute();

            // التوجيه حسب نوع الحساب
            switch ($user['role']) {
                case 'admin':
                    header("Location: dashboard_admin.php");
                    break;
                case 'manager':
                    header("Location: dashboard_manager.php");
                    break;
                case 'agent':
                    header("Location: dashboard_agent.php");
                    break;
            }
            exit;
        }
    }

    // في حال فشل التحقق
    echo "<script>alert('Invalid username, password, or account type'); window.history.back();</script>";
} else {
    header("Location: login.html");
    exit;
}
?>