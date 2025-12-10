<?php
require_once 'db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT id_users FROM users WHERE reset_token = ? AND reset_token_expires > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $userId = $user['id_users'];
    } else {
        die("Invalid or expired reset link.");
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE id_users = ?");
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
    <!-- Use dashboard styles for consistency (variables, fonts) -->
    <link rel="stylesheet" href="css/dashboard_agent.css">
    <link rel="stylesheet" href="css/agent_pages.css">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('Image/blood-donation-tampa-cardio.png') no-repeat center center/cover;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }

        /* Dark overlay to ensure text readability on the image */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .reset-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            text-align: center;
            /* Glassmorphism hint or just clean white card */
        }

        .reset-card h2 {
            margin-bottom: 25px;
            color: #b70b0b; /* Primary Red */
            font-size: 26px;
            font-weight: 600;
        }

        .reset-card form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .reset-card input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box; /* Fix padding issue */
        }

        .reset-card input[type="password"]:focus {
            border-color: #b70b0b;
            box-shadow: 0 0 5px rgba(183, 11, 11, 0.2);
        }

        .reset-card button {
            width: 100%;
            padding: 14px;
            background: #b70b0b;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .reset-card button:hover {
            background: #8e0808;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    <div class="reset-card">
        <h2>Reset Your Password</h2>
        <form action="reset_password.php" method="POST">
            <!-- Ensure userId is passed correctly if available -->
            <input type="hidden" name="user_id" value="<?= isset($userId) ? $userId : '' ?>">
            
            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="new_password" required placeholder="Enter your new password">
            </div>

            <button type="submit">Update Password</button>
        </form>
    </div>
</body>

</html>