<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>

<div class="content">
    <h2>Dashboard</h2>
    
    <div class="dashboard-cards">
        <!-- Total Incident Reports -->
        <div class="card">
            <h3>Total Incident Reports</h3>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total FROM incident_reports");
                $row = $result->fetch_assoc();
                echo $row['total'];
                ?>
            </p>
        </div>

        <!-- Total Crime Incidents -->
        <div class="card">
            <h3>Total Crime Incidents</h3>
            <p>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS total FROM police_reports");  // Assuming you're still tracking police reports
                $row = $result->fetch_assoc();
                echo $row['total'];
                ?>
            </p>
        </div>

        <!-- Total Reports (Incident + Crime) -->
        <div class="card">
            <h3>Total Reports</h3>
            <p>
                <?php
                $result = $conn->query("SELECT 
                    (SELECT COUNT(*) FROM police_reports) + 
                    (SELECT COUNT(*) FROM incident_reports) AS total_reports
                ");
                $row = $result->fetch_assoc();
                echo $row['total_reports'];
                ?>
            </p>
        </div>

        <!-- Crime Statistics Overview (Trend) -->
        <div class="card">
            <h3>Recent Crime Statistics</h3>
            <p>
                <?php
                // Query to get the most common offenses from recent incident reports
                $result = $conn->query("SELECT offense, COUNT(*) AS total FROM incident_reports GROUP BY offense ORDER BY total DESC LIMIT 3");
                while ($row = $result->fetch_assoc()) {
                    echo "{$row['offense']}: {$row['total']} cases<br>";
                }
                ?>
            </p>
        </div>

        <!-- Daily Crime Prediction -->
        <div class="card">
            <h3>Daily Crime Prediction</h3>
            <p>
                <?php
                // Fetch daily crime prediction data from incident_predictions table
                $prediction = "Here are the crime predictions for today based on historical data:<br>";
                $sql = "SELECT offense, COUNT(*) AS predicted_count 
                        FROM incident_predictions 
                        WHERE dateCommitted = CURDATE()
                        GROUP BY offense 
                        ORDER BY predicted_count DESC 
                        LIMIT 3";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $prediction .= "{$row['offense']}: Predicted {$row['predicted_count']} cases<br>";
                    }
                } else {
                    $prediction .= "No predictions available for today.";
                }
                echo $prediction;
                ?>
            </p>
        </div>

        <!-- User List -->
        <div class="card">
            <h3>User List</h3>
            <p>
                <?php
                $result = $conn->query("SELECT username FROM users"); // assuming your table is called 'users'
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "{$row['username']}<br>";
                    }
                } else {
                    echo "No users found";
                }
                ?>
            </p>
        </div>
    </div>

    <h2>Recent Incident Reports</h2>
    <!-- Link to View All Reports -->
    <a href="incident_reports.php" style="color: #003662; text-decoration: none;">View all incident reports</a>

    <table>
        <thead>
            <tr>
                <th>Region</th>
                <th>Province</th>
                <th>Municipal</th>
                <th>Barangay</th>
                <th>Date Committed</th>
                <th>Time Committed</th>
                <th>Stage of Felony</th>
                <th>Offense</th>
                <th>Offense Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display recent incident reports
            $sql = "SELECT region, province, municipal, barangay, dateCommitted, timeCommitted, stageoffelony, offense, offenseType FROM incident_reports ORDER BY dateCommitted DESC LIMIT 5";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Format the date and time to make it more readable
                    $formattedDate = date("F j, Y", strtotime($row['dateCommitted']));
                    $formattedTime = date("g:i A", strtotime($row['timeCommitted']));
                    echo "<tr>
                        <td>{$row['region']}</td>
                        <td>{$row['province']}</td>
                        <td>{$row['municipal']}</td>
                        <td>{$row['barangay']}</td>
                        <td>{$formattedDate}</td>
                        <td>{$formattedTime}</td>
                        <td>{$row['stageoffelony']}</td>
                        <td>{$row['offense']}</td>
                        <td>{$row['offenseType']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No recent incident reports found</td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>

<?php include 'includes/footer.php'; ?>

<style>
    h2 {
        color: #8B0000;
    }
    
    .content {
        top: 0%;
        margin-left: 10px;
        padding: 20px;
    }

    .dashboard-cards {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card {
        background-color: #003662;
        color: white;
        padding: 20px;
        border-radius: 8px;
        width: 30%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
    }

    .card h3 {
        margin: 0 0 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-cards {
            flex-direction: column;
        }

        .card {
            width: 100%;
        }

        .content {
            margin-left: 0;
            padding: 10px;
        }
    }

    @media (max-width: 480px) {
        h2 {
            font-size: 1.5em;
        }

        .card h3 {
            font-size: 1.2em;
        }

        th, td {
            font-size: 0.9em;
            padding: 8px;
        }
    }
</style>
