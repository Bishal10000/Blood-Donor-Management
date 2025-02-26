<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('navbar3.php');
include('conn.php');  // Include DB connection

// Handle Delete Request
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_query = "DELETE FROM donors WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Record deleted successfully!');</script>";
        echo "<script>window.location.href='manage_donors.php';</script>";
        exit;
    } else {
        die("Error deleting record: " . mysqli_error($conn));
    }
}

// Handle Update Request
if (isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);

    $update_query = "UPDATE donors SET name='$name', phone='$phone', email='$email', blood_group='$blood_group', district='$district' WHERE id=$update_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Record updated successfully!');</script>";
        echo "<script>window.location.href='manage_donors.php';</script>";
        exit;
    } else {
        die("Error updating record: " . mysqli_error($conn));
    }
}

// Handle Verify Request - similar to receivers, but reversed logic.
// Here we check if there are any blood requests matching the donor's blood group.
if (isset($_POST['verify_id'])) {
    $verify_id = intval($_POST['verify_id']);
    
    // Retrieve the donor details
    $stmt = $conn->prepare("SELECT blood_group, district, name, email, phone FROM donors WHERE id = ?");
    $stmt->bind_param("i", $verify_id);
    $stmt->execute();
    $result_donor = $stmt->get_result();
    $donor = $result_donor->fetch_assoc();
    $stmt->close();

    if ($donor) {
        $blood_group  = $donor['blood_group'];
        $district     = $donor['district'];
        $donor_name   = $donor['name'];
        $donor_email  = $donor['email'];

        // Check if there are any blood requests for this blood group
        $check_query  = "SELECT COUNT(*) as count FROM blood_requests WHERE blood_group = '$blood_group'";
        $check_result = mysqli_query($conn, $check_query);
        $check_row    = mysqli_fetch_assoc($check_result);

        if ($check_row['count'] > 0) {
            // First, try to find up to 3 blood requests in the same district.
            $stmt = $conn->prepare("SELECT phone FROM blood_requests 
                                    WHERE blood_group = ? 
                                    AND district = ?
                                    LIMIT 3");
            $stmt->bind_param("ss", $blood_group, $district);
            $stmt->execute();
            $request_result = $stmt->get_result();
            $stmt->close();

            if ($request_result->num_rows > 0) {
                $receiver_numbers = [];
                while ($request = $request_result->fetch_assoc()) {
                    $receiver_numbers[] = $request['phone'];
                }
                $notification_message = "Potential blood receivers found for your donation ($blood_group). Receiver contacts: " . implode(", ", $receiver_numbers);
            } else {
                // No blood requests in the donor's district; try a broader search (limit 2).
                $stmt = $conn->prepare("SELECT phone FROM blood_requests 
                                        WHERE blood_group = ? 
                                        LIMIT 2");
                $stmt->bind_param("s", $blood_group);
                $stmt->execute();
                $overall_result = $stmt->get_result();
                $stmt->close();

                if ($overall_result->num_rows > 0) {
                    $receiver_numbers = [];
                    while ($request = $overall_result->fetch_assoc()) {
                        $receiver_numbers[] = $request['phone'];
                    }
                    $notification_message = "No local blood requests found, but potential receivers for your donation ($blood_group) are: " . implode(", ", $receiver_numbers);
                } else {
                    $notification_message = "No blood requests found for your donation ($blood_group).";
                }
            }
        } else {
            $notification_message = "No blood requests found for your donation ($blood_group).";
        }

        // Insert a notification record into the donor_notifications table.
        $insert_query = "INSERT INTO donor_notifications (message, donor_id, donor_email, created_at) VALUES ('$notification_message', $verify_id, '$donor_email', NOW())";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>
                    alert('$notification_message');
                    window.location.href='manage_donors.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to send notification.');
                    window.location.href='manage_donors.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Donor record not found.');
                window.location.href='manage_donors.php';
              </script>";
    }
    exit;
}

// Fetch all records from the donors table for display
$query = "SELECT * FROM donors";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Donor Form Requests</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
<div class="dashboard">
    <h2 class="dashboard-title">Manage Donor Form Requests</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Blood Group</th>
                    <th>District</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['blood_group']; ?></td>
                    <td><?php echo $row['district']; ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="action-btn edit">Edit</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="verify_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="action-btn verify">Verify</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php
    // Display edit form dynamically if Edit button is clicked
    if (isset($_POST['edit_id'])) {
        $edit_id = intval($_POST['edit_id']);
        $edit_query = "SELECT * FROM donors WHERE id = $edit_id";
        $edit_result = mysqli_query($conn, $edit_query);
        $edit_data = mysqli_fetch_assoc($edit_result);
    ?>
    <div class="edit-form-container">
        <h3>Edit Form Request</h3>
        <form method="POST">
            <input type="hidden" name="update_id" value="<?php echo $edit_data['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $edit_data['name']; ?>" required>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo $edit_data['phone']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $edit_data['email']; ?>" required>
            <label for="blood_group">Blood Group:</label>
            <input type="text" name="blood_group" value="<?php echo $edit_data['blood_group']; ?>" required>
            <label for="district">District:</label>
            <textarea name="district" required><?php echo $edit_data['district']; ?></textarea>
            <button type="submit" class="action-btn save">Update</button>
        </form>
    </div>
    <?php } ?>
</div>
</body>
</html>
