<?php
<<<<<<< HEAD
// ✅Start session and check if agent is logged in
session_start();
if (!isset($_SESSION['agent_logged_in'])) {
    header("Location: login.html"); 
    // 🔁Redirect to login if not logged in
    exit();
}
?>

=======
// ✅ Start session and check if agent is logged in
session_start();
if (!isset($_SESSION['agent_logged_in'])) {
    header("Location: login.html"); // 🔁 Redirect to login if not logged in
    exit();
}
?>
>>>>>>> d0a0372ed342d0671b952b25031edcbc8ae29e5a
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Agent Dashboard</title>
<<<<<<< HEAD

    <!-- CSS Link -->
    <link rel="stylesheet" href="css/dashboard_agent.css">

    <!-- NOTE: The Boxicons CDN is REMOVED as we are using PNG images now -->
=======
    <link rel="stylesheet" href="css/dashboard_agent.css">
>>>>>>> d0a0372ed342d0671b952b25031edcbc8ae29e5a
</head>

<body>

<<<<<<< HEAD
    <!-- =========================
         NAVBAR 
    ========================== -->
    <div class="navbar">
        <div class="nav-container">
            <div class="logo">
                <!-- Using a placeholder for the blood drop logo -->
                <img src="Image/drop-of-blood-emoji.png" alt="logo">
=======
    <div class="navbar">
        <div class="nav-container">
            <div class="logo">
                <img src="Image/drop-of-blood-emoji.png">
>>>>>>> d0a0372ed342d0671b952b25031edcbc8ae29e5a
                <span>Donors</span>
            </div>

            <div class="menu">
                <a href="index.html" class="nav-btn">Home</a>
                <a href="about.html" class="nav-btn">Contact</a>
                <a href="logout.php" class="nav-login">Logout</a>
            </div>
        </div>
    </div>

<<<<<<< HEAD
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
                            <a href="dashboard_agent.html">
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
                            <a href="stock.html">
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
=======
    <div class="dashboard-container">

        <div class="sidebar">
            <h1>Agent</h1>
            <div class="sidebar-menu">
                <a href="dashboard_agent.php" class="active">Dashboard</a>
                <a href="donations.html">Manage Donations</a>
                <a href="universal_donors.html">Universal Donors</a>
                <a href="stock.html">Blood Stock</a>
                <a href="alert.html">Send Alert</a>
            </div>
        </div>

>>>>>>> d0a0372ed342d0671b952b25031edcbc8ae29e5a
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
<<<<<<< HEAD

    </div>

    <!-- JavaScript for Dark Mode (Linked externally) -->
    <script src="script.js"></script>

=======
    </div>

>>>>>>> d0a0372ed342d0671b952b25031edcbc8ae29e5a
</body>

</html>