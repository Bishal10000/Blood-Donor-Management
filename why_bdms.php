<?php
// Include the database connection file
include 'conn.php';
include 'navbar2.php';

// Fetch total registrations
$result = $conn->query("SELECT COUNT(*) AS total FROM users");
$totalRegistrations = $result->fetch_assoc()['total'];

// Fetch total blood donations
$result = $conn->query("SELECT COUNT(*) AS total FROM donors");
$totalDonations = $result->fetch_assoc()['total'];

 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Why BDMS</title>
    <link rel="stylesheet" href="style/why.css">
</head>
<body>
    <!-- Header
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1>BDMS</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="why_bdms.php">Why BDMS</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="buttons">
                <a href="donate.php" class="btn">Donate Blood</a>
                <a href="request.php" class="btn">Request Blood</a>
            </div>
        </div>
    </header> -->

    <!-- Main Section -->
    <section class="main-section">
        <div class="container">
            <h1>Why BDMS?</h1>
            <p>In developing countries like Nepal, families often face the burden of managing blood supplies during emergencies. The Blood Donor Management System (BDMS) aims to simplify the process of donating and receiving blood by digitizing and automating blood bank operations.</p>
            <p>Our mission is to create a transparent, efficient, and accessible system to ensure no life is lost due to a lack of blood.</p>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <h2>Our Impact</h2>
            <div class="stats">
                <div class="stat">
                    <h3>Total Registrations</h3>
                    <p><?php echo $totalRegistrations; ?></p>
                </div>
                <div class="stat">
                    <h3>Blood Donations</h3>
                    <p><?php echo $totalDonations; ?></p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Blood Donor Management System (BDMS). All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
