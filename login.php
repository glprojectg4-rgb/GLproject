<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $accountType = $_POST['account_type'];

    // Example hardcoded credentials (replace with database check in production)
    $validUsers = [
        'admin' => ['username' => 'admin', 'password' => 'admin123'],
        'manager' => ['username' => 'manager', 'password' => 'manager123'],
        'agent' => ['username' => 'agent', 'password' => 'agent123'],
    ];

    $valid = false;
    if (isset($validUsers[$accountType])) {
        if ($validUsers[$accountType]['username'] === $username && $validUsers[$accountType]['password'] === $password) {
            $valid = true;
        }
    }

    if ($valid) {
        // Redirect based on account type
        if ($accountType === 'admin') {
            header("Location: dashboard_admin.html");
        } elseif ($accountType === 'manager') {
            header("Location: dashboard_manager.html");
        } elseif ($accountType === 'agent') {
            header("Location: dashboard_agent.html");
        }
        exit;
    } else {
        // Show error (can also redirect back with query string)
        echo "<script>alert('Invalid username, password, or account type'); window.history.back();</script>";
    }
} else {
    header("Location: login.html"); // prevent direct access
    exit;
}
?>
