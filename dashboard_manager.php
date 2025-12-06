
<?php
// ✅Start session and check if agent is logged in
session_start();
if (!isset($_SESSION['manager_logged_in'])) {
    header("Location: login.html"); 
    // 🔁Redirect to login if not logged in
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
                <span class="image"><img src="Image/user2.png"></span>
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
                    <a href="donors.html">
                        <img src="Image/donations.png" class="icon">
                        <span class="text nav-text">Donors</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="locations.html">
                        <img src="Image/location.png" class="icon">
                        <span class="text nav-text">Locations</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="communication.html">
                        <img src="Image/message.png" class="icon">
                        <span class="text nav-text">Communicate</span>
                    </a>
                </li>
            </ul>
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
<!-- JavaScript for Dark Mode (Linked externally) -->
    <script src="script.js"></script>
</body>
</html>
