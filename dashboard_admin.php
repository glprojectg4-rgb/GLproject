<?php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

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
                    <span class="image"><img src="Image/user2.png" alt="Admin User"></span>
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
                            <img src="Image/home.png" class="icon" alt="Dashboard Icon">
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="accounts_admin.html">
                            <img src="Image/add-user.png" class="icon" alt="Accounts Icon">
                            <span class="text nav-text">Accounts</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="diseases_admin.html">
                            <img src="Image/virus.png" class="icon" alt="Diseases Icon">
                            <span class="text nav-text">Diseases</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="admin_alerts.html">
                            <img src="Image/danger.png" class="icon" alt="Alerts Icon">
                            <span class="text nav-text">System Alerts</span>
                        </a>
                    </li>

                </ul>

                <div class="bottom-content">
                    <li class="mode">
                        <div class="sun-moon">
                            <img src="Image/dark.png" class="icon moon" alt="Dark Mode Icon">
                            <img src="Image/light.png" class="icon sun" alt="Light Mode Icon">
                        </div>
                        <span class="mode-text text">Dark mode</span>

                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>
                </div>
            </div>
        </nav>

        <div class="content">
            <h1>Welcome Admin</h1>

            <div class="quick-actions-grid">

                <a href="accounts_admin.html" class="big-btn">
                    <img src="Image/add-user.png" class="big-btn-icon" alt="Accounts Icon">
                    <h3>Manage Accounts</h3>
                    <p>Create, edit, or remove user access.</p>
                </a>

                <a href="diseases_admin.html" class="big-btn">
                    <img src="Image/virus.png" class="big-btn-icon" alt="Diseases Icon">
                    <h3>Manage Diseases</h3>
                    <p>Update list of detectable diseases.</p>
                </a>

                <a href="admin_alerts.html" class="big-btn">
                    <img src="Image/danger.png" class="big-btn-icon" alt="System Alerts Icon">
                    <h3>System Alerts</h3>
                    <p>Monitor critical system notifications.</p>
                </a>

            </div>

            <div class="small-cards-row">

                <div class="small-card">
                    <h4>Total Accounts</h4>
                    <p>150</p>
                </div>

                <div class="small-card">
                    <h4>Total Diseases</h4>
                    <p>24</p>
                </div>

                <div class="small-card">
                    <h4>Pending Alerts</h4>
                    <p>5</p>
                </div>

            </div>

        </div>

    </div>

    <script src="script.js"></script>
</body>

</html>