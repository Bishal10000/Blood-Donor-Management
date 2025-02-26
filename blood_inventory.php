<?php
include('navbar3.php');
include('conn.php');  

$query = "SELECT * FROM blood_availability";
$result = mysqli_query($conn, $query);

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_query = "DELETE FROM blood_availability WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Blood inventory deleted successfully!');</script>";
        echo "<script>window.location.href='Blood_Inventory.php';</script>";
    } else {
        echo "<script>alert('Error deleting inventory record.');</script>";
    }
}

if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $available_units = (int) $_POST['available_units'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    $update_query = "UPDATE blood_availability SET blood_group='$blood_group', available_units=$available_units, address='$address', contact='$contact' WHERE id=$update_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Blood inventory updated successfully!');</script>";
        echo "<script>window.location.href='Blood_Inventory.php';</script>";
    } else {
        echo "<script>alert('Error updating inventory record.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Inventory</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
<div class="dashboard">
    <h2 class="dashboard-title">Blood Inventory</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Blood Group</th>
                    <th>Available Units</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['blood_group']; ?></td>
                    <td><?php echo $row['available_units']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="action-btn edit">Edit</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php
    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $edit_query = "SELECT * FROM blood_availability WHERE id = $edit_id";
        $edit_result = mysqli_query($conn, $edit_query);
        $edit_data = mysqli_fetch_assoc($edit_result);
    ?>
    <h2>Edit Inventory</h2>
    <form method="POST">
        <input type="hidden" name="update_id" value="<?php echo $edit_data['id']; ?>">
        <label for="blood_group">Blood Group:</label>
        <input type="text" name="blood_group" value="<?php echo $edit_data['blood_group']; ?>" required>
        <label for="available_units">Available Units:</label>
        <input type="number" name="available_units" value="<?php echo $edit_data['available_units']; ?>" required>
        <label for="address">Address:</label>
        <textarea name="address" required><?php echo $edit_data['address']; ?></textarea>
        <label for="contact">Contact:</label>
        <input type="text" name="contact" value="<?php echo $edit_data['contact']; ?>" required>
        <button type="submit">Update</button>
    </form>
    <?php } ?>
</div>
</body>
</html>
