<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/db_connection.php'; ?>

<div class="content">
    <h2 class="page-title">Crime Prediction Using Historical Frequency Analysis</h2>

    <?php
    // Fetch incident prediction data for historical analysis
    $sql = "
        SELECT region, province, municipal, barangay, 
            DATE(dateCommitted) AS date_committed, 
            TIME(timeCommitted) AS time_committed, 
            stageoffelony, offense, offenseType
        FROM incident_predictions
        ORDER BY date_committed DESC, time_committed DESC";

    $result = $conn->query($sql);

    // Initialize data storage
    $historical_data = [];
    $daily_totals = [];
    $hourly_totals = [];
    $location_totals = [];
    $offense_totals = [];
    $location_coords = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $region = $row['region'];
            $province = $row['province'];
            $municipal = $row['municipal'];
            $barangay = $row['barangay'];
            $date_committed = $row['date_committed'];
            $time_committed = $row['time_committed'];
            $stageoffelony = $row['stageoffelony'];
            $offense = $row['offense'];
            $offenseType = $row['offenseType'];

            // Store incident prediction data for analysis
            $historical_data[] = [
                'region' => $region,
                'province' => $province,
                'municipal' => $municipal,
                'barangay' => $barangay,
                'date_committed' => $date_committed,
                'time_committed' => $time_committed,
                'stageoffelony' => $stageoffelony,
                'offense' => $offense,
                'offenseType' => $offenseType
            ];

            // Aggregate totals for historical frequency analysis
            $daily_totals[$date_committed] = ($daily_totals[$date_committed] ?? 0) + 1;
            $hourly_totals[$time_committed] = ($hourly_totals[$time_committed] ?? 0) + 1;
            $location_totals[$barangay] = ($location_totals[$barangay] ?? 0) + 1;
            $offense_totals[$offense] = ($offense_totals[$offense] ?? 0) + 1;

            // Store coordinates for location
            $location_coords[$barangay] = [
                'region' => $region,
                'province' => $province,
                'municipal' => $municipal
            ];
        }
    } else {
        echo "<p>No data available for prediction.</p>";
    }

    // Analyze Historical Data
    $predicted_date = array_key_exists(date('Y-m-d'), $daily_totals) 
        ? date('Y-m-d', strtotime('tomorrow')) 
        : date('Y-m-d'); // Predict tomorrow if today is inactive
    $predicted_time = $hourly_totals ? array_search(max($hourly_totals), $hourly_totals) : 'Unknown';
    $predicted_location = $location_totals ? array_search(max($location_totals), $location_totals) : 'Unknown';
    $predicted_offense = $offense_totals ? array_search(max($offense_totals), $offense_totals) : 'Unknown';

    // Get location details for the predicted location
    $predicted_region = $location_coords[$predicted_location]['region'] ?? 'Unknown';
    $predicted_province = $location_coords[$predicted_location]['province'] ?? 'Unknown';
    $predicted_municipal = $location_coords[$predicted_location]['municipal'] ?? 'Unknown';
    ?>

    <!-- Display Prediction Results -->
    <h3>Crime Prediction Summary</h3>
    <div class="prediction-summary">
        <div class="prediction-card">
            <strong>Predicted Date:</strong> <span><?php echo $predicted_date; ?></span>
        </div>
        <div class="prediction-card">
            <strong>Predicted Time:</strong> <span><?php echo $predicted_time; ?></span>
        </div>
        <div class="prediction-card">
            <strong>Predicted Location:</strong> <span><?php echo $predicted_location; ?></span>
        </div>
        <div class="prediction-card">
            <strong>Predicted Offense:</strong> <span><?php echo $predicted_offense; ?></span>
        </div>
        <div class="prediction-card">
            <strong>Region:</strong> <span><?php echo $predicted_region; ?></span>
        </div>
        <div class="prediction-card">
            <strong>Province:</strong> <span><?php echo $predicted_province; ?></span>
        </div>
        <div class="prediction-card">
            <strong>Municipality:</strong> <span><?php echo $predicted_municipal; ?></span>
        </div>
    </div>

    <!-- Incident Data Table -->
    <h3>Incident Prediction Data</h3>
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Region</th>
                    <th>Province</th>
                    <th>Municipality</th>
                    <th>Barangay</th>
                    <th>Date Committed</th>
                    <th>Time Committed</th>
                    <th>Stage of Felony</th>
                    <th>Offense</th>
                    <th>Offense Type</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historical_data)): ?>
                    <?php foreach ($historical_data as $incident): ?>
                        <tr>
                            <td><?php echo $incident['region']; ?></td>
                            <td><?php echo $incident['province']; ?></td>
                            <td><?php echo $incident['municipal']; ?></td>
                            <td><?php echo $incident['barangay']; ?></td>
                            <td><?php echo $incident['date_committed']; ?></td>
                            <td><?php echo $incident['time_committed']; ?></td>
                            <td><?php echo $incident['stageoffelony']; ?></td>
                            <td><?php echo $incident['offense']; ?></td>
                            <td><?php echo $incident['offenseType']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<style>
    /* Main container */
    .content {
        margin-left: 10px;
    padding: 20px;
    }

    /* Title styling */
    .page-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #003366;
    }

    /* Prediction summary layout */
    .prediction-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
        justify-content: space-between;
    }

    /* Individual prediction cards */
    .prediction-card {
        background-color: #003662;
        color: white;
        padding: 20px;
        border-radius: 8px;
        flex: 1 1 calc(33% - 20px);
        text-align: center;
        box-sizing: border-box;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Make the span bold */
    .prediction-card span {
        font-weight: bold;
    }

    /* Table styling */
    .table-responsive {
        margin-top: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    .table th, .table td {
        text-align: center;
    }

    .table-dark {
        background-color: #003662;
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .prediction-card {
            flex: 1 1 48%; /* Adjust to 2 cards per row */
        }

        .table th, .table td {
            font-size: 14px;
        }

        .page-title {
            font-size: 1.75rem; /* Adjust page title size */
        }
    }

    @media (max-width: 576px) {
        .prediction-card {
            flex: 1 1 100%; /* Adjust to 1 card per row */
        }

        .page-title {
            font-size: 1.5rem;
        }

        .table th, .table td {
            font-size: 12px;
        }
    }
</style>
