
<?php
session_start();
require('conn.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user ID
$sql = "SELECT * FROM register WHERE id = $user_id";  // Get the user's details from the register table
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $lastActionDate = $user['last_action_date'];  // Get the last receiving date
    $currentDate = date("Y-m-d");

    // Check if the user has a recorded last action date
    if ($lastActionDate) {
        // Calculate the number of days since the last action
        $daysSinceLastAction = (strtotime($currentDate) - strtotime($lastActionDate)) / (60 * 60 * 24);

        // If less than 90 days, restrict access to the dashboard
        if ($daysSinceLastAction < 90) {
            $remainingDays = 90 - $daysSinceLastAction;
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Access Restricted',
                    text: 'You need to wait $remainingDays more day(s) before receiving blood.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'login.html';  // Redirect to login page after alert
                });
            </script>";
            exit();  // Prevent the dashboard from loading
        }
    }
} else {
    echo "User not found.";
    exit();
}

// Fetch blood stock data
$sql = "SELECT blood_type, quantity FROM blood_stock";
$result = $conn->query($sql);

// Check if query failed
if (!$result) {
    die("Query failed: " . $conn->error);
}

$blood_stock = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $blood_stock[$row['blood_type']] = $row['quantity'];
    }
} else {
    echo "No blood stock data found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiver Dashboard - Blood Bank</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Receiver Dashboard</h2>
        <ul>
            <li><a href="receiver_dashboard.php">Home</a></li>
            <li><a href="blood_request.php">Blood Requests</a></li>
            <li><a href="request_history.php">Request History</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header / Title -->
        <div class="header">
            <h1>Welcome to Blood Bank</h1>
        </div>

         <!-- Blood Stock Summary -->
    <div class="blood-summary" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
    <?php foreach($blood_stock as $type => $count): ?>
    <div class="blood-type" style="background-color: #ecf0f1; border-radius: 8px; padding: 40px; flex: 1; min-width: 200px; max-width: 30%; height: 150px; text-align: center; transition: background-color 0.3s;">
        <h3 style="color: #e74c3c; font-size: 36px; margin-bottom: 10px;"><?php echo htmlspecialchars($type); ?> <span style="font-size: 36px;">🩸</span></h3> <!-- Blood drop -->
        <p style="font-size: 24px; color: #2c3e50;"><?php echo htmlspecialchars($count); ?> Units</p>
    </div>
    <?php endforeach; ?>
</div>

       
    </div>
</body>
</html>
