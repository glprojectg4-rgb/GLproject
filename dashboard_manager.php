<?php
session_start();
if (!isset($_SESSION['manager_logged_in'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>

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
            <a href="about.html" class="nav-btn">Contact</a>
            <a href="logout.php" class="nav-login">Logout</a>
        </div>
    </div>
</div>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image"><img src="Image/manager.png"></span>
                <div class="text logo-text">
                    <span class="name">Manager</span>
                    <span class="profession">Blood Bank</span>
                </div>
            </div>
        </header>

        <div class="menu-bar">
            <ul class="menu-links">

                <li class="nav-link">
                    <a href="dashboard_manager.php" class="active">
                        <img src="Image/home.png" class="icon">
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="donors.php">
                        <img src="Image/donor.png" class="icon">
                        <span class="text nav-text">Donors</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="locations.php">
                        <img src="Image/location.png" class="icon">
                        <span class="text nav-text">Locations</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="communication.php">
                        <img src="Image/message.png" class="icon">
                        <span class="text nav-text">Communication</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="content">
        <h1>Welcome Manager</h1>

        <div class="card">
            <h3>Total Donors</h3>
            <p>Placeholder Data</p>
        </div>

        <div class="card">
            <h3>CTS Centers Registered</h3>
            <p>Placeholder Data</p>
        </div>

        <div class="card">
            <h3>Pending Messages</h3>
            <p>Placeholder Data</p>
        </div>

    </div>

</div>

</body>
</html>
