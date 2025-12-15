<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "manager") {
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
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/dashboard_manager.css">

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
                    <span class="image">
                        <img src="Image/user2.png" alt="User">
                    </span>
                    <div class="text logo-text">
                        <span class="name">Manager</span>
                        <span class="profession">Blood Bank</span>
                    </div>
                </div>
            </header>

            <div class="menu-bar">
                <div class="menu">
                    <ul class="menu-links">

                        <li class="nav-link">
                            <a href="dashboard_manager.php" class="active">
                                <img src="Image/home.png" class="icon" alt="Dashboard Icon">
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="donors.php">
                                <img src="Image/donations.png" class="icon" alt="Donors Icon">
                                <span class="text nav-text">Donors</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="locations.php">
                                <img src="Image/location.png" class="icon" alt="Locations Icon">
                                <span class="text nav-text">Locations</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="communication.php">
                                <img src="Image/message.png" class="icon" alt="Communicate Icon">
                                <span class="text nav-text">Communicate</span>
                            </a>
                        </li>

                    </ul>
                </div>

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
            <h1>Welcome Manager</h1>

            <div class="quick-actions-grid">

                <a href="donors.php" class="big-btn">
                    <img src="Image/donations.png" class="big-btn-icon" alt="Donors Icon">
                    <h3>Manage Donors</h3>
                    <p>View, edit, and verify donor records.</p>
                </a>

                <a href="locations.php" class="big-btn">
                    <img src="Image/location.png" class="big-btn-icon" alt="Locations Icon">
                    <h3>Manage Locations</h3>
                    <p>Register and oversee CTS centers.</p>
                </a>

                <a href="communication.php" class="big-btn">
                    <img src="Image/message.png" class="big-btn-icon" alt="Communicate Icon">
                    <h3>Send Campaigns</h3>
                    <p>Communicate alerts and requests to specific donor groups.</p>
                </a>



            </div>

            <div class="small-cards-row">

                <div class="small-card card-donors">
                    <h4>Total Donors</h4>
                    <p><?php
                        $donors_query = "SELECT COUNT(*) as count FROM donors";
                        $donors_result = $conn->query($donors_query);
                        echo $donors_result->fetch_assoc()['count'];
                    ?></p>
                </div>

                <div class="small-card card-locations">
                    <h4>CTS Centers Registered</h4>
                    <p><?php
                        $cts_query = "SELECT COUNT(*) as count FROM cts_centers";
                        $cts_result = $conn->query($cts_query);
                        echo $cts_result->fetch_assoc()['count'];
                    ?></p>
                </div>

                <div class="small-card card-messages">
                    <h4>Partners & Associations</h4>
                    <p><?php
                        $partners_query = "SELECT COUNT(*) as count FROM partners";
                        $partners_result = $conn->query($partners_query);
                        $partners_count = $partners_result->fetch_assoc()['count'];

                        $assoc_query = "SELECT COUNT(*) as count FROM associations";
                        $assoc_result = $conn->query($assoc_query);
                        $assoc_count = $assoc_result->fetch_assoc()['count'];

                        echo ($partners_count + $assoc_count);
                    ?></p>
                </div>

            </div>

        </div>

    </div>

    <script src="script.js"></script>

</body>

</html>