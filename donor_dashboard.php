
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard - Register Donor</title>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Donor Dashboard</h2>
        <ul>
            <li><a href="donor_dashboard.php">Home</a></li>
            <li><a href="donation_history.php">Donation History</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Register as a Donor</h1>
            <?php if (isset($message)): ?>
                <p><?= htmlspecialchars($message); ?></p>
            <?php endif; ?>
        </div>

        <div class="donor-form">
            <form action="donor_dashboard.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required><br>

                <label for="phone">Phone No:</label>
                <input type="tel" id="phone" name="phone" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="blood_group">Blood Group:</label>
                <select id="blood_group" name="blood_group" required>
                    <option value="">-- Select Blood Group --</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select><br>

                <label for="disease">Disease (if any):</label>
                <input type="text" id="disease" name="disease"><br>

                <button type="submit">Register Donor</button>
            </form>
        </div>
    </div>

</body>
</html>

<?php
session_start();
require('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $blood_group = $_POST['blood_group'];
    $disease = !empty($_POST['disease']) ? $_POST['disease'] : NULL;

    // Check last registered_at date for restriction
    $stmt = $conn->prepare("SELECT MAX(registered_at) AS last_action_date FROM donate WHERE email = ?");
    $stmt->bind_param("s", $email);
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
                          text: 'You need to wait $remainingDays more day(s) before registering as a donor again.',
                          confirmButtonText: 'OK'
                      }).then(() => {
                          window.location.href = 'donor_dashboard.php';
                      });
                  </script>";
            exit(); // Stop further processing
        }
    }

    // Insert new donor if no restriction applies
    $stmt = $conn->prepare("INSERT INTO donate (name, address, age, phone, email, blood_group, disease, registered_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssss", $name, $address, $age, $phone, $email, $blood_group, $disease, $currentDate);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: 'Donor registered successfully.',
                      confirmButtonText: 'OK'
                  }).then(() => {
                      window.location.href = 'donor_dashboard.php';
                  });
              </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
                  Swal.fire({
                      icon: 'error',
                      title: 'Error',
                      text: 'There was an error registering the donor. Please try again later.',
                      confirmButtonText: 'OK'
                  });
              </script>";
    }

    $stmt->close();
}
?>
