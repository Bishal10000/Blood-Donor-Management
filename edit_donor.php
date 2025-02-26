<?php
include 'conn.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $blood_group = $_POST['blood_group'];
    $address = $_POST['address'];

    $conn->query("UPDATE donors SET name='$name', phone='$phone', email='$email', blood_group='$blood_group', address='$address' WHERE id='$id'");
    header('Location: index.php');
}

$id = $_GET['id'];
$donor = $conn->query("SELECT * FROM donors WHERE id='$id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Donor</title>
</head>
<body>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $donor['id']; ?>">
        <label>Name: <input type="text" name="name" value="<?php echo $donor['name']; ?>"></label>
        <label>Phone: <input type="text" name="phone" value="<?php echo $donor['phone']; ?>"></label>
        <label>Email: <input type="text" name="email" value="<?php echo $donor['email']; ?>"></label>
        <label>Blood Group: <input type="text" name="blood_group" value="<?php echo $donor['blood_group']; ?>"></label>
        <label>Address: <textarea name="address"><?php echo $donor['address']; ?></textarea></label>
        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>
