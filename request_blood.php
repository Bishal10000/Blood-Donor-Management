<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

$user_id = $_SESSION['user_id'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('conn.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : "";
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $note = $conn->real_escape_string($_POST['note']);

    // New fields: province and district
    $province = $conn->real_escape_string($_POST['province']);
    $district = $conn->real_escape_string($_POST['district']);

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $message = "You must be logged in to make a request.";
        die($message);
    }

    if (isset($_FILES['requisition']) && $_FILES['requisition']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        $fileType = mime_content_type($_FILES['requisition']['tmp_name']);
        $fileSize = $_FILES['requisition']['size'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= 5 * 1024 * 1024) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9\.\-_]/', '', basename($_FILES['requisition']['name']));
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['requisition']['tmp_name'], $filePath)) {
                $sql = "INSERT INTO blood_requests (name, email, phone, blood_group, requisition_file, note, province, district, user_id) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssi", $name, $email, $phone, $blood_group, $filePath, $note, $province, $district, $user_id);

                if ($stmt->execute()) {
                    $message = "Blood request submitted successfully!";
                } else {
                    $message = "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $message = "Failed to upload the requisition form.";
            }
        } else {
            $message = "Invalid file. Ensure it is a PDF, JPG, or PNG and does not exceed 5 MB.";
        }
    } else {
        $message = "No file uploaded or invalid request.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Request Form</title>
    <link rel="stylesheet" href="style/user.css">
    <link rel="stylesheet" href="style/dasboardstyle.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("blood-request-form");
            const fileInput = document.getElementById("requisition");

            form.addEventListener("submit", function (e) {
                const file = fileInput.files[0];
                const allowedTypes = ["application/pdf", "image/jpeg", "image/png"];
                const maxSize = 5 * 1024 * 1024; // 5 MB

                if (file) {
                    if (!allowedTypes.includes(file.type)) {
                        e.preventDefault();
                        alert("Invalid file type. Please upload a PDF, JPG, or PNG file.");
                        return;
                    }

                    if (file.size > maxSize) {
                        e.preventDefault();
                        alert("File size exceeds the 5 MB limit. Please upload a smaller file.");
                        return;
                    }
                }
            });
        });
    </script>
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
            <li >
                    <a href="blood_availability.php">Donor Availability</a>
            </li>
            <li><a href="our_achievements.php">Our Achievements</a></li>
            <li><a href="notification_page.php">Notification</a></li>
        </ul>
    </nav>
    <div class="buttons">
        <a href="logout.php" class="btn">Logout</a>
    </div>
</header>

<div class="form-container">
    <h2 class="form-header">Blood Request Form</h2>
    <?php if (!empty($message)): ?>
        <p style="color: <?= strpos($message, 'successfully') !== false ? 'green' : 'red'; ?>;">
            <?= htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>
    <form id="blood-request-form" action="" method="POST" enctype="multipart/form-data">
        <!-- Full Name -->
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required>

        <!-- Phone -->
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

        <!-- Province -->
        <label for="province">Province:</label>
        <select id="province" name="province" required>
            <option value="" disabled selected>Select a Province</option>
            <option value="Koshi">Koshi</option>
            <option value="Madesh">Madesh</option>
            <option value="Bagmati">Bagmati</option>
            <option value="Gandaki">Gandaki</option>
            <option value="Lumbini">Lumbini</option>
            <option value="Karnali">Karnali</option>
            <option value="Sudurpashchim">Sudurpashchim</option>
        </select>

        <!-- District -->
        <label for="district">District:</label>
        <input type="text" id="district" name="district" placeholder="Enter your district" required>

        <!-- Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email address">

        <!-- Blood Group -->
        <label for="blood_group">Blood Group:</label>
        <select id="blood_group" name="blood_group" required>
            <option value="">Select Blood Group</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        <!-- Requisition Form -->
        <label for="requisition">Requisition Form:</label>
        <input type="file" id="requisition" name="requisition" accept=".pdf,.jpg,.jpeg,.png" required>
        <p style="font-size: 12px; color: #888;">💡 You can upload PDF, JPG, or PNG files. Max size: 5 MB.</p>

        <!-- Note -->
        <label for="note">Note:</label>
        <textarea id="note" name="note" placeholder="Enter any additional details" rows="3"></textarea>

        <!-- Submit Button -->
        <button type="submit">Submit Request</button>
    </form>
</div>
</body>
</html>
<?php include 'footer.php' ?>
