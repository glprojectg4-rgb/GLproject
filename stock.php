<?php
include "db_connection.php";

$query = "
    SELECT CONCAT(blood_type, rhesus_factor) AS type, COUNT(*) AS total
    FROM donors
    GROUP BY type
";

$result = $conn->query($query);

$blood_stock = [];

while ($row = $result->fetch_assoc()) {
    $blood_stock[$row["type"]] = $row["total"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blood Stock</title>
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
                    <span class="image">
                        <img src="Image/user2.png" alt="User">
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
                            <a href="stock.php" class="active">
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

            <h1 class="gradient-text">Available Blood Donors</h1>

            <div class="blood-grid">

                <div class="blood-card">
                    <span class="blood-type">🩸 A+</span>
                    <span class="blood-count">(<?= $blood_stock['A+'] ?? 0 ?>)</span>
                </div>

                <div class="blood-card">
                    <span class="blood-type">🩸 A−</span>
                    <span class="blood-count">(<?= $blood_stock['A-'] ?? 0 ?>)</span>
                </div>

                <div class="blood-card">
                    <span class="blood-type">🩸 B+</span>
                    <span class="blood-count">(<?= $blood_stock['B+'] ?? 0 ?>)</span>
                </div>

                <div class="blood-card">
                    <span class="blood-type">🩸 B−</span>
                    <span class="blood-count">(<?= $blood_stock['B-'] ?? 0 ?>)</span>
                </div>

                <div class="blood-card">
                    <span class="blood-type">🩸 O+</span>
                    <span class="blood-count">(<?= $blood_stock['O+'] ?? 0 ?>)</span>

                </div>

                <div class="blood-card">
                    <span class="blood-type">🩸 O−</span>
                    <span class="blood-count">(<?= $blood_stock['O-'] ?? 0 ?>)</span>
                </div>

                <div class="blood-card">
                    <span class="blood-type">🩸 AB+</span>
                    <span class="blood-count">(<?= $blood_stock['AB+'] ?? 0 ?>)</span>
                </div>

                <div class="blood-card">
                    <span class="blood-type">🩸 AB−</span>
                    <span class="blood-count">(<?= $blood_stock['AB-'] ?? 0 ?>)</span>
                </div>
            </div>


        </div>

    </div>
    <script src="script.js"></script>
</body>

</html>
