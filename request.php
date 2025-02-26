<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Donor Approvals</title>
    <link rel="stylesheet" href="style/dashboard.css"> <!-- Sidebar CSS -->
    <link rel="stylesheet" href="style/table.css"> <!-- Table CSS -->
</head>
<body>

    Sidebar Menu
    <!-- <div class="sidebar">
        <h2>Blood Bank Management</h2>
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="donor.php">Donor</a></li>
            <li><a href="patient.php">Patient</a></li>
            <li><a href="donations.php">Donations</a></li>
            <li><a href="request.php"> Requests</a></li>
            <li><a href="request_history.php">Request History</a></li>
            <li><a href="blood_stock.php">Blood Stock</a></li>
        </ul>
    </div> -->

    <!-- Main Content -->
    <div class="main-content">
        <h2>Pending Donor Approvals</h2>
        <?php include 'navbar.php'; ?>
    <?php
    // Database configuration
    include 'conn.php';
    
    // Query to fetch blood requests made by the current user
    $sql = "SELECT id, name, age, gender, contact, address, blood_type, units_needed, emergency_level, id_card_path, prescription_path, requested_at, status 
              FROM blood_requests 
              WHERE status ='pending'";
    $result = $conn->query($sql);

    // Display pending approvals table
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
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
                <th>Action</th>
            </tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
            echo "<td>" . htmlspecialchars($row['address']) . "</td>";
            echo "<td>" . htmlspecialchars($row['blood_type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['units_needed']) . "</td>";
            echo "<td>" . htmlspecialchars($row['emergency_level']) . "</td>";
            echo "<td><a href='" . htmlspecialchars($row['id_card_path']) . "' target='_blank'>View</a></td>";
            echo "<td><a href='" . htmlspecialchars($row['prescription_path']) . "' target='_blank'>View</a></td>";
            echo "<td>" . htmlspecialchars($row['requested_at']) . "</td>";  
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
echo "<td>
        <a href='reciever_approve.php?id=" . htmlspecialchars($row['id']) . "' class='approve'>Approve</a> | 
        <a href='reciever_reject.php?id=" . htmlspecialchars($row['id']) . "' class='reject'>Reject</a>
      </td>";

                echo "</tr>";
            }
            

            echo "</table>";
        } else {
            echo "<p>No pending approvals.</p>";
        }

        $conn->close();
        ?>
    </div>

</body>
</html>
