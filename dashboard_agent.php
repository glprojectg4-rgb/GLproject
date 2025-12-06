<?php
// ✅Start session and check if agent is logged in
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "agent") {
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Agent Dashboard</title>

    <!-- CSS Link -->
    <link rel="stylesheet" href="css/dashboard_agent.css">

    <!-- NOTE: The Boxicons CDN is REMOVED as we are using PNG images now -->
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

    <!-- =========================
         LAYOUT CONTAINER
    ========================== -->
    <div class="dashboard-container">

        <!-- =========================
             SIDEBAR 
        ========================== -->
        <nav class="sidebar">
            <header>
                <div class="image-text">
                    <span class="image">
                        <!-- Placeholder User Image -->
                        <img src="Image/employee.png" alt="User">
                    </span>

                    <div class="text logo-text">
                        <span class="name">Agent Panel</span>
                        <span class="profession">Blood Bank</span>
                    </div>
                </div>
            </header>

            <div class="menu-bar">
                <div class="menu">
                    <ul class="menu-links">

                        <!-- Dashboard - Using home.png -->
                        <li class="nav-link">
                            <a href="dashboard_agent.php">
                                <img src="Image/home.png" class="icon" alt="Dashboard Icon">
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>

                        <!-- Manage Donations - Using donation.png -->
                        <li class="nav-link">
                            <a href="donations.html">
                                <img src="Image/donations.png" class="icon" alt="Donations Icon">
                                <span class="text nav-text">Donations</span>
                            </a>
                        </li>

                        <!-- Universal Donors - Using univ.png -->
                        <li class="nav-link">
                            <a href="universal_donors.html">
                                <img src="Image/univ.png" class="icon" alt="Universal Donors Icon">
                                <span class="text nav-text">Univ. Donors</span>
                            </a>
                        </li>

                        <!-- Blood Stock - Using stock.png -->
                        <li class="nav-link">
                            <a href="stock.php">
                                <img src="Image/stock.png" class="icon" alt="Blood Stock Icon">
                                <span class="text nav-text">Blood Stock</span>
                            </a>
                        </li>

                        <!-- Send Alert - Using alert.png -->
                        <li class="nav-link">
                            <a href="alert.html">
                                <img src="Image/alert.png" class="icon" alt="Alert Icon">
                                <span class="text nav-text">Send Alert</span>
                            </a>
                        </li>

                    </ul>
                </div>

                <!-- Dark Mode Toggle (Kept Boxicons for sun/moon appearance) -->
                <div class="bottom-content">
                    <li class="mode">
                        <div class="sun-moon">
                            <!-- Using dark.png for the moon icon -->
                            <img src="Image/dark.png" class="icon moon" alt="Dark Mode Icon">
                            <!-- Assuming light.png for the sun icon -->
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

        <!-- =========================
             MAIN CONTENT
        ========================== -->
        <div class="content">
            <h1>Welcome Agent</h1>

            <div class="card">
                <h3>Total Donations Today</h3>
                <p>Placeholder data</p>
            </div>

            <div class="card">
                <h3>Critical Blood Stock</h3>
                <p>Placeholder data</p>
            </div>

            <div class="card">
                <h3>Pending Alerts</h3>
                <p>Placeholder data</p>
            </div>
        </div>

    </div>

    <!-- JavaScript for Dark Mode (Linked externally) -->
    <script src="script.js"></script>

</body>

</html>