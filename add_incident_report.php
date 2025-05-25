<?php
include 'includes/db_connection.php';
include 'includes/user_sidebar.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs and sanitize them
    $region = $conn->real_escape_string($_POST['region']);
    $province = $conn->real_escape_string($_POST['province']);
    $municipal = $conn->real_escape_string($_POST['municipal']);
    $barangay = $conn->real_escape_string($_POST['barangay']);
    $dateCommitted = $conn->real_escape_string($_POST['dateCommitted']);
    $timeCommitted = $conn->real_escape_string($_POST['timeCommitted']);
    $stageoffelony = $conn->real_escape_string($_POST['stageoffelony']);
    $offense = $conn->real_escape_string($_POST['offense']);
    $offenseType = $conn->real_escape_string($_POST['offenseType']);

    // SQL query to insert the new incident report
    $sql = "INSERT INTO incident_reports 
        (region, province, municipal, barangay, dateCommitted, timeCommitted, stageoffelony, offense, offenseType) 
        VALUES 
        ('$region', '$province', '$municipal', '$barangay', '$dateCommitted', '$timeCommitted', '$stageoffelony', '$offense', '$offenseType')";

    if ($conn->query($sql) === TRUE) {
        $message = "Incident report added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<?php include 'includes/header.php'; ?>

<div class="content">
    <h2>Add Incident Report</h2>

    <!-- Display the success or error message -->
    <?php if (!empty($message)) : ?>
        <div style="color: <?php echo ($conn->error) ? 'red' : 'green'; ?>; text-align: center; margin-bottom: 15px;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Form for adding new incident report -->
    <form action="" method="POST">
        <input type="text" name="region" placeholder="Region" required>
        <input type="text" name="province" placeholder="Province" required>
        <input type="text" name="municipal" placeholder="Municipal" required>
        <input type="text" name="barangay" placeholder="Barangay" required>
        <input type="date" name="dateCommitted" required>
        <input type="time" name="timeCommitted" required>
        <input type="text" name="stageoffelony" placeholder="Stage of Felony" required>
        <input type="text" name="offense" placeholder="Offense" required>
        <input type="text" name="offenseType" placeholder="Offense Type" required>
        <button type="submit">Add Incident Report</button>
    </form>

    <a href="incident_reports.php" class="btn-cancel">Cancel</a>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }

    .content {
        padding: 20px;
        margin-left: 270px;
        min-height: 100vh;
        background-color: white;
        transition: margin-left 0.3s;
    }

    h2 {
        color: #8B0000;
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }

    form input {
        width: 80%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1em;
    }

    button, .btn-cancel {
        background-color: #003662;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        font-size: 1em;
        transition: background-color 0.3s;
    }

    button:hover, .btn-cancel:hover {
        background-color: #6A5ACD;
    }

    /* Mobile-first Design */
    @media (max-width: 768px) {
        .content {
            margin-left: 0;
            padding: 15px;
        }

        h2 {
            font-size: 1.8em;
        }

        form input, button, .btn-cancel {
            width: 100%;
            padding: 10px;
        }

        button {
            font-size: 1.1em;
        }
    }

    /* Mobile Design */
    @media (max-width: 480px) {
        h2 {
            font-size: 1.6em;
        }

        form input, button, .btn-cancel {
            padding: 8px;
        }
    }
</style>