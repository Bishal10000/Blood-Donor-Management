<?php
// File: donate_blood.php

// Database configuration
include 'conn.php';

// Assuming the donor is logged in and the donor ID is available
$donor_id = 1; // Replace this with actual session donor ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['donate'])) {
        $quantity = intval($_POST['quantity']);

        // Check if quantity is valid
        if ($quantity > 0) {
            // Insert new donation record into donations table
            $sql = "INSERT INTO donations (donor_id, blood_type, quantity, donation_date) 
                    SELECT id, blood_type, '$quantity', NOW() FROM donor WHERE id = $donor_id";
            if ($conn->query($sql) === TRUE) {
                
                // Update the last donation date in donor table
                $sql_update = "UPDATE donor SET last_donation_date = NOW() WHERE id = $donor_id";
                $conn->query($sql_update);

                // Redirect back to donor dashboard
                header("Location: donor_dashboard.php");
                exit();
            } else {
                echo "Error: Could not complete the donation. Please try again.";
            }
        } else {
            echo "Invalid donation quantity. Please enter a positive number.";
        }
    }
}

// Close the connection
$conn->close();
?>
