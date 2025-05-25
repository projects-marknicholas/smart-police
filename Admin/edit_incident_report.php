<?php
include 'includes/db_connection.php';

$id = $_GET['id'];
$sql = "SELECT * FROM incident_reports WHERE id = $id";
$result = $conn->query($sql);
$report = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $incident_type = $_POST['incident_type'];
    $incident_date = $_POST['incident_date'];
    $incident_time = $_POST['incident_time'];

    $sql = "UPDATE incident_reports SET 
            location = '$location', 
            incident_type = '$incident_type', 
            incident_date = '$incident_date', 
            incident_time = '$incident_time' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: incident_reports.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content">
    <h2>Edit Incident Report</h2>
    
    <div class="form-container">
        <form action="edit_incident_report.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo $report['location']; ?>" required>
            </div>

            <div class="form-group">
                <label for="incident_type">Incident Type</label>
                <input type="text" id="incident_type" name="incident_type" value="<?php echo $report['incident_type']; ?>" required>
            </div>

            <div class="form-group">
                <label for="incident_date">Incident Date</label>
                <input type="date" id="incident_date" name="incident_date" value="<?php echo $report['incident_date']; ?>" required>
            </div>

            <div class="form-group">
                <label for="incident_time">Incident Time</label>
                <input type="time" id="incident_time" name="incident_time" value="<?php echo date('H:i', strtotime($report['incident_time'])); ?>" required>
            </div>

            <button type="submit" class="btn-update">Update Incident Report</button>
        </form>
        <a href="incident_reports.php" class="btn-cancel">Cancel</a>
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

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-update, .btn-cancel {
        background-color: #003662;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
        text-align: center;
        margin-top: 10px;
        display: inline-block;
        text-decoration: none;
    }

    .btn-update:hover, .btn-cancel:hover {
        background-color: #6A5ACD;
    }

    .btn-cancel {
        background-color: #dc143c;
    }

    .btn-cancel:hover {
        background-color: #ff6347;
    }
</style>
