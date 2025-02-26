<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

$user_id = $_SESSION['user_id'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('conn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $province = $conn->real_escape_string($_POST['province']);
    $district = $conn->real_escape_string($_POST['district']);

    // Insert data into donors table
    $sql = "INSERT INTO donors (user_id, name, phone, email, blood_group, province, district, last_donation_date, is_active) 
            VALUES ('$user_id', '$name', '$phone', '$email', '$blood_group', '$province', '$district', NULL, 1)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Donor registered successfully!'); window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration Form</title>
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
            <li >
                    <a href="blood_availability.php">Donor Availability</a>
            </li>
            <li><a href="our_achievements.php">Our Achievements</a></li>
            <li><a href="donor_notification.php">Notification</a></li>
        </ul>
    </nav>
    <div class="buttons">
        <a href="logout.php" class="btn">Logout</a>
    </div>
</header>


    <div class="form-container">
        <h2 class="form-header">Donor Registration Form</h2>
        <form id="donor-form" action="" method="POST">
            <!-- Full Name -->
            <label for="donor-name">Full Name:</label>
            <input type="text" id="donor-name" name="name" placeholder="Enter your full name" required>

            <!-- Phone -->
            <label for="donor-phone">Phone:</label>
            <input type="tel" id="donor-phone" name="phone" placeholder="Enter your phone number" required>

            <!-- Email -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address">

            <!-- Blood Group -->
            <label for="donor-blood-group">Blood Group:</label>
            <select id="donor-blood-group" name="blood_group" required>
                <option value="">Select Blood Group</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <!-- Province -->
            <label for="province">Province:</label>
            <select id="province" name="province" required>
                <option value="" disabled selected>Select a Province</option>
                <option value="Koshi">Koshi</option>
                <option value="Madesh">Madesh</option>
                <option value="Bagmati">Bagmati</option>
                <option value="Gandaki">Gandaki</option>
                <option value="Lumbini">Lumbini</option>
                <option value="Karnali">Karnali</option>
                <option value="Sudurpashchim">Sudurpashchim</option>
            </select>

            <!-- District -->
            <label for="district">District:</label>
            <input type="text" id="district" name="district" placeholder="Enter your district" required>

            <!-- Submit Button -->
            <button type="submit">Register as Donor</button>
        </form>
    </div>
</body>
</html>
<?php
include 'footer.php';
?>