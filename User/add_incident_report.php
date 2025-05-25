<?php
// Include the database connection file
include('includes/db_connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $incident_type = $_POST['incident_type'];
    $incident_date = $_POST['incident_date'];
    $incident_time = $_POST['incident_time'];
    $barangay = $_POST['barangay'];
    $description = $_POST['description'];

    // Prepare and execute the SQL query to insert the data
    $sql = "INSERT INTO incident_reports (incident_type, incident_date, incident_time, barangay, description) 
            VALUES ('$incident_type', '$incident_date', '$incident_time', '$barangay', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Incident report added successfully');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch the list of barangays from the database for the dropdown
$barangay_sql = "SELECT * FROM barangays";
$barangay_result = mysqli_query($conn, $barangay_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Incident Report</title>
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Include your CSS file -->
</head>
<body>

<!-- Form to add a new incident report -->
<div class="form-container">
    <h2>Add Incident Report</h2>
    <form action="add_incident_report.php" method="POST">
        <label for="incident_type">Incident Type:</label>
        <input type="text" id="incident_type" name="incident_type" required><br><br>

        <label for="incident_date">Incident Date:</label>
        <input type="date" id="incident_date" name="incident_date" required><br><br>

        <label for="incident_time">Incident Time:</label>
        <input type="time" id="incident_time" name="incident_time" required><br><br>

        <label for="barangay">Barangay:</label>
        <select id="barangay" name="barangay" required>
            <option value="">Select Barangay</option>
            <?php while ($row = mysqli_fetch_assoc($barangay_result)) { ?>
                <option value="<?php echo $row['barangay_id']; ?>"><?php echo $row['barangay_name']; ?></option>
            <?php } ?>
        </select><br><br>

        <label for="description">Incident Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea><br><br>

        <button type="submit" name="submit">Add Incident Report</button>
    </form>
</div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
