<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "manager") {
    header("Location: login.html");
    exit();
}

$message = "";

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add Donor
    if (isset($_POST['add_donor'])) {
        $full_name = $_POST['full_name'];
        $dob = $_POST['dob'];
        $blood = $_POST['blood_type'];
        $rh = substr($blood, -1);
        $bt = substr($blood, 0, -1);
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $donation_type = 'blood';

        $stmt = $conn->prepare("INSERT INTO donors (full_name, date_of_birth, blood_type, rhesus_factor, address, phone, donation_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $full_name, $dob, $bt, $rh, $address, $phone, $donation_type);
        
        if ($stmt->execute()) {
            $message = "Donor added successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }

    // Edit Donor
    if (isset($_POST['edit_donor'])) {
        $id = $_POST['donor_id'];
        $full_name = $_POST['full_name'];
        $dob = $_POST['dob'];
        $blood = $_POST['blood_type'];
        $rh = substr($blood, -1);
        $bt = substr($blood, 0, -1);
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        $stmt = $conn->prepare("UPDATE donors SET full_name=?, date_of_birth=?, blood_type=?, rhesus_factor=?, address=?, phone=? WHERE id_donors=?");
        $stmt->bind_param("ssssssi", $full_name, $dob, $bt, $rh, $address, $phone, $id);
        
        if ($stmt->execute()) {
            $message = "Donor updated successfully.";
        } else {
            $message = "Error updating donor.";
        }
    }

    // Delete Donor
    if (isset($_POST['delete_donor'])) {
        $id = $_POST['donor_id'];
        $stmt = $conn->prepare("DELETE FROM donors WHERE id_donors = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Donor deleted successfully.";
        } else {
             $message = "Error deleting donor.";
        }
    }
}

// Handle Search
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $search_param = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM donors WHERE full_name LIKE ? OR phone LIKE ? OR CONCAT(blood_type, rhesus_factor) LIKE ? ORDER BY created_at DESC");
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt->execute();
    $donors = $stmt->get_result();
} else {
    $donors = $conn->query("SELECT * FROM donors ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Donors</title>

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
                        <a href="donors.php" class="active">
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
                        <a href="communication.php">
                            <img src="Image/message.png" class="icon">
                            <span class="text nav-text">Communicate</span>
                        </a>
                    </li>
                </ul>
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
            <h1>Manage Donors</h1>

            <?php if ($message): ?>
                <div style="background: #e3f2fd; color: #0d47a1; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Search Form -->
            <div class="form-card" style="margin-bottom: 20px;">
                <h3>Search Donors</h3>
                <form method="GET" action="donors.php">
                    <label>Search by Name, Phone, or Blood Type</label>
                    <div style="display: flex; gap: 10px; align-items: flex-end;">
                        <div style="flex: 1;">
                            <input type="text" name="search" placeholder="Enter search term..." value="<?php echo htmlspecialchars($search); ?>" style="width: 100%; margin: 0;">
                        </div>
                        <button class="submit-btn" type="submit" style="margin: 0; white-space: nowrap;">Search</button>
                        <?php if ($search): ?>
                            <a href="donors.php" class="submit-btn" style="background: #666; text-decoration: none; display: inline-block; padding: 10px 20px; margin: 0; white-space: nowrap;">Clear</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Add Donor Form -->
            <div class="form-card">
                <h3>Add Donor</h3>
                <form method="POST" action="donors.php">
                    <input type="hidden" name="add_donor" value="1">
                    
                    <label>Full Name</label>
                    <input type="text" name="full_name" placeholder="Donor Name" required>

                    <label>Date of Birth</label>
                    <input type="date" name="dob" required>

                    <label>Blood Type</label>
                    <select name="blood_type" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>

                    <label>Address</label>
                    <input type="text" name="address" placeholder="Address" required>

                    <label>Phone</label>
                    <input type="text" name="phone" placeholder="Phone Number" required>

                    <button class="submit-btn">Add Donor</button>
                </form>
            </div>

            <!-- Donors List -->
            <div class="table-card">
                <h3>Donors List <?php if ($search) echo "- Search Results"; ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>Blood</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $donors->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                            <td><?php echo htmlspecialchars($row['blood_type'] . $row['rhesus_factor']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td>
                                <button class="btn-action" style="background:#007bff; margin-right:5px;" onclick="editDonor(<?php echo $row['id_donors']; ?>, '<?php echo htmlspecialchars($row['full_name'], ENT_QUOTES); ?>', '<?php echo $row['date_of_birth']; ?>', '<?php echo $row['blood_type'] . $row['rhesus_factor']; ?>', '<?php echo htmlspecialchars($row['address'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['phone'], ENT_QUOTES); ?>')">Edit</button>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this donor?');">
                                    <input type="hidden" name="donor_id" value="<?php echo $row['id_donors']; ?>">
                                    <input type="hidden" name="delete_donor" value="1">
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

    <!-- Edit Modal -->
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:var(--body-color); margin:auto; padding:0; max-width:600px; border-radius:15px; max-height:90vh; overflow-y:auto; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding:25px; border-radius:15px 15px 0 0;">
                <h2 style="margin:0; color:white; font-size:24px;">Edit Donor</h2>
            </div>
            <form method="POST" action="donors.php" style="padding:30px;">
                <input type="hidden" name="edit_donor" value="1">
                <input type="hidden" name="donor_id" id="edit_id">
                
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text-color);">Full Name</label>
                        <input type="text" name="full_name" id="edit_name" required style="width:100%; padding:12px; border:2px solid var(--border-color); border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text-color);">Date of Birth</label>
                        <input type="date" name="dob" id="edit_dob" required style="width:100%; padding:12px; border:2px solid var(--border-color); border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text-color);">Blood Type</label>
                        <select name="blood_type" id="edit_blood" required style="width:100%; padding:12px; border:2px solid var(--border-color); border-radius:8px; font-size:14px;">
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text-color);">Phone</label>
                        <input type="text" name="phone" id="edit_phone" required style="width:100%; padding:12px; border:2px solid var(--border-color); border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div style="margin-bottom:25px;">
                    <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text-color);">Address</label>
                    <input type="text" name="address" id="edit_address" required style="width:100%; padding:12px; border:2px solid var(--border-color); border-radius:8px; font-size:14px;">
                </div>

                <div style="display:flex; gap:15px; margin-top:30px;">
                    <button type="submit" style="flex:1; padding:14px; background:#dc3545; color:white; border:none; border-radius:8px; cursor:pointer; font-size:16px; font-weight:600; transition:0.3s;">Update Donor</button>
                    <button type="button" onclick="closeEditModal()" style="flex:1; padding:14px; background:#6c757d; color:white; border:none; border-radius:8px; cursor:pointer; font-size:16px; font-weight:600; transition:0.3s;" onmouseover="this.style.background='#5a6268'" onmouseout="this.style.background='#6c757d'">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        function editDonor(id, name, dob, blood, address, phone) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_dob').value = dob;
            document.getElementById('edit_blood').value = blood;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('editModal').style.display = 'block';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
    </script>
</body>

</html>
