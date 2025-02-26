<?php
// Database connection
include'conn.php';

// Get and sanitize donor ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Check if ID is valid
if ($id > 0) {
    // Update status to "approved"
    $sql = "UPDATE donate SET status = 'approved' WHERE id = $id";
    $conn->query($sql);
}

// Redirect back to donations page
header("Location: donations.php");
exit();

$conn->close();
?>
