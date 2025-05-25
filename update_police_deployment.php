<?php
include 'includes/db_connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $officer_name = $_POST['officer_name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $location = $_POST['location'];

    // Update the police deployment data in the database
    $sql = "UPDATE police_deployment SET officer_name = '$officer_name', latitude = '$latitude', longitude = '$longitude', location = '$location' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the police deployment page after successful update
        header("Location: police_deployment.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
