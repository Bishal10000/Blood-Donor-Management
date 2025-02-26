<?php
session_start();
require('../includes/conn.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'donor') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donor_id = $_SESSION['user_id'];
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];

    // Update donor status
    $stmt = $conn->prepare("UPDATE donors 
                           SET last_donation_date = NOW(), 
                               donation_count = donation_count + 1,
                               is_active = 0 
                           WHERE id = ?");
    $stmt->bind_param("i", $donor_id);
    $stmt->execute();

    // Update blood stock
    $stmt = $conn->prepare("INSERT INTO blood_stock 
                           (blood_group, quantity, donor_id) 
                           VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $blood_group, $quantity, $donor_id);
    $stmt->execute();

    header("Location: donor_dashboard.php?success=1");
    exit();
}
?>

<!-- Donation Form HTML -->