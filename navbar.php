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
        <a href="user_dashboard.php" style="text-decoration: none; color: inherit;">User Dashboard</a>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="why_bdms.php">Why BDMS</a></li>
            
    
            <li class="dropdown">
            <a href="#">Looking For Blood</a>
                <div class="dropdown-content">
                    <a href="register.php">User Register</a>
                    <a href="blood_availability.php">Blood Availability</a>
                </div>
            </li>

            <li><a href="our_achievements.php">Our Achievements</a></li>
        </ul>
    </nav>
    <div class="buttons">
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    </div>
</header>
</body>
</html>
