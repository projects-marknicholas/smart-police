<?php
include 'includes/db_connection.php';

$query = "SELECT barangay_name, latitude, longitude, officer_name FROM barangay_locations";
$result = mysqli_query($conn, $query);

$locations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $locations[] = $row;
}

echo json_encode($locations);
?>
