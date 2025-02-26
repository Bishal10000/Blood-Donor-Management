<?php
// Database configuration
include 'conn.php';
// Get and sanitize donor ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Check if ID is valid
if ($id > 0) {
    // Update status to "approved"
    $sql = "UPDATE blood_requests SET status = 'approved' WHERE id = $id";
    $conn->query($sql);
}

// Redirect back to donations page
header("Location: request.php");
exit();

$conn->close();
?>
