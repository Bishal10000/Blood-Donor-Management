<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('conn.php');
require 'navbar2.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $blood_type = $_POST['blood_type'];
    $age = $_POST['age'];
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'] ?? '';

    $errors = [];

    // Validate Name
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $errors[] = "Name should only contain alphabets and spaces.";
    }

    // Validate Address
    if (!preg_match("/^[a-zA-Z0-9\s.,-]+$/", $address)) {
        $errors[] = "Address contains invalid characters.";
    }

    // Validate Phone
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone should be a 10-digit number.";
    }

    // Validate Blood Type
    $valid_blood_types = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
    if (!in_array($blood_type, $valid_blood_types)) {
        $errors[] = "Please select a valid blood type.";
    }

    // Validate Age
    if ($age < 18 || $age > 60) {
        $errors[] = "Age should be between 18 and 60.";
    }

    // Validate Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate Password
    if (strlen($password) < 6) {
        $errors[] = "Password should be at least 6 characters long.";
    }
    
    // Confirm Password
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    if ($check_email->get_result()->num_rows > 0) {
        $errors[] = "Email already registered.";
    }

    // Handle User Type
    $user_types = [];
    if (isset($_POST['user_type'])) {
        foreach ($_POST['user_type'] as $type) {
            if ($type === 'donor') {
                $user_types[] = 'donor';
            } elseif ($type === 'receiver') {
                $user_types[] = 'receiver';
            } elseif ($type === 'both') {
                $user_types[] = 'donor';
                $user_types[] = 'receiver';
            }
        }
    }

    // Remove duplicates and validate at least one type
    $user_types = array_unique($user_types);
    if (empty($user_types)) {
        $errors[] = "Please select at least one user type.";
    }
    $user_types = implode(',', $user_types);

    // Use plain text password (No hashing)
    $plain_password = $password;

    // Process errors or register user
    if (!empty($errors)) {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    } else {
        // Insert Data
        $sql = "INSERT INTO users (name, address, phone, blood_type, age, email, password, user_type)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisss", $name, $address, $phone, $blood_type, $age, $email, $plain_password, $user_types);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registration Successful!');
                window.location.href = 'login.php';
              </script>";
        } else {
            echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
        }
        $stmt->close();
    }
    $check_email->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style/register.css">
    <!-- Include Font Awesome for eye icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1>Registration</h1>
            <form action="register.php" method="post">
                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" required>
                </div>
                <div class="field input">
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" required>
                </div>
                <div class="field input">
                    <label for="blood_type">Blood Type</label>
                    <select name="blood_type" id="blood_type" required>
                        <option value="">Select</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required>
                        <i class="toggle-password fa-regular fa-eye" 
                           onclick="togglePassword('password', this)"></i>
                    </div>
                </div>
                <div class="field input">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="confirm_password" id="confirm_password" required>
                        <i class="toggle-password fa-regular fa-eye" 
                           onclick="togglePassword('confirm_password', this)"></i>
                    </div>
                </div>

                <div class="field input">
                    <label>User Type</label>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="user_type[]" value="donor"> Donor
                        </label>
                        <label>
                            <input type="checkbox" name="user_type[]" value="receiver"> Receiver
                        </label>
                        <label>
                            <input type="checkbox" name="user_type[]" value="both"> Both
                        </label>
                    </div>
                </div>
                <button type="submit">Register</button>
                <div class="links">
                    Already have an account? <a href="login.php">Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, icon) {
            const passwordField = document.getElementById(fieldId);
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
