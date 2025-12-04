<?php
// ✅Start session and check if agent is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.html"); 
    // 🔁Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="css/dashboard_agent.css">
    <link rel="stylesheet" href="css/agent_pages.css">
</head>

<body>

<!-- NAVBAR -->
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

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image"><img src="Image/user1.png"></span>
                <div class="text logo-text">
                    <span class="name">Admin</span>
                    <span class="profession">Control Panel</span>
                </div>
            </div>
        </header>

        <div class="menu-bar">
            <ul class="menu-links">

                <li class="nav-link">
                    <a href="dashboard_admin.php" class="active">
                        <img src="Image/home.png" class="icon">
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="accounts_admin.html">
                        <img src="Image/add-user.png" class="icon">
                        <span class="text nav-text">Accounts</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="diseases_admin.html">
                        <img src="Image/virus.png" class="icon">
                        <span class="text nav-text">Diseases</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="admin_alerts.html">
                        <img src="Image/danger.png" class="icon">
                        <span class="text nav-text">System Alerts</span>
                    </a>
                </li>

            </ul>

            <!-- DARK MODE -->
            <div class="bottom-content">
                <li class="mode">
                    <div class="sun-moon">
                        <img src="Image/dark.png" class="icon moon">
                        <img src="Image/light.png" class="icon sun">
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="content">
        <h1>Welcome Admin</h1>

        <!-- 3 SIMPLE CARDS (LIKE AGENT) -->
        <div class="card">
            <h3>Total Accounts</h3>
            <p>Placeholder Data</p>
        </div>

        <div class="card">
            <h3>Total Diseases</h3>
            <p>Placeholder Data</p>
        </div>

        <div class="card">
            <h3>Pending Alerts</h3>
            <p>Placeholder Data</p>
        </div>

    </div>

</div>

<script src="script.js"></script>
</body>
</html>
