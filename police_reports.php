<?php 
include 'includes/header.php'; 
include 'includes/sidebar.php'; 
include 'includes/db_connection.php'; 
?>

<div class="content">
    <h2>Police Reports</h2>

    <!-- Button to trigger the modal for viewing yearly report -->
    <button id="openYearlyReport" class="btn-yearly">Yearly Report</button>

    <!-- Modal for selecting the year -->
    <div id="yearModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Select Year</h3>
            <select id="yearSelect" class="year-dropdown">
                <?php
                $currentYear = date("Y");
                for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <button id="filterYear" class="btn-filter">Filter</button>
        </div>
    </div>

    <!-- Table for displaying the police reports -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Address</th>
                <th>Offense</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="reportTableBody">
            <?php
            $year = isset($_GET['year']) ? $_GET['year'] : date("Y");
            $sql = "SELECT * FROM police_reports WHERE YEAR(date_of_case) = $year";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['offense']}</td>
                        <td>{$row['date_of_case']}</td>
                        <td>
                            <a href='edit_police_report.php?id={$row['id']}' class='btn-edit'>Edit</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No reports found for $year</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    /* Basic Layout */
    .content {
        margin-left: 15px;
        padding: 20px;
    }

    h2 {
        color: #003662;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* Button Design */
    .btn-yearly, .btn-filter {
        background-color: #003662;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .btn-yearly:hover, .btn-filter:hover {
        background-color: #6A5ACD;
        transform: translateY(-2px);
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #003662;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .btn-edit {
        background-color: #ffa500;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .btn-edit:hover {
        background-color: #ff4500;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        transition: opacity 0.3s;
    }

    .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 30px;
        width: 90%;
        max-width: 400px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .close {
        color: #333;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #888;
    }

    .year-dropdown {
        width: 100%;
        padding: 10px;
        margin: 15px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content {
            margin-left: 0;
            padding: 10px;
        }

        table {
            font-size: 14px;
        }

        h2 {
            font-size: 20px;
        }
    }
</style>

<script>
    // Modal handling
    var yearModal = document.getElementById("yearModal");
    var btnYearly = document.getElementById("openYearlyReport");
    var closeModal = document.getElementsByClassName("close")[0];
    var filterYearBtn = document.getElementById("filterYear");

    btnYearly.onclick = function() {
        yearModal.style.display = "block";
    }

    closeModal.onclick = function() {
        yearModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == yearModal) {
            yearModal.style.display = "none";
        }
    }

    filterYearBtn.onclick = function() {
        var selectedYear = document.getElementById("yearSelect").value;
        window.location.href = "?year=" + selectedYear;
    }
</script>
