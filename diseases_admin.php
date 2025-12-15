<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: login.html");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_disease'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO diseases (name, description, id_users) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $description, $user_id);
        
        if ($stmt->execute()) {
            $message = "Disease added successfully.";
        } else {
            $message = "Error adding disease: " . $conn->error;
        }
    }

    if (isset($_POST['delete_disease'])) {
        $id = $_POST['disease_id'];
        $stmt = $conn->prepare("DELETE FROM diseases WHERE id_diseases = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Disease deleted successfully.";
        } else {
            $message = "Error deleting disease.";
        }
    }
}

$diseases = $conn->query("SELECT * FROM diseases ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Diseases</title>

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
                    <li class="nav-link"><a href="accounts_admin.php"><img src="Image/add-user.png" class="icon"><span
                                class="text nav-text">Accounts</span></a></li>
                    <li class="nav-link"><a href="diseases_admin.php" class="active"><img src="Image/virus.png"
                                class="icon"><span class="text nav-text">Diseases</span></a></li>
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
            <h1 class="gradient-text">Manage Diseases</h1>

            <?php if ($message): ?>
                <div style="background: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-card">
                <h3>Add Disease</h3>
                <form method="POST" action="diseases_admin.php">
                    <input type="hidden" name="add_disease" value="1">
                    
                    <label>Disease Name</label>
                    <input type="text" name="name" required>

                    <label>Description</label>
                    <input type="text" name="description" required>

                    <button class="submit-btn">Add Disease</button>
                </form>
            </div>

            <div class="table-card">
                <h3>Recorded Diseases</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $diseases->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this disease?');">
                                    <input type="hidden" name="disease_id" value="<?php echo $row['id_diseases']; ?>">
                                    <input type="hidden" name="delete_disease" value="1">
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
