<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conn.php';
include 'navbar2.php';

// Fetch data from the database
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalDonationsQuery = "SELECT COUNT(*) AS total_donations FROM donors";
$totalRequestsQuery = "SELECT COUNT(*) AS total_requests FROM blood_requests";
$activeDonorsQuery = "SELECT COUNT(*) AS active_donors FROM donors";


$totalUsers = $conn->query($totalUsersQuery)->fetch_assoc()['total_users'] ?? "N/A";
$totalDonations = $conn->query($totalDonationsQuery)->fetch_assoc()['total_donations'] ?? "N/A";
$totalRequests = $conn->query($totalRequestsQuery)->fetch_assoc()['total_requests'] ?? "N/A";
$activeDonors = $conn->query($activeDonorsQuery)->fetch_assoc()['active_donors'] ?? "N/A";

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/dasboardstyle.css">
    <title>Blood Donation Stats</title>
</head>
<body>
    <!-- Stats Section -->
    <div class="stats-container">
        <div class="stat-box red">
            <div class="stat-header">Total Registered Users</div>
            <div class="stat-value"><?php echo $totalUsers ? $totalUsers : "N/A"; ?></div>
        </div>
        <div class="stat-box blue">
            <div class="stat-header">Total Donations Made</div>
            <div class="stat-value"><?php echo $totalDonations ? $totalDonations : "N/A"; ?></div>
        </div>
        <div class="stat-box yellow">
            <div class="stat-header">Total Blood Requests</div>
            <div class="stat-value"><?php echo $totalRequests ? $totalRequests : "N/A"; ?></div>
        </div>
        <div class="stat-box green">
            <div class="stat-header">Active Donors</div>
            <div class="stat-value"><?php echo $activeDonors ? $activeDonors : "N/A"; ?></div>
        </div>
    </div>

    <!-- Buttons Section -->
    <section class="buttons-container">
        <a href="blood_availability.php" class="button red">
            <i class="icon">💉</i> Blood Availability Search
        </a>
        <!-- <a href="blood-bank-directory.php" class="button blue">
            <i class="icon">🏥</i> Blood Bank Directory
        </a>
        <a href="donation-camps.php" class="button yellow">
            <i class="icon">📅</i> Blood Donation
        </a> -->
        <a href="register.php" class="button orange">
            <i class="icon">👤</i> User Register
        </a>
        <a href="login.php" class="button green">
            <i class="icon">👤</i> User Login
        </a>
    </section>

    <!-- Donate Section -->
    <section class="donate-section">
        <div class="donate-content">
            <img src="1.webp" alt="Donate Blood Image" class="donate-image">
            <div class="donate-text">
                <h2>Every Drop Counts</h2>
                <p>
                    Blood donation is a noble act that can save lives. By donating blood, you contribute to a healthier world. 
                    Take a step forward today and become a hero in someone's life.
                </p>
                <a href="register.php" class="donate-button">Donate Now</a>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="info-section">
        <h2>Learn About Donation</h2>
        <table class="donation-table" style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center; padding: 10px; background-color: red; font-size: 1.5em;">
                        Compatible Blood Type Donors
                    </th>
                </tr>
                <tr>
                    <th>Blood Type</th>
                    <th>Donate Blood To</th>
                    <th>Receive Blood From</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>A+</td>
                    <td>A+, AB+</td>
                    <td>A+, A-, O+, O-</td>
                </tr>
                <tr>
                    <td>O+</td>
                    <td>O+, A+, B+, AB+</td>
                    <td>O+, O-</td>
                </tr>
                <tr>
                    <td>B+</td>
                    <td>B+, AB+</td>
                    <td>B+, B-, O+, O-</td>
                </tr>
                <tr>
                    <td>AB+</td>
                    <td>AB+</td>
                    <td>Everyone</td>
                </tr>
                <tr>
                    <td>A-</td>
                    <td>A+, A-, AB+, AB-</td>
                    <td>A-, O-</td>
                </tr>
                <tr>
                    <td>O-</td>
                    <td>Everyone</td>
                    <td>O-</td>
                </tr>
                <tr>
                    <td>B-</td>
                    <td>B+, B-, AB+, AB-</td>
                    <td>B-, O-</td>
                </tr>
                <tr>
                    <td>AB-</td>
                    <td>AB+, AB-</td>
                    <td>AB-, A-, B-, O-</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>
</html>
<?php
include 'footer.php';
?>