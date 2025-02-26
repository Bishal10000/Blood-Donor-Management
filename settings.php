<?php
include('navbar3.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
<div class="dashboard">
    <h2 class="dashboard-title">Settings</h2>
    <form action="save_settings.php" method="POST">
        <div>
            <label for="email_notifications">Enable Email Notifications:</label>
            <input type="checkbox" id="email_notifications" name="email_notifications">
        </div>
        <div>
            <label for="sms_notifications">Enable SMS Notifications:</label>
            <input type="checkbox" id="sms_notifications" name="sms_notifications">
        </div>
        <div>
            <label for="admin_email">Admin Email:</label>
            <input type="email" id="admin_email" name="admin_email" placeholder="Enter email address">
        </div>
        <input type="submit" value="Save Settings">
    </form>
</div>
</body>
</html>