<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="style/dasboardstyle.css">
    
</head>
<body>
<header>
    <div class="logo">
        <a href="index.php" style="text-decoration: none; color: inherit;">Blood Donor Mgmt</a>
    </div>

    <nav>
        <ul>
            <li><a href="why_bdms.php">Why BDMS</a></li>
            <li>
            
            <li><a href="blood_availability.php">Search Donors</a></li>

    
                
            </li>

            <li><a href="our_achievements.php">Our Achievements</a></li>
            
    
        </ul>
    </nav>
    <div class="buttons">
        <?php if(isset($_SESSION['user_id'])): ?>
            <!-- Show logout when user is logged in -->
            <a href="logout.php" class="btn">Logout</a>
        <?php else: ?>
            <!-- Show login/register when user is not logged in -->
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
        <?php endif; ?>
    </div>
</header>
</body>
</html>