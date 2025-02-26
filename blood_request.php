<?php
require('conn.php');
require('navbar2.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $address = $_POST['address']; // Capture address
    $blood_type = $_POST['blood_type'];
    $units_needed = $_POST['units_needed'];
    $emergency_level = $_POST['emergency_level'];

    // Check last requested_at date for restriction
    $stmt = $conn->prepare("SELECT MAX(requested_at) AS last_action_date FROM blood_requests WHERE contact = ?");
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    $lastActionDate = $row['last_action_date'];
    $currentDate = date('Y-m-d H:i:s');

    if ($lastActionDate) {
        $daysSinceLastAction = (strtotime($currentDate) - strtotime($lastActionDate)) / (60 * 60 * 24);

        if ($daysSinceLastAction < 90) {
            $remainingDays = round(90 - $daysSinceLastAction);
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                  <script>
                      Swal.fire({
                          icon: 'error',
                          title: 'Access Restricted',
                          text: 'You need to wait $remainingDays more day(s) before making another blood request.',
                          confirmButtonText: 'OK'
                      }).then(() => {
                          window.location.href = 'blood_request.php';
                      });
                  </script>";
            exit(); // Stop further processing
        }
    }

    // Insert new blood request if no restriction applies
    $id_card_path = 'uploads/' . basename($_FILES['id_card']['name']);
    $prescription_path = 'uploads/' . basename($_FILES['prescription']['name']);
    move_uploaded_file($_FILES['id_card']['tmp_name'], $id_card_path);
    move_uploaded_file($_FILES['prescription']['tmp_name'], $prescription_path);

    $stmt = $conn->prepare("INSERT INTO blood_requests (name, email, age, contact, address, blood_type, units_needed, emergency_level, id_card_path, prescription_path, requested_at, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssissssisss", $name, $email, $age, $contact, $address, $blood_type, $units_needed, $emergency_level, $id_card_path, $prescription_path, $currentDate);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Blood request submitted successfully.',
                      confirmButtonText: 'OK'
                  }).then(() => {
                      window.location.href = 'blood_request.php';
                  });
              </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'There was an error submitting the blood request. Please try again later.',
                      confirmButtonText: 'OK'
                  });
              </script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Request Form</title>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Receiver Dashboard</h2>
        <ul>
            <li><a href="receiver_dashboard.php">Home</a></li>
            <li><a href="blood_request.php">Blood Requests</a></li>
            <li><a href="request_history.php">Request History</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <h2>Blood Request Form</h2>

    <div class="form-container">
        <h2 class="form-header">Blood Request Form</h2>
        <form id="blood-request-form" action="blood_request.php" method="POST" enctype="multipart/form-data">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="18" required>

            <label for="contact">Contact Number:</label>
            <input type="tel" id="contact" name="contact" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="blood_type">Blood Type:</label>
            <select id="blood_type" name="blood_type" required>
                <option value="">Select Blood Type</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="units_needed">Units Needed:</label>
            <input type="number" id="units_needed" name="units_needed" min="1" required>

            <label for="emergency_level">Emergency Level:</label>
            <select id="emergency_level" name="emergency_level" required>
                <option value="Normal">Normal</option>
                <option value="Urgent">Urgent</option>
                <option value="Critical">Critical</option>
            </select>

            <label for="id_card">Upload Identification Card (e.g., Citizenship, License):</label>
            <input type="file" id="id_card" name="id_card" accept=".jpg, .jpeg, .png, .pdf" required>

            <label for="prescription">Upload Doctor's Prescription:</label>
            <input type="file" id="prescription" name="prescription" accept=".jpg, .jpeg, .png, .pdf" required>

            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>
