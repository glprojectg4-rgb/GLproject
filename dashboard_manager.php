<?php
// ✅ Start session
session_start();

// Check if role is not set OR role is not 'manager'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "manager") {
    // Redirect unauthenticated user
    header("Location: login.html");
    exit();
}
// If the user IS a manager, the script continues to render the HTML.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>

    <link rel="stylesheet" href="css/dashboard_agent.css">
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Manager specifics tailored to override agent defaults -->
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
                            <a href="donors.html">
                                <img src="Image/donations.png" class="icon" alt="Donors Icon">
                                <span class="text nav-text">Donors</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="locations.html">
                                <img src="Image/location.png" class="icon" alt="Locations Icon">
                                <span class="text nav-text">Locations</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="communication.html">
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

            <!-- Quick Actions Grid (Moved to top to match Agent Dashboard) -->
            <div class="quick-actions-grid">

                <a href="donors.html" class="big-btn">
                    <img src="Image/donations.png" class="big-btn-icon" alt="Donors Icon">
                    <h3>Manage Donors</h3>
                    <p>View, edit, and verify donor records.</p>
                </a>

                <a href="locations.html" class="big-btn">
                    <img src="Image/location.png" class="big-btn-icon" alt="Locations Icon">
                    <h3>Manage Locations</h3>
                    <p>Register and oversee CTS centers.</p>
                </a>

                <a href="communication.html" class="big-btn">
                    <img src="Image/message.png" class="big-btn-icon" alt="Communicate Icon">
                    <h3>Send Campaigns</h3>
                    <p>Communicate alerts and requests to specific donor groups.</p>
                </a>



            </div>

            <!-- Small Cards Row (Moved below Grid) -->
            <div class="small-cards-row">

                <div class="small-card card-donors">
                    <h4>Total Donors</h4>
                    <p>1,250</p>
                </div>

                <div class="small-card card-locations">
                    <h4>CTS Centers Registered</h4>
                    <p>12</p>
                </div>

                <div class="small-card card-messages">
                    <h4>Pending Messages</h4>
                    <p>4</p>
                </div>

            </div>

        </div>

    </div>

    <script src="script.js"></script>

</body>

</html>