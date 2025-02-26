<?php

// Database configuration
$host = '127.0.0.1';
$port = '3306';
$dbname = 'blood_bank';
$username = 'root';
$password = 'Bishal@10';


// Connect to MySQL Workbench
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
