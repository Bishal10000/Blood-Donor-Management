<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user_type'] !== 'donor' && $_SESSION['user_type'] !== 'receiver') {
    die("Access Denied: Only donors or receivers can access this page.");
}

$user_id = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style/user.css">
    <link rel="stylesheet" href="style/dasboardstyle.css">

</head>
<body>
<header>
    <div class="logo">
        <a href="user_dashboard.php" style="text-decoration: none; color: inherit;">User Dashboard</a>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="why_bdms.php">Why BDMS</a></li>
            
    
            <li class="dropdown">
            <a href="#">Looking For Blood</a>
                <div class="dropdown-content">
                    <a href="register.php">User Register</a>
                    <a href="blood_availability.php">Blood Availability</a>
                </div>
            </li>

            <li><a href="our_achievements.php">Our Achievements</a></li>

        </ul>
    </nav>
    <div class="buttons">
        <a href="logout.php" class="btn">Logout</a>
    </div>
</header>



    <div class="dashboard-container">
        <!-- Header Section -->
        <header class="dashboard-header">
            <h1>Welcome to Dashboard</h1>
            <p>Manage your blood donation and requests effortlessly.</p>
        </header>

        <!-- Main Section -->
        <main class="dashboard-main">
            <!-- Donor Section -->
            <section class="donor-section">
                <h2>Donate Blood</h2>
                <p>Your donation can save lives. Join the cause today!</p>
                <a href="donate_blood.php" class="action-btn donate-btn" role="button" aria-label="Donate blood now">
                    Donate Blood
                </a>
            </section>

            <!-- Receiver Section -->
            <section class="receiver-section">
                <h2>Need Blood?</h2>
                <p>Facing an emergency? Request blood from verified donors.</p>
                <a href="request_blood.php" class="action-btn request-btn" role="button" aria-label="Request blood now">
                    Request Blood
                </a>
            </section>
        </main>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2025 Blood Donor Management  (BDM). All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
