<?php
// Include the database connection
include('conn.php');
include('navbar3.php'); // Navbar included

// Fetch all records from the donors table
$query = "SELECT * FROM donors";
$result = mysqli_query($conn, $query);

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM donors WHERE id = $delete_id";
    mysqli_query($conn, $delete_query);
    header('Location: Manage_Form_Requests.php');
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $update_query = "UPDATE donors SET name='$name', phone='$phone', email='$email', blood_group='$blood_group', address='$address' WHERE id=$update_id";
    mysqli_query($conn, $update_query);
    header('Location: Manage_Form_Requests.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Form Requests</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <div class="container">
        <h1>Manage Form Requests</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Blood Group</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['blood_group']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td>
                            <a href="Manage_Form_Requests.php?edit_id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="Manage_Form_Requests.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (isset($_GET['edit_id'])) { 
            $edit_id = $_GET['edit_id'];
            $edit_query = "SELECT * FROM donors WHERE id = $edit_id";
            $edit_result = mysqli_query($conn, $edit_query);
            $edit_data = mysqli_fetch_assoc($edit_result);
        ?>
            <h2>Edit Request</h2>
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
                <label for="address">Address:</label>
                <textarea name="address" required><?php echo $edit_data['address']; ?></textarea>
                <button type="submit">Update</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
