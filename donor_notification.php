<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

include('navbar2.php');
include('conn.php');

// Verify the user is a donor and get donor_id
$donor_check = "SELECT id FROM donors WHERE user_id = $user_id";
$donor_result = mysqli_query($conn, $donor_check);
if (!$donor_result || mysqli_num_rows($donor_result) == 0) {
    die("You must be registered as a donor to access this page.");
}
$donor = mysqli_fetch_assoc($donor_result);
$donor_id = $donor['id'];

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Mark as read
    if (isset($_GET['mark_read'])) {
        $notification_id = intval($_GET['mark_read']);
        $updateQuery = "UPDATE donor_notifications SET status = 'read' 
                        WHERE id = $notification_id AND donor_id = $donor_id";
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: /Blood_Bank/donor_notification.php");
            exit();
        }
    }
    
    // Delete notification
    if (isset($_GET['delete'])) {
        $notification_id = intval($_GET['delete']);
        $deleteQuery = "DELETE FROM donor_notifications 
                       WHERE id = $notification_id AND donor_id = $donor_id";
        if (mysqli_query($conn, $deleteQuery)) {
            header("Location: /Blood_Bank/donor_notification.php");
            exit();
        }
    }
}

// Fetch notifications
$query = "SELECT * FROM donor_notifications 
         WHERE donor_id = $donor_id 
         ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching notifications: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Notifications - FundHive</title>
    <link rel="stylesheet" href="style/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .dashboard {
            max-width: 1200px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .dashboard-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead th {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            text-align: left;
        }
        tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: #555;
        }
        tr.unread {
            background-color: #e8f7e8;
            font-weight: bold;
        }
        tr.read {
            background-color: #f7f7f7;
        }
        .action-links {
            display: flex;
            gap: 15px;
        }
        .mark-read {
            color: #007bff;
            text-decoration: none;
        }
        .delete-button {
            color: #dc3545;
            text-decoration: none;
        }
        .no-notifications {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <h2 class="dashboard-title">Donor Notifications</h2>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert error">
            Error: <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="alert success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="<?php echo ($row['status'] == 'unread') ? 'unread' : 'read'; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?></td>
                            <td>
                                <div class="action-links">
                                    <?php if($row['status'] == 'unread'): ?>
                                        <a href="donor_notification.php?mark_read=<?php echo $row['id']; ?>" 
                                           class="mark-read">
                                            Mark as Read
                                        </a>
                                    <?php else: ?>
                                        <span class="read-status">Read</span>
                                    <?php endif; ?>
                                    <a href="donor_notification.php?delete=<?php echo $row['id']; ?>" 
                                       class="delete-button"
                                       onclick="return confirm('Are you sure you want to delete this notification?');">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-notifications">You have no notifications at this time.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>