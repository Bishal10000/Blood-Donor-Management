<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
if ($_SESSION['user_type'] !== 'admin') {
    die("Access Denied: You do not have permission to view this page.");
}

$user_id = $_SESSION['user_id'];



include('navbar3.php');
include('conn.php');  
$query = "SELECT COUNT(*) AS total_users FROM users";
$result = mysqli_query($conn, $query);
$total_users = mysqli_fetch_assoc($result)['total_users'];

$query = "SELECT COUNT(*) AS total_donations FROM donors";
$result = mysqli_query($conn, $query);
$total_donations = mysqli_fetch_assoc($result)['total_donations'];

// $query = "SELECT SUM(available_units) AS total_blood FROM blood_availability";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
<div class="dashboard">
    <h2 class="dashboard-title">Dashboard Overview</h2>
    <div class="dashboard-grid">
        <div class="card red">
            <h3>Total Registered Users</h3>
            <p><?php echo $total_users; ?></p>
        </div>
        <div class="card blue">
            <h3>Total Donations Made</h3>
            <p><?php echo $total_donations; ?></p>
        </div>
        <div class="card yellow">
            <h3>Total Blood Requests</h3>
            <p>6</p>  
        </div>
        
    </div>
</div>

</body>
</html>
