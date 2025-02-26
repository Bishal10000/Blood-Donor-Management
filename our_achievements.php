<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('conn.php');
require 'navbar2.php';

// Get total donors
$total_donors = $conn->query("SELECT COUNT(*) FROM donors")->fetch_row()[0];

// Get total receivers
$total_receivers = $conn->query("SELECT COUNT(*) FROM blood_requests ")->fetch_row()[0];

// Get successful connections (requests with donor matches)
$successful_connections = $conn->query("SELECT COUNT(DISTINCT br.id) 
                                      FROM blood_requests br
                                      JOIN donors d ON br.blood_group = d.blood_group 
                                        AND br.district = d.district")->fetch_row()[0];
                                        
// Get active donors (available to donate)
$active_donors = $conn->query("SELECT COUNT(*) FROM donors WHERE is_active = 1")->fetch_row()[0];

// Get top 5 most active donors with phone number
$top_donors = $conn->query("SELECT name, blood_group, district, phone, created_at,
                           DATEDIFF(NOW(), last_donation_date) AS days_since_last_donation
                           FROM donors 
                           ORDER BY created_at DESC 
                           LIMIT 5");

// Get recent 10 blood requests with phone
$recent_requests = $conn->query("SELECT br.name, br.blood_group, br.created_at, br.district, br.phone
                               FROM blood_requests br
                               JOIN users u ON br.user_id = u.id
                               ORDER BY br.created_at DESC 
                               LIMIT 10");
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Achievements</title>
    <link rel="stylesheet" href="style/achiv.css">
    <style>
        .achievement-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 2.5em;
            color: #e74c3c;
            margin: 10px 0;
        }
        .list-section {
            margin: 30px 0;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-outline-primary {
            color: #007bff;
            background-color: transparent;
            border: 1px solid #007bff;
        }
        small {
            display: block;
            font-size: 0.8em;
            color: #6c757d;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blood Donor Network Achievements</h1>

        <div class="achievement-container">
            <div class="stat-card">
                <div class="stat-number"><?= $total_donors ?></div>
                <h3>Registered Donors</h3>
            </div>
            
            <div class="stat-card">
                <div class="stat-number"><?= $total_receivers ?></div>
                <h3>Registered Receivers </h3>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?= $successful_connections ?></div>
                <h3>Successful Connections</h3>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?= $active_donors ?></div>
                <h3>Currently Active Donors</h3>
            </div>
        </div>

        <div class="list-section">
            <h2>Top Recent Donors</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Donor Name</th>
                        <th>Blood Group</th>
                        <th>Location</th>
                        <th>Request Date</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($donor = $top_donors->fetch_assoc()): ?>
                    <tr>
                        <td><?= $donor['name'] ?></td>
                        <td><?= $donor['blood_group'] ?></td>
                        <td><?= $donor['district'] ?></td>
                        <td><?= date('M d, Y', strtotime($donor['created_at'])) ?></td>
                        <td>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <!-- Show phone number for logged-in users -->
                                <?= $donor['phone'] ?>
                            <?php else: ?>
                                <!-- Show login/register prompt for non-logged-in users -->
                                <a href="login.php" class="btn btn-sm btn-primary">Login</a> or 
                                <a href="register.php" class="btn btn-sm btn-outline-primary">Register</a>
                                <small>to view contact</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="list-section">
            <h2>Recent Blood Requests</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Requester</th>
                        <th>Blood Group</th>
                        <th>Request Date</th>
                        <th>Location</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($request = $recent_requests->fetch_assoc()): ?>
                    <tr>
                        <td><?= $request['name'] ?></td>
                        <td><?= $request['blood_group'] ?></td>
                        <td><?= date('M d, Y', strtotime($request['created_at'])) ?></td>
                        <td><?= $request['district'] ?></td>
                        <td>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <!-- Show phone number for logged-in users -->
                                <?= $request['phone'] ?>
                            <?php else: ?>
                                <!-- Show login/register prompt for non-logged-in users -->
                                <a href="login.php" class="btn btn-sm btn-primary">Login</a> or 
                                <a href="register.php" class="btn btn-sm btn-outline-primary">Register</a>
                                <small>to view contact</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
include 'footer.php';
?>
</body>
</html>