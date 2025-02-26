<?php
include('navbar3.php');
include('conn.php'); 

$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_query = "DELETE FROM users WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('User deleted successfully!');</script>";
        echo "<script>window.location.href='Manage_Users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}

if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $age = (int) $_POST['age'];
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    $update_query = "UPDATE users SET name='$name', blood_type='$blood_type', phone='$phone', email='$email', address='$address', age=$age, user_type='$user_type' WHERE id=$update_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('User updated successfully!');</script>";
        echo "<script>window.location.href='Manage_Users.php';</script>";
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
<div class="dashboard">
    <h2 class="dashboard-title">Manage Users</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blood Type</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['blood_type']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['user_type']; ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
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
        $edit_query = "SELECT * FROM users WHERE id = $edit_id";
        $edit_result = mysqli_query($conn, $edit_query);
        $edit_data = mysqli_fetch_assoc($edit_result);
    ?>
    <h2>Edit User</h2>
    <form method="POST">
        <input type="hidden" name="update_id" value="<?php echo $edit_data['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $edit_data['name']; ?>" required>
        <label for="blood_type">Blood Type:</label>
        <input type="text" name="blood_type" value="<?php echo $edit_data['blood_type']; ?>" required>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo $edit_data['phone']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $edit_data['email']; ?>" required>
        <label for="address">Address:</label>
        <textarea name="address" required><?php echo $edit_data['address']; ?></textarea>
        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo $edit_data['age']; ?>" required>
        <label for="user_type">User Type:</label>
        <input type="text" name="user_type" value="<?php echo $edit_data['user_type']; ?>" required>
        <button type="submit">Update</button>
    </form>
    <?php } ?>
</div>
</body>
</html>
