<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "agent") {
    header("Location: login.html");
    exit();
}

// Universal donors are those who made universal donations (not targeted to specific recipient)
$donors = $conn->query("SELECT DISTINCT donor_name, 
    (SELECT phone FROM donors WHERE full_name = donations.donor_name LIMIT 1) as phone,
    (SELECT address FROM donors WHERE full_name = donations.donor_name LIMIT 1) as address,
    (SELECT CONCAT(blood_type, rhesus_factor) FROM donors WHERE full_name = donations.donor_name LIMIT 1) as blood_type,
    COUNT(*) as donation_count
    FROM donations 
    WHERE donation_type = 'universal' 
    GROUP BY donor_name 
    ORDER BY donation_count DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Universal Donors</title>
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
                            <a href="donations.php">
                                <img src="Image/donations.png" class="icon" alt="Donations Icon">
                                <span class="text nav-text">Donations</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="universal_donors.php" class="active">
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
                            <a href="alert.php">
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

            <h1 class="gradient-text">Universal Donors</h1>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Donor Name</th>
                            <th>Blood Type</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Universal Donations</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while($row = $donors->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['donor_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['blood_type'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['address'] ?? 'N/A'); ?></td>
                            <td><strong><?php echo $row['donation_count']; ?></strong></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <script src="script.js"></script>
</body>

</html>
