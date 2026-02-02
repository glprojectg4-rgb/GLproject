<?php
require_once 'db_connection.php';

// Add alert_type column if it doesn't exist
$sql = "ALTER TABLE alerts ADD COLUMN alert_type ENUM('disease', 'stock') DEFAULT 'disease'";
if ($conn->query($sql) === TRUE) {
    echo "Column alert_type added successfully";
} else {
    echo "Error adding column: " . $conn->error;
}
?>
