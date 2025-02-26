
<?php
session_start();
//database connection
require('conn.php');


$query = "SELECT id, name, address, age, phone, email, blood_group, disease, registered_at, status 
          FROM donate 
          WHERE name='{$_SESSION['username']}'"; 
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation History</title>
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
        <h2>Donor Dashboard</h2>
        <ul>
            <li><a href="donor_dashboard.php">Home</a></li>
            <li><a href="donation_history.php">Donation History</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Donation History</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Blood Group</th>
                    <th>Disease</th>
                    <th>Registered At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['address']); ?></td>
                            <td><?= htmlspecialchars($row['age']); ?></td>
                            <td><?= htmlspecialchars($row['phone']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['blood_group']); ?></td>
                            <td><?= htmlspecialchars($row['disease']); ?></td>
                            <td><?= htmlspecialchars($row['registered_at']); ?></td>
                            <td class="<?php echo 'status-' . strtolower($row['status']); ?>">
                                <?= htmlspecialchars($row['status']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="10">No donation records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
$conn->close();
?>
