<?php
session_start();
require_once 'db_connection.php';

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: login.html");
    exit();
}

$message = "";

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Add New User
    if (isset($_POST['add_user'])) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $role = strtolower($_POST['role']);
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $username = $full_name; // Use full name as username

        // Check if email exists
        $check = $conn->prepare("SELECT id_users FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $message = "Error: Email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, role, password, username, status, is_deleted) VALUES (?, ?, ?, ?, ?, 'active', 0)");
            $stmt->bind_param("sssss", $full_name, $email, $role, $hashed_password, $username);
            
            if ($stmt->execute()) {
                $message = "<strong>✅ User added successfully!</strong><br><br>
                            <strong>Login Credentials:</strong><br>
                            Username: <strong>$username</strong><br>
                            Password: <strong>$password</strong><br>
                            Role: <strong>" . ucfirst($role) . "</strong><br><br>
                            <em>Please save these credentials and share them with the user.</em>";
            } else {
                $message = "Error adding user: " . $conn->error;
            }
        }
    }

    // Delete User (Soft Delete)
    if (isset($_POST['delete_user'])) {
        $id_to_delete = $_POST['user_id'];
        $stmt = $conn->prepare("UPDATE users SET is_deleted = 1 WHERE id_users = ?");
        $stmt->bind_param("i", $id_to_delete);
        if ($stmt->execute()) {
            $message = "User deleted successfully.";
        } else {
            $message = "Error deleting user.";
        }
    }
}

// Fetch Users
$users = $conn->query("SELECT * FROM users WHERE is_deleted = 0 ORDER BY CreateD_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Accounts</title>

    <link rel="stylesheet" href="css/dashboard_agent.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/agent_pages.css">
</head>

<body>

    <div class="navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="Image/drop-of-blood-emoji.png">
                <span>Donors</span>
            </div>
            <div class="menu">
                <a href="index.html" class="nav-btn">Home</a>
                <a href="about.html" class="nav-btn">About</a>
                <a href="logout.php" class="nav-login">Logout</a>
            </div>
        </div>
    </div>

    <div class="dashboard-container">

        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image"><img src="Image/user2.png"></span>
                    <div class="text logo-text">
                        <span class="name">Admin</span>
                        <span class="profession">Control Panel</span>
                    </div>
                </div>
            </header>

            <div class="menu-bar">
                <ul class="menu-links">
                    <li class="nav-link"><a href="dashboard_admin.php"><img src="Image/home.png" class="icon"><span
                                class="text nav-text">Dashboard</span></a></li>
                    <li class="nav-link"><a href="accounts_admin.php" class="active"><img src="Image/add-user.png"
                                class="icon"><span class="text nav-text">Accounts</span></a></li>
                    <li class="nav-link"><a href="diseases_admin.php"><img src="Image/virus.png" class="icon"><span
                                class="text nav-text">Diseases</span></a></li>
                    <li class="nav-link"><a href="admin_alerts.php"><img src="Image/danger.png" class="icon"><span
                                class="text nav-text">System Alerts</span></a></li>
                </ul>

                <div class="bottom-content">
                    <li class="mode">
                        <div class="sun-moon">
                            <img src="Image/dark.png" class="icon moon">
                            <img src="Image/light.png" class="icon sun">
                        </div>
                        <span class="mode-text text">Dark mode</span>
                        <div class="toggle-switch"><span class="switch"></span></div>
                    </li>
                </div>
            </div>
        </nav>

        <div class="content">
            <h1 class="gradient-text">Manage Accounts</h1>

            <?php if ($message): ?>
                <div style="background: #e3f2fd; color: #0d47a1; padding: 15px; border-radius: 5px; margin-bottom: 20px; line-height: 1.6;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-card">
                <h3>Add New Account</h3>

                <form method="POST" action="accounts_admin.php">
                    <input type="hidden" name="add_user" value="1">
                    
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>

                    <label>Email</label>
                    <input type="email" name="email" required>

                    <label>Role</label>
                    <select name="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="agent">Agent</option>
                        <option value="manager">Manager</option>
                    </select>

                    <label>Password</label>
                    <input type="password" name="password" required>

                    <button class="submit-btn">Add Account</button>
                </form>
            </div>

            <div class="table-card">
                <h3>Users Accounts</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($row['role'])); ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id_users']; ?>">
                                    <input type="hidden" name="delete_user" value="1">
                                    <button class="btn-action btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
