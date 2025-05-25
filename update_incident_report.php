<?php
include 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $location = $_POST['location'];
    $incident_type = $_POST['incident_type'];

    // Check if a new photo is uploaded
    if ($_FILES['photo']['name']) {
        $photo = "uploads/" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        $sql = "UPDATE incident_reports SET location=?, incident_type=?, photo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $location, $incident_type, $photo, $id);
    } else {
        $sql = "UPDATE incident_reports SET location=?, incident_type=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $location, $incident_type, $id);
    }

    if ($stmt->execute()) {
        header("Location: incident
