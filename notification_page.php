<?php
session_start();
include('conn.php');  // Include DB connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /Blood_Bank/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
include('navbar2.php');

// Handle mark as read
if (isset($_GET['mark_read'])) {
    $notification_id = intval($_GET['mark_read']);
    $updateQuery = "UPDATE notifications SET status = 'read' 
                    WHERE id = $notification_id AND user_id = $user_id";
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: /Blood_Bank/notification_page.php?success=marked_read");
        exit();
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $notification_id = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM notifications 
                   WHERE id = $notification_id AND user_id = $user_id";
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: /Blood_Bank/notification_page.php?success=deleted");
        exit();
    }
}

// Fetch notifications
$query = "SELECT * FROM notifications 
         WHERE user_id = $user_id 
         ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - FundHive</title>
    <link rel="stylesheet" href="/Blood_Bank/style/admin.css">
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
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert.success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <h2 class="dashboard-title">Notifications</h2>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="alert success">
            <?php switch($_GET['success']) {
                case 'deleted': echo "Notification deleted successfully"; break;
                case 'marked_read': echo "Notification marked as read"; break;
            } ?>
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
                        <tr class="<?= $row['status'] === 'unread' ? 'unread' : '' ?>">
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['message']) ?></td>
                            <td><?= date('M j, Y g:i a', strtotime($row['created_at'])) ?></td>
                            <td>
                                <div class="action-links">
                                    <?php if($row['status'] === 'unread'): ?>
                                        <a href="/Blood_Bank/notification_page.php?mark_read=<?= $row['id'] ?>" 
                                           class="mark-read">
                                            Mark as Read
                                        </a>
                                    <?php else: ?>
                                        <span>Read</span>
                                    <?php endif; ?>
                                    <a href="/Blood_Bank/notification_page.php?delete=<?= $row['id'] ?>" 
                                       class="delete-button"
                                       onclick="return confirm('Are you sure you want to delete this notification?')">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No notifications found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>