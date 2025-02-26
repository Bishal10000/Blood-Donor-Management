<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'conn.php';
include 'navbar2.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Blood Donors</title>
    <link rel="stylesheet" href="style/blood_availability.css">
    <link rel="stylesheet" href="style/dashboard.css">
    
        
</head>
<body>
    <div class="container">
        <h1>Find Blood Donors</h1>
        <form method="POST">
            <!-- Province Dropdown -->
            <div class="form-group">
                <label for="province">Select Province:</label>
                <select id="province" name="province" required>
                    <option value="" disabled selected>Select a Province</option>
                    <option value="Koshi"> Koshi</option>
                    <option value="Madesh">Madesh</option>
                    <option value="Bagmati">Bagmati</option>
                    <option value="Gandaki">Gandaki</option>
                    <option value="Lumbini">Lumbini</option>
                    <option value="Karnali">Karnali</option>
                    <option value="Sudurpashchim">Sudurpashchim</option>
                </select>
            </div>

            <!-- District Input -->
            <div class="form-group">
                <label for="district">Enter District:</label>
                <input type="text" id="district" name="district" placeholder="Enter district name" required>
            </div>

            <!-- Blood Group Dropdown -->
            <div class="form-group">
                <label for="blood_group">Blood Group:</label>
                <select id="blood_group" name="blood_group" required>
                    <option value="" disabled selected>Select Blood Group</option>
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

            <button type="submit" style="margin-top: 20px;">Search Donors</button>
        </form>

        <!-- Donor Results Table -->
        <table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Donor Name</th>
                    <th>Blood Group</th>
                    <th>Province</th>
                    <th>District</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $province = $_POST['province'];
                    $district = $_POST['district'];
                    $blood_group = $_POST['blood_group'];

                    // Fetch donors from the database
                    $stmt = $conn->prepare("SELECT name, blood_group, province, district, phone 
                                            FROM donors 
                                            WHERE province = ? AND district LIKE ? AND blood_group = ?");
                    $district_like = "%$district%";
                    $stmt->bind_param('sss', $province, $district_like, $blood_group);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$counter}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['blood_group']}</td>
                                <td>{$row['province']}</td>
                                <td>{$row['district']}</td>
                                <td>";
                            
                            // Check if user is logged in
                            if (isset($_SESSION['user_id'])) {
                                echo $row['phone'];
                            } else {
                                echo '<a href="register.php">Register</a> or <a href="login.php">Login</a> to view contact';
                            }
                            
                            echo "</td></tr>";
                            $counter++;
                        }
                    } else {
                        echo '<tr><td colspan="6" class="no-data">No donors found matching your criteria</td></tr>';
                    }

                    $stmt->close();
                    $conn->close();
                }
                ?>
            </tbody>
        </table>

        <div class="register-link">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <p>Need to contact donors? <a href="register.php">Register</a> or <a href="login.php">Login</a></p>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2025 Blood Donor Management  (BDM). All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
