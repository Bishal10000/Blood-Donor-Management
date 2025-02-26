<?php
include('conn.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $district = $_POST['district'];
    $municipality = $_POST['municipality'];

    $query = "SELECT health_post, address, blood_group, available_units, contact 
              FROM blood_availability 
              WHERE district = ? AND municipality = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $district, $municipality);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
