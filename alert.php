<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "agent") {
    header("Location: login.html");
    exit();
}

$message = "";

// Ensure alert_type column exists (Temporary auto-migration)
$check_col = $conn->query("SHOW COLUMNS FROM alerts LIKE 'alert_type'");
if ($check_col->num_rows == 0) {
    $conn->query("ALTER TABLE alerts ADD COLUMN alert_type ENUM('disease', 'stock') DEFAULT 'disease'");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alert_type = $_POST['alert_type'];
    $agent_id = $_SESSION['user_id'];
    $date = date('Y-m-d'); // Default to today

    if ($alert_type === 'stock') {
        $blood_type = $_POST['blood_type'];
        $disease = "Low Stock: " . $blood_type;
        $donor_name = "System"; // Placeholder for stock alerts
        $appointment_date = $date;
    } else {
        $donor_name = $_POST['donor_name'];
        $disease = $_POST['disease'];
        $appointment_date = $_POST['date'];
    }

    $stmt = $conn->prepare("INSERT INTO alerts (donor_name, disease_detected, appointment_date, agent_id, alert_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $donor_name, $disease, $appointment_date, $agent_id, $alert_type);
    
    if ($stmt->execute()) {
        $message = "Alert sent successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Send Alert</title>
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
                            <a href="universal_donors.php">
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
                            <a href="alert.php" class="active">
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

            <h1 class="gradient-text">Send Alert</h1>

             <?php if ($message): ?>
                <div style="background: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-card">
                <form method="POST" action="alert.php">
                    <label>Alert Type</label>
                    <select name="alert_type" id="alert_type" onchange="toggleFields()" required>
                        <option value="disease">Disease Detection</option>
                        <option value="stock">Low Blood Stock</option>
                    </select>

                    <div id="disease_fields">
                        <label>Donor Name</label>
                        <input type="text" name="donor_name" placeholder="Enter full name">

                        <label>Disease Detected</label>
                        <input type="text" name="disease" placeholder="Enter disease">

                        <label>Appointment Date</label>
                        <input type="date" name="date">
                    </div>

                    <div id="stock_fields" style="display: none;">
                        <label>Blood Type Low</label>
                        <select name="blood_type">
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>

                    <button class="submit-btn" style="margin-top: 15px;">Send Alert</button>
                </form>
            </div>

        </div>

    </div>
    <script src="script.js"></script>
    <script>
        function toggleFields() {
            const type = document.getElementById('alert_type').value;
            const diseaseFields = document.getElementById('disease_fields');
            const stockFields = document.getElementById('stock_fields');
            
            if (type === 'stock') {
                diseaseFields.style.display = 'none';
                stockFields.style.display = 'block';
                
                // Remove required from disease fields to verify form is valid
                document.getElementsByName('donor_name')[0].required = false;
                document.getElementsByName('disease')[0].required = false;
                document.getElementsByName('date')[0].required = false;
                document.getElementsByName('blood_type')[0].required = true;
            } else {
                diseaseFields.style.display = 'block';
                stockFields.style.display = 'none';

                document.getElementsByName('donor_name')[0].required = true;
                document.getElementsByName('disease')[0].required = true;
                document.getElementsByName('date')[0].required = true;
                document.getElementsByName('blood_type')[0].required = false;
            }
        }
        // Init
        toggleFields();
    </script>
</body>

</html>
