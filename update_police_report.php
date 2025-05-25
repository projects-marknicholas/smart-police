<?php
include 'includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $offense = $_POST['offense'];
    $date_of_case = $_POST['date_of_case'];

    // Prepare the SQL update statement
    $sql = "UPDATE police_reports SET name=?, age=?, address=?, offense=?, date_of_case=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $name, $age, $address, $offense, $date_of_case, $id);

    if ($stmt->execute()) {
        header("Location: police_reports.php?update=success");
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}
?>
