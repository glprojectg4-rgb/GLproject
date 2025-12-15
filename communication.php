<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "manager") {
    header("Location: login.html");
    exit();
}

$message = "";

// Create messages table if it doesn't exist
$conn->query("CREATE TABLE IF NOT EXISTS messages (
    id_messages INT AUTO_INCREMENT PRIMARY KEY,
    recipient_type ENUM('donor', 'partner', 'association', 'cts_center') NOT NULL,
    recipient_id INT,
    recipient_name VARCHAR(100),
    subject VARCHAR(200) NOT NULL,
    message_body TEXT NOT NULL,
    manager_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add Partner
    if (isset($_POST['add_partner'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $manager_id = $_SESSION['user_id'];
        
        $stmt = $conn->prepare("INSERT INTO partners (name_partners, contact_email_partners, phone_partners, manager_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $phone, $manager_id);
        if ($stmt->execute()) {
            $message = "Partner added successfully.";
        }
    }

    // Add Association
    if (isset($_POST['add_association'])) {
        $name = $_POST['name'];
        $contact = $_POST['contact_person'];
        $phone = $_POST['phone'];
        $manager_id = $_SESSION['user_id'];
        
        $stmt = $conn->prepare("INSERT INTO associations (name, contact_person, phone, manager_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $contact, $phone, $manager_id);
        if ($stmt->execute()) {
            $message = "Association added successfully.";
        }
    }

    // Send Message
    if (isset($_POST['send_message'])) {
        $recipient_type = $_POST['recipient_type'];
        $recipient_id = $_POST['recipient_id'] ?? null;
        $recipient_name = $_POST['recipient_name'];
        $subject = $_POST['subject'];
        $message_body = $_POST['message_body'];
        $manager_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO messages (recipient_type, recipient_id, recipient_name, subject, message_body, manager_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssi", $recipient_type, $recipient_id, $recipient_name, $subject, $message_body, $manager_id);
        
        if ($stmt->execute()) {
            $message = "Message sent successfully to " . htmlspecialchars($recipient_name) . "!";
        } else {
            $message = "Error sending message.";
        }
    }

    // Delete Partner
    if (isset($_POST['delete_partner'])) {
        $id = $_POST['partner_id'];
        $stmt = $conn->prepare("DELETE FROM partners WHERE id_partners = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Partner deleted successfully.";
        } else {
            $message = "Error deleting partner.";
        }
    }

    // Delete Association
    if (isset($_POST['delete_association'])) {
        $id = $_POST['assoc_id'];
        $stmt = $conn->prepare("DELETE FROM associations WHERE id_associations = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Association deleted successfully.";
        } else {
            $message = "Error deleting association.";
        }
    }
}

$partners = $conn->query("SELECT * FROM partners ORDER BY created_at DESC");
$associations = $conn->query("SELECT * FROM associations ORDER BY created_at DESC");
$donors = $conn->query("SELECT id_donors, full_name, phone FROM donors ORDER BY full_name ASC");
$cts_centers = $conn->query("SELECT id_cts_centers, name, phone FROM cts_centers ORDER BY name ASC");
$recent_messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Communication & Partners</title>

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
                        <a href="locations.php">
                            <img src="Image/location.png" class="icon">
                            <span class="text nav-text">Locations</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="communication.php" class="active">
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
            <h1 class="gradient-text">Communication Center</h1>
            
            <?php if ($message): ?>
                <div style="background: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Send Message Section -->
            <h2 class="section-title">Send Message</h2>
            <div class="form-card">
                <h3>Compose Message</h3>
                <form method="POST" action="communication.php">
                    <input type="hidden" name="send_message" value="1">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label>Recipient Type</label>
                            <select name="recipient_type" id="recipient_type" onchange="updateRecipients()" required>
                                <option value="">Select Type</option>
                                <option value="donor">Donor</option>
                                <option value="partner">Partner</option>
                                <option value="association">Association</option>
                                <option value="cts_center">CTS Center</option>
                            </select>
                        </div>

                        <div>
                            <label>Recipient</label>
                            <select name="recipient_name" id="recipient_select" required>
                                <option value="">Select recipient type first</option>
                            </select>
                            <input type="hidden" name="recipient_id" id="recipient_id">
                        </div>
                    </div>

                    <label>Subject</label>
                    <input type="text" name="subject" placeholder="Message subject" required>

                    <label>Message</label>
                    <textarea name="message_body" rows="8" placeholder=" " required style="width: 100%; resize: vertical;"></textarea>

                    <button class="submit-btn" style="width: 100%; margin-top: 10px;">Send Message</button>
                </form>
            </div>

            <!-- Recent Messages -->
            <div class="table-card" style="margin-top: 30px;">
                <h3>Recent Messages</h3>
                <table>
                    <thead>
                        <tr>
                            <th>To</th>
                            <th>Type</th>
                            <th>Subject</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $recent_messages->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['recipient_name']); ?></td>
                            <td><?php echo ucfirst($row['recipient_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td><?php echo date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Partners Section -->
            <h2 class="section-title" style="margin-top: 40px;">Manage Partners</h2>
            <div class="form-card">
                <h3>Add Partner</h3>
                <form method="POST" action="communication.php">
                    <input type="hidden" name="add_partner" value="1">
                    <label>Partner Name</label>
                    <input type="text" name="name" required>
                    <label>Email</label>
                    <input type="email" name="email" required>
                    <label>Phone</label>
                    <input type="text" name="phone" required>
                    <button class="submit-btn">Add Partner</button>
                </form>
            </div>

            <div class="table-card">
                <h3>Partners List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $partners->data_seek(0); // Reset pointer
                        while($row = $partners->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name_partners']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_email_partners']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_partners']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this partner?');">
                                    <input type="hidden" name="partner_id" value="<?php echo $row['id_partners']; ?>">
                                    <input type="hidden" name="delete_partner" value="1">
                                    <button class="btn-action btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Associations Section -->
            <h2 class="section-title" style="margin-top: 40px;">Manage Associations</h2>
            <div class="form-card">
                <h3>Add Association</h3>
                <form method="POST" action="communication.php">
                    <input type="hidden" name="add_association" value="1">
                    <label>Association Name</label>
                    <input type="text" name="name" required>
                    <label>Contact Person</label>
                    <input type="text" name="contact_person" required>
                    <label>Phone</label>
                    <input type="text" name="phone" required>
                    <button class="submit-btn">Add Association</button>
                </form>
            </div>

            <div class="table-card">
                <h3>Associations List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $associations->data_seek(0); // Reset pointer
                        while($row = $associations->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_person']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this association?');">
                                    <input type="hidden" name="assoc_id" value="<?php echo $row['id_associations']; ?>">
                                    <input type="hidden" name="delete_association" value="1">
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
    <script>
        // Store recipient data
        const recipients = {
            donor: <?php 
                $donors->data_seek(0);
                $donor_arr = [];
                while($d = $donors->fetch_assoc()) {
                    $donor_arr[] = ['id' => $d['id_donors'], 'name' => $d['full_name']];
                }
                echo json_encode($donor_arr);
            ?>,
            partner: <?php 
                $partners->data_seek(0);
                $partner_arr = [];
                while($p = $partners->fetch_assoc()) {
                    $partner_arr[] = ['id' => $p['id_partners'], 'name' => $p['name_partners']];
                }
                echo json_encode($partner_arr);
            ?>,
            association: <?php 
                $associations->data_seek(0);
                $assoc_arr = [];
                while($a = $associations->fetch_assoc()) {
                    $assoc_arr[] = ['id' => $a['id_associations'], 'name' => $a['name']];
                }
                echo json_encode($assoc_arr);
            ?>,
            cts_center: <?php 
                $cts_centers->data_seek(0);
                $cts_arr = [];
                while($c = $cts_centers->fetch_assoc()) {
                    $cts_arr[] = ['id' => $c['id_cts_centers'], 'name' => $c['name']];
                }
                echo json_encode($cts_arr);
            ?>
        };

        function updateRecipients() {
            const type = document.getElementById('recipient_type').value;
            const select = document.getElementById('recipient_select');
            const idInput = document.getElementById('recipient_id');
            
            select.innerHTML = '<option value="">Select recipient</option>';
            
            if (type && recipients[type]) {
                recipients[type].forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.name;
                    option.textContent = item.name;
                    option.dataset.id = item.id;
                    select.appendChild(option);
                });
            }

            select.onchange = function() {
                const selectedOption = this.options[this.selectedIndex];
                idInput.value = selectedOption.dataset.id || '';
            };
        }
    </script>
</body>

</html>
