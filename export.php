<?php
// export.php - Handle CSV Exports
session_start();
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['role'])) {
    die("Access denied");
}

if (isset($_GET['export'])) {
    $type = $_GET['export'];
    $filename = $type . "_" . date('Y-m-d') . ".csv";

    // Header settings for download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');

    // Define columns and query based on export type
    if ($type === 'donors') {
        fputcsv($output, array('ID', 'Full Name', 'DOB', 'Blood Type', 'Rhesus', 'Address', 'Phone', 'Created At'));
        $query = "SELECT id_donors, full_name, date_of_birth, blood_type, rhesus_factor, address, phone, created_at FROM donors ORDER BY created_at DESC";
    } 
    elseif ($type === 'partners') {
        fputcsv($output, array('ID', 'Partner Name', 'Contact Email', 'Phone', 'Manager ID', 'Created At'));
        $query = "SELECT id_partners, name_partners, contact_email_partners, phone_partners, manager_id, created_at FROM partners ORDER BY created_at DESC";
    } 
    elseif ($type === 'associations') {
        fputcsv($output, array('ID', 'Association Name', 'Contact Person', 'Phone', 'Manager ID', 'Created At'));
        $query = "SELECT id_associations, name, contact_person, phone, manager_id, created_at FROM associations ORDER BY created_at DESC";
    } 
    else {
        die("Invalid export type");
    }

    // Execute query and loop data
    if (isset($query)) {
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }

    fclose($output);
    exit();
}
?>
