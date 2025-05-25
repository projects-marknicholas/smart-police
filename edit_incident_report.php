<?php
include 'includes/db_connection.php';

// Validate and sanitize the ID parameter
if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    die("Invalid ID provided.");
}

$id = intval($_GET['id']);

// Fetch the incident report
$sql = "SELECT * FROM incident_reports WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$report = $result->fetch_assoc();

if (!$report) {
    die("Incident report not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize POST data
    $region = trim($_POST['region']);
    $province = trim($_POST['province']);
    $municipal = trim($_POST['municipal']);
    $barangay = trim($_POST['barangay']);
    $dateCommitted = $_POST['dateCommitted'];
    $timeCommitted = $_POST['timeCommitted'];
    $stageOfFelony = trim($_POST['stageoffelony']);
    $offense = trim($_POST['offense']);
    $offenseType = trim($_POST['offenseType']);

    // Validate all required fields
    if (
        empty($region) || empty($province) || empty($municipal) || empty($barangay) ||
        empty($dateCommitted) || empty($timeCommitted) || empty($stageOfFelony) ||
        empty($offense) || empty($offenseType)
    ) {
        echo "All fields are required.";
    } else {
        // Update the incident report
        $sql = "UPDATE incident_reports 
                SET region = ?, province = ?, municipal = ?, barangay = ?, 
                    dateCommitted = ?, timeCommitted = ?, stageoffelony = ?, 
                    offense = ?, offenseType = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssi",
            $region, $province, $municipal, $barangay, $dateCommitted,
            $timeCommitted, $stageOfFelony, $offense, $offenseType, $id
        );

        if ($stmt->execute()) {
            header("Location: incident_reports.php");
            exit;
        } else {
            echo "Error updating report: " . $conn->error;
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content">
    <h2>Edit Incident Report</h2>
    
    <div class="form-container">
        <form action="edit_incident_report.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            <div class="form-group">
                <label for="region">Region</label>
                <input type="text" id="region" name="region" value="<?php echo htmlspecialchars($report['region']); ?>" required>
            </div>

            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($report['province']); ?>" required>
            </div>

            <div class="form-group">
                <label for="municipal">Municipal</label>
                <input type="text" id="municipal" name="municipal" value="<?php echo htmlspecialchars($report['municipal']); ?>" required>
            </div>

            <div class="form-group">
                <label for="barangay">Barangay</label>
                <input type="text" id="barangay" name="barangay" value="<?php echo htmlspecialchars($report['barangay']); ?>" required>
            </div>

            <div class="form-group">
                <label for="dateCommitted">Date Committed</label>
                <input type="date" id="dateCommitted" name="dateCommitted" value="<?php echo htmlspecialchars($report['dateCommitted']); ?>" required>
            </div>

            <div class="form-group">
                <label for="timeCommitted">Time Committed</label>
                <input type="time" id="timeCommitted" name="timeCommitted" value="<?php echo htmlspecialchars($report['timeCommitted']); ?>" required>
            </div>

            <div class="form-group">
                <label for="stageoffelony">Stage of Felony</label>
                <input type="text" id="stageoffelony" name="stageoffelony" value="<?php echo htmlspecialchars($report['stageoffelony']); ?>" required>
            </div>

            <div class="form-group">
                <label for="offense">Offense</label>
                <input type="text" id="offense" name="offense" value="<?php echo htmlspecialchars($report['offense']); ?>" required>
            </div>

            <div class="form-group">
                <label for="offenseType">Offense Type</label>
                <input type="text" id="offenseType" name="offenseType" value="<?php echo htmlspecialchars($report['offenseType']); ?>" required>
            </div>

            <button type="submit" class="btn-update">Update Incident Report</button>
        </form>
        <a href="incident_reports.php" class="btn-cancel">Cancel</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
/* Styles remain unchanged */
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
