<?php
require_once 'db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $userId = $user['id'];
    } else {
        die("Invalid or expired reset link.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
    $stmt->bind_param("si", $newPassword, $userId);
    $stmt->execute();

    echo "<script>alert('Password updated successfully.'); window.location.href='login.html';</script>";
    exit;
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="form-container">
        <h2>Reset Your Password</h2>
        <form action="reset_password.php" method="POST">
            <input type="hidden" name="user_id" value="<?= $userId ?>">
            <label>New Password:</label>
            <input type="password" name="new_password" required>
            <button type="submit">Update Password</button>
        </form>
    </div>
</body>

</html>