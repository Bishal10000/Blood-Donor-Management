<?php

ob_start(); // Start output buffering
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('navbar3.php');
include('conn.php');  

// Handle Delete Request
if (isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $delete_query = "DELETE FROM blood_requests WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Request deleted successfully!');</script>";
        echo "<script>window.location.href='manage_receivers.php';</script>";
        exit;
    }
}

// Handle Update Request
if (isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    $update_query = "UPDATE blood_requests SET name='$name', email='$email', phone='$phone', blood_group='$blood_group', note='$note' WHERE id=$update_id";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Request updated successfully!');</script>";
        echo "<script>window.location.href='manage_receivers.php';</script>";
        exit;
    }
}

// Handle Verify Request using nested ifs to insert notification for all cases
if (isset($_POST['verify_id'])) {
    $verify_id = intval($_POST['verify_id']);
    
    // Retrieve the blood request details
    $stmt = $conn->prepare("SELECT blood_group, province, district, user_id, email, name FROM blood_requests WHERE id = ?");
    $stmt->bind_param("i", $verify_id);
    $stmt->execute();
    $result_request = $stmt->get_result();
    $request = $result_request->fetch_assoc();
    $stmt->close();

    if ($request) {
        $blood_group  = $request['blood_group'];
        $province     = $request['province'];
        $district     = $request['district'];
        $user_id      = $request['user_id'];
        $user_email   = $request['email'];
        $patient_name = $request['name'];

        // Check if this blood group exists in the donors inventory
        $check_query  = "SELECT COUNT(*) as count FROM donors WHERE blood_group = '$blood_group'";
        $check_result = mysqli_query($conn, $check_query);
        $check_row    = mysqli_fetch_assoc($check_result);

        if ($check_row['count'] > 0) {
            // First, try to find up to 3 active donors in the same district.
            $stmt = $conn->prepare("SELECT phone FROM donors 
                                    WHERE blood_group = ? 
                                    AND province = ? 
                                    AND district = ?
                                    AND is_active = 1
                                    LIMIT 3");
            $stmt->bind_param("sss", $blood_group, $province, $district);
            $stmt->execute();
            $donor_result = $stmt->get_result();
            $stmt->close();

            if ($donor_result->num_rows > 0) {
                // Donors found in district.
                $donor_numbers = [];
                while ($donor = $donor_result->fetch_assoc()) {
                    $donor_numbers[] = $donor['phone'];
                }
                $notification_message = "We found potential donors for $patient_name ($blood_group). Donor contacts: " . implode(", ", $donor_numbers);
            } else {
                // No donors in district; try province-level (limit to 2).
                $stmt = $conn->prepare("SELECT phone FROM donors 
                                        WHERE blood_group = ? 
                                        AND province = ?
                                        AND is_active = 1
                                        LIMIT 2");
                $stmt->bind_param("ss", $blood_group, $province);
                $stmt->execute();
                $province_result = $stmt->get_result();
                $stmt->close();

                if ($province_result->num_rows > 0) {
                    $donor_numbers = [];
                    while ($donor = $province_result->fetch_assoc()) {
                        $donor_numbers[] = $donor['phone'];
                    }
                    $notification_message = "No local donors found for $patient_name, but we found some in $province province. Contacts: " . implode(", ", $donor_numbers);
                } else {
                    $notification_message = "Blood group $blood_group is not available for $patient_name.";
                }
            }
        } else {
            $notification_message = "Blood group not found in inventory for $patient_name ($blood_group).";
        }

        // Insert the notification record regardless of the branch.
        $insert_query = "INSERT INTO notifications (message, user_id, user_email, created_at) VALUES ('$notification_message', $user_id, '$user_email', NOW())";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>
                    alert('$notification_message');
                    window.location.href='manage_receivers.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to send notification.');
                    window.location.href='manage_receivers.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Blood request not found.');
                window.location.href='manage_receivers.php';
              </script>";
    }
    exit;
}

// Fetch all blood requests for display
$query = "SELECT * FROM blood_requests";
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
  <title>Manage Blood Requests</title>
  <link rel="stylesheet" href="style/admin.css">
</head>
<body>
<div class="dashboard">
  <h2 class="dashboard-title">Manage Blood Requests</h2>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Blood Group</th>
          <th>Requisition File</th>
          <th>Note</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['phone']; ?></td>
          <td><?php echo $row['blood_group']; ?></td>
          <td><a href="<?php echo $row['requisition_file']; ?>" target="_blank">View File</a></td>
          <td><?php echo $row['note']; ?></td>
          <td>
            <form method="POST" style="display: inline;">
              <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
              <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this request?');">Delete</button>
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
  if (isset($_POST['edit_id'])) {
      $edit_id = intval($_POST['edit_id']);
      $edit_query = "SELECT * FROM blood_requests WHERE id = $edit_id";
      $edit_result = mysqli_query($conn, $edit_query);
      $edit_data = mysqli_fetch_assoc($edit_result);
  ?>
  <div class="edit-form-container">
      <h3>Edit Blood Request</h3>
      <form method="POST">
          <input type="hidden" name="update_id" value="<?php echo $edit_data['id']; ?>">
          <label for="name">Name:</label>
          <input type="text" name="name" value="<?php echo $edit_data['name']; ?>" required>
          <label for="email">Email:</label>
          <input type="email" name="email" value="<?php echo $edit_data['email']; ?>">
          <label for="phone">Phone:</label>
          <input type="text" name="phone" value="<?php echo $edit_data['phone']; ?>" required>
          <label for="blood_group">Blood Group:</label>
          <input type="text" name="blood_group" value="<?php echo $edit_data['blood_group']; ?>" required>
          <label for="note">Note:</label>
          <textarea name="note"><?php echo $edit_data['note']; ?></textarea>
          <button type="submit" class="action-btn save">Update</button>
      </form>
  </div>
  <?php } ?>
</div>
</body>
</html>
