<?php
session_start();
require_once 'db_connection.php';

// Ensure donation_sites table exists
$conn->query("CREATE TABLE IF NOT EXISTS donation_sites (
    id_donation_sites INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "manager") {
    header("Location: login.html");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add CTS Center
    if (isset($_POST['add_cts'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $manager_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO cts_centers (name, address, phone, manager_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $address, $phone, $manager_id);
        
        if ($stmt->execute()) {
            $message = "CTS Center added successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

   
    if (isset($_POST['delete_cts'])) {
        $id = $_POST['cts_id'];
        $stmt = $conn->prepare("DELETE FROM cts_centers WHERE id_cts_centers = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "CTS Center deleted successfully.";
        } else {
            $message = "Error deleting center.";
        }
    }

    
    if (isset($_POST['add_site'])) {
        $name = $_POST['site_name'];
        $address = $_POST['site_address'];
        $phone = $_POST['site_phone'];
        
        $stmt = $conn->prepare("INSERT INTO donation_sites (name, address, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $address, $phone);
        
        if ($stmt->execute()) {
            $message = "Donation site added successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

    
    if (isset($_POST['delete_site'])) {
        $id = $_POST['site_id'];
        $stmt = $conn->prepare("DELETE FROM donation_sites WHERE id_donation_sites = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Donation site deleted successfully.";
        } else {
            $message = "Error deleting site.";
        }
    }
}

$cts_centers = $conn->query("SELECT * FROM cts_centers ORDER BY created_at DESC");
$donation_sites = $conn->query("SELECT * FROM donation_sites ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Locations</title>

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
                        <a href="dashboard_manager.php">
                            <img src="Image/home.png" class="icon">
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="donors.php">
                            <img src="Image/donations.png" class="icon">
                            <span class="text nav-text">Donors</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="locations.php" class="active">
                            <img src="Image/location.png" class="icon">
                            <span class="text nav-text">Locations</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="communication.php">
                            <img src="Image/message.png" class="icon">
                            <span class="text nav-text">Communicate</span>
                        </a>
                    </li>

                </ul>

                <div class="bottom-content">
                    <li class="mode">
                        <div class="sun-moon">
                            <img src="Image/dark.png" class="icon moon">
                            <img src="Image/light.png" class="icon sun">
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
            <h1 class="gradient-text">Locations Management</h1>

            <?php if ($message): ?>
                <div style="background: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- CTS Centers Section -->
            <h2 class="section-title">CTS Centers</h2>

            <div class="form-card">
                <h3>Add CTS Center</h3>
                <form method="POST" action="locations.php">
                    <input type="hidden" name="add_cts" value="1">
                    <label>Center Name</label>
                    <input type="text" name="name" required>

                    <label>Address</label>
                    <input type="text" name="address" required>

                    <label>Phone</label>
                    <input type="text" name="phone" required>

                    <button class="submit-btn">Add CTS Center</button>
                </form>
            </div>

            <div class="table-card">
                <h3>CTS Centers List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $cts_centers->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this center?');">
                                    <input type="hidden" name="cts_id" value="<?php echo $row['id_cts_centers']; ?>">
                                    <input type="hidden" name="delete_cts" value="1">
                                    <button class="btn-action btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

           
            <h2 class="section-title" style="margin-top: 40px;">Donation Sites</h2>

            <div class="form-card">
                <h3>Add Donation Site</h3>
                <form method="POST" action="locations.php">
                    <input type="hidden" name="add_site" value="1">
                    <label>Site Name</label>
                    <input type="text" name="site_name" required>

                    <label>Address</label>
                    <input type="text" name="site_address" required>

                    <label>Phone</label>
                    <input type="text" name="site_phone" required>

                    <button class="submit-btn">Add Donation Site</button>
                </form>
            </div>

            <div class="table-card">
                <h3>Donation Sites List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $donation_sites->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this site?');">
                                    <input type="hidden" name="site_id" value="<?php echo $row['id_donation_sites']; ?>">
                                    <input type="hidden" name="delete_site" value="1">
                                    <button class="btn-action btn-delete">Delete</button>
                                </form>
                            </td>
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
