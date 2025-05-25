<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>

<div class="content">
    <h2>Crime Prediction</h2>

    <?php
    // Query to get incident report data for prediction, including location and time
    $sql = "
        SELECT incident_type AS offense, COUNT(*) as offense_count, 
               YEAR(incident_date) as year, 
               MONTH(incident_date) as month, 
               DAY(incident_date) as day, 
               TIME(incident_date) as time_of_incident, 
               location
        FROM incident_reports 
        GROUP BY offense, year, month, day, location 
        ORDER BY year DESC, month DESC, day DESC";
    $result = $conn->query($sql);

    // Initialize arrays for prediction
    $crime_data = [];
    $years = [];
    
    if ($result->num_rows > 0) {
        // Fetch data and organize for prediction
        while ($row = $result->fetch_assoc()) {
            $offense = $row['offense'];
            $offense_count = $row['offense_count'];
            $year = $row['year'];
            $month = $row['month'];
            $day = $row['day'];
            $time_of_incident = $row['time_of_incident'];
            $location = $row['location'];

            // Store data for graph plotting or further analysis
            if (!isset($crime_data[$offense])) {
                $crime_data[$offense] = [];
            }
            if (!isset($crime_data[$offense][$year])) {
                $crime_data[$offense][$year] = [];
            }
            if (!isset($crime_data[$offense][$year][$month])) {
                $crime_data[$offense][$year][$month] = [];
            }

            $crime_data[$offense][$year][$month][] = [
                'count' => $offense_count,
                'day' => $day,
                'time' => $time_of_incident,
                'location' => $location
            ];
            if (!in_array($year, $years)) {
                $years[] = $year;
            }
        }
    } else {
        echo "<p>No data available for prediction.</p>";
    }

    // Sort years in ascending order
    sort($years);
    ?>

    <!-- Prediction logic -->
    <h3>Crime Trend Prediction</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Offense</th>
                    <?php foreach ($years as $year): ?>
                        <th><?php echo $year; ?></th>
                    <?php endforeach; ?>
                    <th>Prediction (Next Incident)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through offenses to predict future trends
                foreach ($crime_data as $offense => $data) {
                    echo "<tr>";
                    echo "<td>$offense</td>";

                    // Display past data with checks for existence
                    foreach ($years as $year) {
                        $year_total = 0;
                        
                        if (isset($data[$year])) {
                            foreach ($data[$year] as $month => $incidents) {
                                foreach ($incidents as $incident) {
                                    $year_total += $incident['count'];
                                }
                            }
                        }
                        
                        echo "<td>$year_total</td>";
                    }

                    // Adjust prediction logic to show the most recent valid data
                    $last_year = end($years);
                    $last_month_data = $data[$last_year] ?? [];
                    $predicted_day = 'N/A';
                    $predicted_time = 'N/A';
                    $predicted_location = 'Unknown';

                    // Find the latest incident data if available
                    if (!empty($last_month_data)) {
                        $last_incident = end($last_month_data);
                        $predicted_day = $last_incident['day'] ?? 'N/A';
                        $predicted_time = $last_incident['time'] ?? 'N/A';
                        $predicted_location = $last_incident['location'] ?? 'Unknown';
                    }

                    // Display prediction with details
                    echo "<td>Day: $predicted_day, Time: $predicted_time, Location: $predicted_location</td>";

                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Add styling for the table -->
<style>
    .content {
        margin-left: 270px;
        padding: 20px;
    }

    h2 {
        color: #8B0000;
    }

    .table-responsive {
        overflow-x: auto; /* Enables horizontal scrolling on smaller screens */
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
</style>
