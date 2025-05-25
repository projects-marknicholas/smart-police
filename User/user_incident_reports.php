<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>

<div class="content">
    <h2>Incident Reports</h2>
    
    <button id="openModal" class="btn-add">Add Incident Report</button>

    <!-- Modal for adding new incident report -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>Add New Incident Report</h3>
            </div>
            <div class="modal-body">
                <form action="add_incident_report.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="location">Exact Location</label>
                        <input type="text" name="location" placeholder="Exact Location" required>
                    </div>
                    <div class="form-group">
                        <label for="incident_type">Incident Type</label>
                        <input type="text" name="incident_type" placeholder="Incident Type" required>
                    </div>
                    <div class="form-group">
                        <label for="incident_date">Date</label>
                        <input type="date" name="incident_date" required>
                    </div>
                    <div class="form-group">
                        <label for="incident_time">Time</label>
                        <input type="time" name="incident_time" required>
                    </div>
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" placeholder="Latitude" required>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" placeholder="Longitude" required>
                    </div>
                    <button type="submit" class="btn-submit">Add Incident Report</button>
                </form>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Location</th>
                <th>Incident Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == 'deleted') {
                    echo "<p class='success-msg'>Incident report deleted successfully.</p>";
                } elseif ($_GET['msg'] == 'error') {
                    echo "<p class='error-msg'>Error deleting incident report. Please try again.</p>";
                }
            }

            $sql = "SELECT * FROM incident_reports";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['location']}</td>
                        <td>{$row['incident_type']}</td>
                        <td>{$row['incident_date']}</td>
                        <td>" . date('g:i A', strtotime($row['incident_time'])) . "</td>
                        <td>{$row['latitude']}</td>
                        <td>{$row['longitude']}</td>
                        <td>
                            <a href='edit_incident_report.php?id={$row['id']}' class='btn-edit'>Edit</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No incident reports found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    .content {
        margin-left: 270px;
        padding: 20px;
    }

    h2 {
        color: #8B0000;
    }

    .btn-add {
        background-color: #003662;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
        transition: background-color 0.3s;
    }

    .btn-add:hover {
        background-color: #6A5ACD;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 0;
        border: 1px solid #888;
        width: 40%;
        border-radius: 8px;
        overflow: hidden;
    }

    .modal-header {
        padding: 10px 20px;
        background-color: #003662;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-submit {
        background-color: #003662;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #6A5ACD;
    }

    .close {
        color: white;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #003662;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    .btn-edit {
        background-color: #ffa500;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-edit:hover {
        background-color: #ff4500;
    }

    /* Custom message styles */
    .success-msg {
        color: green;
        font-size: 1.2em;
        margin-top: 10px;
    }

    .error-msg {
        color: red;
        font-size: 1.2em;
        margin-top: 10px;
    }
</style>

<script>
    // Get the modal
    var modal = document.getElementById("addModal");

    // Get the button that opens the modal
    var btn = document.getElementById("openModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
