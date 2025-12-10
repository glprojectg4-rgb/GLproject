<?php
// ✅Start session and check if agent is logged in
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "agent") {
    header("Location: login.html");
    exit();
}

// Placeholder variables for the dynamic content
// Replace these with actual database fetches in a live environment
$total_donations_today = 42;
$critical_blood_types = "O-, AB-";
$pending_alerts_count = 7;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Agent Dashboard</title>

    <link rel="stylesheet" href="css/dashboard_agent.css">

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

                        <li class="nav-link">
                            <a href="dashboard_agent.php">
                                <img src="Image/home.png" class="icon" alt="Dashboard Icon">
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="donations.html">
                                <img src="Image/donations.png" class="icon" alt="Donations Icon">
                                <span class="text nav-text">Donations</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="universal_donors.html">
                                <img src="Image/univ.png" class="icon" alt="Universal Donors Icon">
                                <span class="text nav-text">Univ. Donors</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="stock.php">
                                <img src="Image/stock.png" class="icon" alt="Blood Stock Icon">
                                <span class="text nav-text">Blood Stock</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="alert.html">
                                <img src="Image/alert.png" class="icon" alt="Alert Icon">
                                <span class="text nav-text">Send Alert</span>
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
            <h1>Welcome Agent</h1>

            <div class="quick-actions-grid">

                <a href="donations.html" class="big-btn">
                    <img src="Image/donations.png" class="big-btn-icon" alt="Donations Icon">
                    <h3>Manage Donations</h3>
                    <p>Register new donations and update records.</p>
                </a>

                <a href="universal_donors.html" class="big-btn">
                    <img src="Image/univ.png" class="big-btn-icon" alt="Universal Donors Icon">
                    <h3>Universal Donors</h3>
                    <p>List, verify, and track O- donors.</p>
                </a>

                <a href="stock.php" class="big-btn">
                    <img src="Image/stock.png" class="big-btn-icon" alt="Blood Stock Icon">
                    <h3>Blood Stock</h3>
                    <p>Monitor blood levels by blood type.</p>
                </a>

                <a href="alert.html" class="big-btn">
                    <img src="Image/alert.png" class="big-btn-icon" alt="Alert Icon">
                    <h3>Send Alert</h3>
                    <p>Immediate emergency notifications to donors.</p>
                </a>

            </div>

            <div class="small-cards-row">
                <div class="small-card">
                    <h4>Today’s Donations</h4>
                    <p><?php echo $total_donations_today; ?> Units</p>
                </div>

                <div class="small-card">
                    <h4>Critical Blood Types</h4>
                    <p><?php echo $critical_blood_types; ?></p>
                </div>

                <div class="small-card">
                    <h4>Pending Alerts</h4>
                    <p><?php echo $pending_alerts_count; ?> Requests</p>
                </div>
            </div>
        </div>

    </div>

    <script src="script.js"></script>

</body>

</html>