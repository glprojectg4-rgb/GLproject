<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "agent") {
    header("Location: login.html");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add Donation
    if (isset($_POST['add_donation'])) {
        $donor_name = $_POST['donor_name'];
        $donation_type = strtolower($_POST['donation_type']);
        $recipient_name = !empty($_POST['recipient_name']) ? $_POST['recipient_name'] : NULL;
        $recipient_dob = !empty($_POST['recipient_dob']) ? $_POST['recipient_dob'] : NULL;
        $recipient_chu = !empty($_POST['recipient_chu']) ? $_POST['recipient_chu'] : NULL;
        $agent_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO donations (donor_name, donation_type, recipient_name, recipient_dob, recipient_chu, agent_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $donor_name, $donation_type, $recipient_name, $recipient_dob, $recipient_chu, $agent_id);
        
        if ($stmt->execute()) {
            $message = "Donation recorded successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

    // Delete Donation
    if (isset($_POST['delete_donation'])) {
        $id = $_POST['donation_id'];
        $stmt = $conn->prepare("DELETE FROM donations WHERE id_donations = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Donation deleted successfully.";
        } else {
            $message = "Error deleting donation.";
        }
    }
}

$donations = $conn->query("SELECT * FROM donations ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Donations</title>
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
                            <a href="donations.php" class="active">
                                <img src="Image/donations.png" class="icon" alt="Donations Icon">
                                <span class="text nav-text">Donations</span>
                            </a>
                        </li>

                         <li class="nav-link">
                            <a href="universal_donors.php">
                                <img src="Image/univ.png" class="icon">
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

            <h1 class="gradient-text">Manage Donations</h1>

             <?php if ($message): ?>
                <div style="background: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="form-card">
                <form method="POST" action="donations.php">
                    <input type="hidden" name="add_donation" value="1">
                    <label>Donor Full Name</label>
                    <input type="text" name="donor_name" placeholder="Enter donor name" required>

                    <label>Donation Type</label>
                    <select name="donation_type" id="donation_type" required onchange="toggleRecipient()">
                        <option value="universal">Universal</option>
                        <option value="targeted">Targeted Donation</option>
                    </select>

                    <label>Quantity (ml)</label>
                    <input type="number" name="quantity" placeholder="Example: 450" required> <!-- Field not in DB, but good for form -->

                    <label>Recipient Full Name (For Targeted)</label>
                    <input type="text" name="recipient_name" id="recipient_name" placeholder="Optional">

                    <label>Recipient Date of Birth</label>
                    <input type="date" name="recipient_dob">

                    <label>Hospital Department (CHU)</label>
                    <input type="text" name="recipient_chu" placeholder="Enter department">

                    <button class="submit-btn">Save Donation</button>
                </form>
            </div>

             <div class="table-card">
                <h3>Recent Donations</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Donor</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $donations->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['donor_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['donation_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this donation?');">
                                    <input type="hidden" name="donation_id" value="<?php echo $row['id_donations']; ?>">
                                    <input type="hidden" name="delete_donation" value="1">
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
    </div>
    <script src="script.js"></script>
    <script>
        function toggleRecipient() {
            const type = document.getElementById('donation_type').value;
            const recipientInput = document.getElementById('recipient_name');
            
            if (type === 'targeted') {
                recipientInput.required = true;
                recipientInput.placeholder = "Required for Targeted Donation";
            } else {
                recipientInput.required = false;
                recipientInput.placeholder = "Optional";
            }
        }
        // Init
        toggleRecipient();
    </script>
</body>

</html>
