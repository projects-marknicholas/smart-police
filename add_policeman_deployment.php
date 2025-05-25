
<?php
// include necessary files
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $officer_name = $_POST['officer_name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $location = $_POST['location'];

    // Insert the data into the database
    $sql = "INSERT INTO police_deployment (officer_name, latitude, longitude, location) VALUES ('$officer_name', '$latitude', '$longitude', '$location')";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the map page after successful addition
        header('Location: police_map_deployment.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<div class="content">
    <h2>Add Police Deployment</h2>

    <!-- Form to add new police deployment -->
    <form method="POST" action="add_policeman_deployment.php">
    <!-- Input fields for officer details -->
    <input type="text" name="officer_name" placeholder="Officer Name" required>
    <input type="text" name="latitude" placeholder="Latitude" required>
    <input type="text" name="longitude" placeholder="Longitude" required>
    <input type="text" name="location" placeholder="Location" required>
    <button type="submit">Add Policeman</button>
</form>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    .content {
        margin-left: 15px;
        padding: 20px;
    }

    h2 {
        color: #003662;
        font-size: 24px;
        margin-bottom: 20px;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        margin: 5px 0;
    }

    input {
        width: 100%;
        padding: 8px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-submit {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #45a049;
    }
</style>
