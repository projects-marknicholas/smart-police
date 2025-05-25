<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>

<div class="content">
    <h2>Edit Police Report</h2>

    <?php
    // Retrieve the ID from the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the existing report data
        $sql = "SELECT * FROM police_reports WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "<p>No report found.</p>";
            exit;
        }
    } else {
        echo "<p>Invalid request.</p>";
        exit;
    }
    ?>

    <div class="form-container">
        <form action="update_police_report.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required>
            </div>

            <div class="form-group">
                <label for="offense">Offense</label>
                <input type="text" id="offense" name="offense" value="<?php echo $row['offense']; ?>" required>
            </div>

            <div class="form-group">
                <label for="date_of_case">Date of Case</label>
                <input type="date" id="date_of_case" name="date_of_case" value="<?php echo $row['date_of_case']; ?>" required>
            </div>

            <button type="submit" class="btn-update">Update Report</button>
            <a href="police_reports.php" class="btn-cancel">Cancel</a>
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

    .btn-update:hover {
        background-color: #6A5ACD;
    }

    .btn-cancel {
        background-color: #dc143c;
    }

    .btn-cancel:hover {
        background-color: #ff6347;
    }
</style>
