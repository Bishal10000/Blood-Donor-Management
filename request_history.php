<?php
session_start();
require('conn.php');

$query = "SELECT id, name, age, gender, contact, address, blood_type, units_needed, emergency_level, id_card_path, prescription_path, requested_at, status 
          FROM blood_requests 
          WHERE name='{$_SESSION['username']}'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request History</title>
    <link rel="stylesheet" href="style/dashboard.css">
    <link rel="stylesheet" href="style/table.css">
    <style>
        .status-approved { color: green; }
        .status-pending { color: orange; }
        .status-rejected { color: red; }
    </style>
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

    <div class="main-content">
        <h2>Request History</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Blood Type</th>
                    <th>Units Needed</th>
                    <th>Emergency Level</th>
                    <th>ID Card</th>
                    <th>Prescription</th>
                    <th>Requested At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['age']); ?></td>
                            <td><?= htmlspecialchars($row['gender']); ?></td>
                            <td><?= htmlspecialchars($row['contact']); ?></td>
                            <td><?= htmlspecialchars($row['address']); ?></td>
                            <td><?= htmlspecialchars($row['blood_type']); ?></td>
                            <td><?= htmlspecialchars($row['units_needed']); ?></td>
                            <td><?= htmlspecialchars($row['emergency_level']); ?></td>
                            <td><a href="<?= htmlspecialchars($row['id_card_path']); ?>" target="_blank">View</a></td>
                            <td><a href="<?= htmlspecialchars($row['prescription_path']); ?>" target="_blank">View</a></td>
                            <td><?= htmlspecialchars($row['requested_at']); ?></td>
                            <td class="<?php echo 'status-' . strtolower($row['status']); ?>">
                                <?= htmlspecialchars($row['status']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="13">No request records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
$conn->close();
?>
