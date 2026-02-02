<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: login.html");
    exit();
}

$alerts = $conn->query("SELECT * FROM alerts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>System Alerts</title>

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
                    <li class="nav-link"><a href="diseases_admin.php"><img src="Image/virus.png" class="icon"><span
                                class="text nav-text">Diseases</span></a></li>
                    <li class="nav-link"><a href="admin_alerts.php" class="active"><img src="Image/danger.png"
                                class="icon"><span class="text nav-text">System Alerts</span></a></li>
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
            <h1 class="gradient-text">System Alerts</h1>

            <div class="table-card">
                <h3>All Alerts</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Alert Details</th>
                            <th>Detected Disease</th>
                            <th>Donor Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while($row = $alerts->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php 
                                    if ($row['alert_type'] === 'stock') {
                                        echo "Stock Status Alert";
                                    } else {
                                        echo "Disease Detection Alert";
                                    }
                                ?>
                            </td>
                            <td class="low" style="color: red; font-weight: bold;">
                                <?php echo htmlspecialchars($row['disease_detected']); ?>
                            </td>
                            <td>
                                <?php 
                                    if ($row['alert_type'] === 'stock') {
                                        echo "<em>System Generated</em>";
                                    } else {
                                        echo htmlspecialchars($row['donor_name']); 
                                    }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
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
