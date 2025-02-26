<?php
// if ($_SESSION['user_type'] != 'admin') {
//     header('Location: login.php'); // Redirect to login if not admin
//     exit;
// }
?>

<nav class="navbar">
<div class="logo">
        <a href="admin_dashboard.php" style="text-decoration: none; color: inherit;">Blood Donor Mgmt</a>
    </div>
    <div class="menu">
        <a href="manage_donors.php">Manage Donors</a>
        <a href="manage_receivers.php">Manage Receiver</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>


