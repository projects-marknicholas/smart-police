<?php
include 'includes/header.php'; 
include 'includes/sidebar.php'; 
include 'includes/db_connection.php';

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the police deployment data based on the provided ID
    $sql = "SELECT * FROM police_deployment WHERE id = $id";
    $result = $conn->query($sql);
    
    // If data found, fetch it
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit;
    }
} else {
    echo "ID not specified.";
    exit;
}
?>

<div class="content">
    <h2>Edit Police Deployment</h2>

    <!-- Form for editing the police deployment data -->
    <form action="update_police_deployment.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="officer_name">Officer Name:</label>
        <input type="text" name="officer_name" value="<?php echo $row['officer_name']; ?>" required><br>

        <label for="latitude">Latitude:</label>
        <input type="text" name="latitude" value="<?php echo $row['latitude']; ?>" required><br>

        <label for="longitude">Longitude:</label>
        <input type="text" name="longitude" value="<?php echo $row['longitude']; ?>" required><br>

        <label for="location">Location:</label>
        <input type="text" name="location" value="<?php echo $row['location']; ?>" required><br>

        <button type="submit" class="btn-submit">Update Deployment</button>
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
