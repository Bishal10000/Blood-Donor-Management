<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('conn.php');
require('navbar2.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $user_type = $_POST['user_type'] ?? '';

    if ($username !== '' && $password !== '' && $user_type !== '') {
        if ($user_type === 'admin') {
            // Admin login remains unchanged
            $sql = "SELECT * FROM admin WHERE LOWER(username) = LOWER(?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) die("Error preparing statement: " . $conn->error);
            $stmt->bind_param("s", $username);
        } else {
            // Modified query to handle multiple user types
            $sql = "SELECT * FROM users WHERE LOWER(name) = LOWER(?) AND FIND_IN_SET(?, user_type) > 0";
            $stmt = $conn->prepare($sql);
            if (!$stmt) die("Error preparing statement: " . $conn->error);
            $stmt->bind_param("ss", $username, $user_type);
        }

        if (!$stmt->execute()) die("Error executing statement: " . $stmt->error);

        $result = $stmt->get_result();
        if (!$result) die("Error getting result set: " . $stmt->error);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Plain text password comparison (consider using password_hash() in production)
            if ($password === $user['password']) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = $user_type; // This will be the selected type (donor/receiver)

                $redirect = ($user_type === 'admin') ? 'admin_dashboard.php' : 'user_dashboard.php';
                header("Location: $redirect");
                exit();
            } else {
                $error = 'Invalid Password. Please check your credentials.';
            }
        } else {
            $error = 'Invalid Login. Username not found or user type incorrect.';
        }

        $stmt->close();
    } else {
        $error = 'Missing Fields. Please fill in all required fields.';
    }

    if (isset($error)) {
        echo "<script>alert('$error');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<!-- The rest of your HTML remains unchanged -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

        <form action="login.php" method="POST" id="loginForm">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required>
            </div>
            <div class="field input">
        <label for="password">Password:</label>
        <div class="password-wrapper">
          <input type="password" name="password" id="password" placeholder="Enter your password" required />
          <i class="toggle-password fa-regular fa-eye" onclick="togglePassword('password', this)"></i>
        </div>
      </div>
            
            <div class="user-type">
                <label>User Type:</label>
                <label for="admin">
                    <input type="radio" name="user_type" value="admin" id="admin" required> Admin
                </label>
                <label for="donor">
                    <input type="radio" name="user_type" value="donor" id="donor"> Donor
                </label>
                <label for="receiver">
                    <input type="radio" name="user_type" value="receiver" id="receiver"> Receiver
                </label>
            </div>

            <button type="submit">Login</button>

            <p>Do not have an account? <a href="register.php" class="signup-link">Sign up</a></p>
        </form>
    </div>

    <script>
   
   function togglePassword(fieldId, icon) {
        const passwordField = document.getElementById(fieldId);
        if (!passwordField) {
            console.error("Password field not found");
            return;
        }
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

  </script>
</body>
</html>
