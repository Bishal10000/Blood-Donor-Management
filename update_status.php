<?php
require 'conn.php';

// Update donor eligibility
$conn->query("UPDATE donors 
             SET is_active = CASE 
                 WHEN last_donation_date IS NULL THEN 1
                 WHEN DATEDIFF(CURDATE(), last_donation_date) > 90 THEN 1
                 ELSE 0 
             END");

file_put_contents('cron.log', date('Y-m-d H:i:s')." - Donor statuses updated\n", FILE_APPEND);