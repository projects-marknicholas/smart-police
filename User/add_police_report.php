<?php
// Include database connection file
include 'includes/db_connection.php';



// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $offense = mysqli_real_escape_string($conn, $_POST['offense']);
    $date_of_case = mysqli_real_escape_string($conn, $_POST['date_of_case']);

    // SQL query to insert data into police_reports table
    $sql = "INSERT INTO police_reports (name, age, address, offense, date_of_case) 
            VALUES ('$name', '$age', '$address', '$offense', '$date_of_case')";

    // Check if the query executed successfully
    if ($conn->query($sql) === TRUE) {
        // Redirect back to police_reports.php with success message
        header("Location: police_reports.php?message=Report added successfully");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content">
    <h2>Add Police Report</h2>

    <div class="form-container">
        <form action="add_police_report.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" required>
            </div>

        


            <div class="form-group">
                <label for="offense">Offense</label>
                <input type="text" id="offense" name="offense" required>
            </div>

            <div class="form-group">
                <label for="date_of_case">Date of Case</label>
                <input type="date" id="date_of_case" name="date_of_case" required>
            </div>

            <button type="submit">Add Police Report</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    .content {
        margin-left: 270px;
        padding: 20px;
    }

    h2 {
        color: #003662;
    }

    .form-container {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        max-width: 500px;
        margin: 0 auto;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        color: #333;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input, .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #003662;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }

    button:hover {
        background-color: #6A5ACD;
    }
    .form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #ffffff;
    appearance: none; /* Remove default arrow */
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23003662" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center; /* Position the arrow */
    background-size: 12px; /* Adjust the size of the arrow */
}

</style>
